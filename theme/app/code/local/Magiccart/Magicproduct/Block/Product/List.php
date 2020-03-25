<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2015-03-16 09:41:08
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Block_Product_List extends Mage_Catalog_Block_Product_List
{

    protected $_productCollection;

    public function isRootCategoryFilterMode()
    {
        if(!$this->isSingleCateogryMode()) return Mage::app()->getStore()->getRootCategoryId();
    }

    public function isSingleCateogryMode(){
        $groups = Mage::app()->getGroups();
        if(count($groups) ==1) return true;
        $CatIds = array();
        foreach ($groups as $group) {
            $CatIds[] = $group->getRootCategoryId();
        }
        $average = array_sum($CatIds) / count($CatIds);
        if($average == $CatIds[0]) return true;
        return false;
    }

    public function categoryFilter($collection)
    {
        $cfg = true; // get from config or Widget
        if($cfg){
            $catId = (int) $this->getRequest()->getPost('category_id');
            if(!$catId) {$catId = Mage::registry('current_category');}
            if($catId){
                $Category = Mage::getModel('catalog/category')->load($catId);
                $collection->addCategoryFilter($Category); // not use RootCatId
            }else {
                $catId = $this->isRootCategoryFilterMode();
                if($catId){
                    $category = Mage::getModel('catalog/category')->load($catId);
                    // $catIds = explode(',',$category->getChildren());
                    $catIds = explode(',',$category->getAllChildren()); // incluce itself
                    $collection->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
                               ->addAttributeToFilter('category_id', array('in' => $catIds))
                               ->groupByAttribute('entity_id');    //->getSelect()->group('e.entity_id');   

                    $attributes = Mage::getSingleton('catalog/config')->getProductAttributes();                   
                    $collection = Mage::getModel('catalog/product') // fix lost size in List
                            ->getCollection() 
                            ->addAttributeToSelect($attributes)              
                            ->addAttributeToFilter('entity_id', array('in' => $collection->getAllIds()))
                            ->setOrder($this->getRequest()->getParam('order'), $this->getRequest()->getParam('dir'));
                    $limit = (int)$this->getRequest()->getParam('limit') ? (int)$this->getRequest()->getParam('limit') : (int)$this->getToolbarBlock()->getDefaultPerPageValue();
                    $collection->setPageSize($limit)->setCurPage($this->getRequest()->getParam('p')); 
                }

            }
        }
        return $collection;
    }

    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $type = $this->getRequest()->getParam('type');
            $collection = null;
            switch ($type) {
              case 'bestseller':
                $collection = $this->getBestsellerProducts();
                break;
              case 'featured':
                $collection = $this->getFeaturedProducts();
                break;
              case 'latest':
                $collection = $this->getLatestProducts();
                break;
              case 'mostviewed':
                $collection = $this->getMostviewedProducts();
                break;
              case 'newproduct':
                $collection = $this->getNewProducts();
                break;
              case 'saleproduct':
                $collection = $this->getSaleProducts();
                break;
              default:
                $collection = $this->getFeaturedProducts();
                break;
            }
            $this->_productCollection = $collection;
        }
        return $this->_productCollection;
    }


    public function getBestsellerProducts(){

        // set Store
        $storeIds = Mage::app()->getGroup()->getStoreIds(); // filter follow store;
        //$storeIds  = $this->getStoreId(); // filter follow store view
        $storeId = implode(',', $storeIds);

        // set Time
        $timePeriod = ($this->getTimePeriod()) ? $this->getTimePeriod() : 365;
        $date = date('Y-m-d H:i:s');
        $newdate = strtotime ( '-'.$timePeriod.' day' , strtotime ( $date ) ) ;
        $newdate = date ( 'Y-m-j' , $newdate ); 

        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $tablePrefix = Mage::getConfig()->getTablePrefix();

        $sql = "SELECT max(qo) AS des_qty,`product_id`,`parent_item_id`
            FROM ( SELECT sum(`qty_ordered`) AS qo,`product_id`,created_at,store_id,`parent_item_id` FROM {$tablePrefix}sales_flat_order_item GROUP BY `product_id` )
            AS t1 where store_id IN ({$storeId})
            AND parent_item_id is null
            AND created_at between '{$newdate}' AND '{$date}'
            GROUP BY `product_id` ORDER BY des_qty DESC";

        // Note: remove limit if filter follow category

        $rows = $read->fetchAll($sql);
        $producIds = array();
        foreach ($rows as $row) { $producIds[] = $row['product_id'];}
        $collection = Mage::getModel('catalog/product')->getCollection()
                            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())              
                            ->addAttributeToFilter('entity_id', array('in' => $producIds))
                            ->setOrder($this->getRequest()->getParam('order'), $this->getRequest()->getParam('dir'));
        $limit = (int)$this->getRequest()->getParam('limit') ? (int)$this->getRequest()->getParam('limit') : (int)$this->getToolbarBlock()->getDefaultPerPageValue();
        $collection->setPageSize($limit)->setCurPage($this->getRequest()->getParam('p'));
        return $collection;
    }

    public function getFeaturedProducts(){
        $featured   = Magiccart_Magicproduct_Helper_Data::FEATURED;
        $collection = Mage::getModel('catalog/product')->getCollection()
                            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                            ->addAttributeToFilter($featured, 1, 'left')
                            ->addMinimalPrice()
                            ->addTaxPercents()
                            ->addStoreFilter()
                            ->setOrder($this->getRequest()->getParam('order'), $this->getRequest()->getParam('dir'));
        $limit = (int)$this->getRequest()->getParam('limit') ? (int)$this->getRequest()->getParam('limit') : (int)$this->getToolbarBlock()->getDefaultPerPageValue();
        $collection->setPageSize($limit)->setCurPage($this->getRequest()->getParam('p'));

        // CategoryFilter
        $collection = $this->categoryFilter($collection);

        return $collection; 
    }

    public function getLatestProducts(){

        $collection = Mage::getModel('catalog/product')->getCollection()
                            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                            ->addMinimalPrice()
                            ->addTaxPercents()
                            ->addStoreFilter()
                            ->addAttributeToSort('entity_id', 'desc')
                            ->setOrder($this->getRequest()->getParam('order'), $this->getRequest()->getParam('dir'));
        $limit = (int)$this->getRequest()->getParam('limit') ? (int)$this->getRequest()->getParam('limit') : (int)$this->getToolbarBlock()->getDefaultPerPageValue();
        $collection->setPageSize($limit)->setCurPage($this->getRequest()->getParam('p'));

        // CategoryFilter
        $collection = $this->categoryFilter($collection);

        return $collection; 
    }

    public function getMostviewedProducts(){
     //Magento get popular products by total number of views
        $attributes = Mage::getSingleton('catalog/config')->getProductAttributes();
        $collection = Mage::getResourceModel('reports/product_collection')
                            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                            ->addAttributeToSelect($attributes)
                            ->addViewsCount()
                            ->addMinimalPrice()
                            ->addTaxPercents()
                            ->addStoreFilter()
                            ->setOrder($this->getRequest()->getParam('order'), $this->getRequest()->getParam('dir'));
        $limit = (int)$this->getRequest()->getParam('limit') ? (int)$this->getRequest()->getParam('limit') : (int)$this->getToolbarBlock()->getDefaultPerPageValue();
        $collection->setPageSize($limit)->setCurPage($this->getRequest()->getParam('p')); 

        // CategoryFilter
        $collection = $this->categoryFilter($collection);
        $productFlatHelper = Mage::helper('catalog/product_flat');
        if($productFlatHelper->isEnabled())
        {
            // fix error lost image vs name while Enable useFlatCatalogProduct
            $productIds = array();
            foreach ($collection as $product) 
            {
                $productIds[] = $product->getEntityId();
            }
            $collection = Mage::getModel('catalog/product')
                            ->getCollection() 
                            ->addAttributeToSelect($attributes)              
                            ->addAttributeToFilter('entity_id', array('in' => $productIds));       
        }

        return $collection;
    }

    public function getNewProducts() {

        $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        $collection = Mage::getResourceModel('catalog/product_collection')
                            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                            ->addAttributeToSelect('*') //Need this so products show up correctly in product listing
                            ->addAttributeToFilter('news_from_date', array('or'=> array(
                                0 => array('date' => true, 'to' => $todayDate),
                                1 => array('is' => new Zend_Db_Expr('null')))
                            ), 'left')
                            ->addAttributeToFilter('news_to_date', array('or'=> array(
                                0 => array('date' => true, 'from' => $todayDate),
                                1 => array('is' => new Zend_Db_Expr('null')))
                            ), 'left')
                            ->addAttributeToFilter(
                                array(
                                    array('attribute' => 'news_from_date', 'is'=>new Zend_Db_Expr('not null')),
                                    array('attribute' => 'news_to_date', 'is'=>new Zend_Db_Expr('not null'))
                                    )
                              )
                            ->addAttributeToSort('news_from_date', 'desc')
                            ->addMinimalPrice()
                            ->addTaxPercents()
                            ->addStoreFilter()
                            ->setOrder($this->getRequest()->getParam('order'), $this->getRequest()->getParam('dir'));
        $limit = (int)$this->getRequest()->getParam('limit') ? (int)$this->getRequest()->getParam('limit') : (int)$this->getToolbarBlock()->getDefaultPerPageValue();
        $collection->setPageSize($limit)->setCurPage($this->getRequest()->getParam('p')); 

        // CategoryFilter
        $collection = $this->categoryFilter($collection);

        return $collection;
    }

    public function getSaleProducts() {

        $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        $collection = Mage::getResourceModel('catalog/product_collection')
                            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                            ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                            ->addAttributeToFilter('special_from_date', array('or'=> array(
                                0 => array('date' => true, 'to' => $todayDate),
                                1 => array('is' => new Zend_Db_Expr('null')))
                            ), 'left')
                            ->addAttributeToFilter('special_to_date', array('or'=> array(
                                0 => array('date' => true, 'from' => $todayDate),
                                1 => array('is' => new Zend_Db_Expr('null')))
                            ), 'left')
                            ->addAttributeToFilter(
                                array(
                                    array('attribute' => 'special_from_date', 'is'=>new Zend_Db_Expr('not null')),
                                    array('attribute' => 'special_to_date', 'is'=>new Zend_Db_Expr('not null'))
                                    )
                              )
                            ->addAttributeToSort('special_to_date','desc')
                            ->addTaxPercents()
                            ->addStoreFilter()
                            ->setOrder($this->getRequest()->getParam('order'), $this->getRequest()->getParam('dir'));
        $limit = (int)$this->getRequest()->getParam('limit') ? (int)$this->getRequest()->getParam('limit') : (int)$this->getToolbarBlock()->getDefaultPerPageValue();
        $collection->setPageSize($limit)->setCurPage($this->getRequest()->getParam('p')); 

        // CategoryFilter
        $collection = $this->categoryFilter($collection);

        return $collection;
    }

}

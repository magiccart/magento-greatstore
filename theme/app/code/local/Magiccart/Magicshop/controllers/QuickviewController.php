<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2015-02-09 13:23:59
 * @@Function:
 */
?>
<?php
class Magiccart_Magicshop_QuickviewController extends Mage_Core_Controller_Front_Action
{
    /**
     * Initialize requested product object
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _initProduct()
    {
			
        Mage::dispatchEvent('catalog_controller_product_init_before', array('controller_action'=>$this));
        $categoryId = (int) $this->getRequest()->getParam('category', false);
        $productId  = (int) $this->getRequest()->getParam('id');
		$storeId 	= Mage::app()->getStore()->getId();
		$path  = (string) $this->getRequest()->getParam('path');
		if($path) $path[0] == "\/" ? $path = substr($path, 1, strlen($path)) : $path;
		$tableName = Mage::getSingleton('core/resource')->getTableName('core_url_rewrite'); 
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');

		$query = "select MAIN_TABLE.`product_id` from `{$tableName}` as MAIN_TABLE where MAIN_TABLE.`store_id` = {$storeId} AND MAIN_TABLE.`request_path` in('{$path}')";
		$readresult=$write->query($query);
		if ($row = $readresult->fetch() ) {
			$productId=$row['product_id'];
		}	

        if (!$productId) {
            return false;
        }

        $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productId);

        if (!Mage::helper('catalog/product')->canShow($product)) {
            return false;
        }
        if (!in_array(Mage::app()->getStore()->getWebsiteId(), $product->getWebsiteIds())) {
            return false;
        }

        $category = null;
        if ($categoryId) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            $product->setCategory($category);
            Mage::register('current_category', $category);
        }
        elseif ($categoryId = Mage::getSingleton('catalog/session')->getLastVisitedCategoryId()) {
            if ($product->canBeShowInCategory($categoryId)) {
                $category = Mage::getModel('catalog/category')->load($categoryId);
                $product->setCategory($category);
                Mage::register('current_category', $category);
            }
        }
        Mage::register('current_product', $product);
        Mage::register('product', $product);

        try {
            Mage::dispatchEvent('catalog_controller_product_init', array('product'=>$product));
            Mage::dispatchEvent('catalog_controller_product_init_after', array('product'=>$product, 'controller_action' => $this));
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            return false;
        }

        return $product;
    }

    /**
     * Initialize product view layout
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  Mage_Catalog_ProductController
     */
    protected function _initProductLayout($product)
    {
        $update = $this->getLayout()->getUpdate();
        $update->addHandle('default');
        $this->addActionLayoutHandles();

        $update->addHandle('PRODUCT_TYPE_'.$product->getTypeId());
        $update->addHandle('PRODUCT_'.$product->getId());

        if ($product->getPageLayout()) {
            $this->getLayout()->helper('page/layout')
                ->applyHandle($product->getPageLayout());
        }

        $this->loadLayoutUpdates();


        $update->addUpdate($product->getCustomLayoutUpdate());

        $this->generateLayoutXml()->generateLayoutBlocks();

        if ($product->getPageLayout()) {
            $this->getLayout()->helper('page/layout')
                ->applyTemplate($product->getPageLayout());
        }

        $currentCategory = Mage::registry('current_category');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('product-'.$product->getUrlKey());
            if ($currentCategory instanceof Mage_Catalog_Model_Category) {
                $root->addBodyClass('categorypath-'.$currentCategory->getUrlPath())
                    ->addBodyClass('category-'.$currentCategory->getUrlKey());
            }
        }
        return $this;
    }

    /**
     * View product action
     */
    public function ajaxAction()
    {
    	if ($product = $this->_initProduct()) {
    		Mage::dispatchEvent('catalog_controller_product_view', array('product'=>$product));
    
    		if ($this->getRequest()->getParam('options')) {
    			$notice = $product->getTypeInstance(true)->getSpecifyOptionMessage();
    			Mage::getSingleton('catalog/session')->addNotice($notice);
    		}
    
    		Mage::getSingleton('catalog/session')->setLastViewedProductId($product->getId());
    		Mage::getModel('catalog/design')->applyDesign($product, Mage_Catalog_Model_Design::APPLY_FOR_PRODUCT);
    
    		$this->_initProductLayout($product);
    		$this->_initLayoutMessages('catalog/session');
    		$this->_initLayoutMessages('tag/session');
    		$this->_initLayoutMessages('checkout/session');
    		$this->renderLayout();
    	}
    	else {
    		if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
    			$this->_redirect('');
    		} elseif (!$this->getResponse()->isRedirect()) {
    			$this->_forward('noRoute');
    		}
    	}
    	
    }
    public function viewAction()
    {
		if ($this->getRequest()->isAjax()) {
			if ($product = $this->_initProduct()) {
				Mage::dispatchEvent('catalog_controller_product_view', array('product'=>$product));

				if ($this->getRequest()->getParam('options')) {
					$notice = $product->getTypeInstance(true)->getSpecifyOptionMessage();
					Mage::getSingleton('catalog/session')->addNotice($notice);
				}

				Mage::getSingleton('catalog/session')->setLastViewedProductId($product->getId());
				Mage::getModel('catalog/design')->applyDesign($product, Mage_Catalog_Model_Design::APPLY_FOR_PRODUCT);

				$this->_initProductLayout($product);
				$this->_initLayoutMessages('catalog/session');
				$this->_initLayoutMessages('tag/session');
				$this->_initLayoutMessages('checkout/session');
				$this->renderLayout();
			}else {
				if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
					$this->_redirect('');
				} elseif (!$this->getResponse()->isRedirect()) {
					$this->_forward('noRoute');
				}
			}
		} else {
			Mage::app()->getFrontController()->getResponse()
						->setRedirect(Mage::getUrl('checkout/cart'))
						->sendResponse();
		}
    }
}


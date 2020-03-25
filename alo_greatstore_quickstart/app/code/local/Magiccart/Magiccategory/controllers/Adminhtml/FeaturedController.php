<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2014-08-08 23:43:40
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_Adminhtml_FeaturedController extends Mage_Adminhtml_Controller_Action
{
	
	protected function _initProduct()
    {
        
        $product = Mage::getModel('catalog/product')
            ->setStoreId($this->getRequest()->getParam('store', 0));

    	
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $product->setAttributeSetId($setId);
            }

            if ($typeId = $this->getRequest()->getParam('type')) {
                $product->setTypeId($typeId);
            }
                    
        $product->setData('_edit_mode', true);
        
        Mage::register('product', $product);
       
        return $product;
    }

	
	public function indexAction()
	{
        $this->_initProduct();
        
		$this->loadLayout()->_setActiveMenu('magiccategory/featuredproduct');
			
		$this->_addContent($this->getLayout()->createBlock('magiccategory/adminhtml_edit'));
        
        $this->renderLayout();
	
	}
	
	public function gridAction()
	{
		 
	$this->getResponse()->setBody(
            $this->getLayout()->createBlock('magiccategory/adminhtml_edit_grid')->toHtml()
        );
	
	}
	
	public function saveAction()
	{
		$data = $this->getRequest()->getPost(); 
		$storeId    = $this->getRequest()->getParam('store', 0);
		$featured   = Magiccart_Magiccategory_Helper_Data::FEATURED;
        $collection = Mage::getModel('catalog/product')->getCollection();

        parse_str($data['featured_products'], $featured_products);
		
        $collection->addIdFilter(array_keys($featured_products));
        
		 try {
		 	
			foreach($collection->getItems() as $product)
			{
				
				$product->setData($featured, $featured_products[$product->getEntityId()]);
				$product->setStoreId($storeId);		
		  		$product->save();	
			} 	
		 	
			
		 	$this->_getSession()->addSuccess($this->__('Featured product was successfully saved.'));
			$this->_redirect('*/*/index', array('store'=> $this->getRequest()->getParam('store')));	
		 	
		 }catch (Exception $e){
			$this->_getSession()->addError($e->getMessage());
			$this->_redirect('*/*/index', array('store'=> $this->getRequest()->getParam('store')));
		 }
	
	}
	
	protected function _validateSecretKey()
	{
		return true;
	}

	// protected function _isAllowed()
	// {
	// 	return Mage::getSingleton('admin/session')->isAllowed('admin/catalog/featuredproduct');
	// }
	
}


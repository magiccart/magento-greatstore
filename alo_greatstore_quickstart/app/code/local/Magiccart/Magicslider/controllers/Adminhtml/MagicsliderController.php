<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-05-04 15:19:02
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Adminhtml_MagicsliderController extends Mage_Adminhtml_Controller_Action
{
	const NAVIGATION = 'magiccart/magicslider_items';
	protected function _initAction() 
	{
		$this->loadLayout()
		->_setActiveMenu(self::NAVIGATION)
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Magicslider Manager'));
		
		return $this;
	}   

	public function indexAction() 
	{
		$this->_initAction()
		->renderLayout();
	}

	public function uploadAction()
	{
		try {

				$_helper  = Mage::helper('magicslider');
				$uploader = new Varien_File_Uploader('image');
				$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
				$uploader->addValidateCallback('catalog_product_image',
				Mage::helper('catalog/image'), 'validateUploadFile');
				$uploader->setAllowRenameFiles(true);
				$uploader->setFilesDispersion(true);
				$result = $uploader->save($_helper->getBaseTmpMediaPath());

				Mage::dispatchEvent('catalog_product_gallery_upload_image_after', array(
				'result' => $result,
				'action' => $this
				));

				/**
				* Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
				*/
				$result['tmp_name'] = str_replace(DS, "/", $result['tmp_name']);
				$result['path'] = str_replace(DS, "/", $result['path']);
				$tempUrl = $this->_prepareFileForUrl($result['file']);
				if(substr($tempUrl, 0, 1) == '/') {
	            $tempUrl = substr($tempUrl, 1);
				}
				$result['url'] = $_helper->getBaseTmpMediaUrl() . $tempUrl;
				/* $result['url'] = Mage::getSingleton('catalog/product_media_config')->getTmpMediaUrl($result['file']); */
				
				$result['file'] = $result['file'];
				$result['cookie'] = array(
				'name'     => session_name(),
				'value'    => $this->_getSession()->getSessionId(),
				'lifetime' => $this->_getSession()->getCookieLifetime(),
				'path'     => $this->_getSession()->getCookiePath(),
				'domain'   => $this->_getSession()->getCookieDomain()
				);
			
		} catch (Exception $e) {
			$result = array(
			'error' => $e->getMessage(),
			'errorcode' => $e->getCode());
		}
		
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}
		
	protected function _prepareFileForUrl($file)
    {
        return str_replace(DS, '/', $file);
    }

	public function editAction() 
	{
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('magicslider/magicslider')->load($id);
		$tmp 	= unserialize($model->getConfig());
		$model->addData($tmp);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			//echo '<pre>';			
			//$model->setData('stores',json_decode($model->getData('stores')));
			//print_R($model->getData());exit;
			Mage::register('magicslider_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu(self::NAVIGATION);

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Magicslider Manager'), Mage::helper('adminhtml')->__('Magicslider Manager'));			

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('magicslider/adminhtml_magicslider_edit'))
			->_addLeft($this->getLayout()->createBlock('magicslider/adminhtml_magicslider_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicslider')->__('Magicslider does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() 
	{
		 $this->_title($this->__('New Magicslider'));

		$_model  = Mage::getModel('magicslider/magicslider');
		Mage::register('magicslider_data', $_model);
		Mage::register('current_magicslider', $_model);

		$this->_initAction();
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Magicslider Manager'), Mage::helper('adminhtml')->__('Magicslider Manager'), $this->getUrl('*'));
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Add Magicslider'), Mage::helper('adminhtml')->__('Add Magicslider'));

		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

		$this->_addContent($this->getLayout()->createBlock('magicslider/adminhtml_magicslider_edit'))
		->_addLeft($this->getLayout()->createBlock('magicslider/adminhtml_magicslider_edit_tabs'));

		$this->renderLayout(); 
	}

	public function saveAction() 
	{
		
		if ($data = $this->getRequest()->getPost()) {
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
					
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
					
				}
				
				//this way the name is saved in DB
				$data['filename'] = $_FILES['filename']['name'];
			}
			
			
			$model = Mage::getModel('magicslider/magicslider');	
			if(isset($data['magicslider_tabs']['images']) && !empty($data['magicslider_tabs']['images'])){	
				$images = Mage::helper('core')->jsonDecode($data['magicslider_tabs']['images'],true);
				//$images = json_decode($data['magicslider_tabs']['images'],true);
				$newArray = array();
				foreach($images as $key=>$image){
					if($image['removed']!=1){
						$newArray[] = $image;
					}
				}				
				$content = Mage::helper('core')->jsonEncode($newArray);				
				$data['content'] = $content;
				unset($data['magicslider_tabs']['images']);
			}
			
			if(isset($data['stores']) && !empty($data['stores'])){			
				if(in_array('0',$data['stores'])){
					$data['stores'] = array(0);
				}	
				
				/* $stores = Mage::helper('core')->jsonEncode($data['stores']);	 */		
				$data['stores'] = implode(',',$data['stores']);
			}
			$tmp = array('width', 'height', 'controls', 'pager', 'pause', 'speed');
			$config = array();
			foreach ($tmp as $key) {
				$config[$key] = $data[$key];
			}
			$data['config'] = serialize($config);
			$model->setData($data)->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
					->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('magicslider')->__('Magicslider was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicslider')->__('Unable to find Magicslider to save'));
		$this->_redirect('*/*/');
	}

	public function deleteAction() 
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('magicslider/magicslider');
				
				$model->setId($this->getRequest()->getParam('id'))
				->delete();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Magicslider was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	public function massDeleteAction() 
	{
		$magicsliderIds = $this->getRequest()->getParam('magicslider');
		if(!is_array($magicsliderIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Magicslider(s)'));
		} else {
			try {
				foreach ($magicsliderIds as $magicsliderId) {
					$magicslider = Mage::getModel('magicslider/magicslider')->load($magicsliderId);
					$magicslider->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('adminhtml')->__(
				'Total of %d record(s) were successfully deleted', count($magicsliderIds)
				)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
	
	public function massStatusAction()
	{
		$magicsliderIds = $this->getRequest()->getParam('magicslider');
		if(!is_array($magicsliderIds)) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Magicslider(s)'));
		} else {
			try {
				foreach ($magicsliderIds as $magicsliderId) {
					$magicslider = Mage::getSingleton('magicslider/magicslider')
					->load($magicsliderId)
					->setStatus($this->getRequest()->getParam('status'))
					->setIsMassupdate(true)
					->save();
				}
				$this->_getSession()->addSuccess(
				$this->__('Total of %d record(s) were successfully updated', count($magicsliderIds))
				);
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
}

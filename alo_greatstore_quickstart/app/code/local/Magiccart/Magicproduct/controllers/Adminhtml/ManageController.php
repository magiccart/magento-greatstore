<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2015-05-04 14:16:07
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicproduct_Adminhtml_ManageController extends Mage_Adminhtml_Controller_Action
{
	const NAVIGATION = 'magiccart/magicproduct_items';
	const PATH 		 = 'magicproduct/identifier/';
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu(self::NAVIGATION)
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Itmes Manager'), Mage::helper('adminhtml')->__('Itmes Manager'));
		return $this;
	}   

	public function indexAction() {
		$this->_initAction()
			 // ->_addContent($this->getLayout()->createBlock('adminhtml/store_switcher'))
			 ->_addContent($this->getLayout()->createBlock('magicproduct/adminhtml_manage'))
			 ->renderLayout();
	}

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magicproduct/adminhtml_manage_grid')->toHtml()
        );
    }

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model = Mage::getModel('core/config_data')->load($id);
		if($model->getValue()) $model->addData(unserialize($model->getValue()));
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('magicproduct_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu(self::NAVIGATION);

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Itmes Manager'), Mage::helper('adminhtml')->__('Itmes Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Itmes News'), Mage::helper('adminhtml')->__('Itmes News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			// $this->_addContent($this->getLayout()->createBlock('adminhtml/store_switcher'));
			$this->_addContent($this->getLayout()->createBlock('magicproduct/adminhtml_manage_edit'))
				// ->_addLeft($this->getLayout()->createBlock('adminhtml/system_config_switcher'))
				->_addLeft($this->getLayout()->createBlock('magicproduct/adminhtml_manage_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicproduct')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
				try {	
					$uploader = new Varien_File_Uploader('image');
					
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . 'magiccart' . DS .'magicproduct'. DS;
					$result = $uploader->save($path, $_FILES['image']['name'] );
					
					//this way the name is saved in DB
					$data['image'] = 'magiccart/magicproduct/'. $result['file'];
				} catch (Exception $e) {
		      
		        }	        
			} else {
				if(isset($data['image']['delete']) && $data['image']['delete'] == 1) {
					 $data['image'] = '';
				} else {
					unset($data['image']);
				}
			}
	  	
	  		if(isset($data['stores'])) $data['stores'] = implode(',', $data['stores']);
			$id = $this->getRequest()->getParam('id');
			$path  = self::PATH . $data['identifier'];
			$value = serialize($data);
			$model = Mage::getModel('core/config_data');
			if($id){
				$check = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', $path)->getFirstItem();
				if($check->getConfigId() != $id){
	                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicproduct')->__('Identifier already exists')); //Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	                Mage::getSingleton('adminhtml/session')->setFormData($data);
	                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
	                return;					
				}
				$model->load($id);
				$model->setData('path', $path)
					->setData('value', $value);
			} else {
				$model->setData('path', $path)
					->setData('value', $value);
			}

			try {
				$model->save(); //$model->saveConfig($path, $value, $scope, $storeId);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('magicproduct')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicproduct')->__('Identifier already exists')); //Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicproduct')->__('Unable to find Item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
                $model =  Mage::getModel('core/config_data');
				$model->setId($this->getRequest()->getParam('id'))->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $mpIds = $this->getRequest()->getParam('magicproduct');
        if(!is_array($mpIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Item(s)'));
        } else {
            try {
                foreach ($mpIds as $Id) {
                    $model =  Mage::getModel('core/config_data')->load($Id);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($mpIds)
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
        $mpIds = $this->getRequest()->getParam('magicproduct');
        if(!is_array($mpIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Item(s)'));
        } else {
            try {
                foreach ($mpIds as $Id) {
                    $model =  Mage::getModel('core/config_data')->load($Id);
                    $tmp =	unserialize($model->getValue());
                    $tmp['status'] = $this->getRequest()->getParam('status');
                    $model->setValue(serialize($tmp))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($mpIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'magicproduct.csv';
        $content    = $this->getLayout()
	    				   ->createBlock('magicproduct/adminhtml_manage_grid')
	        			   ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'magicproduct.xml';
        $content    = $this->getLayout()
        				   ->createBlock('magicproduct/adminhtml_manage_grid')
            			   ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}


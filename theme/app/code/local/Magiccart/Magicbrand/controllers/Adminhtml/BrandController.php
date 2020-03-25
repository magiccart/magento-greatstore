<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 19:51:31
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicbrand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{
	const NAVIGATION = 'magiccart/magicbrand_brand';
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu(self::NAVIGATION)
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand Manager'), Mage::helper('adminhtml')->__('Brand Manager'));
		return $this;
	}   

	public function indexAction() {
		$this->_initAction()
			 ->_addContent($this->getLayout()->createBlock('magicbrand/adminhtml_brand'))
			 ->renderLayout();
	}

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magicbrand/adminhtml_brand_grid')->toHtml()
        );
    }

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('magicbrand/brand')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('brand_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu(self::NAVIGATION);

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand Manager'), Mage::helper('adminhtml')->__('Brand Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand News'), Mage::helper('adminhtml')->__('Brand News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('magicbrand/adminhtml_brand_edit'))
				->_addLeft($this->getLayout()->createBlock('magicbrand/adminhtml_brand_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicbrand')->__('Item does not exist'));
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
					$path = Mage::getBaseDir('media') . DS . 'magiccart' . DS .'magicbrand'. DS;
					$result = $uploader->save($path, $_FILES['image']['name'] );
					
					//this way the name is saved in DB
					$data['image'] = 'magiccart/magicbrand/'. $result['file'];
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
	  		//var_dump($data);die;
			$model = Mage::getModel('magicbrand/brand');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('magicbrand')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicbrand')->__('Unable to find brand to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('magicbrand/brand');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
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
        $brandIds = $this->getRequest()->getParam('brand');
        if(!is_array($brandIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select brand(s)'));
        } else {
            try {
                foreach ($brandIds as $brandId) {
                    $brand = Mage::getModel('magicbrand/brand')->load($brandId);
                    $brand->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($brandIds)
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
        $brandIds = $this->getRequest()->getParam('brand');
        if(!is_array($brandIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select brand(s)'));
        } else {
            try {
                foreach ($brandIds as $brandId) {
                    $brand = Mage::getSingleton('magicbrand/brand')
                        ->load($brandId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($brandIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'magicbrand.csv';
        $content    = $this->getLayout()
	    				   ->createBlock('magicbrand/adminhtml_brand_grid')
	        			   ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'magicbrand.xml';
        $content    = $this->getLayout()
        				   ->createBlock('magicbrand/adminhtml_brand_grid')
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


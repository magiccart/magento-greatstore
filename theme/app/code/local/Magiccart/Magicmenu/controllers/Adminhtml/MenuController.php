<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-11-17 11:33:18
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicmenu_Adminhtml_MenuController extends Mage_Adminhtml_Controller_Action
{
	const NAVIGATION = 'magiccart/magicmenu_menus';	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu(self::NAVIGATION)
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Menu Manager'), Mage::helper('adminhtml')->__('Menu Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			 ->_addContent($this->getLayout()->createBlock('magicmenu/adminhtml_menu'))
			 ->renderLayout();
	}

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magicmenu/adminhtml_menu_grid')->toHtml()
        );
    }

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('magicmenu/menu')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('menu_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu(self::NAVIGATION);

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Menu Manager'), Mage::helper('adminhtml')->__('Menu Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Menu News'), Mage::helper('adminhtml')->__('Menu News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('magicmenu/adminhtml_menu_edit'))
				->_addLeft($this->getLayout()->createBlock('magicmenu/adminhtml_menu_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicmenu')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			if(!$data['top'] && !$data['right'] && !$data['bottom'] && !$data['left']){
				//Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicmenu')->__('Unable to find static block to save'));
				//$this->_redirect('*/*/');
				//return;				
			}else {
				$data['extra'] = 0;
			}

			if(isset($data['stores'])) $data['stores'] = implode(',', $data['stores']);
			$custom = array('right'=>'right_proportions', 'left'=>'left_proportions');
			foreach($custom as $key =>$value){
				if($data[$key] == '') $data[$value] = '';
			}
			if(isset($data['cat_id'])){
				$model =  Mage::getModel('magicmenu/menu')->load($data['cat_id']);
				if($model->getData()){
					$model->addData($data);
					try {
							$model->setId($this->getRequest()->getParam('id'))->save();
							Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('magicmenu')->__('Item was successfully saved'));
							$this->_redirect('*/*/');
							return;
						   
						} catch (Exception $e){
			                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			                Mage::getSingleton('adminhtml/session')->setFormData($data);
			                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			                return;
						}
				}
			}else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicmenu')->__('Unable to find Category Id to save'));
				$this->_redirect('*/*/');
				return;
			}

			$model = Mage::getModel('magicmenu/menu');
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
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('magicmenu')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magicmenu')->__('Unable to find menu to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('magicmenu/menu');
				 
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
        $menuIds = $this->getRequest()->getParam('menu');
        if(!is_array($menuIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select menu(s)'));
        } else {
            try {
                foreach ($menuIds as $menuId) {
                    $menu = Mage::getModel('magicmenu/menu')->load($menuId);
                    $menu->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($menuIds)
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
        $menuIds = $this->getRequest()->getParam('menu');
        if(!is_array($menuIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select menu(s)'));
        } else {
            try {
                foreach ($menuIds as $menuId) {
                    $menu = Mage::getSingleton('magicmenu/menu')
                        ->load($menuId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($menuIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'magicmenu.csv';
        $content    = $this->getLayout()
	    				   ->createBlock('magicmenu/adminhtml_menu_grid')
	        			   ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'magicmenu.xml';
        $content    = $this->getLayout()
        				   ->createBlock('magicmenu/adminhtml_menu_grid')
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


<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-09-03 20:18:41
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_IndexController extends Mage_Core_Controller_Front_Action
{

	public function viewAction()
	{
        $this->loadLayout();    
        $this->renderLayout();
	}

    public function indexAction()
    {		
		$this->loadLayout();
	  	$this->getLayout()->getBlock("head")->setTitle($this->__("Testimonials"));
	  	$breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      	$breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));
      	$breadcrumbs->addCrumb("testimonials", array(
                "label" => $this->__("Testimonials"),
                "title" => $this->__("Testimonials")
		   ));
		$this->renderLayout();
    }

	public function checkAction() 
	{
		if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
			if(Mage::helper('testimonial')->getGeneralCfg('allowGuest')) {
				$this->_redirect('*/*/create');
			}else {
				Mage::getSingleton('customer/session')->authenticate($this);
			}
		}else {
			$this->_redirect('*/*/create');
		}
	}

    public function createAction()
    {
        $this->loadLayout();
		  $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
		  $breadcrumbs->addCrumb("home", array(
					"label" => $this->__("Home"),
					"title" => $this->__("Home"),
					"link"  => Mage::getBaseUrl()
			   ));
		  $breadcrumbs->addCrumb("create_testimonials", array(
					"label" => $this->__("Create Testimonials"),
					"title" => $this->__("Create Testimonials")
			   ));
        $this->renderLayout();
    }
    public function createpostAction()
    {
		if ($this->getRequest()->getPost()) {
			try {
				$data = $this->getRequest()->getParams();
				//echo '<pre>'; var_dump($data); echo '</pre>'; exit;
				if (isset($_FILES['image']['name']) && (file_exists($_FILES['image']['tmp_name']))) {
					$uploader = new Varien_File_Uploader('image');
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
					$path = Mage::getBaseDir('media'). DS . 'magiccart'. DS .'testimonial'. DS;
					$uploader->save($path, $_FILES['image']['name']);
					$data['image'] = 'magiccart/testimonial/' . $_FILES['image']['name'];
				}
				$autoApprove = Mage::helper('testimonial')->getGeneralCfg('autoApprove');
				if($autoApprove) $data['status'] = Mage_Review_Model_Review::STATUS_APPROVED;
				$model = Mage::getModel('testimonial/testimonial');
				$model->setData($data)->save();

				Mage::getModel('core/session')->addSuccess(Mage::helper('adminhtml')->__('Testimonial successfully submitted for admin approval.'));
				$this->_redirect('*/*');
			} catch (Exception $e) {
				Mage::getModel('core/session')->addError($e->getMessage());
				$this->_redirect('*/*');
				//return;
			}
		}
    }

	public function thankAction() 
	{
		$message= Mage::helper('testimonial')->getGeneralCfg('thank');
		
		// if(Mage::helper('testimonial')->getGeneralCfg('autoApprove'))
		
		Mage::getSingleton('core/session')->addSuccess($message);
		
		$this->_redirect('*/index');
		
	}

}


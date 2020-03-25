<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2014-09-09 16:02:09
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_IndexController extends Mage_Core_Controller_Front_Action
{
    public function ajaxAction()
    {
    	if ($this->getRequest()->isAjax()) {

	        $this->loadLayout();    
	        $this->renderLayout();
	        return $this;
	    }
    }

    public function productAction()
    {
        $this->loadLayout();   
        $type = $this->getRequest()->getParam('type');
        $title = $this->getProductTitle($type);
        $this->getLayout()->getBlock("head")->setTitle($this->__($title));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
           ));
        $breadcrumbs->addCrumb("magiccategory", array(
                "label" => $this->__($title),
                "title" => $this->__($title)
           )); 
        $this->renderLayout();
    }

    public function getProductTitle($tp)
    {
        $types = Mage::getSingleton("magiccategory/system_config_type")->toOptionArray();
        foreach ($types as $type) {
            if($type['value'] == $tp) return $type['label'];
        }
    }

}


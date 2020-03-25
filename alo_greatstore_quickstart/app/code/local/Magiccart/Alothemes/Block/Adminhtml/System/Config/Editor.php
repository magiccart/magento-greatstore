<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-08-27 21:52:31
 * @@Modify Date: 2015-05-05 10:22:07
 * @@Function:
 */
?>
<?php
class Magiccart_Alothemes_Block_Adminhtml_System_Config_Editor 
	extends Mage_Adminhtml_Block_System_Config_Form_Field 
	implements Varien_Data_Form_Element_Renderer_Interface{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
        $element->setWysiwyg(true);
        $element->setConfig(Mage::getSingleton('cms/wysiwyg_config')->getConfig());
        return parent::_getElementHtml($element);
    }
}


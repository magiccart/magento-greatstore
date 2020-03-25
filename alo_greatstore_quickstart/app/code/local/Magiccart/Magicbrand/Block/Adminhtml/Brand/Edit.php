<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 19:51:44
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicbrand_Block_Adminhtml_Brand_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'magicbrand';
        $this->_controller = 'adminhtml_brand';
        
        $this->_updateButton('save', 'label', Mage::helper('magicbrand')->__('Save Brand'));
        $this->_updateButton('delete', 'label', Mage::helper('magicbrand')->__('Delete Brand'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('magicbrand_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'magicbrand_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'magicbrand_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('brand_data') && Mage::registry('brand_data')->getId() ) {
            return Mage::helper('magicbrand')->__("Edit Brand '%s'", $this->htmlEscape(Mage::registry('brand_data')->getTitle()));
        } else {
            return Mage::helper('magicbrand')->__('Add Brand');
        }
    }
}

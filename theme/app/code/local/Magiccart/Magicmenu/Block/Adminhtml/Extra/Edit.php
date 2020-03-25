<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-05 15:30:39
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicmenu_Block_Adminhtml_Extra_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'magicmenu';
        $this->_controller = 'adminhtml_extra';
        
        $this->_updateButton('save', 'label', Mage::helper('magicmenu')->__('Save Extra Menu'));
        $this->_updateButton('delete', 'label', Mage::helper('magicmenu')->__('Delete Extra Menu'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('magicmenu_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'magicmenu_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'magicmenu_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('extra_data') && Mage::registry('extra_data')->getId() ) {
            return Mage::helper('magicmenu')->__("Edit Extra Menu '%s'", $this->htmlEscape(Mage::registry('extra_data')->getName()));
        } else {
            return Mage::helper('magicmenu')->__('Add Extra Menu');
        }
    }
}


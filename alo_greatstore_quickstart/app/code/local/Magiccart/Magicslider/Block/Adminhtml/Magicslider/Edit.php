<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2014-09-22 13:31:03
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Block_Adminhtml_Magicslider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'magicslider';
        $this->_controller = 'adminhtml_magicslider';
        
        $this->_updateButton('save', 'label', Mage::helper('magicslider')->__('Save Magicslider'));
        $this->_updateButton('delete', 'label', Mage::helper('magicslider')->__('Delete Magicslider'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('magicslider_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'magicslider_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'magicslider_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('magicslider_data') && Mage::registry('magicslider_data')->getId() ) {
            return Mage::helper('magicslider')->__("Edit Magicslider '%s'", $this->htmlEscape(Mage::registry('magicslider_data')->getTitle()));
        } else {
            return Mage::helper('magicslider')->__('Add Magicslider');
        }
    }
}

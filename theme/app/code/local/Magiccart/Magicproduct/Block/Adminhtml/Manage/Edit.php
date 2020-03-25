<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-18 19:54:43
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Block_Adminhtml_Manage_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'magicproduct';
        $this->_controller = 'adminhtml_manage';
        
        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('Save Magicproduct'));
        $this->_updateButton('delete', 'label', Mage::helper('adminhtml')->__('Delete Magicproduct'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('magicproduct_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'magicproduct_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'magicproduct_content');
                }
            }
            var back = $('edit_form').action + 'back/edit/';
            function saveAndContinueEdit(){
                editForm.submit(back);
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('magicproduct_data') && Mage::registry('magicproduct_data')->getId() ) {
            return Mage::helper('adminhtml')->__("Edit Magicproduct '%s'", $this->htmlEscape(Mage::registry('magicproduct_data')->getTitle()));
        } else {
            return Mage::helper('adminhtml')->__('Add Magicproduct');
        }
    }
}

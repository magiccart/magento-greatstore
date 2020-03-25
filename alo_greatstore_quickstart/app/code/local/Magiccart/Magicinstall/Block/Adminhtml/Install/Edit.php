<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:47:03
 * @@Modify Date: 2014-11-06 00:51:12
 * @@Function:
 */
?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Install_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->removeButton('back');
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'magicinstall';
        $this->_controller = 'adminhtml_install';
        
        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('Submit'));
        $this->_updateButton('delete', 'label', Mage::helper('adminhtml')->__('Delete Item'));
		
    
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('install_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'install_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'install_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('install_data') && Mage::registry('install_data')->getId() ) {
            return Mage::helper('install')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('install_data')->getTitle()));
        } else {
            return Mage::helper('install')->__('');
        }
    }
}


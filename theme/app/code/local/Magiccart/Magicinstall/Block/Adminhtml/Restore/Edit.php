<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 16:28:07
 * @@Modify Date: 2014-10-27 11:12:15
 * @@Function:
 */
?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Restore_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'magicinstall';
        $this->_controller = 'adminhtml_restore';
        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('Restore Defaults'));
        $this->_removeButton('delete');
        $this->_removeButton('back');
    }

    public function getHeaderText()
    {
        return Mage::helper('adminhtml')->__('Theme Restore Defaults');
    }
}

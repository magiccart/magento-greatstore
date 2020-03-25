<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:45:57
 * @@Modify Date: 2014-10-27 09:52:10
 * @@Function:
 */

 ?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Page extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_page';
        $this->_blockGroup = 'magicinstall';
        $this->_headerText = Mage::helper('magicinstall')->__('Manage Export Page');
        parent::__construct();
        $this->_removeButton('add');
    }
}


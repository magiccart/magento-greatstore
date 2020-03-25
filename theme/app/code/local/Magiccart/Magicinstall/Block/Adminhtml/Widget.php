<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:44:37
 * @@Modify Date: 2014-10-27 09:52:24
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Widget extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_widget';
        $this->_blockGroup = 'magicinstall';
        $this->_headerText = $this->__('Manage Export Widget');
        parent::__construct();
        $this->_removeButton('add');
    }
}


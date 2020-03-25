<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:47:03
 * @@Modify Date: 2015-11-04 11:43:05
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Permissions extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_permissions';
        $this->_blockGroup = 'magicinstall';
        $this->_headerText = $this->__('Manage Export Permissions Block');
        parent::__construct();
        $this->_removeButton('add');
    }
}


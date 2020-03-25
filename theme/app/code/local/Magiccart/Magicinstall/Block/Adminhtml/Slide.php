<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:47:03
 * @@Modify Date: 2014-11-25 16:30:31
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Slide extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_slide';
        $this->_blockGroup = 'magicinstall';
        $this->_headerText = $this->__('Manage Export Magicslider');
        parent::__construct();
        $this->_removeButton('add');
    }
}


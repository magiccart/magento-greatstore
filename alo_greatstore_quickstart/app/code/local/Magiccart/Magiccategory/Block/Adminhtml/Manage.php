<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-14 15:21:15
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_Block_Adminhtml_Manage extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_manage';
    $this->_blockGroup = 'magiccategory';
    $this->_headerText = Mage::helper('Adminhtml')->__('Group Manage');
    $this->_addButtonLabel = Mage::helper('Adminhtml')->__('Add Group');
    parent::__construct();
  }
}

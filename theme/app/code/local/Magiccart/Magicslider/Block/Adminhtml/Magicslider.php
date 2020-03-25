<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2014-09-22 13:29:11
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Block_Adminhtml_Magicslider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_magicslider';
    $this->_blockGroup = 'magicslider';
    $this->_headerText = Mage::helper('magicslider')->__('Slide Manage');
    $this->_addButtonLabel = Mage::helper('magicslider')->__('Add Slide');
    parent::__construct();
  }
}

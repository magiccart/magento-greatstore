<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-05 15:15:29
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicmenu_Block_Adminhtml_Extra extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_extra';
		$this->_blockGroup = 'magicmenu';
		$this->_headerText = Mage::helper('magicmenu')->__('Extra Menu Manager');
		$this->addButtionLabel = Mage::helper('magicmenu')->__('Add Extra Menu');
		parent::__construct();
	}
}


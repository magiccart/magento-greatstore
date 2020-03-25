<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-05 11:25:30
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicmenu_Block_Adminhtml_Menu extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_menu';
		$this->_blockGroup = 'magicmenu';
		$this->_headerText = Mage::helper('magicmenu')->__('Menu Manager');
		$this->addButtionLabel = Mage::helper('magicmenu')->__('Add Custom Menu');
		parent::__construct();
	}
}


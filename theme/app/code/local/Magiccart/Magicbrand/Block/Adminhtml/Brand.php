<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 20:48:09
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicbrand_Block_Adminhtml_Brand extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_brand';
		$this->_blockGroup = 'magicbrand';
		$this->_headerText = Mage::helper('magicbrand')->__('Brand Manager');
		$this->addButtionLabel = Mage::helper('magicbrand')->__('Add Brand');
		parent::__construct();
	}
}

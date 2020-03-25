<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-30 16:51:30
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Block_Adminhtml_Testimonial extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_testimonial';
		$this->_blockGroup = 'testimonial';
		$this->_headerText = Mage::helper('adminhtml')->__('Testimonial Manager');
		$this->addButtionLabel = Mage::helper('adminhtml')->__('Add Testimonial');
		parent::__construct();
	}
}


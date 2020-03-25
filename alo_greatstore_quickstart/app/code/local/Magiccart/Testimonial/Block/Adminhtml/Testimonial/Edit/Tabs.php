<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-08-06 16:17:16
 * @@Function:
 */
 ?>
<?php

class Magiccart_Testimonial_Block_Adminhtml_Testimonial_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('testimonial_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('adminhtml')->__('Testimonial Information'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
			'label'     => Mage::helper('adminhtml')->__('Testimonial Information'),
			'title'     => Mage::helper('adminhtml')->__('Testimonial Information'),
			'content'   => $this->getLayout()->createBlock('testimonial/adminhtml_testimonial_edit_tab_form')->toHtml(),
		));

		return parent::_beforeToHtml();
	}
}


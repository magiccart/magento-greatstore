<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-05 13:38:16
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicmenu_Block_Adminhtml_Menu_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

	public function __construct()
	{
		parent::__construct();
		$this->setId('menu_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('magicmenu')->__('Menu Information'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
			'label'     => Mage::helper('magicmenu')->__('Menu Information'),
			'title'     => Mage::helper('magicmenu')->__('Menu Information'),
			'content'   => $this->getLayout()->createBlock('magicmenu/adminhtml_menu_edit_tab_form')->toHtml(),
		));

		// $this->addTab('images_section', array(
		//     'label'     => Mage::helper('magicmenu')->__('Images menu'),
		//     'title'     => Mage::helper('magicmenu')->__('Images menu'),
		//     'url'       => $this->getUrl('*/*/images', array('_current' => true)),
		//     'class'     => 'ajax',
		// ));

		// $this->addTab('product_section', array(
		//     'label'     => Mage::helper('magicmenu')->__('Products'),
		//     'title'     => Mage::helper('magicmenu')->__('Products'),
		//     'url'       => $this->getUrl('*/*/product', array('_current' => true)),
		//     'class'     => 'ajax',
		// ));

		return parent::_beforeToHtml();
	}
}


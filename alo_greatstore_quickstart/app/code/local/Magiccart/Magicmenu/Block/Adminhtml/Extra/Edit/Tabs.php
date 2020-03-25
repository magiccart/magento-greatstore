<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-05 18:18:41
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicmenu_Block_Adminhtml_Extra_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
			'content'   => $this->getLayout()->createBlock('magicmenu/adminhtml_extra_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}


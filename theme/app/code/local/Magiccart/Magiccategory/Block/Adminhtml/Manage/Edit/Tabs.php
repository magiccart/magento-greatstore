<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-05-04 14:58:29
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_Block_Adminhtml_Manage_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('magiccategory_tabs');
		$this->setName('magiccategory_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('adminhtml')->__('Magiccategory Information'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('general_section', array(
			'label'     => Mage::helper('adminhtml')->__('General Information'),
			'title'     => Mage::helper('adminhtml')->__('General Information'),
			'content'   => $this->getLayout()->createBlock('magiccategory/adminhtml_manage_edit_tab_form')->toHtml(),
		));      

		$this->addTab('categories', array(
			'label'     => Mage::helper('catalog')->__('Categories'),
			'url'       => $this->getUrl('*/*/categories', array('_current' => true)),
			'class'     => 'ajax',
		));

		$reponsive = Mage::getSingleton('core/layout')->createBlock('magicproduct/adminhtml_manage_edit_tab_reponsive');
		$reponsive->setId($this->getHtmlId() . '_content')->setElement($this); 
		$this->addTab('reponsive_section', array(
			'label'     => Mage::helper('adminhtml')->__('Reponsive'),
			'title'     => Mage::helper('adminhtml')->__('Reponsive'),
			'content'   => $reponsive->toHtml(),
		));

		$content = Mage::getSingleton('core/layout')->createBlock('magiccategory/adminhtml_manage_edit_tab_config');
		$content->setId($this->getHtmlId() . '_content')->setElement($this); 
		$this->addTab('config_section', array(
			'label'     => Mage::helper('adminhtml')->__('Config'),
			'title'     => Mage::helper('adminhtml')->__('Config'),
			'content'   => $content->toHtml(),
		));

		return parent::_beforeToHtml();
	}
}

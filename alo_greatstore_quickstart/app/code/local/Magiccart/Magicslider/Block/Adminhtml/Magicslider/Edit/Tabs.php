<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2014-09-22 16:16:43
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Block_Adminhtml_Magicslider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('magicslider_tabs');
		$this->setName('magicslider_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('magicslider')->__('Magicslider Information'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('general_section', array(
			'label'     => Mage::helper('magicslider')->__('General Information'),
			'title'     => Mage::helper('magicslider')->__('General Information'),
			'content'   => $this->getLayout()->createBlock('magicslider/adminhtml_magicslider_edit_tab_form')->toHtml(),
		));	  


		$content = Mage::getSingleton('core/layout')->createBlock('magicslider/adminhtml_magicslider_edit_tab_gallery');
		$content->setId($this->getHtmlId() . '_content')->setElement($this);       

		$this->addTab('gallery_section', array(
			'label'     => Mage::helper('magicslider')->__('Content Slider'),
			'title'     => Mage::helper('magicslider')->__('Content Slider'),
			'content'   => $content->toHtml(),
		));

		return parent::_beforeToHtml();
	}
}

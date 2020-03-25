<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:47:03
 * @@Modify Date: 2015-03-05 08:36:03
 * @@Function:
 */
?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Install_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('installtemplate_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('adminhtml')->__('Item Information'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
			'label'     => Mage::helper('adminhtml')->__('Setting Template'),
			'title'     => Mage::helper('adminhtml')->__('Setting Template'),
			'content'   => $this->getLayout()->createBlock('magicinstall/adminhtml_install_edit_tab_form')->toHtml(),
		));

		return parent::_beforeToHtml();
	}
}


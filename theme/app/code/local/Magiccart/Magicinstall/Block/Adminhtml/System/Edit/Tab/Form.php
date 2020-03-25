<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:47:03
 * @@Modify Date: 2015-02-05 17:48:17
 * @@Function:
 */
?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_System_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('export_form', array('legend'=>Mage::helper('adminhtml')->__('Export Config')));

		$fieldset->addField('store_id', 'select', array(
			'name' => 'store_id',
			'label' => $this->__('Store Export'),
			'required' => true,
			'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false),
		));
		return parent::_prepareForm();
	}
}


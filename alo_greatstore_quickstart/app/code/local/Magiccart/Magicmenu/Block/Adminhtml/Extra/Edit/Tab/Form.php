<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-12-02 15:35:17
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicmenu_Block_Adminhtml_Extra_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	public function getStaticBlock()
	{
		// $options = Mage::getResourceModel('cms/block_collection')->load()->toOptionArray(); // if use value is id
		$options = array();
		$blocks = Mage::getResourceModel('cms/block_collection')->load();
		foreach ($blocks as $block) {
			$options[$block->getIdentifier()] = $block->getTitle();
		}
		array_unshift($options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Please select a static block ...')));
		return $options;
	}

	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('menu_form', array('legend'=>Mage::helper('magicmenu')->__('Category information')));

		$name = $fieldset->addField('name', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Name'),
			'required'  => true,
			'class'     => 'required-entry',
			'name'      => 'name',
			'after_element_html' => '<p class="nm"><small>Name show in Navigation</small></p>',
		));

		$fieldset->addField('link', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Link'),
			// 'required'  => true,
			'name'      => 'link',
			'after_element_html' => '
				<p class="nm"><small>Link for Menu:</small></p>
				<p class="nm"><small>Ex1: http://domain.com/contact</small></p>
				<p class="nm"><small>Ex2: magicproduct/index/product/type/bestseller</small></p>
				<p class="nm"><small>Ex3: bestseller (URL Rewrite)</small></p>
			',
		));

		$fieldset->addField('magic_label', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Label'),
			'name'      => 'magic_label',
			'after_element_html' => '<p class="nm"><small>Example: New,Hot,...</small></p>',
		));

		$short_desc = $fieldset->addField('short_desc', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Short Description'),
			'name'      => 'short_desc',
		));
		$short_desc->setAfterElementHtml(
			'<p>You have 20</p>
			<script language="javascript" type="text/javascript">
			$("'.$short_desc->getHtmlId().'").observe("keypress", limitText);
			function limitText(event) {
				var obj = event.element();
				var limit = 20;
				if (obj.value.length > limit) {
					obj.value = obj.value.substring(0, limit);
				} else {
					obj.next().innerHTML = "You have "+(limit - obj.value.length) +" character";
				}
			}
			</script>
			'
		);

		$extContent = $fieldset->addField('ext_content', 'select', array(
			'label'     => Mage::helper('magicmenu')->__('Content'),
			'name'      => 'ext_content',
			'values'    => $this->getStaticBlock(),
			'after_element_html' => '<p class="nm"><small>Content Dropdown while hover</small></p>',
		));
	
		// $fieldset->addField('active_from', 'text', array(
		// 	'label'     => Mage::helper('magicmenu')->__('Active From'),
		// 	'required'  => false,
		// 	'name'      => 'active_from',
		// ));

		// $fieldset->addField('active_to', 'text', array(
		// 	'label'     => Mage::helper('magicmenu')->__('Active To'),
		// 	'required'  => false,
		// 	'name'      => 'active_to',
		// ));
	
		if (!Mage::app()->isSingleStoreMode()) {
			$fieldset->addField('stores', 'multiselect', array(
				'name' => 'stores[]',
				'label' => $this->__('Store View'),
				'required' => true,
				'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
			));
		}

		$fieldset->addField('order', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Extra Menu Order'),
			'class'     => 'validate-digits',
			'required'  => false,
			'name'      => 'order',
			'after_element_html' => '<p class="nm"><small>Order Extra Menu in Navigation</small></p>',
		));

		$fieldset->addField('status', 'select', array(
			'label'     => Mage::helper('magicmenu')->__('Status'),
			'name'      => 'status',
			'values'    => array(
				array(
					'value'     => 1,
					'label'     => Mage::helper('magicmenu')->__('Enabled'),
				),

				array(
					'value'     => 2,
					'label'     => Mage::helper('magicmenu')->__('Disabled'),
				),
			),
			'after_element_html' => '<p class="nm"><small>Enabled Extra Menu</small></p>',
		));

		if ( Mage::getSingleton('adminhtml/session')->getMenuData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getMenuData());
			Mage::getSingleton('adminhtml/session')->setMenuData(null);
		} elseif ( Mage::registry('extra_data') ) {
			$form->setValues(Mage::registry('extra_data')->getData());
		}

		return parent::_prepareForm();
	}
}


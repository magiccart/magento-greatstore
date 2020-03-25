<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-11-09 16:38:32
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicmenu_Block_Adminhtml_Menu_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

	public function getCatTop()
	{

		$catTop = Mage::getModel('catalog/category')
						->getCollection()
						->addAttributeToSelect(array('entity_id','name'))
						->addIsActiveFilter()
						->addAttributeToFilter('level',2) // note: ->addAttributeToFilter('level',2) =! ->addLevelFilter(2)
						->addOrderField('position');
		$options = array(''=>Mage::helper('catalog')->__('Please select a category ...'));
		foreach ($catTop as $cat) {
			$options[$cat->getEntityId()] = $cat->getName();
		}


		// $Roots = Mage::getModel('catalog/category')->getCollection()
		// 				->addAttributeToSelect('entity_id')
		// 				->addAttributeToFilter('level',1)
		// 				->addIsActiveFilter()
		// 				->addOrderField('position');

		// $options = array(''=>Mage::helper('catalog')->__('Please select a category ...'));
		// foreach ($Roots as $root) {
		// 	$catTop = Mage::getModel('catalog/category')
		// 					->getCollection()
		//                     ->addAttributeToSelect(array('entity_id','name'))
		//                     ->addAttributeToFilter('parent_id', $root->getEntityId())
		// 					->addIsActiveFilter()
		// 					->addAttributeToFilter('level',2)
		// 					->addOrderField('position');
		// 	foreach ($catTop as $cat) {
		// 		$options[$cat->getEntityId()] = $cat->getName();
		// 	}
		// }

		return $options;

	}
	
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

		$cat = $fieldset->addField('cat_id', 'select', array(
			'label'     => Mage::helper('magicmenu')->__('Category'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'cat_id',
			'values'    => $this-> getCatTop(),
			'after_element_html' => '
				<p class="nm"><small>Select top category</small></p>
				<p class="nm"><small>Label && short description set in Manage Categories</small></p>
			',
		));

		$cat_proportions = $fieldset->addField('cat_proportions', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Proportions: Category'),
			'class'     => 'validate-greater-than-zero',
			// 'required'  => true,
			'name'      => 'cat_proportions',
		));
	    $cat_proportions->setAfterElementHtml(
			'<p class="nm"><small>Proportions weight</small></p>
			<script type="text/javascript">
				Event.observe(window, "load", function() {
					var map     = "'.$cat->getHtmlId().'";
					var depend  = "'.$cat_proportions->getHtmlId().'";

					// Event.observe(map, "change", function(){
					// 	$(depend).removeClassName("required-entry");
					// 	$(depend).up(1).fade();              
					// });                      
					if ($(map).getValue() != "") $(depend).up(1).appear(); else $(depend).up(1).hide();
					Event.observe(map, "change", function(){
						if ($(map).getValue() != "") $(depend).up(1).appear(); else $(depend).up(1).fade();                      
					});
				})
			</script>
			'
	    );

		$cat_columns = $fieldset->addField('cat_columns', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Columns category'),
			'class'     => 'validate-greater-than-zero',
			// 'required'  => true,
			'name'      => 'cat_columns',
		));

		// $label = $fieldset->addField('label', 'text', array(
		// 	'label'     => Mage::helper('magicmenu')->__('Label'),
		// 	'name'      => 'label',
		// 	'after_element_html' => '<p class="nm"><small>Example: New,Hot,...</small></p>',
		// ));

		// $short_desc = $fieldset->addField('short_desc', 'text', array(
		// 	'label'     => Mage::helper('magicmenu')->__('Short Description'),
		// 	'name'      => 'short_desc',
		// ));
		// $short_desc->setAfterElementHtml(
		// 	'<p>You have 20</p>
		// 	<script language="javascript" type="text/javascript">
		// 	$("'.$short_desc->getHtmlId().'").observe("keypress", limitText);
		// 	function limitText(event) {
		// 		var obj = event.element();
		// 		var limit = 20;
		// 		if (obj.value.length > limit) {
		// 			obj.value = obj.value.substring(0, limit);
		// 		} else {
		// 			obj.next().innerHTML = "You have "+(limit - obj.value.length);
		// 		}
		// 	}
		// 	</script>
		// 	'
		// );

		$top = $fieldset->addField('top', 'select', array(
			'label'     => Mage::helper('magicmenu')->__('Block Top'),
			'name'      => 'top',
			'values'    => $this->getStaticBlock(),
		));

		$right = $fieldset->addField('right', 'select', array(
			'label'     => Mage::helper('magicmenu')->__('Block Right'),
			'name'      => 'right',
			'values'    => $this->getStaticBlock(),
		));

		$right_proportions = $fieldset->addField('right_proportions', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Proportions: Block Right'),
			'class'     => 'validate-greater-than-zero',
			// 'required'  => true,
			'name'      => 'right_proportions',
			'after_element_html' => '<p class="nm"><small>Proportions weight</small></p>',
		));

	    $right_proportions->setAfterElementHtml(
			'<p class="nm"><small>Proportions weight</small></p>
			<script type="text/javascript">
				Event.observe(window, "load", function() {
					var map     = "'.$right->getHtmlId().'";
					var depend  = "'.$right_proportions->getHtmlId().'";

					// Event.observe(map, "change", function(){
					// 	$(depend).removeClassName("required-entry");
					// 	$(depend).up(1).fade();              
					// });                      
					if ($(map).getValue() != "") $(depend).up(1).appear(); else $(depend).up(1).hide();
					Event.observe(map, "change", function(){
						if ($(map).getValue() != "") $(depend).up(1).appear(); else $(depend).up(1).fade();                      
					});
				})
			</script>
			'
	    );

		$bottom = $fieldset->addField('bottom', 'select', array(
			'label'     => Mage::helper('magicmenu')->__('Block Bottom'),
			'name'      => 'bottom',
			'values'    => $this->getStaticBlock(),
		));

		$left = $fieldset->addField('left', 'select', array(
			'label'     => Mage::helper('magicmenu')->__('Block Left'),
			'name'      => 'left',
			'values'    => $this->getStaticBlock(),
		));

		$left_proportions = $fieldset->addField('left_proportions', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Proportions: Block Left'),
			'class'     => 'validate-greater-than-zero',
			// 'required'  => true,
			'name'      => 'left_proportions',
			'after_element_html' => '<p class="nm"><small>Proportions weight</small></p>',
		));

	    $left_proportions->setAfterElementHtml(
			'<p class="nm"><small>Proportions weight</small></p>
			<script type="text/javascript">
				Event.observe(window, "load", function() {
					var map     = "'.$left->getHtmlId().'";
					var depend  = "'.$left_proportions->getHtmlId().'";

					// Event.observe(map, "change", function(){
					// 	$(depend).removeClassName("required-entry");
					// 	$(depend).up(1).fade();              
					// });                      
					if ($(map).getValue() != "") $(depend).up(1).appear(); else $(depend).up(1).hide();
					Event.observe(map, "change", function(){
						if ($(map).getValue() != "") $(depend).up(1).appear(); else $(depend).up(1).fade();                      
					});
				})
			</script>
			'
	    );

	/*
		$fieldset->addField('active_from', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Active From'),
			'required'  => false,
			'name'      => 'active_from',
		));

		$fieldset->addField('active_to', 'text', array(
			'label'     => Mage::helper('magicmenu')->__('Active To'),
			'required'  => false,
			'name'      => 'active_to',
		));
	*/

		if (!Mage::app()->isSingleStoreMode()) {
			$fieldset->addField('stores', 'multiselect', array(
				'name' => 'stores[]',
				'label' => $this->__('Store View'),
				'required' => true,
				'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
			));
		}

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
			'after_element_html' => '<p class="nm"><small>Show Static Block in Category</small></p>',
		));

		if ( Mage::getSingleton('adminhtml/session')->getMenuData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getMenuData());
			Mage::getSingleton('adminhtml/session')->setMenuData(null);
		} elseif ( Mage::registry('menu_data') ) {
			$form->setValues(Mage::registry('menu_data')->getData());
		}

		return parent::_prepareForm();
	}
}


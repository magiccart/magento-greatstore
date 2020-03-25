<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-05-05 11:22:07
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Block_Adminhtml_Magicslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$model = Mage::registry('magicslider_data');	
		
		if($model->getStores())
		{		
			//$_model->setPageId(Mage::helper('core')->jsonDecode($_model->getPageId()));
			$model->setStores(explode(',',$model->getStores()));
		}
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('magicslider_form', array('legend'=>Mage::helper('adminhtml')->__('General Information')));
		
		$fieldset->addField('title', 'text', array(
			'label'     => Mage::helper('adminhtml')->__('Title'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'title',
		));

        $fieldset->addField('identifier', 'text', array(
            'name'      => 'identifier',
            'label'     => Mage::helper('adminhtml')->__('Identifier'),
            'title'     => Mage::helper('adminhtml')->__('Identifier'),
            'required'  => true,
            'class'     => 'validate-xml-identifier',
            'after_element_html' => '<p class="nm"><small>For example: slide-home_1, slide-home_2, slide-left,</small></p>'
        ));

        $fieldset->addField('width', 'text', array(
            'name'      => 'width',
            'label'     => Mage::helper('adminhtml')->__('Width Image'),
            'title'     => Mage::helper('adminhtml')->__('Width Image'),
            'required'  => true,
            'value'     => 1920,
            'class'     => 'validate-greater-than-zero',
        ));

        $fieldset->addField('height', 'text', array(
            'name'      => 'height',
            'label'     => Mage::helper('adminhtml')->__('Height Image'),
            'title'     => Mage::helper('adminhtml')->__('Height Image'),
            'required'  => true,
            'value'     => 900,
            'class'     => 'validate-greater-than-zero',
        ));

		// $fieldset->addField('easing', 'select', array(
		// 	'label'     => Mage::helper('adminhtml')->__('Easing Effect Slide'),
		// 	'name'      => 'easing',
		// 	'values'	=> Mage::getSingleton('magicslider/widget_effect')->toOptionArray(),
		// ));

		$fieldset->addField('controls', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Show Next/Back control:'),
			'title'     => Mage::helper('adminhtml')->__('Show Next/Back control:'),
			'name'      => 'controls',
			'value'     => array(1),
			'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
		));

		$fieldset->addField('pager', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Show Pager control:'),
			'title'     => Mage::helper('adminhtml')->__('Show Pager control:'),
			'name'      => 'pager',
			'value'     => array(1),
			'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
		));

		$fieldset->addField('pause', 'text', array(
			'label'     => Mage::helper('adminhtml')->__('Pause:'),
			'title'     => Mage::helper('adminhtml')->__('Pause:'),
			'name'      => 'pause',
			'class'     => 'validate-greater-than-zero',
		));
		
		$fieldset->addField('speed', 'text', array(
			'label'     => Mage::helper('adminhtml')->__('Speed:'),
			'title'     => Mage::helper('adminhtml')->__('Speed:'),
			'name'      => 'speed',
			'value'     => 1000,
			'class'     => 'validate-greater-than-zero',
		));

		// if (!Mage::app()->isSingleStoreMode()) {
		// 	$field = $fieldset->addField('stores', 'multiselect', array(
		// 		'name'      => 'stores[]',
		// 		'label'     => Mage::helper('cms')->__('Store View'),
		// 		'title'     => Mage::helper('cms')->__('Store View'),
		// 		'required'  => true,			
		// 		'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
		// 		 'value'     => $model->getStores()
		// 		//'value'     => array('0'=>'1','1'=>'2'),	
		// 	));
		// 	$renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
		// 	$field->setRenderer($renderer);
		// }else {
		// 	$fieldset->addField('stores', 'hidden', array(
		// 		'name'      => 'stores[]',
		// 		'value'     => Mage::app()->getStore(true)->getId()
		// 	));
		// 	$model->setStoreId(Mage::app()->getStore(true)->getId());
		// } 
		
		$fieldset->addField('status', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Status'),
			'name'      => 'status',
			'values'    => array(
				array(
				'value'     => 1,
				'label'     => Mage::helper('adminhtml')->__('Enabled'),
				),
				array(
				'value'     => 2,
				'label'     => Mage::helper('adminhtml')->__('Disabled'),
				),
			),
		));
		
		// $fieldset->addField('advanced_settings', 'textarea', array(
		// 	'label'     => Mage::helper('adminhtml')->__('Advanced Settings'),
		// 	'required'  => false,
		// 	'name'      => 'advanced_settings',
		// 	'note'   	=> "Default : {numbers_align: 'right',animation:'fade',interval: 1000,dots: true,navigation: false}"
		// )); 
		
		if (Mage::getSingleton('adminhtml/session')->getMagicsliderData())
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getMagicsliderData());
			Mage::getSingleton('adminhtml/session')->setMagicsliderData(null);
		} elseif ( Mage::registry('magicslider_data') ) {
            $data = Mage::registry('magicslider_data')->getData();
            if($data) $form->setValues($data);
		}
		return parent::_prepareForm();
	}
}

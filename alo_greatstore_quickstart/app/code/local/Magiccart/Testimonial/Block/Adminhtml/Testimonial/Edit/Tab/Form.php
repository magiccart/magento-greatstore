<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-11-12 22:29:09
 * @@Function:
 */
 ?>
<?php

class Magiccart_Testimonial_Block_Adminhtml_Testimonial_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    // protected function _prepareLayout()
    // {
    //     parent::_prepareLayout();
    //     if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
    //         $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
    //     }
    // }

	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('testimonial_form', array(
			'legend'=>Mage::helper('adminhtml')->__('Testimonial information'))
		);

		$fieldset->addField('name', 'text', array(
			'label'     =>Mage::helper('adminhtml')->__('Name'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'name',
		));

		$fieldset->addField('company', 'text', array(
			'label'     =>Mage::helper('adminhtml')->__('Company'),
			// 'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'company',
		));

		$fieldset->addField('website', 'text', array(
			'label'     =>Mage::helper('adminhtml')->__('Website'),
			// 'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'website',
		));

        $fieldset->addField('summary_rating', 'note', array(
            'label'     => Mage::helper('review')->__('Summary Rating'),
            'text'      => $this->getLayout()->createBlock('testimonial/adminhtml_renderer_form_summary')->ratingHtml(),
        ));

        $fieldset->addField('detailed_rating', 'note', array(
            'label'     => Mage::helper('review')->__('Detailed Rating'),
            'text'      => $this->getLayout()->createBlock('testimonial/adminhtml_renderer_form_detailed')->ratingHtml(),
        ));

		$fieldset->addField('image', 'image', array(
		  'label'     =>Mage::helper('adminhtml')->__('Image'),
		  'required'  => true,
		  'name'      => 'image',
		));

		if (!Mage::app()->isSingleStoreMode()) {
		  	$fieldset->addField('stores', 'multiselect', array(
				'name' => 'stores[]',
				'label' => $this->__('Store View'),
				'required' => true,
				'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
		  	));
		}

		$fieldset->addField('text', 'editor', array(
		    'name'      => 'text',
		    'label'     =>Mage::helper('adminhtml')->__('Content'),
		    'title'     =>Mage::helper('adminhtml')->__('Content'),
		    'style'     => 'width:275px; height:200px;',
		    'wysiwyg'   => false,
		    'required'  => true,
		));

		$fieldset->addField('position', 'text', array(
			'label'     =>Mage::helper('adminhtml')->__('Position'),
			'class'     => 'validate-digits',
			'required'  => false,
			'name'      => 'position',
		));

		
		// $fieldset->addField('active_from', 'text', array(
		// 	'label'     =>Mage::helper('adminhtml')->__('Active From'),
		// 	'required'  => false,
		// 	'name'      => 'active_from',
		// ));

		// $fieldset->addField('active_to', 'text', array(
		// 	'label'     =>Mage::helper('adminhtml')->__('Active To'),
		// 	'required'  => false,
		// 	'name'      => 'active_to',
		// ));
		

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('adminhtml')->__('Status'),
            'name'      => 'status',
            'values'    => Mage::helper('review')->getReviewStatusesOptionArray(),
        ));

		if ( Mage::getSingleton('adminhtml/session')->getTestimonialData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getTestimonialData());
			Mage::getSingleton('adminhtml/session')->setTestimonialData(null);
		} elseif ( Mage::registry('testimonial_data') ) {
			$form->setValues(Mage::registry('testimonial_data')->getData());
		}
		return parent::_prepareForm();
	}
}


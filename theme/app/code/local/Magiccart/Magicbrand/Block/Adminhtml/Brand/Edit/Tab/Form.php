<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 19:52:00
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicbrand_Block_Adminhtml_Brand_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  
  protected function getGeneralCfg($cfg)
  {
     return Mage::helper('magicbrand')->getGeneralCfg($cfg);
  }

  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('brand_form', array('legend'=>Mage::helper('magicbrand')->__('Brand information')));

	    $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('magicbrand')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $cfg = $this->getGeneralCfg('brand');
      $fieldset->addField('brand_attribute', 'hidden', array(
          'label'     => Mage::helper('magicbrand')->__('Brand Attribute'),
          'required'  => false,
          'name'      => 'brand_attribute',
          'values'    => $cfg,
      ))->afterElementHtml = "<script>$('brand_attribute').setValue('$cfg');</script>";

      if($cfg){
          $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $cfg);
          $options = $attribute->getSource()->getAllOptions(true);
          if($options){
            foreach ($options as $option) {
              $brands[$option['value']] = $option['label'];
            }
          }
          if(array_filter($brands)){
            $fieldset->addField('brand', 'select', array(
                'label'     => Mage::helper('magicbrand')->__('Brand'),
                'name'      => 'brand',
                'required'  => true,
                'values'    => $brands,
            ))->afterElementHtml = '<p class="nm"><small>' . "Brand attribute $cfg !" . '</small></p>'
                                  ."<script>$('brand').select('option').each(function (item) {if(item.value == ''){item.text = '-- Select Brand --';}})</script>";
          }
      }

      $fieldset->addField('image', 'image', array(
          'label'     => Mage::helper('magicbrand')->__('Image'),
          'required'  => true,
          'name'      => 'image',
      ));

      $fieldset->addField('url', 'text', array(
          'label'     => Mage::helper('magicbrand')->__('Url'),
          'required'  => false,
          'name'      => 'url',
      ));

      if (!Mage::app()->isSingleStoreMode()) {
          $fieldset->addField('stores', 'multiselect', array(
              'name' => 'stores[]',
              'label' => $this->__('Store View'),
              'required' => true,
              'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
          ));
      }

      $fieldset->addField('order', 'text', array(
          'label'     => Mage::helper('magicbrand')->__('Brand Order'),
          'class'     => 'validate-digits',
          'required'  => false,
          'name'      => 'order',
      ));

	/*
      $fieldset->addField('active_from', 'text', array(
          'label'     => Mage::helper('magicbrand')->__('Active From'),
          'required'  => false,
          'name'      => 'active_from',
      ));

      $fieldset->addField('active_to', 'text', array(
          'label'     => Mage::helper('magicbrand')->__('Active To'),
          'required'  => false,
          'name'      => 'active_to',
      ));
	 */

	    $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('magicbrand')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('magicbrand')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('magicbrand')->__('Disabled'),
              ),
          ),
      ));
     
      // $fieldset->addField('content', 'editor', array(
      //     'name'      => 'content',
      //     'label'     => Mage::helper('magicbrand')->__('Content'),
      //     'title'     => Mage::helper('magicbrand')->__('Content'),
      //     'style'     => 'width:275px; height:200px;',
      //     'wysiwyg'   => false,
      //     'required'  => false,
      // ));
     
      if ( Mage::getSingleton('adminhtml/session')->getBrandData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getBrandData());
          Mage::getSingleton('adminhtml/session')->setBrandData(null);
      } elseif ( Mage::registry('brand_data') ) {
          $form->setValues(Mage::registry('brand_data')->getData());
      }
      return parent::_prepareForm();
  }
}


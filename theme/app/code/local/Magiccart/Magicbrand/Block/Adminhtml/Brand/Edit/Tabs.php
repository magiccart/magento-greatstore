<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 19:51:50
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicbrand_Block_Adminhtml_Brand_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('brand_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('magicbrand')->__('Brand Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('magicbrand')->__('Brand Information'),
          'title'     => Mage::helper('magicbrand')->__('Brand Information'),
          'content'   => $this->getLayout()->createBlock('magicbrand/adminhtml_brand_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}

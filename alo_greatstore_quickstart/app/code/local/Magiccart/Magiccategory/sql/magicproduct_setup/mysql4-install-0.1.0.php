<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2014-08-08 23:39:22
 * @@Function:
 */
?>
<?php
$this->startSetup();
$attribute  = Magiccart_Magiccategory_Helper_Data::FEATURED; // code attribute featured
$featured   = Mage::getModel('eav/entity_attribute')
                ->loadByCode('catalog_product', $attribute);
if(!$featured->getData())
{
    $this->addAttribute('catalog_product', $attribute, array(
            'group'             => 'General',
            'type'              => 'int',
            'backend'           => '',
            'frontend'          => '',
            'label'             => 'Featured product',
            'note'              => 'is Featured',
            'input'             => 'boolean',
            'class'             => '',
            'source'            => '',
            'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,  // 'is_global'  for updateAttribute
            'visible'           => true,
            'required'          => false,
            'user_defined'      => false,
            'default'           => '0',
            'searchable'        => false,
            'filterable'        => false,
            'comparable'        => false,
            'visible_on_front'  => false,
            'unique'            => false,
            'apply_to'          => 'simple,configurable,virtual,bundle,downloadable',
            'is_configurable'   => false,
            'used_in_product_listing' => true
        ));
}

$this->endSetup();

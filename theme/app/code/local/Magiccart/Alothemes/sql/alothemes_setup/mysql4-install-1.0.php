<?php

/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2014-08-08 23:31:28
 * @@Function:
 */
?>
<?php
$this->startSetup();

$this->addAttribute('catalog_category','custom_design_apply',
	array(
            'type'              => 'int',
            'label'             => 'Apply To',
            'frontend'          => '',
            'table'             => '',
            'input'             => 'select',
            'class'             => '',
            'source'            => 'core/design_source_apply',
            'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
            'visible'           => true,
            'required'          => false,
            'user_defined'      => false,
            'default'           => '',
            'searchable'        => false,
            'filterable'        => false,
            'comparable'        => false,
            'visible_on_front'  => false,
            'unique'            => false,
            'group' 			=> 'design',
			'sort'  			=> 20
        )
);

/*
$this->addAttribute('catalog_product', 'magic_featured', array(
        'group'             => 'Magiccart', //'General',
        'type'              => 'varchar',
        'backend'           => '',
        'frontend'          => '',
        'label'             => 'Featured product',
        'note'              => 'is Featured',
        'input'             => 'boolean',
        'class'             => '',
        'source'            => '',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
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

$this->addAttribute('catalog_category', 'magic_featured', array(
        'group'         => 'Magiccart',
        'input'         => 'select',
        'type'          => 'varchar',
        'label'         => 'Featured Category',
        'note'          => "This field set Featured for Category .",
        'backend'       => '',
        'visible'       => 1,
        'required'      => 0,
        'user_defined'  => 1,
        'source'        => 'eav/entity_attribute_source_boolean',
        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    ));
    	
$installer->addAttribute('catalog_category', 'magic_featured', array(
        'group'             => 'Magiccart',
        'label'             => 'Featured Category',
        'note'              => "This field set Featured for Category .",
        'type'              => 'text',
        'input'             => 'textarea',
        'visible'           => true,
        'required'          => false,
        'backend'           => '',
        'frontend'          => '',
        'searchable'        => false,
        'filterable'        => false,
        'comparable'        => false,
        'user_defined'      => true,
        'visible_on_front'  => true,
        'wysiwyg_enabled'   => true,
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'is_html_allowed_on_front'  => true,
    ));
*/
$this->endSetup();

<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-14 12:13:45
 * @@Function:
 */
 ?>
<?php
$setup = $this;
$setup->startSetup();
$setup->run("
    -- DROP TABLE IF EXISTS {$this->getTable('magiccart_magicmenu')};
    CREATE TABLE {$this->getTable('magiccart_magicmenu')} (
        `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `cat_id` varchar(255) DEFAULT '' COMMENT 'Not unsigned',
        `cat_columns` varchar(255) DEFAULT '' COMMENT 'Not unsigned',
        `cat_proportions` varchar(255) DEFAULT '' COMMENT 'Not unsigned',
        `short_desc` varchar(255) NOT NULL DEFAULT '',
        `extra` smallint(6) NOT NULL DEFAULT '0' COMMENT 'is Extra Category',
        `name` varchar(255) NOT NULL DEFAULT ''  COMMENT 'Name for Extra Category',
        `magic_label` varchar(255)   DEFAULT ''  COMMENT 'Label for Extra Category',
        `link` varchar(255) NOT NULL DEFAULT '#' COMMENT 'Link for Extra Category',
        `ext_content` text           DEFAULT ''  COMMENT 'Content for Extra Category',
        `top` varchar(255) NOT NULL DEFAULT '',
        `right` varchar(255) NOT NULL DEFAULT '',
        `right_proportions` varchar(255) DEFAULT '' COMMENT 'Not unsigned',
        `bottom` varchar(255) NOT NULL DEFAULT '',
        `left` varchar(255) NOT NULL DEFAULT '',
        `left_proportions` varchar(255) DEFAULT '' COMMENT 'Not unsigned',
        -- `width` int(11) unsigned DEFAULT NULL,
        -- `height` int(11) unsigned DEFAULT NULL,
        `stores` varchar(255)NOT NULL DEFAULT '0',
        `order` int(11) NOT NULL DEFAULT '0',
        `status` smallint(6) NOT NULL DEFAULT '0',
        -- `active_from` datetime DEFAULT NULL,
        -- `active_to` datetime DEFAULT NULL,
        -- `created_time` datetime DEFAULT NULL,
        -- `update_time` datetime DEFAULT NULL,
        PRIMARY KEY (`menu_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

//*
$setup->addAttribute('catalog_category', 'magic_label', array(
    'group'                    => 'Magiccart',
    'label'                    => 'Category Label',
    'note'                     => "Example: New,Hot,... use in Magicmenu",
    'input'                    => 'text',
    'type'                     => 'varchar',
    'backend'                  => 'catalog/category_attribute_backend_image',
    'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'                  => true,
    'required'                 => false,
    'user_defined'             => true,
    'order'                    => 10
));
$setup->addAttribute('catalog_category', 'short_desc', array(
    'group'                    => 'Magiccart',
    'label'                    => 'Short Description',
    'note'                     => 'Example: "Sale off 20%" (less than 20 characters)',
    'input'                    => 'text',
    'type'                     => 'varchar',
    'backend'                  => 'catalog/category_attribute_backend_image',
    'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'                  => true,
    'required'                 => false,
    'user_defined'             => true,
    'order'                    => 15
));
$setup->addAttribute('catalog_category', 'magic_image', array(
    'group'                    => 'Magiccart',
    'label'                    => 'Cat Image',
    'note'                     => "Use for in Module related of Magiccart",
    'input'                    => 'image',
    'type'                     => 'varchar',
    'backend'                  => 'catalog/category_attribute_backend_image',
    'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'                  => true,
    'required'                 => false,
    'user_defined'             => true,
    'order'                    => 20
));
$setup->addAttribute('catalog_category', 'magic_thumbnail', array(
    'group'                    => 'Magiccart',
    'label'                    => 'Cat Thumbnail',
    'note'                     => "Use for in Module related of Magiccart",
    'input'                    => 'image',
    'type'                     => 'varchar',
    'backend'                  => 'catalog/category_attribute_backend_image',
    'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'                  => true,
    'required'                 => false,
    'user_defined'             => true,
    'order'                    => 30
));
//*/
$setup->endSetup();


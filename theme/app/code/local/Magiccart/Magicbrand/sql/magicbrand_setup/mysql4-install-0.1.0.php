<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 19:48:49
 * @@Function:
 */
 ?>
<?php
$this->startSetup();
$this->run("
	-- DROP TABLE IF EXISTS {$this->getTable('magiccart_magicbrand')};
	CREATE TABLE {$this->getTable('magiccart_magicbrand')} (
	  `brand_id` int(11) unsigned NOT NULL auto_increment,
	  `title` varchar(255) NOT NULL default '',
	  `brand_attribute` varchar(255) NOT NULL default '',
	  `brand` int(11) unsigned NOT NULL,
	  `image` varchar(255) NOT NULL DEFAULT '',
	  `thumbnail` varchar(255) NOT NULL,
	  `stores` varchar(255) NOT NULL DEFAULT '0',
	  `content` text NULL default '',
	  `url` varchar(512) NOT NULL DEFAULT '#',
	  `status` smallint(6) NOT NULL default '0',
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  `order` int(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`brand_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
");
$this->endSetup(); 


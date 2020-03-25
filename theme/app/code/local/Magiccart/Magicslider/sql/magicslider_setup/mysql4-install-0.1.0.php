<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-23 17:10:17
 * @@Function:
 */
?>

<?php
$this->run("
	-- DROP TABLE IF EXISTS {$this->getTable('magicslider/magicslider')};
	CREATE TABLE {$this->getTable('magicslider/magicslider')} (
	 	`slide_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		`identifier` VARCHAR(225) NOT NULL,
		`title` VARCHAR(255) NOT NULL DEFAULT '',
		`content` TEXT NOT NULL,
		`config` TEXT NOT NULL,
		-- `stores` TEXT NULL,
		`status` SMALLINT(6) NOT NULL DEFAULT '0',
		`created_time` DATETIME NULL DEFAULT NULL,
		`update_time` DATETIME NULL DEFAULT NULL,
		-- `height` INT(50) NULL DEFAULT '300',
		-- `width` INT(50) NULL DEFAULT '685',
		-- `page_id` TEXT NULL,
		-- `category_id` TEXT NULL,
		-- `position` VARCHAR(128) NULL DEFAULT '',
		-- `advanced_settings` TEXT NULL DEFAULT '',
		PRIMARY KEY (`slide_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$this->endSetup(); 

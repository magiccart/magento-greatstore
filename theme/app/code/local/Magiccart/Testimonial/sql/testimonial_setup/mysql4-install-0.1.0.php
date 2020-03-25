<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-08-07 00:04:29
 * @@Function:
 */
 ?>
<?php
$this->startSetup();
$this->run("
        -- DROP TABLE IF EXISTS {$this->getTable('magiccart_testimonial')};
        CREATE TABLE {$this->getTable('magiccart_testimonial')} (
        testimonial_id int(11) unsigned NOT NULL auto_increment,
        name varchar(50) NOT NULL default '',
        text text NOT NULL default '',
        image varchar(128) default NULL,
        stores varchar(255) NOT NULL DEFAULT '0',
        sidebar tinyint(4) NOT NULL default 2,
        company varchar(50) NOT NULL default '',
        email varchar(50) NOT NULL default '',
        website varchar(50) NOT NULL default '',
        status tinyint(4) NOT NULL default 3,
        created_time datetime NULL,
        update_time datetime NULL,
        rating_summary tinyint(4) NOT NULL default 0,
        position int(11) default 0,
        PRIMARY KEY(testimonial_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
");
$this->endSetup(); 


<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
try {
    $installer->run("
        CREATE TABLE IF NOT EXISTS {$this->getTable('blog/tag')} (
            `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `tag` VARCHAR( 255 ) NOT NULL ,
            `tag_count` INT( 11 ) NOT NULL DEFAULT '0',
            `store_id` TINYINT( 4 ) NOT NULL ,
            INDEX (`tag`, `tag_count`, `store_id`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
    ");
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();

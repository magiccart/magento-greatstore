<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
try {
    $installer->run("

        -- DROP TABLE IF EXISTS {$this->getTable('blog/blog')};
        CREATE TABLE IF NOT EXISTS {$this->getTable('blog/blog')} (
            `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL DEFAULT '',
            `image` varchar(255) DEFAULT '',
            `post_content` text NOT NULL,
            `status` smallint(6) NOT NULL DEFAULT '0',
            `created_time` datetime DEFAULT NULL,
            `update_time` datetime DEFAULT NULL,
            `identifier` varchar(255) NOT NULL DEFAULT '',
            `user` varchar(255) NOT NULL DEFAULT '',
            `update_user` varchar(255) NOT NULL DEFAULT '',
            `meta_keywords` text NOT NULL,
            `meta_description` text NOT NULL,
            `comments` tinyint(11) NOT NULL,
            `tags` text NOT NULL,
            `short_content` text NOT NULL,
            PRIMARY KEY (`post_id`),
            UNIQUE KEY `identifier` (`identifier`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;

        INSERT INTO {$this->getTable('blog/blog')} VALUES (NULL,'Hello World','','Welcome to Magento Blog. This is your first post. Edit or delete it, then start blogging!', 1,'2014-09-06 07:28:34','2014-09-11 16:43:55','Hello','Joe Blogs','Joe Blogs','Keywords','Description',0,'','');


        -- DROP TABLE IF EXISTS {$this->getTable('blog/cat')};
        CREATE TABLE IF NOT EXISTS {$this->getTable('blog/cat')} (
            `cat_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL DEFAULT '',
            `identifier` varchar(255) NOT NULL DEFAULT '',
            `sort_order` tinyint(6) NOT NULL,
            `meta_keywords` text NOT NULL,
            `meta_description` text NOT NULL,
            PRIMARY KEY (`cat_id`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;

        INSERT INTO {$this->getTable('blog/cat')} (`cat_id`, `title`, `identifier`) VALUES (NULL, 'News', 'news');


        -- DROP TABLE IF EXISTS {$this->getTable('blog/cat_store')};
        CREATE TABLE IF NOT EXISTS {$this->getTable('blog/cat_store')} (
            `cat_id` smallint(6) unsigned DEFAULT NULL,
            `store_id` smallint(6) unsigned DEFAULT NULL
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;


        -- DROP TABLE IF EXISTS {$this->getTable('blog/comment')};
        CREATE TABLE IF NOT EXISTS {$this->getTable('blog/comment')} (
            `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `post_id` smallint(11) NOT NULL DEFAULT '0',
            `comment` text NOT NULL,
            `status` smallint(6) NOT NULL DEFAULT '0',
            `created_time` datetime DEFAULT NULL,
            `user` varchar(255) NOT NULL DEFAULT '',
            `email` varchar(255) NOT NULL DEFAULT '',
            PRIMARY KEY (`comment_id`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;

        INSERT INTO {$this->getTable('blog/comment')} (`comment_id` ,`post_id` ,`comment` ,`status` ,`created_time` ,`user` ,`email`)
        VALUES (NULL , '1', 'This is the first comment. It can be edited, deleted or set to unapproved so it is not displayed. This can be done in the admin panel.', '2', NOW( ) , 'Joe Blogs', 'joe@blogs.com');


        -- DROP TABLE IF EXISTS {$this->getTable('blog/post_cat')};
        CREATE TABLE IF NOT EXISTS {$this->getTable('blog/post_cat')} (
            `cat_id` smallint(6) unsigned DEFAULT NULL,
            `post_id` smallint(6) unsigned DEFAULT NULL
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;


        -- DROP TABLE IF EXISTS {$this->getTable('blog/store')};
        CREATE TABLE IF NOT EXISTS {$this->getTable('blog/store')} (
            `post_id` smallint(6) unsigned DEFAULT NULL,
            `store_id` smallint(6) unsigned DEFAULT NULL
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;


        -- DROP TABLE IF EXISTS {$this->getTable('blog/store')};
        CREATE TABLE IF NOT EXISTS {$this->getTable('blog/store')} (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `tag` varchar(255) NOT NULL,
            `tag_count` int(11) NOT NULL DEFAULT '0',
            `store_id` tinyint(4) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `tag` (`tag`,`tag_count`,`store_id`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;

    ");
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();

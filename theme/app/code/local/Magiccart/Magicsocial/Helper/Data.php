<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-15 20:37:16
 * @@Modify Date: 2014-07-18 21:46:54
 * @@Function:
 */

class Magiccart_Magicsocial_Helper_Data extends Mage_Core_Helper_Abstract
{

    const SECTIONS      = 'magicsocial';   // module name
    const GROUPS        = 'general';       // setup general
    const GROUPS_PLUS   = 'social';        // custom group
    const FACEBOOK      = 'facebook';
    const TWITTER       = 'twitter';
    
    public function getGeneralCfg($cfg=null) 
    {
        $config = Mage::getStoreConfig(self::SECTIONS.'/'.self::GROUPS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

    public function getSocialCfg($cfg=null)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_PLUS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

    public function getFacebookCfg($cfg=null)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::FACEBOOK);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;        
    }

    public function getTwitterCfg($cfg=null)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::TWITTER);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;        
    }

}

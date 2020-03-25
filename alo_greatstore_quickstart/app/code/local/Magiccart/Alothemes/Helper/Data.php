<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-07 12:27:23
 * @@Modify Date: 2014-08-08 23:32:51
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Helper_Data extends Mage_Core_Helper_Abstract
{

    const SECTIONS      = 'alothemes';      // module name
    const GROUPS_GENERAL= 'general';    // setup general
    const GROUPS_PRODUCT= 'product';
    const GROUPS_LIST   = 'list';
    const GROUPS_DETAIL = 'detail';
    const GROUPS_COLOR  = 'color';
    const GROUPS_FONT   = 'font';

    public function getConfig($group=NULL)
    {
        /*$path = self::SECTIONS; if($group) $path .='/'.$group;
        return $config = Mage::getStoreConfig($path);*/
        if(!$group) return Mage::getStoreConfig(self::SECTIONS);
        return Mage::getStoreConfig(self::SECTIONS.'/'.$group);
    }

    public function getGeneralCfg($cfg) 
    {
        $config = Mage::getStoreConfig(self::SECTIONS.'/'.self::GROUPS_GENERAL);
        if(isset($config[$cfg])) return $config[$cfg];
    }

    public function getProductCfg($cfg)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_PRODUCT);
        if(isset($config[$cfg])) return $config[$cfg];
    }

    public function getListCfg($cfg)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_LIST);
        if(isset($config[$cfg])) return $config[$cfg];
    }

    public function getDetailCfg($cfg=null)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_DETAIL);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

    public function getColorCfg($cfg)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_COLOR);
        if(isset($config[$cfg])) return $config[$cfg];
    }

    public function getFontCfg($cfg)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_FONT);
        if(isset($config[$cfg])) return $config[$cfg];
    }

}


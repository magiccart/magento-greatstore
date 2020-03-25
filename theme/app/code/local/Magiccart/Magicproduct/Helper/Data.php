<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2014-08-22 14:50:27
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Helper_Data extends Mage_Core_Helper_Abstract
{

    const SECTIONS      = 'magicproduct';   // module name
    const GROUPS        = 'general';        // setup general
    const GROUPS_PLUS   = 'product';        // custom group
    const FEATURED      = 'featured';       // attribute featured
    
    public function getGeneralCfg($cfg=null) 
    {
        $config = Mage::getStoreConfig(self::SECTIONS.'/'.self::GROUPS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

    public function getProductCfg($cfg=null)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_PLUS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

}


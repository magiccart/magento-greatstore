<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 15:04:15
 * @@Modify Date: 2015-02-04 18:16:17
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Helper_Data extends Mage_Core_Helper_Abstract
{
    const SECTIONS      = 'magicinstall';   // module name
    const GROUPS        = 'general';        // setup general
    const IMPORT        = 'import';        // setup general

    public function getConfig($cfg=null) 
    {
        $config = Mage::getStoreConfig(self::SECTIONS.'/'.self::GROUPS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

    public function getStoreActiveTheme()
    {
        $package = $this->getConfig('package');
        $theme 	 = $this->getConfig('theme');
        $home 	 = $this->getConfig('cms_home_page');
        $stores  = Mage::app()->getStores();
        $storeIds = array();
        foreach ($stores as $_store) {
           	$packageCfg = Mage::getStoreConfig('design/package/name', $_store); 
           	$themeCfg = Mage::getStoreConfig('design/theme/default', $_store); 
           	$homeCfg = Mage::getStoreConfig('web/default/cms_home_page', $_store); 
           	if($packageCfg == $package && $themeCfg == $theme && $homeCfg == $home) $storeIds[] = $_store->getId();
        }
        return $storeIds;
    }

}


<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-14 12:17:17
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicmenu_Helper_Data extends Mage_Core_Helper_Abstract
{

    // Define atribute
    const CAT_LABEL     = 'magic_label';        // attribute label
    const IMAGE         = 'magic_image';        // attribute image
    const THUMBNAIL     = 'magic_thumbnail';    // attribute thumbnail
    const SHORT_DESC    = 'short_desc';         // attribute short description
    // End define atribute

    const SECTIONS      = 'magicmenu';          // module name
    const GROUPS        = 'general';            // setup general

    public function getConfig()
    {
    	$config = Mage::getStoreConfig(self::SECTIONS);
        return $config;
    }

    public function getGeneralCfg($cfg=null) 
    {
        $config = Mage::getStoreConfig(self::SECTIONS.'/'.self::GROUPS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }		
}


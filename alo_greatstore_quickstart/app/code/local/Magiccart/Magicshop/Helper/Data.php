<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-26 13:44:47
 * @@Modify Date: 2014-10-25 23:03:10
 * @@Function:
 */
?>
<?php
class Magiccart_Magicshop_Helper_Data extends Mage_Core_Helper_Abstract
{
    const SECTIONS      = 'magicshop';   // module name
    const GROUPS        = 'general';        // setup general
    const GROUPS_PLUS   = 'quickview';        // custom group
    
    public function getGeneralCfg($cfg=null) 
    {
        $config = Mage::getStoreConfig(self::SECTIONS.'/'.self::GROUPS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

    public function getQuickviewCfg($cfg=null)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_PLUS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

    public function jsParam($obj)
    {
        $param = array(
            'url'                  =>  $obj->getSendUrl(),
            'updateUrl'            =>  $obj->getUpdateUrl(),
            'src_image_progress'   =>  $obj->getSkinUrl('magiccart/magicshop/images/loading.gif'),
            'error'                =>  $this->__(' ↑ This is a required field.'),
            'isProductView'        =>  Mage::registry('current_product') ? 1 : 0
        );
        if(Mage::registry('current_product')) $param['product_id'] = Mage::registry('current_product')->getId();
        
        return Zend_Json::encode($param);
    }
}

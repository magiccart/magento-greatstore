<?php
/**
 * Magiccart
 * @category     Magiccart
 * @copyright   Copyright (c) 2014 ALO (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-06-05 20:29:22
 * @@Modify Date: 2015-02-12 21:41:57
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Helper_Timer extends Mage_Core_Helper_Abstract
{
    protected $_config = array();

    public function getConfig($cfg = null)
    {
        if (!$this->_config) $this->_config = Mage::getStoreConfig('alothemes/timer'); 
        if (isset($this->_config[$cfg]) ) return $this->_config[$cfg];
        // return $this->_config;
    }

    public function getTimer($product, $num)
    {
        return $this->getLayout()
        			->createBlock('core/template')
        			->setNum($num)
					->setProduct($product)
					->setTemplate('magiccart/alothemes/timer/timer.phtml')
					->toHtml();
    }

}


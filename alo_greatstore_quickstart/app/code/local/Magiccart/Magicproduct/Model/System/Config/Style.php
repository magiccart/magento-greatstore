<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-03-13 23:15:05
 * @@Modify Date: 2014-08-07 22:21:05
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Model_System_Config_Style
{
    
    const TABTOP = 'tabtop';
    const TABBOTTOM = 'tabbottom';
    
    public function toOptionArray()
    {
        return array(
            array('value' => self::TABTOP, 'label'=>Mage::helper('adminhtml')->__('Tab on Top')),
            array('value' => self::TABBOTTOM, 'label'=>Mage::helper('adminhtml')->__('Tab down Bottom')),
        );
    }
}

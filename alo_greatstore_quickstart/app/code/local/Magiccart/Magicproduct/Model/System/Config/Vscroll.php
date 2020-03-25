<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-08-07 22:10:30
 * @@Modify Date: 2014-08-07 23:04:23
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Model_System_Config_Vscroll
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'top',     'label'=>Mage::helper('adminhtml')->__('Srcoll Top')),
            array('value' => 'bottom',  'label'=>Mage::helper('adminhtml')->__('Srcoll Bottom')),
        );
    }
}

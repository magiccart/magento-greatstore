<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-08-07 22:10:30
 * @@Modify Date: 2014-10-16 08:57:08
 * @@Function:
 */
?>
<?php
class Magiccart_Blog_Model_System_Config_Column
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1,   'label'=>Mage::helper('adminhtml')->__('1 item per column')),
            array('value' => 2,   'label'=>Mage::helper('adminhtml')->__('2 items per column')),
            array('value' => 3,   'label'=>Mage::helper('adminhtml')->__('3 items per column')),
            array('value' => 4,   'label'=>Mage::helper('adminhtml')->__('4 items per column')),
            array('value' => 5,   'label'=>Mage::helper('adminhtml')->__('5 items per column')),
            array('value' => 6,   'label'=>Mage::helper('adminhtml')->__('6 items per column')),
            array('value' => 7,   'label'=>Mage::helper('adminhtml')->__('7 items per column')),
            array('value' => 8,   'label'=>Mage::helper('adminhtml')->__('8 items per column')),
            array('value' => 9,   'label'=>Mage::helper('adminhtml')->__('9 items per column')),
            array('value' => 10,  'label'=>Mage::helper('adminhtml')->__('10 items per column')),
        );
    }
}

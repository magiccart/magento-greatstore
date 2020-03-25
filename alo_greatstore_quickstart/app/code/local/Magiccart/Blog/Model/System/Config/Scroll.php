<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-08-07 22:10:30
 * @@Modify Date: 2014-10-16 08:57:27
 * @@Function:
 */
?>
<?php
class Magiccart_Blog_Model_System_Config_Scroll
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'left',    'label'=>Mage::helper('adminhtml')->__('Scroll Left')),
            array('value' => 'right',   'label'=>Mage::helper('adminhtml')->__('Scroll Right')),
            array('value' => 'top',     'label'=>Mage::helper('adminhtml')->__('Scroll Top')),
            array('value' => 'bottom',  'label'=>Mage::helper('adminhtml')->__('Scroll Bottom')),
        );
    }
}

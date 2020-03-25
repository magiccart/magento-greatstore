<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-07 12:27:23
 * @@Modify Date: 2014-08-08 23:32:18
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Model_System_Config_Source_Tab
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'box-description', 'label'=>Mage::helper('adminhtml')->__('Description')),
            array('value'=>'box-additional', 'label'=>Mage::helper('adminhtml')->__('Additional')),
            array('value'=>'box-up-sell', 'label'=>Mage::helper('adminhtml')->__('Up-Sell')),
            array('value'=>'box-tags', 'label'=>Mage::helper('adminhtml')->__('Product Tags')),
        );
    }

}

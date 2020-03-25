<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-15 20:37:16
 * @@Modify Date: 2014-07-16 13:04:28
 * @@Function:
 */

class Magiccart_Magicsocial_Model_System_Config_Source_Effect
{

    public function toOptionArray()
    {
        return array(
            array('value' => 'swing', 'label'=>Mage::helper('adminhtml')->__('swing')),
            array('value' => 'easeOutQuad', 'label'=>Mage::helper('adminhtml')->__('easeOutQuad')),
            array('value' => 'easeOutCirc', 'label'=>Mage::helper('adminhtml')->__('easeOutCirc')),
            array('value' => 'easeOutElastic', 'label'=>Mage::helper('adminhtml')->__('easeOutElastic')),
            array('value' => 'easeOutExpo', 'label'=>Mage::helper('adminhtml')->__('easeOutExpo')),
        );
    }

}

<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-06 12:56:09
 * @@Modify Date: 2014-06-03 09:33:03
 * @@Function:
 */
class Magiccart_Alothemes_Model_System_Config_Source_Design_Font_Size
{
    public function toOptionArray()
    {
		return array(
			array('value' => '12px',	'label' => Mage::helper('adminhtml')->__('12 px')),
			array('value' => '13px',	'label' => Mage::helper('adminhtml')->__('13 px')),
            array('value' => '14px',	'label' => Mage::helper('adminhtml')->__('14 px')),
            array('value' => '16px',	'label' => Mage::helper('adminhtml')->__('16 px'))
        );
    }
}


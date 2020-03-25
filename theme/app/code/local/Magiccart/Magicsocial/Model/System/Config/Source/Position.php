<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-15 20:37:16
 * @@Modify Date: 2014-07-23 15:02:46
 * @@Function:
 */
class Magiccart_Magicsocial_Model_System_Config_Source_Position
{

    public function toOptionArray()
    {
        return array(
            array('value' => 'left', 'label'=>Mage::helper('adminhtml')->__('Left')),
            array('value' => 'right', 'label'=>Mage::helper('adminhtml')->__('Right')),		
        );
    }

}

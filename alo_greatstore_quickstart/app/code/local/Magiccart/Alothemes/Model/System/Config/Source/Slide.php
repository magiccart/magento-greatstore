<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-07 12:27:23
 * @@Modify Date: 2014-08-08 23:32:27
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Model_System_Config_Source_Slide
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'', 'label'=>Mage::helper('adminhtml')->__('None Slider')),
            array('value'=>'horizontal', 'label'=>Mage::helper('adminhtml')->__('Horizontal Slider')),
            array('value'=>'vertical', 'label'=>Mage::helper('adminhtml')->__('Vertical Slider')),
        );
    }

}

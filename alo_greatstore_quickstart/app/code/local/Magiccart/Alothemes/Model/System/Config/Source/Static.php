<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-07 12:27:23
 * @@Modify Date: 2015-04-22 10:49:22
 * @@Function:
 */

class Magiccart_Alothemes_Model_System_Config_Source_Static
{
    public function toOptionArray()
    {
        $collection = Mage::getModel('cms/block')->getCollection()
                    ->addFieldToFilter('identifier', array('like'=>'home_static_%'))
                    ->addFieldToFilter('is_active', 1);
        $options = array();
        foreach($collection as $block){
            $options[] = array('value'=>$block->getIdentifier(), 'label'=>Mage::helper('adminhtml')->__($block->getTitle()));
        }
        return $options;
    }

}

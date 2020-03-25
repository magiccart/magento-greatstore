<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart <team.magiccart@gmail.com>
 * @@Create Date: 2014-10-07 08:20:08
 * @@Modify Date: 2014-12-15 23:32:05
 * @@Function:
 */
?>
<?php

class Magiccart_Magicslider_Model_Widget_Effect
{

    public function toOptionArray()
    {
		$optionTxt = array(
		    // 'random',
		    'easeOutQuad',
		    'easeInQuad',
		    'easeInOutQuad',
		    'easeInCubic',
		    'easeOutCubic',
		    'easeInOutCubic',
		    'easeInQuart',
		    'easeOutQuart',
		    'easeInOutQuart',
		    'easeInQuint',
		    'easeOutQuint',
		    'easeInOutQuint',
		    'easeInSine',
		    'easeOutSine',
		    'easeInOutSine',
		    'easeInExpo',
		    'easeOutExpo',
		    'easeInOutExpo',
		    'easeInCirc',
		    'easeOutCirc',
		    'easeInOutCirc',
		    'easeInElastic',
		    'easeOutElastic',
		    'easeInOutElastic',
		    'easeInBack',
		    'easeOutBack',
		    'easeInOutBack',
		    'easeInBounce',
		    'easeOutBounce',
		    'easeInOutBounce',
		);
		$options = array();
		foreach ($optionTxt as $value) {
		    $options[] = array('value' => $value, 'label'=>Mage::helper('adminhtml')->__($value));
		}
		return $options;
    }
}


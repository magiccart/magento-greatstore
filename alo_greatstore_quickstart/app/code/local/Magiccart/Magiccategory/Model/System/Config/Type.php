<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-03-13 23:15:05
 * @@Modify Date: 2014-11-04 14:06:22
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_Model_System_Config_Type
{
    
    const BEST 		 = 'bestseller';
    const FEATURED 	 = 'featured';
    const LATEST     = 'latest';
    const MOSTVIEWED = 'mostviewed';
    const NEWPRODUCT = 'newproduct';
    const RANDOM 	 = 'random';
    const REVIEW     = 'review';
    const SALE 	     = 'saleproduct';
    const SPECIAL 	 = 'specialproduct';

    public function toOptionArray()
    {
        return array(
            array('value' => self::BEST, 	 	'label'=>Mage::helper('adminhtml')->__('Bestseller')),
            array('value' => self::FEATURED,    'label'=>Mage::helper('adminhtml')->__('Featured Products')),
            array('value' => self::LATEST,   	'label'=>Mage::helper('adminhtml')->__('Latest Products')),
            array('value' => self::MOSTVIEWED, 	'label'=>Mage::helper('adminhtml')->__('Most Viewed')),
            // mostviewed <=> popular
            //array('value' => 'popular', 'label'=>Mage::helper('adminhtml')->__('Popular Product')),
            array('value' => self::NEWPRODUCT, 	'label'=>Mage::helper('adminhtml')->__('New Products')),
            //newproduct <=> Recently Added
            //array('value' => 'recentlyadded', 'label'=>Mage::helper('adminhtml')->__('Recently Added')),
            array('value' => self::RANDOM,      'label'=>Mage::helper('adminhtml')->__('Random Products')),
            // array('value' => self::REVIEW, 		'label'=>Mage::helper('adminhtml')->__('Review Products')),
            array('value' => self::SALE, 		'label'=>Mage::helper('adminhtml')->__('Sale Products')),
            //specialproduct => saleproduct
            //array('value' => self::SPECIAL, 	'label'=>Mage::helper('adminhtml')->__('Special Products'))
        );
    }
}

<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-07 12:27:23
 * @@Modify Date: 2015-11-17 11:30:30
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Model_System_Config_Source_Action
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'cart', 'label'=>Mage::helper('adminhtml')->__('Add to Cart')),
            array('value'=>'compare', 'label'=>Mage::helper('adminhtml')->__('Add to Compare')),
            array('value'=>'wishlist', 'label'=>Mage::helper('adminhtml')->__('Ad to Wishlist')),
            // array('value'=>'quickview', 'label'=>Mage::helper('adminhtml')->__('Quick View')),
            array('value'=>'review', 'label'=>Mage::helper('adminhtml')->__('Review')),
        );
    }

}

<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-03-13 23:15:05
 * @@Modify Date: 2014-08-07 22:20:17
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_Model_System_Config_Sort
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'ASC', 'label'=>Mage::helper('adminhtml')->__('Ascending')),
            array('value'=>'DESC', 'label'=>Mage::helper('adminhtml')->__('Descending'))
        );
    }

}

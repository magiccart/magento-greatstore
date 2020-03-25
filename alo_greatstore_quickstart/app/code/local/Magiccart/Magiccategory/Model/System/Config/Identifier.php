<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-03-13 23:15:05
 * @@Modify Date: 2015-04-19 11:52:49
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_Model_System_Config_Identifier
{

    public function toOptionArray()
    {
		$Identifiers = Mage::getStoreConfig('magiccategory/identifier');
		$options = array();
		foreach ($Identifiers as $id => $value) {
			$tmp = unserialize($value);
			$options[] = array('value'=>$id, 'label'=>Mage::helper('adminhtml')->__($tmp['title']));
		}
        return $options;
    }

}

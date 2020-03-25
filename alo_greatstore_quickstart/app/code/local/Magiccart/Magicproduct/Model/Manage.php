<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-17 19:19:34
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Model_Manage extends Varien_Data_Collection
{
	public function __construct()
	{
		// $widgets = Mage::getStoreConfig('magicproduct/identifier');
		$widgets = Mage::getModel('core/config_data')->getCollection()
							->addFieldToFilter('path', array('like' => 'magicproduct/identifier/%'));
		if($widgets){
			foreach ($widgets as $widget) {
				$widget->addData(unserialize($widget->getValue()));
				$this->addItem($widget);
			}
		}
	}


	public function getCollection() 
	{
		return $this;
	}

    // public function load($id=0, $field=null)
    // {
    //     return $this->getCollection()->getItemById($id);
    // }
}

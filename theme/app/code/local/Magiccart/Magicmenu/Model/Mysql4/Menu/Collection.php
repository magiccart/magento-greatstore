<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-05 11:24:01
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicmenu_Model_Mysql4_Menu_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('magicmenu/menu');
	}
}


<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-05 11:23:55
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicmenu_Model_Mysql4_Menu extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('magicmenu/menu', 'menu_id');
	}
}


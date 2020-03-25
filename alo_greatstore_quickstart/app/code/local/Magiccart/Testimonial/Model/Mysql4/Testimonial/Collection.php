<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-30 16:43:53
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Model_Mysql4_Testimonial_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('testimonial/testimonial');
	}
}


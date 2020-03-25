<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-30 16:43:31
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Model_Mysql4_Testimonial extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('testimonial/testimonial', 'testimonial_id');
	}
}


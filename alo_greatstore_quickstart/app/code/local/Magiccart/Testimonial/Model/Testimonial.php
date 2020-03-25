<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-30 16:42:05
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Model_Testimonial extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
        $this->_init('testimonial/testimonial');
	}
}


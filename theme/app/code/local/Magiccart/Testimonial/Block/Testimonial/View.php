<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-09-03 13:17:14
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Block_Testimonial_View extends Magiccart_Testimonial_Block_Testimonial
{

	public function _getTestimonial()
	{
	    $id = $this->getRequest()->getParam('id');
	    $store = Mage::app()->getStore()->getStoreId();
	    $testimonials = Mage::getModel('testimonial/testimonial')
	                    ->getCollection()
	                    ->addFieldToFilter('stores',array(array('like' => '%0%'),array('like' => "%$store%")))
	                    ->addFieldToFilter('testimonial_id', $id)
	                    ->setOrder('position', 'ASC')
	                    ->addFieldToFilter('status', Mage_Review_Model_Review::STATUS_APPROVED);
	    return $testimonials->getFirstItem();
	}
    
}


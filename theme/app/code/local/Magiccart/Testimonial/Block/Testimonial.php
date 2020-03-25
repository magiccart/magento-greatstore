<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2015-03-11 08:25:18
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Block_Testimonial extends Mage_Core_Block_Template
{
	public $config = array();

    protected function _construct()
    {
        parent::_construct();

        $this->config = Mage::helper('testimonial')->getGeneralCfg();
    }

    protected function _getWriteUrl()
    {
        return $this->getUrl('testimonial/index/create');
    }

    protected function _getSubmitUrl()
    {
        return $this->getUrl('testimonial/index/createpost');
    }

	public function getFormUrl() {
		return $this->getUrl('testimonial/index/check');
	}
  
	public function getTestimonials()
	{
	    $store = Mage::app()->getStore()->getStoreId();
	    $testimonials = Mage::getModel('testimonial/testimonial')
	                    ->getCollection()
	                    ->addFieldToFilter('stores',array(array('like' => '0%'),array('like' => "%$store%")))
	                    ->setOrder('position', 'ASC')
	                    ->addFieldToFilter('status', Mage_Review_Model_Review::STATUS_APPROVED);
	    return $testimonials;
	}

	public function getImage($object)
	{
	    $image = Mage::helper('testimonial/image');
	    $width = $this->config['widthImages'];
	    $height= $this->config['heightImages'];
	    $floder = $width.'x'.$height;
	    $image->setFolder($floder);
	    $image->setWidth($width);
	    $image->setHeight($height); 
	    $image->setQuality(100); // not require
	    return $image->init($object, 'image');
	}

}


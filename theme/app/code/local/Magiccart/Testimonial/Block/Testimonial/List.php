<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-08-15 22:20:28
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Block_Testimonial_List extends Magiccart_Testimonial_Block_Testimonial
{

	public function __construct() 
	{
		parent::__construct();
		$this->setTestimonial($this->getTestimonials());
		
	}

	public function _prepareLayout()
	{
		parent::_prepareLayout();
		$this->getLayout()->getBlock('head')->setTitle($this->__('Testimonial'));
		$pager = $this->getLayout()->createBlock('page/html_pager', 'testimonial.pager');
		
        $perPage = $this->config['per_page'];
        $perPage = explode(',', $perPage);
        $perPage = array_combine($perPage, $perPage);
        $pager->setAvailableLimit($perPage);
		$pager->setCollection($this->getTestimonial());
		$this->setChild('pager', $pager);
		$this->getTestimonial()->load();

		return $this;
    }

	public function _getTestimonial()
	{
		return $this->getTestimonial();
	}
    
	public function getPagerHtml() 
	{
		return $this->getChildHtml('pager');
	}

}

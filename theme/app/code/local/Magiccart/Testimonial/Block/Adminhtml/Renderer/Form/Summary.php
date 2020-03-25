<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-31 13:57:43
 * @@Modify Date: 2014-08-06 17:21:43
 * @@Function:
 */
?>
<?php
class Magiccart_Testimonial_Block_Adminhtml_Renderer_Form_Summary extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRating()
    {
		$id = $this->getRequest()->getParam('id');
		
		$resource = Mage::getSingleton('core/resource');
		$connection = $resource->getConnection('core_write');
		$table = $resource->getTableName('testimonial/testimonial');
		// select query
		$where = $connection->quoteInto("testimonial_id = ?", $id);
		$sql = $connection->select()->from($table,array('rating_summary'))->where($where);
		$rating = $connection->fetchOne($sql);
		
		return $rating;
    }

    public function ratingHtml()
    {	
		$rating = 0;
		if($this->getRating()) $rating = ceil($this->getRating() * 20);
		$html = '<div class="rating-box">';
		        	$html .= '<div class="rating" style="width:'. $rating .'%;"></div>';			
		$html .= '</div>';
		return $html;
    }

}


<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-31 13:57:43
 * @@Modify Date: 2014-08-06 22:25:03
 * @@Function:
 */
?>
<?php
class Magiccart_Testimonial_Block_Adminhtml_Renderer_Form_Detailed extends Mage_Adminhtml_Block_Template
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
    	$html = '';
		$html .= '<div class="product-review-box">
			        <table cellspacing="0" id="product-review-table">
			            <thead>
			                <tr>';
			                	for ($i=1; $i<=5; $i++) {
			                		$html .= '<th><span class="nobr">'. Mage::helper('rating')->__("$i star") .'</span></th>';
			                	}
		$html .=	   		'</tr>
			            </thead>
			            <tbody>
			                <tr class="odd last">';
			                	$class 		= 'class="first"';
			                	for ($i=1; $i<=5; $i++) {
			                		$checked	= ( $i == $this->getRating()) ? 'checked="checked"' : '';
			                    	$html .= '<td '.$class.'><input type="radio" name="rating_summary" id="rating_' .$i.'" value="'.$i.'" '.$checked.' /></td>';
			                		$class = ($i == 4) ? 'class="last"' : '';
			                	}
		$html .=            '</tr>
			            </tbody>
			        </table>
			    </div>';
		return $html;
    }

}

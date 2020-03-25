<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-31 00:15:17
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Block_Adminhtml_Renderer_Grid_Column_Rating extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $html = '<span class="rating-box">';
        $html .= '<span style="width:'. $row->getData($this->getColumn()->getIndex()) * 20 .'%;" class="rating"></span>';
        $html .= '</span>';
        return $html;
    }
}

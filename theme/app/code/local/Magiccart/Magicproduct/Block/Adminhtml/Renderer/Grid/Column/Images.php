<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2014-03-16 08:40:05
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Block_Adminhtml_Renderer_Grid_Column_Images extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
    
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }
    protected function _getValue(Varien_Object $row)
    {      
        $val = $row->getData($this->getColumn()->getIndex());
        $val = str_replace("no_selection", "", $val);
        $url = Mage::getBaseUrl('media') . 'catalog/product' . $val;
        $out = "<img src=". $url ." width='80px'/>";
        return $out;
    }
}

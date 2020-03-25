<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 20:48:17
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicbrand_Block_Adminhtml_Renderer_Grid_Column_Images extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
    public function render(Varien_Object $row)
    {
        $value  = $row->getData($this->getColumn()->getIndex());  /* ten file */
        Mage::getBaseDir('media') . DS .'magiccart' .DS .'magicbrand' .DS;
        $url = Mage::getBaseUrl('media').$value;
        return "<a href=\"".$url ."\" target=\"_blank\"><img width=80 src=\"".$url."\" /></a>";
    }
}

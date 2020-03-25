<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-26 13:44:47
 * @@Modify Date: 2014-10-25 23:03:15
 * @@Function:
 */
?>
<?php
class Magiccart_Magicshop_Block_Ajaxcart extends Mage_Core_Block_Template
{    
    public function getSendUrl()
    {
        $url = $this->getUrl('magicshop/ajax/index');
        if (isset($_SERVER['HTTPS']) && 'off' != $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "")
        {
            $url = str_replace('http:', 'https:', $url);
        }
        return $url;
    }
    
    public function getUpdateUrl()
    {
        $url = $this->getUrl('checkout/cart/updatePost');
        if (isset($_SERVER['HTTPS']) && 'off' != $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "")
        {
            $url = str_replace('http:', 'https:', $url);
        }
        return $url;
    }
}


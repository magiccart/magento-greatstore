<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2014-09-22 13:25:20
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Model_Mysql4_Magicslider extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('magicslider/magicslider', 'slide_id');
    }
}

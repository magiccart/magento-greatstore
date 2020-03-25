<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2015-04-22 14:56:17
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicmenu_Helper_Image extends Mage_Core_Helper_Abstract
{

    public function getBaseTmpMediaUrl()
    {
        return Mage::getBaseUrl('media') . 'catalog/category/';
    }
    
    public function getBaseTmpMediaPath()
    {
        return Mage::getBaseDir('media') .DS. 'catalog' .DS. 'category' .DS;
    }

    public function resizeImg($fileName,$width,$height=null)
    {
        $imageURL = $this->getBaseTmpMediaUrl() .$fileName;

        $imagePath = $this->getBaseTmpMediaPath() .str_replace('/', DS,$fileName);
        
        $extra =$width . 'x' . $height;
        $newPath = $this->getBaseTmpMediaPath() ."cache".DS.$extra.str_replace('/', DS,$fileName);
        //if width empty then return original size image's URL
        if ($width != '' && $height != '') {
            //if image has already resized then just return URL
            if (file_exists($imagePath) && is_file($imagePath) && !file_exists($newPath)) {
                $imageObj = new Varien_Image($imagePath);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(FALSE);
                $imageObj->keepTransparency(true);
                $imageObj->keepFrame(FALSE);
                $imageObj->quality(100);
                //$width, $height - sizes you need (Note: when keepAspectRatio(TRUE), height would be ignored)
                $imageObj->resize($width, $height);
                $imageObj->save($newPath);
            }
            $resizedURL = $this->getBaseTmpMediaUrl() ."cache".'/'.$extra.'/'.$fileName;
         } else {
            $resizedURL = $imageURL;
         }
         return $resizedURL;
    }

}

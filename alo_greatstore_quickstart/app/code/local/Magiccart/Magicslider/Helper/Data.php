<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-22 14:49:40
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function getBaseTmpMediaUrl()
    {
        return Mage::getBaseUrl('media') . 'magiccart/magicslider/';
    }
	
	public function getBaseTmpMediaPath()
    {
        return Mage::getBaseDir('media') .DS. 'magiccart' .DS. 'magicslider' .DS;
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

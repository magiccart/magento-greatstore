<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-10-23 15:09:49
 * @@Modify Date: 2015-04-22 14:57:02
 * @@Function:
 */
?>
<?php
class Magiccart_Blog_Helper_Images extends Mage_Core_Helper_Abstract
{

	public function resizeImg($fileName,$width,$height=null)
	{
		$baseURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
		$imageURL = $baseURL .'/'.'magiccart/blog'.'/'.$fileName;
		
		$basePath = Mage::getBaseDir('media');
		$imagePath = $basePath.DS.'magiccart/blog/'.str_replace('/', DS,$fileName);
		
		$extra =$width . 'x' . $height;
		$newPath = Mage::getBaseDir('media') . DS .'magiccart/blog'.DS."cache".DS.$extra.'/'.str_replace('/', DS,$fileName);
		//if width empty then return original size image's URL
		if ($width != '' && $height != '') {
			//if image has already cache then just return URL
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
			$cacheURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "magiccart/blog".'/'."cache".'/'.$extra.'/'.$fileName;
		 } else {
			$cacheURL = $imageURL;
		 }
		 return $cacheURL;
	}
	
}

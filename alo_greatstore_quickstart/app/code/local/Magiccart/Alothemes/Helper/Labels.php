<?php
/**
 * Magiccart
 * @category 	 Magiccart
 * @copyright 	Copyright (c) 2014 ALO (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-06-05 20:29:22
 * @@Modify Date: 2015-07-31 15:24:59
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Helper_Labels extends Mage_Core_Helper_Abstract
{	
    const SECTIONS      = 'alothemes';      // module name
    const GROUPS_LABELS   = 'labels';
	protected $labels = false;
	protected $new = 'New';
	protected $sale = 'Sale';

    public function getLabelsCfg($cfg=null)
    {
        $config =  Mage::getStoreConfig(self::SECTIONS .'/'.self::GROUPS_LABELS);
        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }

	public function getLabels($product)
	{
		$html  = '';
		if(!$this->labels) $this->labels = $this->getLabelsCfg();
		$config = $this->labels;

		$showNew = isset($config['newLabel']) ? $config['newLabel'] : true; // get in Cfg;
		if($showNew){
			$isNew = $this->isNew($product);
			if($isNew){
				$label = isset($config['newText']) ? $config['newText'] : $this->new;
				$html .= '<span class="sticker top-left"><span class="labelnew">' . $this->__($label) . '</span></span>';			
			}	
		}
		$showSale = isset($config['saleLabel']) ? $config['saleLabel'] : true; // get in Cfg;
		if($showSale){
			$isSale = $this->isOnSale($product);
			if($isSale){
				$percent = isset($config['salePercent']) ? $config['salePercent'] : false; // get in Cfg;
				if($percent){
					$price = $product->getPrice();
					$finalPrice = $product->getFinalPrice();
					$label = floor(($finalPrice/$price)*100 - 100).'%';
				}else {
					$label = isset($config['saleText']) ? $config['saleText'] : $this->sale;
				}
				$html .= '<span class="sticker top-right"><span class="labelsale">' . $this->__($label) . '</span></span>';
			}
		}
		
		return $html;
	}

	public function isNew($product)
	{
		return $this->_nowIsBetween($product->getData('news_from_date'), $product->getData('news_to_date'));
	}

	public function isOnSale($product)
	{
		$specialPrice = number_format($product->getFinalPrice(), 2);
		$regularPrice = number_format($product->getPrice(), 2);
		
		if ($specialPrice != $regularPrice)
			return $this->_nowIsBetween($product->getData('special_from_date'), $product->getData('special_to_date'));
		else
			return false;
	}
	
	protected function _nowIsBetween($fromDate, $toDate)
	{
		if ($fromDate)
		{
			$fromDate = strtotime($fromDate);
			$toDate = strtotime($toDate);
			$now = strtotime(date("Y-m-d H:i:s"));
			
			if ($toDate)
			{
				if ($fromDate <= $now && $now <= $toDate)
					return true;
			}
			else
			{
				if ($fromDate <= $now)
					return true;
			}
		}
		
		return false;
	}

    public function getImageHover($product)
    {
	    return  $product->load('media_gallery')
	                    ->getMediaGalleryImages()
	                    ->getItemByColumnValue('position','2') //->getItemByColumnValue('label','Imagehover')
	                    ->getFile();
    }

}

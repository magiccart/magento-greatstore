<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2015-11-23 15:17:46
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicbrand_Block_Brand extends Mage_Core_Block_Template
{
	public $config = array();

    protected function _construct()
    {
        parent::_construct();

        $this->config = Mage::helper('magicbrand')->getGeneralCfg();
    }
  
	public function getBrand()
	{
	    $store = Mage::app()->getStore()->getStoreId();
	    $attribute = isset($this->config['brand']) ? trim($this->config['brand']) : '';
        if($attribute){
            $brands = Mage::getModel('magicbrand/brand')->getCollection()
                        ->addFieldToFilter('brand_attribute', $attribute)
                        ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)))
                        ->addFieldToFilter('status', 1);
        }else {
            $brands = Mage::getModel('magicbrand/brand')->getCollection()
                        ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)))
                        ->addFieldToFilter('status', 1);
        }
	    return $brands;
	}

	public function getImage($object)
	{
	    $image = Mage::helper('magicbrand/image');
	    $width = $this->config['widthImages'];
	    $height= $this->config['heightImages'];
	    $floder = $width.'x'.$height;
	    $image->setFolder($floder);
	    $image->setWidth($width);
	    $image->setHeight($height); 
	    $image->setQuality(100); // not require
	    return $image->init($object, 'image');
	}

    public function getDevices()
    { 
        return array('portrait'=>480, 'landscape'=>640, 'tablet'=>768, 'desktop'=>992);
    }

    public function setBxslider()
    {
        $options = array(
            'auto',
            'speed',
            'controls',
            'pager',
            'slideWidth',
        );
        $script = 'moveSlides: 1,';
        foreach ($options as $opt) {
            $cfg  =  $this->config["$opt"];
            $script    .= "$opt: $cfg, ";
        }

        $options2 = array(
            'mode'=>'vertical',
        );
        foreach ($options2 as $key => $value) {
            $cfg  =  $this->config["$value"];
            if($cfg) $script    .= "$key: '$value', ";
        }
        if($this->config['visibleItems']) $script .= 'visibleItems: ' . $this->config['visibleItems'] . ', ';
        $maxSlides = $this->config['visibleItems'] ?  $this->config['visibleItems'] : 1;
        $enableResponsiveBreakpoints = true ;//$this->config['enableResponsiveBreakpoints'] ;
        if($enableResponsiveBreakpoints){
            $script .= 'responsiveBreakpoints: {';
            $responsiveBreakpoints = $this->getDevices();
            foreach ($responsiveBreakpoints as $opt => $screen) {
                $cfg = $this->config[$opt];
                if($cfg) $script .= "$screen : $cfg ,";
                if($cfg > $maxSlides) $maxSlides = $cfg;
            }
            $script .= "},";
        }
        $script .= 'maxSlides: ' . $maxSlides . ', ';
        return $script;

    }

}


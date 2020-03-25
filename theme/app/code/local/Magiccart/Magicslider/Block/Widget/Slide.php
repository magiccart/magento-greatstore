<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-05-04 15:56:43
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Block_Widget_Slide extends Mage_Core_Block_Template
	implements Mage_Widget_Block_Interface
{

	protected $_collection;
	
    protected function _construct()
    {
		$identifier = $this->getData('identifier');
		if($identifier){
			$this->_collection = Mage::getModel('magicslider/magicslider')->getCollection()
		                    ->addFieldToFilter('identifier', $identifier)
		                    ->addFieldToFilter('status', 1);
		}else {
			$this->_collection = Mage::getModel('magicslider/magicslider')->getCollection()
		                    ->addFieldToFilter('status', 1)
							->setPageSize (1);
		}
		$tmp = $this->_collection->getFirstItem()->getData();
		$data = unserialize($tmp['config']);
        $this->addData($data);
        parent::_construct();
    }

	protected function _prepareLayout()
	{
	   	if(Mage::getStoreConfig('magicslider/general/enabled')){
		    $head = $this->getLayout()->getBlock('head')
						->addCss('magiccart/plugin/css/animate.css')
						->addCss('magiccart/plugin/css/jquery.bxslider.css')
						->addCss('magiccart/magicslider/css/magicslider.css')
						->addJs('magiccart/jquery.min.js')
						->addJs('magiccart/jquery.noconflict.js')
						->addJs('magiccart/plugin/jquery.easing.min.js')
						->addJs('magiccart/plugin/jquery.bxslider.js');	   		
	   	}
	    parent::_prepareLayout();
	}
	
	protected function _getCollection() {
		return $this->_collection;		
    }
	
	public function _getMagicsliderImageCollection($magicsliderCollection){
		return $magicsliderCollection->getData();	
	}
	
	public function getSortedImages($content){
		$imagesArray = json_decode($content,true);
		if(isset($imagesArray) && !empty($imagesArray) && count($imagesArray)>0){
			$temp = array();
			foreach($imagesArray as $key=>$image){
				if($image['disabled']){
					unset($imagesArray[$key]);
					continue;
				}
				$temp[$key] = $image['position'];
			}				
			array_multisort($temp, SORT_ASC, $imagesArray);
		}
		return $imagesArray;
	}

	public function getBxslider()
	{

        $options = array(
            'controls',
            'pager',
            'pause',
            'speed',
        );
        $script = '';
        // $script .= 'easing: "'.$this->getData('easing') .'",';
        foreach ($options as $opt) {
            $cfg  =  $this->getData("$opt") ? $this->getData("$opt") : 0;
            $script    .= "$opt: $cfg, ";
        }

        return $script;
	}

	public function generateRandomString($length = 10) {
	    $characters = 'abcdefghijklmnopqrstuvwxyz';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}

}

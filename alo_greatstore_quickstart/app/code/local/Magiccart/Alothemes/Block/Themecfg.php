<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-05 16:23:31
 * @@Modify Date: 2015-09-03 22:29:03
 * @@Function:
 */

class Magiccart_Alothemes_Block_Themecfg extends Mage_Core_Block_Template
{
	public function __construct() {
		parent::__construct();
		$this->setConfig(Mage::helper('alothemes')->getConfig());
		
	}	

	protected function _prepareLayout()
	{
		//die(Mage::app()->getConfig()->getNode()->asXML());
	    //$this->getLayout()->getBlock('head')->removeItem('js', 'prototype/prototype.js');  // remove Javascript
	  
		$skin = Mage::getSingleton('core/design_package')->getSkinBaseDir();
		$exp 	= explode(DS, $skin);
		$count 	= count($exp);
		$package_theme = $exp[$count-2].'/'.$exp[$count-1];
		$cfg = 'abc'; // get in Config
		$expcfg = explode('_', $cfg);
		if($expcfg[0] == $package_theme){
	    	$this->getLayout()->getBlock('head')->addCss($expcfg[1]);
		}
	    parent::_prepareLayout();

	}

	public function getLayoutCfg()
	{
		$cfg = array();
		$cfg['controller'] = $this->getRequest()->getRouteName(). // '-'.$this->getRequest()->getModuleName().
							'/'.$this->getRequest()->getControllerName().
							'/'.$this->getRequest()->getActionName();

		$root = $this->getLayout()->getBlock('root');
		if ($root) {
		    $rootTpl = $root->getTemplate(); // For core/design_package calculated if absolute path use getTemplateFile();
		    switch ($rootTpl) {
		        case 'page/1column.phtml':
		            $cfg['page'] = 'page/1column.phtml';
		            break;		        
		        case 'page/2columns-left.phtml':
		            $cfg['page'] = 'page/2columns-left.phtml';
		            break;		        
		        case 'page/2columns-right.phtml':
		            $cfg['page'] = 'page/2columns-right.phtml';
		            break;		        
		        case 'page/3column3.phtml':
		            $cfg['page'] = 'page/3column3.phtml';
		            break;

		        //etc.
		    }
		}
		return $cfg;
	}

	public function getThemecfg()
	{
		$isSecure = $this->getRequest()->isSecure();
		$protocol = $isSecure ? 'https' : 'http';
		$cfg 	= $this->getConfig(); // config Style 
		$html ='';
		$font 	= $cfg['font'];
		/* get Lib Font */
		if($font['google']) $html  = '<link rel="stylesheet" type="text/css" href="' .$protocol. '://fonts.googleapis.com/css?family='.str_replace(' ', '+', $font['google']).'" media="all" />';
		$html  .= "\n"; // break line;
		/* CssGenerator */
		$html  .= '<style type="text/css">';
		$html  .= '*, body, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6{ font-size: '.$font['size'].'; font-family: '.$font['google'].';}';

		$design = Mage::getStoreConfig("alodesign");
		foreach ($design as $group => $options) 
		{
			foreach ($options as $property => $values) {
				$values = @unserialize($values);
				if($values){
					foreach ($values as $value) {
						if($value){
							$html .= $value['selector'] .'{';
								if($value['color']) 	 $html .= 'color:' .$value['color']. ';';
								if($value['background']) $html .= ' background-color:' .$value['background']. ';';
								if($value['border']) 	 $html .= ' border-color:' .$value['border']. ';';
							$html .= '}';
						}
					}
				}
			}
		}
		$html  .= '</style>';
		$html  .= "\n"; // break line;

		/* Ajax Loading */
		$image 		= isset($cfg['general']['ajaxloading']) ? $cfg['general']['ajaxloading'] : '';
		if($image){
			$link = Mage::getBaseUrl('media', array('_secure'=>$isSecure)).'magiccart/'.$image;
		}else {
			// Mage::app()->getFrontController()->getRequest()->isSecure();
			// $this->getUrl('my-page', array('_forced_secure' => $isSecure));
			$link = $this->getSkinUrl('images/opc-ajax-loader.gif', array('_secure'=>$isSecure));
		}
		$cfg['general']['ajaxloading'] = $link;
		$cfg['general']['baseUrl'] = Mage::getBaseUrl();
		unset($cfg['font']);
		$html .= '<script type="text/javascript"> Themecfg = '.json_encode($cfg).'</script>';  // json config theme

		return $html;

	}

}

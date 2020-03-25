<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2015-03-11 08:31:20
 * @@Function:
 */
 ?>
<?php
class Magiccart_Testimonial_Block_Widget_Slide extends Magiccart_Testimonial_Block_Testimonial
 	implements Mage_Widget_Block_Interface
{
	protected function _prepareLayout() {
		$head = $this->getLayout()->getBlock('head');
	    $head->addCss('magiccart/plugin/css/jquery.bxslider.css');
	    $head->addCss('magiccart/testimonial/css/testimonial.css');
	    $head->addJs('magiccart/plugin/jquery.bxslider.js');
	    return parent::_prepareLayout();
	}

    public function getDevices()
    { 
        return array('portrait'=>480, 'landscape'=>640, 'tablet'=>768, 'maxSlides'=>992);
    }

    public function getBxslider()
    {
        $options = array(
            'auto',
            'speed',
            'pause',
            'controls',
            'pager',
            'maxSlides',
        );
        $script = '';
        foreach ($options as $opt) {
            $cfg  =  $this->config["$opt"] ? $this->config["$opt"] : 0;
            $script    .= "$opt: $cfg, ";
        }

        $options2 = array(
            'mode'=>'vertical',
        );
        foreach ($options2 as $key => $value) {
            $cfg  =  $this->config["$value"];
            if($cfg) $script    .= "$key: '$value', ";
        }
        $enableResponsiveBreakpoints = true ;//$this->config['enableResponsiveBreakpoints'] ;
        if($enableResponsiveBreakpoints){
            $script .= 'responsiveBreakpoints: {';
            $responsiveBreakpoints = $this->getDevices();
            foreach ($responsiveBreakpoints as $opt => $screen) {
                $cfg = isset($this->config[$opt]) ? $this->config[$opt] : '';
                if($cfg) $script .= "$screen : $cfg ,";
            }
            $script .= "}";
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


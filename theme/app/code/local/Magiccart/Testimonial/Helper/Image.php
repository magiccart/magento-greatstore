<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-12-16 18:05:07
 * @@Function:
 */
 ?>
<?php

class Magiccart_Testimonial_Helper_Image extends Mage_Core_Helper_Abstract
{

    /******* Set Image ******/
    protected $folder   = 'mc';
    protected $field    = 'image';
    protected $media    = NULL;
    protected $quality  = 100;
    protected $height    = 135;
    protected $width    = 135;

    public function setField($name)
    {
        if($name) $this->field = $name;
    }

    public function setFolder($folder)
    {
        if($folder) $this->folder = $folder;
    }
    public function setHeight($height)
    {
        if($height) $this->height = $height;
    }

    public function setWidth($width)
    {
        if($width) $this->width = $width;
    }
    public function setQuality($quality)
    {
        if($quality) $this->quality = $quality;       
    }

    public function resize($width, $height)
    {
        $this->setHeight($height);
        $this->setWidth($width);
    }

    /*********** End set Image ***********/

    public function getMedia()
    {
        if(!$this->media) $this->media = Mage::getBaseDir ('media');
    }

    public function getUrlMedia()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
    }

    public function init($object, $field)
    {
        if($field) $this->setField($field);
        $image = $object->getData($this->field);
        if (! $image) return false;

        $this->getMedia(); // set media

        $Url              = $this->getPath($object);

        $img = explode('/', $image);
        $img = end($img);
        $Url['original'] .= $img;
        $Url['resized']  .= $img;
        if(!is_file ($Url['original'])) return 'not found original image';
        if( file_exists($Url['resized']))
        {
            $imageResizedObj = new Varien_Image ( $Url['resized'] );
            if( $this->width != $imageResizedObj->getOriginalWidth()
                || $this->height != $imageResizedObj->getOriginalHeight()
                || filemtime($Url['original']) > filemtime($Url['resized']) )
            {
                $this->convertImage($Url['original'], $Url['resized']);
            }            
        } else {
            
            if(file_exists($Url['original'])) $this->convertImage($Url['original'], $Url['resized']);
        }

        if(file_exists($Url['resized'])){
            $Url['url_resized'] .= $img;
            return $Url['url_resized'];
        }else{
            $Url['url_original'] .= $img;
            return $Url['url_original'];
        }


    }

    public function getPath($object)
    {
        if(!is_object($object)) return;
        else{

            $class      = strtolower(get_class($object));
            $names      = explode("_", $class);
            if($names[0] =='Mage' && $names[1] =='catalog')
            {
                $names[0] = $names[1];
                $names[1] = end($names);
            }
            $namespace  = $names[0];
            $module     = $names[1];

            $Media      = $this->media;

            $dir = $Media . DS . $namespace . DS . $module . DS;
            $url = $this->getUrlMedia() ."/$namespace/$module/";
            $folder = $this->folder;

            $Path['original']     = $dir;
            $Path['resized']      = $dir . 'cache'.DS.$folder . DS;
            $Path['url_original'] = $url;
            $Path['url_resized']  = $url ."cache/$folder/";

        }

        return $Path;
    }

    function convertImage($OriginalUrl, $ResizedlUrl=null)
    {
        $width  = $this->width;
        $height = $this->height;
        if(! is_file ( $OriginalUrl )) return false;
        if(!$ResizedlUrl) $ResizedlUrl = $OriginalUrl;

        $imageObj = new Varien_Image ( $OriginalUrl );
        $imageObj->constrainOnly ( true );
        $imageObj->keepAspectRatio ( true );
        $imageObj->keepFrame ( true ); // force Frame
        $imageObj->quality ( $this->quality );
        $imageObj->keepTransparency(true);  // keep Transparency with image png
        $imageObj->backgroundColor(array(255,255,255));
        $imageObj->resize ( $width, $height );
        $imageObj->save ( $ResizedlUrl );        
    }

}

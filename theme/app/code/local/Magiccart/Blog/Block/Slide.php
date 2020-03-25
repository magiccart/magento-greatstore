<?php

class Magiccart_Blog_Block_Slide extends Magiccart_Blog_Block_Last
{

    protected function _prepareLayout()
    {
        if(Mage::helper('blog')->isEnabled()){
            $head = $this->getLayout()->getBlock('head');
            $head->addCss('magiccart/plugin/css/jquery.bxslider.css');
            $head->addCss('magiccart/blog/css/blog.css');
            $head->addJs('magiccart/jquery.min.js');
            $head->addJs('magiccart/jquery.noconflict.js');
            $head->addJs('magiccart/plugin/jquery.bxslider.js');
            $head->addJs('magiccart/magicproduct.js');        
        }
        parent::_prepareLayout();

    }

    protected function _toHtml()
    {
        $this->setTemplate('magiccart/blog/widget_slide.phtml');
        if ($this->_helper()->getEnabled()) {
            return $this->setData('blog_widget_recent_count', $this->getBlocksCount())->renderView();
        }
    }

    public function getRecent()
    {
        $collection = Mage::getModel('blog/blog')->getCollection()
            ->addPresentFilter()
            ->addEnableFilter(Magiccart_Blog_Model_Status::STATUS_ENABLED)
            ->addStoreFilter()
            ->joinComments()
            ->setOrder('created_time', 'desc')
        ;

        if ($this->getBlogCount()) {
            $collection->setPageSize($this->getBlogCount());
        } else {
            $collection->setPageSize(Mage::helper('blog')->getRecentPage());
        }

        if ($collection && $this->getData('categories')) {
            $collection->addCatsFilter($this->getData('categories'));
        }
        foreach ($collection as $item) {
            $item->setAddress($this->getBlogUrl($item->getIdentifier()));
        }
        return $collection;
    }

    public function getDevices()
    {
        $devices = array('portrait'=>480, 'landscape'=>640, 'tablet'=>768, 'desktop'=>992);
        return $devices;
    }

    public function getItemsDevice()
    {
        $screens = $this->getDevices();
        $screens['visibleItems']  = 993;
        $itemOnDevice = array();
        foreach ($screens as $screen => $size) {
            // $fn = 'get'.ucfirst($screen);
            // $itemOnDevice[$size] = $this->{$fn}();
            $itemOnDevice[$size] = $this->getData($screen);
        }
        return $itemOnDevice;
    }

    public function setFlexiselArray()
    {
        
        //var_dump($this->getData());die;
        if($this->getData('slide')){
            $optTrue = array(
                // 'infiniteLoop',
                'pager',
                'controls',
            );
            $options = array(
                'speed',
                'auto',
                'pause',
                'visibleItems',
            );
            $script = array();
            $script['moveSlides'] = 2;
            $script['infiniteLoop'] = 0;
            $script['maxSlides'] = $this->getData('visibleItems');
            $script['slideWidth'] = $this->getData('widthImages');
            if($this->getData('vertical')){
                $script['mode'] = 'vertical';
                $script['minSlides'] = $this->getData('visibleItems');
            }
            if($this->getData('marginColumn')) $script['slideMargin'] = (int) $this->getData('marginColumn');
            foreach ($optTrue as $opt) {
                $script[$opt] = $this->getData($opt) ? 1 : 0;
            }
            foreach ($options as $opt) {
                $cfg = $this->getData($opt);
                if($cfg) $script[$opt] = (int) $cfg;
            }
            $responsiveBreakpoints = $this->getDevices();
            // $script['responsiveBreakpoints']['mobile'] = array('changePoint'=> 320, 'visibleItems'=> 1);
            foreach ($responsiveBreakpoints as $opt => $screen) {
                $cfg = $this->getData($opt);
                if($cfg) $script['responsiveBreakpoints'][(int) $screen] = (int) $cfg;
            }
            return $script;
        }
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

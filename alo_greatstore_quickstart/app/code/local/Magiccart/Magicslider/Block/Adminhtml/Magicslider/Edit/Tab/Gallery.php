<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2014-10-06 19:21:13
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Block_Adminhtml_Magicslider_Edit_Tab_Gallery extends Mage_Adminhtml_Block_Widget {

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magiccart/magicslider/edit/tab/gallery.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('uploader',
            $this->getLayout()->createBlock('adminhtml/media_uploader')
        );

        $this->getUploader()->getConfig()
            ->setUrl(Mage::getModel('adminhtml/url')->addSessionParam()->getUrl('*/*/upload'))
            ->setFileField('image')
            ->setFilters(array(
                'images' => array(
                    'label' => Mage::helper('adminhtml')->__('Images (.gif, .jpg, .png)'),
                    'files' => array('*.gif', '*.jpg','*.jpeg', '*.png')
                )
            ));

        Mage::dispatchEvent('catalog_product_gallery_prepare_layout', array('block' => $this));

        return parent::_prepareLayout();
    }

    /**
     * Retrive uploader block
     *
     * @return Mage_Adminhtml_Block_Media_Uploader
     */
    public function getUploader()
    {
        return $this->getChild('uploader');
    }

    /**
     * Retrive uploader block html
     *
     * @return string
     */
    public function getUploaderHtml()
    {
        return $this->getChildHtml('uploader');
    }

    public function getJsObjectName()
    {
        return $this->getHtmlId() . 'JsObject';
    }

    public function getAddImagesButton()
    {
        return $this->getButtonHtml(
            Mage::helper('magicslider')->__('Add New Images'),
            $this->getJsObjectName() . '.showUploader()',
            'add',
            $this->getHtmlId() . '_add_images_button'
        );
    }

    public function getImagesJson()
    {
		$model = Mage::registry('magicslider_data');
		if(isset($model['content']) && !empty($model['content'])){
            $options = json_decode($model->getData('content'));
            foreach ($options as $opt) {
                $opt->url = Mage::helper('magicslider')->getBaseTmpMediaUrl() .$opt->file;
            }
			return json_encode($options);
		}
		return '[]';
		
		
        /* if(is_array($this->getElement()->getValue())) {
            $value = $this->getElement()->getValue();
            if(count($value['images'])>0) {
                foreach ($value['images'] as &$image) {
                    $image['url'] = Mage::getSingleton('catalog/product_media_config')
                                        ->getMediaUrl($image['file']);
                }
                return Mage::helper('core')->jsonEncode($value['images']);
            }
        }
        return '[]'; */
    }

    public function getImagesValuesJson()
    {
        $values = array();
        foreach ($this->getMediaAttributes() as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute */
            //$values[$attribute->getAttributeCode()] = $attribute->getValue();
        }
        return Mage::helper('core')->jsonEncode($values);
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    public function getImageTypes()
    {
        $imageTypes = array();
		
        foreach ($this->getMediaAttributes() as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute */
            $imageTypes[$attribute->getAttributeCode()] = array(
                'label' => $attribute->getLabel(),                         
                'field' => $attribute->getLabel()
            );
        }
        return $imageTypes;
    }

    /* public function hasUseDefault()
    {
        foreach ($this->getMediaAttributes() as $attribute) {
            if($this->getElement()->canDisplayUseDefault($attribute))  {
                return true;
            }
        }

        return false;
    } */

    /**
     * Enter description here...
     *
     * @return array
     */
    public function getMediaAttributes()
    {
		$attributeCollection = new Varien_Data_Collection();
		
		$attribute1 = new Varien_Object();
		$attribute1->setAttributeCode('attribute1');
		$attribute1->setLabel('attribute1');
		$attributeCollection->addItem($attribute1);
		
		$attribute2 = new Varien_Object();
		$attribute2->setAttributeCode('attribute2');
		$attribute2->setLabel('attribute2');
		//$attributeCollection->addItem($attribute2);
		
        return $attributeCollection;//$this->getElement()->getDataObject()->getMediaAttributes();
    }

    public function getImageTypesJson()
    {
        return Mage::helper('core')->jsonEncode($this->getImageTypes());
    }
	
	
	protected function getStoreId()
    {
        return Mage::app()->getStore(true)->getId();
    }
	
}

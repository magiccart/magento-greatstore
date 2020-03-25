<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-07-28 19:51:39
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicbrand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('brandGrid');
      $this->setDefaultSort('brand_id');
      $this->setUseAjax(true);
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function getCfg(){
     return Mage::helper('magicbrand')->getGeneralCfg('brand');
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('magicbrand/brand')->getCollection();
                                                      //->addFieldToFilter('brand_attribute', $this->getCfg());
      foreach($collection as $link) { // renderer stores
          if($link->getStores() && $link->getStores() != 0 ){
            $link->setStores(explode(',',$link->getStores()));
          }
          else{
            $link->setStores(array('0'));
          }
        }
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('brand_id', array(
          'header'    => Mage::helper('magicbrand')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'brand_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('magicbrand')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $cfg = $this->getCfg();
      if($cfg){
          $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $cfg);
          $options = $attribute->getSource()->getAllOptions(true);
          if($options){
            $brands = array();
            foreach ($options as $option) {
              $brands[$option['value']] = $option['label'];
            }
          }
          if(array_filter($brands)){
            $this->addColumn('brand', array(
                  'header'    => Mage::helper('magicbrand')->__('Brand'),
                  'align'     =>'left',
                  'index'     => 'brand',
                  'type'      => 'options',
                  'options'   => $brands,
              ));
          }
      }

      $this->addColumn('url', array(
          'header'    => Mage::helper('magicbrand')->__('Url'),
          'align'     =>'left',
          'index'     => 'url',
      ));

      $this->addColumn('image',
        array(
          'header'=> Mage::helper('magicbrand')->__('Image'),
          'type' => 'image',
          'renderer'  => 'magicbrand/adminhtml_renderer_grid_column_images',
          'width' => 64,
          'index' => 'image',
      ));

      $this->addColumn('brand_attribute', array(
          'header'    => Mage::helper('magicbrand')->__('Attribute'),
          'align'     =>'center',
          'index'     => 'brand_attribute',
      ));

      if (!Mage::app()->isSingleStoreMode()) {
        $this->addColumn('stores', array(
            'header'        => Mage::helper('magicbrand')->__('Stores View'),
            'index'         => 'stores',
            'type'          => 'store',
            'store_all'     => true,
            'store_view'    => true,
            'sortable'      => true,
            'filter_condition_callback' => array($this,'_filterStoreCondition'),
        ));
      }

      $this->addColumn('order', array(
          'header'    => Mage::helper('magicbrand')->__('Order'),
          'align'     =>'left',
          'index'     => 'order',
      ));

      $this->addColumn('status', array(
          'header'    => Mage::helper('magicbrand')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('magicbrand')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('magicbrand')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('magicbrand')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('magicbrand')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('brand_id');
        $this->getMassactionBlock()->setFormFieldName('brand');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('magicbrand')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('magicbrand')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('magicbrand/status')->getOptionArray(); // option Action for change status

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('magicbrand')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('magicbrand')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

  public function getGridUrl()
  {
    return $this->getUrl('*/*/grid', array('_current'=>true)); // for Ajax in grid
  }

}


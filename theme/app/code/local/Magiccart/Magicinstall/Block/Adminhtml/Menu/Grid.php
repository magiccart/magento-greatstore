<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:52:42
 * @@Modify Date: 2015-02-05 17:17:18
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Menu_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('extraGrid');
      $this->setDefaultSort('menu_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  public function  getStaticBlock()
  {
    // $options = Mage::getResourceModel('cms/block_collection')->load()->toOptionArray(); // if use value is id
    $options = array();
    $blocks = Mage::getResourceModel('cms/block_collection')->load();
    foreach ($blocks as $block) {
      $options[$block->getIdentifier()] = $block->getTitle();
    }
    return $options; 
  }

  protected function _prepareCollection()
  {
    $collection = Mage::getModel('magicmenu/menu')->getCollection()
                      ->addFieldToFilter('extra', 1);
      foreach($collection as $link) { // renderer stores
        if($link->getStores() && $link->getStores() != 0 ){
          $link->setStores(explode(',',$link->getStores()));
        }else {
          $link->setStores(array('0'));
        }
      }
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('name', array(
        'header'    => Mage::helper('adminhtml')->__('Name'),
        'align'     =>'left',
        'width'     => '150px',
        'index'     => 'name',
      ));

      $this->addColumn('magic_label', array(
          'header'    => Mage::helper('adminhtml')->__('Label'),
          'align'     =>'left',
          'index'     => 'magic_label',
          'width'     => '150px',
      ));

      $this->addColumn('link', array(
          'header'    => Mage::helper('adminhtml')->__('Link'),
          'align'     =>'left',
          'index'     => 'link',
          'width'     => '300px',
      ));

      $this->addColumn('short_desc', array(
          'header'    => Mage::helper('adminhtml')->__('Short Description'),
          'align'     =>'left',
          'index'     => 'short_desc',
          'width'     => '200px',
      ));

      $this->addColumn('ext_content', array(
        'header'    => Mage::helper('adminhtml')->__('Dropdown Content'),
        'align'     =>'left',
        'index'     => 'ext_content',
        'type'      => 'options',
        'options'   => $this->getStaticBlock(),
      ));

      if (!Mage::app()->isSingleStoreMode()) {
        $this->addColumn('stores', array(
            'header'        => Mage::helper('magicmenu')->__('Stores View'),
            'index'         => 'stores',
            'type'          => 'store',
            'store_all'     => true,
            'store_view'    => true,
            'sortable'      => true,
            'filter_condition_callback' => array($this,'_filterStoreCondition'),
        ));
      }

      $this->addColumn('order', array(
          'header'    => Mage::helper('adminhtml')->__('Order'),
          'align'     =>'left',
          'index'     => 'order',
        'width'     => '50px',
      ));

      $this->addColumn('status', array(
          'header'    => Mage::helper('adminhtml')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
            1 => 'Enabled',
            2 => 'Disabled',
        ),
      ));
	  
      return parent::_prepareColumns();
  }
  
  protected function _afterLoadCollection()
  {
	  $this->getCollection()->walk('afterLoad');
	  parent::_afterLoadCollection();
  }
  
  protected function _filterStoreCondition($collection, $column)
  {
	  if (!$value = $column->getFilter()->getValue()) {
		  return;
	  }

	  $this->getCollection()->addStoreFilter($value);
  }

  protected function _prepareMassaction()
  {
      $this->setMassactionIdField('menu_id');
      $this->getMassactionBlock()->setFormFieldName('menu_ids');

    $stores = Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false);
    $this->getMassactionBlock()->addItem('export', array(
      'label'    => Mage::helper('adminhtml')->__('Export'),
      'url'      => $this->getUrl('*/*/exportXml'),
      'additional' => array(
      'visibility' => array(
          'name' => 'store_id',
          'type' => 'select',
          'class' => 'required-entry',
          'label' => Mage::helper('adminhtml')->__('Store'),
          'values' => $stores
        )
      ),
      'confirm'  => Mage::helper('adminhtml')->__('Are you sure?')
    ));
	  return $this;
  }

}


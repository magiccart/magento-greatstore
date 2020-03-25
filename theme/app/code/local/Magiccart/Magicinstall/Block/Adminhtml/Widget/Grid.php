<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:49:05
 * @@Modify Date: 2015-02-05 17:18:16
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Widget_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('widgetInstanceGrid');
      $this->setDefaultSort('instance_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('widget/widget_instance')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('instance_id', array(
          'header'    => Mage::helper('widget')->__('Widget ID'),
          'align'     => 'left',
          'index'     => 'instance_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('widget')->__('Widget Instance Title'),
          'align'     => 'left',
          'index'     => 'title',
      ));

      $this->addColumn('type', array(
          'header'    => Mage::helper('widget')->__('Type'),
          'align'     => 'left',
          'index'     => 'instance_type',
          'type'      => 'options',
          'options'   => $this->getTypesOptionsArray()
      ));

      $this->addColumn('package_theme', array(
          'header'    => Mage::helper('widget')->__('Design Package/Theme'),
          'align'     => 'left',
          'index'     => 'package_theme',
          'type'      => 'theme',
          'with_empty' => true,
      ));

      $this->addColumn('sort_order', array(
          'header'    => Mage::helper('widget')->__('Sort Order'),
          'width'     => '100',
          'align'     => 'center',
          'index'     => 'sort_order',
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
      $this->setMassactionIdField('instance_id');
      $this->getMassactionBlock()->setFormFieldName('instance_ids');

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


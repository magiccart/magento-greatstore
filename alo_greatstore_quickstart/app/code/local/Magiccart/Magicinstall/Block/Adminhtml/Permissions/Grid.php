<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:52:42
 * @@Modify Date: 2015-11-06 11:26:11
 * @@Function:
 */

class Magiccart_Magicinstall_Block_Adminhtml_Permissions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('permissionsBlockGrid');
      $this->setDefaultSort('block_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

    protected function _prepareCollection()
    {
      $magentoVersion = Mage::getVersion();
      if (version_compare($magentoVersion, '1.9.2.2', '>=')){
        $collection = Mage::getResourceModel('admin/block_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
      }else {
          echo 'Feature only support version is 1.9.2.2 or greater';
      }
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('block_id', array(
            'header'    => Mage::helper('adminhtml')->__('ID'),
            'width'     => 5,
            'align'     => 'right',
            'sortable'  => true,
            'index'     => 'block_id'
        ));

        $this->addColumn('block_name', array(
            'header'    => Mage::helper('adminhtml')->__('Block Name'),
            'index'     => 'block_name'
        ));

        $this->addColumn('is_allowed', array(
            'header'    => Mage::helper('adminhtml')->__('Status'),
            'index'     => 'is_allowed',
            'type'      => 'options',
            'options'   => array('1' => Mage::helper('adminhtml')->__('Allowed'), '0' => Mage::helper('adminhtml')->__('Not allowed')),
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
      $this->setMassactionIdField('block_id');
      $this->getMassactionBlock()->setFormFieldName('block_ids');
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


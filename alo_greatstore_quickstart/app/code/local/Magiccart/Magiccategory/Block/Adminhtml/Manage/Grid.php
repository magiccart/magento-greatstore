<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-18 00:18:07
 * @@Function:
 */
// include('Varien\Db\Collection.php');
class Magiccart_Magiccategory_Block_Adminhtml_Manage_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('manageGrid');
		$this->setDefaultSort('identifier');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('core/config_data')->getCollection()
							->addFieldToFilter('path', array('like' => 'magiccategory/identifier/%'));
		if($collection){
			foreach ($collection as $widget) {
				$tmp = unserialize($widget->getValue());
				$data = $tmp ? $tmp : array();
				$widget->addData($data);
			}
		}
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{

		$this->addColumn('config_id', array(
			'header'    => Mage::helper('adminhtml')->__('ID'),
			'align'     =>'left',
			'width'     => '50px',
			'index'     => 'config_id',
		    // 'column_css_class'=>'no-display',//this sets a css class to the column row item
		    // 'header_css_class'=>'no-display',//this sets a css class to the column header
		));

		$this->addColumn('title', array(
			'header'    => Mage::helper('adminhtml')->__('Title'),
			'align'     =>'left',
			'width'     => '150px',
			'index'     => 'title',
		));

		$this->addColumn('identifier', array(
			'header'    => Mage::helper('adminhtml')->__('Identifier'),
			'align'     =>'left',
			'width'     => '100px',
			'index'     => 'identifier',
		));

		$this->addColumn('slide', array(
			'header'    => Mage::helper('adminhtml')->__('Slide'),
			'align'     =>'center',
			'width'     => '80px',
			'index'     => 'slide',
			'type'      => 'options',
			'options'   => array(
				0 => 'No',
				1 => 'Yes',
			),
		));

		$this->addColumn('limit', array(
			'header'    => Mage::helper('adminhtml')->__('Limit'),
			'align'     =>'center',
			'width'     => '80px',
			'index'     => 'limit',
		));

		$this->addColumn('status', array(
			'header'    => Mage::helper('adminhtml')->__('Status'),
			'align'     => 'center',
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
				'header'    =>  Mage::helper('adminhtml')->__('Action'),
				'width'     => '100',
				'type'      => 'action',
				'getter'    => 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('adminhtml')->__('Edit'),
						'url'       => array('base'=> '*/*/edit'),
						'field'     => 'id'
					)
				),
				'filter'    => false,
				'sortable'  => false,
				'index'     => 'stores',
				'is_system' => true,
		));

		// $this->addExportType('*/*/exportCsv', Mage::helper('adminhtml')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('adminhtml')->__('XML'));

		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('config_id');
		$this->getMassactionBlock()->setFormFieldName('magiccategory');

		$this->getMassactionBlock()->addItem('delete', array(
			'label'    => Mage::helper('adminhtml')->__('Delete'),
			'url'      => $this->getUrl('*/*/massDelete'),
			'confirm'  => Mage::helper('adminhtml')->__('Are you sure?')
		));

		$statuses = Mage::getSingleton('magiccategory/status')->getOptionArray();

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
			 'label'=> Mage::helper('adminhtml')->__('Change status'),
			 'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			 'additional' => array(
					'visibility' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('adminhtml')->__('Status'),
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

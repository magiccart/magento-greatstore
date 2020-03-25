<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-11-16 11:04:25
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicmenu_Block_Adminhtml_Extra_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('extraGrid');
		// $this->setDefaultSort('menu_id');
		$this->setUseAjax(true);
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
		// $this->addColumn('menu_id', array(
		// 	'header'    => Mage::helper('magicmenu')->__('ID'),
		// 	'align'     =>'right',
		// 	'width'     => '50px',
		// 	'index'     => 'menu_id',
		// ));

		$this->addColumn('name', array(
			'header'    => Mage::helper('magicmenu')->__('Name'),
			'align'     =>'left',
			'width'     => '150px',
			'index'     => 'name',
		));

		$this->addColumn('magic_label', array(
		    'header'    => Mage::helper('magicmenu')->__('Label'),
		    'align'     =>'left',
		    'index'     => 'magic_label',
			'width'     => '100px',
		));

		$this->addColumn('short_desc', array(
		    'header'    => Mage::helper('magicmenu')->__('Short Description'),
		    'align'     =>'left',
		    'index'     => 'short_desc',
			'width'     => '150px',
		));

		$this->addColumn('link', array(
		    'header'    => Mage::helper('magicmenu')->__('Link'),
		    'align'     =>'left',
		    'index'     => 'link',
			'width'     => '300px',
		));

		$this->addColumn('ext_content', array(
			'header'    => Mage::helper('magicmenu')->__('Dropdown Content'),
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
		    'header'    => Mage::helper('magicmenu')->__('Order'),
		    'align'     =>'left',
		    'index'     => 'order',
			'width'     => '50px',
		));

		$this->addColumn('status', array(
				'header'    => Mage::helper('magicmenu')->__('Status'),
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
			'header'    =>  Mage::helper('magicmenu')->__('Action'),
			'width'     => '100',
			'type'      => 'action',
			'getter'    => 'getId',
			'actions'   => array(
				array(
					'caption'   => Mage::helper('magicmenu')->__('Edit'),
					'url'       => array('base'=> '*/*/edit'),
					'field'     => 'id'
				)
			),
			'filter'    => false,
			'sortable'  => false,
			'index'     => 'stores',
			'is_system' => true,
		));

		$this->addExportType('*/*/exportCsv', Mage::helper('magicmenu')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('magicmenu')->__('XML'));

		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('menu_id');
		$this->getMassactionBlock()->setFormFieldName('menu');

		$this->getMassactionBlock()->addItem('delete', array(
			'label'    => Mage::helper('magicmenu')->__('Delete'),
			'url'      => $this->getUrl('*/*/massDelete'),
			'confirm'  => Mage::helper('magicmenu')->__('Are you sure?')
		));

		$statuses = Mage::getSingleton('magicmenu/status')->getOptionArray(); // option Action for change status

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('magicmenu')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'visibility' => array(
					'name' => 'status',
					'type' => 'select',
					'class' => 'required-entry',
					'label' => Mage::helper('magicmenu')->__('Status'),
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


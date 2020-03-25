<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:52:42
 * @@Modify Date: 2015-02-05 17:17:58
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Slide_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('slideGrid');
		$this->setDefaultSort('slide_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('magicslider/magicslider')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('slide_id', array(
			'header'    => Mage::helper('adminhtml')->__('ID'),
			'align'     =>'center',
			'width'     => '50px',
			'index'     => 'slide_id',
		));

		$this->addColumn('title', array(
			'header'    => Mage::helper('adminhtml')->__('Title'),
			'align'     =>'left',
			'index'     => 'title',
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

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('slide_id');
		$this->getMassactionBlock()->setFormFieldName('slide_ids');

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


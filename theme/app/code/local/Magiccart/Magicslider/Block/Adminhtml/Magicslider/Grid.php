<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-20 14:22:26
 * @@Function:
 */
?>
<?php
class Magiccart_Magicslider_Block_Adminhtml_Magicslider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('magicsliderGrid');
      $this->setDefaultSort('magicslider_id');
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
        'align'     =>'right',
        'width'     => '50px',
        'index'     => 'slide_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('magicslider')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $this->addColumn('identifier', array(
          'header'    => Mage::helper('magicslider')->__('Identifier'),
          'align'     =>'left',
          'index'     => 'identifier',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('magicslider')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('magicslider')->__('Status'),
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
                'header'    =>  Mage::helper('magicslider')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('magicslider')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		// $this->addExportType('*/*/exportCsv', Mage::helper('magicslider')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('magicslider')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('magicslider_id');
        $this->getMassactionBlock()->setFormFieldName('magicslider');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('magicslider')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('magicslider')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('magicslider/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('magicslider')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('magicslider')->__('Status'),
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

}

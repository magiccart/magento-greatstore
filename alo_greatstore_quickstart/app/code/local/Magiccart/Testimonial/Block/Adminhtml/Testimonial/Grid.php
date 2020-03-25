<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-30 23:04:00
 * @@Modify Date: 2014-08-06 23:02:03
 * @@Function:
 */
?>
<?php
class Magiccart_Testimonial_Block_Adminhtml_Testimonial_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
	parent::__construct();
	$this->setId('testimonialGrid');
	$this->setDefaultSort('testimonial_id');
	$this->setDefaultDir('DESC');
	$this->setSaveParametersInSession(true);
    }

    protected function _getStore() {
	$storeId = (int) $this->getRequest()->getParam('store', 0);
	return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection() {
      	$collection = Mage::getModel('testimonial/testimonial')->getCollection();
      
      	foreach($collection as $link) { // renderer stores
          	if($link->getStores() && $link->getStores() != 0 ){
            	$link->setStores(explode(',',$link->getStores()));
          	}else{
            	$link->setStores(array('0'));
          	}
        }
      	$this->setCollection($collection);
      	return parent::_prepareCollection();
    }

    protected function _prepareColumns() 
    {
		$this->addColumn('testimonial_id', array(
			'header'    => Mage::helper('adminhtml')->__('ID'),
			'align'     =>'right',
			'width'		=> '80px',
			'index'     => 'testimonial_id'
		));

		$this->addColumn('name', array(
			'header'    => Mage::helper('adminhtml')->__('Name'),
			'align'     =>'left',
			'index'     => 'name',
		));

        $this->addColumn('text', array(
            'header'    => Mage::helper('adminhtml')->__('Text'),
            'align'     => 'left',
            'index'     => 'text',
        ));

	    if (!Mage::app()->isSingleStoreMode()) {
	        $this->addColumn('stores', array(
	            'header'        => Mage::helper('adminhtml')->__('Stores View'),
	            'index'         => 'stores',
	            'type'          => 'store',
	            'store_all'     => true,
	            'store_view'    => true,
	            'sortable'      => true,
	            'filter_condition_callback' => array($this,'_filterStoreCondition'),
	        ));
	    }

	    $this->addColumn('rating_summary', array(
			'header'    => Mage::helper('adminhtml')->__('Rating'),
			'align'     => 'left',
			'width'     => '80px',
			'index'     => 'rating_summary',
			'type'      => 'options',
			'renderer'  => 'testimonial/adminhtml_renderer_grid_column_rating',
			'options'   => array(
			  1 => '1 star',
			  2 => '2 stars',
			  3 => '3 stars',
			  4 => '4 stars',
			  5 => '5 stars',
			),
	    ));

	  //   $this->addColumn('sidebar', array(
			// 'header'    => Mage::helper('adminhtml')->__('Display in Sidebar'),
			// 'align'     => 'left',
			// 'width'     => '100px',
			// 'index'     => 'sidebar',
			// 'type'      => 'options',
			// 'options'   => array(
			//   1 => 'Yes',
			//   2 => 'No',
			// ),
	  //   ));

        $this->addColumn('position', array(
            'header'    => Mage::helper('adminhtml')->__('Position'),
            'align'     => 'right',
            'width'     => '50px',
            'index'     => 'position',
            'type'      => 'number',
        ));

      	$this->addColumn('status', array(
			'header'    => Mage::helper('adminhtml')->__('Status'),
			'align'     => 'left',
			'width'     => '80px',
			'index'     => 'status',
			'type'      => 'options',
			'options'   => Mage::helper('review')->getReviewStatuses(),
      	));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('adminhtml')->__('Action'),
                'width'     => '100px',
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
		
		$this->addExportType('*/*/exportCsv', Mage::helper('adminhtml')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('adminhtml')->__('XML'));
	  
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('testimonial_id');
        $this->getMassactionBlock()->setFormFieldName('testimonial');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('adminhtml')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('adminhtml')->__('Are you sure?')
        ));

        $statuses = Mage::helper('review')->getReviewStatuses();

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
 
 
        // $sideBarstatuses = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();

        // array_unshift($sideBarstatuses, array('label'=>'', 'value'=>''));
        // $this->getMassactionBlock()->addItem('testimonial_sidebar', array(
        //      'label'=> Mage::helper('adminhtml')->__('Change slide status'),
        //      'url'  => $this->getUrl('*/*/massSidebarstatus', array('_current'=>true)),
        //      'additional' => array(
        //             'visibility' => array(
        //                  'name' => 'sidebar',
        //                  'type' => 'select',
        //                  'class' => 'required-entry',
        //                  'label' => Mage::helper('adminhtml')->__('Status'),
        //                  'values' => $sideBarstatuses
        //              )
        //      )
        // ));

       return $this;
    }

}

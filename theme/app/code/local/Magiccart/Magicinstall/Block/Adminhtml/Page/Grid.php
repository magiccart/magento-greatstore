<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:51:41
 * @@Modify Date: 2015-02-05 17:17:35
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Page_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {

        parent::__construct();
        $this->setId('cmsPageGrid');
        $this->setDefaultSort('identifier');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('cms/page')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $collection->setFirstStoreFlag(true);
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('title', array(
            'header'    => Mage::helper('cms')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));

        $this->addColumn('identifier', array(
            'header'    => Mage::helper('cms')->__('URL Key'),
            'align'     => 'left',
            'index'     => 'identifier'
        ));

        $this->addColumn('root_template', array(
            'header'    => Mage::helper('cms')->__('Layout'),
            'index'     => 'root_template',
            'type'      => 'options',
            'options'   => Mage::getSingleton('page/source_layout')->getOptions(),
        ));

        /**
        * Check is single store mode
        */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('cms')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('cms')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => Mage::getSingleton('cms/page')->getAvailableStatuses()
        ));

        $this->addColumn('creation_time', array(
            'header'    => Mage::helper('cms')->__('Date Created'),
            'index'     => 'creation_time',
            'type'      => 'datetime',
        ));

        $this->addColumn('update_time', array(
            'header'    => Mage::helper('cms')->__('Last Modified'),
            'index'     => 'update_time',
            'type'      => 'datetime',
        ));

        $this->addColumn('page_actions', array(
            'header'    => Mage::helper('cms')->__('Action'),
            'width'     => 10,
            'sortable'  => false,
            'filter'    => false,
            'renderer'  => 'adminhtml/cms_page_grid_renderer_action',
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
	    $this->setMassactionIdField('page_id');
	    $this->getMassactionBlock()->setFormFieldName('page_ids');

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


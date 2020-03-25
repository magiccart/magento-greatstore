<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 17:00:24
 * @@Modify Date: 2015-05-06 17:38:39
 * @@Function:
 */
?>
<?php
class Magiccart_Magicinstall_Adminhtml_InstallController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction() 
    {
        $this->loadLayout()
                ->_setActiveMenu('magiccart/magicinstall_install')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction() 
    {
        $this->newAction();
    }

    public function editAction() 
    {
        $this->_initAction()
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock('magicinstall/adminhtml_install_edit'))
            ->_addLeft($this->getLayout()->createBlock('adminhtml/system_config_switcher'))
            ->_addLeft($this->getLayout()->createBlock('magicinstall/adminhtml_install_edit_tabs'));
        // $this->getLayout()->getBlock('left')
        //     ->append($this->getLayout()->createBlock('adminhtml/system_config_tabs')->initTabs());
        $this->renderLayout();
    }

    public function newAction() 
    {
        $this->_forward('edit');
    }

    public function saveAction() 
    {
        if ($data = $this->getRequest()->getPost()) {
            $action = trim($data['action']);
            // $stores = array();
            // $stores = isset($data['store_ids']) ? $data['store_ids'] : array(0);
            // if(in_array(0, $stores)) $stores = $this->getStoreIds();
            $stores = isset($data['store_ids']) ? $data['store_ids'] : array(0);
            if(isset($data['scope']) && isset($data['scope_id'])){
                if($data['scope'] == 'websites'){
                    $stores = Mage::app()->getWebsite($data['scope_id'])->getStoreIds();
                }else {
                    $stores  = $data['scope_id']; 
                }
            }
            // var_dump($stores); die;
            try 
            {
                if ($action == '1') {
                    // import page, static block, widget
                    $restore = Mage::getSingleton('magicinstall/import_cms');
                    if($data['pages']=='1')     $restore->importCmsItems('cms/page', 'pages', $data['theme'], $data['overwrite_pages'], $stores);
                    if($data['blocks']=='1')    $restore->importCmsItems('cms/block', 'blocks', $data['theme'], $data['overwrite_blocks'], $stores);
                    if(isset($data['widgets']) && $data['widgets']=='1')   $restore->importWidgetItems('widget/widget_instance', 'widgets', $data['theme'], false, $stores);
                    if($data['menus']=='1')     $restore->importMenuItems('magicmenu/menu', 'magicmenu', $data['theme'], false, $stores);
                    if($data['slide']=='1')     $restore->importSlideItems('magicslider/magicslider', 'magicslider', $data['theme'], false, $stores);
                    if($data['config']=='1'){
                        if(isset($data['scope']) && isset($data['scope_id'])){
                            $restore->importSystemConfig('core/config', 'system', $data['theme'], $data['scope'], $stores);
                        }else {
                            $restore->importSystemConfig('core/config', 'system', $data['theme']);
                        }
                    }
					
                    $magentoVersion = Mage::getVersion();
                    if (version_compare($magentoVersion, '1.9.2.2', '>=')){
                        $restore->importPermissionsItems('admin/block', 'permissions', $data['theme'], false, $stores); // fix 1.9.2.2
                    }
					
                } else {
                    //uninstall static block
                    if($data['pages']=='1') Mage::getSingleton('magicinstall/import_cms')->deleteCmsItems('cms/page', 'pages', $data['theme'], $stores);
                    if($data['blocks']=='1') Mage::getSingleton('magicinstall/import_cms')->deleteCmsItems('cms/block', 'blocks', $data['theme'], $stores);
                    if($data['config']=='1') Mage::getSingleton('magicinstall/import_cms')->deleteSystemConfig('core/config', 'system', $data['theme'], $stores);
                }

                $this->_redirectReferer();
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e);
                $this->_redirectReferer();
            }
        }
    }

    public function getStoreIds() 
    {
        $stores = Mage::app()->getStores();
        $storeIds = array();
        $storeIds[]= 0;
        foreach ($stores as $_store) {
            $storeIds[] = $_store->getId();
        }
        return $storeIds;
    }

}

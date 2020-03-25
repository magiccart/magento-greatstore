<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:58:54
 * @@Modify Date: 2014-11-04 14:47:24
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Adminhtml_RestoreController extends Mage_Adminhtml_Controller_Action
{

    protected $_stores;
    protected $_clear;

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('magiccart/magicinstall/restore')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Restore Defaults'), Mage::helper('adminhtml')->__('Restore Defaults'));
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->_title($this->__('ALO Themes'))
            ->_title($this->__('magicinstall'))
            ->_title($this->__('Restore Defaults'));
        $this->_addContent($this->getLayout()->createBlock('magicinstall/adminhtml_restore_edit'));
        $this->renderLayout();
    }

    public function restoreAction()
    {
        $this->_stores = $this->getRequest()->getParam('stores', array(0));
        $this->_clear = $this->getRequest()->getParam('clear_scope', true);
        if ($this->_clear) {
            if ( !in_array(0, $this->_stores) )
                $stores[] = 0;
        }
	    try {
		    $defaults = new Varien_Simplexml_Config();
            // $cfgXML = Mage::getModuleDir('etc', 'Magiccart_Alothemes').'/config.xml';
            $cfgXML = Mage::getBaseDir().'/app/code/local/Magiccart/Alothemes/etc/config.xml';
            if(!file_exists($cfgXML)){
                echo 'Not found file:' .$cfgXML;
                return;
            }
            $defaults->loadFile($cfgXML);
            $this->_restoreSettings($defaults->getNode('default/alothemes')->children(), 'alothemes');
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Default Settings for magicinstall Design Theme has been restored.'));
        }
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while restoring theme settings.'));
        }
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }

    private function _restoreSettings($items, $path)
    {
        $websites = Mage::app()->getWebsites();
        $stores = Mage::app()->getStores();
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->_restoreSettings($item->children(), $path.'/'.$item->getName());
            } else {
                if ($this->_clear) {
                    Mage::getConfig()->deleteConfig($path.'/'.$item->getName());
                    foreach ($websites as $website) {
                        Mage::getConfig()->deleteConfig($path.'/'.$item->getName(), 'websites', $website->getId());
                    }
                    foreach ($stores as $store) {
                        Mage::getConfig()->deleteConfig($path.'/'.$item->getName(), 'stores', $store->getId());
                    }
                }
                foreach ($this->_stores as $store) {
                    $scope = ($store ? 'stores' : 'default');
                    Mage::getConfig()->saveConfig($path.'/'.$item->getName(), (string)$item, $scope, $store);
                }
            }
        }
    }
	
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('magiccart/magicinstall/restore');
    }

}


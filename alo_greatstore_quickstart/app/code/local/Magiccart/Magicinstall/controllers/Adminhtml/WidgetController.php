<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:58:54
 * @@Modify Date: 2015-02-04 19:03:02
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Adminhtml_WidgetController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Mage_Adminhtml_Cms_PageController
     */
    protected $dir = 'import';
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('magiccart/magicinstall')
            ->_title(Mage::helper('magicinstall')->__('Manage Export Widget'))
            ->_addBreadcrumb(Mage::helper('magicinstall')->__('Manage Export Widget'), Mage::helper('magicinstall')->__('Manage Export Widget'));
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('magicinstall/adminhtml_widget'));
        $this->renderLayout();
    }

    /**
     *  Export page grid to XML format
     */
    public function exportXmlAction()
    {
        $fileName   = 'widgets.xml';
        $instanceIds = $this->getRequest()->getParam('instance_ids');
        $storeId = (int) $this->getRequest()->getParam('store_id', 0);
        if(!is_array($instanceIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                $collection = Mage::getModel('widget/widget_instance')->getCollection()->addFieldToFilter('instance_id',array('in'=>$instanceIds));
                $xml = '<root>';
                    $xml.= '<widgets>';
                    $num = 0;
                    foreach ($collection as $instance) {
                        $xml.= '<instance>';
                            $xml.= '<title><![CDATA['.$instance->getTitle().']]></title>';
                            $xml.= '<instance_type>'.$instance->getInstanceType().'</instance_type>';
                            $xml.= '<package_theme>'.$instance->getPackageTheme().'</package_theme>';
                            $xml.= '<widget_parameters><![CDATA['.serialize($instance->getWidgetParameters()).']]></widget_parameters>';
                            $xml.= '<sort_order>'.$instance->getSortOrder().'</sort_order>';
                            $pages = Mage::getSingleton('magicinstall/resource_widget_instance')->pageItemsLoad($instance->getInstanceId());
                            $packageTheme = explode('/', $instance->getPackageTheme());
                            foreach($pages as $page){
                                $xml.='<page>';
                                    $xml.='<group>'.$page['page_group'].'</group>';
                                    $xml.='<layout_handle>'.$page['layout_handle'].'</layout_handle>';
                                    $xml.='<block_reference>'.$page['block_reference'].'</block_reference>';
                                    $xml.='<for>'.$page['page_for'].'</for>';
                                    $xml.='<entities>'.$page['entities'].'</entities>';
                                    $xml.='<template>'.$page['page_template'].'</template>';
                                    $xml.='<area>frontend</area>';
                                    $xml.='<package>'.$packageTheme[0].'</package>';
                                    $xml.='<theme>'.$packageTheme[1].'</theme>';
                                $xml.='</page>';
                            }
                            $layoutUpdate = Mage::getSingleton('magicinstall/resource_widget_instance')->layoutLoad($instance->getInstanceId());
                            $xml.='<xml><![CDATA['.$layoutUpdate.']]></xml>';
                        $xml.= '</instance>';
                        $num++;
                    }
                    $xml.= '</widgets>';
                $xml.= '</root>';
               // $this->_sendUploadResponse($fileName, $xml);
                $theme = Mage::getStoreConfig('design/theme/default', $storeId);
                if(!$theme) $theme = 'default';
                $moduleName = 'Magiccart_' . ucfirst(Mage::app()->getRequest()->getModuleName());
                $folder = Mage::getModuleDir('etc', $moduleName) .DIRECTORY_SEPARATOR. $this->dir .DIRECTORY_SEPARATOR. $theme;
                @mkdir($folder, 0644, true);
                $doc =  new DOMDocument('1.0', 'UTF-8');
                $doc->loadXML($xml);
                $doc->formatOutput = true;
                $doc->save("$folder/$fileName");
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Export (%s) Item Widget:', $num)
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*');
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}


<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:56:13
 * @@Modify Date: 2015-02-04 19:02:29
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Adminhtml_PageController extends Mage_Adminhtml_Controller_Action
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
            ->_title(Mage::helper('magicinstall')->__('Manage Export Page'))
            ->_addBreadcrumb(Mage::helper('magicinstall')->__('Manage Export Page'), Mage::helper('magicinstall')->__('Manage Export Page'));
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('magicinstall/adminhtml_page'));
        $this->renderLayout();
    }

    /**
     *  Export page grid to XML format
     */
    public function exportXmlAction()
    {
        $fileName   = 'pages.xml';
        $pageIds = $this->getRequest()->getParam('page_ids');
        $storeId = (int) $this->getRequest()->getParam('store_id', 0);
        if(!is_array($pageIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                $collection = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('page_id',array('in'=>$pageIds));
                $options = array('title', 'root_template', 'identifier', 'content_heading', 'content', 'layout_update_xml', 'is_active');
                $xml = '<root>';
                    $xml.= '<pages>';
                    $num = 0;
                    foreach ($collection as $page) {
                        $xml.= '<cms_block>';
                        foreach ($options as $opt) {
                            $xml.= '<'.$opt.'><![CDATA['.$page->getData($opt).']]></'.$opt.'>';
                        }
                        $xml.= '</cms_block>';
                        $num++;
                    }
                    $xml.= '</pages>';
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
                    Mage::helper('adminhtml')->__('Export (%s) CMS Page:', $num)
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


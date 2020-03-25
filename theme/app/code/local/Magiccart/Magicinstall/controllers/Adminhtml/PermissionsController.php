<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 15:01:10
 * @@Modify Date: 2015-11-06 11:27:12
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Adminhtml_PermissionsController extends Mage_Adminhtml_Controller_Action
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
            ->_title(Mage::helper('magicinstall')->__('Manage Export Permissions Blocks'))
            ->_addBreadcrumb(Mage::helper('magicinstall')->__('Manage Export Permissions Blocks'), Mage::helper('magicinstall')->__('Manage Export Permissions Block'));
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('magicinstall/adminhtml_permissions'));
        $this->renderLayout();
    }

    /**
     *  Export page grid to XML format
     */
    public function exportXmlAction()
    {
        
        $magentoVersion = Mage::getVersion();
        if (version_compare($magentoVersion, '1.9.2.2', '<')) {
            echo 'Feature only support version is 1.9.2.2 or greater';
            return;
        }
        $fileName   = 'permissions.xml';
        $storeId = (int) $this->getRequest()->getParam('store_id', 0);
        $blockIds = $this->getRequest()->getParam('block_ids');
        if(!is_array($blockIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                $collection = Mage::getModel('admin/block')->getCollection()->addFieldToFilter('block_id',array('in'=>$blockIds));
                $options = array('block_name', 'is_allowed');
                $xml = '<root>';
                    $xml.= '<permissions>';
                    $num = 0;
                    foreach ($collection as $block) {
                        $xml.= '<admin_block>';
                        foreach ($options as $opt) {
                            $xml.= '<'.$opt.'><![CDATA['.$block->getData($opt).']]></'.$opt.'>';
                        }
                        $xml.= '</admin_block>';
                        $num++;
                    }
                    $xml.= '</permissions>';
                $xml.= '</root>';
               // $this->_sendUploadResponse($fileName, $xml);
                $theme = Mage::getStoreConfig('design/theme/default', $storeId);
                if(!$theme) $theme = 'default';
                $moduleName = 'Magiccart_Magicinstall'; //'Magiccart_' . ucfirst(Mage::app()->getRequest()->getModuleName());
                $folder = Mage::getModuleDir('etc', $moduleName) .DIRECTORY_SEPARATOR. $this->dir .DIRECTORY_SEPARATOR. $theme;
                @mkdir($folder, 0644, true);
                $doc =  new DOMDocument('1.0', 'UTF-8');
                $doc->loadXML($xml);
                $doc->formatOutput = true;
                $doc->save("$folder/$fileName");
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Export (%s) Permissions Blocks:', $num)
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


<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 15:01:10
 * @@Modify Date: 2015-05-05 21:26:30
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Adminhtml_SystemController extends Mage_Adminhtml_Controller_Action
{

    protected $dir = 'import';
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('magiccart/magicinstall')
            ->_title(Mage::helper('magicinstall')->__('Manage Export System Config'))
            ->_addBreadcrumb(Mage::helper('magicinstall')->__('Manage Export System Config'), Mage::helper('magicinstall')->__('Manage Export System Config'));
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction() 
    {
        $this->newAction();
    }

    public function editAction() 
    {
        $this->_initAction()
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock('magicinstall/adminhtml_system_edit'))
            ->_addLeft($this->getLayout()->createBlock('magicinstall/adminhtml_system_edit_tabs'));
        $this->renderLayout();
    }

    public function newAction() 
    {
        $this->_forward('edit');
    }

    public function saveAction() 
    {
        $this->_forward('exportXml');
    }

    /**
     *  Export page grid to XML format
     */
    public function exportXmlAction()
    {
        $fileName   = 'system.xml';
        try 
        {
            $storeId = (int) $this->getRequest()->getParam('store_id', 0);
            $doc     =  new DOMDocument('1.0', 'UTF-8');
            $root    = $doc->createElement('root');
            $system  = $doc->createElement('system');
            $doc->appendChild( $root );
            $etcPath = Mage::getBaseDir('etc');
            $ite     = new RecursiveDirectoryIterator($etcPath);
            $num = 0;
            foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) 
            {
                if(is_file($filename)){
                    if(preg_match('/^Magiccart_/', basename($filename))) {
                        // Change Node XML
                        $xmlObj = new Varien_Simplexml_Config($filename);
                        $module = $xmlObj->getNode('modules')->children()->getName();
                        $systemXml = Mage::getModuleDir('etc', $module). DIRECTORY_SEPARATOR .'system.xml';
                        $configXml = Mage::getModuleDir('etc', $module). DIRECTORY_SEPARATOR .'config.xml';
                        if(file_exists($systemXml)){
                            $cfgXmlObj = new Varien_Simplexml_Config($configXml);
                            $default = $cfgXmlObj->getNode('default')->asArray();
                            // var_dump($default);die;
                        }
                        if(file_exists($systemXml)){
                                $sysXmlObj = new Varien_Simplexml_Config($systemXml);
                                $sections = $sysXmlObj->getNode('sections')->children();
                                foreach ($sections as $section) {
                                    $section = $section->getName();
                                    $collection = Mage::getStoreConfig($section, $storeId); 
                                    foreach ($collection as $key => $group) {
                                        if(is_array($group)){
                                            foreach ($group as $k => $vl) {

                                                if(isset($default[$section][$key][$k])){
                                                    if($vl == $default[$section][$key][$k]) continue;
                                                }else {
                                                    if($vl == '') continue;
                                                }
                                                $config = $doc->createElement( 'config' );
                                                $path   = $doc->createElement( 'path' );
                                                $path->nodeValue = $section .'/'. $key .'/'. $k;
                                                $value  = $doc->createElement( 'value' );
                                                $value->nodeValue = $vl;
                                                $config->appendChild( $path );
                                                $config->appendChild( $value );
                                                $system->appendChild( $config );
                                                $root->appendChild( $system );
                                                $num++;
                                            }
                                        }
                                    }
                                }
                        }
                        // End change Node XML
                    }
                }
            } // End foreach
            $extraCfg = array(
                'web/default/front',
                'web/default/cms_home_page',
                'design/theme/default',
                'design/package/name',
                'catalog/product_image/small_width',
            );
            foreach ($extraCfg as $cfg) {
                $vl = Mage::getStoreConfig($cfg, $storeId); 
                $config = $doc->createElement( 'config' );
                $path   = $doc->createElement( 'path' );
                $path->nodeValue = $cfg;
                $value  = $doc->createElement( 'value' );
                $value->nodeValue = $vl;
                $config->appendChild( $path );
                $config->appendChild( $value );
                $system->appendChild( $config );
                $root->appendChild( $system );
                $num++;
            }
            // $this->_sendUploadResponse($fileName, $xml);
            $themeCfg = array(
                'design/theme/default',
                'design/theme/layout',
                'design/theme/skin',
                'design/theme/template',
                'design/theme/locale'
                );
            foreach ($themeCfg as $cfg) {
                $theme = Mage::getStoreConfig($cfg, $storeId);
                if($theme) break;
            }
            if(!$theme) $theme = 'default';
            $moduleName = 'Magiccart_' . ucfirst(Mage::app()->getRequest()->getModuleName());
            $folder = Mage::getModuleDir('etc', $moduleName) .DIRECTORY_SEPARATOR. $this->dir .DIRECTORY_SEPARATOR. $theme;
            @mkdir($folder, 0644, true);
            $doc->formatOutput = true;
            $doc->save("$folder/$fileName");
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Export (%s) System Config:', $num));
        } catch (Exception $e) {
             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/edit');
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


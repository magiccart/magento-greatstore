<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-12-02 15:31:24
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicproduct_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{

    protected $router = array('bestseller', 'featured', 'mostviewed', 'newproduct', 'saleproduct',);
	public function initControllerRouters($observer)
	{
		$front = $observer->getEvent()->getFront();
		$front->addRouter('magicproduct', $this); // $this: new Magiccart_Magicproduct_Controller_Router();
	}

    public function match(Zend_Controller_Request_Http $request)
    {
        if (!Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }

        $identifier = trim($request->getPathInfo(), '/');

        $condition = new Varien_Object(array(
            'identifier' => $identifier,
            'continue'   => true
        ));
        Mage::dispatchEvent('magicproduct_controller_router_match_before', array(
            'router'    => $this,
            'condition' => $condition
        ));
        $identifier = $condition->getIdentifier();

        if ($condition->getRedirectUrl()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect($condition->getRedirectUrl())
                ->sendResponse();
            $request->setDispatched(true);
            return true;
        }

        if (!$condition->getContinue()) return false;

		if(!in_array($identifier, $this->router)) return false;

        $request->setModuleName('magicproduct')
            ->setControllerName('index')
            ->setActionName('product')
            ->setParam('type', $identifier);
        $request->setAlias(
            Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
            $identifier
        );

        return true;

	}
}

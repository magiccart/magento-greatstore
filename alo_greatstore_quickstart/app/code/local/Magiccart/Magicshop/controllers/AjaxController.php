<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-26 13:44:47
 * @@Modify Date: 2015-04-02 09:37:02
 * @@Function:
 */
?>
<?php
require_once "Mage/Checkout/controllers/CartController.php";
class Magiccart_Magicshop_AjaxController extends Mage_Checkout_CartController
{
    public function indexAction()
    {
        $idProduct = Mage::app()->getRequest()->getParam('product_id');
        $IsProductView = Mage::app()->getRequest()->getParam('IsProductView');
        $params = Mage::app()->getRequest()->getParams();
        unset($params['product_id']);
        unset($params['IsProductView']);
        $product = Mage::getModel('catalog/product')->setStoreId(Mage::app()->getStore()->getId())->load($idProduct);
        $responseText = '';
        if ($product->getId())
        {
            try{
                if(($product->getTypeId() == 'simple' && !($product->getRequiredOptions())) || count($params) > 0 || ($product->getTypeId() == 'virtual' && !($product->getRequiredOptions()))){
                    if(!array_key_exists('qty', $params)) {
                        $params['qty'] = $product->getStockItem()->getMinSaleQty();  
                    }

                    $related = $this->getRequest()->getParam('related_product');

                    $cart = Mage::getSingleton('checkout/cart');
                    $cart->addProduct($product, $params);
                    if (!empty($related)) {
                        $related = explode(',', $related);
                        $cart->addProductsByIds($related);

                    }
                    $cart->save();
                    Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
                    if (!$cart->getQuote()->getHasError()){

                        $related = Mage::getModel('catalog/product')->getCollection()                
                                                ->addAttributeToFilter('entity_id', array('in' => $related))
                                                ->addAttributeToSelect('name')
                                                ->addAttributeToSelect('small_image');

                        $responseText = $this->addToCartResponse($product, $related, $cart, $IsProductView, $params,0);    
                    }    
                }else {
                     $responseText = $this->showOptionsResponse($product, $IsProductView);    
                }
                    
            }
            catch (Exception $e) {
                $responseText = $this->addToCartResponse($product, $related, $cart, $IsProductView, $params, $e->getMessage());
                Mage::logException($e);
            }
        } else {
            $responseText = $this->__('Not found product');
        }
        $this->getResponse()->setBody($responseText);
    }
    
    private function showOptionsResponse($product, $IsProductView)
	{
        Mage::register('current_product', $product);                  
        Mage::register('product', $product);         
        $block = Mage::app()->getLayout()->createBlock('catalog/product_view', 'catalog.product_view');
        $textScript = ('true' == !$IsProductView)? ' optionsPrice['.$product->getId().'] = new Product.OptionsPrice('.$block->getJsonConfig().');': '';
        $html  ='<div class="options">';
		$html .='<p><span class="product-name">'.$product->getName().'</span></p>';
        $html .= '<script type="text/javascript">
                    optionsPrice = new Product.OptionsPrice('.$block->getJsonConfig().'); 
                    '.$textScript.'  
                 </script>';
        $html .= '<form id="product_addtocart_form" enctype="multipart/form-data">'; 
        $js = Mage::app()->getLayout()->createBlock('core/template', 'product_js')->setTemplate('catalog/product/view/options/js.phtml');
        $js->setProduct($product);
        $html .= $js->toHtml();
        // $html .= '<img class="image" src="' .Mage::helper('catalog/image')->init($product, 'small_image')->resize(55).'" />';
        $options = Mage::app()->getLayout()->createBlock('catalog/product_view_options', 'product_options')
                            ->setTemplate('catalog/product/view/options.phtml')
                            ->addOptionRenderer('text', 'catalog/product_view_options_type_text', 'catalog/product/view/options/type/text.phtml')
                            ->addOptionRenderer('select', 'catalog/product_view_options_type_select', 'catalog/product/view/options/type/select.phtml')
                            ->addOptionRenderer('file', 'catalog/product_view_options_type_file', 'catalog/product/view/options/type/file.phtml')
                            ->addOptionRenderer('date', 'catalog/product_view_options_type_date', 'catalog/product/view/options/type/date.phtml');
        $options->setProduct($product);
        $html .= $options->toHtml();                                            
         
        if ($product->isConfigurable()){
            $configurable = Mage::app()->getLayout()->createBlock('catalog/product_view_type_configurable', 'product_configurable_options');
            $configurable ->setTemplate('catalog/product/view/type/options/configurable.phtml');   
            /* color swatcher */
            $swatcher =  Mage::app()->getLayout()->createBlock('configurableswatches/catalog_product_view_type_configurable_swatches', 'color_swatcher');
            if($swatcher){
                $attr_renderers = $swatcher->setTemplate('configurableswatches/catalog/product/view/type/options/configurable/swatches.phtml');
                $configurable->setChild('attr_renderers', $attr_renderers); 
            } 
            /* end color swatcher */			
            $configurableData = Mage::app()->getLayout()->createBlock('catalog/product_view_type_configurable', 'product_type_data')
                            ->setTemplate('catalog/product/view/type/configurable.phtml');
            $configurable->setProduct($product);
            $configurableData->setProduct($product);
            $htmlCong = $configurable->toHtml();
            $html .= $htmlCong.$configurableData->toHtml();
        } else if($product->isGrouped()){
              $blockGr = Mage::app()->getLayout()->createBlock('catalog/product_view_type_grouped', 'catalog.product_view_type_grouped')
                                                 ->setTemplate('catalog/product/view/type/grouped.phtml'); 
              $html .= $blockGr->toHtml();                                                                             
        } else if ($product->getTypeId() == 'downloadable')
        {
            $downloadable = Mage::app()->getLayout()->createBlock('downloadable/catalog_product_links', 'product_downloadable_options')
                            ->setTemplate('downloadable/catalog/product/links.phtml');
			$html .= $downloadable->toHtml();
		}

        if($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE){
			 $blockBn = Mage::app()->getLayout()->createBlock('bundle/catalog_product_view_type_bundle', 'product.info.bundle.options') ;                                           
			 $blockBn ->addRenderer('select', 'bundle/catalog_product_view_type_bundle_option_select');
			 $blockBn->addRenderer('multi', 'bundle/catalog_product_view_type_bundle_option_multi');
			 $blockBn->addRenderer('radio', 'bundle/catalog_product_view_type_bundle_option_radio', 'bundle/catalog/product/view/type/bundle/option/radio.phtml');
			 $blockBn->addRenderer('checkbox', 'bundle/catalog_product_view_type_bundle_option_checkbox', 'bundle/catalog/product/view/type/bundle/option/checkbox.phtml');
			 $blockBn->setTemplate('bundle/catalog/product/view/type/bundle/options.phtml');
			 $html .= $blockBn->toHtml();
			 $blockBn->setTemplate('bundle/catalog/product/view/type/bundle.phtml');
			 $html .= $blockBn->toHtml();
        }else {
            $price = Mage::app()->getLayout()->createBlock('catalog/product_view', 'product_view')
                                ->setTemplate('catalog/product/view/price_clone.phtml');
            $html .= $price->toHtml();    
        }
          
        
        $html .= '</form>';
        $html .= '<div class="action-cart">';
            $html .= '<button class="button btn-cancel" title="'.$this->__('Cancel').'" type="button"><span><span>'.$this->__('Cancel').'</span></span></button>';
            $html .= '<button class="button btn-cart" title="'.$this->__('Add to Cart').'" type="button"><span><span>'.$this->__('Add to Cart').'</span></span></button>';
        $html .= '</div>';
        $html .= '</div>';
        $result = array(
            'dataOption'   =>  $html, 
            'action'       =>  'methods.sendAjax('.$product->getId().', 1);', 
            'add_to_cart'  =>  '0' ,
          );
         return Zend_Json::encode($result);    
    } 

    private function addToCartResponse($product, $related, $cart, $IsProductView, $params, $text)
	{
        $info  = '<div class="response">';
        $info .= '<p><span class="product-name">'.$product->getName().' '.$this->__('was added to your shopping cart').'</span></p>';
        // $info .= '<img class="image" src="' .Mage::helper('catalog/image')->init($product, 'small_image')->resize(100 ,130).'" />';
        $info .= '<div>';
        $result = array(
            'dataOption'  =>  $info, 
            'count'       =>  Mage::getSingleton('checkout/cart')->getSummaryQty()>1 ? ' (' . Mage::getSingleton('checkout/cart')->getSummaryQty(). $this->__(' items)') : ' (' . Mage::getSingleton('checkout/cart')->getSummaryQty(). $this->__(' item)'),
            'add_to_cart' =>  '1'
        );
        
        if($text){
             $result['dataOption'] = '<p>' . $text . '</p>';
        }else{
            
            Mage::unregister('current_product');
            Mage::unregister('product');
            Mage::register('current_product', $product);                  
            Mage::register('product', $product);
            
			$param_p=$this->_getProductRequest($params);
			if($param_p['options'] || $param_p['super_attribute'] || $param_p['bundld_options'] || $param_p['super_group'] || $param_p['links'])
			{
				$result['dataOption'].='<p> You can choose options : </p>';
			}
		
			if($param_p['options']){
				$result['dataOption'] .='<div class="option-custom">';
				foreach($param_p['options'] as $key_o=>$value_o){
					$result['dataOption'] .='<p>';
					$option=$product->getOptionById($key_o);
					$result['dataOption'] .='<span>'.$option->getTitle().':'.'</span>';
					$result['dataOption'] .= '<span >'.$value_o.'</span>';
					$result['dataOption'] .='</p>';
				}
				$result['dataOption'] .='</div>';
			}
			if($param_p['links']){
				$result['dataOption'] .='<div class="option-d">';
				$result['dataOption'] .='<p>'.$product->getLinksTitle().'</p>';
				$result['dataOption'] .='<ul>';
				foreach($param_p['links'] as $key_d=>$value_d){
					foreach($product->getDownloadableLinks() as $link){
						if($link->getId()==$value_d){
							$result['dataOption'] .='<li>'.$link->getTitle().'</li>';
							break;
						}
					}   
				}
				$result['dataOption'] .='</ul>';
				$result['dataOption'] .='</div>';
			}
			if($param_p['super_group']){
				$result['dataOption'] .='<div class="option-group">';
				foreach($param_p['super_group'] as $key_g=>$value_g){
					$model_p=Mage::getModel('catalog/product')->load($key_g);
					$result['dataOption'] .='<p><span>'.$model_p->getName().':'.'</span>';
					$result['dataOption'] .= '<span >'.$value_g.'</span></p>';
				}
				$result['dataOption'] .='</div>';
			}   
			if(count($param_p['super_attribute'])){
				$result['dataOption'] .='<div class="option-cf">';
				foreach($param_p['super_attribute'] as $key=>$value){
					$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $key);
					$result['dataOption'] .='<p><span>'.$this->__($attribute->getName()).':'.'</span>';
					$result['dataOption'] .= '<span>'.$attribute->getSource()->getOptionText($value).'</span></p>';
				}
				$result['dataOption'] .='</div>';
			}
			if($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE){
				$result['dataOption'].=$this->getBundleOptions($product);
			}
			/* relatedResponse */

			if(count($related)){
				$infoRelated = '<div class="info-related">';
				foreach ($related as $red) {
					$infoRelated .= '<p><span class="product-name">'.$red->getName().' '.$this->__('was added to your shopping cart').'</span></p>';
					$infoRelated .= '<img class="image" src="' .Mage::helper('catalog/image')->init($red, 'small_image')->resize(55).'" />';
				}
				$infoRelated .= '</div>';

                $result['dataOption'] .= $infoRelated;
			}
			/* end relatedResponse */
			$block = Mage::app()->getLayout()->createBlock('magicshop/ajaxcart', 'ajaxcart.js');
			/*
			if (Mage::getSingleton('checkout/cart')->getSummaryQty() == 1){
				$result['dataOption'] .=  "<p>".$this->__('There is') .' <a href="'.$block->getUrl('checkout/cart').'" id="items-count">1' . $this->__(' item') . '</a> '.$this->__('in your cart.')."</p>";    
			}else{
				$result['dataOption'] .=  "<p>".$this->__('There are') .' <a href="'.$block->getUrl('checkout/cart').'" id="items-count">'.Mage::getSingleton('checkout/cart')->getSummaryQty().  $this->__(' items') . '</a> '.  $this->__('in your cart.')."</p>";    
			}
			// summ price
			$result['dataOption'] .= '<p>' . $this->__('Cart Subtotal:') . ' <span class="total-price">' .  Mage::helper('checkout')->formatPrice($this->getSubtotal($cart)); 
			if ($_subtotalInclTax = $this->getSubtotalInclTax($cart)){
				$result['dataOption'] .= '<br />(' . Mage::helper('checkout')->formatPrice($_subtotalInclTax) .' ' . Mage::helper('tax')->getIncExcText(true). ')';
			}
			$result['dataOption'] .='</span></p>';
			//$result['dataOption'] .='<p><a class="button" href="'.Mage::getUrl('checkout/cart').'">View Cart</a><a class="button cart-continue">Continue</a></p>';
			$result['dataOption'] .= '<div class="action-cart">';
				$result['dataOption'] .= '<button onclick="setLocation('."'".Mage::getUrl('checkout/cart')."'".')" class="button btn-cart" title="'.$this->__('View Cart').'" type="button"><span><span>'.$this->__('View Cart').'</span></span></button>';
				$result['dataOption'] .= '<button class="button cart-continue" title="'.$this->__('Continue').'" type="button"><span><span>'.$this->__('Continue').'</span></span></button>';
			$result['dataOption'] .= '</div>';
			*/
        }
		
        $result = $this->replaceJs($result);
        return Zend_Json::encode($result);
    }
   
    public function cartAction()
    {   
        $_SERVER['REQUEST_URI'] = str_replace(Mage::getBaseUrl(), '/index.php/', $_SERVER['HTTP_REFERER']);
        $myCart = Mage::app()->getLayout()->createBlock('checkout/cart_sidebar', 'cart_sidebar')
                             ->setTemplate('checkout/cart/sidebar.phtml');
        $this->getResponse()->setBody($myCart->toHtml());
    }

    public function checkoutAction()
    {   
        $_SERVER['REQUEST_URI'] = str_replace(Mage::getBaseUrl(), '/index.php/', $_SERVER['HTTP_REFERER']); 
        $this->loadLayout(array('checkout_cart_index')); 
        $myCart = Mage::app()->getLayout('checkout_cart_index')->getBlock('checkout.cart');
        $this->getResponse()->setBody($myCart->toHtml());
    }
    
    public function reloadCartAction()
    { 
        $_SERVER['REQUEST_URI'] = str_replace(Mage::getBaseUrl(), '/index.php/', $_SERVER['HTTP_REFERER']); 
        $myCart = Mage::app()->getLayout()->createBlock('checkout/cart_sidebar', 'cart_sidebar')
                             ->setTemplate('magiccart/magicshop/checkout/cart/mini_cart.phtml');
        $this->getResponse()->setBody($myCart->toHtml());
    }

    public function getSubtotal($cart, $skipTax = true)
    {
        $subtotal = 0;
        $totals = $cart->getQuote()->getTotals();
        $config = Mage::getSingleton('tax/config');
        if (isset($totals['subtotal'])) {
            if ($config->displayCartSubtotalBoth()) {
                if ($skipTax) {
                    $subtotal = $totals['subtotal']->getValueExclTax();
                } else {
                    $subtotal = $totals['subtotal']->getValueInclTax();
                }
            } elseif($config->displayCartSubtotalInclTax()) {
                $subtotal = $totals['subtotal']->getValueInclTax();
            } else {
                $subtotal = $totals['subtotal']->getValue();
                if (!$skipTax && isset($totals['tax'])) {
                    $subtotal+= $totals['tax']->getValue();
                }
            }
        }
        return $subtotal;
    }
    
    public function getSubtotalInclTax($cart)
    {
        if (!Mage::getSingleton('tax/config')->displayCartSubtotalBoth()) {
            return 0;
        }
        return $this->getSubtotal($cart, false);
    }
    //replace js   
    private function replaceJs($result)
    {
         $arrScript = array();
         $result['script'] = '';               
         preg_match_all("@<script type=\"text/javascript\">(.*?)</script>@s",  $result['dataOption'], $arrScript);
         $result['dataOption'] = preg_replace("@<script type=\"text/javascript\">(.*?)</script>@s",  '', $result['dataOption']);
         foreach($arrScript[1] as $script){ 
             $result['script'] .= $script;                 
         }
         $result['script'] =  preg_replace("@var @s",  '', $result['script']); 
         return $result;
    }
	
	protected function _getProductRequest($requestInfo)
    {
        if ($requestInfo instanceof Varien_Object) {
            $request = $requestInfo;
        } elseif (is_numeric($requestInfo)) {
            $request = new Varien_Object(array('qty' => $requestInfo));
        } else {
            $request = new Varien_Object($requestInfo);
        }

        if (!$request->hasQty()) $request->setQty(1);

        return $request;
    }
	
	protected function getBundleOptions($product)
    {
		$html='<div>';
		$optionCollection = $product->getTypeInstance()->getOptionsCollection();
		$selectionCollection = $product->getTypeInstance()->getSelectionsCollection($product->getTypeInstance()->getOptionsIds());
		$options = $optionCollection->appendSelections($selectionCollection);
		foreach( $options as $option ){	
			$_selections = $option->getSelections();
			if(count($_selections)){
				foreach( $_selections as $selection ){
					if($selection->getName()){   
						$html .='<p class="option-bundle"><span>'.$option->getTitle().'</span></p>';
						$html .= '<p><span>'.$selection->getName().'</span></p>';
					}
				}
			}
			
		}
		$html .= '</div>';
        return $html;
    }

}

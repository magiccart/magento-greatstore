/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-30 14:27:05
 * @@Modify Date: 2015-10-26 23:16:30
 * @@Function:
 */
"use strict";
(function () {
    jQuery.fn.magiccart = function(options) {
    
        var defaults = jQuery.extend({
            miniCartWrap : '.miniCartWrap',
            wrapPopupAjaxcart : 'popupAjaxcart',
            miniMainCart : 'mini-maincart',
            miniContentCart : '.mini-contentCart', // '.mini-maincart',
            tickerMiniCart : '.mini-maincart', // 'a.top-link-cart',
            buttonCart : 'button.btn-cart',
            fly : false,
            loading : '',
            url : null,  
            updateUrl : null,   
            isProductView : 0,
            product_id : 0,
            notification : null,
            timeOut : 10000,
        }, options);
        
        /******************************
        Private Variables
         *******************************/
         
        var object      = null;
        // var baseUrl     = null;
        var settings    = jQuery.extend(defaults, options);
        var popupAjaxcart   = '';
        var bgPopup         = '';
        var loading         = '';
        var notification    = '';
        var popupWidth; // Declare the global width of each item in carousel
        var popupHeight; // Declare the global height of each item in carousel
        
        /******************************
        Public Methods
        *******************************/
        var methods = {
            init : function() {
                return this.each(function() {
                    methods.ajaxCartShoppCartLoad('button.btn-cart');
                });
            },
            
            /******************************
            Initialize Items
            Fully initialize everything. Plugin is loaded and ready after finishing execution
        *******************************/
            // initialize : function(options) {
            //     Object.extend(settings, options);
            // },

            getMagicUrl: function($ctrl){
                var ctrl = $ctrl || ''; // if(typeof $path == 'undefined') {path =''}
                return Themecfg.general.baseUrl + ctrl;
            },

            ajaxCartShoppCartLoad: function(buttonClass){
                methods.createMinicart();
                if(settings.isProductView) return;
                jQuery(buttonClass).each(function(){
                    var $this = jQuery(this);
                    var attrclick = $this.attr('onclick');
                    if(attrclick) $this.attr('magiccartEvent', attrclick.toString());
                    $this.attr('onclick', '');
                    // jQuery(this).click(this.searchIdAndSendAjax); // don't worked
                });
                jQuery(document).on("click", buttonClass , this.searchIdAndSendAjax);

                methods.createPopup();
            },

            sendAjax : function(idProduct, param, magiccartEvent) {
                // console.log(this);
                if(idProduct) {
                    var postData = 'product_id=' + idProduct;           
                    postData = this.addProductParam(postData);
                    if('' == postData) 
                        return true;
                    new Ajax.Request(settings.url, {
                        method: 'post',
                        postBody : postData,
                        onCreate: function (request) {
                            if(!popupAjaxcart){
                                popupAjaxcart = jQuery('#'+settings.wrapPopupAjaxcart);
                                notification = jQuery('#toPopup', popupAjaxcart)
                                loading = jQuery('.loading', popupAjaxcart);
                                bgPopup = jQuery('.overlay', popupAjaxcart);
                            } 
                            popupAjaxcart.show();
                            bgPopup.hide();
                            loading.show();
                            notification.hide();

                        },
                        onSuccess: function(transport) {
                            if (transport.responseText.isJSON()) {
                                var response = transport.responseText.evalJSON();
                                if (response.error) {
                                    alert(response.error);
                                }else{
                                    if(response.redirect) {
                                         //if IE7
                                        if (document.all && !document.querySelector) {
                                            magiccartEvent = magiccartEvent.substring(21, magiccartEvent.length-2)
                                            eval(magiccartEvent);
                                        }
                                        else{
                                            eval(magiccartEvent);    
                                        }
                                        return true;
                                    }
                                    this.showPopup(response.dataOption,response.add_to_cart,response.action);
                                    var maxHeight = parseInt($$('html')[0].getHeight()/4);
                                    var height  = notification.height();
                                    if(!(height <= maxHeight)) {
                                    notification.setStyle({
                                        overflowY : 'scroll', 
                                        maxHeight : maxHeight + 'px'
                                    });
                                    } 
                                    if(response.add_to_cart === '1'){
                                        this.updateCount(response.count); 
                                        this.updateShoppingCart(); 
                                        this.updateSidebarCart(); 
                                        this.updateMinicart(response.update_mini_cart);
                                        jQuery.fancybox.close();
                                    }    
                                }
                            }
                        }.bind(this),
                        onFailure: function()
                        {
                            this.hideAnimation();
                            eval(magiccartEvent);
                        }.bind(this)    
                    });
                }
            }, 
            
            addProductParam: function(postData) {
                var form = $('product_addtocart_form');
                if($$('#toPopup #product_addtocart_form')[0]){
                    form = $$('#toPopup #product_addtocart_form')[0];
                }  
                if(form) {
                    var validator = new Validation(form);
                    if (validator.validate()) postData += "&" + jQuery(form).serialize();
                    else return '';
                }
                postData += '&IsProductView=' + settings.isProductView;
                return postData;
            }, 
            
            createPopup : function(){
                if(!jQuery('#'+settings.wrapPopupAjaxcart).length) jQuery('body').append('<div id="'+settings.wrapPopupAjaxcart+'" style="display: none"><div id="toPopup"></div><div class="loading"></div><div class="overlay"></div><div>');
            },
            showPopup : function(data,isadd,action){
                var popupStatus     = 0;
                var notification    = jQuery('#toPopup', popupAjaxcart).html(data);
                var btnContinue     = jQuery('button.cart-continue', notification);
                // setTimeout(function(){
                    if(popupStatus == 0) { 
                        loading.fadeOut('normal');
                        popupAjaxcart.fadeIn(500); 
                        var isOption = popupAjaxcart.find('.options');
                        if(!isOption.length){
                            var time = 5;
                            //popupAjaxcart.delay(time*1000).fadeOut(500);
							setTimeout(function() {
								popupAjaxcart.fadeOut(500);
							}, time*1000);
                            popupAjaxcart.find('#toPopup').append('<span class="countDown">'+time+'</span>');
                            var counter = popupAjaxcart.find('.countDown');
                            var countDown = function(){
                                var time = counter.html();
                                if (time<= 0) return;
                                else time-=1; 
                                counter.html(time);
                                setTimeout(function(){ countDown() }, 1000); 
                            }
                            countDown();
                        }
                        bgPopup.css("opacity", "0.8");
                        bgPopup.fadeIn(100);
                        notification.fadeIn(100);
                        popupStatus = 1;
                    }
                // },200);
                if(isadd=='1'){
                    setTimeout(function(){
                        if(popupStatus == 1) {
                            popupAjaxcart.fadeOut("normal");
                            popupStatus = 0; 
                        }
                    },settings.timeOut);
                    btnContinue.click(function() {
                        if(popupStatus == 1) {
                            popupAjaxcart.fadeOut("normal");
                            popupStatus = 0; 
                        }
                    });
                } else{ // if(isadd=='0')
                    // action options inPopup       
                    var btnCart  = jQuery('button.btn-cart', notification);
                    btnCart.click(function(){ eval(action) });
                    var btnCancel = jQuery('button.btn-cancel', notification);
                    btnCancel.click(function(){ popupAjaxcart.fadeOut("normal").children('#toPopup').empty() });
                }
                bgPopup.click(function() {
                        if(popupStatus == 1) {
                            popupAjaxcart.fadeOut("normal").children('#toPopup').empty();
                            popupStatus = 0; 
                        }
                    });
            },
            
            updateSidebarCart : function() {
                if($$('.block-cart')[0]){
                    var url = this.getMagicUrl('magicshop/ajax/cart');
                    new Ajax.Updater($$('.block-cart')[0], url, {
                        method: 'post'
                    }); 
                    return true; 
                }
            },
            
            updateCount : function(count) {
                var topLinkCart = $$('a.top-link-cart')[0];
                if(topLinkCart){
                    var pos = topLinkCart.innerHTML.indexOf("(");
                    if(pos >= 0 && count) {
                        topLinkCart.innerHTML =  topLinkCart.innerHTML.substring(0, pos) + count;    
                    }
                    else{
                        if(count) topLinkCart.innerHTML =  topLinkCart.innerHTML + count;     
                    }
                };
            },
            
            updateShoppingCart : function() { // add cart in page checkout 
                if($$('body.checkout-cart-index div.cart')[0]){
                    var url = this.getMagicUrl('magicshop/ajax/checkout');
                    new Ajax.Request(url, {
                        method: 'post',
                        onSuccess: function(transport) {
                           if(transport.responseText) {
                                var response = transport.responseText;
                                var holderDiv = document.createElement('div');
                                holderDiv = $(holderDiv);
                                holderDiv.innerHTML = response; 
                                $$('body.checkout-cart-index div.cart')[0].innerHTML = holderDiv.childElements()[0].innerHTML;
                                if (typeof Themecfg != 'undefined'){ // for alothemes
                                    if(Themecfg.checkout.crosssellsSlide) crossSlide();
                                    methods.ajaxCartShoppCartLoad('button.btn-cart');
                                }
                            }       
                        }.bind(this),
                    });
                 }
            }, 

            createMinicart: function() {
                var mnCart = jQuery(settings.tickerMiniCart);
                if(mnCart.length) {
                    var container = mnCart.parent().children('.' +settings.miniMainCart);
                    if(!container.length){
                        container = document.createElement('div');
                        container = jQuery(container);
                        container.addClass(settings.miniMainCart);
                        container.hide();
                        if(mnCart.parent()){
                            mnCart.parent().append(container);
                            this.updateMinicart();   
                        }
                    }
                    mnCart.parent().mouseover(this.showMinicart);
                    mnCart.parent().mouseout(this.hideMinicart);
                    container.parent().mouseover(this.showMinicart);
                    container.parent().mouseout(this.hideMinicart);
					mnCart.parent().click(function(event) {jQuery(settings.miniContentCart).toggle(150)});
                    return;
                }
            },

            showMinicart: function() {
               jQuery(settings.miniContentCart).stop(true, true).delay(200).slideDown(200);
            },
            
            hideMinicart: function() {
                jQuery(settings.miniContentCart).stop(true, true).delay(200).fadeOut(500);
            },
            
            updateMinicart: function(content) {
                var elements = jQuery( '.' +settings.miniMainCart);
                if(content) {
                    elements.each(function() {
                        jQuery(this).parent().html(content);
                    });
                } else {
                    var url = this.getMagicUrl('magicshop/ajax/reloadCart');
                    jQuery.ajax({ url : url, type : "post", success : function (result){ elements.each(function() { jQuery(this).parent().html(result) }) } });
                }
            },

            searchIdAndSendAjax: function(event) {
                // console.log(this);
                event.preventDefault();
                var element = jQuery(event.target);
                var elObj = element.is(':button') ? element : jQuery(element).closest(':button');
                // var elProduct = element.match('li') ? element : element.up('li'); 
                var magiccartEvent = elObj.attr('magiccartEvent');
                if(settings.fly) methods.showAnimation(element);
                if($('confirmBox')) {
                    jQuery(function($) {
                        $.confirm.hide();
                    })
                }

                if(settings.isProductView && settings.product_id){
                    methods.sendAjax(settings.product_id, '', magiccartEvent);
                    return;
                }
                var idProduct = methods.searchIdIdProduct(elObj);
                if(idProduct){
                    methods.sendAjax(idProduct, '', magiccartEvent);
                    return;
                }
                if(magiccartEvent) eval(magiccartEvent);
            },
            searchIdIdProduct: function(elObj){
                var idProduct = 0;
                var magiccartEvent = elObj.attr('magiccartEvent');
                if(magiccartEvent != undefined) {
                    var idProduct = magiccartEvent.match(/product(.?)+form_key/);
                    if(idProduct) idProduct = idProduct[0].replace(/[^\d]/gi, '');
                    else{ // for page compare
                        idProduct = magiccartEvent.match(/product(.?)+uenc/);
                        if(idProduct) idProduct = idProduct[0].replace(/[^\d]/gi, '');
                    }
                    if(parseInt(idProduct) > 0) return parseInt(idProduct);
                }
                var elObjProduct = elObj.closest('li.item');
                var idPrice = elObjProduct.find('[id^="product-price"]');
                if(idPrice.length) idProduct = idPrice.attr('id').replace(/[^\d]/gi, '');
                if(idProduct) return idProduct;

                var addToLinks = elObjProduct.find('.add-to-links');
                if(addToLinks.length){
                    var compareLink = addToLinks.find('a.link-compare');
                    if(compareLink.length){
                        idProduct = compareLink.attr('href').match(/product(.?)+uenc/);
                        if(idProduct) idProduct = idProduct[0].replace(/[^\d]/gi, '');
                    }
                    if(!idProduct){
                    	var wishlistLink = addToLinks.find('a.link-wishlist');
	                    if(wishlistLink.length){
	                        idProduct = wishlistLink.attr('href').match(/product(.?)+form_key/);
	                        if(idProduct) idProduct = idProduct[0].replace(/[^\d]/gi, '');
	                    }
                    }
                    if(parseInt(idProduct) > 0) return parseInt(idProduct);
                }

                if($$("input[name='product']")[0] && $$("input[name='product']")[0].value) {
                    idProduct = $$("input[name='product']")[0].value;
                    if(parseInt(idProduct) > 0) return parseInt(idProduct); 
                }
                return 0;
            },
            showAnimation: function(element) {
                var cart=jQuery(settings.tickerMiniCart);
                var currentImg = {};
                if(jQuery('.product-view').length>0){
                    if(jQuery('#qty').val()>0 && jQuery('.validation-failed').length==0){
                        var currentImg = jQuery('.product-view').find('.product-image img');
                    } else {
                        jQuery('.qty').each(function() { // Grouped Product
                            if(jQuery(this).val()) {
                                var currentImg = jQuery('.product-view').find('.product-image img');
                                return false; // break each jQuery;
                            }
                        });
                    }
                }else{
                    var currentImg = jQuery(element).parents('.item').find('.product-image img');
                }
                if(currentImg.length){
                    var imgclone = currentImg.clone()
                        .offset({ top:currentImg.offset().top, left:currentImg.offset().left })
                        .addClass('imgfly')
                        .css({'opacity':'0.7', 'position':'absolute', 'height':'180px', 'width':'180px', 'z-index':'1000'})
                        .appendTo(jQuery('body'))
                        .animate({
                            'top': cart.offset().top + 10,
                            'left':cart.offset().left + 10,
                            'width':55,
                            'height':55
                        }, 1000, 'easeInOutExpo');
                    imgclone.animate({'width':0, 'height':0});
                }
               
            } 
        };
        if (methods[options]) { // $("#element").pluginName('methodName', 'arg1', 'arg2');
            return methods[options].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof options === 'object' || !options) { // $("#element").pluginName({ option: 1, option:2 });
            return methods.init.apply(this);
        } else {
            $.error('Method "' + method + '" does not exist in magiccart plugin!');
        }
    }
})(jQuery);

/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-04-25 13:16:48
 * @@Modify Date: 2015-02-12 20:05:15
 * @@Function:
 */

(function ($) {
	"use strict";
    $.fn.magicproduct = function (options) {
        var defaults = {
            //selector : '.magicproduct', // Selector product grid
            tabs 	 : '.magictabs',
            loading  : '.ajax_loading',
            product  : '.content-products',
            margin 	 : 30, // Margin product
        };
        var options = $.extend(defaults, options);
        return this.each(function () {
            //var selector 	= options.selector;
            var tabs 	 	= options.tabs;
            var loading 	= options.loading;
            var product 	= options.product;
            var margin 		= options.margin;
			var $content 	= $(this);
			var $tabs 		= $(tabs, $content);
			var $infotabs 	= $tabs.data('ajax')
			var $itemtabs 	= $('.item',$tabs);
			var $loading 	= $(loading, $content);

			magicProduct();
			$itemtabs.click(function() {
				var $this 	= $(this);
				var type  	= $this.data('type');
				var info 	= $infotabs;
				//var info 	= $infotabs.push(type:type);
				var $class 	= '.mc-'+type;
				var $product = $(product, $content);
				var $cnt_type = $($class, $product);

				if(type != "random" && $this.hasClass('active')) return;
				$itemtabs.removeClass('active');
				$this.addClass('active');
				if(type != "random" && $this.hasClass('loaded')){
					resetAnimate($cnt_type);
					$product.children().hide();  // not fadeOut()
					$($class, $product).fadeIn(); // not show()
					setAnimate($cnt_type); //require for Animate
					magicProduct();
				} else {
					if(type == undefined) return;
					$loading.show();
					$.ajax({
						type: 'post',
						data: { type: type, info: info },
						url : $loading.data('url'),
						success:function(data){
							$loading.hide();
							$(product, $content).children().hide();
							if(type=='random') $($class, $(product, $content)).remove();
							$(product, $content).append(data);
							$itemtabs.each(function(){
								if($(this).data('type') == type) $(this).addClass('loaded');
							});
							magicProduct();
							$product.magiccart({url: getMagicUrl('magicshop/ajax')});  // callback ajaxcart
							$product.quickview({
								// itemClass : '.products-grid li.item', //selector for each items in catalog product list,use to insert quickview image
								itemClass : '.products-grid .item', //selector for each items in catalog product list,use to insert quickview image
								aClass : 'a.product-image', //selector for each a tag in product items,give us href for one product
								imgClass: '.product-image img' //class for quickview href product-collateral
							});	
						}
					});
				}
			});

			function magicProduct(){
				var $product = $(product, $content);
				var $slide  = $product.data('slider');
				if($slide) getSlider(); else gridProduct();
			}

			// slide Product
			function getSlider(){
				$itemtabs.each(function() {
					var $this = $(this);
					if($this.hasClass('active')){
						var type = $this.data('type');
						var $class = '.mc-'+type;
						var $product = $(product, $content);
						var $content_active = $($class, $product);
						var $options  = $product.data('slider');
						var slide = $('.flexisel-content', $content_active);
						slide.bxSlider( $options );
					}
				});
			}

			// Grid Product
			function gridProduct(){
				var $window  = $(window).width();
				var $tabs 		= $(tabs, $content);
				var $itemtabs 	= $('.item.active',$tabs);
				var $type 	 = '.mc-' + $itemtabs.data('type');
				var $product = $(product, $content);
				var $pdt 	 = $($type, $product);
				var $options = $product.data('options');
				var margin 	 = $product.data('margin');

				setReponsive($window);
				$(window).resize(function(){
					var $window = $(window).width();
					setReponsive($window);
			 	})

				function setReponsive($window){
					var $items 	 = $('.item', $pdt);
					var $width 	 = $content.parent().width();
					var n = 0;
					$.each($options, function(i, v){
						if(!n) n = parseInt(v);
					    if (i <= $window) n = parseInt(v); else return false;
					});
					calculator($items, n, $width, margin); // break jQuery.each()
				}		

		 		function calculator($items, n, $width, margin){	
					var temp = ($width- margin*(n-1))/n;
					var width = (temp*n + Math.floor(temp))/(n + 1); // approximately down
					$items.each(function(idx) {
						$(this).width(width);
						if(idx % n ==0) $(this).css({"margin-left": "0", "clear": "both"});
						else $(this).css({"margin-left": margin, "clear": ""});
					});	
			 	}
			}

			// Effect
			function resetAnimate(cnt){
				var parent = cnt.parent();
				$('.products-grid', parent).removeClass("play");
				$('.products-grid .item', parent).removeAttr('style');
			}

			function setAnimate(cnt, time){
				var animate = cnt;
				var  time = time || 300; // if(typeof time == 'undefined') {time =300}
				var $_items = $('.item-animate', animate);
				$_items.each(function(i){
					$(this).attr("style", "-webkit-animation-delay:" + i * time + "ms;"
						                + "-moz-animation-delay:" + i * time + "ms;"
						                + "-o-animation-delay:" + i * time + "ms;"
						                + "animation-delay:" + i * time + "ms;");
					if (i == $_items.size() -1){
						$('.products-grid', animate).addClass("play");  // require for Animate
					}
				});
			}

        });

    };

})(jQuery);


/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-06-30 14:27:05
 * @@Modify Date: 2015-10-27 08:31:29
 * @@Function:
 */

 /* Timer */
var mcTimer =1;
if (typeof(BackColor)=="undefined") BackColor = "white";
if (typeof(ForeColor)=="undefined") ForeColor= "black";
//if (typeof(DisplayFormat)=="undefined") DisplayFormat = "<span class='day'>%%D%%</span><span style='margin:0px 4px'>:</span><span class='hour'>%%H%%</span><span style='margin:0px 4px'>:</span><span class='min'>%%M%%</span><span style='margin:0px 4px'>:</span><span class='sec'>%%S%%</span>";
if (typeof(CountActive)=="undefined") CountActive = true;
if (typeof(FinishMessage)=="undefined") FinishMessage = "";
if (typeof(CountStepper)!="number") CountStepper = -1;
if (typeof(LeadingZero)=="undefined") LeadingZero = true;
CountStepper = Math.ceil(CountStepper);
if (CountStepper == 0) CountActive = false;
var SetTimeOutPeriod = (Math.abs(CountStepper)-1)*1000 + 990;
function calcage(secs, num1, num2) {
    s = ((Math.floor(secs/num1)%num2)).toString();
    if (LeadingZero && s.length < 2) s = "0" + s;
    return "<b>" + s + "</b>";
}
function CountBack(secs,iid,mcTimer) {
    if (secs < 0) {
        document.getElementById(iid).innerHTML = FinishMessage;
        // document.getElementById('caption'+mcTimer).style.display = "none";
        // document.getElementById('heading'+mcTimer).style.display = "none";
        return;
    }
    DisplayStr = DisplayFormat.replace(/%%D%%/g, calcage(secs,86400,100000));
    DisplayStr = DisplayStr.replace(/%%H%%/g, calcage(secs,3600,24));
    DisplayStr = DisplayStr.replace(/%%M%%/g, calcage(secs,60,60));
    DisplayStr = DisplayStr.replace(/%%S%%/g, calcage(secs,1,60));
    document.getElementById(iid).innerHTML = DisplayStr;
    if (CountActive) setTimeout(function(){CountBack((secs+CountStepper),iid,mcTimer)}, SetTimeOutPeriod);
}
/* End Timer */

// function getMagicUrl($ctrl){
//     var ctrl = $ctrl || ''; // if(typeof $path == 'undefined') {path =''}
//     var protocol = window.location.protocol;
//     var domain = Mage.Cookies.domain.substr(1);
//     var path = '/';
//     if(Mage.Cookies.path != path) path = Mage.Cookies.path +'/';
//     var url = protocol + '//' + domain + path;   // http://domain.com/ or / https://domain.com/magento/
//     return url + ctrl;
// }
function getMagicUrl($ctrl){
    var ctrl = $ctrl || ''; // if(typeof $path == 'undefined') {path =''}
    return Themecfg.general.baseUrl + ctrl;
}
function crossSlide(){
	if(Themecfg.crosssell.slide >0){
		var modeSlide = parseInt(Themecfg.crosssell.vertical);
		modeSlide = (modeSlide > 0 ) ? 'vertical' : 'horizontal';
		jQuery("ul#crosssell-products-list").bxSlider({
			slideWidth: parseInt(Themecfg.crosssell.slideWidth),
			infiniteLoop: true,
			mode: modeSlide,
			controls: parseInt(Themecfg.crosssell.controls),
			pager: parseInt(Themecfg.crosssell.pager),
			moveSlides: 1,
			minSlides: 4,
			visibleItems: parseInt(Themecfg.crosssell.visibleItems),
			maxSlides: parseInt(Themecfg.crosssell.visibleItems),
			slideMargin: parseInt(Themecfg.crosssell.slideMargin),
			responsiveBreakpoints : {480: parseInt(Themecfg.crosssell.portrait), 640: parseInt(Themecfg.crosssell.landscape), 768: parseInt(Themecfg.crosssell.tablet), 992: parseInt(Themecfg.crosssell.desktop)}			
		});				
	}
}
jQuery(document).ready(function($) {

	var specialOffer = $('#header-offer');
	specialOffer.find('.header-offer-close').click(function() {
		specialOffer.slideUp('slow');
	});

	/* Tabs in product detail */
	(function(selector){
		var $content = $(selector);
		var $child   = $content.children('.box-collateral');
		if(Themecfg.detail.inforTabs){
			var activeTab = Themecfg.detail.activeTab;
			var activeContent = $content.children('.box-collateral.'+activeTab);
			if(activeContent.length){
				activeContent.addClass('active');
			} else {
				$content.children('.box-collateral').first().addClass('active');
			}
		}
        var ul = jQuery('<ul class="toggle-tabs"></ul>');
		$.each($child, function(index, val) {
			var title = $(this).children('h2').first().text();
			if(!title) title = $(this).children('.form-add').children('h2').first().text(); // for review
			var active = $(this).hasClass('active') ? 'active': '';
                var li = jQuery('<li class="item '+ active +'"></li>');
                li.html('<span>'+title+'</span>');
                ul.append(li);
		});
        ul.insertBefore($content);
        var $tabs =  ul.children();

        $tabs.click(function(event) {
        	$(this).siblings().removeClass('active'); // $tabs.removeClass('active');
        	$(this).addClass('active');
        	$child.hide();
        	$child.eq($(this).index()).show();

        });

	})('.product-view .product-collateral');

		if($.fn.bxSlider !== undefined){
			if(Themecfg.detail.slide > 0){
				var modeSlide = parseInt(Themecfg.detail.vertical);
				modeSlide = (modeSlide > 0 ) ? 'vertical' : 'horizontal';
				$(".product-image-thumbs").bxSlider({
					slideWidth: parseInt(Themecfg.detail.slideWidth),
					infiniteLoop: true,
					mode: modeSlide,
					controls: parseInt(Themecfg.detail.controls),
					pager: parseInt(Themecfg.detail.pager),
					moveSlides: 1,
					minSlides: 4,
					visibleItems: parseInt(Themecfg.detail.visibleItems),
					maxSlides: parseInt(Themecfg.detail.visibleItems),
					slideMargin: parseInt(Themecfg.detail.slideMargin),
					responsiveBreakpoints : {480: parseInt(Themecfg.detail.portrait), 640: parseInt(Themecfg.detail.landscape), 768: parseInt(Themecfg.detail.tablet), 992: parseInt(Themecfg.detail.desktop)}
				});
			}
			if(Themecfg.related.slide > 0){
				var modeSlide = parseInt(Themecfg.related.vertical);
				modeSlide = (modeSlide > 0 ) ? 'vertical' : 'horizontal';
	 			$("#block-related ul.mini-products-list").bxSlider({
					slideWidth: parseInt(Themecfg.related.slideWidth),
					infiniteLoop: true,
					mode: modeSlide,
					controls: parseInt(Themecfg.related.controls),
					pager: parseInt(Themecfg.related.pager),
					moveSlides: 1,
					minSlides: 4,
					visibleItems: parseInt(Themecfg.related.visibleItems),
					maxSlides: parseInt(Themecfg.related.visibleItems),
					slideMargin: parseInt(Themecfg.related.slideMargin),
					responsiveBreakpoints : {480: parseInt(Themecfg.related.portrait), 640: parseInt(Themecfg.related.landscape), 768: parseInt(Themecfg.related.tablet), 992: parseInt(Themecfg.related.desktop)}		
				});				
			}
			if(Themecfg.upsell.slide > 0){
				var modeSlide = parseInt(Themecfg.upsell.vertical);
				modeSlide = (modeSlide > 0 ) ? 'vertical' : 'horizontal';
				$("#upsell-product ul.up-sell-detail").bxSlider({
					slideWidth: parseInt(Themecfg.upsell.slideWidth),
					infiniteLoop: true,
					mode: modeSlide,
					controls: parseInt(Themecfg.upsell.controls),
					pager: parseInt(Themecfg.upsell.pager),
					moveSlides: 1,
					minSlides: 4,
					visibleItems: parseInt(Themecfg.upsell.visibleItems),
					maxSlides: parseInt(Themecfg.upsell.visibleItems),
					slideMargin: parseInt(Themecfg.upsell.slideMargin),
					responsiveBreakpoints : {480: parseInt(Themecfg.upsell.portrait), 640: parseInt(Themecfg.upsell.landscape), 768: parseInt(Themecfg.upsell.tablet), 992: parseInt(Themecfg.upsell.desktop)}				
				});				
			}

			crossSlide();

		}
		
	/* Light Box Image */
	if(Themecfg.detail.lightBox > 0){
	    $('.product-image-gallery .gallery-image, .product-view .view-full').click(function(e) {
	        e.preventDefault();
	        var currentImage = $(this).data('zoom-image');
	        var gallerylist = [];
	        var gallery = $('.product-image-gallery .gallery-image').not('#image-main');

	        gallery.each(function(index, el) {
	        	var img_src = $(this).data('zoom-image');       
				if(img_src == currentImage){
					gallerylist.unshift({
						href: ''+img_src+'',
						title: $(this).find('img').attr("title"),
						openEffect	: 'elastic'
					});	
				}else {
					gallerylist.push({
						href: ''+img_src+'',
						title: $(this).find('img').attr("title"),
						openEffect	: 'elastic'
					});
				}    	
	        });
	        $.fancybox(gallerylist);
	    });
	}
	/* Back to Top */

	(function(selector){
		var $backtotop = $(selector);
		$backtotop.hide();
		var height =  $(document).height();
		$(window).scroll(function () {
			var ajaxPopup = $('#toPopup');
			if(ajaxPopup.length) {
				var ajaxPosition = ajaxPopup.offset();
				ajaxPopup.css({
					top : ajaxPosition.top,
					position: 'absolute',
				});
			}
			if ($(this).scrollTop() > height/10) {
				$backtotop.fadeIn();
			} else {
				$backtotop.fadeOut();
			}
		});
		$backtotop.click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

	})('#backtotop');

	var $toggleTab  = $('.toggle-tab');
	$toggleTab.click(function(){
		$(this).parent().toggleClass('toggle-visible').find('.toggle-content').toggleClass('visible');
	});
	
	$('.main').on("click", '.alo_qty_dec', function(){
	    var input = $(this).parent().find('input');
        var value  = parseInt(input.val());
        if(value) input.val(value-1);
	});
    $('.main').on("click", '.alo_qty_inc', function(){
        var input = $(this).parent().find('input');
        var value  = parseInt(input.val());
        input.val(value+1);
    });

    /* animate */
	//if(WOW !== undefined) new WOW().init();
	/*var wi = jQuery(window).width();
	if (wi > 767){
	 new WOW().init();
	}*/

	/* elevator click*/ 
	(function(selector){
		var $megashop = $(selector);
		var length = $megashop.length;
		$megashop.each(function(index, el) {
			var elevator = $(this).find('.floor-elevator');
			elevator.attr('id', 'elevator-' +index);
			var bntUp 	= elevator.find('.btn-elevator.up');
			var bntDown = elevator.find('.btn-elevator.down');
			bntUp.attr('href', '#elevator-' + (index-1));
			bntDown.attr('href', '#elevator-' +(index+1));
			if(!index) bntUp.addClass('disabled');
			if(index == length-1) bntDown.addClass('disabled');
			elevator.find('.btn-elevator').click(function(e) {
				 e.preventDefault();
			    var target = this.hash;
			    if($(document).find(target).length <=0){
			        return false;
			    }
			    var $target = $(target);
			    $('html, body').stop().animate({
			        'scrollTop': $target.offset().top-50
			    }, 500);
			    return false;
			});
		});

	})('.megashop');
	
});


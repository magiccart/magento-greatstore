jQuery(function($) {
	var myhref,qsbtt;
	//read href attr in a tag
	function readHref(){
		var mypath = arguments[0];
		var patt = /\/[^\/]{0,}$/ig;
		if(mypath[mypath.length-1]=="/"){
			mypath = mypath.substring(0,mypath.length-1);
			return (mypath.match(patt)+"/");
		} else {
			var baseUrl = getMagicUrl();
			mypath = mypath.replace(baseUrl, "").replace('index.php', "");
			mypath[0] == "\/" ? mypath = mypath.substring(1,mypath.length) : mypath;
			return mypath;
		}
	}

    function getMagicUrl($ctrl){
        var ctrl = $ctrl || ''; // if(typeof $path == 'undefined') {path =''}
        return Themecfg.general.baseUrl + ctrl;
    }

	//string trim
	function strTrim(){
		return arguments[0].replace(/^\s+|\s+$/g,"");
	}

	function _qsJnit(){
		var selectorObj = arguments[0];
		var listprod = $(selectorObj.itemClass);
		var baseUrl = getMagicUrl('magicshop/quickview/view');
		if(!$('#magicshop_quickview_handler').length){
			var _qsHref = "<a id=\"magicshop_quickview_handler\" href=\"#\" style=\"visibility:hidden;position:absolute;top:0;left:0\"></a>";
			$(document.body).append(_qsHref);
		}
		var qsHandlerImg = $('#magicshop_quickview_handler');
		if(selectorObj.autoDetect){
			$.each(listprod, function(index, value) { 
				var reloadurl = baseUrl;
				//get reload url
				myhref = $(value).find(selectorObj.aClass );
				var prodHref = readHref(myhref.attr('href'));
				prodHref=strTrim(prodHref);
				reloadurl = baseUrl+"/?path="+prodHref;
				//end reload url

				$(selectorObj.imgClass, this).bind('mouseover', function() {
					var o = $(this).offset();
					qsHandlerImg.attr('href',reloadurl).show()
						.css({
							'top': o.top+($(this).height() - qsHandlerImg.height())/2+'px',
							'left': o.left+($(this).width() - qsHandlerImg.width())/2+'px',
							'visibility': 'visible'
						});
				});
				$(value).bind('mouseout', function() {
					qsHandlerImg.hide();
				});
			});

			//fix bug image disapper when hover
			qsHandlerImg.bind('mouseover', function() {
					$(this).show();
				})
				.bind('click', function() {
					$(this).hide();
					// $('#fancybox-loading span').css('background-image', 'url(' + MC.Quickview.QS_IMG_LOAD + ')');
					// $('#fancybox-loading-overlay').css('background-color', MC.Quickview.OVERLAYCOLOR );
				});

		} else {
			$('.link-quickview').click(function(event) {
				event.preventDefault();
				qsHandlerImg.attr('href', $(this).attr('href'));
				qsHandlerImg.trigger('click');
			});
		}

		//insert quickview popup
		qsHandlerImg.fancybox({
				'titleShow'			: false,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'autoDimensions'	: false,
				'maxHeight' 		:600,
				'scrolling'     	: 'no',
				'padding' 			:0,
  				'margin'			:0,
				'type'				: 'ajax',
				'overlayColor'		: '#353535',//MC.Quickview.OVERLAYCOLOR,
				beforeLoad : function(){ spConfig = false; isQuickview = true},
				afterClose : function(){ if(isQuickview) $('.zoomContainer').remove()},
				beforeShow : function(){
					var quickview = $('.quickview-main');
					var btnCart = quickview.find('button.btn-cart');
					btnCart.onclick = '';
					quickview.width(MC.Quickview.dialogWidth);
					btnCart.click(function( event ) {
						event.preventDefault();
					});
			        btnCart.magiccart({url: getMagicUrl('magicshop/ajax')});
			        var $thumbslide = $(".galleryimages");
			        var $typeslide  = $thumbslide.data('slide');
			        quickview.find(".product-image-thumbs").bxSlider({infiniteLoop: true , minSlides: 3, maxSlides: 3, slideMargin: 10, slideWidth: 150, pager:false, visibleItems: parseInt(Themecfg.detail.visibleItems), responsiveBreakpoints : {480: parseInt(Themecfg.detail.portrait), 640: parseInt(Themecfg.detail.landscape), 768: parseInt(Themecfg.detail.tablet), 992: parseInt(Themecfg.detail.desktop)}});
				   	ProductMediaManager.init();
					if(spConfig && typeof Product.ConfigurableSwatches != 'undefined'){
						var swatchesConfig = new Product.ConfigurableSwatches(spConfig);
					}
				},
				
		});

	}
	//end base function

	_qsJnit({
		// itemClass : '.products-grid li.item', //selector for each items in catalog product list,use to insert quickview image
		itemClass : '.products-grid .item', //selector for each items in catalog product list,use to insert quickview image
		aClass : 'a.product-image', //selector for each a tag in product items,give us href for one product
		imgClass: '.product-image img', //class for quickview href product-collateral
		autoDetect: false,
	});

	jQuery.fn.quickview = _qsJnit;
});


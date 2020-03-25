jQuery(document).ready(function($){
	(function(){
		var color = '#row_alodesign_base_color, #row_alodesign_header_color, #row_alodesign_left_color, #row_alodesign_right_color, #row_alodesign_content_color, #row_alodesign_footer_color, #row_alodesign_custom_color';
		var background = '#row_alodesign_base_background, #row_alodesign_header_background, #row_alodesign_left_background, #row_alodesign_right_background, #row_alodesign_content_background, #row_alodesign_footer_background, row_alodesign_custom_background';
		var border = '#row_alodesign_base_border, #row_alodesign_header_border, #row_alodesign_left_border, #row_alodesign_right_border, #row_alodesign_content_border, #row_alodesign_footer_border, row_alodesign_custom_border';
	    var selector = color  + ',' + background + ',' + border;
	    $(selector).on("click", 'button', function(){
	    	var input = $(selector).find(".color");
	    	input.each(function(index, el) {
	    		if(!$(this).parent().children('span').hasClass('mColorPickerTrigger')) $(this).attr("data-hex", true).width("116px").mColorPicker();
	    	});
	    });
	    $(selector).each(function(index, el) {
	    	$(this).find(" > td.label").hide();
	    	var readonly = $(this).find(".color.alo-readonly");
	    	if(readonly.length){
	    		$(this).find(".grid").width("690px");
	    		$(this).find("button").parent().hide();
		    	var container = readonly.parent().parent();
		    	// container.children(':last-child').hide();
		    	var title = container.children(':first-child');
		    	var inputs = title.find('input');
		    	inputs.each(function(index, el) {
			    	$(this).parent().append('<p style="width: 200px">' + $(this).val() + '</P>');	   		
		    	});
		    	inputs.hide();
		    	readonly.each(function(index, el) {
			    	if($(this).val() =='') $(this).parent().children().hide();	   		
		    	});
	    	}else {
	    		$(this).find(".grid").width("966px");
	    	}
	    });
		$fonts = $('select.mc-fonts');
		$size  = $('select.font-size', $fonts.parent().parent().parent());
		$size.change(function(){$fonts.trigger("click")});
		$fonts.each(function(index, val) {
			$(this).after('<div class="font_preview" style="padding: 10px">Preview this Font</div>');
		});
		$fonts.click(function() {
			var $item 	= $(this);
			var $parent = $item.parent();
			var $font 	= $item.val();
			var $size 	= $('select.font-size').val();
			previewFont($size, $font);
			//$item.bind("change", function() {
				var $size 	= $('select.font-size').val();
				var $font 	= $(this).val();
				previewFont($size, $font);
			//});
			function previewFont(size, font){ 
				var link = jQuery("<link>", {
		  			type: "text/css",
		  			rel: "stylesheet", 
		  			href: "//fonts.googleapis.com/css?family=" + font, 
				}).appendTo("head");
				//console.log(size);
				$('.font_preview', $parent).css({"font-size": size, "font-family": font});
			};
		})
	})(jQuery)
});

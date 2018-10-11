
jQuery( document ).ready(function() {
	b = false;
	$window = jQuery(window);
	if ($window.width() < 650 && jQuery('.panier-mobile').length) {
		
		$window.scroll(function () {
			

			if (b) {
				if (jQuery('#up-reserve').offset().top - $window.height() <= window.scrollY  && jQuery('#down-reserve').offset().top >= window.scrollY) {
					jQuery('.reserve_btn_mobile').animate({bottom : -50}); 
					b = false;
				}
			} else {
				if (jQuery('#up-reserve').offset().top - $window.height() >= window.scrollY  || jQuery('#down-reserve').offset().top <= window.scrollY) {

					if (window.scrollY > 1000) {
						jQuery('.reserve_btn_mobile').animate({bottom : 0}); 
						b = true;
					} 
					
				}
			}


			 

			
		});

		jQuery('.btn_mobile_down').on('click',function(){
            jQuery('html, body').animate({scrollTop: jQuery("#up-reserve").offset().top}, 300);
        });
	}
	
  
});

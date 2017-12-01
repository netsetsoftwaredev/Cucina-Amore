jQuery(document).ready(function(){
	jQuery('.contact-index-index .geninpara .genin').click(function(){
		jQuery(this).toggleClass('activ');
		jQuery('.contact-index-index .geninpara .geninchild').slideToggle();
	});
	jQuery('.contact-index-index .onsinqpara .onsin').click(function(){
		jQuery(this).toggleClass('activ');
		jQuery('.contact-index-index .onsinqpara .onsinchild').slideToggle();
	});
});
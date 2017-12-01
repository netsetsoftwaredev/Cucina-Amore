require(['jquery','owl.carousel/owl.carousel.min'],function($){
			$(function(){
				 $('.nutritional-trigger').on('click', function(){
					 $('.nutritional-form').show();
					
					});
					 
				$('.nutritional-trigger-close').on('click', function(){
					 $('.nutritional-form').removeClass('active');
					 $('.nutritional-form').hide();
					 $('body').removeClass('nutritional-open');
				});
			});
	$(document).ready(function(){
		/* our catalog script Start */
		$('.catlog-trigger').on('click', function(){
			
			$(this).next('.catlog-form01').addClass('active');
			$('body').addClass('catlog-open');
		});
		/*$('.btn-trigger').on('click', function(){
			$('.catlog-form02').addClass('active');
			$('.catlog-form01').removeClass('active');
		});*/
		$('.catlog-trigger-close').on('click', function(){
			$('.catlog-form01').removeClass('active');
			$('.catlog-form02').removeClass('active');
			$('body').removeClass('catlog-open');
		});
	 /* our catalog script End */
	 
	 
	 $('.search-close').on('click', function() {
		$('.block-search').removeClass('show');		 
	 });
		var owl = $('.cucina-carousel');
		owl.owlCarousel({
			margin: 0,
			nav: false,
			loop: true,
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		});
		
		$('.flavor-slider').owlCarousel({
			margin: 0,
			nav: false,
			loop: true,
			autoHeight:true,
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		});
		
		var halfCol = $('.half-col').height();
		$('.half-col.orange-color').css({'height':halfCol});
	});
	
	var owl = $('.kitchen-carousel');
	owl.owlCarousel({
		margin: 0,
		nav: true,
		loop: true,
		autoHeight:true,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
	$(document).on('click', '.cart-plus', function(){
		input = $(this).prev('input.item-qty');
		Currvalue = input.val();
		updatedVal = parseInt(Currvalue)+1;
		input.stop().val(updatedVal);
		$(this).parent().next('button').trigger('click');
	});
	$(document).on('click', '.cart-minus', function(){
		input = $(this).next('input.item-qty');
		Currvalue = input.val();
		if(parseInt(Currvalue) > 0)
		{
			updatedVal = parseInt(Currvalue)-1;
		}
		input.stop().val(updatedVal);
		$(this).parent().next('button').trigger('click');
	});
	
	var hgt = $('.read-bx').height()
	$(document).on('click', '.share-recipe a.read_more', function() {
	  $('.recip-desc .read-br').css({'height':hgt});
	});
	
	$(window).load(function(){
			var heIG = $('.year-moniter-list').outerHeight();
			$('.year-moniter-piller').css('height',heIG);
		});
		$(window).resize(function(){
			var heIG = $('.year-moniter-list').outerHeight();
			$('.year-moniter-piller').css('height',heIG);
		});
	var bannerImgSrc = $('.who-we-top-banner > img').attr('src');
	$('.who-we-top-banner').css('background-image', 'url(' + bannerImgSrc + ')');
	
	// for mega menu----
	$('.level0 > .level-top').next('.submenu').parents('li').addClass('down-arrow');
	    $('.tem-btn, .history-btn').click(function() {
				if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				  var target = $(this.hash);
				  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				  if (target.length) {
					$('html,body').animate({
					  scrollTop: target.offset().top
					}, 500);
					return false;
				  }
				}
	    });
		
	jQuery('.nutritional-form-trigger').on('click', function(){
		jQuery('.nutritional-form').css('display','none');
	});
	
});


require(['jquery'], function ($) {
    $(".minicart-wrapper").mouseover(function(){
		$(this).click();
		$(".action.showcart").click();		
	});
	/*$(".minicart-wrapper").mouseout(function(){
		$(".minicart-wrapper").removeClass("active");
		$(".action.showcart").removeClass("active");	
		$(".mage-dropdown-dialog").css("display", "none");				
	});	*/
});

/*require(['jquery'], function ($) {*/

require(['jquery','js/jquery.nice-select'],function($){
	   $('#sorter').niceSelect();
	   $('#mob-cats').niceSelect();
	   $('.catalogsearch-result-index .category-filter select').niceSelect();
	   $('select#job_category').niceSelect();
	   
	   
	   
});

require(['jquery','uiRegistry','js/jquery.nice-select'],function($){
	   setTimeout(function(){ $( "#product-options-wrapper .super-attribute-select" ).niceSelect();}, 5000);
	   
	   $("#attribute160").on('change',function(){
    		setTimeout(function(){ $("#attribute161").niceSelect('update');}, 500);
    	});
});

		 
		
		

jQuery(document).ready(function($) { "use strict";

	// Frame
	$('.su-frame-align-center, .su-frame-align-none').each(function() {
		var frame_width = $(this).find('img').width();
		$(this).css('width', frame_width + 12);
	});

	// Spoiler
	$('.su-spoiler .su-spoiler-title').click(function() {

		var // Spoiler elements
		spoiler = $(this).parent('.su-spoiler').filter(':first'),
		title = spoiler.children('.su-spoiler-title'),
		content = spoiler.children('.su-spoiler-content'),
		isAccordion = ( spoiler.parent('.su-accordion').length > 0 ) ? true : false;

		if ( spoiler.hasClass('su-spoiler-open') ) {
			if ( !isAccordion ) {
				content.hide(200);
				spoiler.removeClass('su-spoiler-open');
			}
		}
		else {
			spoiler.parent('.su-accordion').children('.su-spoiler').removeClass('su-spoiler-open');
			spoiler.parent('.su-accordion').find('.su-spoiler-content').hide(200);
			content.show(100);
			spoiler.addClass('su-spoiler-open');
		}
	});

	// Tabs
	$('.su-tabs-nav').delegate('span:not(.su-tabs-current)', 'click', function() {
		$(this).addClass('su-tabs-current').siblings().removeClass('su-tabs-current')
		.parents('.su-tabs').find('.su-tabs-pane').hide().eq($(this).index()).show();
	});
	$('.su-tabs-pane').hide();
	$('.su-tabs-nav span:first-child').addClass('su-tabs-current');
	$('.su-tabs-panes .su-tabs-pane:first-child').show();

	// Tables
	$('.su-table tr:even').addClass('su-even');
	
	// Google Maps
	$('.googlemap').each( function() {
		
		var $map_id = $(this).attr('id'),
		$title = $(this).find('.title').val(),
		$location = $(this).find('.location').val(),
		$zoom = parseInt( $(this).find('.zoom').val() ),
		geocoder, map;
		
		var mapOptions = {
			scrollwheel: false,
			zoom: $zoom,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		geocoder = new google.maps.Geocoder();
		
		geocoder.geocode( { 'address': $location}, function(results, status) {
		
			if (status == google.maps.GeocoderStatus.OK) {
			
				var mapOptions = {
					scrollwheel: false,
					/*navigationControl: false,
					mapTypeControl: false,
					scaleControl: false,*/
					draggable: false,
					zoom: $zoom,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				
				map = new google.maps.Map($('#'+ $map_id + ' .map_canvas')[0], mapOptions);
				
				map.setCenter(results[0].geometry.location);
				
				var marker = new google.maps.Marker({
				  map: map, 
				  position: results[0].geometry.location,
				  title : $location,
				  animation: google.maps.Animation.DROP
				});
				
				var contentString = '<div class="map-infowindow">'+
					( ($title) ? '<h3>' + $title + '</h3>' : '' ) + 
					$location + '<br/>' +
					'<a href="https://maps.google.com/?q='+ $location +'" target="_blank">View on Google Map</a>' +
					'</div>';
				
				var infowindow = new google.maps.InfoWindow({
				  content: contentString
				});
				
				google.maps.event.addListener(map, 'click', function(e) {
					map.setOptions({draggable: true});
				});
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map,marker);
				});
				
				google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
				  infowindow.open(map, marker);
				});
				
			} else {
				$('#'+ $map_id).html("Geocode was not successful for the following reason: " + status);
			}
		});
		
	});

});

function mycarousel_initCallback(carousel) {

	// Disable autoscrolling if the user clicks the prev or next button.
	carousel.buttonNext.bind('click', function() {
		carousel.startAuto(0);
	});

	carousel.buttonPrev.bind('click', function() {
		carousel.startAuto(0);
	});

	// Pause autoscrolling if the user moves with the cursor over the clip.
	carousel.clip.hover(function() {
		carousel.stopAuto();
	}, function() {
		carousel.startAuto();
	});
}
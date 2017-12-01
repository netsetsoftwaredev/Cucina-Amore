jQuery(document).ready(function($) { "use strict";
 

	// Apply chosen
	$('#su-generator-select').chosen({
		no_results_text: $('#su-generator-select').attr('data-no-results-text'),
		allow_single_deselect: true
	});

	// Select shortcode
	$('#su-generator-select').live( "change", function() {
		var queried_shortcode = $('#su-generator-select').find(':selected').val();
		$('#su-generator-settings').addClass('su-loading-animation');
		$('#su-generator-settings').load($('#su-generator-url').val() + '/lib/generator.php?shortcode=' + queried_shortcode, function() {
			$('#su-generator-settings').removeClass('su-loading-animation');
				
			$(this).find('.themo-wpColorPicker').wpColorPicker();
		});
	});

	// Insert shortcode
	$('#su-generator-insert').live('click', function(event) {
		var queried_shortcode = $('#su-generator-select').find(':selected').val();
		var su_compatibility_mode_prefix = $('#su-compatibility-mode-prefix').val();
		$('#su-generator-result').val('[' + su_compatibility_mode_prefix + queried_shortcode);
		$('#su-generator-settings .su-generator-attr').each(function() {
			if ( $(this).val() !== '' ) {
				$('#su-generator-result').val( $('#su-generator-result').val() + ' ' + $(this).attr('name') + '="' + $(this).val() + '"' );
			}
		});
		$('#su-generator-result').val($('#su-generator-result').val() + ']');

		// wrap shortcode
		if ( $('#su-generator-content').val() != 'false' ) {
			$('#su-generator-result').val($('#su-generator-result').val() + $('#su-generator-content').val() + '[/' + su_compatibility_mode_prefix + queried_shortcode + ']');
		}

		var shortcode = jQuery('#su-generator-result').val();

		// Insert into widget
		if ( typeof window.su_generator_target !== 'undefined' ) {
			
			// We need to see if the current textarea is the same as the active editor
			// If it's not then we aren't using the active editor and timymce has not been
			// added to this textarea. Insert the shortcode via ID.
			
			var activeEditor = tinyMCE.activeEditor.id;
			var activeTextarea = window.su_generator_target;
		  
			if(activeEditor == activeTextarea){
				window.send_to_editor(shortcode);
			}else{
				$('#' + window.su_generator_target).val( $('textarea#' + window.su_generator_target).val() + shortcode);
				tb_remove();
			}

		}else {
			console.log('sent_to_editor');
			window.send_to_editor(shortcode); // Insert into editor
		}

		// Prevent default action
		event.preventDefault();
		return false;
	});

	// Get Target Content Target (Content Editor Text Area)
	
	$('.ot-metabox-wrapper').on("click", "a[data-page='themo_shortcode_button']", function() {
		window.su_generator_target = $(this).attr('data-target');
	});
	
	

	
	/*if (name === 'my_field_name') {
	// do your stuff here
	}*/

});
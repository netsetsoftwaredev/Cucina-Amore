<?php
$return = "";
$attr_info = "";
	// Start WordPress
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
	// Capability check
	if ( !current_user_can( 'author' ) && !current_user_can( 'editor' ) && !current_user_can( 'administrator' ) )
		die( 'Access denied' );

	// Param check
	if ( empty( $_GET['shortcode'] ) )
		die( 'Shortcode not specified' );
	$shortcode = su_shortcodes( $_GET['shortcode'] );
	//do_action('skematik_add_shortcode_generator');
	
	if (isset($shortcode['help']) && count( $shortcode['help'] ) && $shortcode['help']  ){
		$return .= "<div class='updated'><p>";
		 $return .= $shortcode['help'];
		$return .= "</div>";
	}

	// Shortcode has atts
	if ( count( $shortcode['atts'] ) && $shortcode['atts'] ) {
		foreach ( $shortcode['atts'] as $attr_name => $attr_info ) {
			$return .= '<p>';
			
			if (strpos($attr_name, 'help') !== FALSE){
					$return .= "<div class='updated'><p>";
					 $return .= $attr_info;
					$return .= "</div>";
			}else{
				$return .= '<label for="su-generator-attr-' . $attr_name . '">' . $attr_info['desc'] . '</label>';
	
				// Select
				if ( count( $attr_info['values'] ) && $attr_info['values'] ) {
					$return .= '<select name="' . $attr_name . '" id="su-generator-attr-' . $attr_name . '" class="su-generator-attr">';
					foreach ( $attr_info['values'] as $attr_value ) {
						$attr_value_selected = ( $attr_info['default'] == $attr_value ) ? ' selected="selected"' : '';
						$return .= '<option' . $attr_value_selected . '>' . $attr_value . '</option>';
					}
					$return .= '</select>';
				}
	
				// Text & color input
				else {
	
					// Color picker
					if (isset($attr_info['type']) && $attr_info['type'] == 'color' ) {
						$return .= '<input type="text" name="' . $attr_name . '" data-default-color="'.$attr_info['default'].'" value="' . $attr_info['default'] . '" id="su-generator-attr-' . $attr_name . '" class="themo-wpColorPicker su-generator-attr" />';
					}
					// Textarea
					elseif(isset($attr_info['textarea']) && $attr_info['textarea'] == 'on'){
						$return .= '<textarea name="' . $attr_name . '" id="su-generator-attr-' . $attr_name . '" class="su-generator-attr" rows="15" cols="65">'. $attr_info['default'] .'</textarea>';
					}
					// Text input
					else {
						$return .= '<input type="text" name="' . $attr_name . '" value="' . $attr_info['default'] . '" id="su-generator-attr-' . $attr_name . '" class="su-generator-attr" />';
					}
				}
			}
			$return .= '</p>';
		}
	}


	
	// Single shortcode (not closed)
	if ( $shortcode['type'] == 'single' ) {
		$return .= '<input type="hidden" name="su-generator-content" id="su-generator-content" value="false" />';
	}

	// Wrapping shortcode
	else {
		if(isset($shortcode['textarea']) && $shortcode['textarea'] == 'on'){
			$return .= '<p><label>' . __( 'Content', 'themovation-shortcodes' ) . '</label><textarea name="su-generator-content" id="su-generator-content" rows="15" cols="65">'. $shortcode['content'] .'</textarea></p>';
		}else{
			$return .= '<p><label>' . __( 'Content', 'themovation-shortcodes' ) . '</label><input type="text" name="su-generator-content" id="su-generator-content" value="' . $shortcode['content'] . '" /></p>';
		}
	}

	if (isset($shortcode['usage']) && count( $shortcode['usage'] ) && $shortcode['usage']  ){
		$return .= "<div class='updated'><p>";
		 $return .= $shortcode['usage'];
		$return .= "</div>";
	}
	
	$return .= '<p><a href="#" class="button-primary" id="su-generator-insert">' . __( 'Insert', 'themovation-shortcodes' ) . '</a></p>';
	//$return .= '<a href="' . su_plugin_url() . '/images/demo/' . $_GET['shortcode'] . '.png" target="_blank" class="button alignright">' . __( 'Demo', 'themovation-shortcodes' ) . '</a></p>';
	// <a href="#" class="button-primary" id="su-generator-insert-another">' . __( 'Insert & Add Another', 'themovation-shortcodes' ) . '</a>

	$return .= '<input type="hidden" name="su-generator-result" id="su-generator-result" value="" />';

	

	echo $return;
?>
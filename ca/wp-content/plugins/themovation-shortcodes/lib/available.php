<?php
/**
 * List of available shortcodes
 */
 
function su_shortcodes( $shortcode = false ) {
	global $shortcodes;
	$shortcodes = array(
		# basic shortcodes - start
		'basic-shortcodes-open' => array(
			'name' => __( 'Theme Shortcodes', 'themovation-shortcodes' ),
			'type' => 'opengroup'
		),


/*
==========================================================
Accordion Group
==========================================================
*/
		'accordion_group' => array(
			'name' => 'Accordion Group',
			'type' => 'wrap',
			'atts' => array( ),
			'usage' => 'Content is optional.',
			'content' => '',
			'desc' => __( 'Accordion Group', 'themovation-shortcodes' ),
			'help' => __( 'Multiple Accordions are grouped with this shortcode.', 'themovation-shortcodes' ),
		),
		
/*
==========================================================
Accordion
==========================================================
*/
		'accordion' => array(
			'name' => 'Accordion',
			'type' => 'wrap',
			'atts' => array(
					'title' => array(
						'values' => array( ),
						'default' => 'Box Title here',
						'desc' => __( 'Box Title', 'themovation-shortcodes' ),
					),
					'icon-help' => __( '<strong>Icons:</strong> Use any Glyphicon, Halfling, Social or Filetype. Add the icon name (e.g.: glyphicons-camera, halflings-user, social-facebook) in the appropriate text field below. Find the <a href="http://glyphicons.com/" target="_blank">full list here</a>.', 'themovation-shortcodes' ),
					'icon' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Glyphicon', 'themovation-shortcodes' )
					),
					'icon_halflings' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Halfling', 'themovation-shortcodes' )
					),
					'icon_social' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Social', 'themovation-shortcodes' )
					),
					'icon_filetype' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Filetype', 'themovation-shortcodes' )
					),
			),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'textarea' => 'on',
			'desc' => __( 'Collapsible content areas.', 'themovation-shortcodes' ),
			'help' => __( 'Multiple Accordions should be grouped with the Accordion Group shortcode first.', 'themovation-shortcodes' ),
		),

 
/*
==========================================================
Alert
==========================================================
*/			
		'alert' => array(
			'name' => 'Alert',
			'type' => 'wrap',
			'atts' => array(
			
				'heading' => array(
					'values' => array( ),
					'default' => 'Alert Heading',
					'desc' => __( 'Alert Heading', 'themovation-shortcodes' )
				),
				'type' => array(
					'values' => array(
						'alert-success',
						'alert-info',
						'alert-error',
						'alert-danger',
					),
					'default' => 'alert-info',
					'desc' => __( 'Alert Style', 'themovation-shortcodes' )
				),
				'block' => array(
					'values' => array(
						'true',
						'false'
					),
					'default' => 'false',
					'desc' => __( 'Block Padding', 'themovation-shortcodes' )
				),
				'close' => array(
					'values' => array(
						'true',
						'false'
					),
					'default' => 'true',
					'desc' => __( 'Close Button', 'themovation-shortcodes' )
				)
			),
			//'usage' => '[alert type="alert-info" heading="Alert Heading" block="false" close="false"]Content[/alert]',
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'desc' => __( 'Alert box with optional padding and close button', 'themovation-shortcodes' )
		),

/*
==========================================================
Blockquote
==========================================================
*/			
		'blockquote' => array(
			'name' => 'Blockquote',
			'type' => 'wrap',
			'atts' => array(
			
				'cite' => array(
					'values' => array( ),
					'default' => 'Cite Title',
					'desc' => __( 'Cite Title', 'themovation-shortcodes' )
				),
				'name' => array(
					'values' => array( ),
					'default' => 'Cite Name',
					'desc' => __( 'Cite Name', 'themovation-shortcodes' )
				),
				'align' => array(
					'values' => array(
						'left',
						'right',
					),
					'default' => 'left',
					'desc' => __( 'Blockquote Alignment', 'themovation-shortcodes' )
				),
				'reverse' => array(
					'values' => array(
						'on',
						'off'
					),
					'default' => 'off',
					'desc' => __( 'Reverse Display', 'themovation-shortcodes' )
				),
				
			),
			//'usage' => "[blockquote name='R Labelle' cite='Themovation' ]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.[/blockquote]",
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'desc' => __( 'For quoting blocks of content from another source within your document.', 'themovation-shortcodes' )
		),		

/*
==========================================================
Theme Buttons
==========================================================
*/			
		'themo_button' => array(
			'name' => 'Button',
			'type' => 'single',
			'atts' => array(
				'text' => array(
					'values' => array( ),
					'default' => 'Button Text',
					'desc' => __( 'Button Text', 'themovation-shortcodes' )
				),
				'url' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Button Link', 'themovation-shortcodes' )
				),
				'type' => array(
					'values' => array(
						'standard',
						'ghost',
						'cta',
					),
					'default' => 'standard',
					'desc' => __( 'Button Style', 'themovation-shortcodes' )
				),
				'target' => array(
					'values' => array(
						'',
						'_self',
						'_blank'
					),
					'default' => '',
					'desc' => __( 'Button Link Target', 'themovation-shortcodes' )
				),
			),
			'usage' => '',
			'desc' => __( 'Theme Buttons in 3 Styles: Standard, Ghost and Call to Action', 'themovation-shortcodes' ),
		),		

/*
==========================================================
Bootstrap Button Group
==========================================================
*/
		'button_group' => array(
			'name' => 'Bootstrap | Button Group',
			'type' => 'wrap',
			'atts' => array(
				'variation' => array(
					'values' => array(
						'none',
						'justified',
					),
					'default' => 'none',
					'desc' => __( 'Button Group Justified', 'themovation-shortcodes' )
				),
			),
			'usage' => 'Optional: Add button shortcode to content field or use the Button Shortcode Generator.',
			'content' => '',
			'desc' => __( 'Button Group', 'themovation-shortcodes' ),
			'help' => __( 'Group multiple buttons with this shortcode.', 'themovation-shortcodes' ),
		),
		
/*
==========================================================
Bootstrap Buttons
==========================================================
*/			
		'button' => array(
			'name' => 'Bootstrap | Button',
			'type' => 'wrap',
			'atts' => array(
				'text' => array(
					'values' => array( ),
					'default' => 'Button Text',
					'desc' => __( 'Button Text', 'themovation-shortcodes' )
				),
				'url' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Button Link', 'themovation-shortcodes' )
				),
				'size' => array(
					'values' => array(
						'',
						'xs',
						'sm',
						'default',
						'large'
					),
					'default' => 'default',
					'desc' => __( 'Button Size', 'themovation-shortcodes' )
				),
				'type' => array(
					'values' => array(
						'',
						'primary',
						'default',
						'info',
						'success',
						'danger',
						'warning',
						'inverse'
					),
					'default' => 'default',
					'desc' => __( 'Button Style (color)', 'themovation-shortcodes' )
				),
				'target' => array(
					'values' => array(
						'',
						'_self',
						'_blank'
					),
					'default' => '',
					'desc' => __( 'Button Link Target', 'themovation-shortcodes' )
				),
				'dropdown-help' => __( '<strong>Dropdowns:</strong> Use the shortcode generator to add dropdown buttons after you add at least one button.', 'themovation-shortcodes' ),
				'dropdown' => array(
					'values' => array(
						'no',
						'yes',
					),
					'default' => 'no',
					'desc' => __( 'Is this the top of a button dropdown?', 'themovation-shortcodes' )
				),
				'split' => array(
					'values' => array(
						'no',
						'yes',
					),
					'default' => 'no',
					'desc' => __( 'Button dropdown split style?', 'themovation-shortcodes' )
				),
				'icon-help' => __(  '<strong>Icons:</strong> Use any Glyphicon, Halfling, Social or Filetype. Add the icon name (e.g.: glyphicons-camera, halflings-user, social-facebook) in the appropriate text field below. Find the <a href="http://glyphicons.com/" target="_blank">full list here</a>.', 'themovation-shortcodes'  ),
				'icon' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Glyphicon', 'themovation-shortcodes' )
				),
				'icon_halflings' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Halfling', 'themovation-shortcodes' )
				),
				'icon_social' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Social', 'themovation-shortcodes' )
				),
				'icon_filetype' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Filetype', 'themovation-shortcodes' )
				),
			),
			'content' => '',
			'usage' => '',
			'desc' => __( '4 sizes, 7 colors and 500+ icons', 'themovation-shortcodes' ),
			'help' => __( 'Multiple buttons need to be wrapped in a [button_group][/button_group], single buttons do not.', 'themovation-shortcodes' ),
		),

/*
==========================================================
Bootstrap Button Dropdown
==========================================================
*/			
		'dropdown' => array(
			'name' => 'Bootstrap | Button Dropdown',
			'type' => 'wrap',
			'atts' => array(
				'link' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Dropdown Link', 'themovation-shortcodes' )
				),
				'target' => array(
					'values' => array(
						'',
						'_self',
						'_blank'
					),
					'default' => '',
					'desc' => __( 'Dropdown Target', 'themovation-shortcodes' )
				),
				'divder' => array(
					'values' => array(
						'no',
						'yes',
					),
					'default' => 'no',
					'desc' => __( 'Dropdown Divder', 'themovation-shortcodes' )
				),
				
				'help' => __(  '<strong>Icons:</strong> Use any Glyphicon, Halfling, Social or Filetype. Add the icon name (e.g.: glyphicons-camera, halflings-user, social-facebook) in the appropriate text field below. Find the <a href="http://glyphicons.com/" target="_blank">full list here</a>.', 'themovation-shortcodes' ),
				'icon' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Glyphicon', 'themovation-shortcodes' )
				),
				'icon_halflings' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Halfling', 'themovation-shortcodes' )
				),
				'icon_social' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Social', 'themovation-shortcodes' )
				),
				'icon_filetype' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Filetype', 'themovation-shortcodes' )
				),
			),
			'content' => 'Button Text',
			'usage' => "",
			'desc' => __( '4 sizes, 7 colors and 500+ icons', 'themovation-shortcodes' ),
			'help' => __( 'Used in conjunction with the Button Shortcode and Button Group Shortcode.<br>This Shortcode requires a Button Shortcode AND a Button Group Shortcode Wrapper', 'themovation-shortcodes' ),
		),

/*
==========================================================
Carousel
==========================================================
*/			
		'slider_gallery' => array(
			'name' => 'Carousel / Slider Gallery',
			'type' => 'single',
			'atts' => array(
				'ids' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Include specific image IDs', 'themovation-shortcodes' )
				),
				'width' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Carousel width e.g. 600', 'themovation-shortcodes' )
				),
			),
			'help' => __( 'Simular to the <a href="http://codex.wordpress.org/Gallery_Shortcode" target="_blank">WordPress [gallery] shortcode</a>. Takes image IDs and converts into a carousel gallery.', 'themovation-shortcodes' ),
			'desc' => __( 'A Carousel of your gallery\'s images', 'themovation-shortcodes' )
		),

/*
==========================================================
Code
==========================================================
*/	
		'code' => array(
			'name' => 'Code',
			'type' => 'wrap',
			'atts' => array(
				'scroll' => array(
					'values' => array(
						'on',
						'off'
					),
					'default' => 'off',
					'desc' => __( 'Scroll - for large blocks', 'themovation-shortcodes' )
				),
				'inline' => array(
					'values' => array(
						'on',
						'off'
					),
					'default' => 'off',
					'desc' => __( 'Inline with text', 'themovation-shortcodes' )
				)
			),
			'content' => __( 'Code goes here', 'themovation-shortcodes' ),
			'textarea' => 'on',
			'desc' => __( 'Code box for showing code.', 'themovation-shortcodes' )
		),

/*
==========================================================
Column
==========================================================
*/
		'column' => array(
			'name' => 'Column',
			'type' => 'wrap',
			'atts' => array(
				'span' => array(
					'values' => array(
						'1',
						'2',
						'3',
						'4',
						'5',
						'6',
						'7',
						'8',
						'9',
						'10',
						'11',
						'12'
					),
					'default' => '',
					'desc' => __( 'Column Span.', 'themovation-shortcodes' )
				)
			),
			'help' => __( 'The column shortcode is a grid of up to 12 columns. If you want two equal columns, create two columns, with a span of 6 each.', 'themovation-shortcodes' ),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'textarea' => 'on',
			'desc' => __( 'Grid systems are used for creating page layouts through a series of rows and columns that house your content.', 'themovation-shortcodes' )
		),

/*
==========================================================
Column Row
==========================================================
*/
		'row' => array(
			'name' => 'Column Row',
			'type' => 'wrap',
			'atts' => array( ),
			//'usage' => '[row][/row]',
			'content' => '',
			'desc' => __( 'Row', 'themovation-shortcodes' ),
			'help' => __( 'For each column row, use this row shortcode generator to wrap.', 'themovation-shortcodes' ),
		),

/*
==========================================================
Dropcaps
==========================================================
*/
		'dropcaps' => array(
			'name' => 'Dropcaps',
			'type' => 'wrap',
			'atts' => array(
				'style' => array(
					'values' => array(
						'box',
						'circle',
						'book',
					),
					'default' => 'book',
					'desc' => __( 'Style', 'themovation-shortcodes' )
				),
			),
			'content' => '',
		),
		
/*
==========================================================
Google Map
==========================================================
*/			
		'google_map' => array(
			'name' => 'Google Map',
			'type' => 'single',
			'atts' => array(
				'title' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Title', 'themovation-shortcodes' )
				),
				'location' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Location', 'themovation-shortcodes' )
				),
				'width' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Width', 'themovation-shortcodes' )
				),
				'height' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Height', 'themovation-shortcodes' )
				),
				'zoom' => array(
					'values' => range(1,19),
					'default' => 8,
					'desc' => __( 'Zoom level', 'themovation-shortcodes' )
				),
				'align' => array(
					'values' => array(
						'default',
						'left',
						'center',
						'right'
					),
					'default' => '',
					'desc' => __( 'Alignment', 'themovation-shortcodes' )
				),
				'class' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Class', 'themovation-shortcodes' )
				),
			),
		),




/*
==========================================================
Highlight
==========================================================
*/			
		'highlight' => array(
			'name' => 'Highlight',
			'type' => 'wrap',
			'atts' => array(
				'color' => array(
					'values' => array(
						'primary',
						'info',
						'success',
						'danger',
						'warning',
					),
					'default' => 'default',
					'desc' => __( 'Color', 'themovation-shortcodes' )
				),
				'class' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Class', 'themovation-shortcodes' )
				),
				
			),
			'content' => '',
		),


/*
==========================================================
Horizontal Description Group
==========================================================
*/
		'hr_list_wrap' => array(
			'name' => 'Horizontal Description Group',
			'type' => 'wrap',
			'atts' => array( ),
			'content' => '',
			//'desc' => __( 'Make terms and descriptions line up side-by-side.', 'themovation-shortcodes' ),
			'help' => __( 'Group / wrap a horizontal description list together.', 'themovation-shortcodes' ),
		),

/*
==========================================================
Horizontal Description List
==========================================================
*/
		'hr_list' => array(
			'name' => 'Horizontal Description List',
			'type' => 'wrap',
			'atts' => array(
					'title' => array(
						'values' => array( ),
						'default' => 'Enter title here',
						'desc' => __( 'List Title', 'themovation-shortcodes' ),
					),
			),
			'content' => '',
			'textarea' => 'on',
			'help' => __( 'Make terms and descriptions line up side-by-side.', 'themovation-shortcodes' ),
		),

/*
==========================================================
Icons
==========================================================
*/			
		'glyphicon' => array(
			'name' => 'Icon',
			'type' => 'single',
			'atts' => array(
				/*'type' => array(
					'values' => array(
						'none','glass','music','search','envelope','heart','star','star-empty','user','film','th-large','th','th-list','ok','remove','zoom-in','zoom-out','off','signal','cog','trash','home','file','time','road','download-alt','download','upload','inbox','play-circle','repeat','refresh','list-alt','lock','flag','headphones','volume-off','volume-down','volume-up','qrcode','barcode','tag','tags','book','bookmark','print','camera','icon-font','bold','italic','text-height','text-width','align-left','align-center','align-right','align-justify','list','indent-left','indent-right','facetime-video','picture','pencil','map-marker','adjust','tint','edit','share','check','move','step-backward','fast-backward','backward','play','pause','stop','forward','fast-forward','step-forward','eject','chevron-left','chevron-right','plus-sign','minus-sign','remove-sign','ok-sign','question-sign','info-sign','screenshot','remove-circle','ok-circle','ban-circle','arrow-left','arrow-right','arrow-up','arrow-down','share-alt','resize-full','resize-small','plus','minus','asterisk','exclamation-sign','gift','leaf','fire','eye-open','eye-close','warning-sign','plane','calendar','random','comment','magnet','chevron-up','chevron-down','retweet','shopping-cart','folder-close','folder-open','resize-vertical','resize-horizontal','hdd','bullhorn','bell','certificate','thumbs-up','thumbs-down','hand-right','hand-left','hand-up','hand-down','circle-arrow-right','circle-arrow-left','circle-arrow-up','circle-arrow-down','globe','wrench','tasks','filter','briefcase','fullscreen'
					),
					'default' => 'default',
					'desc' => __( 'Icon', 'themovation-shortcodes' )
				),*/
				
				'size' => array(
					'values' => array(
						'med-icon',
					),
					'default' => 'med-icon',
					'desc' => __( 'Size', 'themovation-shortcodes' )
				),
				'wrapper' => array(
					'values' => array(
						'i',
						'button',
						'span',
					),
					'default' => 'i',
					'desc' => __( 'Wrapper', 'themovation-shortcodes' )
				),
				'style' => array(
					'values' => array(
						'accent',
					),
					'default' => 'accent',
					'desc' => __( 'Style', 'themovation-shortcodes' )
				),
				'help' => __(  '<strong>Icons:</strong> Use any Glyphicon, Halfling, Social or Filetype. Add the icon name (e.g.: glyphicons-camera, halflings-user, social-facebook) in the appropriate text field below. Find the <a href="http://glyphicons.com/" target="_blank">full list here</a>.', 'themovation-shortcodes'  ),
				'icon' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Glyphicon', 'themovation-shortcodes' )
				),
				'icon_halflings' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Halfling', 'themovation-shortcodes' )
				),
				'icon_social' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Social', 'themovation-shortcodes' )
				),
				'icon_filetype' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Filetype', 'themovation-shortcodes' )
				),
				
			),
			//'usage' => '[icon type="music" size="24"]',
			//'desc' => __( '210 icons', 'themovation-shortcodes' )
		),

/*
==========================================================
Image shapes
==========================================================
*/
		'shape' => array(
			'name' => 'Image Shapes',
			'type' => 'wrap',
			'atts' => array(
				'src' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Image src', 'themovation-shortcodes' ),
				),
				'shape' => array(
					'values' => array(
						'thumbnail',
						'rounded',
						'circle'
					),
					'default' => 'img-circle',
					'desc' => __( 'Image shape', 'themovation-shortcodes' )
				),
				'link' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Image link', 'themovation-shortcodes' ),
				),
				'target' => array(
					'values' => array(
						'',
						'_self',
						'_blank'
					),
					'default' => '',
					'desc' => __( 'Image link target', 'themovation-shortcodes' )
				),
				'class' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Image class', 'themovation-shortcodes' ),
				),
				'alt' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Image alt text', 'themovation-shortcodes' ),
				),
				'width' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Image width', 'themovation-shortcodes' ),
				),
				'height' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Image height', 'themovation-shortcodes' ),
				),
			),
			'content' => '',
			'help' => __( 'Apply mages styles: rounded, circle or thumbnail.', 'themovation-shortcodes' ),
		),

/*
==========================================================
Jumbotron
==========================================================
*/
		'jumbotron' => array(
			'name' => 'Jumbotron',
			'type' => 'wrap',
			'atts' => array(
					'background' => array(
						'values' => array( ),
						'default' => '#f6f6f6',
						'desc' => __( 'Background color', 'themovation-shortcodes' ),
						'type' => 'color'
					),
					'color' => array(
						'values' => array( ),
						'default' => '#000',
						'desc' => __( 'Text Color', 'themovation-shortcodes' ),
						'type' => 'color'
					)
			),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'textarea' => 'on',
			'desc' => __( 'A lightweight, flexible component that can optionally extend the entire viewport to showcase key content on your site.', 'themovation-shortcodes' )
		),

/*
==========================================================
Labels
==========================================================
*/			
		'label' => array(
			'name' => 'Label',
			'type' => 'single',
			'atts' => array(
				'type' => array(
					'values' => array(
						'',
						'primary',
						'default',
						'info',
						'success',
						'danger',
						'warning',
						'inverse'
					),
					'default' => '',
					'desc' => __( 'Label Style (color)', 'themovation-shortcodes' )
				),
				'text' => array(
					'values' => array( ),
					'default' => 'Label Text',
					'desc' => __( 'Label Text', 'themovation-shortcodes' )
				),
			),
			'desc' => __( 'Text surrounded by a solid color for importance.', 'themovation-shortcodes' )
		),				

/*
==========================================================
Lead
==========================================================
*/
		'lead' => array(
			'name' => 'Lead Paragraph',
			'type' => 'wrap',
			'atts' => array(
				'align' => array(
					'values' => array(
						'default',
						'left',
						'center',
						'right'
					),
					'default' => '',
					'desc' => __( 'text alignment', 'themovation-shortcodes' )
				),
			),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'desc' => __( 'Lead Paragraph', 'themovation-shortcodes' )
		),

/*
==========================================================
Modals
==========================================================
*/
		'modal' => array(
			'name' => 'Modal Window',
			'type' => 'wrap',
			'atts' => array(
				'title' => array(
						'values' => array( ),
						'default' => 'Modal Title here',
						'desc' => __( 'Modal', 'themovation-shortcodes' ),
					),
				'button_type' => array(
					'values' => array(
						'',
						'primary',
						'default',
						'info',
						'success',
						'danger',
						'warning',
						'inverse'
					),
					'default' => 'default',
					'desc' => __( 'Button Style (color)', 'themovation-shortcodes' )
				),
				'button_text' => array(
					'values' => array( ),
					'default' => 'Button Text',
					'desc' => __( 'Button Text', 'themovation-shortcodes' )
				),
				'button_size' => array(
					'values' => array(
						'',
						'xs',
						'sm',
						'default',
						'large'
					),
					'default' => 'default',
					'desc' => __( 'Button Size', 'themovation-shortcodes' )
				),
				
				'footer' => array(
					'values' => array(
						'on',
						'off'
					),
					'default' => 'off',
					'desc' => __( 'Display footer', 'themovation-shortcodes' )
				),
				
			),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'textarea' => 'on',
			'desc' => __( 'Lead Paragraph', 'themovation-shortcodes' )
		),		


/*
==========================================================
Page Header
==========================================================
*/			
		'header' => array(
			'name' => 'Page Header',
			'type' => 'single',
			'atts' => array(
				'text' => array(
					'values' => array( ),
					'default' => 'Heading Text',
					'desc' => __( 'Heading Text', 'themovation-shortcodes' )
				),
				'subtext' => array(
					'values' => array( ),
					'default' => 'Sub Text',
					'desc' => __( 'Sub Text', 'themovation-shortcodes' ),
				),
			),
			'desc' => __( 'Page Header.', 'themovation-shortcodes' )
		),

/*
==========================================================
Panel with Heading
==========================================================
*/			
		'panel' => array(
			'name' => 'Panel with Heading',
			'type' => 'wrap',
			'atts' => array(
				'type' => array(
					'values' => array(
						'',
						'primary',
						'default',
						'info',
						'success',
						'danger',
						'warning',
						'inverse'
					),
					'default' => 'default',
					'desc' => __( 'Style (color)', 'themovation-shortcodes' )
				),
				'heading' => array(
					'values' => array( ),
					'default' => 'Heading',
					'desc' => __( 'Heading', 'themovation-shortcodes' ),
				),
			),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'textarea' => 'on',
			'desc' => __( 'Page Header.', 'themovation-shortcodes' )
		),


/*
==========================================================
Popovers
==========================================================
*/			
		'popover' => array(
			'name' => 'Popover',
			'type' => 'wrap',
			'atts' => array(
				'popover_title' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Popover Title', 'themovation-shortcodes' )
				),
				'popover_placement' => array(
					'values' => array(
						'left',
						'top',
						'right',
						'bottom'
					),
					'default' => 'top',
					'desc' => __( 'Popover Placement', 'themovation-shortcodes' )
				),
				'button_text' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Button Text', 'themovation-shortcodes' )
				),
				'button_type' => array(
					'values' => array(
						'primary',
						'default',
						'info',
						'success',
						'danger',
						'warning',
						'inverse'
					),
					'default' => '1',
					'desc' => __( 'Button Style (color)', 'themovation-shortcodes' )
				),
				'button_size' => array(
					'values' => array(
						'',
						'xs',
						'sm',
						'default',
						'large'
					),
					'default' => 'default',
					'desc' => __( 'Button Size', 'themovation-shortcodes' )
				),
				'link' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Link Url', 'themovation-shortcodes' )
				),
				'target' => array(
					'values' => array(
						'_self',
						'_blank'
					),
					'default' => '_self',
					'desc' => __( 'Link Target', 'themovation-shortcodes' )
				),
				
			),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'textarea' => 'on',
		),

/*
==========================================================
Popover Text
==========================================================
*/			
		'popover_text' => array(
			'name' => 'Popover Text',
			'type' => 'wrap',
			'atts' => array(
				'popover_title' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Popover Title', 'themovation-shortcodes' )
				),
				'popover_content' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Popover Text', 'themovation-shortcodes' ),
					'textarea' => 'on'
				),
				'popover_placement' => array(
					'values' => array(
						'left',
						'top',
						'right',
						'bottom'
					),
					'default' => 'top',
					'desc' => __( 'Popover Placement', 'themovation-shortcodes' )
				),
				'link' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Link Url', 'themovation-shortcodes' )
				),
				'target' => array(
					'values' => array(
						'_self',
						'_blank'
					),
					'default' => '_self',
					'desc' => __( 'Link Target', 'themovation-shortcodes' )
				),
			),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'usage' => __( 'The content you enter above will activate the popover text and will be displayed inline.', 'themovation-shortcodes' ),
		),

/*
==========================================================
Progress Bar
==========================================================
*/			
		'progress' => array(
			'name' => 'Progress Bar',
			'type' => 'single',
			'atts' => array(
				'label' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Label', 'themovation-shortcodes' )
				),
				'type' => array(
					'values' => array(
						'primary',
						'info',
						'success',
						'warning',
						'danger'
					),
					'default' => 'info',
					'desc' => __( 'Style (color)', 'themovation-shortcodes' )
				),
				'progress' => array(
					'values' => array( ),
					'default' => '25',
					'desc' => __( 'Percentage of Progress', 'themovation-shortcodes' )
				),
				'striped' => array(
					'values' => array(
						'on',
						'off'
					),
					'default' => 'off',
					'desc' => __( 'Striped', 'themovation-shortcodes' )
				),
				'animate' => array(
					'values' => array(
						'on',
						'off'
					),
					'default' => 'off',
					'desc' => __( 'Animate (requires striped)', 'themovation-shortcodes' )
				),
				
			),
			
		),


/*
==========================================================
Tabs / Wrap
==========================================================
*/			
		'tabwrap' => array(
			'name' => 'Tab Wrap / Group',
			'type' => 'wrap',
			'atts' => array( ),
			'usage' => 'Content is optional, however you can place a [tab][/tab] shortcode in here. We will wrap it for you.',
			'content' => '',
			'help' => __( 'Togglable Tabs need to be wrapped in [tabwrap][/tabwrap] tags. Use this shortcode to output the wrapper tags.', 'themovation-shortcodes' ),
		),

/*
==========================================================
Tabs / Togglable
==========================================================
*/			
		'tab' => array(
			'name' => 'Tab',
			'type' => 'wrap',
			'atts' => array(
				'title' => array(
					'values' => array( ),
					'default' => 'Tab label goes here',
					'desc' => __( 'Tab Label', 'themovation-shortcodes' )
				),
			),
			'content' => __( 'Tab content goes here', 'themovation-shortcodes' ),
			'textarea' => 'on',
		),

/*
==========================================================
Tooltip
===========================================d===============
*/			
		'tooltip' => array(
			'name' => 'Tooltip',
			'type' => 'single',
			'atts' => array(
				'tooltip_text' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Tooltip Text', 'themovation-shortcodes' )
				),
				'tooltip_placement' => array(
					'values' => array(
						'left',
						'top',
						'right',
						'bottom'
					),
					'default' => 'top',
					'desc' => __( 'Popover Placement', 'themovation-shortcodes' )
				),
				'button_text' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Button Text', 'themovation-shortcodes' )
				),
				'button_type' => array(
					'values' => array(
						'primary',
						'default',
						'info',
						'success',
						'danger',
						'warning',
						'inverse'
					),
					'default' => '1',
					'desc' => __( 'Button Style (color)', 'themovation-shortcodes' )
				),
				'button_size' => array(
					'values' => array(
						'',
						'xs',
						'sm',
						'default',
						'large'
					),
					'default' => 'default',
					'desc' => __( 'Button Size', 'themovation-shortcodes' )
				),
				'link' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Link Url', 'themovation-shortcodes' )
				),
				'target' => array(
					'values' => array(
						'_self',
						'_blank'
					),
					'default' => '_self',
					'desc' => __( 'Link Target', 'themovation-shortcodes' )
				),
				
			),
		),

/*
==========================================================
Tooltip Text
==========================================================
*/			
		'tooltip_text' => array(
			'name' => 'Tooltip Text',
			'type' => 'wrap',
			'atts' => array(
				'tooltip_text' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Tooltip Text', 'themovation-shortcodes' ),
				),
				'tooltip_placement' => array(
					'values' => array(
						'left',
						'top',
						'right',
						'bottom'
					),
					'default' => 'top',
					'desc' => __( 'Tooltip Placement', 'themovation-shortcodes' )
				),
				'link' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Link Url', 'themovation-shortcodes' )
				),
				'target' => array(
					'values' => array(
						'_self',
						'_blank'
					),
					'default' => '_self',
					'desc' => __( 'Link Target', 'themovation-shortcodes' )
				),
			),
			'content' => __( 'Content goes here', 'themovation-shortcodes' ),
			'usage' => __( 'The content you enter above will activate the tooltip text and will be displayed inline.', 'themovation-shortcodes' ),
		),


		/*
==========================================================
Icons
==========================================================
*/
		'video_play' => array(
			'name' => 'Video Lighbox Button',
			'type' => 'single',
			'atts' => array(
				'src' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Video src e.g. http://www.youtube.com/embed/iUchUvXA8mk', 'themovation-shortcodes' ),
				),
				'width' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Video lighbox width e.g. 1280', 'themovation-shortcodes' )
				),
				'size' => array(
					'values' => array(
						'xs-icon',
						'sm-icon',
						'med-icon',
						'lrg-icon',
						'xl-icon',
					),
					'default' => 'xl-icon',
					'desc' => __( 'Size', 'themovation-shortcodes' )
				),
				'help' => __(  '<strong>Icons:</strong> Use any Glyphicon, Halfling, Social or Filetype. Add the icon name (e.g.: glyphicons-camera, halflings-user, social-facebook) in the appropriate text field below. Find the <a href="http://glyphicons.com/" target="_blank">full list here</a>.', 'themovation-shortcodes'  ),
				'icon' => array(
					'values' => array( ),
					'default' => 'glyphicons-play-button',
					'desc' => __( 'Glyphicon', 'themovation-shortcodes' )
				),
				'icon_halflings' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Halfling', 'themovation-shortcodes' )
				),
				'icon_social' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Social', 'themovation-shortcodes' )
				),
				'icon_filetype' => array(
					'values' => array( ),
					'default' => '',
					'desc' => __( 'Filetype', 'themovation-shortcodes' )
				),

			),
			//'usage' => '[icon type="music" size="24"]',
			//'desc' => __( '210 icons', 'themovation-shortcodes' )
		),

/*
==========================================================
End Shortcodes
==========================================================
*/
				'basic-shortcodes-close' => array(
			'type' => 'closegroup'
		),
	);


do_action('add_to_shortcode_generator');
		
	if ( $shortcode )
		return $shortcodes[$shortcode];
	else
		return $shortcodes;
}


/*
==========================================================
Divider
==========================================================
*/
		/*'divider' => array(
			'name' => 'Divider',
			'type' => 'single',
			'atts' => array( ),
			'usage' => '[divider]',
			'content' => '',
			'desc' => __( 'Divider', 'themovation-shortcodes' )
		),*/
?>
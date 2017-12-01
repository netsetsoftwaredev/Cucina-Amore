<?php
/*
Plugin Name: Call Now Button
Plugin URI: http://callnowbutton.com
Description: Mobile visitors will see a call now button at the bottom of your site
Version: 0.1.3
Author: Jerry Rietveld
Author URI: http://www.jgrietveld.com
License: GPL2
*/
?>
<?php
/*  Copyright 2013  Jerry Rietveld  (email : jerry@jgrietveld.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php
define('CNB_VERSION','0.1.3');
add_action('admin_menu', 'register_cnb_page');
add_action('admin_init', 'cnb_options_init');

function register_cnb_page() {
	add_submenu_page('options-general.php', 'Call Now Button', 'Call Now Button', 'manage_options', 'call-now-button', 'call_now_settings_page');
}
set_basic_options();


// add the color picker
add_action( 'admin_enqueue_scripts', 'cnb_enqueue_color_picker' );
function cnb_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'cnb-script-handle', plugins_url('call-now-button.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

function cnb_options_init() {
	register_setting('cnb_options','cnb');
}
function call_now_settings_page() { ?>
<div class="wrap"><h2>Call Now Button <span style="font-size:12px; font-variant: small-caps; font-family: Verdana, Geneva, sans-serif;">by <a class="pluginhelp" style=" text-decoration:none;" href="http://www.jgrietveld.com" rel="help">Jerry Rietveld</a></span></h2>


<form method="post" action="options.php">
            <?php settings_fields('cnb_options'); ?>
            <?php $options = cnb_get_options(); ?>
			<h4 style="max-width:700px; text-align:right; margin:0;cursor:pointer; color:#21759b" class="cnb_settings"><span class="plus">+</span><span class="minus">-</span> Advanced settings</h4>
            <table class="form-table">
            	<tr valign="top"><th scope="row">Call Now Button</th>
                	<td>
                    	<input name="cnb[active]" type="radio" value="1" <?php checked('1', $options['active']); ?> /> Enabled<br />
                        <input name="cnb[active]" type="radio" value="0" <?php checked('0', $options['active']); ?> /> Disabled
                    </td>
                </tr>
                <tr valign="top"><th scope="row">Phone number</th>
                    <td><input type="text" name="cnb[number]" value="<?php echo $options['number']; ?>" /></td>
                </tr>
			</table>
            <div id="settings">
            	<table class="form-table">
				<tr valign="top"><th scope="row">Button color</th>
                	<td><input name="cnb[color]" type="text" value="<?php echo $options['color']; ?>" class="cnb-color-field" data-default-color="#009900" /></td>
                </tr>
				<tr valign="top"><th scope="row">Appearance</th>
                	<td>
                    	<label title="right">
                        	<input type="radio" name="cnb[appearance]" value="right" <?php checked('right', $options['appearance']); ?>>
                            <span>Right corner</span>
                        </label><br />
                    	<label title="left">
                        	<input type="radio" name="cnb[appearance]" value="left" <?php checked('left', $options['appearance']); ?>>
                            <span>Left corner</span>
                        </label><br />
                    	<label title="full">
                        	<input type="radio" name="cnb[appearance]" value="full" <?php checked('full', $options['appearance']); ?>>
                            <span>Full bottom</span>
                        </label>
                    </td>
                </tr>
                <tr valign="top"><th scope="row">Click tracking</th>
                    <td><input type="radio" name="cnb[tracking]" value="2" <?php checked('2', $options['tracking']); ?> /> Google Universal Analytics (analytics.js)<br />
					    <input type="radio" name="cnb[tracking]" value="1" <?php checked('1', $options['tracking']); ?> /> Google Classic Analytics (ga.js)<br />
					    <input type="radio" name="cnb[tracking]" value="0" <?php checked('0', $options['tracking']); ?> /> Disabled
					<p class="description">Once click tracking has been set up and working on your site for a day, go to the Content section of the reports and view Event Tracking.</p></td>
                </tr>
                <tr valign="top"><th scope="row">Limit appearance</th>
                    <td><input type="text" name="cnb[show]" value="<?php echo $options['show']; ?>" />
					<p class="description">Enter IDs of the posts & pages the Call Now Button should appear on (leave blank for all).</p></td>
                </tr>
            </table>
			</div><!--#settings-->
            <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>

		<h2>Feedback, Requests &amp; Appreciation</h2>
        <div class="donate" style="width:160px; float:left; padding:20px; height:70px;">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="Q82GBVSERC9AW">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div><!--.donate-->

  		<p><strong>Feedback:</strong> I'm very interested in hearing your thoughts about the plugin. Please drop me a line on <a href="http://callnowbutton.com">CallNowButton.com</a></p>
        <p><strong>Coding requests:</strong> If you have any particular modification request you can hire me to tailor the plugin to meet your needs. You can contact me <a href="http://www.jgrietveld.com/contact-me/">here</a>.</p>
        <p><strong>Say thanks:</strong> Developing a plugin takes time and energy. If you like the plugin or use it for clients, consider making a donation. Thanks.</p>
    </div>
<?php }
if(get_option('cnb') && !is_admin()) {
	
	// Color functions to calculate borders
	function changeColor($color, $direction) {
		if(!preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $parts));
		if(!isset($direction) || $direction == "lighter") { $change = 45; } else { $change = -50; }
		for($i = 1; $i <= 3; $i++) {
		  $parts[$i] = hexdec($parts[$i]);
		  $parts[$i] = round($parts[$i] + $change);
		  if($parts[$i] > 255) { $parts[$i] = 255; } elseif($parts[$i] < 0) { $parts[$i] = 0; }
		  $parts[$i] = dechex($parts[$i]);
		} 
		$output = '#' . str_pad($parts[1],2,"0",STR_PAD_LEFT) . str_pad($parts[2],2,"0",STR_PAD_LEFT) . str_pad($parts[3],2,"0",STR_PAD_LEFT);
		return $output;
	}
	
	
	$options = get_option('cnb');
	if(isset($options['active'])) $enabled = $options['active']; else $enabled = 0;
	if($enabled == '1') {
		// it's enables so put footer stuff here
		function cnb_head() {
			$options = get_option('cnb');
			$credits = "\n<!-- Call Now Button ".CNB_VERSION." by Jerry Rietveld (callnowbutton.com) -->\n";
			if($options['appearance'] == 'full') {
				$ButtonAppearance = "width:100%;left:0;";
				$ButtonExtra = "body {padding-bottom:60px;}";				
			} elseif($options['appearance'] == 'left') {
				$ButtonAppearance = "width:100px;left:0;border-bottom-right-radius:40px; border-top-right-radius:40px;";
				$ButtonExtra = "";				
			} else {
				$ButtonAppearance = "width:100px;right:0;border-bottom-left-radius:40px; border-top-left-radius:40px;";
				$ButtonExtra = "";				
			}
			echo $credits."<style>#callnowbutton {display:none;} @media screen and (max-width:650px){#callnowbutton {display:block; ".$ButtonAppearance." height:80px; position:fixed; bottom:-20px; border-top:2px solid ".changeColor($options['color'],'lighter')."; background:url(data:image/svg+xml;base64,".svg(changeColor($options['color'], 'darker') ).") center 2px no-repeat ".$options['color']."; text-decoration:none; box-shadow:0 0 5px #888; z-index:9999;background-size:58px 58px}".$ButtonExtra."}</style>\n";
		}
		add_action('wp_head', 'cnb_head');
		
		function cnb_footer() {
			$alloptions = get_option('cnb');
			
			
			if(isset($alloptions['show']) && $alloptions['show'] != "") {
				$show = explode(',', str_replace(' ', '' ,$alloptions['show']));
				$limited = TRUE;
			} else {
				$limited = FALSE;
			}
			
			if($alloptions['tracking'] == '1') {
				$tracking = "onclick=\"_gaq.push(['_trackEvent', 'Contact', 'Call Now Button', 'Phone']);\""; 
			} elseif($alloptions['tracking'] == '2') {
				$tracking = "onclick=\"ga('send', 'event', 'Contact', 'Call Now Button', 'Phone');\""; 
			} else {
				$tracking = "";
			}
			
			if($limited) {
				if(is_single($show) || is_page($show)) {
					echo '<a href="tel:'.$alloptions['number'].'" id="callnowbutton" '.$tracking.'>&nbsp;</a>';
				}
			} else {
				echo '<a href="tel:'.$alloptions['number'].'" id="callnowbutton" '.$tracking.'>&nbsp;</a>';
			}
		}
		add_action('wp_footer', 'cnb_footer');
	}
} 

function cnb_get_options() { // Checking and setting the default options
	if(!get_option('cnb')) {
		$default_options = array(
							  'active' => 0,
							  'number' => '',
							  'color' => '#009900',
							  'appearance' => 'right',
							  'tracking' => 0,
							  'show' => ''
							  );
		add_option('cnb',$default_options);
		$options = get_option('cnb');
	} 
	
	$options = get_option('cnb');
	
	return $options;
}
function set_basic_options() {
	if(get_option('cnb') && !array_key_exists('color', get_option('cnb'))) {
		$options = get_option('cnb');
		$default_options = array(
							  'active' => $options['active'],
							  'number' => $options['number'],
							  'color' => '#009900',
							  'appearance' => 'right',
							  'tracking' => 0,
							  'show' => ''
							  );
		update_option('cnb',$default_options);
	}
}
function svg($color2) {
	$phone1 = '<path d="M7.104 14.032l15.586 1.984c0 0-0.019 0.5 0 0.953c0.029 0.756-0.26 1.534-0.809 2.1 l-4.74 4.742c2.361 3.3 16.5 17.4 19.8 19.8l16.813 1.141c0 0 0 0.4 0 1.1 c-0.002 0.479-0.176 0.953-0.549 1.327l-6.504 6.505c0 0-11.261 0.988-25.925-13.674C6.117 25.3 7.1 14 7.1 14" fill="'.$color2.'"/><path d="M7.104 13.032l6.504-6.505c0.896-0.895 2.334-0.678 3.1 0.35l5.563 7.8 c0.738 1 0.5 2.531-0.36 3.426l-4.74 4.742c2.361 3.3 5.3 6.9 9.1 10.699c3.842 3.8 7.4 6.7 10.7 9.1 l4.74-4.742c0.897-0.895 2.471-1.026 3.498-0.289l7.646 5.455c1.025 0.7 1.3 2.2 0.4 3.105l-6.504 6.5 c0 0-11.262 0.988-25.925-13.674C6.117 24.3 7.1 13 7.1 13" fill="#fff"/>';
	$svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60">' . $phone1 . '</svg>';
	return base64_encode($svg);
} ?>

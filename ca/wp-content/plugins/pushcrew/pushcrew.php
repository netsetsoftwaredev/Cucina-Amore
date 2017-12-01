<?php
/*
Plugin Name: PushCrew
Plugin URI: https://pushcrew.com/
Description: PushCrew lets you send push notifications from your desktop or mobile website to your users. Simply enable the plugin and start collecting subscribers for your PushCrew account. Visit <a href="https://pushcrew.com/">PushCrew</a> for more details.
Author: Wingify Software Pvt Ltd
Version: 1.1
screenshot-1.png
screenshot-2.png
screenshot-3.png
screenshot-4.png
pushcrew.php
Author URI: https://wingify.com

This relies on the actions being present in the themes header.php and footer.php
* header.php code before the closing </head> tag
*   wp_head();
*
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

$clhf_header_pushcrew_script = '
<!-- Start PushCrew Asynchronous Code -->
<script type=\'text/javascript\'>
(function(p,u,s,h) {
    p._pcq = p._pcq || [];
    p._pcq.push([\'_currentTime\', Date.now()]);
    s = u.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true;
    s.src = \'https://cdn.pushcrew.com/js/PUSHCREW_HASH.js\';
    h = u.getElementsByTagName(\'script\')[0]; h.parentNode.insertBefore(s, h);
})(window,document);
</script>
<!-- End PushCrew Asynchronous Code -->
';

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action ( 'wp_head', 'clhf_headercode',1 );
add_action( 'admin_menu', 'clhf_plugin_menu' );
add_action( 'admin_init', 'clhf_register_mysettings' );
add_action( 'admin_notices','clhf_warn_nosettings');


//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
// options page link
function clhf_plugin_menu() {
  add_options_page('PushCrew', 'PushCrew', 'create_users', 'clhf_pushcrew_options', 'clhf_plugin_options');
}

// whitelist settings
function clhf_register_mysettings(){
  register_setting('clhf_pushcrew_options','pushcrew_hash');
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//
function clhf_headercode(){
  // runs in the header
  global $clhf_header_pushcrew_script;
  $pushcrew_hash = get_option('pushcrew_hash');

  if($pushcrew_hash){
      echo str_replace('PUSHCREW_HASH', $pushcrew_hash, $clhf_header_pushcrew_script); // only output if options were saved
  }
}
//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//
// options page
function clhf_plugin_options() {
  echo '<div class="wrap">';?>
  <h2>PushCrew</h2>
  <p>You need to have a <a target="_blank" href="https://pushcrew.com/">PushCrew</a> account in order to use this plugin. This plugin inserts the neccessary code into your Wordpress site automatically without you having to touch anything. In order to use the plugin, you need to enter your PushCrew Account ID (Your Account ID (a string of characters) can be found in the <i>Account Details</i> section under <i>Settings</i> area after you <a target="_blank" href="https://pushcrew.com/admin/">login</a> into your PushCrew account.)</p>
  <form method="post" action="options.php">
  <?php settings_fields( 'clhf_pushcrew_options' ); ?>
  <table class="form-table">
        <tr valign="top">
            <th scope="row">Your PushCrew Account ID</th>
            <td><input type="text" name="pushcrew_hash" value="<?php echo get_option('pushcrew_hash'); ?>" /></td>
        </tr>
  </table>
  
  <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
<br /><br />
<h1 style="margin-bottom: 40px;">Send Instant Push Notifications from your Desktop and Mobile WordPress Sites</h1>
<img src="https://pushcrew.com/assets/images/home-img.png" />
<p style="margin-top:20px">PushCrew lets you talk to your subscribers in a succinct, easy and delightful manner, using push notifications on websites. Push Notifications are clickable messages sent directly to your subscribers’ browsers (even when they are not on your site). These work on all devices — desktops, tablets and even mobile phones — so you don’t even have to invest in building a mobile app for your business. The opt-in and click rates are amazing! Some of our early adopters have seen an opt-in rate of 40% (10X the rate at which an average email list builds, and 20X the rate at which an average Twitter list populates) and a click rate of 20%. Of course, you get to see all this data, right in your PushCrew dashboard, updated real-time.
<br /><br />
To enable it for your WordPress site, signup for Free at <a target="_blank" href="https://pushcrew.com/">https://pushcrew.com/</a>. Or get in touch with us at <a href="mailto:info@pushcrew.com">info@pushcrew.com</a>
</p>
<?php
  echo '</div>';
}

function clhf_warn_nosettings(){
    if (!is_admin())
        return;

  $clhf_option = get_option("pushcrew_hash");
  if (!$clhf_option){
    echo "<div class='updated fade'><p><strong>PushCrew is almost ready.</strong> You must <a target=\"_blank\" href=\"https://pushcrew.com/admin/settings-accountdetails.php\">enter your Account ID</a> for it to work.</p></div>";
  }
}
?>

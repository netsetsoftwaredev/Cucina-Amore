<?php
/*
* Plugin Name: WP Duplicate posts pages & CPT
* Plugin URI: https://wordpress.org/plugins/wp-duplicate-posts-pages-cpt
* Description: This plugin provides functionality to duplicate the posts, pages and the CPT's with all the custom attributes like taxonomies and post meta data.
* Version: 1.0
* Author: Priyanka Bhave
* Requires at least: 4.1
* Tested up to: 4.6
*/

include_once 'includes/dp_manage.php';
 
function DPWP_install_dupl()
{
	if(is_admin() || current_user_can('manage_options'))
	{
		DPWP_add_row_actions();
	}
   
}

register_activation_hook(__FILE__, 'DPWP_install_dupl');

function DPWP_deactivat_dupl()
{
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'DPWP_deactivat_dupl');
<?php
/**
 * Helpers API.
 */

/**
 * Returns plugin dir path related to DT_DUMMY_PLUGIN_MAIN_FILE constant.
 *
 * @param string $path
 *
 * @return string
 */
function dt_dummy_plugin_dir_path( $path = '' ) {
	return plugin_dir_path( DT_DUMMY_PLUGIN_MAIN_FILE ) . $path;
}

/**
 * Returns plugin dir url related to DT_DUMMY_PLUGIN_MAIN_FILE constant.
 *
 * @param string $path
 *
 * @return string
 */
function dt_dummy_plugin_dir_url( $path = '' ) {
	return plugin_dir_url( DT_DUMMY_PLUGIN_MAIN_FILE ) . $path;
}

/**
 * Determine is Woocommerce plugin is active.
 *
 * @return boolean
 */
function dt_dummy_is_wc_active() {
	return class_exists( 'Woocommerce', false );
}
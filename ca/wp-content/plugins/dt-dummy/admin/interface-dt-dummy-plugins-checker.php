<?php
/**
 * Plugins checher interface.
 *
 * @since 2.0.0
 * @package dt-dummy
 */

interface DT_Dummy_Plugins_Checker_Interface {

	public function is_plugins_active( $plugins = array() );

	public function get_inactive_plugins();

	public function get_install_plugins_page_link();

	public function get_plugin_name( $slug );
}

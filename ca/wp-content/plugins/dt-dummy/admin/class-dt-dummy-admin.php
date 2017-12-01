<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    DT_Dummy
 * @subpackage DT_Dummy/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    DT_Dummy
 * @subpackage DT_Dummy/admin
 * @author     Dream-Theme
 */
class DT_Dummy_Admin {

	private $plugin_page = array();
	private $theme_name;
	private $images_url;

	/**
	 * Main plugin instance.
	 * 
	 * @var object
	 */
	private $plugin;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * @var object
	 */
	private $plugins_checker = null;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct( DT_Dummy $plugin_instance ) {
		$this->plugin = $plugin_instance;
		$this->plugin_name = $this->plugin->get_plugin_name();
		$this->version = $this->plugin->get_version();
	}

	public function choose_dummy_content() {
		$this->theme_name = defined( 'PRESSCORE_THEME_NAME' ) ? PRESSCORE_THEME_NAME : sanitize_key( wp_get_theme()->get( 'Name' ) );
		$this->images_url = plugin_dir_url( __FILE__ ) . '../includes/dummy-content/' . $this->theme_name . '/images/';
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {
		if ( $this->plugin_page['import_dummy'] != $hook ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name . '-import', plugin_dir_url( __FILE__ ) . 'css/dt-dummy-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {
		if ( $this->plugin_page['import_dummy'] != $hook ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name . '-import', plugin_dir_url( __FILE__ ) . 'js/dt-dummy-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name . '-import', 'dtDummy', array(
			'import_nonce' => wp_create_nonce( $this->plugin_name . '_import' ),
			'statusNonce' => wp_create_nonce( $this->plugin_name . '_php_ini_status' ),
			'import_msg' => array(
				'btn_import' => __( 'Importing...', 'dt-dummy' ),
				'msg_import_success' => __( 'Import Success!', 'dt-dummy' ),
				'msg_import_fail' => __( 'Import Fail!', 'dt-dummy' ),
			),
		) );
	}

	/**
	 * @param $links
	 * @param $file
	 *
	 * @return mixed
	 */
	public function add_plugin_action_links( $links, $file ) {
		$links['import-content'] = '<a href="' . esc_url( 'tools.php?page=dt-dummy-import' ) . '">' . __( 'Import content', $this->plugin_name ) . '</a>';
		return $links;
	}

	public function add_admin_notices() {
		global $current_screen;

		if ( ! get_option( 'dt_dummy_first_run_message' ) ) {
			$msg = sprintf( __( 'You can import The7 demo content on <a href="%s">Tools > The7 Demo Content</a> page.' ), esc_url( 'tools.php?page=dt-dummy-import' ) );

			add_settings_error( 'dt-dummy-notices', 'dt-dummy-on-activate', $msg, 'updated' );

			update_option( 'dt_dummy_first_run_message', true );
		}

		if ( ! in_array( $current_screen->parent_base, array( 'options-general', 'options-framework' ) ) ) {
			settings_errors( 'dt-dummy-notices' );
		}
	}
	
	public function ajax_response() {
		if ( ! check_ajax_referer( $this->plugin_name . '_import', false, false ) || ! current_user_can( 'edit_theme_options' ) ) {
			wp_send_json_error( array( 'msg' => '<p>Insufficient user rights.</p>' ) );
		}

		if ( empty( $_POST['dummy'] ) ) {
			wp_send_json_error( array( 'msg' => '<p>Unable to find dummy content.</p>' ) );
		}

		$dummy_content_obj = new DT_Dummy_Content( $this->get_dummy_list(), $this->theme_name );
		$content_part_id = empty( $_POST['content_part_id'] ) ? '0' : sanitize_key( $_POST['content_part_id'] );
		$import_content_dir = $this->plugin->get_plugin_dir( 'includes/dummy-content/' . $this->theme_name );

		$import_manager = new DT_Dummy_Import_Manager( $dummy_content_obj, $content_part_id, $_POST['dummy'], $import_content_dir );

		// Import requested post types from dir.
		$import_manager->import_post_types();

		// Import site meta if meta file entry is present.
		$import_manager->import_site_meta();

		wp_send_json_success();
	}

	public function get_php_ini_status() {
		if ( ! check_ajax_referer( $this->plugin_name . '_php_ini_status', false, false ) || ! current_user_can( 'edit_theme_options' ) ) {
			wp_send_json_error();
		}

		ob_start();
		include 'partials/notices/status.php';
		$status = ob_get_clean();

		wp_send_json_success( $status );
	}

	public function add_plugin_page() {
		$this->plugin_page['import_dummy'] = add_management_page(
			__( 'The7 Demo Content', $this->plugin_name ),
			__( 'The7 Demo Content', $this->plugin_name ),
			'edit_theme_options',
			$this->plugin_name . '-import',
			array( $this, 'plugin_import_page' )
		);
	}

	public function plugin_import_page() {
		include 'partials/dt-dummy-admin-display-import.php';
	}

	public function allow_export_additional_post_types() {
		$post_types = array(
			'attachment'
		);

		foreach ( $post_types as $post_type ) {
			$post_types = get_post_types( array( 'name' => $post_type ), 'objects' );
			if ( ! empty( $post_types ) ) {
				$post_type = reset( $post_types );
				echo '<p><label><input type="radio" name="content" value="' . esc_attr( $post_type->name ) . '" /> ' . esc_html( $post_type->label ) . '</label></p>';
			}
		}
	}

	private function get_dummy_list() {
		include plugin_dir_path( dirname( __FILE__ ) ) . 'includes/dummy-content/dummy-list.php';

		return $dummy_list;
	}

	/**
	 * Factory method. Populates $plugins_checker property.
	 * 
	 * @return object
	 */
	private function plugins_checker() {
		if ( null === $this->plugins_checker ) {
			$this->plugins_checker = ( DT_Dummy_TGMPA::is_tgmpa_active() ? new DT_Dummy_TGMPA() : new DT_Dummy_WP_Plugins() );
		}

		return $this->plugins_checker;
	}
}

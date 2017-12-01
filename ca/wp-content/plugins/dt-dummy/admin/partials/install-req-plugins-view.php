<?php
/**
 * Dummy required plugins not installed view.
 *
 * @package dt-dummy
 * @since   2.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$plugins_info_text_1 = __( 'In order to import this demo, you need to %s the following plugins:', 'dt-dummy' );
$plugins_info_text_2 = __( 'install', 'dt-dummy' );

$tmpa_link = $this->plugins_checker()->get_install_plugins_page_link();
if ( $tmpa_link ) {
	$plugins_info_text_2 = '<a href="' . esc_url( $tmpa_link ) . '">' . $plugins_info_text_2 . '</a>';
}
?>

	<div class="dt-dummy-controls-block">
		<h4><?php printf( $plugins_info_text_1, $plugins_info_text_2 ); ?></h4>
		<p>
			<?php
			$inactive_plugins = $this->plugins_checker()->get_inactive_plugins();

			echo implode( ', ', $inactive_plugins );
			?>
		</p>
	</div>

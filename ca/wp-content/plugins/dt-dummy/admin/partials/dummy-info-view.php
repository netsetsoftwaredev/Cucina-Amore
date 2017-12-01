<?php
/**
 * Dummy info view.
 *
 * @package dt-dummy
 * @since   2.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( $this->plugins_checker()->is_plugins_active( array( 'revslider' ) ) ) :
?>
	<div class="dt-dummy-controls-block dt-dummy-info-content">

		<p><strong><?php printf( __( 'Please note that Slider Revolution content must be imported separately via <a href="%s" target="_blank">interface</a>.', 'dt-dummy' ), admin_url( 'admin.php?page=revslider' ) ); ?></strong></p>

	</div>

<?php
endif;

/* Dummy info content */
$top_content = $dummy_info->get( 'top_content' );

if ( $top_content ) :
?>

	<div class="dt-dummy-controls-block dt-dummy-info-content">

		<?php echo $top_content; ?>

	</div>

<?php endif; ?>

	<div class="dt-dummy-controls-block">

		<div class="dt-dummy-field">
			<label><input type="checkbox" name="all" checked="checked" value="1" /><?php esc_html_e( 'Import the entire content', 'dt-dummy' ); ?></label><span class="dt-dummy-checkbox-desc"><?php esc_html_e( '(Note that this will automatically switch your active Menu and Homepage.)', 'dt-dummy' ); ?></span>
		</div>

		<div class="dt-dummy-field">
			<label><input type="checkbox" name="import_theme_options" value="1" /><?php _e( 'Import Theme Options', 'dt-dummy' ); ?></label><span class="dt-dummy-checkbox-desc"><?php printf( strip_tags( __( '(Attention! That this will overwrite your current Theme Options and widget areas. You may want to %1$sexport%2$s them before proceeding.)', 'dt-dummy' ) ), '<a href="' . admin_url( 'admin.php?page=of-importexport-menu' ) . '" target="_blank">', '</a>' ); ?></span>
		</div>

		<div class="dt-dummy-field">
			<label><input type="checkbox" name="fetch_attachments" checked="checked" value="1" /><?php _e( 'Download and import file attachments', 'dt-dummy' ); ?></label>
		</div>

	</div>

	<div class="dt-dummy-controls-block">
		<h4><?php _e( 'Assign posts to an existing user:', $this->plugin_name ); ?></h4>

		<?php wp_dropdown_users( array(
			'class' => 'dt-dummy-content-user',
			'id' => 'dt-dummy-content-user-' . $content_part_id,
			'selected' => get_current_user_id()
		) ); ?>

	</div>

	<div class="dt-dummy-controls-block dt-dummy-control-buttons">
		<div class="dt-dummy-button-wrap">
			<a href="#" class="button button-primary dt-dummy-button-import"><?php _e( 'Import content', $this->plugin_name ); ?></a><span class="spinner"></span>
		</div>
	</div>

<?php
/* Dummy info content */
$bottom_content = $dummy_info->get( 'bottom_content' );

if ( $bottom_content ) :
?>

	<div class="dt-dummy-controls-block dt-dummy-info-content">

		<?php echo $bottom_content; ?>

	</div>

<?php endif; ?>
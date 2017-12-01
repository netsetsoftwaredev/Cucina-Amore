<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    DT_Dummy
 * @subpackage DT_Dummy/admin/partials
 */

$dummy_content = new DT_Dummy_Content( $this->get_dummy_list(), $this->theme_name );
?>
<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php foreach( $dummy_content->get_content_parts_ids() as $content_part_id ) : ?>

		<?php

		$dummy_info = $dummy_content->get_content_info( $content_part_id );

		$dummy_title = $dummy_info->get( 'title' );
		?>

		<div class="dt-dummy-content">

			<?php if ( $dummy_title ) : ?>

				<h3><?php echo esc_html( $dummy_title ); ?></h3>

			<?php endif; ?>

			<div class="dt-dummy-import-item">

				<?php if ( $dummy_info->get( 'screenshot' ) ) : ?>

					<?php

					$screenshot = $dummy_info->get( 'screenshot' );
					$img = '<img src="' . esc_url( $this->images_url . $screenshot['src'] ) . '" alt="' . esc_attr( $dummy_title ) . '" ' . image_hwstring( $screenshot['width'], $screenshot['height'] ) . '/>';

					if ( $dummy_info->get( 'link' ) ) {
						$img = '<a href="' . esc_url( $dummy_info->get( 'link' ) ) . '" target="_blank">' . $img . '</a>';
					}
					?>
					<div class="dt-dummy-screenshot">

						<?php echo $img; ?>

					</div>

				<?php endif; ?>

				<div class="dt-dummy-controls" data-dt-dummy-content-part-id="<?php echo esc_attr( $content_part_id ); ?>">

					<?php
					if ( $this->plugins_checker()->is_plugins_active( $dummy_info->get( 'req_plugins' ) ) ) {
						include 'dummy-info-view.php';
					} else {
						include 'install-req-plugins-view.php';
					}
					?>

				</div>

			</div>

		</div>

	<?php endforeach; ?>

</div>
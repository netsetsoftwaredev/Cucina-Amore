<?php
// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$dummy_status = new DT_Dummy_Admin_PHPStatus( array(
	'max_execution_time'  => array(
		'value' => '240',
		'type'  => 'seconds',
	),
	'post_max_size'       => array(
		'value' => '64M',
		'type'  => 'bytes',
	),
	'upload_max_filesize' => array(
		'value' => '64M',
		'type'  => 'bytes',
	),
	'memory_limit'        => array(
		'value' => '256M',
		'type'  => 'bytes',
	),
) );
?>
<div style="display: inline-block">
	<p><?php esc_html_e( 'Import Fail!', 'dt-dummy' ); ?></p>

	<?php if ( ! $dummy_status->check_requirements() ) : ?>
		<p><?php esc_html_e( 'Your server configuration does not meet our recommendations. Demo content import may not work correctly. Please apply:', 'dt-dummy' ); ?></p>
		<table class="dt-dummy-php-status widefat">
			<thead>
			<tr>
				<th colspan="2" data-export-label="<?php esc_attr_e( 'Server Environment', 'dt-dummy' ); ?>">
					<h2><?php esc_html_e( 'Server Environment', 'dt-dummy' ); ?></h2>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$strings        = array(
				'post_max_size'       => __( 'PHP Post Max Size', 'dt-dummy' ),
				'upload_max_filesize' => __( 'PHP Upload Max File Size', 'dt-dummy' ),
				'max_execution_time'  => __( 'PHP Time Limit', 'dt-dummy' ),
				'memory_limit'        => __( 'PHP Memory Limit', 'dt-dummy' ),
			);
			$status_report  = $dummy_status->get_ini_entries();
			foreach ( $status_report as $entry_name => $entry ):
				$required_value = '';
				$mark_class = 'yes';
				if ( ! $entry['good'] ) {
					$required_value = '&nbsp;' . sprintf( __( '(%s recommended)', 'dt-dummy' ), $entry['required_value'] );
					$mark_class     = 'error';
				}
				?>
				<tr>
					<td data-export-label="<?php echo esc_attr( $strings[ $entry_name ] ); ?>"><?php echo esc_html( $strings[ $entry_name ] ); ?>:</td>
					<td>
						<mark class="<?php echo esc_attr( $mark_class ); ?>"><?php echo esc_html( $entry['value'] . $required_value ); ?></mark>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<p>
			<?php esc_html_e( 'How to:', 'dt-dummy' ); ?>
			<a href="http://support.dream-theme.com/knowledgebase/allowed-memory-size-error/" target="_blank"><?php esc_html_e( 'tutorials', 'dt-dummy' ); ?></a>
		</p>
	<?php endif; ?>
</div>

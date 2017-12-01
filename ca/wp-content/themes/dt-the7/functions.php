<?php
/**
 * Vogue theme.
 *
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}

/**
 * Initialize theme.
 *
 * @since 1.0.0
 */
require( trailingslashit( get_template_directory() ) . 'inc/init.php' );


if ( function_exists( 'add_image_size' ) ) {
add_image_size( 'team-member', 825, 510, true ); //(cropped)
}
add_filter('image_size_names_choose', 'my_image_sizes');
function my_image_sizes($sizes) {
$addsizes = array(
"team-member" => __( "Team Member Size")
);
$newsizes = array_merge($sizes, $addsizes);
return $newsizes;
}

// Add Shortcode
function custom_shortcode() {

/* Listing Code */
		$args_data = array (
			'tax_query' => array(
				array(
					'taxonomy' => 'dt_team_category',
					'field' => 'slug',
					'terms' => 'owner'
				),
			),
			'post_type' => 'dt_team', // <== this was missing
			'posts_per_page' => 2,
			'order' => 'ASC'
		);
		$data_post = new WP_Query( $args_data );
	?>
	<div class="entry-content">
	<?php while ( $data_post->have_posts() ) : $data_post->the_post(); ?>
		<div class="owners">
			<div class="employee">
				<?php the_post_thumbnail();   ?>
				<div class="employee_Name_post  display-bl-nn">
					<h3 class="entry-title"><?php the_title(); ?></h3>
					<p><?php $meta = get_post_meta( get_the_ID(), '_dt_teammate_options_position', TRUE );
						echo $meta;	 ?></p>
				</div>
			</div>
			<div class="employee_hover">
				<div class="employee_img">	<?php the_content();?>	</div>
				<div class="employee_Name_post">
					<h3 class="entry-title"><?php the_title(); ?></h3>
					<p><?php $meta = get_post_meta( get_the_ID(), '_dt_teammate_options_position', TRUE );
						echo $meta;	 ?></p>
				</div>
			</div>
		</div>
		<?php endwhile;?>
	</div>
	
	<div class="entry-content" style="clear:both;">
	<?php 
		$args  = array (
			'tax_query' => array(
				array(
					'taxonomy' => 'dt_team_category',
					'field' => 'slug',
					'terms' => 'other-team-members'
				),
			),
			'post_type' => 'dt_team', // <== this was missing
			'posts_per_page' => -1,
			'order' => 'ASC'
		);
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
	?>					
	<div class="employee_main">
		<div class="employee">
			<?php the_post_thumbnail('team-member');   ?>
			<div class="employee_Name_post display-bl-nn">
				<h3 class="entry-title"><?php the_title(); ?></h3>
				<p><?php $meta = get_post_meta( get_the_ID(), '_dt_teammate_options_position', TRUE );
						echo $meta;	 ?></p>
			</div>
		</div>
		<div class="employee_hover">
			<div class="employee_img">	<?php the_content();?>	</div>
			<div class="employee_Name_post">
				<h3 class="entry-title"><?php the_title(); ?></h3>
				<p><?php $meta = get_post_meta( get_the_ID(), '_dt_teammate_options_position', TRUE );
						echo $meta;	 ?></p>
			</div>
		</div>
	</div>
	<?php endwhile;?>
	</div>
<?php /* Listing Code */
}
add_shortcode( 'about-team-list', 'custom_shortcode' );

function rudr_instagram_api_curl_connect( $api_url ){
	$connection_c = curl_init(); // initializing
	curl_setopt( $connection_c, CURLOPT_URL, $api_url ); // API URL to connect
	curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
	curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
	$json_return = curl_exec( $connection_c ); // connect and get json data
	curl_close( $connection_c ); // close connection
	return json_decode( $json_return ); // decode and return
}

function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
   // wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );
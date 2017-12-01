<?php
/**
 * Benefits admin part.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Presscore_Mod_Benefits_Admin {

	public function register_post_types() {
		$post_type = 'dt_benefits';
		$args = array(
			'labels'                => array(
				'name'                  => _x('Benefits',					'backend benefits', 'dt-the7-core'),
				'singular_name'         => _x('Benefit',					'backend benefits', 'dt-the7-core'),
				'add_new'               => _x('Add New Benefit',			'backend benefits', 'dt-the7-core'),
				'add_new_item'          => _x('Add New Benefit',			'backend benefits', 'dt-the7-core'),
				'edit_item'             => _x('Edit Item',					'backend benefits', 'dt-the7-core'),
				'new_item'              => _x('New Item',					'backend benefits', 'dt-the7-core'),
				'view_item'             => _x('View Item',					'backend benefits', 'dt-the7-core'),
				'search_items'          => _x('Search Items',				'backend benefits', 'dt-the7-core'),
				'not_found'             => _x('No items found',				'backend benefits', 'dt-the7-core'),
				'not_found_in_trash'    => _x('No items found in Trash',	'backend benefits', 'dt-the7-core'),
				'parent_item_colon'     => '',
				'menu_name'             => _x('Benefits',					'backend benefits', 'dt-the7-core')
			),
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'query_var'             => true,
			'rewrite'               => true,
			'capability_type'       => 'post',
			'has_archive'           => true,
			'hierarchical'          => false,
			'menu_position'         => 39,
			'exclude_from_search'	=> true,
			'supports'              => array( 'title', 'thumbnail', 'editor' )
		);

		$args = apply_filters( "presscore_post_type_{$post_type}_args", $args );

		register_post_type( $post_type, $args );
	}

	public function register_taxonomies() {
		$post_type = 'dt_benefits';
		$taxonomy = 'dt_benefits_category';
		$args = array(
			'labels'                => array(
				'name'              => _x( 'Benefit Categories',			'backend partners', 'dt-the7-core' ),
				'singular_name'     => _x( 'Benefit Category',				'backend partners', 'dt-the7-core' ),
				'search_items'      => _x( 'Search in Category',			'backend partners', 'dt-the7-core' ),
				'all_items'         => _x( 'Benefit Categories',			'backend partners', 'dt-the7-core' ),
				'parent_item'       => _x( 'Parent Category',				'backend partners', 'dt-the7-core' ),
				'parent_item_colon' => _x( 'Parent Category:',				'backend partners', 'dt-the7-core' ),
				'edit_item'         => _x( 'Edit Category',					'backend partners', 'dt-the7-core' ),
				'update_item'       => _x( 'Update Category',				'backend partners', 'dt-the7-core' ),
				'add_new_item'      => _x( 'Add New Benefit Category',		'backend partners', 'dt-the7-core' ),
				'new_item_name'     => _x( 'New Benefit Category Name',		'backend partners', 'dt-the7-core' ),
				'menu_name'         => _x( 'Benefit Categories',			'backend partners', 'dt-the7-core' )
			),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'rewrite'               => true,
			'show_admin_column'		=> true,
		);

		$args = apply_filters( "presscore_taxonomy_{$taxonomy}_args", $args );

		register_taxonomy( $taxonomy, array( $post_type ), $args );
	}

	public function add_meta_boxes( $metaboxes ) {
		$metaboxes[] = plugin_dir_path( __FILE__ ) . 'metaboxes/metaboxes-benefits.php';
		return $metaboxes;
	}

	public function js_composer_default_editor_post_types_filter( $post_types ) {
		$post_types[] = 'dt_benefits';
		return $post_types;
	}
}

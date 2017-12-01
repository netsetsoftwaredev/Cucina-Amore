<?php
/*
Plugin Name: Themovation Custom Post Types
Plugin URI: http://themovation.com
Description: This is a plugin comes bundled with most Themovation themes. It adds the custom post types required to run most themes.
Version: 2
Author: Themovation
Author URI: http://themovation.com
Text Domain: themovation-custom-post-types
Domain Path: /languages/
License: GPL2
*/

function themovation_custom_post_types_load_textdomain() {
    load_plugin_textdomain( 'themovation-custom-post-types', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'themovation_custom_post_types_load_textdomain' );

//-----------------------------------------------------
// themo_portfolio_custom_post_type
// Create a Custom Post Type for the Portfolio
//-----------------------------------------------------

if ( ! function_exists('themo_portfolio_custom_post_type') ) {

// Register Custom Post Type
    function themo_portfolio_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Projects', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Portfolio', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Project:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Projects', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Project', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Project', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Project', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Project', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Project', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );

        if ( function_exists( 'ot_get_option' ) ) {
            $custom_slug = ot_get_option( 'themo_portfolio_rewrite_slug', 'portfolio' );
        }else{
            $custom_slug = 'portfolio';
        }

        $rewrite = array(
            'slug'                => $custom_slug,
            'with_front'          => false,
            'pages'               => true,
            'feeds'               => true,
        );
        $args = array(
            'label'               => __( 'themo_portfolio', 'themovation-custom-post-types' ),
            'description'         => __( 'Portfolio', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
            'taxonomies'          => array( 'themo_project_type' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_portfolio', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_portfolio_custom_post_type', 0 );

}

//-----------------------------------------------------
// themo_project_type
// Create a Taxonomy for the Portfolio
//-----------------------------------------------------

if ( ! function_exists( 'themo_project_type' ) ) {

// Register Custom Taxonomy
    function themo_project_type() {

        $labels = array(
            'name'                       => _x( 'Project Types', 'Taxonomy General Name', 'themovation-custom-post-types' ),
            'singular_name'              => _x( 'Project Type', 'Taxonomy Singular Name', 'themovation-custom-post-types' ),
            'menu_name'                  => __( 'Project Types', 'themovation-custom-post-types' ),
            'all_items'                  => __( 'All Project Types', 'themovation-custom-post-types' ),
            'parent_item'                => __( 'Parent Project Type', 'themovation-custom-post-types' ),
            'parent_item_colon'          => __( 'Parent Project Type:', 'themovation-custom-post-types' ),
            'new_item_name'              => __( 'New Project Type Name', 'themovation-custom-post-types' ),
            'add_new_item'               => __( 'Add New Project Type', 'themovation-custom-post-types' ),
            'edit_item'                  => __( 'Edit Project Type', 'themovation-custom-post-types' ),
            'update_item'                => __( 'Update Project Type', 'themovation-custom-post-types' ),
            'separate_items_with_commas' => __( 'Separate Project Type with commas', 'themovation-custom-post-types' ),
            'search_items'               => __( 'Search Project Types', 'themovation-custom-post-types' ),
            'add_or_remove_items'        => __( 'Add or remove project type', 'themovation-custom-post-types' ),
            'choose_from_most_used'      => __( 'Choose from the most project types', 'themovation-custom-post-types' ),
            'not_found'                  => __( 'Not Found', 'themovation-custom-post-types' ),
        );
        $rewrite = array(
            'slug'                       => 'project-type',
            'with_front'                 => true,
            'hierarchical'               => false,
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'rewrite'                    => $rewrite,
        );
        register_taxonomy( 'themo_project_type', array( 'themo_portfolio' ), $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_project_type', 0 );

}


//-----------------------------------------------------
// themo_accordion_custom_post_type
// Create a Custom Post Type for the Accordion
//-----------------------------------------------------

if ( ! function_exists('themo_accordion_custom_post_type') ) {

// Register Custom Post Type
    function themo_accordion_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Accordions', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Accordion', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Accordion', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_accordion', 'themovation-custom-post-types' ),
            'description'         => __( 'Accordion Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'revisions', 'page-attributes', ),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_accordion', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_accordion_custom_post_type', 0 );

}

if ( ! function_exists('themo_brands_custom_post_type') ) {

// Register Custom Post Type
    function themo_brands_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Brands', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Brand', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Brand', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_brands', 'themovation-custom-post-types' ),
            'description'         => __( 'Brand', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'thumbnail', 'revisions', 'page-attributes', ),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_brands', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_brands_custom_post_type', 0 );
}


//-----------------------------------------------------
// themo_faq_custom_post_type
// Create a Custom Post Type for the Faq
//-----------------------------------------------------

if ( ! function_exists('themo_faq_custom_post_type') ) {

// Register Custom Post Type
    function themo_faq_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Faqs', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Faq', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Faq', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_faq', 'themovation-custom-post-types' ),
            'description'         => __( 'Faq Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'revisions', 'page-attributes', ),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_faq', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_faq_custom_post_type', 0 );

}

//-----------------------------------------------------
// themo_featured_custom_post_type
// Create a Custom Post Type for the featured
//-----------------------------------------------------

if ( ! function_exists('themo_featured_custom_post_type') ) {

// Register Custom Post Type
    function themo_featured_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Featured', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Featured', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Featured', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_featured', 'themovation-custom-post-types' ),
            'description'         => __( 'Featured Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', ),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_featured', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_featured_custom_post_type', 0 );

}

//-----------------------------------------------------
// themo_pricing_plans_custom_post_type
// Create a Custom Post Type for the Pricing Plans
//-----------------------------------------------------

if ( ! function_exists('themo_pricing_plans_custom_post_type') ) {

// Register Custom Post Type
    function themo_pricing_plans_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Pricing Plans', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Pricing Plan', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Pricing Plan', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_pricing_plans', 'themovation-custom-post-types' ),
            'description'         => __( 'Pricing Plan Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', 'page-attributes', ),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_pricing_plans', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_pricing_plans_custom_post_type', 0 );

}

//-----------------------------------------------------
// themo_slider_custom_post_type
// Create a Custom Post Type for the slider
//-----------------------------------------------------

if ( ! function_exists('themo_slider_custom_post_type') ) {

// Register Custom Post Type
    function themo_slider_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Sliders', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Slider', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Slider', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_slider', 'themovation-custom-post-types' ),
            'description'         => __( 'Slider Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', ),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_slider', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_slider_custom_post_type', 0 );

}

//-----------------------------------------------------
// themo_team_custom_post_type
// Create a Custom Post Type for the Team
//-----------------------------------------------------

if ( ! function_exists('themo_team_custom_post_type') ) {

// Register Custom Post Type
    function themo_team_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Teams', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Team', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Team', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_team', 'themovation-custom-post-types' ),
            'description'         => __( 'Team Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'revisions', 'page-attributes', 'thumbnail',),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_team', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_team_custom_post_type', 0 );

}


//-----------------------------------------------------
// themo_testimonials_custom_post_type
// Create a Custom Post Type for the Testimonial
//-----------------------------------------------------

if ( ! function_exists('themo_testimonials_custom_post_type') ) {

// Register Custom Post Type
    function themo_testimonials_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Testimonials', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Testimonial', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_testimonials', 'themovation-custom-post-types' ),
            'description'         => __( 'Testimonial Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', 'page-attributes', 'thumbnail',),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_testimonials', $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_testimonials_custom_post_type', 0 );

}


//-----------------------------------------------------
// themo_thumb_slider_custom_post_type
// Create a Custom Post Type for the Testimonial
//-----------------------------------------------------

if ( ! function_exists('themo_thumb_slider_custom_post_type') ) {

// Register Custom Post Type
    function themo_thumb_slider_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Thumbnail Sliders', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Thumbnail Slider', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Thumbnail Slider', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_thumb_slider', 'themovation-custom-post-types' ),
            'description'         => __( 'Thumbnail Slider Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', 'page-attributes', 'thumbnail',),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_thumb_slider', $args );




    }

// Hook into the 'init' action
    add_action( 'init', 'themo_thumb_slider_custom_post_type', 0 );

}


//-----------------------------------------------------
// themo_tour_custom_post_type
// Create a Custom Post Type for the Testimonial
//-----------------------------------------------------

if ( ! function_exists('themo_tour_custom_post_type') ) {

// Register Custom Post Type
    function themo_tour_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Tours', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Tour', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Tour', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_tour', 'themovation-custom-post-types' ),
            'description'         => __( 'Tour Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', 'page-attributes', 'thumbnail', 'editor'),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_tour', $args );




    }

// Hook into the 'init' action
    add_action( 'init', 'themo_tour_custom_post_type', 0 );

}


//-----------------------------------------------------
// themo_service_block_custom_post_type
// Create a Custom Post Type for the Testimonial
//-----------------------------------------------------

if ( ! function_exists('themo_service_block_custom_post_type') ) {

// Register Custom Post Type
    function themo_service_block_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Service Block & Showcase', 'Post Type General Name', 'themovation-custom-post-types' ),
            'singular_name'       => _x( 'Service Block & Showcase', 'Post Type Singular Name', 'themovation-custom-post-types' ),
            'menu_name'           => __( 'Service Block & Showcase', 'themovation-custom-post-types' ),
            'parent_item_colon'   => __( 'Parent Item:', 'themovation-custom-post-types' ),
            'all_items'           => __( 'All Items', 'themovation-custom-post-types' ),
            'view_item'           => __( 'View Item', 'themovation-custom-post-types' ),
            'add_new_item'        => __( 'Add New Item', 'themovation-custom-post-types' ),
            'add_new'             => __( 'Add New', 'themovation-custom-post-types' ),
            'edit_item'           => __( 'Edit Item', 'themovation-custom-post-types' ),
            'update_item'         => __( 'Update Item', 'themovation-custom-post-types' ),
            'search_items'        => __( 'Search Item', 'themovation-custom-post-types' ),
            'not_found'           => __( 'Not found', 'themovation-custom-post-types' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'themovation-custom-post-types' ),
        );
        $args = array(
            'label'               => __( 'themo_service_block', 'themovation-custom-post-types' ),
            'description'         => __( 'Service Block & Showcase Box', 'themovation-custom-post-types' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', 'page-attributes', 'editor'),
            'taxonomies'          => array( 'themo_cpt_group' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 99,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'themo_service_block', $args );
    }

// Hook into the 'init' action
    add_action( 'init', 'themo_service_block_custom_post_type', 0 );

}

if ( ! function_exists( 'themo_custom_post_type_group' ) ) {

// Register Custom Taxonomy
    function themo_custom_post_type_group() {

        $labels = array(
            'name'                       => _x( 'Groups', 'Taxonomy General Name', 'themovation-custom-post-types' ),
            'singular_name'              => _x( 'Group', 'Taxonomy Singular Name', 'themovation-custom-post-types' ),
            'menu_name'                  => __( 'Groups', 'themovation-custom-post-types' ),
            'all_items'                  => __( 'All Groups', 'themovation-custom-post-types' ),
            'parent_item'                => __( 'Parent Group', 'themovation-custom-post-types' ),
            'parent_item_colon'          => __( 'Parent Group:', 'themovation-custom-post-types' ),
            'new_item_name'              => __( 'New Group Name', 'themovation-custom-post-types' ),
            'add_new_item'               => __( 'Add New Group', 'themovation-custom-post-types' ),
            'edit_item'                  => __( 'Edit Group', 'themovation-custom-post-types' ),
            'update_item'                => __( 'Update Group', 'themovation-custom-post-types' ),
            'separate_items_with_commas' => __( 'Separate group with commas', 'themovation-custom-post-types' ),
            'search_items'               => __( 'Search groups', 'themovation-custom-post-types' ),
            'add_or_remove_items'        => __( 'Add or remove group', 'themovation-custom-post-types' ),
            'choose_from_most_used'      => __( 'Choose from the most used groups', 'themovation-custom-post-types' ),
            'not_found'                  => __( 'Not Found', 'themovation-custom-post-types' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => false,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
            'rewrite'                    => false,
        );

        register_taxonomy( 'themo_cpt_group', array( 'themo_accordion', 'themo_brands', 'themo_slider', 'themo_faq',
            'themo_pricing_plans', 'themo_team', 'themo_testimonials', 'themo_thumb_slider', 'themo_tour',
            'themo_service_block', 'themo_featured' ), $args );

    }

// Hook into the 'init' action
    add_action( 'init', 'themo_custom_post_type_group', 0 );

}

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

function mt_add_pages()
{
// Add a new top-level menu (ill-advised):
    add_menu_page(__('Add Content', 'themovation-custom-post-types'), __('Add Content', 'themovation-custom-post-types'), 'manage_options', 'themo-top-level-handle', 'themo_toplevel_page','dashicons-welcome-add-page', 99);

    // Add a submenu to the custom top-level menu:
    add_submenu_page('themo-top-level-handle', __('Accordions', 'themovation-custom-post-types'), __('Accordions', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_accordion');
    add_submenu_page('themo-top-level-handle', __('Brands', 'themovation-custom-post-types'), __('Brands', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_brands');
    add_submenu_page('themo-top-level-handle', __('FAQs', 'themovation-custom-post-types'), __('FAQs', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_faq');
    add_submenu_page('themo-top-level-handle', __('Featured', 'themovation-custom-post-types'), __('Featured', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_featured');
    add_submenu_page('themo-top-level-handle', __('Pricing Plans', 'themovation-custom-post-types'), __('Pricing Plans', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_pricing_plans');
    add_submenu_page('themo-top-level-handle', __('Sliders', 'themovation-custom-post-types'), __('Sliders', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_slider');
    add_submenu_page('themo-top-level-handle', __('Teams', 'themovation-custom-post-types'), __('Teams', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_team');
    add_submenu_page('themo-top-level-handle', __('Testimonials', 'themovation-custom-post-types'), __('Testimonials', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_testimonials');
    add_submenu_page('themo-top-level-handle', __('Thumbnail Sliders', 'themovation-custom-post-types'), __('Thumbnail Sliders', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_thumb_slider');
    add_submenu_page('themo-top-level-handle', __('Tours', 'themovation-custom-post-types'), __('Tours', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_tour');
    add_submenu_page('themo-top-level-handle', __('Service Block & Showcase', 'themovation-custom-post-types'), __('Service Block & Showcase', 'themovation-custom-post-types'), 'manage_options', 'edit.php?post_type=themo_service_block');
    add_submenu_page('themo-top-level-handle', __('Groups', 'themovation-custom-post-types'), __('Groups', 'themovation-custom-post-types'), 'manage_options', 'edit-tags.php?taxonomy=themo_cpt_group');
}

// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function themo_toplevel_page() {
    // generate url path to Theme Options.
    $theme_options_url = admin_url( 'themes.php?page=ot-theme-options');

    $current_user = wp_get_current_user();

    if(isset($current_user->user_firstname) && $current_user->user_firstname > "") {
        $active_user_name = ' '.$current_user->user_firstname .'!';
    }elseif(isset($current_user->user_login)){
        $active_user_name = ' '.$current_user->user_login.'!';
    }else{
        $active_user_name = '!';
    }

    echo "<h1>" . __( 'Hello'.$active_user_name, 'themovation-custom-post-types' ) . "</h1>";

    echo "<h2>" . __( 'Theme Options', 'themovation-custom-post-types' ) . "</h2>";
    echo "<p><a href='$theme_options_url'>Theme Options</a></p>";

    echo "<h2>" . __( 'Add / Manage Content', 'themovation-custom-post-types' ) . "</h2>";
    echo "<ul>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_accordion')."'>".__( 'Accordions', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_brands')."'>".__( 'Brands', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_faq')."'>".__( 'FAQs', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_featured')."'>".__( 'Featured', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_pricing_plans')."'>".__( 'Pricing Plans', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_slider')."'>".__( 'Sliders', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_team')."'>".__( 'Teams', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_testimonials')."'>".__( 'Testimonials', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_thumb_slider')."'>".__( 'Thumbnail Sliders', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_tour')."'>".__( 'Tours', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit.php?post_type=themo_service_block')."'>".__( 'Service Block & Showcase', 'themovation-custom-post-types' )."</a></li>";
    echo "<li><a href='".admin_url('edit-tags.php?taxonomy=themo_cpt_group')."'>".__( 'Content Groups', 'themovation-custom-post-types' )."</a></li>";
    echo "<ul>";

}

// Make sure subpages are shown expanded under their parent page.
function themo_content_group_menu_correction($parent_file) {
    global $current_screen;
    //echo $current_screen->id;
    $taxonomy = $current_screen->taxonomy;
    $post_type = $current_screen->post_type;
    if ($taxonomy == 'themo_cpt_group' || $taxonomy == 'future'){
        $parent_file = 'themo-top-level-handle';
    }
    if ($post_type == 'themo_accordion' || $post_type == 'themo_brands' || $post_type == 'themo_slider' ||
        $post_type == 'themo_faq' || $post_type == 'themo_featured' || $post_type == 'themo_pricing_plans' ||
        $post_type == 'themo_team' || $post_type == 'themo_testimonials' || $post_type == 'themo_thumb_slider'
        || $post_type == 'themo_tour' || $post_type == 'themo_service_block'){
        $parent_file = 'themo-top-level-handle';
    }
    return $parent_file;
}
add_action('parent_file', 'themo_content_group_menu_correction');

// Make Group Column Sortable

function themo_sortable_group_column( $columns ) {

    $columns['taxonomy-themo_cpt_group'] = 'Groups';
    return $columns;
}
add_filter( 'manage_edit-themo_accordion_sortable_columns', 'themo_sortable_group_column' );

// automatically create and apply filters from all taxonomies that apply to all custom post types which use them.
function todo_restrict_manage_posts() {
    global $typenow;
    $args=array();
    $post_types = get_post_types($args);
    if ( in_array($typenow, $post_types) ) {
        $filters = get_object_taxonomies($typenow);
        foreach ($filters as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            wp_dropdown_categories(array(
                //'show_option_all' => __('Show All '.$tax_obj->label ),
                'show_option_all' => sprintf( __( 'Show All %1$s', 'themovation-custom-post-types' ), $tax_obj->label ),
                'taxonomy' => $tax_slug,
                'name' => $tax_obj->name,
                'orderby' => 'term_order',
                'selected' => isset($_GET[$tax_obj->query_var]) ? $_GET[$tax_obj->query_var] : '',
                'hierarchical' => $tax_obj->hierarchical,
                'show_count' => false,
                'hide_empty' => true
            ));
        }
    }
}
function todo_convert_restrict($query) {
    global $pagenow;
    global $typenow;
    if ($pagenow=='edit.php') {
        $filters = get_object_taxonomies($typenow);
        foreach ($filters as $tax_slug) {
            $var = &$query->query_vars[$tax_slug];
            if ( isset($var) ) {
                $term = get_term_by('id',$var,$tax_slug);
                $var = $term->slug;
            }
        }
    }
    return $query;
}
add_action( 'restrict_manage_posts', 'todo_restrict_manage_posts' );
add_filter('parse_query','todo_convert_restrict');
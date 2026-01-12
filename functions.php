<?php
function portable_theme_setup() {
    // Support for custom logo
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // Register menu
    register_nav_menus([
        'primary' => __('Primary Menu', 'portable-acf-theme'),
    ]);

    // Support title tag
    add_theme_support('title-tag');

    // Support post thumbnails
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'portable_theme_setup');


function portable_theme_scripts() {

    // Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        [],
        '5.3.2'
    );

    // Theme main CSS (after Bootstrap)
    wp_enqueue_style(
        'theme-style',
        get_stylesheet_uri(),
        ['bootstrap-css'], // dependency
        '1.0'
    );

    // Bootstrap JS bundle (includes Popper)
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        ['jquery'], // WordPress jQuery dependency
        '5.3.2',
        true // load in footer
    );
}
add_action('wp_enqueue_scripts', 'portable_theme_scripts');

require_once get_theme_file_path('/inc/acf-loader.php');
require_once get_theme_file_path('/inc/acf-blocks.php');

// Load Bootstrap Navwalker
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

function mytheme_enqueue_styles() {
    wp_enqueue_style(
        'mytheme-main-style',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        array(),
        filemtime( get_stylesheet_directory() . '/assets/css/main.css' )
    );
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_styles' );


// Register Portfolio post type
function register_portfolio_cpt() {
    $labels = array(
        'name'                  => _x('Portfolio', 'Post Type General Name', 'textdomain'),
        'singular_name'         => _x('Portfolio Item', 'Post Type Singular Name', 'textdomain'),
        'menu_name'             => __('Portfolio', 'textdomain'),
        'name_admin_bar'        => __('Portfolio Item', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Portfolio Item', 'textdomain'),
        'edit_item'             => __('Edit Portfolio Item', 'textdomain'),
        'new_item'              => __('New Portfolio Item', 'textdomain'),
        'view_item'             => __('View Portfolio Item', 'textdomain'),
        'all_items'             => __('All Portfolio Items', 'textdomain'),
        'search_items'          => __('Search Portfolio', 'textdomain'),
        'not_found'             => __('No portfolio items found.', 'textdomain'),
        'not_found_in_trash'    => __('No portfolio items found in Trash.', 'textdomain'),
    );

    $args = array(
        'label'                 => __('Portfolio', 'textdomain'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail', 'excerpt'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Gutenberg support
    );

    register_post_type('portfolio', $args);
}
add_action('init', 'register_portfolio_cpt', 0);
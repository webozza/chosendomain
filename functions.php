<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.1.87' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {
	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'nouislider', get_stylesheet_directory_uri() . '/css/nouislider.css', array(), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'flaticon', get_stylesheet_directory_uri() . '/css/flaticon.css');
}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function custom_scripts() {
    wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, false );
    wp_enqueue_script( 'nouislider', get_stylesheet_directory_uri() . '/js/nouislider.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION );
    wp_localize_script('main', 'my_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce'),
    ));
}
add_action( 'wp_enqueue_scripts', 'custom_scripts');

/**
 * Ajax filter
 */
// -------------------- load more -------------
add_action('wp_ajax_load_more_products', 'load_more_products');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products');

function load_more_products() {
    $filterData = $_POST['filterData'];
    $filteredProductIds = get_filtered_product_ids($filterData);

    // Send a JSON response with appropriate headers
    wp_send_json_success(array('filteredProducts' => $filteredProductIds));
    wp_die();
}



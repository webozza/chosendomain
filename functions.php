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
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.1.92' );

// Enable error reporting and display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    if (isset($_POST['filterData'])) {
        $filterData = $_POST['filterData'];
        $filteredProductIds = get_filtered_product_ids($filterData);

        // Render the products loop and return the HTML
        $products_html = render_product_loop($filteredProductIds);

        wp_send_json_success(array('data' => $products_html));
    } else {
        wp_send_json_error('Filter data not provided.');
    }
    wp_die();
}

function get_filtered_product_ids($filterData) {
    // Apply the filter criteria to retrieve the filtered product IDs
    // Implement your filtering logic here
    // Return an array of product IDs
    return array(); // Placeholder, replace with your actual logic
}

function render_product_loop($productIds) {
    // Use the product IDs to query and render the products loop
    ob_start(); // Start output buffering
    foreach ($productIds as $productId) {
        // Query and render each product here
        // Example: $product = wc_get_product($productId);
        // Example: echo '<div class="product">' . $product->get_title() . '</div>';
    }
    $products_html = ob_get_clean(); // Get the buffered content and clear buffer
    return $products_html;
}



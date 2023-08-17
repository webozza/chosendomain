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
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.1.56' );

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
	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION );
	wp_enqueue_script( 'nouislider', get_stylesheet_directory_uri() . '/js/nouislider.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION );
}
add_action( 'wp_enqueue_scripts', 'custom_scripts');
// Change WooCommerce "Related products" textadd_filter('gettext', 'change_rp_text', 10, 3);add_filter('ngettext', 'change_rp_text', 10, 3);function change_rp_text($translated, $text, $domain){     if ($text === 'Related product' && $domain === 'woocommerce') {         $translated = esc_html__('Similar Domains', $domain);     }     return $translated;}

// -------------------- load more -------------
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts() {
    $page = $_POST['page'];
    $posts_per_page = 10; // Number of products per page

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $page, // Use 'paged' to indicate the current page
    );

    $product_query = new WP_Query($args);

    if ($product_query->have_posts()) {
        while ($product_query->have_posts()) {
            $product_query->the_post();

            $product_id = get_the_ID();
            $product_title = get_the_title();
            $product_slug = get_post_field('post_name', $product_id);
            $price = get_post_meta($product_id, '_price', true);
            $product_description = get_the_content();
            $da = get_post_meta($product_id, 'da', true);
            $dr = get_post_meta($product_id, 'dr', true);
            $live_rd = get_post_meta($product_id, 'live_rd', true);
            $hist_rd = get_post_meta($product_id, 'hist_rd', true);
            $age = get_post_meta($product_id, 'age', true);
            $product_image_url = get_the_post_thumbnail_url($product_id, 'full');
            $product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names'));

            // Domain Extensions
            $domain_extensions = wp_get_post_terms($product_id, 'extension');
            $extension_names = array();
            foreach ($domain_extensions as $extension) {
                $extension_names[] = $extension->name;
            }

            // Domain Type
            $domain_type = get_field('domain_type', $product_id);

            // Authority Backlinks
            $authority_backlinks = wp_get_post_terms($product_id, 'authory_backlink');
            $ab_names = array();
            foreach ($authority_backlinks as $backlink) {
                $ab_names[] = $backlink->name;
            }

            // Language
            $languages  = wp_get_post_terms($product_id, 'language');
            $langs = array();
            foreach ($languages as $lang) {
                $langs[] = $lang->name;
            }

            // Use Cases
            $use_cases = get_post_meta($product_id, 'usecase', false);
            if (empty($use_cases)) {
                $uses = [];
            } else {
                $uses = $use_cases[0];
            }

            if ($_POST['base_url'] == "/domains/") {
                // Output the product HTML for "/domains/" base URL
                ?>
                <div class="product-box visible" data-domain-name="<?= $product_title ?>" data-domain-extension='<?= esc_attr(json_encode($extension_names)); ?>' data-domain-type="<?= $domain_type ?>" data-auth-backlinks='<?= json_encode($ab_names) ?>' data-languages='<?= json_encode($langs) ?>' data-use-cases='<?= json_encode($uses) ?>'>
                    <!-- Your HTML code here for domain products -->
                </div>
                <?php
            } else {
                // Output the product HTML for other base URLs
                ?>
                <div class="product-box visible" data-domain-name="<?= $product_title ?>" data-domain-extension='<?= esc_attr(json_encode($extension_names)); ?>' data-domain-type="<?= $domain_type ?>" data-auth-backlinks='<?= json_encode($ab_names) ?>' data-languages='<?= json_encode($langs) ?>' data-use-cases='<?= json_encode($uses) ?>'>
                    <!-- Your HTML code here for non-domain products -->
                </div>
                <?php
            }
        }
    } else {
        // No more products to load
        echo '';
    }

    wp_reset_postdata();
    die();
}

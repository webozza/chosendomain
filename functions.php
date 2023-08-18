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
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.1.96' );

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

    var_dump($productIds);
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    );
    $product_query = new WP_Query($args);
	$Totalproducts = $product_query -> found_posts;
	$product_cats = get_terms(array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
	));

    function obscureDomain($domain) {
        $parts = explode('.', $domain);
        
        $obscured = [];
        foreach ($parts as $part) {
            if (strlen($part) <= 2) {
                $obscured[] = $part;
            } else {
                $obscured[] = $part[0] . str_repeat('*', strlen($part) - 2) . $part[strlen($part) - 1];
            }
        }
        
        return implode('.', $obscured);
    }

	$extensions = get_terms(array(
		'taxonomy' => 'extension',
		'hide_empty' => false,
	));

	$backlinkos = get_terms(array(
		'taxonomy' => 'authory_backlink',
		'hide_empty' => false,
	));

	$languages = get_terms(array(
		'taxonomy' => 'language',
		'hide_empty' => false,
	));

	$usecases = ["Affiliate","Adsense","PBN","301 redirection"];

    if ($product_query->have_posts()) {
        while ($product_query->have_posts()) {
            
            $product_query->the_post(); // Set up the post data
            $product_id = get_the_ID(); // Use get_the_ID() to get post ID
            $product_title = get_the_title();
            $product_slug = $product->get_slug();
            $price = $product -> get_price();
            $product_description = $product->get_description();
            $da = get_post_meta($product_id, 'da', true);
            $dr = get_post_meta($product_id, 'dr', true);
            $pa = get_post_meta($product_id, 'pa', true);
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
            };

            // Domain Type
            $domain_type = get_field('domain_type', $product_id);

            // Authority Backlinks
            $authority_backlinks = wp_get_post_terms($product_id, 'authory_backlink');
            $ab_names = array();
            foreach ($authority_backlinks as $backlink) {
                $ab_names[] = $backlink->name;
            };

            // Language
            $languages  = wp_get_post_terms($product_id, 'language');
            //var_dump($languages);
            $langs = array();
            foreach ($languages as $lang) {
                $langs[] = $lang->name;
            };

            // Use Cases
            $use_cases = get_post_meta($product_id, 'usecase', false);
            if(empty($use_cases)) {
                $uses = [];
            } else {
                $uses = $use_cases[0];
            }

            ?>
                <div class="product-box visible" data-domain-name="<?= $product_title ?>" data-domain-extension='<?= esc_attr(json_encode($extension_names)); ?>' data-domain-type="<?= $domain_type ?>" data-auth-backlinks='<?= json_encode($ab_names) ?>' data-languages='<?= json_encode($langs) ?>' data-use-cases='<?= json_encode($uses) ?>'> 
                    <div class="product-details">
                        <div class="product-head">
                            <div class="product-img">
                                <?php if ($product_image_url) { ?>
                                    <img src="<?= $product_image_url ?>" alt="product image">
                                <?php } else { ?>
                                    <img src="<?= get_site_url() . '/wp-content/uploads/woocommerce-placeholder.png' ?>" alt="product image">
                                <?php } ?>
                            </div>
                            <div class="product-title"> 
                                <label> 
                                    <input class="script-ignore" type="checkbox" value="" id="title"> 
                                    <span class="obscured-domain-name"> <?= obscureDomain($product_title) ?> </span> 
                                <label> 
                                <br>
                                <div class="description hidden">
                                    <a href="javascript:void(0)"> <img src="/wp-content/uploads/2023/08/heart-love.jpg"> </a>
                                    <span><?= $product_description?></span>
                                </div>
                                <div class="domain-name-revealer">
                                    <i class="flaticon-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="product-body">
                            <div class="catgories"> 
                                <?php foreach($product_categories as $catagory) { ?>
                                    <span><?= $catagory?></span>
                                <?php }?>
                                    <a class="hidden" href="<?= the_permalink($catagory_id -> ID);?>"> View Links </a> 
                            </div>
                            <ul>
                                <li> <span class="da"><?= $da ?></span> DA </li>
                                <li> <span class="pa"><?= $pa ?></span> PA </li>
                                <li class="hidden"> <span class="dr"><?= $dr ?></span> DR </li>
                                <li> <span class="live-rd"><?= $live_rd ?></span> Live RD </li>
                                <li> <span class="hist-rd"><?= $hist_rd ?></span> Hist RD </li>
                                <li class="hidden"> <span class="age"><?= $age ?></span> Age </li>
                                <li class="hidden"> <span class="language"><?= $langs[0] ?></span> Language</li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-card">
                        <h2>$<?= $price ?> </h2>
                        <ul>
                            <li>
                                <a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Add to cart</a>
                            </li>
                            <li> <a href="<?= get_site_url() . '/product/' . $product_slug ?>"> More Data </a> </li>
                        </ul>
                    </div>
                </div>
            <?php
        }

        // Pagination
        $pagination_args = array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '',
            'total' => $product_query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => __('&laquo; Previous'),
            'next_text' => __('Next &raquo;'),
        );

        ?>
            <div class="pagination-section" id="">
                <p class="hidden">Showing <?= $Totalproducts; ?> domains filtered out of <?= $Totalproducts; ?> domains</p>
                <div class="pagination">
                    <?= paginate_links($pagination_args); ?>
                </div>
            </div>
        <?php
    } else {
        echo 'No products found.';
    }

    $products_html = ob_get_clean(); // Get the buffered content and clear buffer
    return $products_html;
}




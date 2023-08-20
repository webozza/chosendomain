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
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.2.51' );

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
        $products_html = render_product_loop($filteredProductIds, $filterData);
        wp_send_json_success(array('data' => $products_html));
    } else {
        wp_send_json_error('Filter data not provided.');
    }
    wp_die();
}

function get_filtered_product_ids($filterData) {
    return array();
}

function render_product_loop($productIds, $filterData) {
    ob_start();
    $minPrice = $filterData['minPrice'];
    $maxPrice = $filterData['maxPrice'];
    $maxDa = $filterData['maxDa'];
    $minDa = $filterData['minDa'];
    $maxPa = $filterData['maxPa'];
    $minPa = $filterData['minPa'];
    $maxLiveRd = $filterData['maxLiveRd'];
    $minLiveRd = $filterData['minLiveRd'];

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
        'meta_query' => array(
            'relation' => 'AND', // Combine the meta queries using the AND operator
            array(
                'key' => '_price', // Use '_price' for WooCommerce product price
                'type' => 'NUMERIC',
                'compare' => '>=', // Greater than or equal to
                'value' => $minPrice,
            ),
            array(
                'key' => '_price', // Use '_price' for WooCommerce product price
                'type' => 'NUMERIC',
                'compare' => '<=', // Less than or equal to
                'value' => $maxPrice,
            ),
            array(
                'key' => 'da', // Replace 'da' with the actual ACF field key
                'type' => 'NUMERIC',
                'compare' => '>=', // Greater than or equal to
                'value' => $minDa,
            ),
            array(
                'key' => 'da', // Replace 'da' with the actual ACF field key
                'type' => 'NUMERIC',
                'compare' => '<=', // Less than or equal to
                'value' => $maxDa,
            ),
            array(
                'key' => 'pa', // Replace 'pa' with the actual ACF field key for Page Authority
                'type' => 'NUMERIC',
                'compare' => '>=', // Greater than or equal to
                'value' => $minPa,
            ),
            array(
                'key' => 'pa', // Replace 'pa' with the actual ACF field key for Page Authority
                'type' => 'NUMERIC',
                'compare' => '<=', // Less than or equal to
                'value' => $maxPa,
            ),
            array(
                'key' => 'live_rd', // Replace 'live_rd' with the actual ACF field key for live_rd
                'type' => 'NUMERIC',
                'compare' => '>=', // Greater than or equal to
                'value' => $minLiveRd,
            ),
            array(
                'key' => 'live_rd', // Replace 'live_rd' with the actual ACF field key for live_rd
                'type' => 'NUMERIC',
                'compare' => '<=', // Less than or equal to
                'value' => $maxLiveRd,
            ),
        ),
    );
    
    // Check if the categoryFilter is defined before adding the tax query
    if (isset($filterData['categoryFilter'])) {
        $categoryFilter = $filterData['categoryFilter'];
    
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $categoryFilter,
                'operator' => 'IN',
            ),
        );
    }

    // Check if the extensionFilter is defined before adding the tax query
    if (isset($filterData['extensionFilter'])) {
        $extensionFilter = $filterData['extensionFilter'];
        $args['tax_query'][] = array(
            'taxonomy' => 'extension',
            'field' => 'slug',
            'terms' => $extensionFilter,
            'operator' => 'IN',
        );
    }   
    
    // Check if the authority Backlinks Filter is defined before adding the tax query
    if (isset($filterData['authorityBacklinksFilter'])) {
        $authorityBacklinksFilter = $filterData['authorityBacklinksFilter'];
        $args['tax_query'][] = array(
            'taxonomy' => 'authory_backlink',
            'field' => 'slug',
            'terms' => $authorityBacklinksFilter,
            'operator' => 'IN',
        );
    }

    // Check if domainType is defined
    if (isset($filterData['domainTypeFilter']) && !empty($filterData['domainTypeFilter'])) {
        $domainType = $filterData['domainTypeFilter'];

        $args['meta_query'][] = array(
            'key' => 'domain_type',
            'value' => $domainType,
            'compare' => '=',
        );
    }
    
    $product_query = new WP_Query($args);
	$totalProducts = $product_query -> found_posts;
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
            
            $product_query->the_post();
            $product_id = get_the_ID();
            $product_title = get_the_title();
            $product_slug = get_post_field('post_name', $product_id);
            $price = get_post_meta($product_id, '_price', true);
            $product_description = get_the_content();
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

            $price_filter = $price >= $minPrice && $price <= $maxPrice;
            $da_filter = $da <= $maxDa && $da >= $minDa;
            $pa_filter = $pa <= $maxPa && $pa >= $minPa;
            $live_rd_filter = $live_rd <= $maxLiveRd && $live_rd >= $minLiveRd;

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
                                    <span></span>
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
                        <h2>$<?= $price ?></h2>
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
            'base' => esc_url(add_query_arg(array('paged' => '%#%', 'filterData' => http_build_query($filterData)), 'https://chosendomain.com/domains')),
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
        
        $pagination_links = paginate_links($pagination_args);                        

        ?>
            <div class="pagination-section" id="">
                <p class="hidden">Showing <?= $totalProducts; ?> domains filtered out of <?= $totalProducts; ?> domains</p>
                <div id="pagination-container" class="pagination">
                    <?php
                    if ($pagination_links) {
                        echo $pagination_links;
                    }
                    ?>
                </div>
            </div>
            <script>
                // Attach a click event handler to the pagination links
                jQuery(document).on('click', '.pagination-link', function(e) {
                    e.preventDefault();
                    const targetPage = parseInt(jQuery(this).data('page'), 10);
                    if (targetPage !== currentPage) {
                        loadPage(targetPage);
                    }
                });
            </script>
        <?php
    } else {
       ?>
            <div class="no-products-found">
                <h5>No products found for your selected filters.</h5>
            </div>
       <?php
    }

    $products_html = ob_get_clean();
    return $products_html;
}




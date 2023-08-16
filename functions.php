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
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.1.40' );

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
//add_action('wp_ajax_load_more_posts', 'load_more_posts');
//add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts() {
    $page = $_POST['page'];
	$posts_per_page = 10; // Number of products per page
	$total_fetched_posts = $posts_per_page * $page;
	$offset = $total_fetched_posts + $posts_per_page;
	
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        //'offset' => $offset, // Set the offset
    );
    $product_query = new WC_Product_Query($args);
    $products = $product_query->get_products();

	$product_cats = get_terms(array(
		'taxonomy' => 'product_cat', // WooCommerce product category taxonomy
		'hide_empty' => false,       // Set to true if you want to hide empty categories
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

    ob_start();

	foreach ($products as $product) {
		$product_id = $product->get_id();
		$product_id = $product->get_id();
		$product_title = $product->get_name();
		$product_slug = $product->get_slug();
		$price = $product -> get_price();
		$product_description = $product->get_description();
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

		if($_POST['base_url'] == "/domains/") {
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
								<li> <span class="da"><?= $da ?></span> <br> DA </li>
								<li class="hidden"> <span class="dr"><?= $dr ?></span> <br> DR </li>
								<li> <span class="live-rd"><?= $live_rd ?></span> <br> Live <br> RD </li>
								<li> <span class="hist-rd"><?= $hist_rd ?></span><br> Hist <br> RD </li>
								<li class="hidden"> <span class="age"><?= $age ?></span> <br> Age </li>
								<li> <span class="language"><?= $langs[0] ?></span> <br> Language</li>
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
		} else { ?>
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
									<span class="obscured-domain-name"> <?= $product_title ?> </span> 
								</label> 
								<br>
								<div class="description hidden">
									<a href="javascript:void(0)"> <img src="/wp-content/uploads/2023/08/heart-love.jpg"> </a>
								</div>
								<!--<div class="domain-name-revealer">
									<i class="flaticon-eye"></i>
								</div>-->
							</div>
							<h6>$<?= $price ?></h6>
							<div class="product-card">
								<ul>
									<li>
										<a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Add to cart</a>
									</li>
									<li> <a href="<?= get_site_url() . '/product/' . $product_slug ?>"> More Data </a> </li>
								</ul>
							</div>
						</div>
						<div class="product-body" style="display:none;">
							<div class="catgories"> 
								<?php foreach($product_categories as $catagory) { ?>
									<span><?= $catagory?></span>
								<?php }?>
									<a class="hidden" href="<?= the_permalink($catagory_id -> ID);?>"> View Links </a> 
							</div>
						</div>
					</div>
				</div>
		<?php }
	}
	
	$response = ob_get_clean();
	echo $response;
	wp_die();
}
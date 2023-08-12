<?php
    /* Template Name: Custom Single product page */
?>

<?php get_header() ?>

<?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 1,
        // 'id' => get_the_ID(),
    );

    $product_id = get_the_ID(); // Get the current product ID

    $product = wc_get_product($product_id);

    if ($product) {
    // Display product title
    echo '<h1>' . $product->get_name() . '</h1>';

    // Display product price
    echo '<p>' . $product->get_price_html() . '</p>';

    // Display product description
    echo '<div>' . $product->get_description() . '</div>';

    // Display product image
    echo '<div>' . $product->get_image() . '</div>';

    // Display other product attributes as needed
    echo '<div>' . $product->get_post_meta() . '</div>';
}




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
?>

<!-- Product Details Info -->
<div class="domain-inventory-content product-details-page" id="product-container">
    <?php
        if ($products) {
            foreach ($products as $product) {
                
                $product_id = $product->get_id();
                $product_title = $product->get_name();
                $product_slug = $product->get_slug();
                $price = $product -> get_price();
                //$product_description = $product->get_description();
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
        ?>
    <div class="product-box visible" data-domain-name="<?= $product_title ?>" data-domain-extension='<?= esc_attr(json_encode($extension_names)); ?>' data-domain-type="<?= $domain_type ?>" data-auth-backlinks='<?= json_encode($ab_names) ?>' data-languages='<?= json_encode($langs) ?>' data-use-cases='<?= json_encode($uses) ?>'> 
        <div class="product-details">

            <div class="product-head">
                <!-- <div class="product-img">
                    <?php if ($product_image_url) { ?>
                        <img src="<?= $product_image_url ?>" alt="product image">
                    <?php } else { ?>
                        <img src="<?= get_site_url() . '/wp-content/uploads/woocommerce-placeholder.png' ?>" alt="product image">
                    <?php } ?>
                </div> -->
                <div class="product-title"> 
                    <div>
                        <h2 class="obscured-domain-name"> <?= obscureDomain($product_title) ?> 
                        <span class="domain-name-revealer">
                            <i class="flaticon-eye"></i>
                        </span></h2>
                    </div>
                </div>
                <div class="priceSection">
                    <h4>$<?= $price ?> </h4>
                </div>
                <div class="catsection">
                    <div class="catgories"> 
                        <ul>
                            <li>
                                <p>Category
                        <?php foreach($product_categories as $catagory) { ?>
                            <span><?= $catagory?></span>
                        <?php }?>
                                </p>
                            </li>
                            <li>
                                <a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Buy Now</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="product-body">
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
            <ul>
                <li>
                    <!-- <a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Buy Now</a> -->
                </li>
                <!-- <li> <a href="<?= get_site_url() . '/product/' . $product_slug ?>">More Data </a> </li> -->
            </ul>
        </div>
    </div>
    <?php
            }
        } else {
            echo 'No products found.';
        }
        ?>

    <div class="no-results-found" style="display:none;">
        No results found to the selected filters. Please change/remove filters to show domains.
    </div>
</div>




<?php get_footer() ?>
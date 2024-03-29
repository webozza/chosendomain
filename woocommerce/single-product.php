<?php
    /* Template Name: Custom Single product page */
?>

<?php get_header() ?>

<!-- Product Details Info -->
<div class="domain-inventory-content product-details-page" id="product-container">
    <?php
	
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
                
        $product_id = get_the_ID();
        $product_title = get_the_title($product_id);
        $product_slug = get_post_field('post_name', $product_id);
        $product = wc_get_product($product_id);
        $product_price = $product->get_price();
        $product_description = $product->get_description();
        $da = get_post_meta($product_id, 'da', true);
		$pa = get_post_meta($product_id, 'pa', true);
        $dr = get_post_meta($product_id, 'dr', true);
        $tf = get_post_meta($product_id, 'tf', true);
        $google_index = get_post_meta($product_id, 'google_index', true);
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

        // Use Cases
        $use_cases = get_post_meta($product_id, 'usecase', false);
        if(empty($use_cases)) {
            $uses = [];
        } else {
            $uses = $use_cases[0];
        }
    ?>

    <?php if($domain_type != "Aged Domain") { ?>
        <div class="product-box visible" data-domain-name="<?= $product_title ?>" data-domain-extension='<?= esc_attr(json_encode($extension_names)); ?>' data-domain-type="<?= $domain_type ?>" data-auth-backlinks='<?= json_encode($ab_names) ?>' data-use-cases='<?= json_encode($uses) ?>'> 
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
                        <span class="obscured-domain-name"> <?= $domain_type !== "Premium Domain 2" && !is_user_logged_in() ? obscureDomain($product_title) : $product_title ?> </span>
                        <div class="domain-name-revealer"><i class="flaticon-eye"></i></div>
                    </div>
                    
                    <div class="catsection">
                        <div class="catgories">
                        <b> Category: </b>
                            <?php foreach($product_categories as $catagory) { ?>
                            <span><?= $catagory?></span>
                            <?php }?>
                                    <a class="hidden" href="<?= the_permalink($catagory_id -> ID);?>"> View Links </a> 
                        </div>
                        <div>
                            <div class="priceSection">
                                <h4>$<?= $product_price ?> </h4>
                            </div>
                            <a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Buy Now</a>
                        </div>
                    </div>
                </div>

                <?php if($domain_type != "Premium Domain 2") { ?>
                    <div class="product-body">
                        <ul>
                            <li> <span class="da"><?= $da ?></span> DA </li>
                            <li> <span class="pa"><?= $pa ?></span> PA </li>
                            <li class="hidden"> <span class="dr"><?= $dr ?></span> DR </li>
                            <li> <span class="live-rd"><?= $live_rd ?></span> RD </li>
                            <li> <span class="hist-rd"><?= $hist_rd ?></span> BL </li>
                            <li class="hidden"> <span class="age"><?= $age ?></span> Age </li>
                        </ul>
                    </div>
                <?php } ?>
                <div class="product-description">
                    <h4><span>Domain Details:</span></h4>
                    <p><?= $product_description ?></p>
                </div>
            </div>
            <!-- <div class="product-card">
                <ul>
                    <li>
                        <a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Buy Now</a>
                    </li>
                    <li> <a href="<?= get_site_url() . '/product/' . $product_slug ?>">More Data </a> </li>
                </ul>
            </div> -->
        </div>
    <?php } else { ?>
        <div class="auction-item-5 live aos-init aos-animate" data-aos="zoom-out-up" data-aos-duration="1200" data-domain-name="<?= $product_title ?>">
            <div class="auction-inner">
                <div>
                    <div class="upcoming-badge" title="Upcoming Auction">
                        <img src="/wp-content/uploads/2024/03/new-domain.png">
                    </div>
                    <div class="catgories"> 
                        <h5>Niche</h5>
                        <?php foreach($product_categories as $catagory) { ?>
                            <span><?= $catagory?></span>
                        <?php }?>
                            <a class="hidden" href="<?= the_permalink($catagory_id -> ID);?>"> View Links </a> 
                    </div>
                </div>
                <div class="auction-thumb">
                    <a href="<?= get_site_url() . '/product/' . $product_slug ?>"><img src="./assets/images/auction/upcoming/upcoming-2.png" alt="upcoming"></a>
                    <a href="#0" class="rating"><i class="far fa-star"></i></a>
                </div>
                <div class="auction-content">
                    <div class="title-area">
                        <div>
                            <h6 class="title">
                                <a class="obscured-domain-name" href="<?= get_site_url() . '/product/' . $product_slug ?>"><?= $product_title ?></a>
                            </h6>
                            <div class="domain-name-revealer">
                                <i class="flaticon-eye"></i>
                            </div>
                        </div>
                        <div class="product-body">
                            <div class="bid-area">
                                <ul>
                                    <li> DA <span class="da"><?= $da ?></span></li>
                                    <li> PA <span class="pa"><?= $pa ?></span></li>
                                    <li> DR <span class="dr"><?= $dr ?></span></li>
                                    <li> TF <span class="tf"><?= $tf ?></span></li>
                                    <li> RD <span class="rd"><?= $live_rd ?></span></li>
                                    <li> Age <span class="age"><?= $age ?></span></li>
                                    <li> Google Index <span class="google-index"><?= $google_index ?></span></li>
                                </ul>
                            </div>
                            <div class="product-short-desc"><p><?php echo $product->post->post_excerpt; ?></p></div>
                        </div>
                    </div>
                </div>
                <div class="auction-bidding product-card">
                    <div class="bid-incr">
                        <h4>$<?= $product_price ?></h4>
                    </div>
                    <ul>
                        <li>
                            <a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Buy Now</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="no-results-found" style="display:none;">
        No results found to the selected filters. Please change/remove filters to show domains.
    </div>
<?php
global $product;

if( ! is_a( $product, 'WC_Product' ) ){
    $product = wc_get_product(get_the_id());
}

woocommerce_related_products( array(
    'posts_per_page' => 4,
    'columns'        => 4,
    'orderby'        => 'rand',
	'da' => $da,
) );
?>
</div>


<script>
	jQuery(document).ready(function($) {
		$(".domain-name-revealer").click(function () {
			let isLoggedIn = $("body").hasClass("logged-in");

			let unobscuredDomainName = $(this)
			  .closest(".product-box")
			  .data("domain-name");

			if (isLoggedIn) {
			  $(this)
				.closest(".product-box")
				.find(".obscured-domain-name")
				.text(unobscuredDomainName);
			} else {
			  $(".ast-account-action-login").click();
			}
		});
	})
</script>




<?php get_footer() ?>


<style>
.product-details-page{margin-top:50px;}
.product-details-page .product-box{
	border: 1px solid #b9b9b94d;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0px 4px 6px #d1d1d14d;
	margin-bottom: 50px;
}
.product-details-page .product-box:hover{
    box-shadow: 0px 0px 15px #7171714d;
}
.product-details-page .product-title{
	text-align: center;
}
.product-details-page .product-title .domain-name-revealer {
    position: relative;
    right: 0px;
    top: 0px;
}
.product-details-page .product-title .obscured-domain-name {
    font-size: 2.625rem;
    font-weight: 400;
    color: #08104d;
}
.product-details-page .product-description h4{text-decoration:underline;}
.product-details-page .product-description p{
	color: #000;
    font-size: 16px;
    margin-top: 10px;
}
.product-details-page .catsection{
	display: flex;
    flex-direction: row;
    justify-content: space-between;
	margin-bottom: 30px;
}
.product-details-page .catsection a {
    font-size: 15px;
    font-weight: 400;
    padding-top: 12px;
    padding-right: 25px;
    padding-bottom: 12px;
    padding-left: 25px;
    border-radius: 40px;
}
.product-details-page .priceSection h4{
	text-align: right;
	margin-bottom: 10px;
}
.product-details-page .catsection .catgories b{
	margin-top: 10px;
    margin-right: 25px;
	color: #08104d;
}
.product-details-page .catsection .catgories span {
    display: inline-block;
    background: #beebe7;
    border-radius: 35px;
    padding: 3px 25px;
    font-size: 14px;
    line-height: 33px;
    color: #155c5e;
    margin-right: 25px;
}
.product-details-page .catsection ul{list-style:none;text-align: right;}
.product-details-page .product-details .product-body ul{
    list-style: none;
    display: flex;
	margin-left: 0px;
}
.product-details-page .product-details .product-body ul li {
    text-align: center;
    border-right: 1px solid rgba(0, 0, 0, 0.1);
    padding-left: 30px;
    padding-right: 30px;
    display: flex;
    align-items: center;
    flex-direction: column;
	color: #000;
    font-size: 15px;
}
.product-details-page .product-details .product-body ul li span {
    font-weight: 600;
    font-size: 18px;
    color: #08104d;
}
	
	/*related product*/
	.woocommerce ul.products li.product.desktop-align-left .button{
		padding: 10px 20px;
    	font-weight: 400;
    	font-size: 15px;
   		border-radius: 30px;
	}
</style>
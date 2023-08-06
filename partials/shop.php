<?php
    /* Template Name: Custom Shop */
?>

<?php get_header() ?>

<?php
    $args = array(
        'post_type' => 'product',
        'post_per_page' => -1
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
?>

<div class="domain-section">
    <div class="domain-inventory-wrap">

        <!-- Domain Inventory Search Box -->
        <div class="domain-inventory-search-box">
            <h2>Choose your Domain Type</h2>
            <div class="domain-inventory-domain-type switch-domain-type">
                <input type="radio" id="domain-type-budget" name="domain-type[]" value="Budget">
                <label for="domain-type-budget" class="show-tooltip">Budget Domains</label>
                <input type="radio" id="domain-type-premium" name="domain-type[]" value="Premium">
                <label for="domain-type-premium" class="show-tooltip">Premium Domains</label>
                <input type="radio" id="domain-type-30" name="domain-type[]" value="30">
                <label for="domain-type-30" class="show-tooltip">$30 Domains</label>
            </div>
            <div class="domain-inventory-search-field">
                <input type="text" name="domain-search" id="domain-search"
                    placeholder="Search Domain Name" value="">
                <button class="fire-domain-keyword-search">SEARCH</button>
            </div>
        </div>

        <!-- Domain Search Controls -->
        <div class="domain-search-controls">
            <button class="di-hide-filters dc-btn dc-btn-primary-muted dc-btn-big"><span class="hide-on-mobile">Hide
                    filters</span> <i class="far fa-eye-slash"></i></button>
        </div>

        <!-- Domain Loop with Filters -->
        <div class="domain-inventory-search-wrap">
            <!-- FILTERS -->
            <div class="domain-inventory-sidebar">
                <div class="domain-inventory-search-filters">
                    <h2>Filters</h2>
					<div class="slide-accor">
						<div class="filter-title">
                            <h3>Saved Filters </h3>
                        </div>
						<div class="answer">
							<p> No saved filters </p>
						</div>
					</div>
                    <div class="reset-filters">
                        <span>No filters applied</span>
                        <button class="dc-btn dc-btn-primary-outline di-reset-selected-filters" disabled="disabled">Reset all</button>
                    </div>

                    <!-- Category Filter -->
                    <div class="category-filter slide-accor">
                        <div class="filter-title">
                            <h3>Category </h3>
                        </div>
						<div class="answer">
							<div class="search-input-wrapper">
								<input type="text" id="category_search" placeholder="Search Categories">
								<span class="search-icon"></span>
							</div>
						
                        <div class="category-checkboxes" id="category_checkboxes">
							<?php if(!empty($product_cats)) { 
								foreach ($product_cats as $category) {?>
								<a href="<?= get_term_link($category);?>"> 
								<label>
									<input name="category_filter[]" type="checkbox" value="<?= $category->name ?>">	
                                    <span><?= esc_html($category->name) ?></span> <br>
								</label>
								</a>
								<?php
								}
							 } ?>
                        </div>
						</div>
                    </div>

                    <!-- Price Range Filter -->
					<div class="slide-accor"> 
                        <div class="filter-title">
						    <h3>Price</h3>
                        </div>
						<div class="answer">
							<div class="sf-field-post-meta-_sale_price open" data-sf-field-name="_sfm__sale_price"
									data-sf-field-type="post_meta" data-sf-field-input-type="range-slider"
									data-sf-meta-type="number">

									<div data-start-min="0" data-start-max="10000" data-start-min-formatted="0"
										data-start-max-formatted="10000" data-min="0" data-max="10000" data-step="1"
										data-decimal-places="0" data-thousand-seperator="" data-decimal-seperator="."
										data-display-values-as="textinput" data-sf-field-name="_sfm__sale_price"
										class="sf-meta-range sf-meta-range-slider">
										<div class="price-range-inputs">
											<label>
												<input class="sf-input-range-number sf-range-min sf-input-number" min="0"
													max="10000" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
											</label>
											<span class="sf-range-values-separator"></span>
											<label>
												<input class="sf-input-range-number sf-range-max sf-input-number" min="0"
													max="10000" step="1" name="_sfm__sale_price[]" type="number" value="10000"
													title="">
											</label>
										</div>
										<div class="meta-slider noUi-target noUi-ltr noUi-horizontal">
											<div class="noUi-base">
												<div class="noUi-connects">
													<div class="noUi-connect"></div>
												</div>
												<div class="noUi-origin">
													<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0"
														role="slider" aria-orientation="horizontal" aria-valuemin="0.0"
														aria-valuemax="100.0" aria-valuenow="0.0" aria-valuetext="0"></div>
												</div>
												<div class="noUi-origin">
													<div class="noUi-handle noUi-handle-upper" data-handle="1" tabindex="0"
														role="slider" aria-orientation="horizontal" aria-valuemin="0.0"
														aria-valuemax="100.0" aria-valuenow="100.0" aria-valuetext="10000"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>
                    
                    <!-- Price Range Filter -->
					<div class="slide-accor"> 
						<div class="filter-title">
                            <h3>DA</h3>
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
						<div class="answer">

							<div class="sf-field-post-meta-_sale_price open" data-sf-field-name="_sfm__sale_price"
									data-sf-field-type="post_meta" data-sf-field-input-type="range-slider"
									data-sf-meta-type="number">

									<div data-start-min="0" data-start-max="10000" data-start-min-formatted="0"
										data-start-max-formatted="10000" data-min="0" data-max="10000" data-step="1"
										data-decimal-places="0" data-thousand-seperator="" data-decimal-seperator="."
										data-display-values-as="textinput" data-sf-field-name="_sfm__sale_price"
										class="sf-meta-range sf-meta-range-slider">
										<div class="price-range-inputs">
											<label>
												<input class="sf-input-range-number sf-range-min sf-input-number" min="0"
													max="10000" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
											</label>
											<span class="sf-range-values-separator"></span>
											<label>
												<input class="sf-input-range-number sf-range-max sf-input-number" min="0"
													max="10000" step="1" name="_sfm__sale_price[]" type="number" value="10000"
													title="">
											</label>
										</div>
										<div class="meta-slider noUi-target noUi-ltr noUi-horizontal">
											<div class="noUi-base">
												<div class="noUi-connects">
													<div class="noUi-connect"></div>
												</div>
												<div class="noUi-origin">
													<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0"
														role="slider" aria-orientation="horizontal" aria-valuemin="0.0"
														aria-valuemax="100.0" aria-valuenow="0.0" aria-valuetext="0"></div>
												</div>
												<div class="noUi-origin">
													<div class="noUi-handle noUi-handle-upper" data-handle="1" tabindex="0"
														role="slider" aria-orientation="horizontal" aria-valuemin="0.0"
														aria-valuemax="100.0" aria-valuenow="100.0" aria-valuetext="10000"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>
                </div>
            </div>
            <!-- DOMAINS -->
            <div class="domain-inventory-content">
                <?php
					if ($products) {
						foreach ($products as $product) {
							
							$product_id = $product->get_id();
							$product_id = $product->get_id();
							$product_title = $product->get_name();
							$price = $product -> get_price();

							$product_description = $product->get_description();
							$da        = get_post_meta($product_id, 'da', true);
							$dr        = get_post_meta($product_id, 'dr', true);
							$live_rd   = get_post_meta($product_id, 'live_rd', true);
							$hist_rd   = get_post_meta($product_id, 'hist_rd', true);
							$age       = get_post_meta($product_id, 'age', true);
							$language  = get_post_meta($product_id, 'language', true);
							$product_image_url = get_the_post_thumbnail_url($product_id, 'full');
							$product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names'));
					?>
				<div class="product-box visible" data-domain-name="<?= $product_title ?>"> 
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
                                    <input type="checkbox" value="" id="title"> 
                                    <span class="obscured-domain-name"> <?= obscureDomain($product_title) ?> </span> 
                                <label> 
                                <br>
                                <div class="description">
                                    <a href="#"> <img src="/wp-content/uploads/2023/08/heart-love.jpg"> </a>
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
									 <a href="<?= the_permalink($catagory_id -> ID);?>"> View Links </a> 
							</div>
							<ul>
								<li> <span> <?= $da ?> </span> <br> DA </li>
								<li> <span> <?= $dr ?> </span> <br> DR </li>
								<li> <span> <?= $live_rd ?> </span> <br> Live <br> RD </li>
								<li> <span> <?= $hist_rd ?></span><br> Hist <br> RD </li>
								<li> <span> <?= $age ?> </span> <br> Age </li>
								<li> <span> <?= $language ?> </span> <br> Language</li>
							</ul>
						</div>
					</div>
					<div class="product-card">
						<h2>$<?= $price ?> </h2>
						<ul>
							<li>
								<a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Add to cart</a>
							</li>
							<li> <a href="<?= the_permalink($post -> ID);?>"> More Data </a> </li>
							<li> <a href=""> Add to <br>  Compare </a> </li>
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
        </div>

        <?php get_footer() ?>
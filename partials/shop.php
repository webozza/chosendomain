<?php
    /* Template Name: Custom Shop */
?>

<?php get_header() ?>

<?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 9,
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
            <div style="display:none;" class="domain-inventory-search-field">
                <input type="text" name="domain-search" id="domain-search"
                    placeholder="Search Domain Name" value="">
                <button class="fire-domain-keyword-search">SEARCH</button>
            </div>
        </div>

        <!-- Domain Search Controls -->
        <div class="domain-search-controls">
            <button class="di-hide-filters dc-btn dc-btn-primary-muted dc-btn-big">
				<span class="hide-on-mobile">Hide filters</span> 
				<i class="far fa-eye-slash"></i>
			</button>
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
                        <span data-cfa="0">No filters applied</span>
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
						
                        <div class="category-checkboxes cd-checkboxes" id="category_checkboxes">
							<?php if(!empty($product_cats)) { 
								foreach ($product_cats as $category) {?>
								<a href="javascript:void(0)"> 
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
												<input class="sf-input-range-number sf-range-min price-range-min sf-input-number" min="0"
													max="10000" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
											</label>
											<span class="sf-range-values-separator"></span>
											<label>
												<input class="sf-input-range-number sf-range-max price-range-max sf-input-number" min="0"
													max="10000" step="1" name="_sfm__sale_price[]" type="number" value="10000"
													title="">
											</label>
										</div>
										<div class="meta-slider noUi-target noUi-ltr noUi-horizontal price-slider">
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
                    
                    <!-- DA Range Filter -->
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
												<input class="sf-input-range-number sf-range-min da-range-min sf-input-number" min="0"
													max="100" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
											</label>
											<span class="sf-range-values-separator"></span>
											<label>
												<input class="sf-input-range-number sf-range-max da-range-max sf-input-number" min="0"
													max="100" step="1" name="_sfm__sale_price[]" type="number" value="100"
													title="">
											</label>
										</div>
										<div class="meta-slider noUi-target noUi-ltr noUi-horizontal da-slider">
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

                    <!-- DR Range Filter -->
					<div style="display:none;" class="slide-accor"> 
						<div class="filter-title">
                            <h3>DR</h3>
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
												<input class="sf-input-range-number sf-range-min dr-range-min sf-input-number" min="0"
													max="100" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
											</label>
											<span class="sf-range-values-separator"></span>
											<label>
												<input class="sf-input-range-number sf-range-max dr-range-max sf-input-number" min="0"
													max="100" step="1" name="_sfm__sale_price[]" type="number" value="100"
													title="">
											</label>
										</div>
										<div class="meta-slider noUi-target noUi-ltr noUi-horizontal dr-slider">
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

                    <!-- Live RD Range Filter -->
					<div class="slide-accor"> 
						<div class="filter-title">
                            <h3>Live RD</h3>
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
												<input class="sf-input-range-number sf-range-min live-rd-range-min sf-input-number" min="0"
													max="10000" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
											</label>
											<span class="sf-range-values-separator"></span>
											<label>
												<input class="sf-input-range-number sf-range-max live-rd-range-max sf-input-number" min="0"
													max="10000" step="1" name="_sfm__sale_price[]" type="number" value="10000"
													title="">
											</label>
										</div>
										<div class="meta-slider noUi-target noUi-ltr noUi-horizontal live-rd-slider">
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

                    <!-- Age Range Filter -->
					<div class="slide-accor hidden"> 
						<div class="filter-title">
                            <h3>Age</h3>
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
												<input class="sf-input-range-number sf-range-min age-range-min sf-input-number" min="0"
													max="50" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
											</label>
											<span class="sf-range-values-separator"></span>
											<label>
												<input class="sf-input-range-number sf-range-max age-range-max sf-input-number" min="0"
													max="50" step="1" name="_sfm__sale_price[]" type="number" value="50"
													title="">
											</label>
										</div>
										<div class="meta-slider noUi-target noUi-ltr noUi-horizontal age-slider">
											<div class="noUi-base">
												<div class="noUi-connects">
													<div class="noUi-connect"></div>
												</div>
												<div class="noUi-origin">
													<div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0"
														role="slider" aria-orientation="horizontal" aria-valuemin="0.0"
														aria-valuemax="50.0" aria-valuenow="0.0" aria-valuetext="0"></div>
												</div>
												<div class="noUi-origin">
													<div class="noUi-handle noUi-handle-upper" data-handle="1" tabindex="0"
														role="slider" aria-orientation="horizontal" aria-valuemin="0.0"
														aria-valuemax="50.0" aria-valuenow="50.0" aria-valuetext="50"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>

					<!-- Get Extensions -->
					<?php
						$extensions = get_terms(array(
							'taxonomy' => 'extension',
							'hide_empty' => false,
						));
					?>

					<!-- Extension Filter -->
                    <div class="extension-filter slide-accor">
                        <div class="filter-title">
                            <h3>Extension </h3>
                        </div>
						<div class="answer">
							<div class="search-input-wrapper">
								<input type="text" id="extension_search" placeholder="Search extensions">
								<span class="search-icon"></span>
							</div>
						
                        <div class="extension-checkboxes cd-checkboxes" id="extension_checkboxes">
							<?php if(!empty($extensions)) { 
								foreach ($extensions as $extension) {?>
									<a href="javascript:void(0)"> 
										<label>
											<input name="extension_filter[]" type="checkbox" value="<?= $extension->name ?>">	
											<span><?= $extension->name ?></span> <br>
										</label>
									</a>
								<?php
								}
							 } ?>
                        </div>
						</div>
                    </div>

					<!-- Get Auth Backlinks -->
					<?php
						$backlinkos = get_terms(array(
							'taxonomy' => 'authory_backlink',
							'hide_empty' => false,
						));
					?>

					<!-- Authority Backlinks Filter -->
                    <div class="authority-backlinks-filter slide-accor">
                        <div class="filter-title">
                            <h3>Authority backlinks</h3>
                        </div>
						<div class="answer">
							<div class="search-input-wrapper">
								<input type="text" id="auhtority_backlinks_search" placeholder="Search authority sites. Eg. BBC">
								<span class="search-icon"></span>
							</div>
						
                        <div class="auhtority_backlinks-checkboxes cd-checkboxes" id="auhtority_backlinks_checkboxes">
							<?php if(!empty($backlinkos)) { 
								foreach ($backlinkos as $backlink) {?>
									<a href="javascript:void(0)"> 
										<label>
											<input name="auhtority_backlinks_filter[]" type="checkbox" value="<?= $backlink->name ?>">	
											<span><?= $backlink->name ?></span> <br>
										</label>
									</a>
								<?php
								}
							 } ?>
                        </div>
						</div>
                    </div>

					<!-- Get Languages -->
					<?php
						$languages = get_terms(array(
							'taxonomy' => 'language',
							'hide_empty' => false,
						));
					?>

					<!-- Language Filter -->
                    <div class="authority-backlinks-filter slide-accor">
                        <div class="filter-title">
                            <h3>Languages</h3>
                        </div>
						<div class="answer">
							<div class="search-input-wrapper">
								<input type="text" id="languages_search" placeholder="Search languages">
								<span class="search-icon"></span>
							</div>
						
                        <div class="languages-checkboxes cd-checkboxes" id="languages_checkboxes">
							<?php if(!empty($languages)) { 
								foreach ($languages as $language) {?>
									<a href="javascript:void(0)"> 
										<label>
											<input name="languages_filter[]" type="checkbox" value="<?= $language->name ?>">	
											<span><?= $language->name ?></span> <br>
										</label>
									</a>
								<?php
								}
							 } ?>
                        </div>
						</div>
                    </div>

					<!-- Get Use Cases -->
					<?php
						$usecases = ["Affiliate","Adsense","PBN","301 redirection"];
					?>

					<!-- Use Case Filter -->
                    <div class="use-case-filter slide-accor">
                        <div class="filter-title">
                            <h3>Use case</h3>
                        </div>
						<div class="answer">
							<div class="search-input-wrapper hidden">
								<input type="text" id="use_case_search" placeholder="Search use cases">
								<span class="search-icon"></span>
							</div>
							<div class="use-case-checkboxes cd-checkboxes" id="use_case_checkboxes">
								<?php if(!empty($usecases)) { 
									foreach ($usecases as $use) {?>
										<a href="javascript:void(0)"> 
											<label>
												<input name="use_case_filter[]" type="checkbox" value="<?= $use ?>">	
												<span><?= $use ?></span> <br>
											</label>
										</a>
									<?php
									}
								} ?>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <!-- DOMAINS -->
            <div class="domain-inventory-content" id="product-container">
                <?php
					if ($products) {
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
						}
					} else {
						echo 'No products found.';
					}
					?>

                <div class="no-results-found" style="display:none;">
                    No results found to the selected filters. Please change/remove filters to show domains.
                </div>
            </div>
			<!-- LOAD MORE SECTION -->
			<div class="load-more-container">
				<div id="loading-text" style="display: none;">
					<img src="<?= get_site_url() . '/wp-content/uploads/2023/08/imgpsh_fullsize_anim.gif'?>" alt="">
				</div>
			</div>
			<script>
				const productContainer = document.getElementById('product-container');
				const loadingText = document.getElementById('loading-text');
					let page = 1; // Initial page number
					const productsPerPage = 10;

					function fetchAndAppendProducts() {
						loadingText.style.display = 'block'; // Show the loading images
					jQuery.ajax({
						url: '<?php echo esc_url(admin_url('admin-ajax.php', 'https')); ?>', // WordPress AJAX URL
						type: 'POST',
						data: {
						action: 'load_more_posts', // Custom AJAX action
						page: page,
						products_per_page: productsPerPage,
						},
						success: function(response) {
						productContainer.insertAdjacentHTML('beforeend', response);
						page++; // Increment the page number for the next fetch
						loadingText.style.display = 'none'; // Hide the loading images
						},
						error: function(error) {
						console.error(error);
						loadingText.style.display = 'none'; // Hide the loading text in case of an error
						}
					});
					}

					// Detect when the user has scrolled to the bottom
					window.addEventListener('scroll', () => {
					const { scrollTop, scrollHeight, clientHeight } = document.documentElement;

					if (scrollTop + clientHeight >= scrollHeight - 10) {
						fetchAndAppendProducts();
					}
					});

					// Initial fetch
					fetchAndAppendProducts();

			</script>
        </div>

	</div>
</div>

<?php get_footer() ?>
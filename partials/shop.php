<?php
    /* Template Name: Custom Shop */
?>

<?php get_header() ?>

<?php
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

					<!-- Saved Filters -->
					<div class="slide-accor">
						<div class="filter-title">
                            <h3>Saved Filters </h3>
                        </div>
						<div class="answer">
							<p> No saved filters </p>
						</div>
					</div>

					<!-- Reset Filters -->
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

                    <!-- PA Range Filter -->
					<div style="" class="slide-accor"> 
						<div class="filter-title">
                            <h3>PA</h3>
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

					<!-- Language Filter -->
                    <div style="display:none" class="authority-backlinks-filter slide-accor">
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

					<!-- Use Case Filter -->
                    <div style="display:none" class="use-case-filter slide-accor">
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

            <!-- DOMAIN INVENTORY -->
            <div class="domain-inventory-content" id="product-container">
                <?php
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
					?>
                <div class="no-results-found" style="display:none;">
                    No results found to the selected filters. Please change/remove filters to show domains.
                </div>
            </div>
			
			<script>
				jQuery(document).ready(function ($) {
					// jQuery code to initialize the range slider
					var priceSlider = $(".price-slider")[0];
					var daSlider = $(".da-slider")[0];
					var drSlider = $(".dr-slider")[0];
					var liveRdSlider = $(".live-rd-slider")[0];
					var ageSlider = $(".age-slider")[0];
					var paSlider = $(".pa-slider")[0];

					const curPath = window.location.pathname;

					if (curPath !== "/premium-domain/") {
						let runUiSlider = (id, max) => {
						noUiSlider.create(id, {
							start: [0, max],
							connect: true,
							range: {
							min: 0,
							max: max,
							},
						});
						};

						runUiSlider(ageSlider, 50);
						runUiSlider(liveRdSlider, 10000);
						runUiSlider(drSlider, 100);
						runUiSlider(daSlider, 100);
						runUiSlider(priceSlider, 10000);
					}

					//---------------- accordian slide-----------
					$(".slide-accor .filter-title").on("click", function () {
						// Close all answers
						$(".slide-accor .answer").slideUp();
						$(".slide-accor .filter-title").removeClass("active");

						// Toggle the clicked answer
						let answer = $(this).next();
						if (!answer.is(":visible")) {
						answer.slideDown();
						$(this).addClass("active");
						}
					});

					//---------------- search checkboxes ------------
					function setupSearchFilter(searchInputSelector, itemListSelector) {
						var searchInput = $(searchInputSelector);
						var itemList = $(itemListSelector);
						var items = itemList.find("label");

						searchInput.on("keyup", function () {
						var searchTerm = $(this).val().toLowerCase();

						items.each(function () {
							var itemText = $(this).text().toLowerCase();
							if (itemText.includes(searchTerm)) {
							$(this).css("display", "block");
							} else {
							$(this).css("display", "none");
							}
						});
						});
					}

					setupSearchFilter("#category_search", "#category_checkboxes");
					setupSearchFilter("#extension_search", "#extension_checkboxes");
					setupSearchFilter(
						"#auhtority_backlinks_search",
						"#auhtority_backlinks_checkboxes"
					);
					setupSearchFilter("#languages_search", "#languages_checkboxes");

					//---------------- Hide / Show filters ------------
					$(".di-hide-filters").click(async function () {
						$(".domain-inventory-sidebar").toggleClass("hide-it");
						$(".domain-inventory-content").toggleClass("full-width");
						if ($(".domain-inventory-sidebar").hasClass("hide-it")) {
						$(this).text("Show filters");
						} else {
						$(this).text("Hide filters");
						}
					});

					//---------------- Handle for no results ------------
					let noResults = () => {
						let noVisible = $(".product-box.visible").length === 0;
						if (noVisible) {
						$(".no-results-found").fadeIn();
						} else {
						$(".no-results-found").hide();
						}
					};

					//---------------- Initialize empty arrays ------------
					let selectedCats = [];
					let selectedExtensions = [];
					let selectedBacklinks = [];
					let selectedLanguages = [];
					let selectedUses = [];
					let searchTerm = "";
					let maxPriceFilter = -1;
					let selectedDomainType = "";

					const filtersState = {
						price: {
						filtersApplied: 0,
						hasBeenIncremented: false,
						},
						da: {
						filtersApplied: 0,
						hasBeenIncremented: false,
						},
						pa: {
						filtersApplied: 0,
						hasBeenIncremented: false,
						},
						dr: {
						filtersApplied: 0,
						hasBeenIncremented: false,
						},
						liveRd: {
						filtersApplied: 0,
						hasBeenIncremented: false,
						},
						age: {
						filtersApplied: 0,
						hasBeenIncremented: false,
						},
					};

					const updateCombinedFiltersAppliedUI = () => {
						let combinedFiltersApplied = 0;

						for (const filter in filtersState) {
						const filterState = filtersState[filter];
						combinedFiltersApplied += filterState.filtersApplied; // Summing up filtersApplied values
						}

						// Update UI for the combined filters
						const filterSpan = $(".reset-filters span");
						const filterBtn = $(".reset-filters button");

						if (combinedFiltersApplied !== 0) {
						filterBtn.removeAttr("disabled");
						filterBtn.css("color", "#08104d");
						}

						let newCFA =
						combinedFiltersApplied + Number($(".reset-filters span").data("cfa"));
						filterSpan.text(`${newCFA} filter(s) applied`);

						filterSpan.attr("data-cfa", newCFA);
						$(".reset-filters button").css("color", "#08104d");
					};

					const updateFiltersApplied = (filter, minPrice, maxPrice, maximum) => {
						const filterState = filtersState[filter];

						if (
						!filterState.hasBeenIncremented &&
						(minPrice !== 0 || maxPrice !== maximum)
						) {
						filterState.filtersApplied++;
						filterState.hasBeenIncremented = true;
						updateCombinedFiltersAppliedUI(); // Update the combined filters count in UI
						}
					};

					$('.domain-section input[type="checkbox"]:not(.script-ignore)').change(
						function () {
						let combinedFilters = parseInt($(".reset-filters span").attr("data-cfa"));
						let newCombinedFilters;

						let checkbox = $(this);
						if (checkbox.is(":checked")) {
							newCombinedFilters = combinedFilters + 1;
						} else {
							newCombinedFilters = combinedFilters - 1;
						}

						$(".reset-filters span").text(`${newCombinedFilters} filter(s) applied`);
						$(".reset-filters span").attr("data-cfa", newCombinedFilters);

						const filterBtn = $(".reset-filters button");

						if (newCombinedFilters !== 0) {
							filterBtn.removeAttr("disabled");
							filterBtn.css("color", "#08104d");
						}
						}
					);

					$(".reset-filters button").click(function () {
						window.location.reload();
					});

					//---------------- Price Range Filter ------------
					if (curPath !== "/premium-domain/") {
						priceSlider.noUiSlider.on("slide.one", function () {
						let minPrice = $(this)[0].getPositions()[0] * 100;
						let maxPrice = $(this)[0].getPositions()[1] * 100;

						// Set Price
						$(".price-range-min").val(minPrice.toFixed());
						$(".price-range-max").val(maxPrice.toFixed());

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
						updateFiltersApplied("price", minPrice, maxPrice, 10000);
						});
					}

					$(".price-range-min").on("keyup", function () {
						let newMinPrice = parseFloat($(this).val());
						let newMaxPrice = parseFloat($(".price-range-max").val());

						// Update slider positions
						priceSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
						applyFiltersWithAjax(searchTerm);
						updateFiltersApplied("price", newMinPrice, newMaxPrice, 10000);
					});

					$(".price-range-max").on("keyup", function () {
						let newMinPrice = parseFloat($(".price-range-min").val());
						let newMaxPrice = parseFloat($(this).val());
						// Update slider positions
						priceSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
						applyFiltersWithAjax(searchTerm);
						updateFiltersApplied("price", newMinPrice, newMaxPrice, 10000);
					});

					//---------------- DA Range Filter ------------
					if (curPath !== "/premium-domain/") {
						daSlider.noUiSlider.on("slide.one", function () {
						let minPrice = $(this)[0].getPositions()[0];
						let maxPrice = $(this)[0].getPositions()[1];

						// Set Price
						$(".da-range-min").val(minPrice.toFixed());
						$(".da-range-max").val(maxPrice.toFixed());

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
						updateFiltersApplied("da", minPrice, maxPrice, 100);
						});
					}

					$(".da-range-min").on("keyup", function () {
						let newMinPrice = parseFloat($(this).val());
						let newMaxPrice = parseFloat($(".da-range-max").val());

						// Update slider positions
						daSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
						applyFiltersWithAjax(searchTerm);
						updateFiltersApplied("da", newMinPrice, newMaxPrice, 100);
					});

					$(".da-range-max").on("keyup", function () {
						let newMinPrice = parseFloat($(".da-range-min").val());
						let newMaxPrice = parseFloat($(this).val());
						// Update slider positions
						daSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
						applyFiltersWithAjax(searchTerm);
						updateFiltersApplied("da", newMinPrice, newMaxPrice, 100);
					});

					//---------------- PA Range Filter ------------
					if (curPath !== "/premium-domain/") {
						drSlider.noUiSlider.on("slide.one", function () {
						let minPrice = $(this)[0].getPositions()[0];
						let maxPrice = $(this)[0].getPositions()[1];

						// Set Price
						$(".dr-range-min").val(minPrice.toFixed());
						$(".dr-range-max").val(maxPrice.toFixed());

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
						updateFiltersApplied("dr", minPrice, maxPrice, 100);
						});
					}

					$(".dr-range-min").on("keyup", function () {
						let newMinPrice = parseFloat($(this).val());
						let newMaxPrice = parseFloat($(".dr-range-max").val());

						// Update slider positions
						drSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
						applyFiltersWithAjax(searchTerm);
						updateFiltersApplied("dr", newMinPrice, newMaxPrice, 100);
					});

					$(".dr-range-max").on("keyup", function () {
						let newMinPrice = parseFloat($(".dr-range-min").val());
						let newMaxPrice = parseFloat($(this).val());
						// Update slider positions
						drSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
						applyFiltersWithAjax(searchTerm);
						updateFiltersApplied("dr", newMinPrice, newMaxPrice, 100);
					});

					//---------------- Live RD Range Filter ------------
					if (curPath !== "/premium-domain/") {
						liveRdSlider.noUiSlider.on("slide.one", function () {
						let minPrice = $(this)[0].getPositions()[0] * 100;
						let maxPrice = $(this)[0].getPositions()[1] * 100;

						// Set Price
						$(".live-rd-range-min").val(minPrice.toFixed());
						$(".live-rd-range-max").val(maxPrice.toFixed());

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
						updateFiltersApplied("liveRd", minPrice, maxPrice, 10000);
						});
					}

					$(".live-rd-range-min").on("keyup", function () {
						let newMinPrice = parseFloat($(this).val());
						let newMaxPrice = parseFloat($(".live-rd-range-max").val());

						// Update slider positions
						liveRdSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
						applyFiltersWithAjax(searchTerm);
						updateFiltersApplied("da", newMinPrice, newMaxPrice, 1000);
					});

					$(".live-rd-range-max").on("keyup", function () {
						let newMinPrice = parseFloat($(".live-rd-range-min").val());
						let newMaxPrice = parseFloat($(this).val());
						// Update slider positions
						liveRdSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
						applyFiltersWithAjax(searchTerm);
						updateFiltersApplied("liveRd", newMinPrice, newMaxPrice, 1000);
					});

					//---------------- Age Range Filter ------------
					if (curPath !== "/premium-domain/") {
						ageSlider.noUiSlider.on("slide.one", function () {
						let minPrice = $(this)[0].getPositions()[0] / 2;
						let maxPrice = $(this)[0].getPositions()[1] / 2;

						// Set Price
						$(".age-range-min").val(minPrice.toFixed());
						$(".age-range-max").val(maxPrice.toFixed());

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
						updateFiltersApplied("age", minPrice, maxPrice, 50);
						});
					}

					//---------------- Category Filter ------------
					$('[name="category_filter[]"]').change(async function () {
						let cat = $(this);
						let selectedCat = cat.is(":checked");

						if (selectedCat) {
						if (!selectedCats.includes(cat.val())) {
							selectedCats.push(cat.val());
						}
						} else {
						let index = selectedCats.indexOf(cat.val());
						if (index !== -1) {
							selectedCats.splice(index, 1);
						}
						}

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
					});

					//---------------- Domain Extension Filter ------------
					$('[name="extension_filter[]"]').change(async function () {
						let extension = $(this);
						let selectedExtension = extension.is(":checked");

						if (selectedExtension) {
						if (!selectedExtensions.includes(extension.val())) {
							selectedExtensions.push(extension.val());
						}
						} else {
						let index = selectedExtensions.indexOf(extension.val());
						if (index !== -1) {
							selectedExtensions.splice(index, 1);
						}
						}

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
					});

					//---------------- Authority Backlinks Filter ------------
					$('[name="auhtority_backlinks_filter[]"]').change(async function () {
						let backlink = $(this);
						let selectedBacklink = backlink.is(":checked");

						if (selectedBacklink) {
						if (!selectedBacklinks.includes(backlink.val())) {
							selectedBacklinks.push(backlink.val());
						}
						} else {
						let index = selectedBacklinks.indexOf(backlink.val());
						if (index !== -1) {
							selectedBacklinks.splice(index, 1);
						}
						}

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
					});

					//---------------- Languages Filter ------------
					$('[name="languages_filter[]"]').change(async function () {
						let lang = $(this);
						let selectedLanguage = lang.is(":checked");

						if (selectedLanguage) {
						if (!selectedLanguages.includes(lang.val())) {
							selectedLanguages.push(lang.val());
						}
						} else {
						let index = selectedLanguages.indexOf(lang.val());
						if (index !== -1) {
							selectedLanguages.splice(index, 1);
						}
						}

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
					});

					//---------------- Domain Name Search ------------
					$(".fire-domain-keyword-search").click(function () {
						searchTerm = $('[name="domain-search"]').val().toLowerCase().trim();

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
					});

					//---------------- Domain Type Filter ------------
					$('[name="domain-type[]"]').change(function () {
						let selection = $(this);
						let selected = selection.is(":checked");

						if (selected && selection.val() === "Premium") {
						selectedDomainType = "Premium Domain";
						} else if (selected && selection.val() === "Budget") {
						selectedDomainType = "Budget Domain";
						} else if (selected && selection.val() === "30") {
						selectedDomainType = "30";
						} else if (!selected) {
						selectedDomainType = "";
						}

						applyFiltersWithAjax(searchTerm);
					});

					//---------------- Use Case Filter ------------
					$('[name="use_case_filter[]"]').change(async function () {
						let use = $(this);
						let selectedUse = use.is(":checked");

						if (selectedUse) {
						if (!selectedUses.includes(use.val())) {
							selectedUses.push(use.val());
						}
						} else {
						let index = selectedUses.indexOf(use.val());
						if (index !== -1) {
							selectedUses.splice(index, 1);
						}
						}

						applyFiltersWithAjax(searchTerm); // Call the combined filtering function
					});

					//---------------- Use Case Filter ------------
					let resetFilters = () => {
						let checkboxContainers = $(".cd-checkboxes");
						checkboxContainers.each(function () {});
					};

					//---------------- Combined Filtering Function ------------
					let applyFilters = (searchTerm) => {
						let minPrice = parseFloat($(".price-range-min").val());
						let maxPrice = parseFloat($(".price-range-max").val());

						let minDa = parseFloat($(".da-range-min").val());
						let maxDa = parseFloat($(".da-range-max").val());

						let minDr = parseFloat($(".dr-range-min").val());
						let maxDr = parseFloat($(".dr-range-max").val());

						let minLiveRd = parseFloat($(".live-rd-range-min").val());
						let maxLiveRd = parseFloat($(".live-rd-range-max").val());

						let minAge = parseFloat($(".age-range-min").val());
						let maxAge = parseFloat($(".age-range-max").val());

						$(".domain-inventory-content .product-box").each(async function () {
						let domain = $(this);
						let domainCats = domain
							.find(".catgories span")
							.map(function () {
							return $(this).text();
							})
							.get(); // Get an array of category texts
						let domainExtensions = domain.data("domain-extension");
						let authBacklinks = domain.data("auth-backlinks");
						let languages = domain.data("languages");
						let uses = domain.data("use-cases");

						let price = Number(
							domain.find(".product-card h2").text().replace("$", "")
						);
						let da = Number(domain.find(".da").text());
						let dr = Number(domain.find(".dr").text());
						let liveRd = Number(domain.find(".live-rd").text());
						let age = Number(domain.find(".age").text());
						let domainName = domain.data("domain-name");
						let domainType = domain.data("domain-type");

						let priceFilter = price >= minPrice && price <= maxPrice;
						let daFilter = da >= minDa && da <= maxDa;
						let drFilter = dr >= minDr && dr <= maxDr;
						let liveRdFilter = liveRd >= minLiveRd && liveRd <= maxLiveRd;
						let ageFilter = age >= minAge && age <= maxAge;

						let catFilter =
							selectedCats.length === 0 ||
							domainCats.some((cat) => selectedCats.includes(cat));

						let useCaseFilter =
							selectedUses.length === 0 ||
							uses.some((use) => selectedUses.includes(use));

						let extensionFilter =
							selectedExtensions.length === 0 ||
							domainExtensions.some((extension) => {
							let extensionIncluded = selectedExtensions.includes(extension);
							return extensionIncluded;
							});

						let authorityBacklinksFilter =
							selectedBacklinks.length === 0 ||
							authBacklinks.some((backlink) => {
							let backlinksIncluded = selectedBacklinks.includes(backlink);
							return backlinksIncluded;
							});

						let languageFilter =
							selectedLanguages.length === 0 ||
							languages.some((lang) => {
							let languagesIncluded = selectedLanguages.includes(lang);
							return languagesIncluded;
							});

						let searchFilter = domainName.indexOf(searchTerm) !== -1;
						let domainTypeFilter =
							selectedDomainType === "" || selectedDomainType == domainType;

						if (curPath !== "/premium-domain/") {
							if (
							priceFilter &&
							catFilter &&
							searchFilter &&
							//maxPriceTypeFilter &&
							daFilter &&
							drFilter &&
							liveRdFilter &&
							ageFilter &&
							extensionFilter &&
							domainTypeFilter &&
							authorityBacklinksFilter &&
							languageFilter &&
							useCaseFilter
							) {
							domain.fadeIn().css("display", "grid");
							domain.addClass("visible");
							} else {
							domain.hide();
							domain.removeClass("visible");
							}
						} else {
							if (catFilter) {
							domain.fadeIn().css("display", "grid");
							domain.addClass("visible");
							} else {
							domain.hide();
							domain.removeClass("visible");
							}
						}
						});

						setTimeout(() => {
						noResults();
						}, 600);
					};

					let applyFiltersWithAjax = (searchTerm) => {
						let nonce = my_ajax_obj.nonce;
						console.log(nonce);

						// Gather your filter data here, e.g., minPrice, maxPrice, selectedCats, etc.
						let filterData = {
						minPrice: parseFloat($(".price-range-min").val()),
						maxPrice: parseFloat($(".price-range-max").val()),
						minDa: parseFloat($(".da-range-min").val()),
						// ... (rest of your filter data)
						searchTerm: searchTerm,
						nonce: nonce,
						};

						$.ajax({
						type: "POST",
						url: my_ajax_obj.ajax_url,
						data: {
							action: "apply_filters_ajax", // The action name for your server-side function
							filterData: filterData,
							nonce: my_ajax_obj.nonce, // Add the nonce value to the data
						},
						success: function (response) {
							// Update the product list based on the filtered data received from the server
							updateProductList(response.data.filteredProducts); // Access the filteredProducts key
							noResults(); // Perform other necessary actions
						},
						});
					};

					//---------------- Reveal domain name ------------
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
				});
			</script>
        </div>

	</div>
</div>

<?php get_footer() ?>
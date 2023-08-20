<?php
    /* Template Name: Premium Domains */
?>

<?php get_header(); ?>



<!-- ------------------ start ----------- -->
<?php
	$domainType = 'Premium Domain';
	$current_page = max(1, get_query_var('paged'));
	$posts_per_page = 5;
	
    $args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'paged' => $current_page,
		'meta_query' => array(
			array(
				'key' => 'domain_type',
				'value' => $domainType,
				'compare' => '=',
			),
		),
	);	
    $product_query = new WP_Query($args);
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

<div class="domain-section premium-domain-section">
    <div class="domain-inventory-wrap premium-domain">

        <!-- Domain Inventory Search Box -->
        <div class="domain-inventory-search-box">
            <h2>Premium Domain </h2>
        </div>
        <!-- Domain Loop with Filters -->
        <div class="domain-inventory-search-wrap">
            <!-- FILTERS -->
            <div class="domain-inventory-sidebar">
				
               <div class="domain-inventory-search-filters">
			   		<!-- Category Filter -->
				   <div class="category-filter">
                        <div class="filter-title">
                            <h3>Product Categories</h3>
                        </div>
						<div class="answer" style="display:block">
							<div class="search-input-wrapper">
								<input type="text" id="category_search" placeholder="Search Categories">
								<span class="search-icon"></span>
							</div>
							<div class="category-checkboxes cd-checkboxes" id="category_checkboxes">
								<?php if(!empty($product_cats)) { 
									foreach ($product_cats as $category) { ?>
										<?php
											$catObj = get_term_by('name', $category->name, 'product_cat');
											$productCount = $catObj->count;
										?>
										<?php if($productCount != 0) { ?>
											<a href="javascript:void(0)"> 
												<label>
													<input name="category_filter[]" type="checkbox" value="<?= $category->name ?>">	
													<span><?= esc_html($category->name) ?> (<?= $productCount ?>)</span> <br>
												</label>
											</a>
										<?php } ?>
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
					if ($product_query->have_posts()) {
						while ($product_query->have_posts()) {
							
							//$product_id = $product->get_id();
							$product_id = get_the_ID(); // Use get_the_ID() to get post ID
							$product_title = get_the_title();
							$product_slug = get_post_field('post_name', $product_id);
            				$price = get_post_meta($product_id, '_price', true);
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
						<?php if($domain_type == 'Premium Domain') { ?>
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
						<?php } ?>
						<?php
							$pagination_args = array(
								'base' => esc_url(add_query_arg('paged', '%#%')),
								'format' => '?paged=%#%',
								'total' => $product_query->max_num_pages,
								'current' => $current_page,
								'prev_next' => true,
								'prev_text' => __('&laquo; Previous'),
								'next_text' => __('Next &raquo;'),
							);

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

			<div class="domain-inventory-content" id="product-container">
				<?php if ($product_query->have_posts()) {
					while ($product_query->have_posts()) {
						$product_id = get_the_ID(); // Use get_the_ID() to get post ID
						$product_title = get_the_title();
						$product_slug = $product->get_slug();
						$price = $product -> get_price();
						$da = get_post_meta($product_id, 'da', true);
						$product_image_url = get_the_post_thumbnail_url($product_id, 'full');
						$product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names'));

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
						<?php if ($domain_type == 'Premium Domain') { ?>
							<div class="product-box visible" data-domain-name="<?= $product_title ?>" data-domain-type="<?= $domain_type ?>">
								<div class="product-details">
									<!-- Product details content -->
								</div>
							</div>
						<?php } ?>
					<?php }
					
					// Pagination
					$pagination_args = array(
						'base' => esc_url(add_query_arg('paged', '%#%')),
						'format' => '?paged=%#%',
						'total' => $product_query->max_num_pages,
						'current' => $current_page,
						'prev_next' => true,
						'prev_text' => __('&laquo; Previous'),
						'next_text' => __('Next &raquo;'),
					);
					?>
					<div class="pagination-section" id="">
						<p class="hidden">Showing <?= $totalProducts; ?> domains filtered out of <?= $totalProducts; ?> domains</p>
						<div id="pagination-container" class="pagination">
							<?php if ($pagination_links) {
								echo $pagination_links;
							} ?>
						</div>
					</div>
				<?php } else {
					echo 'No products found.';
				} ?>
			</div>

			<!-- LOAD MORE SECTION -->
			<div class="load-more-container">
				<div id="loading-text" style="display: none;">
					<img src="<?= get_site_url() . '/wp-content/uploads/2023/08/imgpsh_fullsize_anim.gif'?>" alt="">
				</div>
			</div>
			<script>
				// const productContainer = document.getElementById('product-container');
				// const loadingText = document.getElementById('loading-text');
				// 	let page = 1; // Initial page number
				// 	const productsPerPage = 10;
				// 	const curLoc = window.loca

				// 	function fetchAndAppendProducts() {
				// 		loadingText.style.display = 'block'; // Show the loading images
				// 		jQuery.ajax({
				// 			url: '<?php echo esc_url(admin_url('admin-ajax.php', 'https')); ?>', // WordPress AJAX URL
				// 			type: 'POST',
				// 			data: {
				// 				action: 'load_more_posts', // Custom AJAX action
				// 				page: page,
				// 				base_url: window.location.pathname,
				// 				products_per_page: productsPerPage,
				// 			},
				// 			success: function(response) {
				// 			productContainer.insertAdjacentHTML('beforeend', response);
				// 			page++; // Increment the page number for the next fetch
				// 			loadingText.style.display = 'none'; // Hide the loading images
				// 			},
				// 			error: function(error) {
				// 			console.error(error);
				// 			loadingText.style.display = 'none'; // Hide the loading text in case of an error
				// 			}
				// 		});
				// 	}

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
<!-- ---------------------- end -------------- -->

<?php get_footer(); ?>


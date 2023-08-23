<?php
    /* Template Name: Premium Domains */
?>

<?php get_header(); ?>

<?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
		'meta_query' => array(
			array(
				'key' => 'domain_type',
				'value' => 'Premium Domain',
				'compare' => '=',
				'type' => 'CHAR',
			),
		),
    );
    $premium_products = new WP_Query($args);

	$product_query = new WC_Product_Query($args);
    $pps = $product_query->get_products();

	// Separate query for categories
	$product_cats = get_terms(array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
	));
?>

<div class="domain-section premium-domain-section">
    <div class="domain-inventory-wrap premium-domain">
        <div class="domain-inventory-search-box">
            <h2>Premium Domains</h2>
        </div>
        <div class="domain-inventory-search-wrap">
            <!-- FILTERS -->
			<?php
				$premium_category_names = array();
				foreach ($pps as $pp) {
					$product_id = $pp->get_id();
					$product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names'));
				
					// Check if the product has the "Premium Domain" value
					if (get_field('domain_type', $product_id) === 'Premium Domain') {
						foreach ($product_categories as $category_name) {
							// Increment the count for the category or initialize if it doesn't exist
							if (isset($premium_category_counts[$category_name])) {
								$premium_category_counts[$category_name]++;
							} else {
								$premium_category_counts[$category_name] = 1;
							}
						}
					}
				}
			?>
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
								<?php
									foreach ($premium_category_counts as $category_name => $count) {
										?>
										<a href="javascript:void(0)"> 
											<label>
												<input name="category_filter[]" type="checkbox" value="<?= $category_name ?>">	
												<span><?= esc_html($category_name) ?> (<?= $count ?>)</span> <br>
											</label>
										</a>
										<?php
									}
								?>
							</div>
						</div>
                    </div>
			   </div>
            </div>
            <!-- DOMAINS -->
            <div class="domain-inventory-content" id="product-container">
				<div class="ajax-loader hidden">
					<img src="<?= get_stylesheet_directory_uri() . '/img/ajax-loader.gif' ?>">
				</div>
                <?php
					if ($premium_products->have_posts()) {
						while ($premium_products->have_posts()) {
							
							$premium_products->the_post(); // Set up the post data
							$product_id = get_the_ID(); // Use get_the_ID() to get post ID
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
											<span class="obscured-domain-name"> <?= $product_title ?> </span> 
										</label> 
										<br>
										<div class="description hidden">
											<a href="javascript:void(0)"> <img src="/wp-content/uploads/2023/08/heart-love.jpg"> </a>
										</div>
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
								<p class="hidden">Showing <?= $total_products; ?> domains filtered out of <?= $total_products; ?> domains</p>
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
        </div>

	</div>
</div>

<script>
	let loading = false;
	let hasMoreProducts = true;
	const productContainer = document.getElementById('product-container');

	async function applyFiltersWithAjax(searchTerm) {
		jQuery('.ajax-loader').removeClass('hidden');
		jQuery('.domain-inventory-content *:not(.ajax-loader):not(.ajax-loader img)').remove();
		
		if (loading || !hasMoreProducts) return;
		loading = true;

		// Pass the category selection to server
		let catsSelected = new Set();
		jQuery('input[name="category_filter[]"]').each(function() {
			let cat = jQuery(this);
			if (cat.is(':checked')) {
				catsSelected.add(cat.val());
			}
		});
		let uniqueCategoryFilters = Array.from(catsSelected);

		const filterData = {
			categoryFilter: uniqueCategoryFilters,
		};

		jQuery.ajax({
			url: my_ajax_obj.ajax_url,
			type: 'POST',
			data: {
				action: 'load_more_premium_products',
				filterData: filterData,
			},
			success: function(response) {
				if (response.success) {
					// Check if response.data is an object
					if (typeof response.data === 'object') {
						const responseData = response.data.data;
						
						if (responseData.trim() === '') {
							hasMoreProducts = false; // No more products to load
							return;
						}
						
						// Append new content to the container
						jQuery('.ajax-loader').addClass('hidden');
						productContainer.insertAdjacentHTML('beforeend', responseData);

						jQuery(".domain-name-revealer").click(function () {
							let isLoggedIn = jQuery("body").hasClass("logged-in");

							let unobscuredDomainName = jQuery(this)
							.closest(".product-box")
							.data("domain-name");

							if (isLoggedIn) {
							jQuery(this)
								.closest(".product-box")
								.find(".obscured-domain-name")
								.text(unobscuredDomainName);
							} else {
							jQuery(".ast-account-action-login").click();
							}
						});
					} else {
						console.error('Invalid response data:', response.data);
					}
				} else {
					console.error('Error in AJAX response:', response.data);
				}
			},
			error: function(error) {
				console.error('AJAX error:', error);
			},
			complete: function() {
				loading = false;
			}
		});
	}
</script>

<?php get_footer(); ?>


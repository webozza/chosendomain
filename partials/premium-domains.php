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
				<?php if ($product_query->have_posts()) {
					while ($product_query->have_posts()) {
						$product_id = get_the_ID(); // Use get_the_ID() to get post ID
						$product_title = get_the_title();
						$product_slug = get_post_field('post_name', $product_id);
						$price = get_post_meta($product_id, '_price', true);
						$product_description = get_the_content();
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
					$pagination_links = paginate_links($pagination_args);  
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

			<script>
				
			</script>
        </div>

	</div>
</div>
<!-- ---------------------- end -------------- -->

<?php get_footer(); ?>


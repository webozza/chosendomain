<?php
    /* Template Name: Aged Domains */
?>

<?php get_header() ?>

<?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
		'meta_query'     => array(
			array(
				'key'     => 'domain_type', // Replace with the actual ACF field key
				'value'   => 'Aged Domain',
				'compare' => '=='
			)
		)
    );
    $product_query = new WP_Query($args);
	$total_products = $product_query -> found_posts;
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

    $tlds = get_terms(array(
		'taxonomy' => 'tld',
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
	<!-- upper Heading -->
	        <div class="upper-heading" style="display:none;">
				<style>
				.upper-heading {
    max-width: 800px;
    text-align: center;
    margin: 10px auto;
    padding: 60px 30px 1px 30px;
}
	.tooltip1 {
    position: relative;
    display: inline-block;
  }
  .tooltip1 h3{margin-right:4px;}
  .tooltip1 .tooltiptext1 {
    visibility: hidden;
    padding: 5px;
    position: absolute;
    z-index: 1;
    width: 150px;
    opacity: 0;
    transition: opacity 0.3s;
	top: -22px;
    left: 105%;
	color:#000;
	font-size:15px;
  }
  .tooltip1:hover .tooltiptext1 {
    visibility: visible;
    opacity: 1;
  }
					.seodomain-point{text-align:left;}
					.seodomain-point li{color:#333;list-style:none;}
					/* .seodomain-point li::before{ 
						content: "\00BB";
						font-size:23px;
						color:#f45a2a;
					}  */
					.seodomain-point li a{color:#f45a2a;}
				</style>
            <h2>Aged and Expired Domain With Strong Links</h2>
				<ul class="seodomain-point">
					<li>👉  Click on the <b>"Eye"</b> button to view the domain.</li>
					<li>👉 <b>Register</b> or <b>log in</b> to access and view the domain details.</li>
					<li>👉 Utilize filters to narrow down options based on your specific requirements.</li>
					<li>👉 Once you've selected a domain, click <b>"Add to Cart."</b></li>
					<li>👉 Proceed to checkout and complete the purchase.</li>
					<li>👉 Our team will initiate the domain transfer process promptly.</li>
					<li>👉 Learn more about the transfer process by reading our "<a href="https://chosendomain.com/how-it-works/">How It Works</a>" section.</li>
					<li>👉 For any queries, Contact us on <a href="https://join.skype.com/invite/u9iflIaZWX5y">Skype</a></li>
				</ul>
        </div>
	<!-- upper Heading ending -->
    <div class="aged-domain-heading">
        <h2>Aged Domains</h2>
    </div>
    <div class="domain-inventory-wrap">
        <!-- Domain Inventory Search Box -->
        <div class="domain-inventory-search-box" style="display:none;">
            <h2>Aged Domains</h2>
            <div class="domain-inventory-domain-type switch-domain-type">
                <input type="radio" id="domain-type-budget" name="domain-type[]" value="Budget Domain">
                <label for="domain-type-budget" class="show-tooltip">Budget Domains</label>
                <input type="radio" id="domain-type-premium" name="domain-type[]" value="Premium Domain">
                <label for="domain-type-premium" class="show-tooltip">Premium Domains</label>
                <input type="radio" id="domain-type-30" name="domain-type[]" value="30">
                <label for="domain-type-30" class="show-tooltip">$30 Domains</label>
            </div>
            <div style="" class="domain-inventory-search-field">
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
							<div class="tooltip1">
							<div style="display:flex;">
                            	<h3>DA</h3>
								<i class="fa-solid fa-circle-info"></i>
							</div>
								<div class="tooltiptext1">Domain Authority</div>
								</div><!--<p id="info-text">Domain Authority</p>-->
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
							<div class="tooltip1">
							<div style="display:flex;">
                            	<h3>PA</h3>
								<i class="fa-solid fa-circle-info"></i>
							</div>
								<div class="tooltiptext1">Page Authority</div>
								</div>
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
											<input class="sf-input-range-number sf-range-min pa-range-min sf-input-number" min="0"
												max="100" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
										</label>
										<span class="sf-range-values-separator"></span>
										<label>
											<input class="sf-input-range-number sf-range-max pa-range-max sf-input-number" min="0"
												max="100" step="1" name="_sfm__sale_price[]" type="number" value="100"
												title="">
										</label>
									</div>
									<div class="meta-slider noUi-target noUi-ltr noUi-horizontal pa-slider">
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
					<div style="" class="slide-accor"> 
						<div class="filter-title">
							<div class="tooltip1">
							<div style="display:flex;">
                            	<h3>DR</h3>
								<i class="fa-solid fa-circle-info"></i>
							</div>
								<div class="tooltiptext1">Domain Rating</div>
								</div>
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

                    <!-- TF Range Filter -->
					<div style="" class="slide-accor"> 
						<div class="filter-title">
							<div class="tooltip1">
							<div style="display:flex;">
                            	<h3>TF</h3>
								<i class="fa-solid fa-circle-info"></i>
							</div>
								<div class="tooltiptext1">Trust Flow</div>
								</div>
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
											<input class="sf-input-range-number sf-range-min tf-range-min sf-input-number" min="0"
												max="100" step="1" name="_sfm__sale_price[]" type="number" value="0" title="">
										</label>
										<span class="sf-range-values-separator"></span>
										<label>
											<input class="sf-input-range-number sf-range-max tf-range-max sf-input-number" min="0"
												max="100" step="1" name="_sfm__sale_price[]" type="number" value="100"
												title="">
										</label>
									</div>
									<div class="meta-slider noUi-target noUi-ltr noUi-horizontal tf-slider">
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

                    <!-- RD -->
					<div class="slide-accor"> 
						<div class="filter-title">
							<div class="tooltip1">
							<div style="display:flex;">
                            	<h3>RD</h3>
								<i class="fa-solid fa-circle-info"></i>
							</div>
								<div class="tooltiptext1">Referring Domains</div>
								</div>
							
                        </div>
						<div class="answer">
							<div class="sf-field-post-meta-_sale_price open" data-sf-field-name="_sfm__sale_price" data-sf-field-type="post_meta" data-sf-field-input-type="range-slider" data-sf-meta-type="number">
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
					<div class="slide-accor"> 
						<div class="filter-title">
                            <h3>Age</h3>
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
						<div class="answer">

							<div class="sf-field-post-meta-_sale_price open" data-sf-field-name="_sfm__sale_price" data-sf-field-type="post_meta" data-sf-field-input-type="range-slider" data-sf-meta-type="number">

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

                    <!-- TLDs -->
                    <div class="tld-filter slide-accor">
                        <div class="filter-title">
                            <h3>TLD </h3>
                        </div>
						<div class="answer">
							<div class="search-input-wrapper">
								<input type="text" id="tld_search" placeholder="Search tlds">
								<span class="search-icon"></span>
							</div>
						
                        <div class="tld-checkboxes cd-checkboxes" id="tld_checkboxes">
							<?php if(!empty($tlds)) { 
								foreach ($tlds as $tld) {?>
									<a href="javascript:void(0)"> 
										<label>
											<input name="tld_filter[]" type="checkbox" value="<?= $tld->name ?>">	
											<span>.<?= $tld->name ?></span> <br>
										</label>
									</a>
								<?php
								}
							 } ?>
                        </div>
						</div>
                    </div>

                    <!-- Google Index -->
                </div>
            </div>

            <!-- DOMAIN INVENTORY -->
            <div class="domain-inventory-content" id="product-container">
				<div class="ajax-loader hidden">
					<img src="<?= get_stylesheet_directory_uri() . '/img/ajax-loader.gif' ?>">
				</div>
                <?php
					if ($product_query->have_posts()) {
						while ($product_query->have_posts()) {
							
							$product_query->the_post(); // Set up the post data
							$product_id = get_the_ID(); // Use get_the_ID() to get post ID
							
							// Skip if the domain type is not "Premium Domain 2"
							$domain_type = get_field('domain_type', $product_id);
							$product_title = get_the_title();
							$product_slug = get_post_field('post_name', $product_id);
            				$price = get_post_meta($product_id, '_price', true);
							$product_description = get_the_content();
							$da = get_post_meta($product_id, 'da', true);
							$pa = get_post_meta($product_id, 'pa', true);
							$live_rd = get_post_meta($product_id, 'live_rd', true);
							$hist_rd = get_post_meta($product_id, 'hist_rd', true);
							$product_image_url = get_the_post_thumbnail_url($product_id, 'full');
							$product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names'));

                            // Aged Domain Filters
                            $dr = get_post_meta($product_id, 'dr', true);
                            $tf = get_post_meta($product_id, 'tf', true);
                            $rd = get_post_meta($product_id, 'live_rd', true);
                            $age = get_post_meta($product_id, 'age', true);
                            $google_index = get_post_meta($product_id, 'google_index', true);


							// Domain Extensions
							$domain_extensions = wp_get_post_terms($product_id, 'extension');
							$extension_names = array();
							foreach ($domain_extensions as $extension) {
								$extension_names[] = $extension->name;
							};

                            // Top Level Domains (TLD)
                            $tlds = wp_get_post_terms($product_id, 'tld');
                            $tld_names = array();
                            foreach ($tlds as $tld) {
                                $tld_names[] = $tld->name;
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
								<div style="display:none;" class="product-box visible" data-domain-name="<?= $product_title ?>" data-domain-extension='<?= esc_attr(json_encode($extension_names)); ?>' data-tld='<?= esc_attr(json_encode($tld_names)); ?>' data-domain-type="<?= $domain_type ?>" data-auth-backlinks='<?= json_encode($ab_names) ?>' data-languages='<?= json_encode($langs) ?>' data-use-cases='<?= json_encode($uses) ?>'> 
									<div class="product-details">
										<div class="product-head">
											<!--
											<div class="product-img">
												<?php if ($product_image_url) { ?>
													<img src="<?= $product_image_url ?>" alt="product image">
												<?php } else { ?>
													<img src="<?= get_site_url() . '/wp-content/uploads/woocommerce-placeholder.png' ?>" alt="product image">
												<?php } ?>
											</div>
											-->
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
												<li> <span class="dr"><?= $dr ?></span> DR </li>
                                                <li> <span class="dr"> 0 </span> TF </li>
												<li> <span class="rd">0</span> RD </li>
												<li> <span class="age"><?= $age ?></span> Age </li>
                                                <li> <span class="tld"> 0 </span> TLD </li>
                                                <li> <span class="google-index"> 0 </span> Google Index </li>
											</ul>
											<div class="product-short-desc"><p><?php echo $product->post->post_excerpt; ?></p></div>
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
                                <div class="auction-item-5 live aos-init aos-animate" data-aos="zoom-out-up" data-aos-duration="1200">
                                    <div class="auction-inner">
                                        <div class="upcoming-badge" title="Upcoming Auction">
                                            <img src="/wp-content/uploads/2024/03/new-domain.png">
                                        </div>
                                        <div class="auction-thumb">
                                            <a href="<?= get_site_url() . '/product/' . $product_slug ?>"><img src="./assets/images/auction/upcoming/upcoming-2.png" alt="upcoming"></a>
                                            <a href="#0" class="rating"><i class="far fa-star"></i></a>
                                        </div>
                                        <div class="auction-content">
                                            <div class="title-area">
                                                <h6 class="title">
                                                    <a href="<?= get_site_url() . '/product/' . $product_slug ?>"><?= $product_title ?></a>
                                                </h6>
                                                <div class="product-body">
                                                    <div class="catgories"> 
                                                        <?php foreach($product_categories as $catagory) { ?>
                                                            <span><?= $catagory?></span>
                                                        <?php }?>
                                                            <a class="hidden" href="<?= the_permalink($catagory_id -> ID);?>"> View Links </a> 
                                                    </div>
                                                    <div class="bid-area">
                                                        <ul>
                                                            <li> <span class="da"><?= $da ?></span> DA </li>
                                                            <li> <span class="pa"><?= $pa ?></span> PA </li>
                                                            <li> <span class="dr"><?= $dr ?></span> DR </li>
                                                            <li> <span class="tf"><?= $tf ?></span> TF </li>
                                                            <li> <span class="rd"><?= $rd ?></span> RD </li>
                                                            <li> <span class="age"><?= $age ?></span> Age </li>
                                                            <li> <span class="google-index"><?= $google_index ?></span> Google Index </li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-short-desc"><p><?php echo $product->post->post_excerpt; ?></p></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="auction-bidding product-card">
                                            <div class="bid-incr">
                                                <h4>$<?= $price ?></h4>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="?add-to-cart=<?= $product_id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart " data-product_id="<?= $product_id ?>" data-product_sku="" aria-label="Add “<?= $product_title ?>” to your cart" aria-describedby="" rel="nofollow">Add to cart</a>
                                                </li>
                                                <li> <a href="<?= get_site_url() . '/product/' . $product_slug ?>"> More Data </a> </li>
                                            </ul>
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

		<!-- LOAD MORE SECTION -->
		<div class="load-more-container">
			<div id="loading-text" style="display: none;">
				<img src="<?= get_site_url() . '/wp-content/uploads/2023/08/imgpsh_fullsize_anim.gif'?>" alt="">
			</div>
		</div>

		<!-- Ajax Filters -->
		<script>
			// Check if URL contains a page number
			const urlParams = new URLSearchParams(window.location.search);
			const urlPageNumber = urlParams.get('paged');

			if (urlPageNumber) {
				currentPage = parseInt(urlPageNumber); // Update the current page number
				loadPage(currentPage); // Load the page based on URL page number
			}

			let loading = false;
			let hasMoreProducts = true;
			const productContainer = document.getElementById('product-container');
			const loadingText = document.getElementById('loading-text');

			function parseQueryString(url) {
				const queryString = url.split('?')[1];
				const paramsArray = queryString.split('&');
				
				const paramsObject = {};
				
				paramsArray.forEach(param => {
					const [key, value] = param.split('=');
					paramsObject[key] = value || true; // If no value, set it to true
				});
				
				return paramsObject;
			}

			async function applyFiltersWithAjax(searchTerm) {
				jQuery('.ajax-loader').removeClass('hidden');
				jQuery('.domain-inventory-content *:not(.ajax-loader):not(.ajax-loader img)').remove();

				let containerOffset = jQuery('.domain-inventory-content').offset().top  - 70;
				jQuery(window).scrollTop(containerOffset);
				
				if (loading || !hasMoreProducts) return;
				loading = true;
				loadingText.style.display = 'block';

				// Pass the category selection to server
				let catsSelected = new Set();
				jQuery('input[name="category_filter[]"]').each(function() {
					let cat = jQuery(this);
					if (cat.is(':checked')) {
						catsSelected.add(cat.val());
					}
				});
				let uniqueCategoryFilters = Array.from(catsSelected);

				// Pass the extension selection to server
				let extensionsSelected = new Set();
				jQuery('input[name="extension_filter[]"]').each(function() {
					let extension = jQuery(this);
					if (extension.is(':checked')) {
						extensionsSelected.add(extension.val());
					}
				});
				let uniqueExtensionFilters = Array.from(extensionsSelected);

                // Pass the tld selection to server
				let tldsSelected = new Set();
				jQuery('input[name="tld_filter[]"]').each(function() {
					let tld = jQuery(this);
					if (tld.is(':checked')) {
						tldsSelected.add(tld.val());
					}
				});
				let uniqueTldFilters = Array.from(tldsSelected);

				// Pass the authority backlinks selection to server
				let authorityBacklinksSelected = new Set();
				jQuery('input[name="auhtority_backlinks_filter[]"]').each(function() {
					let ab = jQuery(this);
					if (ab.is(':checked')) {
						authorityBacklinksSelected.add(ab.val());
					}
				});
				let uniqueAuthorityBacklinks = Array.from(authorityBacklinksSelected);

				// Pass the domain type selected
				let domainTypeSelected = "";
				jQuery('input[name="domain-type[]"]').each(function() {
					let domainType = jQuery(this);
					if(domainType.is(':checked')) {
						domainTypeSelected = domainType.val();
					}
				})

				const filterData = {
					minPrice: parseFloat(jQuery(".price-range-min").val()),
					maxPrice: parseFloat(jQuery(".price-range-max").val()),
					minDa: parseFloat(jQuery(".da-range-min").val()),
					maxDa: parseFloat(jQuery(".da-range-max").val()),
					minPa: parseFloat(jQuery(".pa-range-min").val()),
					maxPa: parseFloat(jQuery(".pa-range-max").val()),
					minLiveRd: parseFloat(jQuery(".live-rd-range-min").val()),
					maxLiveRd: parseFloat(jQuery(".live-rd-range-max").val()),
                    minTf: parseFloat(jQuery(".tf-range-min").val()),
					maxTf: parseFloat(jQuery(".tf-range-max").val()),
					minAge: parseFloat(jQuery(".age-range-min").val()),
					maxAge: parseFloat(jQuery(".age-range-max").val()),
					minDr: parseFloat(jQuery(".dr-range-min").val()),
					maxDr: parseFloat(jQuery(".dr-range-max").val()),
					searchTerm: searchTerm,
					categoryFilter: uniqueCategoryFilters,
					extensionFilter: uniqueExtensionFilters,
                    tldFilter: uniqueTldFilters,
					authorityBacklinksFilter: uniqueAuthorityBacklinks,
					domainTypeFilter: domainTypeSelected,
				};

				jQuery.ajax({
					url: my_ajax_obj.ajax_url,
					type: 'POST',
					data: {
						action: 'load_more_products',
						filterData: filterData,
						cd_page: 'aged_domains',
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

								domainRevealerFunc();
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
						loadingText.style.display = 'none';
						loading = false;
					}
				});
			}

			let currentPage = 1;

			function loadPage(pageNumber) {
				jQuery('.ajax-loader').removeClass('hidden');
				jQuery('.domain-inventory-content *:not(.ajax-loader):not(.ajax-loader img)').remove();
				
				if (loading || !hasMoreProducts) return;
				loading = true;
				loadingText.style.display = 'block';

				// Pass the category selection to server
				let catsSelected = new Set();
				jQuery('input[name="category_filter[]"]').each(function() {
					let cat = jQuery(this);
					if (cat.is(':checked')) {
						catsSelected.add(cat.val());
					}
				});
				let uniqueCategoryFilters = Array.from(catsSelected);

				// Pass the extension selection to server
				let extensionsSelected = new Set();
				jQuery('input[name="extension_filter[]"]').each(function() {
					let extension = jQuery(this);
					if (extension.is(':checked')) {
						extensionsSelected.add(extension.val());
					}
				});
				let uniqueExtensionFilters = Array.from(extensionsSelected);

				// Pass the extension selection to server
				let authorityBacklinksSelected = new Set();
				jQuery('input[name="auhtority_backlinks_filter[]"]').each(function() {
					let ab = jQuery(this);
					if (ab.is(':checked')) {
						authorityBacklinksSelected.add(ab.val());
					}
				});
				let uniqueAuthorityBacklinks = Array.from(authorityBacklinksSelected);

				// Pass the domain type selected
				let domainTypeSelected = "";
				jQuery('input[name="domain-type[]"]').each(function() {
					let domainType = jQuery(this);
					if(domainType.is(':checked')) {
						domainTypeSelected = domainType.val();
					}
				})

				const filterData = {
					minPrice: parseFloat(jQuery(".price-range-min").val()),
					maxPrice: parseFloat(jQuery(".price-range-max").val()),
					minDa: parseFloat(jQuery(".da-range-min").val()),
					maxDa: parseFloat(jQuery(".da-range-max").val()),
					minPa: parseFloat(jQuery(".pa-range-min").val()),
					maxPa: parseFloat(jQuery(".pa-range-max").val()),
					minDr: parseFloat(jQuery(".dr-range-min").val()),
					maxDr: parseFloat(jQuery(".dr-range-max").val()),
					minLiveRd: parseFloat(jQuery(".live-rd-range-min").val()),
					maxLiveRd: parseFloat(jQuery(".live-rd-range-max").val()),
                    minTf: parseFloat(jQuery(".tf-range-min").val()),
					maxTf: parseFloat(jQuery(".tf-range-max").val()),
					minAge: parseFloat(jQuery(".age-range-min").val()),
					maxAge: parseFloat(jQuery(".age-range-max").val()),
					searchTerm: searchTerm,
					categoryFilter: uniqueCategoryFilters,
					extensionFilter: uniqueExtensionFilters,
                    tldFilter: uniqueTldFilters,
					authorityBacklinksFilter: uniqueAuthorityBacklinks,
					domainTypeFilter: domainTypeSelected,
				};

				jQuery.ajax({
					url: my_ajax_obj.ajax_url,
					type: 'POST',
					data: {
						action: 'load_more_products',
						filterData: filterData,
						cd_page: 'aged_domains',
						pageNumber: currentPage, // Add the current page number
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

								// Update the pagination container if provided in the response
								if (typeof response.data.pagination !== 'undefined') {
									jQuery('#pagination-container').html(response.data.pagination);
								}
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
						loadingText.style.display = 'none';
						loading = false;
					}
				});
			}

			// Add an event listener to pagination links
			document.querySelectorAll('.pagination-link').forEach(link => {
				link.addEventListener('click', function(event) {
					event.preventDefault(); // Prevent default link behavior
					const newPageNumber = parseInt(this.dataset.page); // Get the page number from data-page attribute
					loadPage(newPageNumber); // Load the clicked page
				});
			});

			
		</script>

	</div>
</div>

<?php get_footer() ?>
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
?>

<div class="domain-section">
    <div class="domain-inventory-wrap">

        <!-- Domain Inventory Search Box -->
        <div class="domain-inventory-search-box">
            <h2>Choose your Domain Type</h2>
            <div class="domain-inventory-domain-type switch-domain-type">
                <input type="radio" id="domain-type-budget" name="domain-type" value="Budget">
                <label for="domain-type-budget" class="show-tooltip">Budget Domains</label>
                <input type="radio" id="domain-type-premium" name="domain-type" value="Premium">
                <label for="domain-type-premium" class="show-tooltip">Premium Domains</label>
                <input type="radio" id="domain-type-30" name="domain-type" value="30">
                <label for="domain-type-30" class="show-tooltip">$30 Domains</label>
            </div>
            <div class="domain-inventory-search-field">
                <input type="text" name="domain-search" id="domain-search"
                    placeholder="Search Domain ID / Domain Name / Keyword / Niche" value="">
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
                    <h3>Filters</h3>
                    <div class="reset-filters">
                        <span>No filters applied</span>
                        <button class="btn-reset-filter" disabled="disabled">Reset all</button>
                    </div>
                    <div class="category-filter">
                        <div class="search-input-wrapper">
                            <label for="category-search">Category</label>
                            <input type="text" id="category-search" placeholder="Search Categories">
                            <span class="search-icon"></span>
                        </div>
                        <div class="category-checkboxes">
                            <input type="checkbox" id="category-1" value="Category 1">
                            <label for="category-1">Category 1</label><br>
                            <input type="checkbox" id="category-2" value="Category 2">
                            <label for="category-2">Category 2</label><br>
                            <input type="checkbox" id="category-3" value="Category 3">
                            <label for="category-3">Category 3</label><br>
                            <!-- Add more checkboxes for other categories as needed -->
                        </div>
                    </div>
                    <!-- Price Range Filter -->
                    <li class="sf-field-post-meta-_sale_price open" data-sf-field-name="_sfm__sale_price"
                        data-sf-field-type="post_meta" data-sf-field-input-type="range-slider"
                        data-sf-meta-type="number">
                        <h4>Price</h4>
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
                    </li>

                </div>
            </div>
            <!-- DOMAINS -->
            <div class="domain-inventory-content">
                <?php
					if ($products) {
						foreach ($products as $product) {
							$product_id = $product->get_id();
							$product_title = $product->get_name();
							$product_description = $product->get_description();

					?>
                <div class=""><?= $product_title ?></div>
                <div class=""><?= $product_description ?></div>
                <?php
						}
					} else {
						echo 'No products found.';
					}
					?>
            </div>
        </div>

        <?php get_footer() ?>
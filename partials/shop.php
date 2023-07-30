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
				<input type="text" name="domain-search" id="domain-search" placeholder="Search Domain ID / Domain Name / Keyword / Niche" value="">
				<button class="fire-domain-keyword-search">SEARCH</button>
			</div>
		</div>

        <!-- Domain Search Controls -->
        <div class="domain-search-controls">
            <button class="di-hide-filters dc-btn dc-btn-primary-muted dc-btn-big"><span class="hide-on-mobile">Hide filters</span> <i class="far fa-eye-slash"></i></button>
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

    </div>
</div>

<?php get_footer() ?>
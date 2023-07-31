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
                    <div class="category-filter" onclick="toggleFunction()">
                        <div class="category-filter-content" id="category-filter-content">
                            <label for="category-search">Search Category:</label>
                            <input type="text" id="category-search" placeholder="Enter category name...">
                            <div class="category-list">
                                <!-- Your category elements can go here (e.g., list items, checkboxes, etc.) -->
                                <!-- For example, a list of categories: -->
                                <ul>
                                    <li>Category 1</li>
                                    <li>Category 2</li>
                                    <li>Category 3</li>
                                    <!-- Add more categories as needed -->
                                </ul>
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
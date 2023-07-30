<?php
    /* Template Name: Custom Shop */
?>

<?php get_header() ?>

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

        <!-- Domain Loop with Filters -->
        <div class="domain-search-controls">
            <button class="di-hide-filters dc-btn dc-btn-primary-muted dc-btn-big"><span class="hide-on-mobile">Hide filters</span> <i class="far fa-eye-slash"></i></button>
        </div>

    </div>
</div>

<?php get_footer() ?>
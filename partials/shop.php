<?php
    /* Template Name: Custom Shop */
?>

<?php get_header() ?>

<div class="domain-section">
    <div class="domain-inventory-wrap">
        <div class="domain-inventory-search-box">
			<h2>Choose your Domain Type</h2>
			<div class="domain-inventory-domain-type switch-domain-type">
				<input type="radio" id="domain-type-budget" name="domain-type" value="Budget">
				<label for="domain-type-budget" class="show-tooltip" title="Budget domains are suitable for PBN, 301 Redirection and Money Site">Budget Domains</label>
				<input type="radio" id="domain-type-premium" name="domain-type" value="Premium">
				<label for="domain-type-premium" class="show-tooltip" title="Premium Domains are super powerful with high authority backlinks that will provide faster and better results.">Premium Domains</label>
			</div>
			<div class="domain-inventory-search-field">
				<input type="text" name="domain-search" id="domain-search" placeholder="Search Domain ID / Domain Name / Keyword / Niche" value="">
				<button class="fire-domain-keyword-search">SEARCH</button>
			</div>
		</div>
    </div>
</div>

<?php get_footer() ?>
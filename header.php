<?php
/**
 * The header for Astra Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
if ( apply_filters( 'astra_header_profile_gmpg_link', true ) ) {
	?>
	 <link rel="profile" href="https://gmpg.org/xfn/11"> 
	 <?php
} 
?>
<?php wp_head(); ?>
<?php astra_head_bottom(); ?>
<script src="https://kit.fontawesome.com/cbc1e52f7c.js" crossorigin="anonymous"></script>
<script>
	jQuery(document).ready(function($) {
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
	})
</script>
</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>
<?php astra_body_top(); ?>
<?php wp_body_open(); ?>

<a
	class="skip-link screen-reader-text"
	href="#content"
	role="link"
	title="<?php echo esc_attr( astra_default_strings( 'string-header-skip-link', false ) ); ?>">
		<?php echo esc_html( astra_default_strings( 'string-header-skip-link', false ) ); ?>
</a>

<div
<?php
	echo astra_attr(
		'site',
		array(
			'id'    => 'page',
			'class' => 'hfeed site',
		)
	);
	?>
>
	<?php
	astra_header_before();

	astra_header();

	astra_header_after();

	astra_content_before();
	?>
	<div id="content" class="site-content">
		<div class="ast-container">
		<?php astra_content_top(); ?>

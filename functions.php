<?php
/**
 * Funk Martivi functions and definitions.
 * @link   https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Martivi Child
 */

add_action( 'wp_enqueue_scripts', 'martivi_child_enqueue_scripts', 20 );

function martivi_child_enqueue_scripts() {
    wp_enqueue_style( 'martivi-child', get_stylesheet_uri() );
}

add_filter('woocommerce_variable_price_html', 'single_variation_price', 10, 2); 

function single_variation_price( $price, $product ) { 
     $price = '';
     $price .= wc_price($product->get_price()); 
     return $price;
}

// HIDE TABS FROM THE ONE THAT IS BELOW THE SUMMARY
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');

// INCLUDE TABS JUST BELOW THE PRODUCT SUMMARY
add_action( 'woocommerce_single_product_summary', 'funk_product_attributes', 25 );


function funk_product_attributes(){
	global $product;
	$length = $product->get_attribute( 'length' );
	echo $length;
}

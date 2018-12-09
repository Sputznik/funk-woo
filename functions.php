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

//redo
function funk_product_attributes(){
	global $product;
  $product_cat = $product->get_category_ids();
  if ($product_cat[0] == 15 || $product_cat[0] == 18) {
	$length = $product->get_attribute( 'length' );
	$weight = $product->get_attribute( 'weight' );
  ?>
    <div class="row wc-length-weight">
      <div class="col-sm-2">Length</div>
      <div class="col-sm-10">
        <ul>
          <?php
            for ($i=0;$i < 5;$i++) {
              if ($i < $length) {
              ?>
                <li class="full-circle"></li>
              <?php
              } else {
                ?>
                  <li class="empty-circle"></li>
                <?php
              }
            }
          ?>
        </ul>
      </div>
      <div class="col-sm-2">Weight</div>
      <div class="col-sm-10">
        <ul>
          <?php
            for ($i=0;$i < 5;$i++) {
              if ($i < $weight) {
              ?>
                <li class="full-circle"></li>
              <?php
              } else {
                ?>
                  <li class="empty-circle"></li>
                <?php
              }
            }
          ?>
        </ul>
      </div>
    </div>
  <?php
  }
}
//overriding homepage function for recent products
if ( ! function_exists( 'martivi_recent_products' ) ) {
	/**
	 * Display Recent Products
	 * Hooked into the `martivi-homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function martivi_recent_products( $args ) {

		if ( martivi_is_woocommerce_activated() ) {

			global $post;

			// get post meta data
			$box_title 	= get_post_meta( $post->ID, 'martivi_recent_products_box_title', true );
			$box_desc 	= get_post_meta( $post->ID, 'martivi_recent_products_box_desc', true );

			$args = array(
				'limit' 			=> 8,
				'columns' 			=> 4
			);

			echo '<div class="container">';

			echo '<div class="box-title">';

				echo '<h3>' . wp_kses_post( $box_title ) . '</h3>';
				echo '<p>' . wp_kses_post( $box_desc ) . '</p>';

			echo '</div>';

			echo martivi_do_shortcode( 'recent_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );


			?>
				<div class="row">
					<div class="col-sm-12" style="text-align:center">
            <a href="https://funkanatomy.com/shop">
						<button class="funk-button-pink" type="button">
							I Want To See More!
						</button>
            </a>
					</div>
				</div>

			<?php

			echo '</div>';
		}
	}
}
//overriding tab products function

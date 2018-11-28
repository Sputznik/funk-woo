<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.2
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

// get theme customizer data
$shop_single = get_option( 'martivi_shop_single' );

$thumb_col_classes = 'product-slider';

$attachment_ids = $product->get_gallery_image_ids();

if ( $shop_single['thumbs-pos'] === 'vertical' ) {
	$thumb_col_classes .= ' vertical-carousel col-lg-2 col-md-3 col-sm-3 col-xs-3';
}

if ( $attachment_ids && has_post_thumbnail() ) {
	?>

	<div class="<?php echo esc_html( $thumb_col_classes ); ?>">
		<div id="carousel" class="thumbnail owl-carousel">

			<?php

				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
					$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
					$image_title     = get_post_field( 'post_excerpt', $attachment_id );

					$attributes = array(
						'title'                   => $image_title,
						'data-src'                => $full_size_image[0],
						'data-large_image'        => $full_size_image[0],
						'data-large_image_width'  => $full_size_image[1],
						'data-large_image_height' => $full_size_image[2],
					);


					$html  = '<li class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_thumbnail', false, $attributes );
			 		$html .= '</a></li>';

					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
				}
			?>
		</div>
	</div>
	
<?php } ?>

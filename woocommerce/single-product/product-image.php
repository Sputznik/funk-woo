<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

// get theme customizer data
$shop_single = get_option( 'martivi_shop_single' );

$slider_col_classes = 'product-slider';

$attachment_ids = $product->get_gallery_image_ids();

if ( $shop_single['thumbs-pos'] === 'vertical' ) {

	$slider_col_classes .= ' vertical-slider col-lg-10 col-md-9 col-sm-9 col-xs-9';

	echo '<div class="row">';

	do_action( 'woocommerce_product_thumbnails' );
}

?>
<div class="<?php echo esc_html( $slider_col_classes ); ?>">
<div id="slider" class="images owl-carousel">
	<?php
		if ( has_post_thumbnail() ) {
			$attachment_count = count( $attachment_ids );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			if ( $attachment_count > 0 ) {
				foreach ( $attachment_ids as $attachment_id ) {

					$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
					$img_sizes = $full_size_image[1]. 'x' .$full_size_image[2];

					$image_title    = get_post_field( 'post_excerpt', $attachment_id );
					$image_caption 	= get_post( $attachment_id )->post_excerpt;
					$image_link  	= $full_size_image[0];
					$image       	= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
							'title'	=> $image_title,
							'alt'	=> $image_title
							) );

					echo apply_filters(
							'woocommerce_single_product_image_thumbnail_html',
							sprintf(
								'<a href="%s" itemprop="image" class="martivi-product-image-link" title="%s" data-size="%s">%s</a>',
								esc_url( $image_link ),
								esc_attr( $image_caption ),
								esc_attr( $img_sizes ),
								$image
							),
							$post->ID
						);

				}
			} else {
				$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
				$full_size_image = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				$img_sizes = $full_size_image[1] . 'x' . $full_size_image[2];
				$image_title = get_post_field( 'post_excerpt', $post_thumbnail_id );
				$attributes = array(
					'title' => $image_title
				);
				
				$image = get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );

				echo apply_filters(
							'woocommerce_single_product_image_thumbnail_html',
							sprintf(
								'<a href="%s" itemprop="image" class="martivi-product-image-link" title="%s" data-size="%s">%s</a>',
								esc_url( $full_size_image[0] ),
								esc_attr( $image_title ),
								esc_attr( $img_sizes ),
								$image
							),
							$post->ID
						);
			}

		} else {
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Awaiting product image', 'martivi' ) ), $post->ID );
		}
	?>
</div>
</div>

<?php 
	if ( $shop_single['thumbs-pos'] === 'horizontal' ) {
		do_action( 'woocommerce_product_thumbnails' );
	}

	if ( $shop_single['thumbs-pos'] === 'vertical' ) {
		echo '</div>';
	}

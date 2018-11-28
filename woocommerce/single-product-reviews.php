<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
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
 * @version     3.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! comments_open() ) {
	return;
}

?>

<div id="reviews" class="woocommerce-Reviews">
<div class="row">
<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 woocommerce-comments">
	<div id="comments">

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'martivi' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? __( 'Add a review', 'martivi' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'martivi' ), get_the_title() ),
						'title_reply_to'       => __( 'Leave a Reply to %s', 'martivi' ),
						'comment_notes_after'  => '',
						'fields'               => array(
							'comment_form_before' => '<div class="row">',

							'author' => '<p class="comment-form-author col-lg-6">
											<input id="author" name="author" type="text" placeholder="' . __( 'Name', 'martivi' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required />
										</p>',

							'email'  => '<p class="comment-form-email col-lg-6">
											<input id="email" name="email" type="email" placeholder="'. __( 'Email', 'martivi' ) .'" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required />
										</p>',

							'comment_field' => '<p class="comment-form-comment col-lg-12">
													<textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . __( 'Your Review', 'martivi' ) . '"
														aria-required="true" required></textarea>
												</p>',
							'comment_form_after' => '</div>'
						),
						'label_submit'  => __( 'Submit', 'martivi' ),
						'logged_in_as'  => ''
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'martivi' ), esc_url( $account_page_url ) ) . '</p>';
					}

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'martivi' ) .'</label><select name="rating" id="rating" aria-required="true" required>
							<option value="">' . __( 'Rate&hellip;', 'martivi' ) . '</option>
							<option value="5">' . __( 'Perfect', 'martivi' ) . '</option>
							<option value="4">' . __( 'Good', 'martivi' ) . '</option>
							<option value="3">' . __( 'Average', 'martivi' ) . '</option>
							<option value="2">' . __( 'Not that bad', 'martivi' ) . '</option>
							<option value="1">' . __( 'Very Poor', 'martivi' ) . '</option>
						</select></p>';

						if ( is_user_logged_in()  ) {
							$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'martivi' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';
						}
					}

					

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'martivi' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>

	</div>
</div>
</div>

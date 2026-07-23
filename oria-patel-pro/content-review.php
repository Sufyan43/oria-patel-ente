<?php
/**
 * Template Part: Review Card
 * Used in page-reviews.php and the reviews archive.
 */
$post_id  = get_the_ID();
$rating   = (int) get_post_meta( $post_id, '_oria_star_rating', true );
$name     = get_post_meta( $post_id, '_oria_reviewer_name', true )    ?: get_the_title();
$company  = get_post_meta( $post_id, '_oria_reviewer_company', true ) ?: '';
$country  = get_post_meta( $post_id, '_oria_reviewer_country', true ) ?: '';
$verified = get_post_meta( $post_id, '_oria_verified_purchase', true );
$product  = (int) get_post_meta( $post_id, '_oria_product_reviewed', true );
$photo_id = (int) get_post_meta( $post_id, '_oria_reviewer_photo', true );
$date_raw = get_post_meta( $post_id, '_oria_review_date', true ) ?: get_the_date( 'Y-m-d' );
$date_fmt = $date_raw ? date_i18n( get_option( 'date_format' ), strtotime( $date_raw ) ) : '';
$content  = get_the_content();
$excerpt  = wp_trim_words( wp_strip_all_tags( $content ), 35, null );
$is_long  = str_word_count( wp_strip_all_tags( $content ) ) > 35;
$initials = oria_reviewer_initials( $name );

// Schema.org Review markup
$schema = [
	'@context'     => 'https://schema.org',
	'@type'        => 'Review',
	'reviewRating' => [ '@type' => 'Rating', 'ratingValue' => $rating, 'bestRating' => 5, 'worstRating' => 1 ],
	'author'       => [ '@type' => 'Person', 'name' => $name ],
	'reviewBody'   => wp_strip_all_tags( $content ),
	'datePublished'=> $date_raw,
	'itemReviewed' => [
		'@type' => 'Organization',
		'name'  => get_bloginfo( 'name' ),
		'url'   => home_url( '/' ),
	],
];
if ( $product ) {
	$schema['itemReviewed'] = [ '@type' => 'Product', 'name' => get_the_title( $product ) ];
}
?>
<div class="oria-review-card">
	<script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>

	<!-- Header: stars + badges -->
	<div class="oria-review-card__header">
		<?php echo oria_render_stars( $rating ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<?php if ( '1' === $verified ) : ?>
			<span class="oria-badge oria-badge--verified"><?php esc_html_e( '✔ Verified Purchase', 'oria-patel' ); ?></span>
		<?php endif; ?>
	</div>

	<!-- Title -->
	<h3 class="oria-review-card__title"><?php echo esc_html( get_the_title() ); ?></h3>

	<!-- Content with read-more toggle -->
	<div class="oria-review-card__content">
		<p class="oria-review-card__excerpt"><?php echo esc_html( $excerpt ); ?><?php echo $is_long ? '<span class="oria-review-card__ellipsis">…</span>' : ''; ?></p>
		<?php if ( $is_long ) : ?>
			<div class="oria-review-card__full" hidden><?php echo wp_kses_post( $content ); ?></div>
			<button class="oria-review-card__toggle" aria-expanded="false"><?php esc_html_e( 'Read more', 'oria-patel' ); ?></button>
		<?php endif; ?>
	</div>

	<!-- Product link -->
	<?php if ( $product ) : ?>
	<p class="oria-review-card__product">
		<?php esc_html_e( 'Product:', 'oria-patel' ); ?>
		<a href="<?php echo esc_url( get_permalink( $product ) ); ?>"><?php echo esc_html( get_the_title( $product ) ); ?></a>
	</p>
	<?php endif; ?>

	<!-- Reviewer info -->
	<div class="oria-review-card__footer">
		<div class="oria-reviewer">
			<?php if ( $photo_id ) : ?>
				<img src="<?php echo esc_url( wp_get_attachment_image_url( $photo_id, [ 48, 48 ] ) ); ?>"
				     alt="<?php echo esc_attr( $name ); ?>"
				     class="oria-reviewer__avatar"
				     width="48" height="48" loading="lazy">
			<?php else : ?>
				<div class="oria-reviewer__initials" aria-hidden="true"><?php echo esc_html( $initials ); ?></div>
			<?php endif; ?>
			<div class="oria-reviewer__info">
				<strong class="oria-reviewer__name"><?php echo esc_html( $name ); ?></strong>
				<span class="oria-reviewer__meta">
					<?php echo esc_html( implode( ' · ', array_filter( [ $company, $country ] ) ) ); ?>
				</span>
			</div>
		</div>
		<?php if ( $date_fmt ) : ?>
			<time class="oria-review-card__date" datetime="<?php echo esc_attr( $date_raw ); ?>"><?php echo esc_html( $date_fmt ); ?></time>
		<?php endif; ?>
	</div>
</div>

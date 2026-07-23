<?php
/**
 * Archive template for the oria_review CPT — served at /reviews/
 *
 * WordPress routes the CPT archive here (has_archive => 'reviews') so this file
 * is the true entry-point for /reviews/. The page-reviews.php "Reviews Page"
 * template still works if an admin assigns it to a static page, but this file
 * is what visitors see at the canonical URL.
 */
get_header(); ?>

<div class="op-page-header">
	<div class="op-container">
		<?php oria_breadcrumb_html(); ?>
		<h1 class="op-page-header__title"><?php esc_html_e( 'Customer Reviews &amp; Testimonials', 'oria-patel' ); ?></h1>
		<p class="op-page-header__sub"><?php esc_html_e( 'Real feedback from global buyers of custom sports uniforms, boxing gloves, and apparel from Sialkot, Pakistan.', 'oria-patel' ); ?></p>
	</div>
</div>

<div class="op-container op-section">

	<?php
	/* ── Average rating summary ────────────────────────────────────── */
	$avg_rating  = oria_get_average_rating();
	$total_count = oria_get_review_count();
	if ( $total_count > 0 ) :
		?>
	<div class="oria-rating-summary">
		<div class="oria-rating-summary__score"><?php echo esc_html( number_format( $avg_rating, 1 ) ); ?></div>
		<div class="oria-rating-summary__detail">
			<?php echo oria_render_stars( (int) round( $avg_rating ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<p class="oria-rating-summary__meta">
				<?php printf(
					/* translators: 1: average rating, 2: review count */
					esc_html__( '%1$s out of 5 stars based on %2$s reviews', 'oria-patel' ),
					'<strong>' . esc_html( number_format( $avg_rating, 1 ) ) . '</strong>',
					'<strong>' . esc_html( number_format( $total_count ) ) . '</strong>'
				); ?>
			</p>
		</div>
	</div>
	<?php endif; ?>

	<?php
	/* ── Filter + Sort controls ────────────────────────────────────── */
	$filter_rating = isset( $_GET['rating'] ) ? absint( $_GET['rating'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification
	$sort          = isset( $_GET['sort'] ) ? sanitize_key( $_GET['sort'] ) : 'newest'; // phpcs:ignore WordPress.Security.NonceVerification
	$base_url      = get_post_type_archive_link( 'oria_review' ) ?: home_url( '/reviews/' );
	?>

	<div class="oria-reviews-controls">
		<div class="oria-reviews-filters">
			<span class="oria-reviews-filters__label"><?php esc_html_e( 'Filter:', 'oria-patel' ); ?></span>
			<?php
			$filter_options = [ 0 => __( 'All', 'oria-patel' ), 5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★' ];
			foreach ( $filter_options as $val => $label ) :
				$active = ( $filter_rating === $val );
				$href   = $val ? add_query_arg( 'rating', $val, $base_url ) : $base_url;
			?>
			<a href="<?php echo esc_url( $href ); ?>"
			   class="oria-filter-btn<?php echo $active ? ' is-active' : ''; ?>">
				<?php echo esc_html( $label ); ?>
			</a>
			<?php endforeach; ?>
		</div>

		<div class="oria-reviews-sort">
			<label for="oria-sort-select" class="screen-reader-text"><?php esc_html_e( 'Sort reviews', 'oria-patel' ); ?></label>
			<select id="oria-sort-select" class="op-sort-select" onchange="window.location=this.value">
				<?php
				$sort_opts = [
					'newest'  => [ 'label' => __( 'Newest First',   'oria-patel' ), 'url' => add_query_arg( 'sort', 'newest',  $filter_rating ? add_query_arg( 'rating', $filter_rating, $base_url ) : $base_url ) ],
					'highest' => [ 'label' => __( 'Highest Rated',  'oria-patel' ), 'url' => add_query_arg( 'sort', 'highest', $filter_rating ? add_query_arg( 'rating', $filter_rating, $base_url ) : $base_url ) ],
					'lowest'  => [ 'label' => __( 'Lowest Rated',   'oria-patel' ), 'url' => add_query_arg( 'sort', 'lowest',  $filter_rating ? add_query_arg( 'rating', $filter_rating, $base_url ) : $base_url ) ],
				];
				foreach ( $sort_opts as $key => $opt ) :
				?>
				<option value="<?php echo esc_url( $opt['url'] ); ?>" <?php selected( $sort, $key ); ?>>
					<?php echo esc_html( $opt['label'] ); ?>
				</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<?php
	/* ── Query reviews ─────────────────────────────────────────────── */
	$meta_query = [];
	if ( $filter_rating ) {
		$meta_query[] = [
			'key'     => '_oria_star_rating',
			'value'   => $filter_rating,
			'compare' => '=',
			'type'    => 'NUMERIC',
		];
	}

	$orderby  = 'date';
	$order    = 'DESC';
	$meta_key = '';
	if ( 'highest' === $sort ) { $orderby = 'meta_value_num'; $meta_key = '_oria_star_rating'; $order = 'DESC'; }
	if ( 'lowest'  === $sort ) { $orderby = 'meta_value_num'; $meta_key = '_oria_star_rating'; $order = 'ASC';  }

	$paged      = get_query_var( 'paged' ) ?: 1;
	$query_args = [
		'post_type'      => 'oria_review',
		'post_status'    => 'publish',
		'posts_per_page' => 10,
		'paged'          => $paged,
		'orderby'        => $orderby,
		'order'          => $order,
	];
	if ( ! empty( $meta_query ) ) {
		$query_args['meta_query'] = $meta_query;
	}
	if ( $meta_key ) {
		$query_args['meta_key'] = $meta_key;
	}
	$reviews_query = new WP_Query( $query_args );
	?>

	<?php if ( $reviews_query->have_posts() ) : ?>

		<div class="oria-reviews-grid">
			<?php while ( $reviews_query->have_posts() ) : $reviews_query->the_post(); ?>
				<?php get_template_part( 'content', 'review' ); ?>
			<?php endwhile; ?>
		</div>

		<?php
		echo paginate_links( [
			'total'     => $reviews_query->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 2,
			'prev_text' => '&larr; ' . __( 'Previous', 'oria-patel' ),
			'next_text' => __( 'Next', 'oria-patel' ) . ' &rarr;',
		] );
		wp_reset_postdata();
		?>

	<?php else : ?>
		<div style="text-align:center;padding:60px 0">
			<p style="font-size:48px;margin:0">⭐</p>
			<h2 style="margin:16px 0 8px"><?php esc_html_e( 'No reviews yet', 'oria-patel' ); ?></h2>
			<p style="color:#565959"><?php esc_html_e( 'Be the first to share your experience.', 'oria-patel' ); ?></p>
		</div>
	<?php endif; ?>

	<?php /* ── Submit your review ──────────────────────────────────────── */ ?>
	<div class="oria-review-form-section">
		<h2 class="oria-review-form-section__title"><?php esc_html_e( 'Leave a Review', 'oria-patel' ); ?></h2>
		<p style="color:#565959;margin-bottom:24px"><?php esc_html_e( 'Your review will be published after moderation.', 'oria-patel' ); ?></p>
		<?php echo do_shortcode( '[oria_review_form]' ); ?>
	</div>

</div>

<?php get_footer(); ?>

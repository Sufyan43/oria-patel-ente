<?php
/**
 * Review Functions — Oria Patel Theme
 * CPT registration, meta boxes, frontend form, shortcodes.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ══════════════════════════════════════════════════════════════════════════
   1. REGISTER CPT: oria_review
══════════════════════════════════════════════════════════════════════════ */
add_action( 'init', 'oria_register_reviews_cpt' );
function oria_register_reviews_cpt(): void {
	register_post_type( 'oria_review', [
		'labels'        => [
			'name'               => __( 'Reviews', 'oria-patel' ),
			'singular_name'      => __( 'Review', 'oria-patel' ),
			'add_new'            => __( 'Add Review', 'oria-patel' ),
			'add_new_item'       => __( 'Add New Review', 'oria-patel' ),
			'edit_item'          => __( 'Edit Review', 'oria-patel' ),
			'new_item'           => __( 'New Review', 'oria-patel' ),
			'view_item'          => __( 'View Review', 'oria-patel' ),
			'all_items'          => __( 'All Reviews', 'oria-patel' ),
			'search_items'       => __( 'Search Reviews', 'oria-patel' ),
			'not_found'          => __( 'No reviews found.', 'oria-patel' ),
			'not_found_in_trash' => __( 'No reviews found in Trash.', 'oria-patel' ),
		],
		'public'        => true,
		'has_archive'   => 'reviews',
		'rewrite'       => [ 'slug' => 'reviews', 'with_front' => false ],
		'supports'      => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
		'menu_icon'     => 'dashicons-star-filled',
		'show_in_rest'  => false,
		'menu_position' => 25,
	] );
}

/* ══════════════════════════════════════════════════════════════════════════
   2. META BOX — Review Fields
══════════════════════════════════════════════════════════════════════════ */
add_action( 'add_meta_boxes', 'oria_review_meta_boxes' );
function oria_review_meta_boxes(): void {
	add_meta_box(
		'oria_review_details',
		__( 'Review Details', 'oria-patel' ),
		'oria_review_meta_box_html',
		'oria_review',
		'normal',
		'high'
	);
}

function oria_review_meta_box_html( WP_Post $post ): void {
	wp_nonce_field( 'oria_save_review_meta', 'oria_review_nonce' );

	$fields = [
		'_oria_reviewer_name'    => [ 'label' => 'Reviewer Name',    'type' => 'text'     ],
		'_oria_reviewer_email'   => [ 'label' => 'Reviewer Email',   'type' => 'email'    ],
		'_oria_reviewer_company' => [ 'label' => 'Company',          'type' => 'text'     ],
		'_oria_reviewer_country' => [ 'label' => 'Country',          'type' => 'text'     ],
		'_oria_star_rating'      => [ 'label' => 'Star Rating (1–5)','type' => 'number'   ],
		'_oria_review_date'      => [ 'label' => 'Review Date',      'type' => 'date'     ],
	];

	echo '<table class="form-table">';
	foreach ( $fields as $key => $f ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<tr><th><label for="' . esc_attr( $key ) . '">' . esc_html( $f['label'] ) . '</label></th>';
		echo '<td><input type="' . esc_attr( $f['type'] ) . '" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" class="regular-text"';
		if ( $f['type'] === 'number' ) echo ' min="1" max="5"';
		echo '></td></tr>';
	}

	// Product reviewed — dropdown of all opm_product posts
	$product_val = get_post_meta( $post->ID, '_oria_product_reviewed', true );
	$products    = get_posts( [ 'post_type' => 'opm_product', 'numberposts' => -1, 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ] );
	echo '<tr><th><label for="_oria_product_reviewed">' . esc_html__( 'Product Reviewed', 'oria-patel' ) . '</label></th><td>';
	echo '<select name="_oria_product_reviewed" id="_oria_product_reviewed"><option value="">' . esc_html__( '— Select product —', 'oria-patel' ) . '</option>';
	foreach ( $products as $p ) {
		echo '<option value="' . esc_attr( $p->ID ) . '"' . selected( $product_val, $p->ID, false ) . '>' . esc_html( $p->post_title ) . '</option>';
	}
	echo '</select></td></tr>';

	// Verified purchase
	$verified = get_post_meta( $post->ID, '_oria_verified_purchase', true );
	echo '<tr><th>' . esc_html__( 'Verified Purchase', 'oria-patel' ) . '</th><td>';
	echo '<label><input type="checkbox" name="_oria_verified_purchase" value="1" ' . checked( $verified, '1', false ) . '> ' . esc_html__( 'Yes, verified purchase', 'oria-patel' ) . '</label></td></tr>';

	// Reviewer photo (attachment ID)
	$photo_id = get_post_meta( $post->ID, '_oria_reviewer_photo', true );
	echo '<tr><th><label for="_oria_reviewer_photo">' . esc_html__( 'Reviewer Photo (Attachment ID)', 'oria-patel' ) . '</label></th>';
	echo '<td><input type="number" name="_oria_reviewer_photo" id="_oria_reviewer_photo" value="' . esc_attr( $photo_id ) . '" class="small-text"></td></tr>';

	echo '</table>';
}

add_action( 'save_post_oria_review', 'oria_save_review_meta' );
function oria_save_review_meta( int $post_id ): void {
	if ( ! isset( $_POST['oria_review_nonce'] ) ) return;
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['oria_review_nonce'] ) ), 'oria_save_review_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$text_fields = [ '_oria_reviewer_name', '_oria_reviewer_company', '_oria_reviewer_country', '_oria_review_date' ];
	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	if ( isset( $_POST['_oria_reviewer_email'] ) ) {
		update_post_meta( $post_id, '_oria_reviewer_email', sanitize_email( wp_unslash( $_POST['_oria_reviewer_email'] ) ) );
	}
	if ( isset( $_POST['_oria_star_rating'] ) ) {
		$rating = max( 1, min( 5, absint( $_POST['_oria_star_rating'] ) ) );
		update_post_meta( $post_id, '_oria_star_rating', $rating );
	}
	if ( isset( $_POST['_oria_product_reviewed'] ) ) {
		update_post_meta( $post_id, '_oria_product_reviewed', absint( $_POST['_oria_product_reviewed'] ) );
	}
	if ( isset( $_POST['_oria_reviewer_photo'] ) ) {
		update_post_meta( $post_id, '_oria_reviewer_photo', absint( $_POST['_oria_reviewer_photo'] ) );
	}
	update_post_meta( $post_id, '_oria_verified_purchase', isset( $_POST['_oria_verified_purchase'] ) ? '1' : '0' );
}

/* ══════════════════════════════════════════════════════════════════════════
   3. HELPER FUNCTIONS
══════════════════════════════════════════════════════════════════════════ */
function oria_render_stars( int $rating, bool $show_empty = true ): string {
	$rating = max( 0, min( 5, $rating ) );
	$html   = '<span class="oria-stars" aria-label="' . esc_attr( sprintf( __( '%d out of 5 stars', 'oria-patel' ), $rating ) ) . '">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$html .= '<span class="oria-star ' . ( $i <= $rating ? 'oria-star--filled' : 'oria-star--empty' ) . '" aria-hidden="true">★</span>';
	}
	$html .= '</span>';
	return $html;
}

function oria_get_average_rating(): float {
	global $wpdb;
	$result = $wpdb->get_var(
		"SELECT AVG(CAST(meta_value AS DECIMAL(3,1)))
		 FROM {$wpdb->postmeta} pm
		 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
		 WHERE pm.meta_key = '_oria_star_rating'
		   AND p.post_type = 'oria_review'
		   AND p.post_status = 'publish'"
	);
	return $result ? (float) $result : 0.0;
}

function oria_get_review_count(): int {
	$q = new WP_Query( [
		'post_type'      => 'oria_review',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	] );
	return $q->found_posts;
}

function oria_reviewer_initials( string $name ): string {
	$parts = explode( ' ', trim( $name ) );
	$init  = strtoupper( substr( $parts[0], 0, 1 ) );
	if ( count( $parts ) > 1 ) $init .= strtoupper( substr( end( $parts ), 0, 1 ) );
	return $init;
}

/* ══════════════════════════════════════════════════════════════════════════
   4. FRONTEND REVIEW SUBMISSION FORM  —  shortcode: [oria_review_form]
══════════════════════════════════════════════════════════════════════════ */
add_shortcode( 'oria_review_form', 'oria_review_form_shortcode' );
function oria_review_form_shortcode(): string {
	ob_start();

	if ( isset( $_GET['review_sent'] ) && '1' === $_GET['review_sent'] ) { // phpcs:ignore WordPress.Security.NonceVerification
		echo '<div class="oria-alert oria-alert--success">';
		esc_html_e( 'Thank you! Your review is pending approval.', 'oria-patel' );
		echo '</div>';
		return ob_get_clean();
	}

	$products = get_posts( [
		'post_type'   => 'opm_product',
		'numberposts' => -1,
		'post_status' => 'publish',
		'orderby'     => 'title',
		'order'       => 'ASC',
	] );
	?>
	<form class="oria-review-form" method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php wp_nonce_field( 'oria_submit_review', 'oria_review_form_nonce' ); ?>
		<input type="hidden" name="action" value="oria_submit_review">
		<!-- Honeypot anti-spam field -->
		<div style="display:none" aria-hidden="true">
			<input type="text" name="oria_hp_field" tabindex="-1" autocomplete="off">
		</div>

		<div class="oria-form-grid">
			<div class="oria-form-group">
				<label for="orf_name"><?php esc_html_e( 'Your Name *', 'oria-patel' ); ?></label>
				<input type="text" id="orf_name" name="reviewer_name" required maxlength="100">
			</div>
			<div class="oria-form-group">
				<label for="orf_email"><?php esc_html_e( 'Email Address *', 'oria-patel' ); ?></label>
				<input type="email" id="orf_email" name="reviewer_email" required maxlength="200">
			</div>
			<div class="oria-form-group">
				<label for="orf_company"><?php esc_html_e( 'Company / Team', 'oria-patel' ); ?></label>
				<input type="text" id="orf_company" name="reviewer_company" maxlength="150">
			</div>
			<div class="oria-form-group">
				<label for="orf_country"><?php esc_html_e( 'Country', 'oria-patel' ); ?></label>
				<input type="text" id="orf_country" name="reviewer_country" maxlength="100">
			</div>
			<div class="oria-form-group oria-form-group--full">
				<label for="orf_product"><?php esc_html_e( 'Product Reviewed', 'oria-patel' ); ?></label>
				<select id="orf_product" name="product_reviewed">
					<option value=""><?php esc_html_e( '— Select a product (optional) —', 'oria-patel' ); ?></option>
					<?php foreach ( $products as $p ) : ?>
						<option value="<?php echo esc_attr( $p->ID ); ?>"><?php echo esc_html( $p->post_title ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="oria-form-group oria-form-group--full">
				<label><?php esc_html_e( 'Your Rating *', 'oria-patel' ); ?></label>
				<div class="oria-star-picker" role="radiogroup" aria-label="<?php esc_attr_e( 'Star rating', 'oria-patel' ); ?>">
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
					<label class="oria-star-pick" title="<?php echo esc_attr( $i ); ?> <?php esc_attr_e( 'stars', 'oria-patel' ); ?>">
						<input type="radio" name="star_rating" value="<?php echo esc_attr( $i ); ?>" required>
						<span>★</span>
					</label>
					<?php endfor; ?>
				</div>
			</div>
			<div class="oria-form-group">
				<label for="orf_title"><?php esc_html_e( 'Review Title *', 'oria-patel' ); ?></label>
				<input type="text" id="orf_title" name="review_title" required maxlength="200">
			</div>
			<div class="oria-form-group oria-form-group--full">
				<label for="orf_content"><?php esc_html_e( 'Your Review *', 'oria-patel' ); ?></label>
				<textarea id="orf_content" name="review_content" rows="6" required maxlength="2000"></textarea>
			</div>
			<div class="oria-form-group oria-form-group--full">
				<label for="orf_photo"><?php esc_html_e( 'Your Photo (optional)', 'oria-patel' ); ?></label>
				<input type="file" id="orf_photo" name="reviewer_photo" accept="image/jpeg,image/png,image/webp">
			</div>
			<div class="oria-form-group oria-form-group--full">
				<label class="oria-checkbox-label">
					<input type="checkbox" name="confirm_genuine" value="1" required>
					<?php esc_html_e( 'I confirm this is a genuine review based on my experience.', 'oria-patel' ); ?>
				</label>
			</div>
		</div>

		<button type="submit" class="op-btn op-btn--primary" style="margin-top:8px">
			<?php esc_html_e( 'Submit Your Review', 'oria-patel' ); ?>
		</button>
	</form>
	<?php
	return ob_get_clean();
}

/* ══════════════════════════════════════════════════════════════════════════
   5. FORM SUBMISSION HANDLER
══════════════════════════════════════════════════════════════════════════ */
add_action( 'admin_post_nopriv_oria_submit_review', 'oria_handle_review_submission' );
add_action( 'admin_post_oria_submit_review',        'oria_handle_review_submission' );
function oria_handle_review_submission(): void {
	// Verify nonce
	if ( ! isset( $_POST['oria_review_form_nonce'] ) ||
		 ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['oria_review_form_nonce'] ) ), 'oria_submit_review' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'oria-patel' ) );
	}

	// Honeypot check — bots fill hidden fields
	if ( ! empty( $_POST['oria_hp_field'] ) ) {
		wp_die( esc_html__( 'Spam detected.', 'oria-patel' ) );
	}

	// Sanitize inputs
	$name    = sanitize_text_field( wp_unslash( $_POST['reviewer_name']    ?? '' ) );
	$email   = sanitize_email(      wp_unslash( $_POST['reviewer_email']   ?? '' ) );
	$company = sanitize_text_field( wp_unslash( $_POST['reviewer_company'] ?? '' ) );
	$country = sanitize_text_field( wp_unslash( $_POST['reviewer_country'] ?? '' ) );
	$product = absint(                           $_POST['product_reviewed'] ?? 0  );
	$rating  = max( 1, min( 5, absint(           $_POST['star_rating']     ?? 1  ) ) );
	$title   = sanitize_text_field( wp_unslash( $_POST['review_title']     ?? '' ) );
	$content = sanitize_textarea_field( wp_unslash( $_POST['review_content'] ?? '' ) );

	if ( ! $name || ! is_email( $email ) || ! $title || ! $content ) {
		wp_die( esc_html__( 'Please fill in all required fields.', 'oria-patel' ) );
	}

	// Insert as pending
	$post_id = wp_insert_post( [
		'post_type'    => 'oria_review',
		'post_title'   => $title,
		'post_content' => $content,
		'post_status'  => 'pending',
		'post_author'  => 0,
	] );

	if ( is_wp_error( $post_id ) ) {
		wp_die( esc_html__( 'Could not save your review. Please try again.', 'oria-patel' ) );
	}

	update_post_meta( $post_id, '_oria_reviewer_name',    $name );
	update_post_meta( $post_id, '_oria_reviewer_email',   $email );
	update_post_meta( $post_id, '_oria_reviewer_company', $company );
	update_post_meta( $post_id, '_oria_reviewer_country', $country );
	update_post_meta( $post_id, '_oria_star_rating',      $rating );
	update_post_meta( $post_id, '_oria_product_reviewed', $product );
	update_post_meta( $post_id, '_oria_review_date',      gmdate( 'Y-m-d' ) );
	update_post_meta( $post_id, '_oria_verified_purchase','0' );

	// Handle photo upload — server-side MIME validation (client accept= is bypassable).
	if ( ! empty( $_FILES['reviewer_photo']['name'] ) ) {
		$allowed_mime_types = [ 'image/jpeg', 'image/png', 'image/webp', 'image/gif' ];
		// Use wp_check_filetype on the original filename before trusting anything.
		$file_info = wp_check_filetype( sanitize_file_name( $_FILES['reviewer_photo']['name'] ) );
		if ( empty( $file_info['type'] ) || ! in_array( $file_info['type'], $allowed_mime_types, true ) ) {
			// Skip the upload silently — the review itself is still saved.
			// (We do NOT wp_die here so the review text is not lost.)
		} else {
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
			$attach_id = media_handle_upload( 'reviewer_photo', $post_id );
			if ( ! is_wp_error( $attach_id ) ) {
				update_post_meta( $post_id, '_oria_reviewer_photo', $attach_id );
			}
		}
	}

	// Notify admin
	$admin_email = get_option( 'admin_email' );
	wp_mail(
		$admin_email,
		sprintf( __( 'New review pending: %s', 'oria-patel' ), $title ),
		sprintf(
			"Reviewer: %s (%s)\nRating: %d/5\nProduct: %s\n\nContent:\n%s\n\nApprove: %s",
			$name, $email, $rating,
			$product ? get_the_title( $product ) : 'N/A',
			$content,
			admin_url( 'edit.php?post_type=oria_review&post_status=pending' )
		)
	);

	// Redirect back to reviews page with success flag
	$redirect = get_post_type_archive_link( 'oria_review' ) ?: home_url( '/reviews/' );
	wp_safe_redirect( add_query_arg( 'review_sent', '1', $redirect ) );
	exit;
}

/* ══════════════════════════════════════════════════════════════════════════
   6. SHORTCODE: [oria_reviews_widget count="3"]
══════════════════════════════════════════════════════════════════════════ */
add_shortcode( 'oria_reviews_widget', 'oria_reviews_widget_shortcode' );
function oria_reviews_widget_shortcode( array $atts ): string {
	$atts  = shortcode_atts( [ 'count' => 3 ], $atts, 'oria_reviews_widget' );
	$count = max( 1, absint( $atts['count'] ) );

	$reviews = new WP_Query( [
		'post_type'      => 'oria_review',
		'post_status'    => 'publish',
		'posts_per_page' => $count,
		'orderby'        => 'date',
		'order'          => 'DESC',
	] );

	if ( ! $reviews->have_posts() ) return '';

	ob_start();
	echo '<div class="oria-reviews-widget">';
	while ( $reviews->have_posts() ) {
		$reviews->the_post();
		$rating    = (int) get_post_meta( get_the_ID(), '_oria_star_rating', true );
		$name      = get_post_meta( get_the_ID(), '_oria_reviewer_name', true );
		$product   = (int) get_post_meta( get_the_ID(), '_oria_product_reviewed', true );
		echo '<div class="oria-reviews-widget__item">';
		echo oria_render_stars( $rating ); // phpcs:ignore WordPress.Security.EscapeOutput
		echo '<p class="oria-reviews-widget__excerpt">' . esc_html( wp_trim_words( get_the_content(), 20, '…' ) ) . '</p>';
		echo '<p class="oria-reviews-widget__meta"><strong>' . esc_html( $name ?: get_the_title() ) . '</strong>';
		if ( $product ) {
			echo ' · <a href="' . esc_url( get_permalink( $product ) ) . '">' . esc_html( get_the_title( $product ) ) . '</a>';
		}
		echo '</p>';
		echo '</div>';
	}
	echo '</div>';
	wp_reset_postdata();
	return ob_get_clean();
}

/* ══════════════════════════════════════════════════════════════════════════
   7. ENQUEUE reviews.js on pages with the shortcode
══════════════════════════════════════════════════════════════════════════ */
add_action( 'wp_enqueue_scripts', function() {
	// Enqueue reviews.js wherever the shortcode might appear:
	// any page/post, the reviews archive, or the front page.
	// Using a broad condition is safer than a narrow one — the script is tiny.
	if ( is_singular() || is_front_page() || is_post_type_archive( 'oria_review' ) ) {
		wp_enqueue_script(
			'oria-reviews',
			OP_URI . '/assets/js/reviews.js',
			[],
			OP_VERSION,
			true
		);
	}
} );

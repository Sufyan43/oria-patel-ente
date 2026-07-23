<?php
/**
 * Product CRUD — handles saving / deleting opm_product posts.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Save (create or update) a product from POST data.
 */
function opm_save_product( array $data ): array {
	$post_id     = absint( $data['product_id']      ?? 0 );
	$title       = sanitize_text_field( $data['product_title']   ?? '' );
	$description = wp_kses_post(        $data['product_desc']    ?? '' );
	$excerpt     = sanitize_textarea_field( $data['product_excerpt'] ?? '' );
	$status      = in_array( $data['product_status'] ?? 'publish', [ 'publish', 'draft', 'private' ], true )
	               ? $data['product_status'] : 'publish';

	if ( ! $title ) {
		return [ 'success' => false, 'message' => 'Product name is required.' ];
	}

	$post_args = [
		'post_title'   => $title,
		'post_content' => $description,
		'post_excerpt' => $excerpt,
		'post_status'  => $status,
		'post_type'    => 'opm_product',
	];

	if ( $post_id ) {
		$post_args['ID'] = $post_id;
		$result          = wp_update_post( $post_args, true );
		$msg             = 'Product updated successfully!';
	} else {
		$result = wp_insert_post( $post_args, true );
		$msg    = 'Product added successfully!';
	}

	if ( is_wp_error( $result ) ) {
		return [ 'success' => false, 'message' => $result->get_error_message() ];
	}

	$product_id = (int) $result;

	// ── Featured image ────────────────────────────────────────────────
	$thumb_id = absint( $data['product_thumb_id'] ?? 0 );
	if ( $thumb_id ) {
		set_post_thumbnail( $product_id, $thumb_id );
	}

	// ── Gallery images ────────────────────────────────────────────────
	// Store under _product_image_gallery (same key the theme reads; matches WC convention so
	// products imported from WooCommerce also work without re-saving).
	$gallery_ids = array_filter( array_map( 'absint', explode( ',', $data['product_gallery_ids'] ?? '' ) ) );
	update_post_meta( $product_id, '_product_image_gallery', implode( ',', $gallery_ids ) );

	// ── Categories ───────────────────────────────────────────────────
	$cat_ids = array_filter( array_map( 'absint', (array) ( $data['product_categories'] ?? [] ) ) );
	wp_set_post_terms( $product_id, $cat_ids, 'opm_category' );

	// ── Custom meta fields ───────────────────────────────────────────
	$meta = [
		'_opm_specs'             => opm_sanitize_list( $data['product_specs']             ?? '' ),
		'_opm_sizes'             => opm_sanitize_list( $data['product_sizes']             ?? '' ),
		'_opm_colors'            => opm_sanitize_list( $data['product_colors']            ?? '' ),
		'_opm_custom_text_label' => sanitize_text_field( $data['product_custom_text_label'] ?? '' ),
		'_opm_moq'               => sanitize_text_field( $data['product_moq']               ?? '1' ),
		'_opm_lead_time'         => sanitize_text_field( $data['product_lead_time']          ?? '' ),
		'_opm_fabric'            => sanitize_text_field( $data['product_fabric']             ?? '' ),
		'_opm_printing'          => sanitize_text_field( $data['product_printing']           ?? '' ),
		'_opm_badge_text'        => sanitize_text_field( $data['product_badge']              ?? '' ),
	];

	foreach ( $meta as $key => $value ) {
		update_post_meta( $product_id, $key, $value );
	}

	return [ 'success' => true, 'message' => $msg, 'product_id' => $product_id ];
}

/**
 * Delete a product by post ID.
 */
function opm_delete_product( int $post_id ): array {
	$result = wp_delete_post( $post_id, true );
	if ( ! $result ) {
		return [ 'success' => false, 'message' => 'Could not delete the product.' ];
	}
	return [ 'success' => true, 'message' => 'Product deleted.' ];
}

/**
 * Get all products as WP_Post objects.
 */
function opm_get_products( array $args = [] ): array {
	$defaults = [
		'post_type'      => 'opm_product',
		'post_status'    => [ 'publish', 'draft', 'private' ],
		'posts_per_page' => -1, // show all products in admin list
		'orderby'        => 'date',
		'order'          => 'DESC',
	];
	return get_posts( array_merge( $defaults, $args ) );
}

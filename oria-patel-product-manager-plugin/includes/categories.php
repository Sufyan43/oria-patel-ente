<?php
/**
 * Category CRUD — handles saving / deleting product categories.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Save (create or update) a category from POST data.
 * Returns [ 'success' => bool, 'message' => string, 'term_id' => int|null ]
 */
function opm_save_category( array $data ): array {
	$name        = sanitize_text_field( $data['cat_name']        ?? '' );
	$slug        = sanitize_title(      $data['cat_slug']        ?? '' );
	$description = sanitize_textarea_field( $data['cat_description'] ?? '' );
	$parent_id   = absint(              $data['cat_parent']      ?? 0 );
	$image_id    = absint(              $data['cat_image_id']    ?? 0 );
	$term_id     = absint(              $data['cat_term_id']     ?? 0 );
	$taxonomy    = opm_category_taxonomy();

	if ( ! $name ) {
		return [ 'success' => false, 'message' => 'Category name is required.', 'term_id' => null ];
	}

	$args = [
		'description' => $description,
		'parent'      => $parent_id,
	];
	if ( $slug ) $args['slug'] = $slug;

	if ( $term_id ) {
		// Update existing — must include 'name' or the rename is silently ignored
		$args['name'] = $name;
		$result = wp_update_term( $term_id, $taxonomy, $args );
		if ( is_wp_error( $result ) ) {
			return [ 'success' => false, 'message' => $result->get_error_message(), 'term_id' => null ];
		}
		$saved_id = $term_id;
		$msg      = 'Category updated successfully!';
	} else {
		// Create new
		$result = wp_insert_term( $name, $taxonomy, $args );
		if ( is_wp_error( $result ) ) {
			return [ 'success' => false, 'message' => $result->get_error_message(), 'term_id' => null ];
		}
		$saved_id = $result['term_id'];
		$msg      = 'Category created successfully!';
	}

	// Save thumbnail
	if ( $image_id ) {
		update_term_meta( $saved_id, 'thumbnail_id', $image_id );
	}

	return [ 'success' => true, 'message' => $msg, 'term_id' => $saved_id ];
}

/**
 * Delete a category by term ID.
 */
function opm_delete_category( int $term_id ): array {
	$taxonomy = opm_category_taxonomy();
	$result   = wp_delete_term( $term_id, $taxonomy );
	if ( is_wp_error( $result ) ) {
		return [ 'success' => false, 'message' => $result->get_error_message() ];
	}
	return [ 'success' => true, 'message' => 'Category deleted.' ];
}

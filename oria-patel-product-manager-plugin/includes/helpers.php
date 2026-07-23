<?php
/**
 * Shared helper functions used across the plugin.
 * Uses opm_product CPT and opm_category taxonomy exclusively.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Return the taxonomy used for product categories.
 */
function opm_category_taxonomy(): string {
	return 'opm_category';
}

/**
 * Return the post type used for products.
 */
function opm_product_post_type(): string {
	return 'opm_product';
}

/**
 * Register the opm_product CPT and opm_category taxonomy.
 */
add_action( 'init', function () {
	register_post_type( 'opm_product', [
		'label'          => 'Products',
		'labels'         => [
			'name'          => 'Products',
			'singular_name' => 'Product',
			'add_new_item'  => 'Add New Product',
			'edit_item'     => 'Edit Product',
		],
		'public'         => true,
		'has_archive'    => true,
		'supports'       => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'menu_icon'      => 'dashicons-cart',
		'show_in_rest'   => true,
		'rewrite'        => [ 'slug' => 'products' ],
	] );

	register_taxonomy( 'opm_category', 'opm_product', [
		'label'        => 'Product Categories',
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => [ 'slug' => 'product-category' ],
	] );
} );

/**
 * Recursive helper — adds children of a given parent to the tree.
 */
function opm_build_category_tree( array $indexed, int $parent_id, int $depth, array &$tree, array &$added ): void {
	foreach ( $indexed as $term ) {
		if ( $term->parent !== $parent_id || isset( $added[ $term->term_id ] ) ) continue;
		$tree[]                  = [ 'term' => $term, 'depth' => $depth ];
		$added[ $term->term_id ] = true;
		opm_build_category_tree( $indexed, $term->term_id, $depth + 1, $tree, $added );
	}
}

/**
 * Get all product categories as a flat array with depth info.
 */
function opm_get_category_tree(): array {
	$terms = get_terms( [ 'taxonomy' => 'opm_category', 'hide_empty' => false, 'orderby' => 'name' ] );
	if ( is_wp_error( $terms ) || empty( $terms ) ) return [];

	$indexed = [];
	foreach ( $terms as $t ) $indexed[ $t->term_id ] = $t;

	$tree  = [];
	$added = [];
	opm_build_category_tree( $indexed, 0, 0, $tree, $added );
	return $tree;
}

/**
 * Admin notice helper.
 */
function opm_notice( string $message, string $type = 'success' ): void {
	echo '<div class="notice notice-' . esc_attr( $type ) . ' is-dismissible opm-notice"><p>' . wp_kses_post( $message ) . '</p></div>';
}

/**
 * Sanitise a comma-separated list of text values.
 */
function opm_sanitize_list( string $input ): string {
	$parts = array_map( 'sanitize_text_field', explode( ',', $input ) );
	return implode( ', ', array_filter( $parts ) );
}

<?php
/**
 * Registers admin menu pages and handles form submissions.
 */
defined( 'ABSPATH' ) || exit;

/* ── Enqueue admin assets ───────────────────────────────────────────────── */
add_action( 'admin_enqueue_scripts', function ( string $hook ) {
	if ( strpos( $hook, 'opm_' ) === false ) return;

	wp_enqueue_media(); // WordPress media library uploader

	wp_enqueue_style(
		'opm-admin',
		OPM_URI . 'admin/css/admin.css',
		[],
		OPM_VERSION
	);

	wp_enqueue_script(
		'opm-admin',
		OPM_URI . 'admin/js/admin.js',
		[ 'jquery', 'media-upload', 'thickbox' ],
		OPM_VERSION,
		true
	);

	wp_localize_script( 'opm-admin', 'opmData', [
		'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
		'nonce'     => wp_create_nonce( 'opm_nonce' ),
		'uploadTitle'   => 'Choose Image',
		'uploadButton'  => 'Use this image',
		'galleryTitle'  => 'Add to Gallery',
		'galleryButton' => 'Add selected images',
	] );
} );

/* ── Register menus ─────────────────────────────────────────────────────── */
add_action( 'admin_menu', function () {

	// Top-level menu
	add_menu_page(
		'Oria Patel Manager',
		'🎽 Oria Patel',
		'edit_posts',
		'opm_dashboard',
		'opm_page_dashboard',
		'dashicons-store',
		4
	);

	// Dashboard (same as top-level)
	add_submenu_page( 'opm_dashboard', 'Dashboard',      'Dashboard',         'edit_posts',   'opm_dashboard',    'opm_page_dashboard' );

	// Products
	add_submenu_page( 'opm_dashboard', 'All Products',   '📦 All Products',   'edit_posts',   'opm_products',     'opm_page_products' );
	add_submenu_page( 'opm_dashboard', 'Add Product',    '➕ Add New Product', 'edit_posts',   'opm_add_product',  'opm_page_add_product' );

	// Categories
	add_submenu_page( 'opm_dashboard', 'Categories',     '🗂️ Categories',      'manage_categories', 'opm_categories',    'opm_page_categories' );
	add_submenu_page( 'opm_dashboard', 'Add Category',   '➕ Add Category',    'manage_categories', 'opm_add_category',  'opm_page_add_category' );
} );

/* ── Page callbacks ─────────────────────────────────────────────────────── */

function opm_page_dashboard(): void {
	require_once OPM_DIR . 'admin/views/dashboard.php';
}

function opm_page_products(): void {
	// Handle delete action
	if ( isset( $_GET['action'], $_GET['product_id'], $_GET['_wpnonce'] )
		&& $_GET['action'] === 'delete'
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'opm_delete_product' ) ) {
		$result = opm_delete_product( absint( $_GET['product_id'] ) );
		add_action( 'opm_notices', fn() => opm_notice( $result['message'], $result['success'] ? 'success' : 'error' ) );
	}
	require_once OPM_DIR . 'admin/views/products-list.php';
}

function opm_page_add_product(): void {
	$result = null;
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['opm_product_nonce'] )
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['opm_product_nonce'] ) ), 'opm_save_product' ) ) {
		$result = opm_save_product( $_POST );
		if ( $result['success'] && empty( $_POST['product_id'] ) ) {
			// Redirect to edit the newly created product
			wp_safe_redirect( admin_url( 'admin.php?page=opm_add_product&product_id=' . $result['product_id'] . '&saved=1' ) );
			exit;
		}
	}
	require_once OPM_DIR . 'admin/views/add-product.php';
}

function opm_page_categories(): void {
	if ( isset( $_GET['action'], $_GET['term_id'], $_GET['_wpnonce'] )
		&& $_GET['action'] === 'delete'
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'opm_delete_category' ) ) {
		$result = opm_delete_category( absint( $_GET['term_id'] ) );
		add_action( 'opm_notices', fn() => opm_notice( $result['message'], $result['success'] ? 'success' : 'error' ) );
	}
	require_once OPM_DIR . 'admin/views/categories-list.php';
}

function opm_page_add_category(): void {
	$result = null;
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['opm_cat_nonce'] )
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['opm_cat_nonce'] ) ), 'opm_save_category' ) ) {
		$result = opm_save_category( $_POST );
	}
	require_once OPM_DIR . 'admin/views/add-category.php';
}

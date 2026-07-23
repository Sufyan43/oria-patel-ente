<?php
/**
 * Plugin Name:  Oria Patel — Product Manager
 * Plugin URI:   https://oriapatel.com
 * Description:  Automatically creates all pages (Home, About, Contact, Products), fixes permalinks, and gives you an easy dashboard to manage products and categories.
 * Version:      1.2.0
 * Author:       Oria Patel Enterprises
 * Author URI:   https://oriapatel.com
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * License:      GPL v2 or later
 * Text Domain:  opm
 */

defined( 'ABSPATH' ) || exit;

define( 'OPM_VERSION', '1.2.0' );
define( 'OPM_DIR',     plugin_dir_path( __FILE__ ) );
define( 'OPM_URI',     plugin_dir_url( __FILE__ ) );

/* ── Load sub-files ─────────────────────────────────────────────────────── */
require_once OPM_DIR . 'includes/helpers.php';
require_once OPM_DIR . 'includes/setup.php';
require_once OPM_DIR . 'includes/categories.php';
require_once OPM_DIR . 'includes/products.php';
require_once OPM_DIR . 'admin/admin-menus.php';

/* ── On activation: create pages + fix permalinks ───────────────────────── */
register_activation_hook( __FILE__, function () {
	opm_run_setup();
} );

<?php
/**
 * One-time setup: creates all required WordPress pages and configures
 * permalink structure on plugin activation.
 *
 * Pages created:
 *   • Home           → set as static front page
 *   • About          → /about/
 *   • Contact        → /contact/
 *   • Products       → /products/ (CPT archive — no WooCommerce)
 *   • Privacy Policy → /privacy-policy/
 */
defined( 'ABSPATH' ) || exit;

function opm_run_setup(): void {
	opm_create_pages();
	opm_fix_permalinks();
	update_option( 'opm_setup_done', OPM_VERSION );
}

/**
 * Create all pages if they don't already exist (checks by slug).
 */
function opm_create_pages(): void {
	$pages = [
		[
			'slug'     => 'home',
			'title'    => 'Home',
			'content'  => '',
			'template' => '', // handled by front-page.php
		],
		[
			'slug'    => 'about',
			'title'   => 'About Us',
			'content' => opm_about_content(),
		],
		[
			'slug'    => 'contact',
			'title'   => 'Contact',
			'content' => '[op_contact_form]',
		],
		[
			'slug'    => 'privacy-policy',
			'title'   => 'Privacy Policy',
			'content' => opm_privacy_content(),
		],
	];

	$created_ids = [];

	foreach ( $pages as $page ) {
		$existing = get_page_by_path( $page['slug'] );
		if ( $existing ) {
			$created_ids[ $page['slug'] ] = $existing->ID;
			continue;
		}

		$post_data = [
			'post_title'   => $page['title'],
			'post_name'    => $page['slug'],
			'post_content' => $page['content'] ?? '',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => get_current_user_id() ?: 1,
		];

		$id = wp_insert_post( $post_data );
		if ( ! is_wp_error( $id ) ) {
			$created_ids[ $page['slug'] ] = $id;
		}
	}

	// ── Set front page ────────────────────────────────────────────────────
	if ( isset( $created_ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $created_ids['home'] );
	}

	// ── Assign page templates ─────────────────────────────────────────────
	$template_map = [
		'contact' => 'page-contact.php',
		'about'   => 'page-about.php',
	];
	foreach ( $template_map as $slug => $template ) {
		if ( isset( $created_ids[ $slug ] ) ) {
			update_post_meta( $created_ids[ $slug ], '_wp_page_template', $template );
		}
	}

	update_option( 'opm_page_ids', $created_ids );
}

/**
 * Switch permalink structure to /%postname%/ if not already.
 */
function opm_fix_permalinks(): void {
	$current = get_option( 'permalink_structure', '' );
	if ( $current !== '/%postname%/' ) {
		update_option( 'permalink_structure', '/%postname%/' );
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		$wp_rewrite->flush_rules( true );
	} else {
		flush_rewrite_rules( true );
	}
}

/**
 * Default About Us page content.
 */
function opm_about_content(): string {
	return '<h2>About Oria Patel Enterprises</h2>
<p>Oria Patel Enterprises is a leading manufacturer of custom sports uniforms based in Sialkot, Punjab, Pakistan — the global hub of sports manufacturing.</p>
<p>We specialise in fully sublimated, high-performance sportswear for teams, clubs, schools, and organisations worldwide. From American football to cricket, basketball to cycling — we bring your design vision to life with precision and quality.</p>

<h3>Why Choose Us?</h3>
<ul>
<li><strong>Zero Minimum Order</strong> — Order as few as 1 piece with no extra charge.</li>
<li><strong>Design Mockup</strong> — Our designers create a full 3D digital preview of your uniform within 48 hours.</li>
<li><strong>100% Sublimation Printing</strong> — Fade-proof, vibrant colours that last the lifetime of the garment.</li>
<li><strong>Worldwide Shipping</strong> — We are shipping worldwide, directly to your door.</li>
<li><strong>Custom Everything</strong> — Colours, numbers, names, logos, fonts — all fully customisable.</li>
</ul>

<h3>Our Location</h3>
<p>Sialkot, Punjab, Pakistan — a city with a 500-year heritage of sports goods manufacturing and home to the world\'s finest sporting equipment factories.</p>

<p><a href="/contact/" class="op-btn op-btn--primary">Get a Quote Today →</a></p>';
}

/**
 * Minimal privacy policy content.
 */
function opm_privacy_content(): string {
	return '<h2>Privacy Policy</h2>
<p>At Oria Patel Enterprises, we are committed to protecting your privacy. This policy explains how we collect and use your information.</p>
<h3>Information We Collect</h3>
<p>We collect information you provide when submitting a quote request: your name, email address, phone number, and order details. This information is used solely to respond to your enquiry.</p>
<h3>How We Use Your Information</h3>
<p>Your information is never sold or shared with third parties. It is used only to communicate with you about your order or enquiry.</p>
<h3>Contact Us</h3>
<p>For any privacy questions, please <a href="/contact/">contact us</a>.</p>
<p><em>Last updated: ' . gmdate( 'F Y' ) . '</em></p>';
}

/* ── Admin notice: show setup status ──────────────────────────────────────── */
add_action( 'admin_notices', function () {
	if ( ! current_user_can( 'manage_options' ) ) return;

	$page_ids = get_option( 'opm_page_ids', [] );
	if ( empty( $page_ids ) ) {
		echo '<div class="notice notice-warning is-dismissible">
			<p><strong>🎽 Oria Patel Manager:</strong> Setup not complete.
			<a href="' . esc_url( admin_url( 'admin.php?page=opm_dashboard&run_setup=1' ) ) . '" class="button button-primary" style="margin-left:10px">
				▶ Run Setup Now
			</a></p>
		</div>';
		return;
	}

	$missing = [];
	$check   = [ 'home' => 'Home', 'about' => 'About', 'contact' => 'Contact' ];
	foreach ( $check as $slug => $label ) {
		$id = $page_ids[ $slug ] ?? 0;
		if ( ! $id || get_post_status( $id ) !== 'publish' ) {
			$missing[] = $label;
		}
	}

	if ( $missing ) {
		echo '<div class="notice notice-error is-dismissible">
			<p><strong>🎽 Oria Patel:</strong> These pages are missing: <strong>' . esc_html( implode( ', ', $missing ) ) . '</strong>.
			<a href="' . esc_url( admin_url( 'admin.php?page=opm_dashboard&run_setup=1' ) ) . '">Re-run setup →</a></p>
		</div>';
	}
} );

/* ── Handle setup trigger from admin URL ─────────────────────────────────── */
add_action( 'admin_init', function () {
	if ( ! isset( $_GET['run_setup'] ) || ! current_user_can( 'manage_options' ) ) return;
	opm_run_setup();
	wp_safe_redirect( admin_url( 'admin.php?page=opm_dashboard&setup_done=1' ) );
	exit;
} );

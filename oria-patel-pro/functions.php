<?php
/**
 * Oria Patel Enterprises — functions.php
 * Theme setup, enqueue, menus, widget areas, Customizer.
 * No WooCommerce dependency — uses the opm_product CPT system.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'OP_VERSION', '1.0.0' );
define( 'OP_DIR',  get_template_directory() );
define( 'OP_URI',  get_template_directory_uri() );

/* ─── Theme Setup ───────────────────────────────────────────────────────── */
add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'oria-patel', OP_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 80,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	] );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );

	// Image sizes
	add_image_size( 'op-card',     400, 300, true );
	add_image_size( 'op-category', 600, 450, true );
	add_image_size( 'op-hero',    1400, 700, true );

	// Menus
	register_nav_menus( [
		'primary'  => __( 'Primary Navigation', 'oria-patel' ),
		'footer'   => __( 'Footer Navigation', 'oria-patel' ),
		'footer-2' => __( 'Footer Column 2', 'oria-patel' ),
	] );
} );


/* ─── Remove unused WordPress defaults (emoji, jquery-migrate, wp-embed) ─────── */
add_action( 'init', function () {
	remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles',     'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles',  'print_emoji_styles' );
	remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );
	remove_filter( 'wp_mail',             'wp_staticize_emoji_for_email' );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_deregister_script( 'jquery-migrate' ); // Legacy compatibility shim — not needed here.
	wp_deregister_script( 'wp-embed' );       // oEmbed player unused on this site.
}, 100 );

/* ─── Preconnect to external origins ──────────────────────────────────────────── */
add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://www.googletagmanager.com">' . "\n";
	echo '<link rel="dns-prefetch" href="//www.googletagmanager.com">' . "\n";
	echo '<link rel="dns-prefetch" href="//www.google-analytics.com">' . "\n";
}, 1 );

/* ─── Scripts & Styles ──────────────────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'oria-patel-style', get_stylesheet_uri(), [], OP_VERSION );

	// Landing page CSS — loaded on all front-end pages (small file, needed everywhere for WhatsApp bubble)
	wp_enqueue_style( 'oria-landing', OP_URI . '/assets/css/landing.css', [ 'oria-patel-style' ], OP_VERSION );

	$custom_css = op_generate_custom_css();
	if ( $custom_css ) {
		wp_add_inline_style( 'oria-patel-style', $custom_css );
	}

	wp_enqueue_script( 'oria-patel-main', OP_URI . '/assets/js/main.js', [], OP_VERSION, true );

	// Landing page JS — FAQ accordion, sticky bar, exit popup, lead forms
	wp_enqueue_script( 'oria-landing', OP_URI . '/assets/js/landing.js', [ 'oria-patel-main' ], OP_VERSION, true );

	// Defer main JS — signals parser it can continue without waiting.
	add_filter( 'script_loader_tag', function ( $tag, $handle ) {
		if ( 'oria-patel-main' === $handle ) {
			return str_replace( ' src=', ' defer src=', $tag );
		}
		return $tag;
	}, 10, 2 );

	wp_localize_script( 'oria-patel-main', 'opData', [
		'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
		'nonce'      => wp_create_nonce( 'op_nonce' ),
		'shopUrl'    => home_url( '/products/' ),
		'contactUrl' => home_url( '/contact/' ),
	] );

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );

/**
 * Build CSS custom properties from Customizer values.
 */
function op_generate_custom_css(): string {
	$primary = get_theme_mod( 'op_color_primary', '#0F1111' );
	$accent  = get_theme_mod( 'op_color_accent',  '#F3A847' );
	$link    = get_theme_mod( 'op_color_link',    '#2162A1' );
	$muted   = get_theme_mod( 'op_color_muted',   '#565959' );

	return ":root {
		--op-color-primary: {$primary};
		--op-color-accent:  {$accent};
		--op-color-link:    {$link};
		--op-color-muted:   {$muted};
	}";
}

/* ─── Widget Areas ──────────────────────────────────────────────────────── */
add_action( 'widgets_init', function () {
	$defaults = [
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	];

	register_sidebar( array_merge( $defaults, [
		'name' => __( 'Footer Column 1', 'oria-patel' ),
		'id'   => 'footer-1',
	] ) );
	register_sidebar( array_merge( $defaults, [
		'name' => __( 'Footer Column 2', 'oria-patel' ),
		'id'   => 'footer-2',
	] ) );
	register_sidebar( array_merge( $defaults, [
		'name' => __( 'Footer Column 3', 'oria-patel' ),
		'id'   => 'footer-3',
	] ) );
} );

/* ─── Customizer ────────────────────────────────────────────────────────── */
require_once OP_DIR . '/inc/customizer.php';

/* ─── Template Functions ────────────────────────────────────────────────── */
require_once OP_DIR . '/inc/template-functions.php';

/* ─── SEO Functions (sitemap, robots, schema extensions) ───────────────── */
require_once OP_DIR . '/inc/seo-functions.php';

/* ─── Reviews CPT, meta boxes, shortcodes ──────────────────────────────── */
require_once OP_DIR . '/inc/review-functions.php';

/* ─── Blog helpers (reading time, related posts, social share) ──────────── */
require_once OP_DIR . '/inc/blog-functions.php';

/* ─── Helper: Breadcrumb ────────────────────────────────────────────────── */
function op_breadcrumb(): void {
	echo '<nav class="op-breadcrumb">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'oria-patel' ) . '</a>';
	echo '<span class="op-breadcrumb__sep">›</span>';

	if ( is_singular( 'opm_product' ) ) {
		echo '<a href="' . esc_url( home_url( '/products/' ) ) . '">' . esc_html__( 'Products', 'oria-patel' ) . '</a>';
		echo '<span class="op-breadcrumb__sep">›</span>';
		echo '<span class="op-breadcrumb__current">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_post_type_archive( 'opm_product' ) ) {
		echo '<span class="op-breadcrumb__current">' . esc_html__( 'Products', 'oria-patel' ) . '</span>';
	} elseif ( is_tax( 'opm_category' ) ) {
		$term = get_queried_object();
		echo '<a href="' . esc_url( home_url( '/products/' ) ) . '">' . esc_html__( 'Products', 'oria-patel' ) . '</a>';
		echo '<span class="op-breadcrumb__sep">›</span>';
		echo '<span class="op-breadcrumb__current">' . esc_html( $term->name ) . '</span>';
	} elseif ( is_singular() || is_page() ) {
		echo '<span class="op-breadcrumb__current">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_archive() ) {
		$title = wp_strip_all_tags( get_the_archive_title() );
		$title = preg_replace( '/^[^:]+:\s*/', '', $title );
		echo '<span class="op-breadcrumb__current">' . esc_html( $title ) . '</span>';
	}

	echo '</nav>';
}

/* ─── Contact Form handler (no plugin needed) ───────────────────────────── */
add_action( 'wp_ajax_nopriv_op_contact_form', 'op_handle_contact_form' );
add_action( 'wp_ajax_op_contact_form',        'op_handle_contact_form' );
function op_handle_contact_form(): void {
	check_ajax_referer( 'op_nonce', 'nonce' );

	// wp_unslash() is required before sanitizing — WordPress slashes all $_POST data.
	$name    = sanitize_text_field( wp_unslash( $_POST['name']    ?? '' ) );
	$email   = sanitize_email(      wp_unslash( $_POST['email']   ?? '' ) );
	$sport   = sanitize_text_field( wp_unslash( $_POST['sport']   ?? '' ) );
	$qty     = absint(                           $_POST['qty']     ?? 0   );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( ! $name || ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => __( 'Please fill in all required fields.', 'oria-patel' ) ] );
	}

	$admin_email = get_theme_mod( 'op_contact_email', get_option( 'admin_email' ) );
	$subject     = sprintf( __( 'New Quote Request from %s — %s', 'oria-patel' ), $name, $sport ?: 'N/A' );
	$body        = "Name: {$name}\nEmail: {$email}\nSport/Product: {$sport}\nQuantity: {$qty}\n\nMessage:\n{$message}";

	$sent = wp_mail( $admin_email, $subject, $body, [
		"Reply-To: {$name} <{$email}>",
		'Content-Type: text/plain; charset=UTF-8',
	] );

	if ( $sent ) {
		$msg = get_theme_mod( 'op_form_success_message', __( 'Thank you! Your quote request has been sent. We will reply within 24 hours. 🎉', 'oria-patel' ) );
		wp_send_json_success( [ 'message' => $msg ] );
	} else {
		wp_send_json_error( [ 'message' => __( 'Failed to send. Please email us directly.', 'oria-patel' ) ] );
	}
}

/* ─── Custom excerpt length ─────────────────────────────────────────────── */
add_filter( 'excerpt_length', fn() => 25, 999 );
add_filter( 'excerpt_more',   fn() => '…' );

/* ─── Document title separator ──────────────────────────────────────────── */
add_filter( 'document_title_separator', fn() => '·' );

/* ─── Suppress WordPress core rel_canonical() to prevent duplicate <link> ── */
// The theme's oria_extended_seo_head() (inc/seo-functions.php, priority 2) emits
// canonical for every page type including archives and taxonomies — more complete
// than core's version which only covers singular pages.
remove_action( 'wp_head', 'rel_canonical' );

/* ─── Shortcode: [op_contact_form] ─────────────────────────────────────── */
// Renders the contact/quote form template part. Used in page-contact.php and can
// be placed in any page via the shortcode.
add_shortcode( 'op_contact_form', function(): string {
	ob_start();
	get_template_part( 'template-parts/contact-form' );
	return ob_get_clean();
} );

/* ─── Auto-apply About Page template by slug ────────────────────────────── */
add_filter( 'template_include', function ( $template ) {
	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( in_array( $slug, [ 'about', 'about-us', 'about-oria-patel', 'about-page' ], true ) ) {
			$custom = get_template_directory() . '/page-about.php';
			if ( file_exists( $custom ) ) {
				return $custom;
			}
		}
	}
	return $template;
}, 99 );

/* ─── Default Customizer: brand name for product cards ─────────────────── */
add_filter( 'theme_mod_op_brand_name', function ( $value ) {
	if ( ! $value ) {
		$site = get_bloginfo( 'name' );
		return $site ? ucwords( strtolower( $site ) ) : 'Oria Patel Enterprises';
	}
	return $value;
} );

/* ─── SEO: Meta Description, Open Graph, Twitter Card, Schema.org ────────── */
add_action( 'wp_head', 'op_head_seo_tags', 1 );
function op_head_seo_tags(): void {
	$site_name = get_bloginfo( 'name' );
	$logo_id   = (int) get_theme_mod( 'custom_logo', 0 );
	$logo_url  = $logo_id ? ( wp_get_attachment_image_url( $logo_id, 'full' ) ?: '' ) : '';

	/* ── Page-specific values ──────────────────────────────────────────── */
	if ( is_front_page() ) {
		$og_title = get_theme_mod( 'op_seo_home_title', '' )
			?: ( $site_name . ' — Custom Sports Uniforms Manufacturer | Sialkot, Pakistan' );
		$og_desc = get_theme_mod( 'op_seo_home_desc', '' )
			?: 'Premium custom sports uniforms manufactured in Sialkot, Pakistan. Zero minimum order, free 3D design mockup within 48 hours, worldwide shipping.';
		$hero_id  = (int) get_theme_mod( 'op_hero_image', 0 );
		$og_image = $hero_id ? ( wp_get_attachment_image_url( $hero_id, 'full' ) ?: $logo_url ) : $logo_url;
		$og_url   = home_url( '/' );
		$og_type  = 'website';
	} elseif ( is_singular( 'opm_product' ) ) {
		$og_title = get_the_title() . ' — Custom Uniform | ' . $site_name;
		$excerpt  = get_the_excerpt();
		$og_desc  = $excerpt
			? wp_strip_all_tags( $excerpt )
			: 'Premium custom uniform manufactured in Sialkot, Pakistan. Zero MOQ, free design mockup, worldwide shipping.';
		$og_image = get_the_post_thumbnail_url( null, 'large' ) ?: $logo_url;
		$og_url   = get_permalink();
		$og_type  = 'product';
	} elseif ( is_post_type_archive( 'opm_product' ) || is_tax( 'opm_category' ) ) {
		$og_title = 'Custom Sports Uniforms Catalogue | ' . $site_name;
		$og_desc  = 'Browse our full catalogue of custom sports uniforms. Zero minimum order, free design mockup, worldwide shipping from Sialkot, Pakistan.';
		$og_image = $logo_url;
		$og_url   = get_post_type_archive_link( 'opm_product' ) ?: home_url( '/products/' );
		$og_type  = 'website';
	} elseif ( is_singular() ) {
		$og_title = get_the_title() . ' | ' . $site_name;
		$og_desc  = wp_trim_words( wp_strip_all_tags( get_the_content() ), 25, '…' );
		$og_image = get_the_post_thumbnail_url( null, 'large' ) ?: $logo_url;
		$og_url   = get_permalink() ?: home_url( '/' );
		$og_type  = 'article';
	} else {
		$og_title = $site_name . ' — Custom Sports Uniforms';
		$og_desc  = 'Premium custom sports uniforms manufactured in Sialkot, Pakistan.';
		$og_image = $logo_url;
		$og_url   = home_url( '/' );
		$og_type  = 'website';
	}

	$og_desc = mb_substr( wp_strip_all_tags( $og_desc ), 0, 160 );

	/* ── Output meta tags ─────────────────────────────────────────────── */
	echo '<meta name="description" content="'        . esc_attr( $og_desc )  . '">' . "\n";
	// Canonical is already output by WordPress core (rel_canonical()) — no duplicate needed.
	echo '<meta property="og:type"        content="' . esc_attr( $og_type )  . '">' . "\n";
	echo '<meta property="og:title"       content="' . esc_attr( $og_title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $og_desc )  . '">' . "\n";
	echo '<meta property="og:url"         content="' . esc_url( $og_url )    . '">' . "\n";
	echo '<meta property="og:site_name"   content="' . esc_attr( $site_name ). '">' . "\n";
	if ( $og_image ) echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
	echo '<meta name="twitter:card"        content="summary_large_image">'            . "\n";
	echo '<meta name="twitter:title"       content="' . esc_attr( $og_title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $og_desc )  . '">' . "\n";
	if ( $og_image ) echo '<meta name="twitter:image" content="' . esc_url( $og_image ) . '">' . "\n";

	/* ── Schema.org — Organisation (every page) ───────────────────────── */
	$phone  = get_theme_mod( 'op_contact_phone', '' );
	$schema = [
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'name'     => $site_name,
		'url'      => home_url( '/' ),
		'logo'     => $logo_url ?: home_url( '/' ),
		'sameAs'   => array_values( array_filter( [
			get_theme_mod( 'op_social_facebook',  '' ),
			get_theme_mod( 'op_social_instagram', '' ),
			get_theme_mod( 'op_social_linkedin',  '' ),
			get_theme_mod( 'op_social_whatsapp',  '' ),
		] ) ),
	];
	if ( $phone ) {
		$schema['contactPoint'] = [
			'@type'       => 'ContactPoint',
			'telephone'   => $phone,
			'contactType' => 'customer service',
			'areaServed'  => 'Worldwide',
		];
	}
	echo '<script type="application/ld+json">'
		. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		. '</script>' . "\n";

	/* ── Schema.org — Product (single product pages only) ─────────────── */
	if ( is_singular( 'opm_product' ) ) {
		$prod_schema = [
			'@context'     => 'https://schema.org',
			'@type'        => 'Product',
			'name'         => get_the_title(),
			'description'  => $og_desc,
			'image'        => get_the_post_thumbnail_url( null, 'full' ) ?: $logo_url,
			'brand'        => [ '@type' => 'Brand', 'name' => $site_name ],
			'manufacturer' => [ '@type' => 'Organization', 'name' => $site_name, 'url' => home_url( '/' ) ],
			'offers'       => [
				'@type'         => 'Offer',
				'availability'  => 'https://schema.org/InStock',
				'priceCurrency' => 'USD',
				'seller'        => [ '@type' => 'Organization', 'name' => $site_name ],
				'url'           => get_permalink(),
			],
		];
		echo '<script type="application/ld+json">'
			. wp_json_encode( $prod_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
			. '</script>' . "\n";
	}
}

/* ─── Google Analytics 4 (optional — set ID in Customizer → SEO) ────────── */
add_action( 'wp_head', 'op_google_analytics', 50 );
function op_google_analytics(): void {
	if ( is_admin() || is_customize_preview() ) return;
	$ga_id = get_theme_mod( 'op_seo_google_code', '' );
	if ( ! $ga_id ) return;
	$ga_id = sanitize_text_field( $ga_id );
	?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo esc_js( $ga_id ); ?>');</script>
	<?php
}

/* ─── LCP Preload — Hero Background Image (improves Core Web Vitals) ────── */
add_action( 'wp_head', 'op_preload_hero_lcp', 2 );
function op_preload_hero_lcp(): void {
	if ( ! is_front_page() ) return;
	$hero_id = (int) get_theme_mod( 'op_hero_image', 0 );
	if ( ! $hero_id ) return;
	$src = wp_get_attachment_image_url( $hero_id, 'op-hero' );
	if ( $src ) {
		echo '<link rel="preload" as="image" href="' . esc_url( $src ) . '" fetchpriority="high">' . "\n";
	}
}

/* ─── Transient Cache Busting — flushed on any product/category change ───── */
function op_bust_cat_sections_cache(): void {
	delete_transient( 'op_cat_sections_v1' );
}
add_action( 'save_post_opm_product',  'op_bust_cat_sections_cache' );
add_action( 'delete_post',            'op_bust_cat_sections_cache' );
add_action( 'created_opm_category',   'op_bust_cat_sections_cache' );
add_action( 'edited_opm_category',    'op_bust_cat_sections_cache' );
add_action( 'delete_opm_category',    'op_bust_cat_sections_cache' );
add_action( 'customize_save_after',   'op_bust_cat_sections_cache' );

/* ─── Lead Capture (email bar, exit popup, AJAX handler, leads DB) ──────── */
require_once OP_DIR . '/inc/lead-functions.php';

/* ─── Customizer: Lead Magnet PDF upload option ─────────────────────────── */
add_action( 'customize_register', function ( WP_Customize_Manager $wpc ) {
	$wpc->add_setting( 'op_lead_magnet_pdf', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
	$wpc->add_control( new WP_Customize_Upload_Control( $wpc, 'op_lead_magnet_pdf', [
		'label'       => 'Lead Magnet PDF (Team Uniform Buying Guide)',
		'description' => 'Upload a PDF to offer as a free download on the Thank-You page.',
		'section'     => 'op_business',
		'mime_type'   => 'application/pdf',
	] ) );
}, 20 );

<?php
/**
 * Oria Patel Enterprises — Customizer
 *
 * Everything here is written in plain English so you can confidently
 * change any part of your website without touching a single line of code.
 *
 * How to use:
 *   WordPress Dashboard → Appearance → Customize
 *   Click any section in the left panel, make your change, then click Publish.
 *   You'll see a live preview on the right as you type.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ═══════════════════════════════════════════════════════════════════════════
   MAIN PANEL
   All Oria Patel settings live under "Your Website Settings" in the Customizer.
═══════════════════════════════════════════════════════════════════════════ */
add_action( 'customize_register', function ( WP_Customize_Manager $wpc ) {

	$wpc->add_panel( 'op_theme_options', [
		'title'       => '⚙️ Your Website Settings',
		'description' => 'Everything you need to personalise your website is right here. Click a section to expand it, make your changes, and hit Publish when you\'re happy.',
		'priority'    => 25,
	] );

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 1 — Business Info (most important — fill this first!)
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_business', [
		'title'       => '🏢 Your Business Info',
		'description' => '📌 START HERE — Fill in your real business details. These appear in your website footer, contact page, and quote request emails.',
		'panel'       => 'op_theme_options',
		'priority'    => 10,
	] );

	$business_fields = [
		[
			'id'          => 'op_contact_email',
			'default'     => 'info@oriapatel.com',
			'type'        => 'email',
			'sanitize'    => 'sanitize_email',
			'label'       => '📧 Your Email Address',
			'description' => 'Enquiries and quote requests will be sent to this email. Use your main business inbox.',
		],
		[
			'id'          => 'op_contact_phone',
			'default'     => '+92 311 7337511',
			'type'        => 'text',
			'sanitize'    => 'sanitize_text_field',
			'label'       => '📞 Phone / WhatsApp Number',
			'description' => 'Shown in the footer. Include your country code, e.g. +92 311 7337511',
		],
		[
			'id'          => 'op_contact_address',
			'default'     => 'Sialkot, Punjab, Pakistan',
			'type'        => 'textarea',
			'sanitize'    => 'sanitize_textarea_field',
			'label'       => '📍 Business Address',
			'description' => 'Your factory or office address. Shown in the footer.',
		],
		[
			'id'          => 'op_business_hours',
			'default'     => '24/7 — We respond to all enquiries within 24 hours',
			'type'        => 'text',
			'sanitize'    => 'sanitize_text_field',
			'label'       => '🕐 Business Hours',
			'description' => 'When are you available? Shown next to your contact info in the footer.',
		],
	];

	foreach ( $business_fields as $f ) {
		$wpc->add_setting( $f['id'], [
			'default'           => $f['default'],
			'sanitize_callback' => $f['sanitize'],
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( $f['id'], [
			'type'        => $f['type'],
			'label'       => $f['label'],
			'description' => $f['description'],
			'section'     => 'op_business',
		] );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 2 — Social Media Links
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_social', [
		'title'       => '📱 Social Media Links',
		'description' => 'Add links to your social media profiles. Leave any field blank if you don\'t have that account — the icon will simply be hidden.',
		'panel'       => 'op_theme_options',
		'priority'    => 11,
	] );

	$social_fields = [
		[
			'id'          => 'op_social_whatsapp',
			'default'     => '',
			'label'       => '💬 WhatsApp Link',
			'description' => 'Go to wa.me, enter your number, and paste the full link here. Example: https://wa.me/923111234567',
		],
		[
			'id'          => 'op_social_facebook',
			'default'     => '',
			'label'       => '👍 Facebook Page URL',
			'description' => 'Paste your full Facebook page link, e.g. https://facebook.com/yourpage',
		],
		[
			'id'          => 'op_social_instagram',
			'default'     => '',
			'label'       => '📸 Instagram Profile URL',
			'description' => 'Paste your full Instagram link, e.g. https://instagram.com/yourprofile',
		],
		[
			'id'          => 'op_social_linkedin',
			'default'     => '',
			'label'       => '💼 LinkedIn Page URL',
			'description' => 'Paste your company LinkedIn page link here.',
		],
	];

	foreach ( $social_fields as $f ) {
		$wpc->add_setting( $f['id'], [
			'default'           => $f['default'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( $f['id'], [
			'type'        => 'url',
			'label'       => $f['label'],
			'description' => $f['description'],
			'section'     => 'op_social',
		] );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 3 — Brand Colours
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_colors', [
		'title'       => '🎨 Brand Colours',
		'description' => 'Change your website\'s colour scheme here. Click the colour box, pick a colour, and you\'ll see it update live in the preview on the right. ⚠️ Tip: Stick to 2–3 colours for a professional look.',
		'panel'       => 'op_theme_options',
		'priority'    => 20,
	] );

	$color_fields = [
		[
			'id'          => 'op_color_primary',
			'default'     => '#0F1111',
			'label'       => '🖤 Main Dark Colour',
			'description' => 'Used for the header background, button text, and headings. Default is near-black.',
		],
		[
			'id'          => 'op_color_accent',
			'default'     => '#F3A847',
			'label'       => '🟡 Button / Highlight Colour (Amber)',
			'description' => 'Used for all "Request Quote" and call-to-action buttons. Change this to match your brand.',
		],
		[
			'id'          => 'op_color_link',
			'default'     => '#2162A1',
			'label'       => '🔵 Link Colour (Blue)',
			'description' => 'Used for clickable links throughout the site.',
		],
		[
			'id'          => 'op_color_muted',
			'default'     => '#565959',
			'label'       => '🩶 Secondary Text Colour (Grey)',
			'description' => 'Used for smaller supporting text, descriptions, and labels.',
		],
	];

	foreach ( $color_fields as $f ) {
		$wpc->add_setting( $f['id'], [
			'default'           => $f['default'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( new WP_Customize_Color_Control( $wpc, $f['id'], [
			'label'       => $f['label'],
			'description' => $f['description'],
			'section'     => 'op_colors',
		] ) );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 4 — Announcement Bar (scrolling ticker at the very top)
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_topbar', [
		'title'       => '📢 Announcement Bar (top strip)',
		'description' => 'This is the scrolling dark strip at the very top of every page. Use it to highlight your key selling points — it\'s the first thing visitors see!',
		'panel'       => 'op_theme_options',
		'priority'    => 30,
	] );

	$wpc->add_setting( 'op_topbar_show', [
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_topbar_show', [
		'type'        => 'checkbox',
		'label'       => '✅ Show the announcement bar',
		'description' => 'Uncheck this box to completely hide the top strip.',
		'section'     => 'op_topbar',
	] );

	$topbar_defaults = [
		1 => 'DESIGN MOCKUP',
		2 => 'NO MINIMUM ORDER',
		3 => 'FAST DELIVERY WORLDWIDE',
		4 => '100% SUBLIMATION PRINTING',
	];

	for ( $i = 1; $i <= 4; $i++ ) {
		$wpc->add_setting( "op_topbar_item_{$i}", [
			'default'           => $topbar_defaults[ $i ],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_topbar_item_{$i}", [
			'type'        => 'text',
			'label'       => "Message #{$i} in the scrolling bar",
			'description' => 'Keep it short and punchy — all caps works great here.',
			'section'     => 'op_topbar',
		] );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 5 — Big Hero Banner (the first thing visitors see on homepage)
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_hero', [
		'title'       => '🦸 Homepage Hero (Big Banner)',
		'description' => 'This is the large full-screen banner at the top of your homepage — the very first impression visitors get. Make it count!',
		'panel'       => 'op_theme_options',
		'priority'    => 40,
	] );

	$hero_fields = [
		[
			'id'          => 'op_hero_badge',
			'default'     => 'Premium Manufacturer · Sialkot, Pakistan',
			'type'        => 'text',
			'sanitize'    => 'sanitize_text_field',
			'label'       => '🏷️ Small Badge Text (above the headline)',
			'description' => 'The small pill/tag that appears above the main headline. Example: "Premium Manufacturer · Pakistan" or "Est. 2005 · Sialkot"',
		],
		[
			'id'          => 'op_hero_title',
			'default'     => 'Best Custom Uniforms for Champions',
			'type'        => 'text',
			'sanitize'    => 'sanitize_text_field',
			'label'       => '✍️ Main Big Headline',
			'description' => 'The largest text visitors see. Keep it under 8 words. Use the "Highlighted Word" field just below to make one word appear in your accent colour.',
		],
		[
			'id'          => 'op_hero_desc',
			'default'     => 'Professional-grade sublimated sportswear from our factory. Zero minimum orders, design mockups, worldwide delivery.',
			'type'        => 'textarea',
			'sanitize'    => 'sanitize_textarea_field',
			'label'       => '📝 Supporting Description (below the headline)',
			'description' => 'A sentence or two expanding on your headline. Mention your top 2–3 benefits.',
		],
		[
			'id'          => 'op_hero_cta1_text',
			'default'     => 'Browse Products',
			'type'        => 'text',
			'sanitize'    => 'sanitize_text_field',
			'label'       => '🔘 Primary Button Text (left button)',
			'description' => 'The main button text. Example: "See Our Products" or "View Catalogue"',
		],
		[
			'id'          => 'op_hero_cta1_url',
			'default'     => '/products/',
			'type'        => 'url',
			'sanitize'    => 'esc_url_raw',
			'label'       => '🔗 Primary Button Link',
			'description' => 'Where should the left button take visitors? Default is /products/ — your main product catalogue.',
		],
		[
			'id'          => 'op_hero_cta2_text',
			'default'     => 'Get Quote',
			'type'        => 'text',
			'sanitize'    => 'sanitize_text_field',
			'label'       => '🔘 Secondary Button Text (right button)',
			'description' => 'The outline button text. Example: "Request a Quote" or "Contact Us"',
		],
		[
			'id'          => 'op_hero_cta2_url',
			'default'     => '/contact/',
			'type'        => 'url',
			'sanitize'    => 'esc_url_raw',
			'label'       => '🔗 Secondary Button Link',
			'description' => 'Where should the right button take visitors? Usually your /contact/ page.',
		],
	];

	foreach ( $hero_fields as $f ) {
		$wpc->add_setting( $f['id'], [
			'default'           => $f['default'],
			'sanitize_callback' => $f['sanitize'],
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( $f['id'], [
			'type'        => $f['type'] === 'textarea' ? 'textarea' : 'text',
			'label'       => $f['label'],
			'description' => $f['description'],
			'section'     => 'op_hero',
		] );
	}

	// Highlighted accent word in the hero title
	$wpc->add_setting( 'op_hero_accent_word', [
		'default'           => 'Uniforms',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	] );
	$wpc->add_control( 'op_hero_accent_word', [
		'type'        => 'text',
		'label'       => '✨ Highlighted Word (amber/gold colour)',
		'description' => 'Type exactly one word from your headline. That word will appear in your accent colour. Example: if your headline is "Best Custom Uniforms for Champions", type "Uniforms".',
		'section'     => 'op_hero',
	] );

	// Hero Background Image — special media uploader
	$wpc->add_setting( 'op_hero_image', [
		'default'           => '',
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( new WP_Customize_Media_Control( $wpc, 'op_hero_image', [
		'label'       => '🖼️ Hero Background Photo',
		'description' => 'Upload a high-quality photo of your uniforms or team in action. Best size: 1400×700 pixels or larger. The image will have a dark overlay so your text stays readable.',
		'section'     => 'op_hero',
		'mime_type'   => 'image',
	] ) );

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 6 — "Why Choose Us" Tiles (4 trust badges under the hero)
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_value_props', [
		'title'       => '✅ "Why Choose Us" Tiles',
		'description' => 'The 4 highlighted tiles that appear just below the main banner — they quickly tell visitors why they should choose you. Each tile has an emoji icon, a short title, and a one-line description.',
		'panel'       => 'op_theme_options',
		'priority'    => 50,
	] );

	$prop_defaults = [
		1 => [ 'icon' => '🎽', 'title' => 'Zero Minimum Order',  'desc' => 'Order 1 or 1,000 pieces' ],
		2 => [ 'icon' => '✏️', 'title' => 'Design Mockup',       'desc' => 'See it before you pay' ],
		3 => [ 'icon' => '💧', 'title' => '100% Sublimation',    'desc' => 'Fade-proof custom prints' ],
		4 => [ 'icon' => '🚚', 'title' => 'Fast Worldwide Delivery', 'desc' => 'Door-to-door shipping' ],
	];

	for ( $i = 1; $i <= 4; $i++ ) {
		// Icon
		$wpc->add_setting( "op_prop_{$i}_icon", [
			'default'           => $prop_defaults[ $i ]['icon'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_prop_{$i}_icon", [
			'type'        => 'text',
			'label'       => "Tile #{$i} — Emoji / Icon",
			'description' => 'Paste any emoji here. Visit emojipedia.org if you need inspiration. Example: 🏅 🚀 ⚡ 🎯',
			'section'     => 'op_value_props',
		] );

		// Title
		$wpc->add_setting( "op_prop_{$i}_title", [
			'default'           => $prop_defaults[ $i ]['title'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_prop_{$i}_title", [
			'type'        => 'text',
			'label'       => "Tile #{$i} — Short Title (3–5 words)",
			'description' => 'The bold heading of this tile. Keep it very short.',
			'section'     => 'op_value_props',
		] );

		// Description
		$wpc->add_setting( "op_prop_{$i}_desc", [
			'default'           => $prop_defaults[ $i ]['desc'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_prop_{$i}_desc", [
			'type'        => 'text',
			'label'       => "Tile #{$i} — One-Line Description",
			'description' => 'A brief supporting line under the title.',
			'section'     => 'op_value_props',
		] );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 7 — Sport Category Cards (the 8-card grid on homepage)
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_categories', [
		'title'       => '🏈 Sport Category Cards (8 cards)',
		'description' => 'The grid of 8 sport category cards on your homepage. Visitors click these to jump straight to that sport\'s products. For each card you can set the label, the link, and the background photo.',
		'panel'       => 'op_theme_options',
		'priority'    => 60,
	] );

	$cat_defaults = [
		1 => 'American Football', 2 => 'Baseball',    3 => 'Basketball', 4 => 'Hockey',
		5 => 'Soccer',            6 => 'Volleyball',  7 => 'Wrestling',  8 => 'Track & Field',
	];

	for ( $i = 1; $i <= 8; $i++ ) {
		// Label
		$wpc->add_setting( "op_cat_{$i}_label", [
			'default'           => $cat_defaults[ $i ],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_cat_{$i}_label", [
			'type'        => 'text',
			'label'       => "Card #{$i} — Sport Name",
			'description' => 'The label shown on this card. Example: Soccer, Basketball, Cricket',
			'section'     => 'op_categories',
		] );

		// Link
		$wpc->add_setting( "op_cat_{$i}_url", [
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_cat_{$i}_url", [
			'type'        => 'url',
			'label'       => "Card #{$i} — Link (where it goes when clicked)",
			'description' => 'Paste the full URL of the product category page for this sport. Leave blank to auto-link to the matching opm_category term.',
			'section'     => 'op_categories',
		] );

		// Image
		$wpc->add_setting( "op_cat_{$i}_image", [
			'default'           => '',
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		] );
		$wpc->add_control( new WP_Customize_Media_Control( $wpc, "op_cat_{$i}_image", [
			'label'       => "Card #{$i} — Background Photo",
			'description' => 'Upload a photo for this sport\'s card. Best size: 600×450px. Action shots work great!',
			'section'     => 'op_categories',
			'mime_type'   => 'image',
		] ) );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 8 — Achievement Numbers (animated stats bar)
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_stats', [
		'title'       => '🏆 Achievement Numbers',
		'description' => 'The row of big numbers that scroll into view — e.g. "500+ Teams Served". These animate (count up) when visitors scroll to them, which builds credibility fast.',
		'panel'       => 'op_theme_options',
		'priority'    => 70,
	] );

	$stat_defaults = [
		1 => [ 'icon' => '✅', 'value' => '500+',  'label' => 'Teams Served' ],
		2 => [ 'icon' => '🏅', 'value' => '15+',   'label' => 'Sports Covered' ],
		3 => [ 'icon' => '⚡', 'value' => 'Zero',  'label' => 'Minimum Order' ],
		4 => [ 'icon' => '⏱️', 'value' => '48hr',  'label' => 'Mockup' ],
	];

	for ( $i = 1; $i <= 4; $i++ ) {
		// Emoji
		$wpc->add_setting( "op_stat_{$i}_icon", [
			'default'           => $stat_defaults[ $i ]['icon'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_stat_{$i}_icon", [
			'type'        => 'text',
			'label'       => "Stat #{$i} — Emoji Icon",
			'description' => 'The emoji shown above the number. Example: 🏆 ⭐ 🌍 📦',
			'section'     => 'op_stats',
		] );

		// Value
		$wpc->add_setting( "op_stat_{$i}_value", [
			'default'           => $stat_defaults[ $i ]['value'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_stat_{$i}_value", [
			'type'        => 'text',
			'label'       => "Stat #{$i} — The Big Number or Word",
			'description' => 'Examples: 500+  |  15+  |  Zero  |  48hr  |  100%  |  10yrs',
			'section'     => 'op_stats',
		] );

		// Label
		$wpc->add_setting( "op_stat_{$i}_label", [
			'default'           => $stat_defaults[ $i ]['label'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_stat_{$i}_label", [
			'type'        => 'text',
			'label'       => "Stat #{$i} — Description below the number",
			'description' => 'A short label explaining what the number means. Examples: Teams Served, Countries Shipped, Years Experience',
			'section'     => 'op_stats',
		] );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 9 — How It Works (3-step process)
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_how_it_works', [
		'title'       => '📋 How It Works (3 Steps)',
		'description' => 'The simple 3-step process shown on your homepage — it reassures visitors that ordering is easy. Customise the title and description for each step.',
		'panel'       => 'op_theme_options',
		'priority'    => 80,
	] );

	$step_defaults = [
		1 => [
			'title' => 'Choose Your Sport',
			'desc'  => 'Select your category and tell us your roster sizes, team numbers, and basic design ideas. No design experience needed!',
		],
		2 => [
			'title' => 'Design Mockup',
			'desc'  => 'Our designers create a full-colour 3D digital mockup of your uniform within 48 hours — with no obligation.',
		],
		3 => [
			'title' => 'Approve & Receive',
			'desc'  => 'Once you\'re happy with the design, we manufacture and ship directly to your door in 2–3 weeks.',
		],
	];

	for ( $i = 1; $i <= 3; $i++ ) {
		$wpc->add_setting( "op_step_{$i}_title", [
			'default'           => $step_defaults[ $i ]['title'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_step_{$i}_title", [
			'type'        => 'text',
			'label'       => "Step {$i} — Heading",
			'description' => 'The bold title for this step. Keep it under 5 words.',
			'section'     => 'op_how_it_works',
		] );

		$wpc->add_setting( "op_step_{$i}_desc", [
			'default'           => $step_defaults[ $i ]['desc'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( "op_step_{$i}_desc", [
			'type'        => 'textarea',
			'label'       => "Step {$i} — Description",
			'description' => 'Explain this step in 1–2 sentences. Be reassuring — many customers worry about the process.',
			'section'     => 'op_how_it_works',
		] );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 10 — Footer Text
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_footer', [
		'title'       => '🔻 Footer (bottom of every page)',
		'description' => 'The very bottom section of every page on your website. Update your tagline and copyright year here.',
		'panel'       => 'op_theme_options',
		'priority'    => 90,
	] );

	$wpc->add_setting( 'op_footer_tagline', [
		'default'           => 'Premium custom sports uniforms directly from Sialkot, Pakistan — the global hub of sports manufacturing.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	] );
	$wpc->add_control( 'op_footer_tagline', [
		'type'        => 'textarea',
		'label'       => '💬 Your Brand Tagline (footer)',
		'description' => 'A sentence or two about your business that appears under your logo in the footer.',
		'section'     => 'op_footer',
	] );

	$wpc->add_setting( 'op_footer_copyright', [
		'default'           => '© ' . gmdate( 'Y' ) . ' Oria Patel Enterprises. All rights reserved.',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	] );
	$wpc->add_control( 'op_footer_copyright', [
		'type'        => 'text',
		'label'       => '©️ Copyright Text',
		'description' => 'Shown at the very bottom. Update the year and company name as needed. Example: © 2025 Your Company Name. All rights reserved.',
		'section'     => 'op_footer',
	] );

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 11 — Quote / Contact Page Settings
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_quote_form', [
		'title'       => '📬 Quote Form Settings',
		'description' => 'Settings for the quote request form on your Contact page.',
		'panel'       => 'op_theme_options',
		'priority'    => 95,
	] );

	$wpc->add_setting( 'op_form_success_message', [
		'default'           => 'Thank you! Your quote request has been sent. We will reply within 24 hours. 🎉',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_form_success_message', [
		'type'        => 'textarea',
		'label'       => '✅ Message shown after form is submitted',
		'description' => 'What should visitors see after they successfully send a quote request? Make it friendly and let them know when you\'ll reply.',
		'section'     => 'op_quote_form',
	] );

	$wpc->add_setting( 'op_form_reply_time', [
		'default'           => '24 hours',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_form_reply_time', [
		'type'        => 'text',
		'label'       => '⏰ Your typical reply time',
		'description' => 'How fast do you usually reply? This is shown as a reassurance near the form. Example: 24 hours, 2 hours, Same day',
		'section'     => 'op_quote_form',
	] );

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 12 — Homepage Section Labels
	   Control the eyebrow text and titles for every section on the homepage.
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_section_labels', [
		'title'       => '🏷️ Homepage Section Labels',
		'description' => 'Change the small eyebrow text and headings for each section on your homepage. You can also edit the CTA banner at the bottom of this section.',
		'panel'       => 'op_theme_options',
		'priority'    => 85,
	] );

	$section_label_fields = [
		[ 'op_section_eyebrow_cats', 'Browse by Sport',   '🏈 Category Grid — small label above the heading' ],
		[ 'op_section_title_cats',   'Shop by Category',  '🏈 Category Grid — main heading' ],
		[ 'op_section_eyebrow_top',  'Best Sellers',      '🛍️ Top Products — small label above the heading' ],
		[ 'op_section_title_top',    'Top Products',      '🛍️ Top Products — main heading' ],
		[ 'op_section_eyebrow_hiw',  'Simple Process',    '📋 How It Works — small label (already customisable in the "How It Works" section)' ],
		[ 'op_section_title_hiw',    'How It Works',      '📋 How It Works — main heading' ],
		[ 'op_cta_banner_title',     'Ready to outfit your team?', '🎯 CTA Banner — main headline at the bottom of the homepage' ],
		[ 'op_cta_banner_desc',      'Get a design mockup within 48 hours. No minimums, no commitment.', '🎯 CTA Banner — supporting text' ],
		[ 'op_cta_btn1_text',        'Get Quote',         '🎯 CTA Banner — left button text' ],
		[ 'op_cta_btn2_text',        'Browse Products',   '🎯 CTA Banner — right button text' ],
		[ 'op_products_page_title',  'Our Products',      '🛒 Products archive page — main heading' ],
		[ 'op_products_page_sub',    'Custom sports uniforms manufactured in Sialkot, Pakistan. Zero minimum order.', '🛒 Products archive page — sub-heading below the title' ],
	];

	foreach ( $section_label_fields as $f ) {
		$wpc->add_setting( $f[0], [
			'default'           => $f[1],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wpc->add_control( $f[0], [
			'type'        => 'text',
			'label'       => $f[2],
			'section'     => 'op_section_labels',
		] );
	}

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 13 — WhatsApp & Floating Bubble
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_whatsapp', [
		'title'       => '💬 WhatsApp Floating Button',
		'description' => 'The green WhatsApp button that floats in the bottom-right corner of every page. Visitors can click it to message you instantly.',
		'panel'       => 'op_theme_options',
		'priority'    => 12,
	] );

	$wpc->add_setting( 'op_whatsapp_bubble_show', [
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_whatsapp_bubble_show', [
		'type'        => 'checkbox',
		'label'       => '✅ Show the floating WhatsApp button',
		'description' => 'Uncheck to hide the green WhatsApp bubble. You can still have the WhatsApp link in your footer by filling in the Social Media Links section.',
		'section'     => 'op_whatsapp',
	] );

	$wpc->add_setting( 'op_whatsapp_bubble_number', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_whatsapp_bubble_number', [
		'type'        => 'text',
		'label'       => '📱 WhatsApp Phone Number (for the bubble)',
		'description' => 'Enter your number with country code but no spaces or dashes. Example: 923117337511 (that\'s +92 311 7337511). Leave blank to use the WhatsApp link from the Social Media section.',
		'section'     => 'op_whatsapp',
	] );

	$wpc->add_setting( 'op_whatsapp_bubble_message', [
		'default'           => 'Hello! I\'m interested in custom sports uniforms.',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_whatsapp_bubble_message', [
		'type'        => 'text',
		'label'       => '💬 Pre-filled Message',
		'description' => 'The message that auto-fills in WhatsApp when a visitor clicks the button. Make it welcoming and relevant.',
		'section'     => 'op_whatsapp',
	] );

	/* ───────────────────────────────────────────────────────────────────────
	   SECTION 14 — Advanced / SEO Overrides
	─────────────────────────────────────────────────────────────────────── */
	$wpc->add_section( 'op_seo', [
		'title'       => '🔍 SEO & Search Overrides',
		'description' => 'Fine-tune what search engines see for your homepage. Leave blank to use the smart auto-generated values.',
		'panel'       => 'op_theme_options',
		'priority'    => 98,
	] );

	$wpc->add_setting( 'op_seo_home_title', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_seo_home_title', [
		'type'        => 'text',
		'label'       => '🔖 Homepage SEO Title (shown in Google results)',
		'description' => 'The page title that Google shows. Keep under 60 characters. Leave blank for the auto-generated title.',
		'section'     => 'op_seo',
	] );

	$wpc->add_setting( 'op_seo_home_desc', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_seo_home_desc', [
		'type'        => 'textarea',
		'label'       => '📝 Homepage Meta Description (shown under your title in Google)',
		'description' => 'A short summary of your business for search engines. 140–160 characters works best. Leave blank for the auto-generated description.',
		'section'     => 'op_seo',
	] );

	$wpc->add_setting( 'op_seo_google_code', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	] );
	$wpc->add_control( 'op_seo_google_code', [
		'type'        => 'text',
		'label'       => '📊 Google Analytics Measurement ID',
		'description' => 'Paste your Google Analytics 4 ID here (starts with G-). Example: G-XXXXXXXXXX. Leave blank if you are using a plugin for analytics.',
		'section'     => 'op_seo',
	] );

} ); // end customize_register


/* ─── Customizer Live Preview ─────────────────────────────────────────────
   This loads the preview JS that makes changes show up instantly
   without needing a full page refresh.
──────────────────────────────────────────────────────────────────────── */
add_action( 'customize_preview_init', function () {
	wp_enqueue_script(
		'op-customizer-preview',
		OP_URI . '/assets/js/customizer-preview.js',
		[ 'jquery', 'customize-preview' ],
		OP_VERSION,
		true
	);
} );

/* ─── Customizer Control Panel Styles ────────────────────────────────────── */
add_action( 'customize_controls_enqueue_scripts', function () {
	wp_enqueue_style( 'op-customizer-controls', OP_URI . '/assets/css/customizer.css', [], OP_VERSION );
} );

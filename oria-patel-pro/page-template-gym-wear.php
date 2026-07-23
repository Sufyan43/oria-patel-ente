<?php
/**
 * Template Name: Gym Wear Landing
 * Template Post Type: page
 *
 * Landing page for custom gym wear, fitness apparel, and activewear.
 */

defined( 'ABSPATH' ) || exit;

$op_landing = [
	'title'       => 'Custom Gym & Fitness Wear',
	'slug'        => 'gym-wear',
	'hero_sub'    => 'Private Label Activewear · Zero Minimum Order · Free 48-Hour Design Mockup',
	'price_from'  => 'From $9/piece',
	'price_note'  => 'Final price depends on fabric choice, design complexity, and quantity. Request a free quote.',
	'hero_cta_text' => 'Get Free Mockup in 48h',
	'whatsapp_msg'  => "Hi Oria Patel Enterprises, I'm interested in custom gym and fitness wear. Can you help?",
	'products'    => [
		[ 'name' => 'Custom Gym T-Shirt',          'price' => 'From $9/piece',  'desc' => '100% polyester, moisture-wicking, full sublimation print, fitted or loose cut.' ],
		[ 'name' => 'Sports Leggings',              'price' => 'From $11/piece', 'desc' => 'High-waist, 4-way stretch, custom print, compression or relaxed fit.' ],
		[ 'name' => 'Gym Tank Top / Singlet',       'price' => 'From $8/piece',  'desc' => 'Lightweight, breathable, cut-away or standard, custom logo & colours.' ],
		[ 'name' => 'Sports Shorts',                'price' => 'From $9/piece',  'desc' => 'Quick-dry, custom length, with or without pockets, full sublimation.' ],
		[ 'name' => 'Sports Hoodie / Sweatshirt',   'price' => 'From $18/piece', 'desc' => 'Fleece-lined, custom embroidery or print, kangaroo pocket available.' ],
		[ 'name' => 'Full Gym Set (Top + Bottom)',   'price' => 'From $20/set',   'desc' => 'Matching top and bottom in your brand colours — ideal for gym class or PT uniforms.' ],
	],
	'faqs' => [
		[ 'q' => 'Can I add my gym brand / logo to the clothing?',    'a' => 'Yes! Every piece is custom-made with your logo, brand colours, and any text you need. This is perfect for gym owners, personal trainers, and fitness studios wanting a branded look.' ],
		[ 'q' => 'What fabrics do you use for gym wear?',             'a' => 'We use high-performance polyester blends including spandex/lycra for leggings and compression gear, moisture-wicking polyester for tops and shorts, and fleece-poly blends for hoodies.' ],
		[ 'q' => 'Do you offer private-label packaging?',             'a' => 'Yes. We can add hang tags, woven labels, and heat-transfer labels with your brand name so the garments look professionally retail-ready.' ],
		[ 'q' => 'Is there a size range available?',                  'a' => 'We produce from XS to 5XL. Custom sizes are also available — just provide your measurements and we will cut to spec.' ],
	],
];

require get_template_directory() . '/inc/landing-template.php';

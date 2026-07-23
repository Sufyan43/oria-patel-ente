<?php
/**
 * Template Name: Gloves
 * Template Post Type: page
 *
 * Landing page for custom sports gloves — goalkeeper, batting, cycling, boxing.
 */

defined( 'ABSPATH' ) || exit;

$op_landing = [
	'title'       => 'Custom Sports Gloves',
	'slug'        => 'gloves',
	'hero_sub'    => 'Goalkeeper · Batting · Cycling · Boxing — Zero MOQ · Free 48-Hour Design Mockup',
	'price_from'  => 'From $6/pair',
	'price_note'  => 'Final price depends on glove type, material, and padding. Request a free quote for exact pricing.',
	'hero_cta_text' => 'Get Free Mockup in 48h',
	'whatsapp_msg'  => "Hi Oria Patel Enterprises, I'm interested in custom sports gloves. Can you help?",
	'products'    => [
		[ 'name' => 'Goalkeeper Gloves',    'price' => 'From $12/pair', 'desc' => 'Latex palm, custom print, finger saves available, all sizes.' ],
		[ 'name' => 'Batting Gloves',       'price' => 'From $10/pair', 'desc' => 'Sheepskin palm, nylon back, Velcro wrist, custom logo & colours.' ],
		[ 'name' => 'Cycling Gloves',       'price' => 'From $8/pair',  'desc' => 'Gel padding, breathable mesh, custom sublimation, half or full finger.' ],
		[ 'name' => 'Boxing / MMA Gloves',  'price' => 'From $18/pair', 'desc' => 'Multi-layer foam, genuine or synthetic leather, custom colour & logo.' ],
		[ 'name' => 'Football Receiver Gloves', 'price' => 'From $9/pair', 'desc' => 'Sticky grip palm, lightweight, custom sublimation design.' ],
		[ 'name' => 'Winter Sports Gloves', 'price' => 'From $11/pair', 'desc' => 'Thermal insulation, waterproof shell, custom branding.' ],
	],
	'faqs' => [
		[ 'q' => 'Can I put my team logo on the gloves?',               'a' => 'Yes — all our gloves are fully customisable with your logo, team colours, player names, and any design elements you need.' ],
		[ 'q' => 'What materials do you use?',                          'a' => 'We use high-quality latex (goalkeeper), sheepskin (batting), synthetic leather (boxing/MMA), and technical mesh fabrics depending on the glove type.' ],
		[ 'q' => 'Do you have size charts?',                            'a' => 'Yes. We produce gloves in XS through XXL and can produce custom sizes from your measurements. Size charts are sent with your mockup.' ],
		[ 'q' => 'What is the minimum order?',                          'a' => 'Zero minimum. We make from 1 pair up to bulk runs. Price per pair decreases significantly for orders above 50 pairs.' ],
	],
];

require get_template_directory() . '/inc/landing-template.php';

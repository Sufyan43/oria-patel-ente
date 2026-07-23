<?php
/**
 * Template Name: Sports Uniforms Landing
 * Template Post Type: page
 *
 * Landing page for Soccer, Football, Baseball, Basketball & all sports uniforms.
 */

defined( 'ABSPATH' ) || exit;

$op_landing = [
	'title'       => 'Custom Sports Uniforms',
	'slug'        => 'sports-uniforms',
	'hero_sub'    => 'Zero Minimum Order · Free 48-Hour Design Mockup · Factory Direct from Sialkot Since 1992',
	'price_from'  => 'From $8/piece',
	'price_note'  => 'Final price depends on design complexity, quantity, and shipping location. Request a free quote for exact pricing.',
	'hero_cta_text' => 'Get Free Mockup in 48h',
	'products'    => [
		[ 'name' => 'Soccer / Football Jersey',      'price' => 'From $8/piece',  'desc' => 'Full sublimation, breathable polyester mesh, custom name & number.' ],
		[ 'name' => 'Basketball Uniform Set',         'price' => 'From $10/set',   'desc' => 'Jersey + shorts, lightweight mesh, moisture-wicking fabric.' ],
		[ 'name' => 'Baseball / Softball Uniform',    'price' => 'From $12/set',   'desc' => 'Full uniform set, custom logo, player name, pinstripe available.' ],
		[ 'name' => 'Hockey Jersey',                  'price' => 'From $14/piece', 'desc' => 'Durable polyester, full sublimation, reinforced stitching.' ],
		[ 'name' => 'Rugby Jersey',                   'price' => 'From $11/piece', 'desc' => 'Heavy-duty fabric, moisture management, bold custom designs.' ],
		[ 'name' => 'Volleyball Jersey',              'price' => 'From $9/piece',  'desc' => 'Stretch fabric, slim fit, custom numbers & team colours.' ],
	],
	'faqs' => [
		[ 'q' => 'What is the minimum order quantity?',              'a' => 'Absolutely zero! We manufacture as few as 1 piece. There is no minimum order — perfect for small clubs, school teams, or single custom orders.' ],
		[ 'q' => 'How long does production take?',                   'a' => 'You receive a free digital mockup within 48 hours of your design request. After approval, production typically takes 7–14 days depending on quantity. Shipping adds 5–10 days worldwide.' ],
		[ 'q' => 'Can I customise the colours, logo, and numbers?',  'a' => 'Yes — everything is 100% customisable. Colours, fonts, logos, player names, numbers, collar style, sleeve design — you name it. Our designers work from your brief.' ],
		[ 'q' => 'Do you ship to my country?',                       'a' => 'Yes. We ship to 35+ countries including USA, UK, Australia, Canada, Germany, and more. Shipping cost depends on quantity and destination. Ask for a quote.' ],
	],
];

require get_template_directory() . '/inc/landing-template.php';

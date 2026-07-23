<?php
/**
 * Template Name: General products
 * Template Post Type: page
 *
 * General products landing page — used for all-products or mixed catalogue pages.
 */

defined( 'ABSPATH' ) || exit;

$op_landing = [
	'title'       => 'Custom Sports Products',
	'slug'        => '',
	'hero_sub'    => 'Uniforms · Gym Wear · Jackets · Accessories — Zero MOQ · Free 48-Hour Design Mockup',
	'price_from'  => 'From $6/piece',
	'price_note'  => 'Price depends on product type, material, and design. Request a free quote for exact pricing on your specific order.',
	'hero_cta_text' => 'Get Free Mockup in 48h',
	'whatsapp_msg'  => "Hi Oria Patel Enterprises, I'm interested in your custom sports products. Can you help?",
	'products'    => [
		[ 'name' => 'Sports Uniforms',       'price' => 'From $8/piece',  'desc' => 'Soccer, basketball, baseball, hockey — all sports covered.' ],
		[ 'name' => 'Gym & Fitness Wear',    'price' => 'From $9/piece',  'desc' => 'T-shirts, leggings, shorts, tank tops — all customisable.' ],
		[ 'name' => 'Varsity Jackets',       'price' => 'From $35/piece', 'desc' => 'Wool, leather sleeves, chenille patches — classic American style.' ],
		[ 'name' => 'Sports Gloves',         'price' => 'From $6/pair',   'desc' => 'Goalkeeper, batting, cycling, boxing — custom design.' ],
		[ 'name' => 'Sports Bags & Backpacks', 'price' => 'From $10/piece', 'desc' => 'Duffel bags, backpacks, drawstring bags — custom logo.' ],
		[ 'name' => 'Sports Socks',          'price' => 'From $3/pair',   'desc' => 'Custom colour, stripe, logo — all sports.' ],
	],
	'faqs' => [
		[ 'q' => 'What kinds of products do you manufacture?',              'a' => 'We manufacture sports uniforms (soccer, basketball, baseball, hockey, rugby, volleyball), gym & fitness wear, varsity jackets, sports gloves, bags, socks, caps, and baby/kids sportswear. If you need something not listed, just ask.' ],
		[ 'q' => 'Do I need to send my own designs?',                      'a' => 'No. If you have a design or logo, great — send it over. If not, just describe your colours and ideas and our in-house designers will create the design as part of your free mockup.' ],
		[ 'q' => 'What is your typical turnaround time?',                  'a' => 'Free digital mockup within 48 hours. Production: 7–21 days depending on product complexity and quantity. Worldwide shipping: 5–10 days additional.' ],
		[ 'q' => 'Do you have a catalogue I can browse?',                  'a' => 'Browse our Products page for our current range. For the full catalogue including samples and pricing, chat with us on WhatsApp or fill in the quote form and we will send everything over.' ],
	],
];

require get_template_directory() . '/inc/landing-template.php';

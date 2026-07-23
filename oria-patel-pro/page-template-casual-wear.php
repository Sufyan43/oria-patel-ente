<?php
/**
 * Template Name: Casual Wear Landing
 * Template Post Type: page
 *
 * Landing page for custom casual and streetwear apparel.
 */

defined( 'ABSPATH' ) || exit;

$op_landing = [
	'title'       => 'Custom Casual & Streetwear',
	'slug'        => 'casual-wear',
	'hero_sub'    => 'T-Shirts · Hoodies · Sweatpants — Zero MOQ · Free 48-Hour Design Mockup',
	'price_from'  => 'From $7/piece',
	'price_note'  => 'Price depends on garment type, print method, and quantity. Request a free quote for exact pricing.',
	'hero_cta_text' => 'Get Free Mockup in 48h',
	'whatsapp_msg'  => "Hi Oria Patel Enterprises, I'm interested in custom casual wear / streetwear. Can you help?",
	'products'    => [
		[ 'name' => 'Custom T-Shirt (100% Cotton)',    'price' => 'From $7/piece',  'desc' => 'Premium 180gsm cotton, screen print or DTG, custom logo & text.' ],
		[ 'name' => 'Custom Hoodie',                   'price' => 'From $20/piece', 'desc' => 'Fleece-lined, pullover or zip, custom embroidery or print, all colours.' ],
		[ 'name' => 'Custom Polo Shirt',               'price' => 'From $9/piece',  'desc' => 'Piqué cotton or polyester, embroidered logo, custom colours.' ],
		[ 'name' => 'Sweatpants / Joggers',            'price' => 'From $14/piece', 'desc' => 'Fleece or French terry, drawstring, custom branding, relaxed or tapered.' ],
		[ 'name' => 'Custom Cap / Hat',                'price' => 'From $8/piece',  'desc' => 'Structured or unstructured, 5 or 6 panel, embroidered logo.' ],
		[ 'name' => 'Custom Tote / Drawstring Bag',    'price' => 'From $5/piece',  'desc' => 'Cotton canvas or polyester, custom print, great for team merchandise.' ],
	],
	'faqs' => [
		[ 'q' => 'What print methods do you use for casual wear?',      'a' => 'We offer screen printing (best for bulk), sublimation (for all-over designs), embroidery (for logos on polos and hats), and heat-transfer printing for smaller runs.' ],
		[ 'q' => 'Can you do custom packaging for my clothing brand?',  'a' => 'Yes. We provide hang tags, woven labels, polybag packaging, and custom-branded packaging to help you launch a retail-ready clothing line.' ],
		[ 'q' => 'Is there a minimum order?',                           'a' => 'No minimum order at all. Order 1 piece or 10,000 — we accommodate every scale.' ],
		[ 'q' => 'Do you offer samples before bulk production?',        'a' => 'Yes. We can produce a physical sample before full production. Sample turnaround is 5–7 business days. Contact us for sample pricing.' ],
	],
];

require get_template_directory() . '/inc/landing-template.php';

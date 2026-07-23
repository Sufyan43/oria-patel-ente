<?php
/**
 * Template Name: Jackets Landing
 * Template Post Type: page
 *
 * Landing page for varsity jackets, bomber jackets, and team outerwear.
 */

defined( 'ABSPATH' ) || exit;

$op_landing = [
	'title'       => 'Custom Varsity & Bomber Jackets',
	'slug'        => 'jackets',
	'hero_sub'    => 'Letterman · Bomber · Track — Zero MOQ · Free 48-Hour Design Mockup',
	'price_from'  => 'From $35/piece',
	'price_note'  => 'Final price depends on materials (wool, leather sleeves, nylon), embroidery detail, and quantity. Request a free quote for exact pricing.',
	'hero_cta_text' => 'Get Free Mockup in 48h',
	'whatsapp_msg'  => "Hi Oria Patel Enterprises, I'm interested in custom varsity or bomber jackets. Can you help?",
	'products'    => [
		[ 'name' => 'Classic Varsity Letterman Jacket', 'price' => 'From $45/piece', 'desc' => 'Wool body, genuine leather sleeves, chenille patches, custom lining.' ],
		[ 'name' => 'Bomber Jacket',                    'price' => 'From $38/piece', 'desc' => 'Nylon shell, ribbed cuffs, custom embroidery or sublimation, all colours.' ],
		[ 'name' => 'Track / Coach Jacket',             'price' => 'From $35/piece', 'desc' => 'Lightweight polyester, full-zip, custom print or embroidery, team colours.' ],
		[ 'name' => 'Puffer / Padded Jacket',           'price' => 'From $40/piece', 'desc' => 'Quilted insulation, water-resistant shell, custom logo placement.' ],
		[ 'name' => 'Windbreaker',                      'price' => 'From $30/piece', 'desc' => 'Lightweight nylon, packable, custom sublimation, great for team kits.' ],
		[ 'name' => 'Hoodie Zip-Up',                    'price' => 'From $22/piece', 'desc' => 'Fleece interior, full-zip, custom embroidery or heat transfer, kangaroo pocket.' ],
	],
	'faqs' => [
		[ 'q' => 'Can I mix wool body with leather sleeves on a varsity jacket?', 'a' => 'Yes — the classic varsity letterman style. You choose the body and sleeve materials, colours, chenille letter patches, and internal lining. We produce exactly to your specification.' ],
		[ 'q' => 'Do you do embroidery on jackets?',                              'a' => 'Absolutely. We offer high-quality machine embroidery for logos, lettering, and patches, as well as sublimation printing for all-over designs on lightweight jackets.' ],
		[ 'q' => 'What is the lead time for jackets?',                            'a' => 'You get your free design mockup within 48 hours. After approval, production is typically 14–21 days for jackets due to more complex construction. We then ship worldwide.' ],
		[ 'q' => 'Can I order just 1 jacket?',                                    'a' => 'Yes! There is absolutely zero minimum order. We manufacture from a single piece up to thousands.' ],
	],
];

require get_template_directory() . '/inc/landing-template.php';

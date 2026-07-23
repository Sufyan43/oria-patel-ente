<?php
/**
 * Template Name: Baby Products
 * Template Post Type: page
 *
 * Landing page for custom baby & kids sportswear.
 */

defined( 'ABSPATH' ) || exit;

$op_landing = [
	'title'       => 'Custom Baby & Kids Sportswear',
	'slug'        => 'baby-products',
	'hero_sub'    => 'Safe · Soft · Custom — Zero MOQ · Free 48-Hour Design Mockup',
	'price_from'  => 'From $6/piece',
	'price_note'  => 'Price depends on garment type and design. All fabrics are OEKO-TEX safe and tested for children. Request a quote for exact pricing.',
	'hero_cta_text' => 'Get Free Mockup in 48h',
	'whatsapp_msg'  => "Hi Oria Patel Enterprises, I'm interested in custom baby or kids sportswear. Can you help?",
	'products'    => [
		[ 'name' => 'Baby Sports Onesie',         'price' => 'From $6/piece',  'desc' => 'Soft cotton, snap buttons, custom print, sizes 0–24 months.' ],
		[ 'name' => 'Kids Sports T-Shirt',         'price' => 'From $7/piece',  'desc' => 'Moisture-wicking polyester, custom sublimation, sizes 2–12 years.' ],
		[ 'name' => 'Kids Football / Soccer Kit',  'price' => 'From $14/set',   'desc' => 'Jersey + shorts set, breathable mesh, custom team design.' ],
		[ 'name' => 'Kids Hoodie',                 'price' => 'From $16/piece', 'desc' => 'Soft fleece, custom logo embroidery or print, sizes 2–12 years.' ],
		[ 'name' => 'Kids Track Suit',             'price' => 'From $18/set',   'desc' => 'Full tracksuit (top + bottoms), custom team colours and logo.' ],
		[ 'name' => 'Kids Sports Socks',           'price' => 'From $3/pair',   'desc' => 'Cotton blend, custom colour stripe, sizes UK 6–7 child to 4–6 adult.' ],
	],
	'faqs' => [
		[ 'q' => 'Are the fabrics safe for babies and young children?', 'a' => 'Yes. We use only OEKO-TEX certified, non-toxic, hypoallergenic fabrics and inks for all children\'s garments. Safety is our top priority for kids\' products.' ],
		[ 'q' => 'What sizes do you produce for children?',             'a' => 'Baby sizes from 0–24 months, and kids sizes from 2 years up to 14 years. Custom sizes are also available from measurements.' ],
		[ 'q' => 'Can I put a school or club logo on children\'s kit?', 'a' => 'Absolutely. School crests, club logos, player names, and numbers are all fully customisable.' ],
		[ 'q' => 'Is there a minimum order?',                           'a' => 'No minimum order. Whether you need 1 custom baby onesie or a full school football kit for 200 children, we accommodate every quantity.' ],
	],
];

require get_template_directory() . '/inc/landing-template.php';

<?php
/**
 * Template Name: FAQ's
 * Template Post Type: page
 *
 * Full FAQ page with accordion sections.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$_wa_number = preg_replace( '/[^0-9]/', '', get_theme_mod( 'op_contact_phone', '923117337511' ) ) ?: '923117337511';
$_wa_url    = 'https://wa.me/' . $_wa_number . '?text=' . rawurlencode( "Hi Oria Patel Enterprises, I have a question about your custom sports uniforms. Can you help?" );

$faq_sections = [
	[
		'section' => 'Ordering & Minimum Quantities',
		'items'   => [
			[ 'q' => 'What is the minimum order quantity?',              'a' => 'Absolutely zero! We manufacture from a single piece up to thousands. There is no minimum order — ideal for small clubs, school teams, or individual custom orders.' ],
			[ 'q' => 'Can I order a sample before placing a bulk order?', 'a' => 'Yes. Physical samples are available with a 5–7 day turnaround. Contact us for sample pricing. Most customers approve their design from the free digital mockup without needing a physical sample.' ],
			[ 'q' => 'How do I place an order?',                         'a' => 'Simply fill in the quote form on this website or chat with us on WhatsApp. Share your design ideas, colours, and logo. We send back a free digital mockup within 48 hours. Once you approve, we begin production.' ],
		],
	],
	[
		'section' => 'Design & Customisation',
		'items'   => [
			[ 'q' => 'Do I need to be a designer to order?',             'a' => 'Not at all. Just describe your team colours, sport, and any ideas. Our in-house designers will create the design for you. If you have a logo or existing design file, even better — send it over.' ],
			[ 'q' => 'What file formats do you accept for logos?',       'a' => 'We prefer vector files (AI, EPS, SVG, PDF). High-resolution PNG files (300dpi+) also work well. We can also recreate your logo from a photo if needed — just ask.' ],
			[ 'q' => 'How many colours can I use in my design?',         'a' => 'As many as you like. Our sublimation printing process supports unlimited colours at no extra cost — gradients, photos, complex graphics all included.' ],
			[ 'q' => 'Can I add player names and numbers?',              'a' => 'Yes. Player names, numbers, and sponsor logos can all be added to individual pieces within your order at no extra cost.' ],
		],
	],
	[
		'section' => 'Pricing & Payment',
		'items'   => [
			[ 'q' => 'How is pricing calculated?',                       'a' => 'Price depends on: product type, fabric/material, design complexity, and quantity. Larger quantities mean lower per-unit cost. Request a free quote for exact pricing on your order.' ],
			[ 'q' => 'What currencies do you accept?',                   'a' => 'We invoice in USD. Payment is accepted via bank transfer (SWIFT/TT), PayPal, and Western Union. Contact us to discuss payment options for your country.' ],
			[ 'q' => 'Do I pay upfront?',                                'a' => 'We typically require a 50% deposit to start production, with the balance due before shipping. For repeat customers, we offer flexible terms.' ],
		],
	],
	[
		'section' => 'Production & Shipping',
		'items'   => [
			[ 'q' => 'How long does production take?',                   'a' => 'You receive a free digital mockup within 48 hours. After approval, production is typically 7–14 days for uniforms, 14–21 days for jackets. Shipping adds 5–10 days worldwide.' ],
			[ 'q' => 'Do you ship worldwide?',                           'a' => 'Yes! We ship to 35+ countries including USA, UK, Australia, Canada, Germany, France, Netherlands, and more. We use DHL, FedEx, and EMS depending on your location.' ],
			[ 'q' => 'Is there tracking for my shipment?',               'a' => 'Yes. We provide full shipment tracking as soon as your order is dispatched. You\'ll receive the tracking number by email.' ],
			[ 'q' => 'What if there is a quality issue with my order?',  'a' => 'We quality-check every item before shipment. If any item has a manufacturing defect, we replace it at no cost. Customer satisfaction is our priority — we have maintained it since 1992.' ],
		],
	],
	[
		'section' => 'About Oria Patel Enterprises',
		'items'   => [
			[ 'q' => 'Where are you based?',                             'a' => 'Our factory is in Sialkot, Pakistan — the world\'s leading hub for sports manufacturing. Over 70% of the world\'s footballs and a significant portion of global sportswear are made here.' ],
			[ 'q' => 'How long have you been in business?',              'a' => 'We have been manufacturing custom sports uniforms since 1992 — over 30 years of experience. We have served 500+ clients across 35+ countries.' ],
			[ 'q' => 'Are you a factory or a middleman?',                'a' => 'We are a factory. You deal directly with us — no middlemen, no agents, no extra markups. That is why our pricing is factory-direct competitive.' ],
		],
	],
];
?>
<main id="main" class="op-site-main" role="main">

<div class="op-page-hero op-page-hero--faq">
	<div class="op-container">
		<h1 class="op-page-hero__title">Frequently Asked Questions</h1>
		<p class="op-page-hero__sub">Everything you need to know about ordering custom sports uniforms from Oria Patel Enterprises.</p>
	</div>
</div>

<section class="op-section">
	<div class="op-container op-faq-page">
		<?php foreach ( $faq_sections as $section ) : ?>
		<div class="op-faq-section">
			<h2 class="op-faq-section__heading"><?php echo esc_html( $section['section'] ); ?></h2>
			<div class="op-faq">
				<?php foreach ( $section['items'] as $i => $item ) : ?>
				<div class="op-faq__item">
					<button class="op-faq__question" aria-expanded="false" aria-controls="op-faq-pg-<?php echo esc_attr( sanitize_title( $item['q'] ) ); ?>">
						<?php echo esc_html( $item['q'] ); ?>
						<span class="op-faq__icon" aria-hidden="true">+</span>
					</button>
					<div class="op-faq__answer" id="op-faq-pg-<?php echo esc_attr( sanitize_title( $item['q'] ) ); ?>" hidden>
						<p><?php echo esc_html( $item['a'] ); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endforeach; ?>

		<div class="op-faq-cta op-reveal">
			<h3>Still have questions?</h3>
			<p>Our team is available 24/7 to help. Chat with us directly on WhatsApp — we reply within a few hours.</p>
			<div style="display:flex;gap:16px;flex-wrap:wrap;margin-top:20px">
				<a href="<?php echo esc_url( $_wa_url ); ?>" class="op-btn op-btn--wa" target="_blank" rel="noopener noreferrer">
					💬 Chat on WhatsApp
				</a>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--outline">
					Send a Message
				</a>
			</div>
		</div>
	</div>
</section>

</main>
<?php get_footer(); ?>

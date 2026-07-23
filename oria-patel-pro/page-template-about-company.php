<?php
/**
 * Template Name: About Company
 * Template Post Type: page
 *
 * About page for Oria Patel Enterprises — company history, values, factory, team.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$_wa_number = preg_replace( '/[^0-9]/', '', get_theme_mod( 'op_contact_phone', '923117337511' ) ) ?: '923117337511';
$_wa_url    = 'https://wa.me/' . $_wa_number . '?text=' . rawurlencode( "Hi, I'd like to learn more about Oria Patel Enterprises." );
?>
<main id="main" class="op-site-main" role="main">

<!-- Hero -->
<div class="op-page-hero">
	<div class="op-container">
		<p class="op-page-hero__eyebrow">Sialkot, Pakistan · Est. 1992</p>
		<h1 class="op-page-hero__title">About Oria Patel Enterprises</h1>
		<p class="op-page-hero__sub">Thirty years of manufacturing excellence — factory-direct custom sports uniforms for teams worldwide.</p>
	</div>
</div>

<!-- Story section -->
<section class="op-section">
	<div class="op-container">
		<div class="op-about-grid op-reveal">
			<div class="op-about-grid__text">
				<p class="op-section-eyebrow">Our Story</p>
				<h2 class="op-section-title">Crafting Champions' Kits Since 1992</h2>
				<p>Oria Patel Enterprises was founded in Sialkot, Pakistan — the world's foremost hub for sports manufacturing. For over three decades, we have supplied custom sports uniforms and apparel to youth leagues, professional clubs, gym owners, and sports brands across 35+ countries.</p>
				<p>What sets us apart is simple: <strong>you deal directly with our factory</strong>. No middlemen, no agents, no inflated margins. Every garment is manufactured under our own roof, quality-checked by our team, and shipped directly to your door.</p>
				<p>We offer <strong>zero minimum order</strong> — because we believe every team, no matter how small, deserves professional-quality kit. And every new customer gets a <strong>free design mockup within 48 hours</strong>, so you can see exactly what you're getting before a single stitch is made.</p>
			</div>
			<div class="op-about-grid__image">
				<div class="op-about-image-placeholder">
					<span>📸</span>
					<p>Add your factory / team photo here<br><small>Recommended: 800×600px</small></p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Stats -->
<section class="op-section op-section--alt">
	<div class="op-container">
		<div class="op-about-stats op-reveal">
			<?php
			$stats = [
				[ '30+',  'Years of Experience',    'Established 1992 in Sialkot, Pakistan' ],
				[ '500+', 'Happy Clients',           'Teams, clubs, and brands worldwide' ],
				[ '35+',  'Countries Served',        'USA, UK, Australia, Canada, Europe & beyond' ],
				[ '12+',  'Sports Covered',          'Soccer, gym, jackets, baseball & more' ],
				[ '0',    'Minimum Order',            'Order a single piece with no restrictions' ],
				[ '48h',  'Free Mockup Turnaround',  'Digital preview before production begins' ],
			];
			foreach ( $stats as $s ) : ?>
			<div class="op-about-stat">
				<div class="op-about-stat__value"><?php echo esc_html( $s[0] ); ?></div>
				<div class="op-about-stat__label"><?php echo esc_html( $s[1] ); ?></div>
				<div class="op-about-stat__desc"><?php echo esc_html( $s[2] ); ?></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Values -->
<section class="op-section">
	<div class="op-container">
		<div class="op-section-header op-reveal" style="flex-direction:column;align-items:flex-start">
			<p class="op-section-eyebrow">What We Stand For</p>
			<h2 class="op-section-title">Our Core Values</h2>
		</div>
		<div class="op-values-grid op-reveal">
			<?php
			$values = [
				[ '🎯', 'Customer First',      'Every decision starts with what is best for our customer. Your satisfaction is non-negotiable.' ],
				[ '🏭', 'Factory Transparency', 'We are proud of our factory and processes. No hidden surprises — what you see in the mockup is what you get.' ],
				[ '⚡', 'Speed Without Compromise', '48-hour mockups and fast production without ever sacrificing the quality our reputation is built on.' ],
				[ '🌍', 'Global Accessibility', 'Zero MOQ means any team anywhere in the world can access the same factory-quality kit as the big clubs.' ],
			];
			foreach ( $values as $v ) : ?>
			<div class="op-value-card">
				<div class="op-value-card__icon" aria-hidden="true"><?php echo esc_html( $v[0] ); ?></div>
				<h3 class="op-value-card__title"><?php echo esc_html( $v[1] ); ?></h3>
				<p class="op-value-card__desc"><?php echo esc_html( $v[2] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Factory photos -->
<section class="op-section op-section--alt">
	<div class="op-container">
		<div class="op-section-header op-reveal" style="flex-direction:column;align-items:flex-start">
			<p class="op-section-eyebrow">Made in Sialkot</p>
			<h2 class="op-section-title">Inside Our Factory</h2>
		</div>
		<div class="op-factory-grid op-reveal">
			<?php
			$factory_images = [
				[ 'caption' => 'Our factory floor in Sialkot, Pakistan' ],
				[ 'caption' => 'Quality control on every stitch' ],
				[ 'caption' => 'Our sublimation printing department' ],
				[ 'caption' => 'Finished uniforms ready for worldwide shipping' ],
			];
			foreach ( $factory_images as $fi ) : ?>
			<div class="op-factory-img-slot">
				<div class="op-factory-img-placeholder">
					<span>📸</span>
					<small>Add your factory photo here<br>800×600px recommended</small>
				</div>
				<p class="op-factory-img-caption"><?php echo esc_html( $fi['caption'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Trust badges -->
<section class="op-section">
	<div class="op-container">
		<div class="op-trust-badges op-reveal">
			<div class="op-trust-badge"><span>🔒</span><p>Secure Payment</p></div>
			<div class="op-trust-badge"><span>✅</span><p>Verified Manufacturer</p></div>
			<div class="op-trust-badge"><span>⭐</span><p>Quality Guaranteed</p></div>
			<div class="op-trust-badge"><span>✈️</span><p>Fast Worldwide Shipping</p></div>
			<div class="op-trust-badge"><span>🏭</span><p>Factory Direct</p></div>
			<div class="op-trust-badge"><span>📦</span><p>Zero Minimum Order</p></div>
		</div>
	</div>
</section>

<!-- CTA -->
<section class="op-section op-cta-section">
	<div class="op-container">
		<div class="op-cta-section__inner op-reveal" style="flex-direction:column;text-align:center;align-items:center">
			<h2>Ready to work with us?</h2>
			<p>Get a free design mockup for your team within 48 hours. Zero minimum order, zero obligation.</p>
			<div style="display:flex;gap:16px;flex-wrap:wrap;justify-content:center;margin-top:24px">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--cta op-btn--lg">
					Get Free Mockup in 48h
				</a>
				<a href="<?php echo esc_url( $_wa_url ); ?>" class="op-btn op-btn--wa op-btn--lg" target="_blank" rel="noopener noreferrer">
					💬 Chat on WhatsApp
				</a>
			</div>
		</div>
	</div>
</section>

</main>
<?php get_footer(); ?>

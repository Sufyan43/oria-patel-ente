<?php
/**
 * Template Name: About Author
 * Template Post Type: page
 *
 * Author / founder bio page.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$_wa_number = preg_replace( '/[^0-9]/', '', get_theme_mod( 'op_contact_phone', '923117337511' ) ) ?: '923117337511';
$_wa_url    = 'https://wa.me/' . $_wa_number . '?text=' . rawurlencode( "Hi, I'd like to connect with the founder of Oria Patel Enterprises." );
?>
<main id="main" class="op-site-main" role="main">

<div class="op-page-hero">
	<div class="op-container">
		<p class="op-page-hero__eyebrow">Founder · Sialkot, Pakistan</p>
		<h1 class="op-page-hero__title">Meet the Founder</h1>
		<p class="op-page-hero__sub">The person behind Oria Patel Enterprises — and the passion driving 30 years of sports manufacturing excellence.</p>
	</div>
</div>

<section class="op-section">
	<div class="op-container">
		<div class="op-author-profile op-reveal">
			<!-- Author photo placeholder -->
			<div class="op-author-profile__photo-wrap">
				<div class="op-author-photo-placeholder">
					<span>👤</span>
					<small>Add founder photo here<br>400×400px recommended</small>
				</div>
			</div>
			<div class="op-author-profile__bio">
				<p class="op-section-eyebrow">Founder &amp; Managing Director</p>
				<h2 class="op-section-title">[Founder Name]</h2>
				<p class="op-author-profile__tagline">Sports Manufacturer · Sialkot, Pakistan · Est. 1992</p>

				<p>Add your personal story here. Share your journey — how you started the business, what drives you, and why you are passionate about making high-quality custom sports uniforms accessible to every team in the world regardless of size or budget.</p>

				<p>For example: <em>"I grew up watching local teams in Sialkot struggle to afford professional kit. Having access to our factory's manufacturing capabilities, I knew we could do better — so in 1992, I started Oria Patel Enterprises with a simple goal: factory-quality custom sports uniforms at a fair price, with zero minimum order..."</em></p>

				<p>Share what makes you different, your values, and your vision for the future of the business. This is your opportunity to build trust and connect with potential customers on a human level.</p>

				<div class="op-author-profile__links">
					<a href="<?php echo esc_url( get_theme_mod( 'op_social_linkedin', '#' ) ); ?>" class="op-btn op-btn--outline op-btn--sm" target="_blank" rel="noopener noreferrer">
						LinkedIn Profile
					</a>
					<a href="<?php echo esc_url( $_wa_url ); ?>" class="op-btn op-btn--wa op-btn--sm" target="_blank" rel="noopener noreferrer">
						💬 Connect on WhatsApp
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Milestones -->
<section class="op-section op-section--alt">
	<div class="op-container">
		<div class="op-section-header op-reveal" style="flex-direction:column;align-items:flex-start">
			<p class="op-section-eyebrow">Our Journey</p>
			<h2 class="op-section-title">Key Milestones</h2>
		</div>
		<div class="op-timeline op-reveal">
			<?php
			$milestones = [
				[ '1992', 'Founded in Sialkot',            'Oria Patel Enterprises established with a focus on high-quality sports uniforms.' ],
				[ '2000', 'First International Export',    'Began shipping custom uniforms to the United Kingdom and USA.' ],
				[ '2010', 'Expanded Product Range',        'Added gym wear, jackets, and accessories to our manufacturing capabilities.' ],
				[ '2015', '100+ Country Milestone',        'Served teams in over 100 cities across 30+ countries.' ],
				[ '2020', 'Zero MOQ Policy Launched',      'Officially launched our zero minimum order policy — any team, any quantity.' ],
				[ '2024', '500+ Happy Clients',            'Reached 500+ satisfied clients across 35+ countries and 12+ sports.' ],
			];
			foreach ( $milestones as $m ) : ?>
			<div class="op-timeline__item">
				<div class="op-timeline__year"><?php echo esc_html( $m[0] ); ?></div>
				<div class="op-timeline__content">
					<h3 class="op-timeline__title"><?php echo esc_html( $m[1] ); ?></h3>
					<p class="op-timeline__desc"><?php echo esc_html( $m[2] ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

</main>
<?php get_footer(); ?>

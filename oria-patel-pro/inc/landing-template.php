<?php
/**
 * Shared landing page template renderer.
 * Called by each category template file with a $op_landing config array.
 *
 * Required keys:
 *   title        string  Page / category headline
 *   slug         string  Used for opm_category lookup
 *   hero_sub     string  Sub-headline shown under title
 *   price_from   string  e.g. "From $8/piece"
 *   price_note   string  Short qualifier
 *   faqs         array   [ ['q'=>'…','a'=>'…'], … ]
 *   products     array   Static fallback products [ ['name','price','desc'], … ]
 *
 * Optional keys (with defaults):
 *   hero_cta_text, hero_cta_url, whatsapp_msg
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $op_landing ) || ! is_array( $op_landing ) ) return;

$_title      = $op_landing['title']        ?? 'Custom Sports Uniforms';
$_slug       = $op_landing['slug']         ?? '';
$_hero_sub   = $op_landing['hero_sub']     ?? 'Zero MOQ · Free 48-Hour Design Mockup · Factory Direct from Sialkot';
$_price_from = $op_landing['price_from']   ?? '';
$_price_note = $op_landing['price_note']   ?? 'Final price depends on design complexity, quantity & shipping location. Request a free quote for exact pricing.';
$_faqs       = $op_landing['faqs']         ?? [];
$_products   = $op_landing['products']     ?? [];
$_hero_cta   = $op_landing['hero_cta_text'] ?? 'Get Free Mockup in 48h';
$_cta_url    = $op_landing['hero_cta_url']  ?? home_url( '/contact/' );
$_wa_msg     = $op_landing['whatsapp_msg']  ?? "Hi Oria Patel Enterprises, I'm interested in custom {$_title} for my team. Can you help?";
$_wa_number  = preg_replace( '/[^0-9]/', '', get_theme_mod( 'op_contact_phone', '923117337511' ) ) ?: '923117337511';
$_wa_url     = 'https://wa.me/' . $_wa_number . '?text=' . rawurlencode( $_wa_msg );

// Try to pull live products from the matching opm_category term
$_live_products = [];
if ( $_slug && post_type_exists( 'opm_product' ) && taxonomy_exists( 'opm_category' ) ) {
	$_term = get_term_by( 'slug', $_slug, 'opm_category' );
	if ( ! $_term ) $_term = get_term_by( 'name', $_title, 'opm_category' );
	if ( $_term ) {
		$_q = new WP_Query( [
			'post_type'      => 'opm_product',
			'posts_per_page' => 6,
			'post_status'    => 'publish',
			'tax_query'      => [ [ 'taxonomy' => 'opm_category', 'field' => 'term_id', 'terms' => $_term->term_id ] ],
		] );
		if ( $_q->have_posts() ) {
			while ( $_q->have_posts() ) {
				$_q->the_post();
				$_live_products[] = [
					'name'      => get_the_title(),
					'permalink' => get_permalink(),
					'image'     => get_the_post_thumbnail_url( null, 'op-card' ),
					'excerpt'   => wp_trim_words( get_the_excerpt(), 12 ),
				];
			}
			wp_reset_postdata();
		}
	}
}

get_header();
?>
<main id="main" class="op-site-main" role="main">

<!-- ══ HERO ═══════════════════════════════════════════════════════════════ -->
<div class="op-landing-hero">
	<div class="op-landing-hero__overlay"></div>
	<div class="op-container op-landing-hero__inner">
		<p class="op-landing-hero__eyebrow">Oria Patel Enterprises · Sialkot, Pakistan</p>
		<h1 class="op-landing-hero__title"><?php echo esc_html( $_title ); ?></h1>
		<p class="op-landing-hero__sub"><?php echo esc_html( $_hero_sub ); ?></p>
		<?php if ( $_price_from ) : ?>
		<p class="op-landing-hero__price"><?php echo esc_html( $_price_from ); ?></p>
		<?php endif; ?>
		<div class="op-landing-hero__actions">
			<a href="<?php echo esc_url( $_cta_url ); ?>" class="op-btn op-btn--cta op-btn--lg">
				🎨 <?php echo esc_html( $_hero_cta ); ?>
			</a>
			<a href="<?php echo esc_url( $_wa_url ); ?>"
			   class="op-btn op-btn--wa op-btn--lg"
			   target="_blank" rel="noopener noreferrer">
				<?php /* WhatsApp icon */ ?>
				<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
				Chat With Our Designer
			</a>
		</div>
	</div>
</div>

<!-- ══ TRUST BAR ══════════════════════════════════════════════════════════ -->
<div class="op-trust-bar">
	<div class="op-container">
		<div class="op-trust-bar__items">
			<div class="op-trust-bar__item"><span class="op-trust-bar__icon">🏭</span><span>Since 1992</span></div>
			<div class="op-trust-bar__item"><span class="op-trust-bar__icon">🌍</span><span>500+ Teams Worldwide</span></div>
			<div class="op-trust-bar__item"><span class="op-trust-bar__icon">⚡</span><span>48-Hour Free Mockup</span></div>
			<div class="op-trust-bar__item"><span class="op-trust-bar__icon">📦</span><span>Zero Minimum Order</span></div>
			<div class="op-trust-bar__item"><span class="op-trust-bar__icon">✈️</span><span>Worldwide Shipping</span></div>
		</div>
	</div>
</div>

<!-- ══ PRODUCT SHOWCASE ═══════════════════════════════════════════════════ -->
<section class="op-section">
	<div class="op-container">
		<div class="op-section-header op-reveal">
			<div>
				<p class="op-section-eyebrow">Our Products</p>
				<h2 class="op-section-title"><?php echo esc_html( $_title ); ?> Collection</h2>
			</div>
			<?php if ( $_price_from ) : ?>
			<div class="op-price-badge">
				<span class="op-price-badge__label">Starting at</span>
				<span class="op-price-badge__price"><?php echo esc_html( $_price_from ); ?></span>
			</div>
			<?php endif; ?>
		</div>

		<div class="op-landing-products op-reveal">
			<?php if ( ! empty( $_live_products ) ) :
				foreach ( $_live_products as $_p ) : ?>
			<div class="op-landing-product-card">
				<?php if ( $_p['image'] ) : ?>
				<div class="op-landing-product-card__img-wrap">
					<a href="<?php echo esc_url( $_p['permalink'] ); ?>">
						<img src="<?php echo esc_url( $_p['image'] ); ?>" alt="<?php echo esc_attr( $_p['name'] ); ?>" loading="lazy">
					</a>
				</div>
				<?php endif; ?>
				<div class="op-landing-product-card__body">
					<h3 class="op-landing-product-card__name">
						<a href="<?php echo esc_url( $_p['permalink'] ); ?>"><?php echo esc_html( $_p['name'] ); ?></a>
					</h3>
					<?php if ( $_p['excerpt'] ) : ?>
					<p class="op-landing-product-card__desc"><?php echo esc_html( $_p['excerpt'] ); ?></p>
					<?php endif; ?>
					<?php if ( $_price_from ) : ?>
					<p class="op-landing-product-card__price"><?php echo esc_html( $_price_from ); ?></p>
					<?php endif; ?>
					<a href="<?php echo esc_url( $_wa_url ); ?>" class="op-btn op-btn--primary op-btn--sm" target="_blank" rel="noopener noreferrer">
						Get Free Mockup in 48h
					</a>
				</div>
			</div>
			<?php endforeach;
			elseif ( ! empty( $_products ) ) :
				foreach ( $_products as $_p ) : ?>
			<div class="op-landing-product-card">
				<div class="op-landing-product-card__img-placeholder">
					<span><?php echo esc_html( substr( $_p['name'], 0, 1 ) ); ?></span>
				</div>
				<div class="op-landing-product-card__body">
					<h3 class="op-landing-product-card__name"><?php echo esc_html( $_p['name'] ); ?></h3>
					<p class="op-landing-product-card__desc"><?php echo esc_html( $_p['desc'] ?? '' ); ?></p>
					<p class="op-landing-product-card__price"><?php echo esc_html( $_p['price'] ?? $_price_from ); ?></p>
					<a href="<?php echo esc_url( $_cta_url ); ?>" class="op-btn op-btn--primary op-btn--sm">
						Get Free Mockup in 48h
					</a>
				</div>
			</div>
			<?php endforeach;
			else : ?>
			<div class="op-landing-no-products">
				<p>Products coming soon. <a href="<?php echo esc_url( $_wa_url ); ?>" target="_blank" rel="noopener noreferrer">Chat with us on WhatsApp</a> for the full catalogue.</p>
			</div>
			<?php endif; ?>
		</div>

		<?php if ( $_price_note ) : ?>
		<p class="op-price-note"><?php echo esc_html( $_price_note ); ?></p>
		<?php endif; ?>
	</div>
</section>

<!-- ══ HOW IT WORKS ═══════════════════════════════════════════════════════ -->
<section class="op-section op-section--alt">
	<div class="op-container">
		<div class="op-section-header op-reveal" style="justify-content:center;text-align:center;flex-direction:column">
			<p class="op-section-eyebrow">Simple 3-Step Process</p>
			<h2 class="op-section-title">How It Works</h2>
		</div>
		<div class="op-hiw-steps op-reveal">
			<div class="op-hiw-step">
				<div class="op-hiw-step__num">1</div>
				<div class="op-hiw-step__icon" aria-hidden="true">📤</div>
				<h3 class="op-hiw-step__title">Upload Your Logo &amp; Design</h3>
				<p class="op-hiw-step__desc">Share your team colours, logo, and any design ideas. Even a rough sketch works — our designers do the rest.</p>
			</div>
			<div class="op-hiw-step__arrow" aria-hidden="true">→</div>
			<div class="op-hiw-step">
				<div class="op-hiw-step__num">2</div>
				<div class="op-hiw-step__icon" aria-hidden="true">🎨</div>
				<h3 class="op-hiw-step__title">Receive Free Mockup in 48h</h3>
				<p class="op-hiw-step__desc">We create a professional digital mockup at zero cost. Review it, request changes — we iterate until you love it.</p>
			</div>
			<div class="op-hiw-step__arrow" aria-hidden="true">→</div>
			<div class="op-hiw-step">
				<div class="op-hiw-step__num">3</div>
				<div class="op-hiw-step__icon" aria-hidden="true">🚚</div>
				<h3 class="op-hiw-step__title">We Manufacture &amp; Ship</h3>
				<p class="op-hiw-step__desc">Once you approve, production begins at our Sialkot factory. We ship worldwide with full tracking.</p>
			</div>
		</div>
	</div>
</section>

<!-- ══ SOCIAL PROOF / CLIENT LOGOS ═══════════════════════════════════════ -->
<section class="op-section">
	<div class="op-container">
		<div class="op-section-header op-reveal" style="justify-content:center;text-align:center;flex-direction:column">
			<p class="op-section-eyebrow">Trusted by Teams Worldwide</p>
			<h2 class="op-section-title">500+ Happy Clients in 35+ Countries</h2>
		</div>

		<!-- Client logo placeholder strip -->
		<div class="op-client-logos op-reveal">
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<div class="op-client-logo-slot" aria-label="Client logo <?php echo $i; ?>">
				<span>Client <?php echo $i; ?></span>
				<small>Add your client logo here</small>
			</div>
			<?php endfor; ?>
		</div>

		<!-- Testimonials -->
		<div class="op-testimonials op-reveal">
			<?php
			$testimonials = [
				[ 'quote' => '"Placeholder — add your real testimonial here. We loved the quality of the uniforms and the fast turnaround."', 'name' => 'Coach [Name]', 'team' => '[Team Name], USA', 'stars' => 5 ],
				[ 'quote' => '"Placeholder — add your real testimonial here. Professional service from start to finish. The mockup was perfect."', 'name' => '[Customer Name]', 'team' => '[Club Name], UK', 'stars' => 5 ],
				[ 'quote' => '"Placeholder — add your real testimonial here. Zero minimum order was exactly what our small club needed."', 'name' => '[Manager Name]', 'team' => '[Organisation], Australia', 'stars' => 5 ],
			];
			foreach ( $testimonials as $t ) : ?>
			<div class="op-testimonial-card">
				<div class="op-testimonial-card__stars" aria-label="<?php echo $t['stars']; ?> stars">
					<?php echo str_repeat( '★', $t['stars'] ); ?>
				</div>
				<blockquote class="op-testimonial-card__quote"><?php echo esc_html( $t['quote'] ); ?></blockquote>
				<p class="op-testimonial-card__author"><strong><?php echo esc_html( $t['name'] ); ?></strong></p>
				<p class="op-testimonial-card__team"><?php echo esc_html( $t['team'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ══ FAQ ════════════════════════════════════════════════════════════════ -->
<?php if ( ! empty( $_faqs ) ) : ?>
<section class="op-section op-section--alt">
	<div class="op-container">
		<div class="op-section-header op-reveal" style="justify-content:center;text-align:center;flex-direction:column">
			<p class="op-section-eyebrow">Got Questions?</p>
			<h2 class="op-section-title">Frequently Asked Questions</h2>
		</div>
		<div class="op-faq op-reveal">
			<?php foreach ( $_faqs as $i => $_faq ) : ?>
			<div class="op-faq__item">
				<button class="op-faq__question" aria-expanded="false" aria-controls="op-faq-<?php echo esc_attr( $i ); ?>">
					<?php echo esc_html( $_faq['q'] ); ?>
					<span class="op-faq__icon" aria-hidden="true">+</span>
				</button>
				<div class="op-faq__answer" id="op-faq-<?php echo esc_attr( $i ); ?>" hidden>
					<p><?php echo esc_html( $_faq['a'] ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- ══ FINAL CTA ══════════════════════════════════════════════════════════ -->
<section class="op-section op-cta-section">
	<div class="op-container">
		<div class="op-cta-section__inner op-reveal">
			<div class="op-cta-section__text">
				<h2>Ready to outfit your team?</h2>
				<p>Get a free design mockup within 48 hours — no minimum order, no obligation.</p>
			</div>
			<form class="op-cta-form oria-lead-form" id="oria-cta-form-<?php echo esc_attr( sanitize_title( $_title ) ); ?>" novalidate>
				<input type="hidden" name="source_url" value="<?php echo esc_url( get_permalink() ); ?>">
				<input type="hidden" name="sport" value="<?php echo esc_attr( $_title ); ?>">
				<input type="text"   name="website" style="display:none" tabindex="-1" autocomplete="off">
				<div class="op-cta-form__row">
					<input type="text"  name="name"    class="op-cta-form__input" placeholder="Your name *"             required aria-label="Your name">
					<input type="email" name="email"   class="op-cta-form__input" placeholder="Email address *"         required aria-label="Your email">
					<input type="text"  name="message" class="op-cta-form__input" placeholder="Tell us what you need…" aria-label="Your message">
					<button type="submit" class="op-btn op-btn--cta">Send My Free Mockup Request</button>
				</div>
				<div class="oria-lead-form__msg" hidden></div>
			</form>
			<div class="op-cta-section__wa">
				<span>Or chat instantly:</span>
				<a href="<?php echo esc_url( $_wa_url ); ?>" class="op-btn op-btn--wa" target="_blank" rel="noopener noreferrer">
					<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
					Chat With Our Designer on WhatsApp
				</a>
			</div>
		</div>
	</div>
</section>

</main>
<?php get_footer(); ?>

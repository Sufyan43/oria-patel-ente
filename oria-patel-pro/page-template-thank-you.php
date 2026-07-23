<?php
/**
 * Template Name: Thank You
 * Template Post Type: page
 *
 * Lead magnet delivery / thank-you page shown after mockup request submission.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$_wa_number = preg_replace( '/[^0-9]/', '', get_theme_mod( 'op_contact_phone', '923117337511' ) ) ?: '923117337511';
$_wa_url    = 'https://wa.me/' . $_wa_number . '?text=' . rawurlencode( "Hi! I just submitted a mockup request on your website and wanted to follow up." );
?>
<main id="main" class="op-site-main" role="main">

<section class="op-section">
	<div class="op-container">
		<div class="op-thankyou op-reveal">
			<div class="op-thankyou__icon" aria-hidden="true">🎉</div>
			<h1 class="op-thankyou__title">You're All Set!</h1>
			<p class="op-thankyou__lead">Check your email for your free mockup request confirmation. Our designer will contact you personally within <strong>24 hours</strong>.</p>

			<div class="op-thankyou__steps">
				<div class="op-thankyou__step">
					<span class="op-thankyou__step-num">1</span>
					<p>Check your inbox for a confirmation email from us.</p>
				</div>
				<div class="op-thankyou__step">
					<span class="op-thankyou__step-num">2</span>
					<p>Our designer will reach out within 24 hours with questions to perfect your mockup.</p>
				</div>
				<div class="op-thankyou__step">
					<span class="op-thankyou__step-num">3</span>
					<p>You'll receive your free custom design mockup within 48 hours — ready for your review.</p>
				</div>
			</div>

			<!-- Lead magnet download -->
			<div class="op-thankyou__download">
				<div class="op-thankyou__download-icon" aria-hidden="true">📘</div>
				<div>
					<h3>Meanwhile, download your free guide:</h3>
					<p class="op-thankyou__download-title">"The Team Uniform Buying Guide 2026"</p>
					<p class="op-thankyou__download-desc">Everything you need to know before ordering custom sports uniforms — fabrics, pricing, design tips, and common pitfalls to avoid.</p>
					<?php
					// If a PDF has been uploaded via Customizer, link to it; otherwise show placeholder
					$pdf_url = get_theme_mod( 'op_lead_magnet_pdf', '' );
					?>
					<a href="<?php echo $pdf_url ? esc_url( $pdf_url ) : '#'; ?>"
					   class="op-btn op-btn--primary"
					   <?php if ( $pdf_url ) : ?>download<?php endif; ?>
					   <?php if ( ! $pdf_url ) : ?>onclick="alert('PDF coming soon! We will email it to you directly.'); return false;"<?php endif; ?>>
						⬇ Download Free Guide (PDF)
					</a>
					<?php if ( ! $pdf_url ) : ?>
					<p style="font-size:12px;color:#888;margin-top:8px;">
						<em>Upload the PDF via Appearance → Customize → Lead Magnet PDF. We will also email it to you.</em>
					</p>
					<?php endif; ?>
				</div>
			</div>

			<div class="op-thankyou__footer">
				<p>Want to talk to us right now?</p>
				<a href="<?php echo esc_url( $_wa_url ); ?>" class="op-btn op-btn--wa" target="_blank" rel="noopener noreferrer">
					💬 Chat With Our Designer on WhatsApp
				</a>
				<a href="<?php echo esc_url( home_url( '/products/' ) ); ?>" class="op-btn op-btn--outline" style="margin-top:12px">
					Browse Our Products →
				</a>
			</div>
		</div>
	</div>
</section>

</main>
<?php get_footer(); ?>

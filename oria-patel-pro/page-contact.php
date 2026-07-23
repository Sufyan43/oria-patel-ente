<?php
/**
 * Template Name: Contact Page
 * Template for the Contact / Quote Request page.
 */
get_header(); ?>

<div class="op-page-header">
	<div class="op-container">
		<?php op_breadcrumb(); ?>
		<h1 class="op-page-header__title"><?php the_title(); ?></h1>
		<p class="op-page-header__sub">Fill in the form below and we'll reply within 24 hours.</p>
	</div>
</div>

<div class="op-container op-section">
	<div class="op-contact-layout">

		<!-- Contact form -->
		<div class="op-contact-main">
			<?php get_template_part( 'template-parts/contact-form' ); ?>
		</div>

		<!-- Contact info sidebar -->
		<aside class="op-contact-side">
			<div class="op-contact-info-card">
				<h3 class="op-contact-info-card__title">📬 Get In Touch</h3>

				<?php $reply_time = get_theme_mod( 'op_form_reply_time', '24 hours' ); ?>
				<div class="op-contact-info-item">
					<span class="op-contact-info-item__icon">⏱️</span>
					<div>
						<strong>Response Time</strong>
						<p>We reply within <?php echo esc_html( $reply_time ); ?></p>
					</div>
				</div>

				<?php $email = get_theme_mod( 'op_contact_email', '' ); if ( $email ) : ?>
				<div class="op-contact-info-item">
					<span class="op-contact-info-item__icon">✉️</span>
					<div>
						<strong>Email Us</strong>
						<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
					</div>
				</div>
				<?php endif; ?>

				<?php $phone = get_theme_mod( 'op_contact_phone', '' ); if ( $phone ) : ?>
				<div class="op-contact-info-item">
					<span class="op-contact-info-item__icon">📞</span>
					<div>
						<strong>Phone / WhatsApp</strong>
						<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^+0-9]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
					</div>
				</div>
				<?php endif; ?>

				<?php $whatsapp = get_theme_mod( 'op_social_whatsapp', '' ); if ( $whatsapp ) : ?>
				<a href="<?php echo esc_url( $whatsapp ); ?>" class="op-btn op-btn--primary" style="width:100%;justify-content:center;margin-top:16px;background:#25D366;display:flex" target="_blank" rel="noopener noreferrer">
					💬 Chat on WhatsApp
				</a>
				<?php endif; ?>

				<?php $address = get_theme_mod( 'op_contact_address', '' ); if ( $address ) : ?>
				<div class="op-contact-info-item" style="margin-top:16px">
					<span class="op-contact-info-item__icon">📍</span>
					<div>
						<strong>Our Location</strong>
						<p><?php echo nl2br( esc_html( $address ) ); ?></p>
					</div>
				</div>
				<?php endif; ?>

			</div>

			<!-- Trust badges -->
			<div class="op-contact-info-card" style="margin-top:16px">
				<h3 class="op-contact-info-card__title">✅ Our Guarantees</h3>
				<?php
				$guarantees = [
					'🎽 3D design mockup within 48 hours',
					'📦 No minimum order quantity',
					'🌍 We are shipping worldwide',
					'💧 100% sublimation — fade-proof',
					'🔄 Revisions until you are happy',
				];
				foreach ( $guarantees as $g ) :
				?>
				<p style="display:flex;gap:8px;align-items:flex-start;margin:8px 0;font-size:14px">
					<?php echo esc_html( $g ); ?>
				</p>
				<?php endforeach; ?>
			</div>
		</aside>

	</div>
</div>

<?php get_footer(); ?>

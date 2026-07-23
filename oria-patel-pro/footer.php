</div><!-- .op-site-content -->

<footer class="op-footer" role="contentinfo">
	<div class="op-container">
		<div class="op-footer__grid">

			<!-- Brand column -->
			<div class="op-footer__brand">
				<?php if ( has_custom_logo() ) : ?>
					<div class="op-footer__logo-wrap">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<span class="op-footer__brand-name"><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>

				<p class="op-footer__tagline">
					<?php echo esc_html( get_theme_mod( 'op_footer_tagline', 'Premium custom sports uniforms directly from Sialkot, Pakistan — the global hub of sports manufacturing.' ) ); ?>
				</p>

				<div class="op-footer__socials">
					<?php
					$social_icons = [
						'op_social_facebook' => [
							'label' => 'Facebook',
							'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>',
						],
						'op_social_instagram' => [
							'label' => 'Instagram',
							'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
						],
						'op_social_whatsapp' => [
							'label' => 'WhatsApp',
							'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
						],
						'op_social_linkedin' => [
							'label' => 'LinkedIn',
							'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
						],
					];
					foreach ( $social_icons as $mod => $info ) :
						$url = get_theme_mod( $mod, '' );
						if ( ! $url ) continue;
					?>
					<a href="<?php echo esc_url( $url ); ?>" class="op-footer__social" aria-label="<?php echo esc_attr( $info['label'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo $info['svg']; // phpcs:ignore WordPress.Security.EscapeOutput -- hardcoded SVG ?>
					</a>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Products column -->
			<div>
				<h4 class="op-footer__col-title"><?php esc_html_e( 'Products', 'oria-patel' ); ?></h4>
				<ul class="op-footer__links">
					<?php
					$shop_url = op_shop_url();
					echo '<li><a href="' . esc_url( $shop_url ) . '" class="op-footer__link">' . esc_html__( 'All Products', 'oria-patel' ) . '</a></li>';

					// Pull real category terms so footer links always match live categories
					if ( taxonomy_exists( 'opm_category' ) ) {
						$footer_cats = get_terms( [
							'taxonomy'   => 'opm_category',
							'hide_empty' => true,
							'number'     => 6,
							'orderby'    => 'count',
							'order'      => 'DESC',
							'parent'     => 0,
						] );
						if ( ! is_wp_error( $footer_cats ) ) {
							foreach ( $footer_cats as $fcat ) {
								$furl = get_term_link( $fcat );
								if ( is_wp_error( $furl ) ) $furl = $shop_url;
								echo '<li><a href="' . esc_url( $furl ) . '" class="op-footer__link">' . esc_html( $fcat->name ) . '</a></li>';
							}
						}
					}
					?>
				</ul>
			</div>

			<!-- Company column -->
			<div>
				<h4 class="op-footer__col-title"><?php esc_html_e( 'Company', 'oria-patel' ); ?></h4>
				<ul class="op-footer__links">
					<?php
					// Core pages always shown in footer
					$company_links = [
						home_url( '/about/' )   => __( 'About Us', 'oria-patel' ),
						home_url( '/contact/' ) => __( 'Contact', 'oria-patel' ),
						home_url( '/reviews/' ) => __( 'Reviews', 'oria-patel' ),
						home_url( '/blog/' )    => __( 'Blog', 'oria-patel' ),
					];
					// Optional pages shown only when they exist
					if ( get_page_by_path( 'faq' ) )     $company_links[ home_url( '/faq/' ) ]     = __( 'FAQ', 'oria-patel' );
					if ( get_page_by_path( 'gallery' ) ) $company_links[ home_url( '/gallery/' ) ] = __( 'Gallery', 'oria-patel' );
					foreach ( $company_links as $url => $label ) :
					?>
					<li><a href="<?php echo esc_url( $url ); ?>" class="op-footer__link"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Contact column -->
			<div>
				<h4 class="op-footer__col-title"><?php esc_html_e( 'Contact', 'oria-patel' ); ?></h4>
				<div class="op-footer__contact">

					<?php $email = get_theme_mod( 'op_contact_email', '' ); if ( $email ) : ?>
					<div class="op-footer__contact-item">
						<span class="op-footer__contact-icon">✉</span>
						<a href="mailto:<?php echo esc_attr( $email ); ?>" class="op-footer__link">
							<?php echo esc_html( $email ); ?>
						</a>
					</div>
					<?php endif; ?>

					<?php $phone = get_theme_mod( 'op_contact_phone', '+92 311 7337511' ); if ( $phone ) : ?>
					<div class="op-footer__contact-item">
						<span class="op-footer__contact-icon">📞</span>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^+0-9]/', '', $phone ) ); ?>" class="op-footer__link">
							<?php echo esc_html( $phone ); ?>
						</a>
					</div>
					<?php endif; ?>

					<?php $whatsapp = get_theme_mod( 'op_social_whatsapp', 'https://wa.me/923117337511' ); if ( $whatsapp ) : ?>
					<div class="op-footer__contact-item">
						<span class="op-footer__contact-icon">💬</span>
						<a href="<?php echo esc_url( $whatsapp ); ?>" class="op-footer__link" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'WhatsApp Us', 'oria-patel' ); ?>
						</a>
					</div>
					<?php endif; ?>

					<?php $address = get_theme_mod( 'op_contact_address', 'Sialkot, Punjab, Pakistan' ); if ( $address ) : ?>
					<div class="op-footer__contact-item">
						<span class="op-footer__contact-icon">📍</span>
						<span class="op-footer__link"><?php echo nl2br( esc_html( $address ) ); ?></span>
					</div>
					<?php endif; ?>

					<?php $hours = get_theme_mod( 'op_business_hours', '24/7 — We respond to all enquiries within 24 hours' ); if ( $hours ) : ?>
					<div class="op-footer__contact-item">
						<span class="op-footer__contact-icon">🕐</span>
						<span class="op-footer__link"><?php echo esc_html( $hours ); ?></span>
					</div>
					<?php endif; ?>

				</div>
			</div>

		</div><!-- .op-footer__grid -->

		<div class="op-footer__bottom">
			<p><?php echo esc_html( get_theme_mod( 'op_footer_copyright', '© ' . gmdate( 'Y' ) . ' Oria Patel Enterprises. All rights reserved.' ) ); ?></p>
			<div class="op-footer__bottom-links">
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="op-footer__bottom-link"><?php esc_html_e( 'Privacy Policy', 'oria-patel' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>" class="op-footer__bottom-link"><?php esc_html_e( 'Terms', 'oria-patel' ); ?></a>
			</div>
		</div>
	</div>
</footer>

<!-- ── Floating WhatsApp Bubble (fixed, every page) ────────────────────── -->
<?php
$show_bubble = get_theme_mod( 'op_whatsapp_bubble_show', true );
$bubble_number  = trim( get_theme_mod( 'op_whatsapp_bubble_number', '' ) );
$bubble_message = trim( get_theme_mod( 'op_whatsapp_bubble_message', "Hello! I'm interested in custom sports uniforms." ) );
if ( $bubble_number ) {
	$wa_url = 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $bubble_number );
	if ( $bubble_message ) $wa_url .= '?text=' . rawurlencode( $bubble_message );
} else {
	$wa_url = get_theme_mod( 'op_social_whatsapp', 'https://wa.me/923117337511' );
}
if ( $show_bubble && $wa_url ) : ?>
<a href="<?php echo esc_url( $wa_url ); ?>"
   class="op-whatsapp-bubble"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'oria-patel' ); ?>"
   title="<?php esc_attr_e( 'Chat on WhatsApp — Hi Oria Patel Enterprises, I\'m interested in custom uniforms for my team. Can you help?', 'oria-patel' ); ?>"
   style="position:fixed;bottom:90px;right:20px;z-index:9997;">
	<!-- Official WhatsApp brand icon (from WhatsApp Brand Resources) -->
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="currentColor" aria-hidden="true">
		<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
	</svg>
</a>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>

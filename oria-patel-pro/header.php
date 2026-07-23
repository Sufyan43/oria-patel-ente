<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( get_theme_mod( 'op_topbar_show', true ) ) : ?>
<div class="op-topbar" role="banner">
	<div class="op-topbar__track" aria-hidden="true">
		<?php
		$topbar_defaults = [
			1 => 'FREE DESIGN MOCKUP',
			2 => 'NO MINIMUM ORDER',
			3 => 'FAST DELIVERY WORLDWIDE',
			4 => '100% SUBLIMATION PRINTING',
		];
		$items = [];
		for ( $i = 1; $i <= 4; $i++ ) {
			$text = get_theme_mod( "op_topbar_item_{$i}", $topbar_defaults[ $i ] );
			if ( $text ) $items[] = $text;
		}
		$doubled = array_merge( $items, $items );
		foreach ( $doubled as $item ) : ?>
			<span class="op-topbar__item">
				<span class="op-topbar__dot"></span>
				<?php echo esc_html( $item ); ?>
			</span>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>

<?php
// Resolve the correct products URL once, used in both nav fallbacks
$op_products_url = home_url( '/products/' );
?>

<header class="op-header" role="banner">
	<div class="op-container">
		<div class="op-header__inner">

			<!-- Logo -->
			<div class="op-header__logo">
				<?php if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					// Split "Oria Patel Enterprises" → bold first portion + accent last word
					$site_name = get_bloginfo( 'name' );
					$words     = explode( ' ', trim( $site_name ) );
					$last_word = count( $words ) > 1 ? array_pop( $words ) : '';
					$first_part = implode( ' ', $words );
				?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="op-header__logo-text" rel="home" aria-label="<?php echo esc_attr( $site_name ); ?>">
						<span class="op-logo__bar" aria-hidden="true"></span>
						<span class="op-logo__name">
							<span class="op-logo__primary"><?php echo esc_html( $first_part ); ?></span><?php if ( $last_word ) : ?><span class="op-logo__accent"><?php echo esc_html( $last_word ); ?></span><?php endif; ?>
						</span>
					</a>
				<?php endif; ?>
			</div>

			<!-- Primary navigation (desktop) -->
			<nav class="op-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'oria-patel' ); ?>">
				<?php
				wp_nav_menu( [
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'op-nav__list',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'item_spacing'   => 'discard',
					'fallback_cb'    => function() use ( $op_products_url ) {
						echo '<ul class="op-nav__list">';
						echo '<li class="op-nav__item"><a href="' . esc_url( home_url( '/' ) ) . '" class="op-nav__link">' . esc_html__( 'Home', 'oria-patel' ) . '</a></li>';
						echo '<li class="op-nav__item"><a href="' . esc_url( $op_products_url ) . '" class="op-nav__link">' . esc_html__( 'Products', 'oria-patel' ) . '</a></li>';
						echo '<li class="op-nav__item"><a href="' . esc_url( home_url( '/reviews/' ) ) . '" class="op-nav__link">' . esc_html__( 'Reviews', 'oria-patel' ) . '</a></li>';
						echo '<li class="op-nav__item"><a href="' . esc_url( home_url( '/blog/' ) ) . '" class="op-nav__link">' . esc_html__( 'Blog', 'oria-patel' ) . '</a></li>';
						echo '</ul>';
					},
					'walker' => class_exists( 'OP_Nav_Walker' ) ? new OP_Nav_Walker() : null,
				] );
				?>
			</nav>

			<!-- Header actions -->
			<?php
			$_hdr_wa_number  = trim( get_theme_mod( 'op_whatsapp_bubble_number', '' ) );
			$_hdr_wa_message = trim( get_theme_mod( 'op_whatsapp_bubble_message', "Hi! I'd like a free mockup for my team." ) );
			if ( $_hdr_wa_number ) {
				$_hdr_wa_url = 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $_hdr_wa_number );
				if ( $_hdr_wa_message ) $_hdr_wa_url .= '?text=' . rawurlencode( $_hdr_wa_message );
			} else {
				$_hdr_wa_url = get_theme_mod( 'op_social_whatsapp', 'https://wa.me/923117337511' );
			}
			?>
			<div class="op-header__actions">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--cta op-btn--sm">
					🎨 <?php esc_html_e( 'Get Free Mockup in 48h', 'oria-patel' ); ?>
				</a>

				<a href="<?php echo esc_url( $_hdr_wa_url ); ?>" class="op-btn op-btn--wa-hdr op-btn--sm" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Contact us on WhatsApp', 'oria-patel' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" fill="currentColor" aria-hidden="true" style="flex-shrink:0">
						<path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
					</svg>
					<?php esc_html_e( 'WhatsApp Us', 'oria-patel' ); ?>
				</a>

				<!-- Hamburger (mobile) -->
				<button class="op-hamburger" id="op-hamburger" aria-label="<?php esc_attr_e( 'Open menu', 'oria-patel' ); ?>" aria-expanded="false" aria-controls="op-mobile-nav">
					<span></span><span></span><span></span>
				</button>
			</div>
		</div>
	</div>
</header>

<!-- Mobile navigation overlay -->
<nav class="op-mobile-nav" id="op-mobile-nav" role="navigation" aria-label="<?php esc_attr_e( 'Mobile Menu', 'oria-patel' ); ?>">
	<div class="op-mobile-nav__header">
		<?php if ( has_custom_logo() ) the_custom_logo(); else echo '<span style="font-weight:700;font-size:18px">' . esc_html( get_bloginfo( 'name' ) ) . '</span>'; ?>
		<button class="op-mobile-nav__close" id="op-mobile-close" aria-label="<?php esc_attr_e( 'Close menu', 'oria-patel' ); ?>">&times;</button>
	</div>
	<?php
	wp_nav_menu( [
		'theme_location' => 'primary',
		'container'      => false,
		'menu_class'     => 'op-mobile-nav__list',
		'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
		'item_spacing'   => 'discard',
		'fallback_cb'    => function() use ( $op_products_url ) {
			echo '<ul class="op-mobile-nav__list">';
			$links = [
				home_url( '/' )          => __( 'Home', 'oria-patel' ),
				$op_products_url         => __( 'Products', 'oria-patel' ),
				home_url( '/reviews/' )  => __( 'Reviews', 'oria-patel' ),
				home_url( '/blog/' )     => __( 'Blog', 'oria-patel' ),
			];
			foreach ( $links as $url => $label ) {
				echo '<li><a href="' . esc_url( $url ) . '" class="op-mobile-nav__link">' . esc_html( $label ) . '</a></li>';
			}
			echo '</ul>';
		},
	] );
	?>
	<div style="margin-top:24px;display:flex;flex-direction:column;gap:12px;">
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--cta op-btn--full">
			🎨 <?php esc_html_e( 'Get Free Mockup in 48h', 'oria-patel' ); ?>
		</a>
		<a href="<?php echo esc_url( isset( $_hdr_wa_url ) ? $_hdr_wa_url : get_theme_mod( 'op_social_whatsapp', 'https://wa.me/923117337511' ) ); ?>" class="op-btn op-btn--wa-hdr op-btn--full" target="_blank" rel="noopener noreferrer">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="18" height="18" fill="currentColor" aria-hidden="true" style="flex-shrink:0">
				<path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
			</svg>
			<?php esc_html_e( 'WhatsApp Us', 'oria-patel' ); ?>
		</a>
	</div>
</nav>

<div class="op-site-content">

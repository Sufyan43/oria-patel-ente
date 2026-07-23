<?php get_header(); ?>

<main id="main" class="op-site-main" role="main">
	<div class="op-container op-section" style="text-align:center;padding-top:80px;padding-bottom:80px">
		<p style="font-size:96px;line-height:1;margin-bottom:16px">🏅</p>
		<h1 style="font-size:clamp(36px,6vw,72px);font-weight:700;color:#0F1111;margin-bottom:12px">404</h1>
		<h2 style="font-size:clamp(18px,3vw,28px);font-weight:700;margin-bottom:16px">
			<?php esc_html_e( 'Page not found', 'oria-patel' ); ?>
		</h2>
		<p style="font-size:16px;color:#565959;max-width:480px;margin:0 auto 32px">
			<?php esc_html_e( "Looks like this page got benched. Let's get you back in the game.", 'oria-patel' ); ?>
		</p>
		<div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="op-btn op-btn--primary">
				<?php esc_html_e( 'Go Home', 'oria-patel' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/products/' ) ); ?>" class="op-btn op-btn--outline">
				<?php esc_html_e( 'Browse Products', 'oria-patel' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--outline">
				<?php esc_html_e( 'Contact Us', 'oria-patel' ); ?>
			</a>
		</div>
	</div>
</main>

<?php get_footer(); ?>

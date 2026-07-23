<?php get_header(); ?>

<main id="main" class="op-site-main" role="main">
	<div class="op-container op-section">

		<?php if ( have_posts() ) : ?>
			<h1 class="op-section-title" style="margin-bottom:32px">
				<?php
				if ( is_home() && ! is_front_page() ) :
					single_post_title();
				else :
					esc_html_e( 'Latest Posts', 'oria-patel' );
				endif;
				?>
			</h1>

			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'op-product-card' ); ?> style="padding:24px">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="op-product-card__image-wrap" style="margin:-24px -24px 16px;border-radius:12px 12px 0 0">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'op-card', [ 'class' => 'op-product-card__image' ] ); ?>
								</a>
							</div>
						<?php endif; ?>
						<h2 style="font-size:18px;margin-bottom:8px">
							<a href="<?php the_permalink(); ?>" style="color:inherit"><?php the_title(); ?></a>
						</h2>
						<p style="font-size:13px;color:#565959;margin-bottom:12px">
							<?php echo get_the_date(); ?> &middot; <?php the_author(); ?>
						</p>
						<div style="font-size:14px;color:#565959"><?php the_excerpt(); ?></div>
						<a href="<?php the_permalink(); ?>" class="op-btn op-btn--primary op-btn--sm" style="margin-top:16px">
							<?php esc_html_e( 'Read more', 'oria-patel' ); ?>
						</a>
					</article>
				<?php endwhile; ?>
			</div>

			<div style="margin-top:40px;display:flex;justify-content:center">
				<?php the_posts_pagination( [
					'mid_size'  => 2,
					'prev_text' => '← ' . __( 'Newer', 'oria-patel' ),
					'next_text' => __( 'Older', 'oria-patel' ) . ' →',
				] ); ?>
			</div>

		<?php else : ?>
			<div style="text-align:center;padding:80px 0">
				<p style="font-size:48px;margin-bottom:16px">🔍</p>
				<h1><?php esc_html_e( 'Nothing found', 'oria-patel' ); ?></h1>
				<p style="color:#565959;margin-top:8px"><?php esc_html_e( 'Try searching for what you need.', 'oria-patel' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>

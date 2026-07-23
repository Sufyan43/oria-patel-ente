<?php get_header(); ?>

<main id="main" class="op-site-main" role="main">

	<div class="op-page-header">
		<div class="op-container">
			<?php op_breadcrumb(); ?>
			<h1 class="op-page-header__title"><?php the_archive_title(); ?></h1>
			<?php $desc = get_the_archive_description(); if ( $desc ) echo '<p class="op-page-header__breadcrumb" style="margin-top:8px">' . wp_kses_post( $desc ) . '</p>'; ?>
		</div>
	</div>

	<div class="op-container op-section">
		<?php if ( have_posts() ) : ?>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'op-product-card' ); ?> style="padding:0">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="op-product-card__image-wrap">
								<?php the_post_thumbnail( 'op-card', [ 'class' => 'op-product-card__image' ] ); ?>
							</a>
						<?php endif; ?>
						<div class="op-product-card__body">
							<p class="op-product-card__seller"><?php echo get_the_date(); ?></p>
							<h2 class="op-product-card__title">
								<a href="<?php the_permalink(); ?>" style="color:inherit"><?php the_title(); ?></a>
							</h2>
							<div style="font-size:13px;color:#565959"><?php the_excerpt(); ?></div>
						</div>
						<div class="op-product-card__footer">
							<a href="<?php the_permalink(); ?>" class="op-product-card__cta"><?php esc_html_e( 'Read More', 'oria-patel' ); ?></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div style="margin-top:40px;display:flex;justify-content:center">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts found.', 'oria-patel' ); ?></p>
		<?php endif; ?>
	</div>

</main>

<?php get_footer(); ?>

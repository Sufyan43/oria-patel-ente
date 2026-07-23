<?php
/**
 * Blog Archive Template — shown at /blog/ (WordPress "Posts page")
 */
get_header(); ?>

<div class="op-page-header">
	<div class="op-container">
		<?php oria_breadcrumb_html(); ?>
		<h1 class="op-page-header__title"><?php esc_html_e( 'Our Blog', 'oria-patel' ); ?></h1>
		<p class="op-page-header__sub"><?php esc_html_e( 'Tips, guides & insights on custom sports uniforms from the Sialkot factory floor.', 'oria-patel' ); ?></p>
	</div>
</div>

<div class="op-container op-section">
	<div class="oria-blog-layout">

		<!-- ── MAIN CONTENT ─────────────────────────────────────────── -->
		<main id="main" class="oria-blog-main" role="main">

			<?php if ( have_posts() ) : ?>

				<div class="oria-blog-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'blog-card' ); ?>
					<?php endwhile; ?>
				</div>

				<div class="oria-pagination">
					<?php the_posts_pagination( [
						'mid_size'  => 2,
						'prev_text' => '&larr; ' . __( 'Previous', 'oria-patel' ),
						'next_text' => __( 'Next', 'oria-patel' ) . ' &rarr;',
					] ); ?>
				</div>

			<?php else : ?>
				<div style="text-align:center;padding:80px 0">
					<p style="font-size:48px;margin:0">📝</p>
					<h2 style="margin:16px 0 8px"><?php esc_html_e( 'No posts yet', 'oria-patel' ); ?></h2>
					<p style="color:#565959"><?php esc_html_e( 'Check back soon — great content is coming.', 'oria-patel' ); ?></p>
				</div>
			<?php endif; ?>

		</main>

		<!-- ── SIDEBAR ──────────────────────────────────────────────── -->
		<?php get_sidebar( 'blog' ); ?>

	</div>
</div>

<?php get_footer(); ?>

<?php get_header(); ?>

<main id="main" class="op-site-main" role="main">

	<div class="op-page-header">
		<div class="op-container">
			<?php op_breadcrumb(); ?>
			<h1 class="op-page-header__title"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="op-container op-section op-section--sm">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="op-page-content">
				<?php the_content(); ?>
				<?php
				wp_link_pages( [
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oria-patel' ),
					'after'  => '</div>',
				] );
				?>
			</div>
		<?php endwhile; ?>
	</div>

</main>

<?php get_footer(); ?>

<?php
/**
 * Single Blog Post Template
 * Includes: social share, related posts, author bio, comments.
 */
get_header(); ?>

<main id="main" class="op-site-main" role="main">
<?php while ( have_posts() ) : the_post(); ?>

	<!-- Page header with breadcrumb + meta -->
	<div class="op-page-header">
		<div class="op-container">
			<?php oria_breadcrumb_html(); ?>
			<h1 class="op-page-header__title"><?php the_title(); ?></h1>
			<div class="oria-post-meta">
				<?php
				$cats = get_the_category();
				if ( $cats ) :
					foreach ( $cats as $cat ) :
				?>
					<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="oria-blog-card__badge"><?php echo esc_html( $cat->name ); ?></a>
				<?php endforeach; endif; ?>
				<span class="oria-post-meta__item"><?php echo esc_html( get_the_author() ); ?></span>
				<span class="oria-post-meta__sep" aria-hidden="true">·</span>
				<time class="oria-post-meta__item" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<span class="oria-post-meta__sep" aria-hidden="true">·</span>
				<span class="oria-post-meta__item"><?php echo esc_html( oria_reading_time() ); ?></span>
			</div>
		</div>
	</div>

	<!-- Full-width featured image -->
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="oria-post-hero">
		<?php the_post_thumbnail( 'oria-blog-hero', [
			'style'   => 'width:100%;height:auto;display:block',
			'loading' => 'eager',
		] ); ?>
	</div>
	<?php endif; ?>

	<!-- Post content -->
	<div class="op-container op-section op-section--sm">
		<div class="oria-post-layout">

			<article class="oria-post-content">

				<!-- Social share — top -->
				<?php oria_social_share_buttons(); ?>

				<div class="op-page-content">
					<?php the_content(); ?>
				</div>

				<?php
				wp_link_pages( [
					'before' => '<div class="oria-post-pages"><strong>' . __( 'Pages:', 'oria-patel' ) . '</strong>',
					'after'  => '</div>',
				] );
				?>

				<!-- Tags -->
				<?php the_tags( '<div class="oria-post-tags">', '', '</div>' ); ?>

				<!-- Social share — bottom -->
				<?php oria_social_share_buttons(); ?>

				<!-- Author bio -->
				<?php oria_author_bio_box(); ?>

				<!-- Post navigation -->
				<nav class="oria-post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'oria-patel' ); ?>">
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					?>
					<?php if ( $prev ) : ?>
					<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="oria-post-nav__link oria-post-nav__link--prev">
						<span class="oria-post-nav__dir">&larr; <?php esc_html_e( 'Previous', 'oria-patel' ); ?></span>
						<span class="oria-post-nav__title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
					</a>
					<?php endif; ?>
					<?php if ( $next ) : ?>
					<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="oria-post-nav__link oria-post-nav__link--next">
						<span class="oria-post-nav__dir"><?php esc_html_e( 'Next', 'oria-patel' ); ?> &rarr;</span>
						<span class="oria-post-nav__title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
					</a>
					<?php endif; ?>
				</nav>

				<!-- Comments -->
				<?php if ( comments_open() || get_comments_number() ) : ?>
				<div class="oria-post-comments">
					<?php comments_template(); ?>
				</div>
				<?php endif; ?>

			</article>

			<!-- Sidebar -->
			<?php get_sidebar( 'blog' ); ?>

		</div>
	</div>

	<!-- Related Posts -->
	<?php
	$related = oria_related_posts( get_the_ID(), 3 );
	if ( $related->have_posts() ) :
	?>
	<div class="oria-related-posts op-section--sm" style="background:var(--op-color-bg-alt);padding:40px 0">
		<div class="op-container">
			<h2 class="op-section-title" style="margin-bottom:24px"><?php esc_html_e( 'Related Posts', 'oria-patel' ); ?></h2>
			<div class="oria-blog-grid oria-blog-grid--3col">
				<?php while ( $related->have_posts() ) : $related->the_post(); ?>
					<?php get_template_part( 'content', 'blog-card' ); ?>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

<?php endwhile; ?>
</main>

<?php get_footer(); ?>

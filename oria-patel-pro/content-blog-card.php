<?php
/**
 * Template Part: Blog Post Card
 * Used in home.php (blog archive) and category archives.
 */
$cats      = get_the_category();
$first_cat = $cats ? $cats[0] : null;
$img_url   = get_the_post_thumbnail_url( get_the_ID(), 'oria-blog-card' );
?>
<article class="oria-blog-card" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( $img_url ) : ?>
	<a href="<?php the_permalink(); ?>" class="oria-blog-card__image-wrap" tabindex="-1" aria-hidden="true">
		<img
			src="<?php echo esc_url( $img_url ); ?>"
			alt="<?php echo esc_attr( get_the_title() ); ?>"
			class="oria-blog-card__image"
			loading="lazy"
			width="720" height="405"
		>
	</a>
	<?php endif; ?>

	<div class="oria-blog-card__body">

		<?php if ( $first_cat ) : ?>
		<a href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>" class="oria-blog-card__badge">
			<?php echo esc_html( $first_cat->name ); ?>
		</a>
		<?php endif; ?>

		<h2 class="oria-blog-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<p class="oria-blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?></p>

		<div class="oria-blog-card__meta">
			<span class="oria-blog-card__author">
				<?php echo esc_html( get_the_author() ); ?>
			</span>
			<span class="oria-blog-card__sep" aria-hidden="true">·</span>
			<time class="oria-blog-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
			<span class="oria-blog-card__sep" aria-hidden="true">·</span>
			<span class="oria-blog-card__read-time"><?php echo esc_html( oria_reading_time( get_the_ID() ) ); ?></span>
		</div>

		<a href="<?php the_permalink(); ?>" class="oria-blog-card__cta" aria-label="<?php echo esc_attr( sprintf( __( 'Read more: %s', 'oria-patel' ), get_the_title() ) ); ?>">
			<?php esc_html_e( 'Read More', 'oria-patel' ); ?> &rarr;
		</a>

	</div>

</article>

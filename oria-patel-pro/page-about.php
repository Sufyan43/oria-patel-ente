<?php
/**
 * Template Name: About Page
 */
get_header(); ?>

<div class="op-page-header">
	<div class="op-container">
		<?php op_breadcrumb(); ?>
		<h1 class="op-page-header__title"><?php the_title(); ?></h1>
	</div>
</div>

<div class="op-container op-section">

	<!-- Page content (editable in WordPress editor) -->
	<?php while ( have_posts() ) : the_post(); ?>
	<div class="op-page-content op-page-content--wide">
		<?php the_content(); ?>
	</div>
	<?php endwhile; ?>

	<!-- Why Choose Us tiles -->
	<div style="margin-top:60px">
		<h2 class="op-section-title">Why Choose Oria Patel?</h2>
		<div class="op-value-props" style="margin-top:24px">
			<?php for ( $i = 1; $i <= 4; $i++ ) :
				$icon  = get_theme_mod( "op_prop_{$i}_icon",  '' );
				$title = get_theme_mod( "op_prop_{$i}_title", '' );
				$desc  = get_theme_mod( "op_prop_{$i}_desc",  '' );
				if ( ! $title ) continue;
			?>
			<div class="op-value-prop">
				<div class="op-value-prop__icon"><?php echo esc_html( $icon ); ?></div>
				<h3 class="op-value-prop__title"><?php echo esc_html( $title ); ?></h3>
				<p class="op-value-prop__desc"><?php echo esc_html( $desc ); ?></p>
			</div>
			<?php endfor; ?>
		</div>
	</div>

	<!-- Stats bar -->
	<?php op_stats_bar(); ?>

	<!-- How It Works -->
	<?php op_how_it_works(); ?>

	<!-- CTA -->
	<div style="text-align:center;margin-top:60px;padding:48px;background:#0F1111;border-radius:16px;color:#fff">
		<h2 style="color:#fff;font-size:28px;margin:0 0 12px">Ready to Order Your Custom Uniforms?</h2>
		<p style="color:rgba(255,255,255,.8);margin:0 0 24px">Get a design mockup within 48 hours — no commitment needed.</p>
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--primary" style="font-size:16px;height:50px;padding:0 32px">
			Request a Quote →
		</a>
	</div>

</div>

<?php get_footer(); ?>

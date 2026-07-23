<?php
/**
 * Blog Sidebar — sidebar-blog.php
 */
?>
<aside class="oria-blog-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'oria-patel' ); ?>">

	<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'blog-sidebar' ); ?>
	<?php else : ?>

		<!-- Search -->
		<div class="oria-sidebar-widget">
			<h3 class="oria-sidebar-widget__title"><?php esc_html_e( 'Search', 'oria-patel' ); ?></h3>
			<?php get_search_form(); ?>
		</div>

		<!-- Recent Posts -->
		<div class="oria-sidebar-widget">
			<h3 class="oria-sidebar-widget__title"><?php esc_html_e( 'Recent Posts', 'oria-patel' ); ?></h3>
			<?php
			$recent = wp_get_recent_posts( [ 'numberposts' => 5, 'post_status' => 'publish' ] );
			if ( $recent ) :
			?>
			<ul class="oria-sidebar-widget__list">
				<?php foreach ( $recent as $rp ) : ?>
				<li>
					<a href="<?php echo esc_url( get_permalink( $rp['ID'] ) ); ?>">
						<?php echo esc_html( $rp['post_title'] ); ?>
					</a>
					<span class="oria-sidebar-widget__meta"><?php echo esc_html( get_the_date( '', $rp['ID'] ) ); ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>

		<!-- Categories -->
		<div class="oria-sidebar-widget">
			<h3 class="oria-sidebar-widget__title"><?php esc_html_e( 'Categories', 'oria-patel' ); ?></h3>
			<ul class="oria-sidebar-widget__list">
				<?php wp_list_categories( [
					'title_li'   => '',
					'hide_empty' => 1,
					'show_count' => 1,
				] ); ?>
			</ul>
		</div>

		<!-- Tags -->
		<div class="oria-sidebar-widget">
			<h3 class="oria-sidebar-widget__title"><?php esc_html_e( 'Tags', 'oria-patel' ); ?></h3>
			<div class="oria-sidebar-widget__tagcloud">
				<?php wp_tag_cloud( [
					'smallest'  => 12,
					'largest'   => 18,
					'unit'      => 'px',
					'format'    => 'flat',
					'separator' => ' ',
					'number'    => 20,
				] ); ?>
			</div>
		</div>

		<!-- CTA -->
		<div class="oria-sidebar-widget oria-sidebar-cta">
			<p class="oria-sidebar-cta__emoji">🏅</p>
			<h3 class="oria-sidebar-widget__title" style="margin:8px 0"><?php esc_html_e( 'Get a Free Quote', 'oria-patel' ); ?></h3>
			<p style="font-size:13px;color:#565959;margin:0 0 16px"><?php esc_html_e( 'Zero minimum order. 48-hour design mockup. Worldwide shipping.', 'oria-patel' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--primary op-btn--full">
				<?php esc_html_e( 'Request Quote', 'oria-patel' ); ?>
			</a>
		</div>

	<?php endif; ?>
</aside>

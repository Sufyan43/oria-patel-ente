<?php
/**
 * Archive template for the opm_product custom post type.
 * Shown at /products/ — sidebar layout with hierarchical category navigation.
 */
get_header(); ?>

<div class="op-page-header">
	<div class="op-container">
		<?php op_breadcrumb(); ?>
		<h1 class="op-page-header__title"><?php echo esc_html( get_theme_mod( 'op_products_page_title', 'Our Products' ) ); ?></h1>
		<p class="op-page-header__sub"><?php echo esc_html( get_theme_mod( 'op_products_page_sub', 'Custom sports uniforms manufactured in Sialkot, Pakistan. Zero minimum order.' ) ); ?></p>
	</div>
</div>

<div class="op-container op-section">
	<div class="op-shop-layout">

		<!-- ── LEFT SIDEBAR ───────────────────────────────── -->
		<aside class="op-sidebar">
			<p class="op-sidebar__title"><?php esc_html_e( 'Categories', 'oria-patel' ); ?></p>

			<?php
			// "All Products" link
			$is_all = ! is_tax();
			?>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'opm_product' ) ); ?>"
			   class="op-sidebar__all<?php echo $is_all ? ' is-active' : ''; ?>">
				<?php esc_html_e( 'All Products', 'oria-patel' ); ?>
			</a>

			<div class="op-sidebar__divider"></div>

			<?php
			// Fetch all non-empty terms once
			$all_terms = get_terms( [
				'taxonomy'   => 'opm_category',
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'ASC',
			] );

			if ( ! is_wp_error( $all_terms ) && $all_terms ) :

				// Separate parents and children
				$parents  = [];
				$children = []; // keyed by parent term_id

				foreach ( $all_terms as $term ) {
					if ( 0 === (int) $term->parent ) {
						$parents[] = $term;
					} else {
						$children[ $term->parent ][] = $term;
					}
				}

				// Collect parent IDs for orphan detection
				$parent_ids = wp_list_pluck( $parents, 'term_id' );

				// Orphans: terms whose parent doesn't appear in the list (treat as top-level)
				$orphans = [];
				foreach ( $all_terms as $term ) {
					if ( $term->parent > 0 && ! in_array( $term->parent, $parent_ids, true ) ) {
						$orphans[] = $term;
					}
				}

				// Determine active term
				$current_term = is_tax() ? get_queried_object() : null;

				// Helper closure: render a single link
				$render_link = function( $term, $is_child = false ) use ( $current_term ) {
					$active    = $current_term instanceof WP_Term && $current_term->term_id === $term->term_id;
					$css_class = $is_child ? 'op-sidebar__link op-sidebar__link--child' : 'op-sidebar__link op-sidebar__link--parent';
					if ( $active ) $css_class .= ' is-active';
					?>
					<a href="<?php echo esc_url( get_term_link( $term ) ); ?>"
					   class="<?php echo esc_attr( $css_class ); ?>">
						<span class="op-sidebar__label"><?php echo esc_html( $term->name ); ?></span>
						<span class="op-sidebar__count"><?php echo absint( $term->count ); ?></span>
					</a>
					<?php
				};

				// Render parent categories with their children
				foreach ( $parents as $parent ) :
					$render_link( $parent, false );

					if ( ! empty( $children[ $parent->term_id ] ) ) :
						foreach ( $children[ $parent->term_id ] as $child ) :
							$render_link( $child, true );
						endforeach;
					endif;

				endforeach;

				// Render orphaned child terms as top-level
				foreach ( $orphans as $orphan ) :
					$render_link( $orphan, false );
				endforeach;

			endif;
			?>
		</aside>
		<!-- ── END SIDEBAR ────────────────────────────────── -->

		<!-- ── PRODUCT AREA ───────────────────────────────── -->
		<div class="op-products-area">

			<?php if ( have_posts() ) : ?>

				<div class="op-results-bar">
					<p class="op-results-count">
						<?php
						global $wp_query;
						$total = $wp_query->found_posts;
						echo '<strong>' . absint( $total ) . '</strong> ';
						echo esc_html( _n( 'product', 'products', $total, 'oria-patel' ) );
						?>
					</p>
				</div>

				<div class="op-product-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
						$specs = [];
						$raw   = get_post_meta( get_the_ID(), '_opm_specs', true );
						if ( $raw ) $specs = array_filter( array_map( 'trim', explode( ',', $raw ) ) );
						if ( ! $specs ) $specs = [ '100% Sublimation', 'MOQ: 1', 'Custom Design', 'Worldwide Shipping' ];

						op_product_card( [
							'name'      => get_the_title(),
							'image_url' => get_the_post_thumbnail_url( get_the_ID(), 'op-card' ) ?: '',
							'permalink' => get_permalink(),
							'cta_url'   => home_url( '/contact/' ),
							'specs'     => $specs,
						] );
						?>
					<?php endwhile; ?>
				</div>

				<?php the_posts_pagination( [
					'mid_size'  => 2,
					'prev_text' => '&larr; ' . __( 'Previous', 'oria-patel' ),
					'next_text' => __( 'Next', 'oria-patel' ) . ' &rarr;',
				] ); ?>

			<?php else : ?>

				<div style="text-align:center;padding:80px 0">
					<p style="font-size:56px;margin:0">📭</p>
					<h2 style="margin:16px 0 8px;font-size:24px"><?php esc_html_e( 'No products yet', 'oria-patel' ); ?></h2>
					<p style="color:#565959;margin:0 0 24px"><?php esc_html_e( 'Add your first product from the WordPress dashboard.', 'oria-patel' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--primary">
						<?php esc_html_e( 'Get a Quote', 'oria-patel' ); ?>
					</a>
				</div>

			<?php endif; ?>

		</div>
		<!-- ── END PRODUCT AREA ───────────────────────────── -->

	</div><!-- .op-shop-layout -->
</div>

<?php get_footer(); ?>

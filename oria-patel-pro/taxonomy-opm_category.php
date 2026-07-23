<?php
/**
 * Taxonomy archive for opm_category — /products/[category]/
 * Mirrors archive-opm_product.php but with correct H1 (category name).
 */
get_header();

$term = get_queried_object();
?>

<div class="op-page-header">
	<div class="op-container">
		<?php if ( function_exists( 'oria_breadcrumb_html' ) ) oria_breadcrumb_html(); else op_breadcrumb(); ?>
		<h1 class="op-page-header__title"><?php echo esc_html( $term->name ); ?></h1>
		<?php if ( $term->description ) : ?>
		<p class="op-page-header__sub"><?php echo esc_html( $term->description ); ?></p>
		<?php else : ?>
		<p class="op-page-header__sub">
			<?php printf(
				/* translators: %s category name */
				esc_html__( 'Custom %s manufactured in Sialkot, Pakistan. Zero MOQ, worldwide shipping.', 'oria-patel' ),
				esc_html( $term->name )
			); ?>
		</p>
		<?php endif; ?>
	</div>
</div>

<div class="op-container op-section">
	<div class="op-shop-layout">

		<!-- ── LEFT SIDEBAR ───────────────────────────────── -->
		<aside class="op-sidebar">
			<p class="op-sidebar__title"><?php esc_html_e( 'Categories', 'oria-patel' ); ?></p>

			<a href="<?php echo esc_url( get_post_type_archive_link( 'opm_product' ) ); ?>"
			   class="op-sidebar__all">
				<?php esc_html_e( 'All Products', 'oria-patel' ); ?>
			</a>

			<div class="op-sidebar__divider"></div>

			<?php
			$all_terms = get_terms( [
				'taxonomy'   => 'opm_category',
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'ASC',
			] );

			if ( ! is_wp_error( $all_terms ) && $all_terms ) :
				$parents  = [];
				$children = [];
				foreach ( $all_terms as $t ) {
					if ( 0 === (int) $t->parent ) $parents[] = $t;
					else $children[ $t->parent ][] = $t;
				}
				$parent_ids = wp_list_pluck( $parents, 'term_id' );
				$orphans    = [];
				foreach ( $all_terms as $t ) {
					if ( $t->parent > 0 && ! in_array( $t->parent, $parent_ids, true ) ) $orphans[] = $t;
				}

				$render_link = function( $t, $is_child = false ) use ( $term ) {
					$active    = $term && $term->term_id === $t->term_id;
					$css_class = $is_child ? 'op-sidebar__link op-sidebar__link--child' : 'op-sidebar__link op-sidebar__link--parent';
					if ( $active ) $css_class .= ' is-active';
					?>
					<a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="<?php echo esc_attr( $css_class ); ?>">
						<span class="op-sidebar__label"><?php echo esc_html( $t->name ); ?></span>
						<span class="op-sidebar__count"><?php echo absint( $t->count ); ?></span>
					</a>
					<?php
				};

				foreach ( $parents as $parent ) {
					$render_link( $parent, false );
					if ( ! empty( $children[ $parent->term_id ] ) ) {
						foreach ( $children[ $parent->term_id ] as $child ) {
							$render_link( $child, true );
						}
					}
				}
				foreach ( $orphans as $orphan ) $render_link( $orphan, false );
			endif;
			?>
		</aside>

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
					<?php while ( have_posts() ) : the_post();
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
					endwhile; ?>
				</div>

				<?php the_posts_pagination( [
					'mid_size'  => 2,
					'prev_text' => '&larr; ' . __( 'Previous', 'oria-patel' ),
					'next_text' => __( 'Next', 'oria-patel' ) . ' &rarr;',
				] ); ?>

			<?php else : ?>
				<div style="text-align:center;padding:80px 0">
					<p style="font-size:56px;margin:0">📭</p>
					<h2 style="margin:16px 0 8px;font-size:24px"><?php esc_html_e( 'No products in this category', 'oria-patel' ); ?></h2>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--primary">
						<?php esc_html_e( 'Get a Quote', 'oria-patel' ); ?>
					</a>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>

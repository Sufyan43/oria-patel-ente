<?php
/**
 * Homepage template — front-page.php
 * Uses opm_product CPT. No WooCommerce dependency.
 */
get_header();

$hero_img_id = get_theme_mod( 'op_hero_image', 0 );
$hero_img    = $hero_img_id ? wp_get_attachment_image_url( $hero_img_id, 'op-hero' ) : '';
$shop_url    = home_url( '/products/' );
$cta_url     = home_url( '/contact/' );
?>

<main id="main" class="op-site-main" role="main">

	<!-- ══ HERO — full bleed ════════════════════════════════════════════ -->
	<div class="op-hero">
		<?php if ( $hero_img ) :
			// Resolve explicit dimensions from attachment metadata so browsers can
			// reserve layout space before the image loads (prevents CLS).
			$hero_img_id = (int) get_theme_mod( 'op_hero_image', 0 );
			$hero_meta   = $hero_img_id ? wp_get_attachment_metadata( $hero_img_id ) : [];
			$hero_w      = ! empty( $hero_meta['width'] )  ? (int) $hero_meta['width']  : 1400;
			$hero_h      = ! empty( $hero_meta['height'] ) ? (int) $hero_meta['height'] : 700;
		?>
			<img
				class="op-hero__bg"
				src="<?php echo esc_url( $hero_img ); ?>"
				alt="Custom sports uniforms manufacturer Sialkot Pakistan"
				width="<?php echo esc_attr( $hero_w ); ?>"
				height="<?php echo esc_attr( $hero_h ); ?>"
				fetchpriority="high"
				loading="eager"
			/>
		<?php else : ?>
			<div class="op-hero__bg" style="background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);opacity:1;"></div>
		<?php endif; ?>
		<div class="op-hero__overlay"></div>
		<div class="op-container" style="position:relative;z-index:2;width:100%;">
			<div class="op-hero__content" style="padding:80px 0;max-width:600px">
				<?php $badge = get_theme_mod( 'op_hero_badge', 'Premium Manufacturer · Sialkot, Pakistan' ); if ( $badge ) : ?>
					<span class="op-hero__badge"><?php echo esc_html( $badge ); ?></span>
				<?php endif; ?>

				<?php
				$_hero_title  = esc_html( get_theme_mod( 'op_hero_title', 'Best Custom Uniforms for Champions' ) );
				$_hero_accent = trim( get_theme_mod( 'op_hero_accent_word', 'Uniforms' ) );
				if ( '' !== $_hero_accent && str_contains( $_hero_title, $_hero_accent ) ) {
					$_hero_title = str_replace( $_hero_accent, '<span>' . esc_html( $_hero_accent ) . '</span>', $_hero_title );
				}
				?>
				<h1 class="op-hero__title"><?php echo wp_kses( $_hero_title, [ 'span' => [] ] ); ?></h1>

				<?php $desc = get_theme_mod( 'op_hero_desc', 'Professional-grade sublimated sportswear from our factory. Zero minimum orders, design mockups, worldwide delivery.' ); if ( $desc ) : ?>
					<p class="op-hero__desc"><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>

				<div class="op-hero__actions">
					<a href="<?php echo esc_url( get_theme_mod( 'op_hero_cta1_url', $shop_url ) ); ?>" class="op-btn op-btn--primary">
						<?php echo esc_html( get_theme_mod( 'op_hero_cta1_text', __( 'Browse Products', 'oria-patel' ) ) ); ?>
					</a>
					<a href="<?php echo esc_url( get_theme_mod( 'op_hero_cta2_url', $cta_url ) ); ?>" class="op-btn op-btn--ghost">
						<?php echo esc_html( get_theme_mod( 'op_hero_cta2_text', __( 'Get Quote', 'oria-patel' ) ) ); ?>
					</a>
				</div>
			</div>
		</div>
	</div><!-- .op-hero -->

	<!-- ══ VALUE PROPS STRIP ═════════════════════════════════════════════ -->
	<?php
	$props_defaults = [
		1 => [ '🎨', 'Design Mockup',     '48-hour digital preview' ],
		2 => [ '📦', 'Zero MOQ',           'Order as few as 1 piece' ],
		3 => [ '✈️',  'Worldwide Shipping', 'We ship to every country' ],
		4 => [ '🏭',  'Factory Direct',     'Made in Sialkot, Pakistan' ],
	];
	?>
	<section class="op-section op-section--sm">
		<div class="op-container">
			<div class="op-value-props op-reveal">
				<?php for ( $i = 1; $i <= 4; $i++ ) :
					$icon  = get_theme_mod( "op_prop_{$i}_icon",  $props_defaults[$i][0] );
					$title = get_theme_mod( "op_prop_{$i}_title", $props_defaults[$i][1] );
					$desc  = get_theme_mod( "op_prop_{$i}_desc",  $props_defaults[$i][2] );
					if ( ! $title ) continue;
				?>
				<div class="op-value-prop">
					<?php if ( $icon ) : ?>
						<div class="op-value-prop__icon" aria-hidden="true"><?php echo esc_html( $icon ); ?></div>
					<?php endif; ?>
					<div>
						<p class="op-value-prop__title"><?php echo esc_html( $title ); ?></p>
						<?php if ( $desc ) : ?>
							<p class="op-value-prop__desc"><?php echo esc_html( $desc ); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<!-- ══ SHOP BY CATEGORY GRID ═════════════════════════════════════════ -->
	<section class="op-section">
		<div class="op-container">
			<div class="op-section-header">
				<div class="op-section-header__left">
					<p class="op-section-eyebrow" data-op-setting="op_section_eyebrow_cats"><?php echo esc_html( get_theme_mod( 'op_section_eyebrow_cats', 'Browse by Sport' ) ); ?></p>
					<h2 class="op-section-title" data-op-setting="op_section_title_cats"><?php echo esc_html( get_theme_mod( 'op_section_title_cats', 'Shop by Category' ) ); ?></h2>
				</div>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="op-see-all"><?php esc_html_e( 'View all →', 'oria-patel' ); ?></a>
			</div>
			<?php op_category_grid(); ?>
		</div>
	</section>

	<!-- ══ TOP PRODUCTS SLIDER ═══════════════════════════════════════════ -->
	<section class="op-section">
		<div class="op-container">
			<div class="op-section-header op-reveal">
				<div class="op-section-header__left">
					<p class="op-section-eyebrow" data-op-setting="op_section_eyebrow_top"><?php echo esc_html( get_theme_mod( 'op_section_eyebrow_top', 'Best Sellers' ) ); ?></p>
					<h2 class="op-section-title" data-op-setting="op_section_title_top"><?php echo esc_html( get_theme_mod( 'op_section_title_top', 'Top Products' ) ); ?></h2>
				</div>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="op-see-all"><?php esc_html_e( 'See all →', 'oria-patel' ); ?></a>
			</div>

			<div class="op-slider-wrap op-reveal">
				<button class="op-slider-btn op-slider-btn--prev" aria-label="<?php esc_attr_e( 'Previous', 'oria-patel' ); ?>" disabled>&#8592;</button>
				<div class="op-slider-track" id="op-slider-home">
					<?php
					$cpt_products = new WP_Query( [
						'post_type'      => 'opm_product',
						'posts_per_page' => 12,
						'post_status'    => 'publish',
						'orderby'        => 'date',
						'order'          => 'DESC',
					] );
					// Track IDs shown here so category sections below exclude them (prevents duplicates).
					$op_shown_ids = [];

					if ( $cpt_products->have_posts() ) {
						while ( $cpt_products->have_posts() ) {
							$cpt_products->the_post();
							$id             = get_the_ID();
							$op_shown_ids[] = $id;
							$specs = array_values( array_filter( array_map( 'trim', explode( ',', get_post_meta( $id, '_opm_specs', true ) ?: '' ) ) ) );
							echo '<div class="op-slider-track__item">';
							op_product_card( [
								'name'      => get_the_title(),
								'image_url' => get_the_post_thumbnail_url( $id, 'op-card' ) ?: '',
								'permalink' => get_permalink(),
								'cta_url'   => $cta_url,
								'specs'     => $specs ?: [ '100% Sublimation', 'MOQ: 1', 'Custom Design', 'Worldwide Shipping' ],
							] );
							echo '</div>';
						}
						wp_reset_postdata();
					} else {
						// Static fallback — shown until real products are added
						$static_products = [
							[ 'name' => 'Basketball Jersey',         'specs' => [ '100% Sublimation', 'Lightweight Mesh', 'MOQ: 1', 'Custom Sizing' ] ],
							[ 'name' => 'Soccer Uniform',            'specs' => [ '100% Sublimation', 'Breathable Fabric', 'MOQ: 1', 'Custom Colors' ] ],
							[ 'name' => 'American Football Uniform', 'specs' => [ '100% Sublimation', 'Stretch Fabric', 'MOQ: 1', 'Custom Numbers' ] ],
							[ 'name' => 'Track Suit',                'specs' => [ '100% Sublimation', 'Full Set', 'MOQ: 1', 'Custom Sizing' ] ],
							[ 'name' => 'Baseball Uniform',          'specs' => [ '100% Sublimation', 'Moisture-Wicking', 'MOQ: 1', 'Custom Names' ] ],
							[ 'name' => 'Sports Hoodie',             'specs' => [ 'Custom Print', 'Fleece Lining', 'MOQ: 1', 'All Sizes' ] ],
							[ 'name' => 'Hockey Uniform',            'specs' => [ '100% Sublimation', 'Durable Polyester', 'MOQ: 1', 'Custom Design' ] ],
							[ 'name' => 'Volleyball Jersey',         'specs' => [ '100% Sublimation', 'Stretch Fit', 'MOQ: 1', 'Custom Numbers' ] ],
							[ 'name' => 'Cycling Kit',               'specs' => [ '100% Sublimation', 'Padded Shorts', 'MOQ: 1', 'Aero Fit' ] ],
						];
						foreach ( $static_products as $p ) {
							echo '<div class="op-slider-track__item">';
							op_product_card( $p );
							echo '</div>';
						}
					}
					?>
				</div>
				<button class="op-slider-btn op-slider-btn--next" aria-label="<?php esc_attr_e( 'Next', 'oria-patel' ); ?>">&#8594;</button>
			</div>
		</div>
	</section>





		<!-- ══ PER-CATEGORY PRODUCT SECTIONS ════════════════════════════════ -->
	<?php
	// Query ALL products not shown in the slider
	$all_products = new WP_Query( [
		'post_type'      => 'opm_product',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'post__not_in'   => $op_shown_ids ?? [],
		'orderby'        => 'title',
		'order'            => 'ASC',
	] );

	$gym_fitness    = [];
	$team_sports    = [];
	$jackets        = [];
	$accessories    = [];
	$uncategorized  = [];

	if ( $all_products->have_posts() ) {
		while ( $all_products->have_posts() ) {
			$all_products->the_post();
			$id    = get_the_ID();
			$title = strtolower( get_the_title() );

			// JACKETS (check first — some jacket titles also contain "uniform")
			if ( str_contains( $title, 'jacket' ) || str_contains( $title, 'bomber' ) || str_contains( $title, 'varsity' ) || str_contains( $title, 'satin' ) || str_contains( $title, 'softshell' ) || str_contains( $title, 'insulation' ) || str_contains( $title, 'denim' ) || str_contains( $title, 'puffer' ) || str_contains( $title, 'thinsulate' ) ) {
				$jackets[] = $id;
			}
			// ACCESSORIES
			elseif ( str_contains( $title, 'bag' ) || str_contains( $title, 'sock' ) ) {
				$accessories[] = $id;
			}
			// TEAM SPORTS UNIFORMS
			elseif ( str_contains( $title, 'soccer' ) || str_contains( $title, 'basketball' ) || str_contains( $title, 'baseball' ) || str_contains( $title, 'softball' ) || str_contains( $title, 'track suit' ) || ( str_contains( $title, 'uniform' ) && ! str_contains( $title, 'jacket' ) ) ) {
				$team_sports[] = $id;
			}
			// GYM & FITNESS WEAR
			elseif ( str_contains( $title, 'crop top' ) || str_contains( $title, 'workout' ) || str_contains( $title, 'gym' ) || str_contains( $title, 'stringer' ) || str_contains( $title, 'sports bra' ) || str_contains( $title, 'tudo' ) || str_contains( $title, 'hoodie' ) ) {
				$gym_fitness[] = $id;
			}
			else {
				$uncategorized[] = $id;
			}
		}
		wp_reset_postdata();
	}

	// Helper to render a category section
	function op_render_category_section( $section_id, $heading, $subtitle, $product_ids, $cta_url ) {
		if ( empty( $product_ids ) ) return;
		?>
		<section class="op-section op-category-section" id="<?php echo esc_attr( $section_id ); ?>">
			<div class="op-container">
				<div class="op-section-header op-reveal" style="margin-bottom:32px;">
					<div class="op-section-header__left">
						<h2 class="op-section-title" style="margin-bottom:4px;"><?php echo esc_html( $heading ); ?></h2>
						<p style="color:#888; font-size:15px; margin:0;"><?php echo esc_html( $subtitle ); ?></p>
					</div>
				</div>
				<div class="op-product-grid op-reveal" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:24px;">
					<?php
					foreach ( $product_ids as $pid ) {
						$specs = array_values( array_filter( array_map( 'trim', explode( ',', get_post_meta( $pid, '_opm_specs', true ) ?: '' ) ) ) );
						op_product_card( [
							'name'      => get_the_title( $pid ),
							'image_url' => get_the_post_thumbnail_url( $pid, 'op-card' ) ?: '',
							'permalink' => get_permalink( $pid ),
							'cta_url'   => $cta_url,
							'specs'     => $specs ?: [ '100% Sublimation', 'Custom Design', 'All Sizes', 'Worldwide Shipping' ],
						] );
					}
					?>
				</div>
			</div>
		</section>
		<?php
	}

	// Render all 4 sections
	op_render_category_section( 'gym-fitness', 'Gym & Fitness Wear', 'Custom gym wear, crop tops, stringers, and workout gear', $gym_fitness, $cta_url );
	op_render_category_section( 'team-sports', 'Team Sports Uniforms', 'Full kits for soccer, basketball, baseball, and track', $team_sports, $cta_url );
	op_render_category_section( 'jackets', 'Jackets & Outerwear', 'Varsity, bomber, denim, and insulated jackets', $jackets, $cta_url );
	op_render_category_section( 'accessories', 'Accessories', 'Sports bags, socks, and add-ons', $accessories, $cta_url );

	// If anything didn't match, dump it at the end
	if ( ! empty( $uncategorized ) ) {
		op_render_category_section( 'more-products', 'More Products', 'Additional items from our catalog', $uncategorized, $cta_url );
	}
	?>

	<!-- ══ HOW IT WORKS ══════════════════════════════════════════════════ -->
	<section class="op-section">
		<div class="op-container">
			<?php op_how_it_works(); ?>
		</div>
	</section>

	<!-- ══ STATS BAR ═════════════════════════════════════════════════════ -->
	<section class="op-section op-section--sm">
		<div class="op-container">
			<?php op_stats_bar(); ?>
		</div>
	</section>

	<!-- ══ CTA BANNER ════════════════════════════════════════════════════ -->
	<section class="op-section op-section--sm">
		<div class="op-container">
			<div class="op-cta-banner op-reveal">
				<div>
					<h2 class="op-cta-banner__title"><?php echo esc_html( get_theme_mod( 'op_cta_banner_title', 'Ready to outfit your team?' ) ); ?></h2>
					<p class="op-cta-banner__desc"><?php echo esc_html( get_theme_mod( 'op_cta_banner_desc', 'Get a design mockup within 48 hours. No minimums, no commitment.' ) ); ?></p>
				</div>
				<div class="op-cta-banner__actions">
					<a href="<?php echo esc_url( $cta_url ); ?>" class="op-btn op-btn--outline">
						<?php echo esc_html( get_theme_mod( 'op_cta_btn1_text', 'Get Quote' ) ); ?>
					</a>
					<a href="<?php echo esc_url( $shop_url ); ?>" class="op-btn op-btn--dark">
						<?php echo esc_html( get_theme_mod( 'op_cta_btn2_text', 'Browse Products' ) ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>

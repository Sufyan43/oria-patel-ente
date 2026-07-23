<?php
/**
 * Template helper functions — Oria Patel Theme
 * No WooCommerce dependency — uses opm_product CPT only.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Always returns the CPT products archive URL.
 */
function op_shop_url(): string {
	return home_url( '/products/' );
}

/**
 * Return a stable (non-random) inquiry count for a given seed string.
 * Consistent per product on every page load — range 50–220.
 */
function op_stable_inquiries( string $seed ): int {
	return ( abs( crc32( $seed ) ) % 171 ) + 50;
}

/**
 * Render a single product card.
 * No star ratings — social proof is inquiries count only.
 *
 * @param array $data  Keys: name, image_url, permalink, cta_url, specs, inquiries.
 *                     All optional — sensible defaults are used for any missing key.
 */
function op_product_card( array $data = [] ): void {
	$brand     = get_theme_mod( 'op_brand_name', 'Oria Patel Enterprises' );
	$name      = $data['name']      ?? __( 'Custom Uniform', 'oria-patel' );
	$img_url   = $data['image_url'] ?? '';
	$permalink = $data['permalink'] ?? home_url( '/products/' );
	$cta_url   = $data['cta_url']   ?? home_url( '/contact/' );
	// Cap specs at 4 items — more than 4 bloats DOM and adds no buyer value
	$raw_specs = $data['specs'] ?? [ '100% Sublimation', 'MOQ: 1', 'Custom Design', 'Worldwide Shipping' ];
	$specs     = array_slice( (array) $raw_specs, 0, 4 );
	$inquiries = $data['inquiries'] ?? op_stable_inquiries( $name );
	?>
	<div class="op-product-card">
		<a href="<?php echo esc_url( $permalink ); ?>" class="op-product-card__image-wrap" tabindex="-1">
			<?php if ( $img_url ) : ?>
				<img
					class="op-product-card__image"
					src="<?php echo esc_url( $img_url ); ?>"
					alt="<?php echo esc_attr( $name ); ?>"
					loading="lazy"
				/>
			<?php else : ?>
				<div style="width:100%;height:100%;background:#E5E7EB;display:flex;align-items:center;justify-content:center;font-size:48px;">🏅</div>
			<?php endif; ?>
		</a>

		<div class="op-product-card__body">
			<p class="op-product-card__seller"><?php echo esc_html( $brand ); ?></p>

			<a href="<?php echo esc_url( $permalink ); ?>" class="op-product-card__title">
				<?php echo esc_html( $name ); ?>
			</a>

			<p class="op-product-card__social-proof">
				🔥 <strong><?php echo esc_html( $inquiries ); ?>+</strong>
				<?php esc_html_e( 'inquiries this month', 'oria-patel' ); ?>
			</p>

			<?php if ( $specs ) : ?>
				<ul class="op-product-card__specs">
					<?php foreach ( $specs as $spec ) : ?>
						<li class="op-product-card__spec"><?php echo esc_html( $spec ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<!-- Shipping note removed from card — shown once in footer instead -->
		</div>

		<div class="op-product-card__footer">
			<a href="<?php echo esc_url( $cta_url ); ?>" class="op-product-card__cta">
				<?php esc_html_e( 'Request Quote', 'oria-patel' ); ?>
			</a>
		</div>
	</div>
	<?php
}

/**
 * Render the category grid from Customizer settings.
 * Auto-resolves opm_category term links when no URL is manually set.
 */
function op_category_grid(): void {
	$fallback_url    = home_url( '/products/' );
	$label_defaults  = [
		1 => 'American Football', 2 => 'Baseball',   3 => 'Basketball', 4 => 'Hockey',
		5 => 'Soccer',            6 => 'Volleyball',  7 => 'Wrestling',  8 => 'Track & Field',
	];

	echo '<div class="op-category-grid">';
	$rendered = 0;
	for ( $i = 1; $i <= 8; $i++ ) {
		$label    = get_theme_mod( "op_cat_{$i}_label", $label_defaults[ $i ] );
		$url      = get_theme_mod( "op_cat_{$i}_url",   '' );
		$image_id = get_theme_mod( "op_cat_{$i}_image", 0 );

		if ( ! $label ) continue;

		// Auto-resolve opm_category link when URL not manually set
		if ( ! $url && taxonomy_exists( 'opm_category' ) ) {
			$term = get_term_by( 'name', $label, 'opm_category' );
			if ( $term && ! is_wp_error( $term ) ) {
				$resolved = get_term_link( $term );
				if ( ! is_wp_error( $resolved ) ) $url = $resolved;
			}
		}
		$url = $url ?: $fallback_url;

		$img_url = $image_id ? wp_get_attachment_image_url( $image_id, 'op-category' ) : '';

		$rendered++;
		?>
		<a href="<?php echo esc_url( $url ); ?>" class="op-category-card op-reveal op-reveal--delay-<?php echo $i; ?>">
			<?php if ( $img_url ) : ?>
				<img class="op-category-card__img" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $label ); ?>" loading="lazy" />
			<?php else : ?>
				<div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a1a2e,#16213e);"></div>
			<?php endif; ?>
			<div class="op-category-card__overlay"></div>
			<div class="op-category-card__body">
				<p class="op-category-card__label"><?php echo esc_html( $label ); ?></p>
				<p class="op-category-card__cta"><?php esc_html_e( 'Shop now →', 'oria-patel' ); ?></p>
			</div>
		</a>
		<?php
	}
	if ( 0 === $rendered ) {
		echo '<p style="color:#999;font-size:13px;padding:24px 0;grid-column:1/-1">';
		esc_html_e( 'Add sport category cards in Appearance → Customize → Sport Category Cards.', 'oria-patel' );
		echo '</p>';
	}
	echo '</div>';
}

/**
 * Render the stats bar with defaults so it always shows content.
 */
function op_stats_bar(): void {
	$defaults = [
		1 => [ '🏆', '500+',      'Happy Clients'     ],
		2 => [ '🌍', '35+',       'Countries Served'   ],
		3 => [ '⚽',  '12+',       'Sports Covered'     ],
		4 => [ '📅',  'Since 1992','Est. in Sialkot'    ],
	];

	$rows = [];
	for ( $i = 1; $i <= 4; $i++ ) {
		$icon  = get_theme_mod( "op_stat_{$i}_icon",  $defaults[$i][0] );
		$value = get_theme_mod( "op_stat_{$i}_value", $defaults[$i][1] );
		$label = get_theme_mod( "op_stat_{$i}_label", $defaults[$i][2] );
		if ( ! $value ) continue;
		$rows[] = compact( 'icon', 'value', 'label' );
	}

	if ( ! $rows ) return;

	echo '<div class="op-stats op-reveal"><div class="op-stats__grid">';
	foreach ( $rows as $row ) {
		echo '<div class="op-stat">';
		if ( $row['icon'] ) echo '<div class="op-stat__icon">' . esc_html( $row['icon'] ) . '</div>';
		echo '<div class="op-stat__value" data-count="' . esc_attr( $row['value'] ) . '">' . esc_html( $row['value'] ) . '</div>';
		echo '<div class="op-stat__label">' . esc_html( $row['label'] ) . '</div>';
		echo '</div>';
	}
	echo '</div></div>';
}

/**
 * Render one product slider section for a category.
 *
 * @param string $subtitle  Optional subtitle shown below the H2 with an orange divider.
 */
function op_render_cat_section( string $title, string $cat_url, string $eyebrow, array $items, string $slider_id, string $subtitle = '' ): void {
	if ( empty( $items ) ) return;
	?>
	<section class="op-section op-cat-section" id="op-cat-<?php echo esc_attr( $slider_id ); ?>">
		<div class="op-container">
			<div class="op-section-header op-reveal">
				<div class="op-section-header__left">
					<p class="op-section-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
					<h2 class="op-section-title"><?php echo esc_html( $title ); ?></h2>
					<?php if ( $subtitle ) : ?>
						<p class="op-cat-section__subtitle"><?php echo esc_html( $subtitle ); ?></p>
						<div class="op-cat-divider" aria-hidden="true"></div>
					<?php endif; ?>
				</div>
				<a href="<?php echo esc_url( $cat_url ); ?>" class="op-see-all"><?php esc_html_e( 'See all →', 'oria-patel' ); ?></a>
			</div>

			<div class="op-slider-wrap op-reveal">
				<button class="op-slider-btn op-slider-btn--prev" aria-label="<?php esc_attr_e( 'Previous', 'oria-patel' ); ?>" disabled>&#8592;</button>
				<div class="op-slider-track" id="<?php echo esc_attr( 'op-slider-cat-' . $slider_id ); ?>">
					<?php foreach ( $items as $item ) : ?>
					<div class="op-slider-track__item">
						<?php op_product_card( $item ); ?>
					</div>
					<?php endforeach; ?>
				</div>
				<button class="op-slider-btn op-slider-btn--next" aria-label="<?php esc_attr_e( 'Next', 'oria-patel' ); ?>">&#8594;</button>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Render per-category product slider sections on the homepage.
 *
 * Priority:
 *   1. Real opm_category terms with actual products
 *   2. Hardcoded static showcase (5 categories, always looks great)
 */
/**
 * @param int[] $exclude_ids  Product IDs already shown on the page (e.g. top slider).
 */
function op_category_product_sections( array $exclude_ids = [] ): void {
	/* Serve from a 1-hour transient cache only when no exclusions are passed */
	$use_cache = empty( $exclude_ids );
	if ( $use_cache ) {
		$cached = get_transient( 'op_cat_sections_v1' );
		if ( false !== $cached ) {
			echo $cached; // phpcs:ignore WordPress.Security.EscapeOutput
			return;
		}
	}
	ob_start();

	$shop_url = home_url( '/products/' );
	$cta_url  = home_url( '/contact/' );
	$rendered = 0;

	/* ── 1. Real CPT products/categories ──────────────────────────────── */
	if ( post_type_exists( 'opm_product' ) && taxonomy_exists( 'opm_category' ) ) {
		$parent_cats = get_terms( [
			'taxonomy'   => 'opm_category',
			'parent'     => 0,
			'hide_empty' => true,
			'number'     => 8,
			'orderby'    => 'count',
			'order'      => 'DESC',
		] );

		if ( ! is_wp_error( $parent_cats ) && ! empty( $parent_cats ) ) {
			foreach ( $parent_cats as $cat ) {
				$term_ids = [ $cat->term_id ];
				$children = get_term_children( $cat->term_id, 'opm_category' );
				if ( $children && ! is_wp_error( $children ) ) {
					$term_ids = array_merge( $term_ids, $children );
				}

				$q_args = [
					'post_type'      => 'opm_product',
					'posts_per_page' => 12,
					'post_status'    => 'publish',
					'tax_query'      => [ [
						'taxonomy' => 'opm_category',
						'field'    => 'term_id',
						'terms'    => $term_ids,
					] ],
				];
				// Skip products already shown in the "Top Products" slider (fixes duplicates).
				if ( ! empty( $exclude_ids ) ) {
					$q_args['post__not_in'] = array_map( 'absint', $exclude_ids );
				}
				$q = new WP_Query( $q_args );
				if ( ! $q->have_posts() ) continue;

				$items = [];
				while ( $q->have_posts() ) {
					$q->the_post();
					$id        = get_the_ID();
					$name      = get_the_title();
					$specs_raw = get_post_meta( $id, '_opm_specs', true ) ?: '';
					$specs     = array_values( array_filter( array_map( 'trim', explode( ',', $specs_raw ) ) ) );
					$stored    = (int) get_post_meta( $id, '_opm_inquiries', true );
					$items[]   = [
						'name'      => $name,
						'image_url' => get_the_post_thumbnail_url( $id, 'op-card' ) ?: '',
						'permalink' => get_permalink(),
						'cta_url'   => $cta_url,
						'inquiries' => $stored > 0 ? $stored : op_stable_inquiries( $name . $id ),
						'specs'     => $specs ?: [ '100% Sublimation', 'MOQ: 1', 'Custom Design', 'Worldwide Shipping' ],
					];
				}
				wp_reset_postdata();

				$cat_link = get_term_link( $cat );
				op_render_cat_section(
					$cat->name,
					is_wp_error( $cat_link ) ? $shop_url : $cat_link,
					__( 'Browse Category', 'oria-patel' ),
					$items,
					(string) $cat->term_id
				);
				$rendered++;
			}
		}
	}

	if ( $rendered > 0 ) return;

	/* ── 2. Static showcase — organised into the 4 real product categories ── */
	$static_cats = [
		[
			'name'     => 'Gym & Fitness Wear',
			'subtitle' => 'Custom gym wear, crop tops, stringers, and workout gear',
			'eyebrow'  => 'Most Popular',
			'id'       => 'gym',
			'products' => [
				[ 'name' => 'Female Crop Top',      'specs' => [ '100% Sublimation', 'Cropped Fit', 'MOQ: 1', 'Custom Design' ] ],
				[ 'name' => 'Female Workout Top',   'specs' => [ '100% Sublimation', 'Moisture-Wicking', 'MOQ: 1', 'Custom Colors' ] ],
				[ 'name' => 'Men Workout Shorts',   'specs' => [ '100% Sublimation', 'Elastic Waistband', 'MOQ: 1', 'Custom Design' ] ],
				[ 'name' => 'Men Workout Hoodies',  'specs' => [ '100% Sublimation', 'Fleece Lining', 'MOQ: 1', 'Custom Logo' ] ],
				[ 'name' => 'Men Stringers',        'specs' => [ '100% Sublimation', 'Sleeveless Cut', 'MOQ: 1', 'All Sizes' ] ],
				[ 'name' => 'Men Gym T-Shirts',     'specs' => [ '100% Sublimation', 'Breathable Fabric', 'MOQ: 1', 'Custom Print' ] ],
				[ 'name' => 'Men Gym Pants',        'specs' => [ '100% Sublimation', 'Tapered Fit', 'MOQ: 1', 'Custom Design' ] ],
				[ 'name' => 'Sports Bra Designs',   'specs' => [ '100% Sublimation', 'High-Support', 'MOQ: 1', 'Custom Colors' ] ],
				[ 'name' => 'Tudo Shorts',          'specs' => [ '100% Sublimation', 'Lightweight', 'MOQ: 1', 'Custom Design' ] ],
			],
		],
		[
			'name'     => 'Team Sports Uniforms',
			'subtitle' => 'Full kits for soccer, basketball, baseball, and track',
			'eyebrow'  => 'Pro Grade',
			'id'       => 'uniforms',
			'products' => [
				[ 'name' => 'Soccer Uniform Designs', 'specs' => [ '100% Sublimation', 'Full Kit Available', 'MOQ: 1', 'Custom Name & Number' ] ],
				[ 'name' => 'Basketball Uniform',     'specs' => [ '100% Sublimation', 'Lightweight Mesh', 'MOQ: 1', 'Custom Number' ] ],
				[ 'name' => 'Baseball Uniform',       'specs' => [ '100% Sublimation', 'Button-Down Style', 'MOQ: 1', 'Custom Name & Number' ] ],
				[ 'name' => 'Track Suite (Male)',     'specs' => [ '100% Sublimation', 'Jacket + Pants', 'MOQ: 1', 'Custom Design' ] ],
			],
		],
		[
			'name'     => 'Jackets & Outerwear',
			'subtitle' => 'Varsity, bomber, denim, and insulated jackets',
			'eyebrow'  => 'Classic Craft',
			'id'       => 'jackets',
			'products' => [
				[ 'name' => 'Casual Jacket',      'specs' => [ '100% Sublimation', 'Full Zip', 'MOQ: 1', 'Custom Design' ] ],
				[ 'name' => 'Softshell Jacket',   'specs' => [ 'Softshell Fabric', 'Wind-Resistant', 'MOQ: 1', 'Custom Logo' ] ],
				[ 'name' => 'Insulation Jacket',  'specs' => [ 'Insulated Fill', 'Warm & Lightweight', 'MOQ: 1', 'Custom Colors' ] ],
				[ 'name' => 'Denim Jacket',       'specs' => [ 'Premium Denim', 'Custom Embroidery', 'MOQ: 1', 'All Sizes' ] ],
				[ 'name' => 'Satin Jackets',      'specs' => [ 'Satin Finish', 'Embroidery Ready', 'MOQ: 1', 'Custom Design' ] ],
				[ 'name' => 'Varsity Jackets',    'specs' => [ 'Wool Body', 'Leather Sleeves', 'MOQ: 1', 'Custom Patches' ] ],
				[ 'name' => 'Bomber Jacket',      'specs' => [ '100% Sublimation', 'Ribbed Cuffs', 'MOQ: 1', 'Custom Logo' ] ],
			],
		],
		[
			'name'     => 'Accessories',
			'subtitle' => 'Sports bags, socks, and add-ons',
			'eyebrow'  => 'Complete the Kit',
			'id'       => 'accessories',
			'products' => [
				[ 'name' => 'Sports Bag',   'specs' => [ 'Heavy-Duty Fabric', 'Custom Branding', 'MOQ: 1', 'Multiple Sizes' ] ],
				[ 'name' => 'Sports Socks', 'specs' => [ 'Moisture-Wicking', 'Cushioned Sole', 'MOQ: 1', 'Custom Colors' ] ],
			],
		],
	];

	foreach ( $static_cats as $cat ) {
		$items = [];
		foreach ( $cat['products'] as $p ) {
			$items[] = [
				'name'      => $p['name'],
				'image_url' => '',
				'permalink' => $shop_url,
				'cta_url'   => $cta_url,
				'inquiries' => op_stable_inquiries( $p['name'] ),
				'specs'     => $p['specs'],
			];
		}
		op_render_cat_section( $cat['name'], $shop_url, $cat['eyebrow'], $items, $cat['id'], $cat['subtitle'] );
	}

	$html = ob_get_clean();
	if ( $use_cache ) {
		set_transient( 'op_cat_sections_v1', $html, HOUR_IN_SECONDS );
	}
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Render the How It Works / Simple Process section with defaults.
 */
function op_how_it_works(): void {
	$step_defaults = [
		1 => [ 'title' => 'Tell Us Your Design',    'desc' => 'Share your team colours, logo, and style. We create a full digital mockup within 48 hours — completely free.' ],
		2 => [ 'title' => 'Approve & Revise',        'desc' => 'Review your mockup and request unlimited revisions. We refine every detail until you are 100% happy.' ],
		3 => [ 'title' => 'We Manufacture & Ship',   'desc' => 'Your uniforms are crafted in our Sialkot factory using 100% sublimation and shipped worldwide with tracking.' ],
	];

	$steps = [];
	for ( $i = 1; $i <= 3; $i++ ) {
		$title = get_theme_mod( "op_step_{$i}_title", $step_defaults[$i]['title'] );
		$desc  = get_theme_mod( "op_step_{$i}_desc",  $step_defaults[$i]['desc'] );
		if ( $title ) $steps[] = compact( 'title', 'desc' );
	}

	if ( ! $steps ) return;
	?>
	<div class="op-steps op-reveal">
		<div class="op-section-header" style="margin-bottom:0">
			<div class="op-section-header__left">
				<p class="op-section-eyebrow"><?php esc_html_e( 'Simple Process', 'oria-patel' ); ?></p>
				<h2 class="op-section-title"><?php esc_html_e( 'How It Works', 'oria-patel' ); ?></h2>
			</div>
		</div>
		<div class="op-steps__grid">
			<?php foreach ( $steps as $idx => $step ) : ?>
			<div class="op-step">
				<div class="op-step__number"><?php echo esc_html( $idx + 1 ); ?></div>
				<h3 class="op-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
				<p class="op-step__desc"><?php echo esc_html( $step['desc'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

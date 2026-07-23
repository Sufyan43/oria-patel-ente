<?php
/**
 * Single product template for opm_product CPT.
 * Used when WooCommerce is NOT active.
 */
get_header();
the_post();

$product_id = get_the_ID();
$name       = get_the_title();
$img_url         = get_the_post_thumbnail_url( $product_id, 'op-card' ) ?: '';
$thumb_attach_id = get_post_thumbnail_id( $product_id );
$img_full        = $thumb_attach_id ? ( wp_get_attachment_image_url( $thumb_attach_id, 'full' ) ?: $img_url ) : $img_url;
$desc       = get_the_content();
$excerpt    = get_the_excerpt();

// Custom meta
$specs      = array_filter( array_map( 'trim', explode( ',', get_post_meta( $product_id, '_opm_specs',    true ) ?: '' ) ) );
$sizes      = array_filter( array_map( 'trim', explode( ',', get_post_meta( $product_id, '_opm_sizes',    true ) ?: '' ) ) );
$colors     = array_filter( array_map( 'trim', explode( ',', get_post_meta( $product_id, '_opm_colors',   true ) ?: '' ) ) );
$fabric     = get_post_meta( $product_id, '_opm_fabric',   true );
$printing   = get_post_meta( $product_id, '_opm_printing', true );
$moq        = get_post_meta( $product_id, '_opm_moq',       true ) ?: '1';
$lead_time  = get_post_meta( $product_id, '_opm_lead_time', true );
$badge      = get_post_meta( $product_id, '_opm_badge_text', true );
// Try the canonical key first, fall back to legacy _opm_gallery for products saved before the fix
$_gallery_raw = get_post_meta( $product_id, '_product_image_gallery', true ) ?: get_post_meta( $product_id, '_opm_gallery', true ) ?: '';
$gallery_ids  = array_filter( array_map( 'absint', explode( ',', $_gallery_raw ) ) );

// Categories
$cats = wp_get_post_terms( $product_id, 'opm_category', [ 'fields' => 'names' ] );
if ( is_wp_error( $cats ) ) $cats = [];

$whatsapp  = get_theme_mod( 'op_social_whatsapp', 'https://wa.me/923117337511' );
$inquiries = op_stable_inquiries( $name . $product_id );

if ( ! $specs ) $specs = [ '100% Sublimation', 'MOQ: ' . $moq, 'Custom Design', 'Worldwide Shipping' ];
?>

<div class="op-page-header">
	<div class="op-container">
		<?php op_breadcrumb(); ?>
		<h1 class="op-page-header__title"><?php echo esc_html( $name ); ?></h1>
	</div>
</div>

<div class="op-container op-section">
	<div class="op-product-single">

		<!-- ── Gallery ────────────────────────────────────────────── -->
		<?php
		// Build lightbox image list: featured first, then gallery
		$lbox = [];
		if ( $img_full ) {
			$lbox[] = [ 'full' => $img_full, 'preview' => $img_url, 'alt' => $name ];
		}
		foreach ( $gallery_ids as $gid ) {
			$gfull    = wp_get_attachment_image_url( $gid, 'full' );
			$gpreview = wp_get_attachment_image_url( $gid, 'op-card' ) ?: $gfull;
			$gthumb   = wp_get_attachment_image_url( $gid, 'thumbnail' ) ?: $gpreview;
			$galt     = get_post_meta( $gid, '_wp_attachment_image_alt', true ) ?: $name;
			if ( $gfull ) $lbox[] = [ 'full' => $gfull, 'preview' => $gpreview, 'thumb' => $gthumb, 'alt' => $galt ];
		}
		$lbox_json = wp_json_encode( $lbox );
		$has_lbox  = ! empty( $lbox );
		?>
		<div class="op-product-gallery">
			<!-- Main image -->
			<div class="op-product-main-img <?php echo $has_lbox ? 'op-lbox-trigger' : ''; ?>"
			     <?php if ( $has_lbox ) echo 'data-lbox-index="0" role="button" tabindex="0" aria-label="View full image"'; ?>>
				<?php if ( $img_url ) : ?>
					<img src="<?php echo esc_url( $img_url ); ?>"
					     id="op-main-product-img"
					     alt="<?php echo esc_attr( $name ); ?>" />
					<?php if ( $has_lbox ) : ?>
					<span class="op-lbox-zoom" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
					</span>
					<?php endif; ?>
				<?php else : ?>
					<div class="op-product-img-placeholder">🏅</div>
				<?php endif; ?>
			</div>

			<!-- Thumbnails -->
			<?php if ( count( $lbox ) > 1 ) : ?>
			<div class="op-product-thumbs">
				<?php foreach ( $lbox as $i => $limg ) :
					$tsrc = isset( $limg['thumb'] ) ? $limg['thumb'] : $limg['preview'];
				?>
				<button class="op-thumb <?php echo $i === 0 ? 'op-thumb--active' : ''; ?>"
				        data-lbox-index="<?php echo $i; ?>"
				        data-preview="<?php echo esc_url( $limg['preview'] ); ?>"
				        aria-label="View image <?php echo $i + 1; ?>"
				        type="button">
					<img src="<?php echo esc_url( $tsrc ); ?>" alt="" />
				</button>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>

		<!-- ── Lightbox overlay ─────────────────────────────────────── -->
		<?php if ( $has_lbox ) : ?>
		<div id="op-lightbox" class="op-lightbox" role="dialog" aria-modal="true" aria-label="Product image viewer" hidden>
			<button class="op-lightbox__close" id="op-lbox-close" aria-label="Close">&times;</button>
			<button class="op-lightbox__nav op-lightbox__prev" id="op-lbox-prev" aria-label="Previous image">&#8249;</button>
			<div class="op-lightbox__stage">
				<img src="" alt="" id="op-lbox-img" class="op-lightbox__img" />
				<div class="op-lightbox__counter" id="op-lbox-counter"></div>
			</div>
			<button class="op-lightbox__nav op-lightbox__next" id="op-lbox-next" aria-label="Next image">&#8250;</button>
		</div>
		<script>
		(function(){
			var imgs    = <?php echo $lbox_json; ?>;
			var total   = imgs.length;
			var cur     = 0;
			var lb      = document.getElementById('op-lightbox');
			var lbImg   = document.getElementById('op-lbox-img');
			var lbCount = document.getElementById('op-lbox-counter');
			var mainImg = document.getElementById('op-main-product-img');

			function open(idx){
				cur = (idx + total) % total;
				lbImg.src = imgs[cur].full;
				lbImg.alt = imgs[cur].alt || '';
				lbCount.textContent = (cur + 1) + ' / ' + total;
				lb.hidden = false;
				document.body.classList.add('op-lbox-open');
				document.getElementById('op-lbox-close').focus();
			}
			function close(){
				lb.hidden = true;
				document.body.classList.remove('op-lbox-open');
			}
			function swapMain(idx){
				cur = (idx + total) % total;
				if(mainImg) mainImg.src = imgs[cur].preview;
				// update active thumb
				document.querySelectorAll('.op-thumb').forEach(function(b,i){
					b.classList.toggle('op-thumb--active', i === cur);
				});
			}

			// Thumbnail clicks: swap main image + track current index
			document.querySelectorAll('.op-thumb').forEach(function(btn){
				btn.addEventListener('click', function(){
					var idx = parseInt(this.dataset.lboxIndex, 10);
					swapMain(idx);
				});
			});

			// Main image click → open lightbox
			document.querySelectorAll('.op-lbox-trigger').forEach(function(el){
				el.addEventListener('click', function(){ open(cur); });
				el.addEventListener('keydown', function(e){ if(e.key==='Enter'||e.key===' '){ e.preventDefault(); open(cur); } });
			});

			document.getElementById('op-lbox-close').addEventListener('click', close);
			document.getElementById('op-lbox-prev').addEventListener('click', function(){ open(cur - 1); });
			document.getElementById('op-lbox-next').addEventListener('click', function(){ open(cur + 1); });

			// Click backdrop to close
			lb.addEventListener('click', function(e){ if(e.target === lb) close(); });

			// Keyboard nav
			document.addEventListener('keydown', function(e){
				if(lb.hidden) return;
				if(e.key === 'Escape')    close();
				if(e.key === 'ArrowLeft') open(cur - 1);
				if(e.key === 'ArrowRight')open(cur + 1);
			});
		})();
		</script>
		<?php endif; ?>

		<!-- ── Info ───────────────────────────────────────────────── -->
		<div class="op-product-info">
			<p style="font-size:13px;color:#565959;margin-bottom:8px"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>

			<h1 class="op-product-info__name"><?php echo esc_html( $name ); ?></h1>

			<!-- Social proof — inquiries only, no stars -->
			<p style="font-size:14px;color:#565959;margin:8px 0 16px">
				🔥 <strong style="color:#0F1111"><?php echo $inquiries; ?>+</strong>
				<?php esc_html_e( 'inquiries this month', 'oria-patel' ); ?>
			</p>

			<!-- Badges -->
			<div class="op-product-info__badges" style="margin-bottom:16px">
				<?php if ( $badge ) : ?>
					<span class="op-badge op-badge--accent"><?php echo esc_html( $badge ); ?></span>
				<?php endif; ?>
				<span class="op-badge op-badge--success"><?php esc_html_e( 'Design Mockup', 'oria-patel' ); ?></span>
				<span class="op-badge"><?php echo esc_html( sprintf( __( 'MOQ: %s', 'oria-patel' ), $moq ) ); ?></span>
				<span class="op-badge"><?php esc_html_e( '100% Sublimation', 'oria-patel' ); ?></span>
				<?php foreach ( $cats as $cat ) : ?>
					<span class="op-badge"><?php echo esc_html( $cat ); ?></span>
				<?php endforeach; ?>
			</div>

			<?php if ( $excerpt ) : ?>
			<p style="color:#565959;font-size:15px;line-height:1.6;margin-bottom:20px"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>

			<!-- Trust bullets -->
			<div style="background:#FAFAFA;border:1px solid #D5D9D9;border-radius:8px;padding:16px;margin-bottom:20px;font-size:13px">
				<p style="display:flex;gap:8px;align-items:center;margin-bottom:8px"><span style="color:#067D62;font-weight:700">✓</span><?php esc_html_e( 'We are shipping worldwide', 'oria-patel' ); ?></p>
				<p style="display:flex;gap:8px;align-items:center;margin-bottom:8px"><span style="color:#067D62;font-weight:700">✓</span><?php esc_html_e( '48-hour design mockup', 'oria-patel' ); ?></p>
				<p style="display:flex;gap:8px;align-items:center;margin-bottom:8px"><span style="color:#067D62;font-weight:700">✓</span><?php esc_html_e( 'No minimum order quantity', 'oria-patel' ); ?></p>
				<?php if ( $lead_time ) : ?>
				<p style="display:flex;gap:8px;align-items:center"><span style="color:#067D62;font-weight:700">✓</span><?php echo esc_html( sprintf( __( 'Lead time: %s', 'oria-patel' ), $lead_time ) ); ?></p>
				<?php endif; ?>
			</div>

			<!-- Specs -->
			<?php if ( $specs ) : ?>
			<div style="margin-bottom:20px">
				<p style="font-size:13px;font-weight:700;margin-bottom:8px;color:#0F1111"><?php esc_html_e( 'Specifications', 'oria-patel' ); ?></p>
				<ul class="op-product-card__specs" style="display:flex;flex-wrap:wrap;gap:6px;list-style:none;padding:0;margin:0">
					<?php foreach ( $specs as $spec ) : ?>
						<li class="op-product-card__spec"><?php echo esc_html( $spec ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<!-- Colours -->
			<?php if ( $colors ) : ?>
			<div style="margin-bottom:20px">
				<p style="font-size:13px;font-weight:700;margin-bottom:8px;color:#0F1111"><?php esc_html_e( 'Available Colours', 'oria-patel' ); ?></p>
				<div style="display:flex;flex-wrap:wrap;gap:6px">
					<?php foreach ( $colors as $color ) : ?>
						<span style="padding:4px 12px;border-radius:4px;font-size:13px;background:#F0F2F2;border:1px solid #D5D9D9"><?php echo esc_html( $color ); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>

			<!-- Sizes -->
			<?php if ( $sizes ) : ?>
			<div style="margin-bottom:24px">
				<p style="font-size:13px;font-weight:700;margin-bottom:8px;color:#0F1111"><?php esc_html_e( 'Available Sizes', 'oria-patel' ); ?></p>
				<div style="display:flex;flex-wrap:wrap;gap:6px">
					<?php foreach ( $sizes as $size ) : ?>
						<span style="min-width:40px;text-align:center;padding:6px 10px;border-radius:4px;font-size:13px;font-weight:600;background:#F0F2F2;border:1px solid #D5D9D9"><?php echo esc_html( $size ); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>

			<!-- CTAs -->
			<div class="op-product-info__cta-group">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="op-btn op-btn--primary" style="height:50px;font-size:16px">
					<?php esc_html_e( 'Request a Quote', 'oria-patel' ); ?>
				</a>
				<?php if ( $whatsapp ) : ?>
				<a href="<?php echo esc_url( $whatsapp ); ?>" class="op-btn op-btn--outline" style="background:#25D366;border-color:#25D366;color:#fff;height:50px;font-size:16px" target="_blank" rel="noopener noreferrer">
					💬 <?php esc_html_e( 'WhatsApp Us', 'oria-patel' ); ?>
				</a>
				<?php endif; ?>
			</div>
		</div>

	</div><!-- .op-product-single -->

	<!-- Full description -->
	<?php if ( $desc ) : ?>
	<div style="margin-top:60px;padding-top:40px;border-top:1px solid #D5D9D9">
		<h2 class="op-section-title" style="margin-bottom:20px"><?php esc_html_e( 'Product Details', 'oria-patel' ); ?></h2>
		<div class="op-page-content" style="max-width:720px"><?php echo wp_kses_post( $desc ); ?></div>
	</div>
	<?php endif; ?>

	<!-- Related products -->
	<?php
	$related_args = [
		'post_type'      => 'opm_product',
		'posts_per_page' => 4,
		'post__not_in'   => [ $product_id ],
		'orderby'        => 'rand',
		'post_status'    => 'publish',
	];
	// Match by category if possible
	if ( $cats ) {
		$cat_term = get_term_by( 'name', $cats[0], 'opm_category' );
		if ( $cat_term && ! is_wp_error( $cat_term ) ) {
			$related_args['tax_query'] = [ [ 'taxonomy' => 'opm_category', 'field' => 'term_id', 'terms' => $cat_term->term_id ] ];
		}
	}
	$related_query = new WP_Query( $related_args );
	if ( $related_query->have_posts() ) :
	?>
	<div style="margin-top:60px">
		<h2 class="op-section-title" style="margin-bottom:24px"><?php esc_html_e( 'Related Products', 'oria-patel' ); ?></h2>
		<div class="op-product-grid" style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">
			<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
				<?php
				$rspecs = array_filter( array_map( 'trim', explode( ',', get_post_meta( get_the_ID(), '_opm_specs', true ) ?: '' ) ) );
				op_product_card( [
					'name'      => get_the_title(),
					'image_url' => get_the_post_thumbnail_url( get_the_ID(), 'op-card' ) ?: '',
					'permalink' => get_permalink(),
					'cta_url'   => home_url( '/contact/' ),
					'specs'     => $rspecs ?: [ '100% Sublimation', 'MOQ: 1', 'Custom Design', 'Worldwide Shipping' ],
				] );
				?>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
	<?php endif; ?>

	<!-- All products -->
	<?php
	$all_products_query = new WP_Query( [
		'post_type'      => 'opm_product',
		'posts_per_page' => 8,
		'post__not_in'   => [ $product_id ],
		'orderby'        => 'date',
		'order'          => 'DESC',
		'post_status'    => 'publish',
	] );
	if ( $all_products_query->have_posts() ) :
	?>
	<div style="margin-top:60px">
		<div style="display:flex;justify-content:space-between;align-items:flex-end;gap:16px;margin-bottom:24px;flex-wrap:wrap">
			<h2 class="op-section-title" style="margin-bottom:0"><?php esc_html_e( 'All Products', 'oria-patel' ); ?></h2>
			<a href="<?php echo esc_url( home_url( '/products/' ) ); ?>" class="op-see-all"><?php esc_html_e( 'Browse all →', 'oria-patel' ); ?></a>
		</div>
		<div class="op-product-grid" style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">
			<?php while ( $all_products_query->have_posts() ) : $all_products_query->the_post(); ?>
				<?php
				$aspecs = array_filter( array_map( 'trim', explode( ',', get_post_meta( get_the_ID(), '_opm_specs', true ) ?: '' ) ) );
				op_product_card( [
					'name'      => get_the_title(),
					'image_url' => get_the_post_thumbnail_url( get_the_ID(), 'op-card' ) ?: '',
					'permalink' => get_permalink(),
					'cta_url'   => home_url( '/contact/' ),
					'specs'     => $aspecs ?: [ '100% Sublimation', 'MOQ: 1', 'Custom Design', 'Worldwide Shipping' ],
				] );
				?>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>

<?php
/**
 * Blog Functions — Oria Patel Theme
 * Reading time, related posts, social share, auto product linking.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ══════════════════════════════════════════════════════════════════════════
   1. READING TIME
══════════════════════════════════════════════════════════════════════════ */
function oria_reading_time( int $post_id = 0 ): string {
	$content   = get_post_field( 'post_content', $post_id ?: get_the_ID() );
	$words     = str_word_count( wp_strip_all_tags( $content ) );
	$mins      = max( 1, (int) round( $words / 200 ) );
	return sprintf( _n( '%d min read', '%d min read', $mins, 'oria-patel' ), $mins );
}

/* ══════════════════════════════════════════════════════════════════════════
   2. RELATED POSTS  (same category, exclude current)
══════════════════════════════════════════════════════════════════════════ */
function oria_related_posts( int $post_id = 0, int $count = 3 ): WP_Query {
	$post_id = $post_id ?: get_the_ID();
	$cats    = get_the_category( $post_id );
	$cat_ids = $cats ? wp_list_pluck( $cats, 'term_id' ) : [];

	$args = [
		'post_type'           => 'post',
		'posts_per_page'      => $count,
		'post_status'         => 'publish',
		'post__not_in'        => [ $post_id ],
		'ignore_sticky_posts' => true,
		'orderby'             => 'rand',
	];
	if ( $cat_ids ) {
		$args['category__in'] = $cat_ids;
	}
	return new WP_Query( $args );
}

/* ══════════════════════════════════════════════════════════════════════════
   3. SOCIAL SHARE BUTTONS
══════════════════════════════════════════════════════════════════════════ */
function oria_social_share_buttons( int $post_id = 0 ): void {
	$post_id = $post_id ?: get_the_ID();
	$url     = rawurlencode( get_permalink( $post_id ) );
	$title   = rawurlencode( get_the_title( $post_id ) );
	$excerpt = rawurlencode( wp_trim_words( get_the_excerpt( $post_id ), 20, '' ) );

	$platforms = [
		'facebook'  => [
			'url'   => "https://www.facebook.com/sharer/sharer.php?u={$url}",
			'label' => __( 'Share on Facebook', 'oria-patel' ),
			'color' => '#1877F2',
			'svg'   => '<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>',
		],
		'twitter'   => [
			'url'   => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
			'label' => __( 'Share on Twitter / X', 'oria-patel' ),
			'color' => '#000',
			'svg'   => '<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
		],
		'linkedin'  => [
			'url'   => "https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}&summary={$excerpt}",
			'label' => __( 'Share on LinkedIn', 'oria-patel' ),
			'color' => '#0A66C2',
			'svg'   => '<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
		],
		'whatsapp'  => [
			'url'   => "https://wa.me/?text={$title}%20{$url}",
			'label' => __( 'Share on WhatsApp', 'oria-patel' ),
			'color' => '#25D366',
			'svg'   => '<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
		],
		'email'     => [
			'url'   => "mailto:?subject={$title}&body={$url}",
			'label' => __( 'Share via Email', 'oria-patel' ),
			'color' => '#565959',
			'svg'   => '<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
		],
	];
	?>
	<div class="oria-social-share">
		<span class="oria-social-share__label"><?php esc_html_e( 'Share:', 'oria-patel' ); ?></span>
		<?php foreach ( $platforms as $key => $p ) : ?>
		<a href="<?php echo esc_url( $p['url'] ); ?>"
		   class="oria-social-share__btn oria-social-share__btn--<?php echo esc_attr( $key ); ?>"
		   target="_blank"
		   rel="noopener noreferrer"
		   aria-label="<?php echo esc_attr( $p['label'] ); ?>"
		   style="--share-color:<?php echo esc_attr( $p['color'] ); ?>">
			<?php echo $p['svg']; // phpcs:ignore WordPress.Security.EscapeOutput — hardcoded SVG ?>
		</a>
		<?php endforeach; ?>
	</div>
	<?php
}

/* ══════════════════════════════════════════════════════════════════════════
   4. AUTO-LINK PRODUCT NAMES in blog post content
══════════════════════════════════════════════════════════════════════════ */
add_filter( 'the_content', 'oria_autolink_products', 20 );
function oria_autolink_products( string $content ): string {
	// Only on single blog posts, not in admin
	if ( ! is_singular( 'post' ) || is_admin() ) return $content;

	$products = get_posts( [
		'post_type'   => 'opm_product',
		'numberposts' => -1,
		'post_status' => 'publish',
		'orderby'     => 'title',
		'order'       => 'DESC', // Longest first avoids partial matches
	] );

	foreach ( $products as $product ) {
		$name = $product->post_title;
		$link = get_permalink( $product );

		// Split content on HTML tags to avoid matching inside tag attributes or existing links.
		// PHP's PCRE does not support variable-length lookbehinds so we use a split-and-replace approach:
		// only replace text nodes (odd-indexed items after splitting on HTML tags).
		$parts   = preg_split( '/(<[^>]+>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE );
		$in_link = false;
		$replaced_once = false;
		if ( is_array( $parts ) ) {
			foreach ( $parts as $index => $part ) {
				// Even-indexed items are text nodes; odd-indexed are HTML tags.
				if ( $index % 2 !== 0 ) {
					// Track when we enter/exit an <a> tag so we never nest links.
					if ( preg_match( '/<a\b/i', $part ) )  $in_link = true;
					if ( preg_match( '/<\/a>/i', $part ) ) $in_link = false;
					continue;
				}
				// Text node: only replace if not inside a link and not yet replaced.
				if ( ! $in_link && ! $replaced_once && $part !== '' ) {
					$new_part = preg_replace(
						'/\b(' . preg_quote( $name, '/' ) . ')\b/i',
						'<a href="' . esc_url( $link ) . '" class="oria-product-mention">' . esc_html( $name ) . '</a>',
						$part,
						1
					);
					if ( $new_part !== $part ) {
						$replaced_once = true;
					}
					$parts[ $index ] = $new_part;
				}
			}
			$content = implode( '', $parts );
		}
	}

	return $content;
}

/* ══════════════════════════════════════════════════════════════════════════
   5. AUTHOR BIO BOX
══════════════════════════════════════════════════════════════════════════ */
function oria_author_bio_box(): void {
	$author_id  = get_the_author_meta( 'ID' );
	$name       = get_the_author_meta( 'display_name' );
	$bio        = get_the_author_meta( 'description' );
	$avatar_url = get_avatar_url( $author_id, [ 'size' => 80 ] );
	$posts_url  = get_author_posts_url( $author_id );
	if ( ! $bio ) return;
	?>
	<div class="oria-author-box">
		<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="oria-author-box__avatar" width="80" height="80" loading="lazy">
		<div class="oria-author-box__content">
			<p class="oria-author-box__label"><?php esc_html_e( 'About the Author', 'oria-patel' ); ?></p>
			<h3 class="oria-author-box__name"><a href="<?php echo esc_url( $posts_url ); ?>"><?php echo esc_html( $name ); ?></a></h3>
			<p class="oria-author-box__bio"><?php echo wp_kses_post( $bio ); ?></p>
		</div>
	</div>
	<?php
}

/* ══════════════════════════════════════════════════════════════════════════
   6. BLOG IMAGE SIZE
══════════════════════════════════════════════════════════════════════════ */
add_action( 'after_setup_theme', function() {
	add_image_size( 'oria-blog-card', 720, 405, true );  // 16:9 ratio
	add_image_size( 'oria-blog-hero', 1400, 560, true );
}, 20 );

/* ══════════════════════════════════════════════════════════════════════════
   7. BLOG SIDEBAR WIDGET AREA
══════════════════════════════════════════════════════════════════════════ */
add_action( 'widgets_init', function() {
	register_sidebar( [
		'name'          => __( 'Blog Sidebar', 'oria-patel' ),
		'id'            => 'blog-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s oria-sidebar-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="oria-sidebar-widget__title">',
		'after_title'   => '</h3>',
	] );
} );

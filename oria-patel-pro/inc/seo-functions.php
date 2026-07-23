<?php
/**
 * SEO Functions — Oria Patel Theme
 * Sitemap, robots.txt, canonical, schema extensions for blog & reviews.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ══════════════════════════════════════════════════════════════════════════
   1. TITLE TAG FILTER — custom titles per page type
══════════════════════════════════════════════════════════════════════════ */
add_filter( 'pre_get_document_title', 'oria_custom_title_tag', 10 );
function oria_custom_title_tag( string $title ): string {
	$site = get_bloginfo( 'name' );

	if ( is_front_page() ) {
		return 'Oria Patel Enterprises — Custom Sports Uniforms Manufacturer | Sialkot, Pakistan';
	}
	if ( is_singular( 'opm_product' ) ) {
		$cats  = get_the_terms( get_queried_object_id(), 'opm_category' );
		$cat   = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : 'Uniform';
		return get_the_title() . ' — Custom ' . $cat . ' | ' . $site;
	}
	if ( is_post_type_archive( 'opm_product' ) ) {
		return 'Custom Sports Uniforms Catalogue | ' . $site . ' | Sialkot, Pakistan';
	}
	if ( is_tax( 'opm_category' ) ) {
		$term = get_queried_object();
		return 'Custom ' . $term->name . ' Manufacturer | ' . $site . ' | Sialkot, Pakistan';
	}
	if ( is_singular( 'post' ) ) {
		return get_the_title() . ' | ' . $site . ' Blog';
	}
	if ( is_home() || is_post_type_archive( 'post' ) ) {
		return 'Sports Uniform Manufacturing Blog | ' . $site;
	}
	if ( is_singular( 'oria_review' ) || is_post_type_archive( 'oria_review' ) ) {
		return 'Customer Reviews & Testimonials | ' . $site;
	}
	return $title; // Default WordPress title for all other pages
}

/* ══════════════════════════════════════════════════════════════════════════
   2. EXTENDED SEO HEAD — blog posts, reviews, category schema
══════════════════════════════════════════════════════════════════════════ */
add_action( 'wp_head', 'oria_extended_seo_head', 2 );
function oria_extended_seo_head(): void {
	$logo_id  = (int) get_theme_mod( 'custom_logo', 0 );
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
	$site     = get_bloginfo( 'name' );

	// ── Canonical URL ────────────────────────────────────────────────────
	// WordPress core's rel_canonical() fires on wp_head at priority 10 for singular
	// pages. We suppress it (see functions.php) and emit our own so we can cover
	// archive and taxonomy pages that core does not handle.
	if ( is_singular() ) {
		echo '<link rel="canonical" href="' . esc_url( get_permalink() ) . '">' . "\n";
	} elseif ( is_post_type_archive( 'opm_product' ) ) {
		echo '<link rel="canonical" href="' . esc_url( home_url( '/products/' ) ) . '">' . "\n";
	} elseif ( is_post_type_archive( 'oria_review' ) ) {
		echo '<link rel="canonical" href="' . esc_url( home_url( '/reviews/' ) ) . '">' . "\n";
	} elseif ( is_home() ) {
		echo '<link rel="canonical" href="' . esc_url( home_url( '/blog/' ) ) . '">' . "\n";
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$term = get_queried_object();
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) ) {
			echo '<link rel="canonical" href="' . esc_url( $link ) . '">' . "\n";
		}
	}

	// ── Schema: BlogPosting ──────────────────────────────────────────────
	if ( is_singular( 'post' ) ) {
		$img_url = get_the_post_thumbnail_url( null, 'large' ) ?: $logo_url;
		$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 55, '…' );

		$schema = [
			'@context'         => 'https://schema.org',
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title(),
			'description'      => mb_substr( $excerpt, 0, 160 ),
			'image'            => $img_url,
			'author'           => [
				'@type' => 'Person',
				'name'  => get_the_author(),
			],
			'publisher'        => [
				'@type' => 'Organization',
				'name'  => $site,
				'logo'  => [ '@type' => 'ImageObject', 'url' => $logo_url ],
			],
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'mainEntityOfPage' => get_permalink(),
			'url'              => get_permalink(),
		];

		echo '<script type="application/ld+json">'
			. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
			. '</script>' . "\n";

		// OG article tags
		echo '<meta property="og:type"             content="article">' . "\n";
		echo '<meta property="article:author"      content="' . esc_attr( get_the_author() ) . '">' . "\n";
		echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c' ) ) . '">' . "\n";
		echo '<meta property="article:modified_time"  content="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . "\n";
	}

	// ── Schema: BreadcrumbList ────────────────────────────────────────────
	$crumbs = oria_breadcrumb_items();
	if ( count( $crumbs ) > 1 ) {
		$list = [];
		foreach ( $crumbs as $pos => $crumb ) {
			$list[] = [
				'@type'    => 'ListItem',
				'position' => $pos + 1,
				'name'     => $crumb['name'],
				'item'     => $crumb['url'],
			];
		}
		$schema = [
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $list,
		];
		echo '<script type="application/ld+json">'
			. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
			. '</script>' . "\n";
	}

	// ── Schema: Review aggregate (reviews archive page) ───────────────────
	if ( is_post_type_archive( 'oria_review' ) ) {
		$avg  = oria_get_average_rating();
		$count = oria_get_review_count();
		if ( $count > 0 ) {
			$schema = [
				'@context'        => 'https://schema.org',
				'@type'           => 'Organization',
				'name'            => $site,
				'url'             => home_url( '/' ),
				'aggregateRating' => [
					'@type'       => 'AggregateRating',
					'ratingValue' => number_format( $avg, 1 ),
					'reviewCount' => $count,
					'bestRating'  => '5',
					'worstRating' => '1',
				],
			];
			echo '<script type="application/ld+json">'
				. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
				. '</script>' . "\n";
		}
	}

	// ── Schema: WebSite + SearchAction (homepage) ─────────────────────────
	if ( is_front_page() ) {
		$schema = [
			'@context'        => 'https://schema.org',
			'@type'           => 'WebSite',
			'name'            => $site,
			'url'             => home_url( '/' ),
			'potentialAction' => [
				'@type'       => 'SearchAction',
				'target'      => [
					'@type'       => 'EntryPoint',
					'urlTemplate' => home_url( '/?s={search_term_string}' ),
				],
				'query-input' => 'required name=search_term_string',
			],
		];
		echo '<script type="application/ld+json">'
			. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
			. '</script>' . "\n";
	}
}

/* ══════════════════════════════════════════════════════════════════════════
   3. BREADCRUMB ITEMS HELPER (returns array for schema + HTML rendering)
══════════════════════════════════════════════════════════════════════════ */
function oria_breadcrumb_items(): array {
	$items = [ [ 'name' => __( 'Home', 'oria-patel' ), 'url' => home_url( '/' ) ] ];

	if ( is_singular( 'opm_product' ) ) {
		$items[] = [ 'name' => __( 'Products', 'oria-patel' ), 'url' => home_url( '/products/' ) ];
		$cats = get_the_terms( get_queried_object_id(), 'opm_category' );
		if ( $cats && ! is_wp_error( $cats ) ) {
			$link = get_term_link( $cats[0] );
			$items[] = [ 'name' => $cats[0]->name, 'url' => is_wp_error( $link ) ? home_url( '/products/' ) : $link ];
		}
		$items[] = [ 'name' => get_the_title(), 'url' => get_permalink() ];

	} elseif ( is_post_type_archive( 'opm_product' ) ) {
		$items[] = [ 'name' => __( 'Products', 'oria-patel' ), 'url' => home_url( '/products/' ) ];

	} elseif ( is_tax( 'opm_category' ) ) {
		$term = get_queried_object();
		$items[] = [ 'name' => __( 'Products', 'oria-patel' ), 'url' => home_url( '/products/' ) ];
		$items[] = [ 'name' => $term->name, 'url' => get_term_link( $term ) ];

	} elseif ( is_singular( 'post' ) ) {
		$items[] = [ 'name' => __( 'Blog', 'oria-patel' ), 'url' => home_url( '/blog/' ) ];
		$cats = get_the_category();
		if ( $cats ) {
			$items[] = [ 'name' => $cats[0]->name, 'url' => get_category_link( $cats[0]->term_id ) ];
		}
		$items[] = [ 'name' => get_the_title(), 'url' => get_permalink() ];

	} elseif ( is_home() ) {
		$items[] = [ 'name' => __( 'Blog', 'oria-patel' ), 'url' => home_url( '/blog/' ) ];

	} elseif ( is_post_type_archive( 'oria_review' ) ) {
		$items[] = [ 'name' => __( 'Reviews', 'oria-patel' ), 'url' => home_url( '/reviews/' ) ];

	} elseif ( is_singular( 'oria_review' ) ) {
		$items[] = [ 'name' => __( 'Reviews', 'oria-patel' ), 'url' => home_url( '/reviews/' ) ];
		$items[] = [ 'name' => get_the_title(), 'url' => get_permalink() ];

	} elseif ( is_category() ) {
		$cat = get_queried_object();
		$items[] = [ 'name' => __( 'Blog', 'oria-patel' ), 'url' => home_url( '/blog/' ) ];
		$items[] = [ 'name' => $cat->name, 'url' => get_category_link( $cat->term_id ) ];

	} elseif ( is_singular() || is_page() ) {
		$items[] = [ 'name' => get_the_title(), 'url' => get_permalink() ];

	} elseif ( is_archive() ) {
		$title = wp_strip_all_tags( get_the_archive_title() );
		$title = preg_replace( '/^[^:]+:\s*/', '', $title );
		$items[] = [ 'name' => $title, 'url' => '' ];
	}

	return $items;
}

/**
 * Render HTML breadcrumb nav using the items array.
 * Replaces op_breadcrumb() with a richer version (schema + accessibility).
 */
function oria_breadcrumb_html(): void {
	$items = oria_breadcrumb_items();
	if ( count( $items ) <= 1 ) return;

	echo '<nav class="op-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'oria-patel' ) . '">';
	echo '<ol itemscope itemtype="https://schema.org/BreadcrumbList" style="list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;align-items:center;gap:4px">';

	$last = count( $items ) - 1;
	foreach ( $items as $i => $crumb ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" style="display:flex;align-items:center;gap:4px">';
		if ( $i < $last && $crumb['url'] ) {
			echo '<a href="' . esc_url( $crumb['url'] ) . '" itemprop="item"><span itemprop="name">' . esc_html( $crumb['name'] ) . '</span></a>';
			echo '<span class="op-breadcrumb__sep" aria-hidden="true">›</span>';
		} else {
			echo '<span class="op-breadcrumb__current" itemprop="name">' . esc_html( $crumb['name'] ) . '</span>';
		}
		echo '<meta itemprop="position" content="' . ( $i + 1 ) . '">';
		echo '</li>';
	}

	echo '</ol></nav>';
}

/* ══════════════════════════════════════════════════════════════════════════
   4. XML SITEMAP at /sitemap.xml
══════════════════════════════════════════════════════════════════════════ */
add_action( 'init', 'oria_sitemap_rewrite' );
function oria_sitemap_rewrite(): void {
	add_rewrite_rule( '^sitemap\.xml$', 'index.php?oria_sitemap=1', 'top' );
}

add_filter( 'query_vars', function( $vars ) {
	$vars[] = 'oria_sitemap';
	return $vars;
} );

add_action( 'template_redirect', 'oria_sitemap_output' );
function oria_sitemap_output(): void {
	if ( ! get_query_var( 'oria_sitemap' ) ) return;

	header( 'Content-Type: application/xml; charset=UTF-8' );
	header( 'X-Robots-Tag: noindex' );

	$home = home_url( '/' );
	$urls = [];

	// Homepage — priority 1.0, daily
	$urls[] = [ 'loc' => $home, 'changefreq' => 'daily', 'priority' => '1.0', 'lastmod' => gmdate( 'Y-m-d' ) ];

	// All published pages
	$pages = get_posts( [ 'post_type' => 'page', 'numberposts' => -1, 'post_status' => 'publish' ] );
	foreach ( $pages as $page ) {
		$urls[] = [
			'loc'        => get_permalink( $page ),
			'changefreq' => 'monthly',
			'priority'   => '0.5',
			'lastmod'    => get_the_modified_date( 'Y-m-d', $page ),
		];
	}

	// Products — priority 0.8, weekly
	$products = get_posts( [ 'post_type' => 'opm_product', 'numberposts' => -1, 'post_status' => 'publish' ] );
	foreach ( $products as $post ) {
		$urls[] = [
			'loc'        => get_permalink( $post ),
			'changefreq' => 'weekly',
			'priority'   => '0.8',
			'lastmod'    => get_the_modified_date( 'Y-m-d', $post ),
		];
	}

	// Product categories — priority 0.6
	$cats = get_terms( [ 'taxonomy' => 'opm_category', 'hide_empty' => true ] );
	if ( ! is_wp_error( $cats ) ) {
		foreach ( $cats as $cat ) {
			$link = get_term_link( $cat );
			if ( ! is_wp_error( $link ) ) {
				$urls[] = [ 'loc' => $link, 'changefreq' => 'weekly', 'priority' => '0.6' ];
			}
		}
	}

	// Blog posts — priority 0.7, weekly
	$posts = get_posts( [ 'post_type' => 'post', 'numberposts' => -1, 'post_status' => 'publish' ] );
	foreach ( $posts as $post ) {
		$urls[] = [
			'loc'        => get_permalink( $post ),
			'changefreq' => 'weekly',
			'priority'   => '0.7',
			'lastmod'    => get_the_modified_date( 'Y-m-d', $post ),
		];
	}

	// Reviews — priority 0.6
	$reviews = get_posts( [ 'post_type' => 'oria_review', 'numberposts' => -1, 'post_status' => 'publish' ] );
	foreach ( $reviews as $post ) {
		$urls[] = [
			'loc'        => get_permalink( $post ),
			'changefreq' => 'monthly',
			'priority'   => '0.6',
			'lastmod'    => get_the_modified_date( 'Y-m-d', $post ),
		];
	}

	// Reviews + Blog archive
	$urls[] = [ 'loc' => home_url( '/reviews/' ), 'changefreq' => 'weekly', 'priority' => '0.6' ];
	$urls[] = [ 'loc' => home_url( '/blog/' ),    'changefreq' => 'daily',  'priority' => '0.7' ];

	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	foreach ( $urls as $u ) {
		echo "\t<url>\n";
		echo "\t\t<loc>" . esc_url( $u['loc'] ) . "</loc>\n";
		if ( ! empty( $u['lastmod'] ) )   echo "\t\t<lastmod>" . esc_html( $u['lastmod'] ) . "</lastmod>\n";
		if ( ! empty( $u['changefreq'] ) ) echo "\t\t<changefreq>" . esc_html( $u['changefreq'] ) . "</changefreq>\n";
		if ( ! empty( $u['priority'] ) )   echo "\t\t<priority>" . esc_html( $u['priority'] ) . "</priority>\n";
		echo "\t</url>\n";
	}
	echo '</urlset>';
	exit;
}

/* ══════════════════════════════════════════════════════════════════════════
   5. ROBOTS.TXT via WordPress filter
══════════════════════════════════════════════════════════════════════════ */
add_filter( 'robots_txt', 'oria_robots_txt', 10, 2 );
function oria_robots_txt( string $output, bool $public ): string {
	// Respect the WordPress "Discourage search engines" setting.
	// When $public is false WordPress already outputs "Disallow: /" — don't override it.
	if ( ! $public ) {
		return $output;
	}

	$sitemap = home_url( '/sitemap.xml' );
	return "User-agent: *\n"
		. "Allow: /\n"
		. "Allow: /wp-content/uploads/\n"
		. "Disallow: /wp-admin/\n"
		. "Disallow: /wp-includes/\n"
		. "Disallow: /cart/\n"
		. "Disallow: /checkout/\n"
		. "Disallow: /my-account/\n"
		. "Disallow: /wp-content/plugins/\n"
		. "Disallow: /?s=\n"
		. "\n"
		. "Sitemap: {$sitemap}\n";
}

/* ══════════════════════════════════════════════════════════════════════════
   6. AUTO IMAGE ALT TEXT on upload / render
══════════════════════════════════════════════════════════════════════════ */
add_filter( 'wp_get_attachment_image_attributes', 'oria_auto_alt', 10, 2 );
function oria_auto_alt( array $attr, WP_Post $attachment ): array {
	if ( empty( $attr['alt'] ) ) {
		$title = get_the_title( $attachment->ID );
		$attr['alt'] = esc_attr( "Custom {$title} from Oria Patel Enterprises — manufactured in Sialkot, Pakistan" );
	}
	return $attr;
}

/* ══════════════════════════════════════════════════════════════════════════
   7. FLUSH REWRITE RULES when theme is activated
══════════════════════════════════════════════════════════════════════════ */
add_action( 'after_switch_theme', function() {
	oria_sitemap_rewrite();
	flush_rewrite_rules();
} );

# Oria Patel Pro — WordPress Theme

**Version:** 1.0.0
**Author:** Oria Patel Enterprises
**Website:** https://oriapatel.com
**Requires WordPress:** 6.0+
**Tested up to:** 6.5
**PHP:** 7.4+
**License:** Proprietary — All rights reserved

---

## Overview

Oria Patel Pro is a custom WordPress theme built exclusively for **Oria Patel Enterprises**, a B2B custom sports uniform manufacturer based in Sialkot, Pakistan. It is purpose-built for the `oriapatel.com` domain and is not a general-purpose theme.

The theme handles:

- A custom product catalogue (CPT `opm_product` + taxonomy `opm_category`) — no WooCommerce
- A customer reviews system (CPT `oria_review`) with frontend submission, admin approval, and star ratings
- A full blog system using WordPress's native `post` type
- SEO automation: custom title tags, Schema.org JSON-LD, XML sitemap at `/sitemap.xml`, and `robots.txt`
- A Customizer-driven design system with brand colours, business info, hero content, and social links

---

## Directory Structure

```
oria-patel-pro/
├── assets/
│   ├── css/
│   │   └── customizer.css          # Live preview styles for Customizer
│   ├── img/
│   │   ├── logo-full.png
│   │   └── logo-icon.png
│   └── js/
│       ├── main.js                 # Global JS (sticky nav, counters, etc.)
│       ├── customizer-preview.js   # Customizer live preview bindings
│       └── reviews.js              # Star picker, toggles, form validation
│
├── inc/
│   ├── customizer.php              # All Customizer panels/sections/settings
│   ├── template-functions.php      # Helper functions (op_product_card, op_breadcrumb, etc.)
│   ├── seo-functions.php           # SEO: title tags, schema, sitemap, robots.txt
│   ├── review-functions.php        # Reviews CPT, meta boxes, shortcodes
│   └── blog-functions.php          # Blog helpers: reading time, social share, related posts
│
├── template-parts/
│   └── contact-form.php            # Reusable contact/quote form partial
│
├── 404.php                         # 404 error page
├── archive.php                     # Default archive fallback
├── archive-opm_product.php         # Products archive (/products/)
├── content-blog-card.php           # Blog post card partial
├── content-review.php              # Review card partial
├── footer.php                      # Site footer
├── front-page.php                  # Homepage (static front page)
├── functions.php                   # Theme bootstrap — loads all inc/ files
├── header.php                      # Site header + nav
├── home.php                        # Blog archive (/blog/)
├── index.php                       # Fallback template
├── page.php                        # Default page template
├── page-about.php                  # About page template
├── page-contact.php                # Contact/quote page template
├── page-reviews.php                # Reviews archive page (/reviews/)
├── robots.txt                      # Static robots.txt (also enforced via WP filter)
├── screenshot.png                  # Theme screenshot (WordPress admin)
├── sidebar-blog.php                # Blog sidebar template
├── single.php                      # Single blog post template
├── single-opm_product.php          # Single product template
├── style.css                       # Main stylesheet + Theme headers
└── taxonomy-opm_category.php       # Category archive (/products/[category]/)
```

---

## Custom Post Types

### `opm_product` — Products
- **Not** registered by the theme (assumed registered by a plugin or MU plugin)
- The theme provides archive, single, and taxonomy templates for it
- Taxonomy: `opm_category`
- Meta fields used by the theme:
  - `_opm_specs` — comma-separated list of product specs (e.g. `100% Sublimation, MOQ: 1`)
  - `_opm_inquiries` — integer social proof counter shown on product cards

### `oria_review` — Customer Reviews
- Registered in `inc/review-functions.php`
- Archive slug: `/reviews/`
- Meta fields:
  - `_oria_reviewer_name` — full name
  - `_oria_reviewer_email` — email (never displayed publicly)
  - `_oria_reviewer_company` — company / team name
  - `_oria_reviewer_country` — country
  - `_oria_star_rating` — integer 1–5
  - `_oria_review_date` — ISO date of review
  - `_oria_product_reviewed` — Post ID of reviewed `opm_product`
  - `_oria_verified_purchase` — `1` or `0`
  - `_oria_reviewer_photo` — Attachment ID of reviewer photo

---

## Shortcodes

| Shortcode | Description | Attributes |
|---|---|---|
| `[oria_review_form]` | Frontend review submission form | none |
| `[oria_reviews_widget count="3"]` | Compact recent reviews list | `count` — number of reviews to show (default 3) |

---

## Widget Areas

| ID | Label | Used in |
|---|---|---|
| `footer-1` | Footer Column 1 | `footer.php` |
| `footer-2` | Footer Column 2 | `footer.php` |
| `footer-3` | Footer Column 3 | `footer.php` |
| `blog-sidebar` | Blog Sidebar | `sidebar-blog.php` |

---

## Registered Menus

| Location | Label | Used in |
|---|---|---|
| `primary` | Primary Navigation | Header |
| `footer` | Footer Navigation | Footer column |
| `footer-2` | Footer Column 2 | Footer column |

---

## Image Sizes

| Name | Width | Height | Crop | Used for |
|---|---|---|---|---|
| `op-card` | 400 | 300 | yes | Product cards |
| `op-category` | 600 | 450 | yes | Homepage category grid |
| `op-hero` | 1400 | 700 | yes | Homepage hero |
| `oria-blog-card` | 720 | 405 | yes | Blog post cards (16:9) |
| `oria-blog-hero` | 1400 | 560 | yes | Single post hero |

---

## SEO System (`inc/seo-functions.php`)

The theme manages all SEO without plugins:

- **Title tags** — custom format per page type (homepage, product, category, blog, reviews)
- **Meta description** — pulled from excerpt or auto-generated per page
- **Open Graph** — `og:title`, `og:description`, `og:image`, `og:type`, `og:url`
- **Twitter Card** — `summary_large_image`
- **Canonical URLs** — on all page types
- **Schema.org JSON-LD** — Organization, Product, BlogPosting, Review, AggregateRating, BreadcrumbList, WebSite + SearchAction
- **XML Sitemap** — served at `/sitemap.xml` via WordPress rewrite (no plugin needed)
- **robots.txt** — served via `robots_txt` WordPress filter + physical file
- **Auto alt-text** — fills missing `alt` attributes using the attachment caption or title

---

## PHP Function Reference

### `template-functions.php`
| Function | Description |
|---|---|
| `op_product_card( $args )` | Renders a product card HTML |
| `op_breadcrumb()` | Basic breadcrumb trail |
| `op_get_social_links()` | Returns array of social URLs from Customizer |

### `seo-functions.php`
| Function | Description |
|---|---|
| `oria_breadcrumb_items()` | Returns array of breadcrumb items (label, url) |
| `oria_breadcrumb_html()` | Outputs full breadcrumb HTML with BreadcrumbList schema |

### `review-functions.php`
| Function | Description |
|---|---|
| `oria_render_stars( $rating )` | Outputs HTML star icons (filled + empty) |
| `oria_get_average_rating()` | Returns float average of all approved reviews |
| `oria_get_review_count()` | Returns integer count of approved reviews |
| `oria_reviewer_initials( $name )` | Returns 1–2 letter initials for avatar fallback |

### `blog-functions.php`
| Function | Description |
|---|---|
| `oria_reading_time( $post_id )` | Returns estimated read time in minutes |
| `oria_related_posts( $post_id, $count )` | Returns WP_Query of related posts |
| `oria_social_share_buttons( $post_id )` | Outputs social share button row |
| `oria_author_bio_box( $author_id )` | Outputs author bio card |
| `oria_autolink_products( $content )` | Content filter: auto-links product name mentions |

---

## CSS Architecture

All styles live in `style.css`. The file is organised into sections:

1. **CSS Custom Properties** — all brand variables (`--op-color-*`, `--op-font-*`, `--op-radius-*`)
2. **Reset & Base**
3. **Layout utilities** (`.op-container`, `.op-section`, `.op-grid-*`)
4. **Header & Navigation**
5. **Homepage sections** (hero, value props, categories, stats, how-it-works)
6. **Products** (archive, single, category sidebar)
7. **Blog system** (cards, post layout, author box, social share)
8. **Reviews system** (grid, cards, star picker, form, widget)
9. **Footer**
10. **Responsive breakpoints**

Override individual variables in the Customizer (Brand Colours section) — the theme applies them dynamically as inline CSS on `<body>`.

---

## JavaScript

### `assets/js/main.js`
- Sticky header on scroll
- Animated number counters (Intersection Observer)
- WhatsApp floating button
- Mobile menu toggle
- Announcement bar ticker

### `assets/js/reviews.js`
- Star picker (mouse + keyboard accessible)
- Read-more / read-less toggles on review cards
- Form validation (star rating required before submit)
- Sort select redirect

### `assets/js/customizer-preview.js`
- Binds Customizer live preview for colours, text, and toggle settings

---

## Hooks & Filters

The theme exposes no custom hooks intentionally — all extension points are through standard WordPress hooks. Key hooks used internally:

| Hook | File | Purpose |
|---|---|---|
| `after_setup_theme` | functions.php | Theme support, menus, image sizes |
| `wp_enqueue_scripts` | functions.php | Enqueue CSS/JS |
| `widgets_init` | functions.php | Register widget areas |
| `init` | review-functions.php | Register `oria_review` CPT |
| `add_meta_boxes` | review-functions.php | Review admin meta box |
| `save_post_oria_review` | review-functions.php | Save review meta |
| `admin_post_oria_submit_review` | review-functions.php | Handle public form POST |
| `wp_head` | seo-functions.php | Output all SEO meta + JSON-LD |
| `pre_get_document_title` | seo-functions.php | Custom title tags |
| `template_redirect` | seo-functions.php | Serve `/sitemap.xml` |
| `robots_txt` | seo-functions.php | Append sitemap to robots.txt |
| `the_content` | blog-functions.php | `oria_autolink_products` filter |
| `customize_register` | inc/customizer.php | All Customizer settings |
| `customize_preview_init` | inc/customizer.php | Enqueue preview JS |

---

## Installation

1. Download `oria-patel-pro.zip`
2. In WordPress admin: **Appearance → Themes → Add New → Upload Theme**
3. Select the zip file, click **Install Now**, then **Activate**
4. Go to **Settings → Permalinks** → click **Save Changes** (flushes rewrite rules for `/sitemap.xml`)
5. Go to **Settings → Reading** → set **Posts page** to a page called "Blog"
6. Go to **Appearance → Menus** → assign menus to **Primary Navigation** and **Footer Navigation**
7. Go to **Appearance → Customize** → fill in Business Info, Brand Colours, and Homepage sections

---

## Requirements

| Requirement | Minimum |
|---|---|
| WordPress | 6.0 |
| PHP | 7.4 |
| MySQL | 5.7 |
| HTTPS | Required (share buttons + schema) |
| `opm_product` CPT + `opm_category` taxonomy | Must be registered (plugin or MU plugin) |

---

## Changelog

### 1.0.0
- Initial release
- Custom product archive with hierarchical category sidebar
- Reviews CPT with frontend submission, honeypot protection, admin approval flow
- Full blog system (archive, single, sidebar, related posts, social share, author bio)
- SEO system: XML sitemap, robots.txt, Schema.org, OG tags, canonical URLs
- Taxonomy template for category archives
- Blog sidebar widget area

---

## Support

For theme-related issues, contact the developer or open a ticket in the internal project tracker. Do not modify `style.css` variables directly — use the Customizer Brand Colours section instead so changes survive theme updates.

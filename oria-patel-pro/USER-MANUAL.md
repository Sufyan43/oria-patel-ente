# Oria Patel Pro — Complete User Manual

**Version:** 1.0.0 | For: oriapatel.com WordPress Admin
**Last Updated:** 2026-07-21

This manual covers every setting in the theme — what it does, where to find it, what to type, and what will break if you do it wrong. Follow each section in order the first time you set up the site. After setup, use the Table of Contents to jump to the section you need.

---

## Table of Contents

1. [First-Time Setup Checklist](#1-first-time-setup-checklist)
2. [Customizer — Business Info](#2-customizer--business-info)
3. [Customizer — Social Media Links](#3-customizer--social-media-links)
4. [Customizer — Brand Colours](#4-customizer--brand-colours)
5. [Customizer — Announcement Bar](#5-customizer--announcement-bar)
6. [Customizer — Homepage Hero](#6-customizer--homepage-hero)
7. [Customizer — Why Choose Us Tiles](#7-customizer--why-choose-us-tiles)
8. [Customizer — Sport Category Cards](#8-customizer--sport-category-cards)
9. [Customizer — Achievement Numbers](#9-customizer--achievement-numbers)
10. [Customizer — How It Works Steps](#10-customizer--how-it-works-steps)
11. [Customizer — Footer Settings](#11-customizer--footer-settings)
12. [Customizer — Quote Form Settings](#12-customizer--quote-form-settings)
13. [Customizer — Section Labels](#13-customizer--section-labels)
14. [Customizer — WhatsApp Floating Button](#14-customizer--whatsapp-floating-button)
15. [Customizer — SEO & Analytics](#15-customizer--seo--analytics)
16. [Menus — Primary Navigation](#16-menus--primary-navigation)
17. [Menus — Footer Navigation](#17-menus--footer-navigation)
18. [Widget Areas — Blog Sidebar](#18-widget-areas--blog-sidebar)
19. [Widget Areas — Footer Columns](#19-widget-areas--footer-columns)
20. [Products — Adding / Editing Products](#20-products--adding--editing-products)
21. [Products — Managing Categories](#21-products--managing-categories)
22. [Reviews — Approving / Rejecting Submissions](#22-reviews--approving--rejecting-submissions)
23. [Reviews — Adding a Review Manually](#23-reviews--adding-a-review-manually)
24. [Reviews — Placing the Form on a Page](#24-reviews--placing-the-form-on-a-page)
25. [Blog — Writing and Publishing Posts](#25-blog--writing-and-publishing-posts)
26. [Blog — Setting Up the Blog Page](#26-blog--setting-up-the-blog-page)
27. [SEO — Sitemap and Robots.txt](#27-seo--sitemap-and-robotstxt)
28. [SEO — Per-Page Settings](#28-seo--per-page-settings)
29. [Page Templates](#29-page-templates)
30. [Troubleshooting Common Errors](#30-troubleshooting-common-errors)

---

## 1. First-Time Setup Checklist

Complete these steps immediately after activating the theme. **Skip any one of them and something will be broken.**

| # | Step | Where |
|---|---|---|
| 1 | Activate the theme | Appearance → Themes |
| 2 | Flush permalinks | Settings → Permalinks → Save Changes |
| 3 | Create a **Blog** page (leave content blank) | Pages → Add New |
| 4 | Create a **Reviews** page (leave content blank, select "Reviews" template) | Pages → Add New |
| 5 | Create a **Contact** page (leave content blank, select "Contact Page" template) | Pages → Add New |
| 6 | Create an **About** page (leave content blank, select "About Page" template) | Pages → Add New |
| 7 | Set static front page | Settings → Reading → set "Your homepage displays" to "A static page" → Homepage = your homepage, Posts page = Blog |
| 8 | Assign the Primary menu | Appearance → Menus |
| 9 | Open Customizer and fill Business Info | Appearance → Customize |
| 10 | Open Customizer and fill Homepage Hero | Appearance → Customize |
| 11 | Flush permalinks again after all settings are saved | Settings → Permalinks → Save Changes |

> ⚠️ **Step 2 and 11 are mandatory.** Without flushing permalinks, `/sitemap.xml` and `/reviews/` will return 404 errors.

---

## 2. Customizer — Business Info

**Path:** Appearance → Customize → Your Website Settings → 🏢 Your Business Info

These values appear in the footer, the contact page, and in the Schema.org Organization markup (read by Google).

---

### `Business Email`
- **What it does:** Shown in the footer contact block and used as the `email` property in Organization schema. Also receives a copy of every new review submission notification.
- **What to enter:** A valid email address. Example: `info@oriapatel.com`
- **Character limit:** No hard limit, but keep it under 100 characters.
- **Common error:** Entering a name instead of an email here breaks the Organization schema. Google Search Console may flag a validation error.

---

### `Phone / WhatsApp Number`
- **What it does:** Displayed in the footer and in the header contact strip. Also used to pre-fill the WhatsApp floating button number (see Section 14).
- **What to enter:** Include the full international dialling code without spaces or dashes. Example: `+923001234567`
- **Common error:** Using spaces or dashes (e.g. `+92 300 123 4567`) will break the WhatsApp click-to-chat URL. Always use the format `+[countrycode][number]` with no spaces.

---

### `Business Address`
- **What it does:** Shown in the footer and used in Organization schema (`address` field).
- **What to enter:** Full mailing address on one line. Example: `123 Sports Avenue, Sialkot, Punjab 51310, Pakistan`
- **Common error:** Using HTML tags here (like `<br>`) will show raw HTML to visitors. Keep it plain text.

---

### `Business Hours`
- **What it does:** Displayed in the footer below the address.
- **What to enter:** Plain text. Example: `Mon – Sat: 9 AM – 6 PM (PKT)`
- **Common error:** None — this is display-only text.

---

## 3. Customizer — Social Media Links

**Path:** Appearance → Customize → Your Website Settings → 📱 Social Media Links

These links appear in the footer social icons row.

> ⚠️ **All fields must be full URLs.** Do not enter a username, handle, or partial path.

---

### `WhatsApp Link` (`op_social_whatsapp`)
- **What to enter:** `https://wa.me/923001234567` (replace with your number — no `+`, no spaces, no dashes after `wa.me/`)
- **Common error:** Entering `+92300...` instead of `923001...` — the `+` sign breaks the URL.

---

### `Facebook Page URL` (`op_social_facebook`)
- **What to enter:** `https://www.facebook.com/YourPageName`
- **Common error:** Entering the short username without the full URL.

---

### `Instagram Profile URL` (`op_social_instagram`)
- **What to enter:** `https://www.instagram.com/yourusername`
- **Common error:** Adding a trailing slash inconsistently — either format works, but be consistent.

---

### `LinkedIn Page URL` (`op_social_linkedin`)
- **What to enter:** `https://www.linkedin.com/company/oria-patel-enterprises`
- **Common error:** Using a personal profile URL instead of the company page URL.

---

## 4. Customizer — Brand Colours

**Path:** Appearance → Customize → Your Website Settings → 🎨 Brand Colours

These four colours control the entire site's visual identity. They are applied as CSS custom properties on `<body>` and cascade to every element.

> ⚠️ **Always use the colour picker.** Do not type hex values manually unless you are certain of the exact code. A wrong hex will silently apply an unintended colour everywhere.

---

### `Primary Colour` (`op_color_primary`)
- **What it controls:** Main headings, the header background, dark section backgrounds, button backgrounds, sidebar active state, and the footer background.
- **Default:** `#0F1111` (near-black)
- **How to change:** Click the colour swatch → use the picker or enter a hex code → press Enter → click Publish.
- **Common error:** Setting this to a very light colour makes the white text in the header invisible. If the header looks broken after changing this, switch to a colour with contrast ratio ≥ 4.5:1 against white.

---

### `Accent / CTA Colour` (`op_color_accent`)
- **What it controls:** All primary call-to-action buttons ("Get a Quote", "Request Sample"), badge backgrounds, hover highlights, and the announcement bar background.
- **Default:** `#F3A847` (amber)
- **How to change:** Same as Primary Colour.
- **Common error:** Setting this to white or near-white makes buttons invisible. The text on accent buttons is dark (`#0F1111`), so the accent colour needs strong contrast against dark text.

---

### `Link Colour` (`op_color_link`)
- **What it controls:** All hyperlinks, filter buttons, sidebar category links, and blog card "Read More" links.
- **Default:** `#2162A1` (blue)
- **How to change:** Same as above.
- **Common error:** Setting this to a colour that blends with body text makes links invisible and kills usability.

---

### `Muted Text Colour` (`op_color_muted`)
- **What it controls:** Secondary text — post dates, reading times, product spec tags, form helper text, footer secondary lines.
- **Default:** `#555F6E` (medium grey)
- **How to change:** Same as above.
- **Common error:** Setting this too light (e.g. `#CCCCCC`) fails WCAG accessibility contrast on white backgrounds. Keep it at least `#767676` or darker.

---

## 5. Customizer — Announcement Bar

**Path:** Appearance → Customize → Your Website Settings → 📢 Announcement Bar

The announcement bar is a scrolling ticker that appears above the header.

---

### `Show Announcement Bar` (`op_topbar_show`)
- **What it does:** Toggles the entire bar on or off.
- **Options:** Toggle (on/off)
- **When to turn off:** During major site updates or if the bar text is outdated. Turning it off also removes it from the page layout calculation, so the header position shifts slightly — check mobile layout after toggling.

---

### `Ticker Item 1–4` (`op_topbar_item_1` to `op_topbar_item_4`)
- **What it does:** Four separate text strings that scroll across the bar in a loop.
- **What to enter:** Short, punchy phrases. Examples:
  - `🏆 Trusted by 500+ clubs worldwide`
  - `✈️ Free DHL shipping on orders over $500`
  - `⚡ Zero MOQ — order as few as 1 piece`
  - `📞 24/7 WhatsApp support`
- **Character limit:** Keep each item under 80 characters for readability on mobile.
- **Common error:** Leaving an item blank does not remove it from the ticker — it creates an empty gap. Either fill all four or keep them consistent.

---

## 6. Customizer — Homepage Hero

**Path:** Appearance → Customize → Your Website Settings → 🦸 Homepage Hero

The hero is the large banner at the top of the homepage.

---

### `Badge Text` (`op_hero_badge`)
- **What it does:** Small pill-shaped label above the main heading. Example: `🏆 Pakistan's #1 Sports Uniform Manufacturer`
- **What to enter:** Short trust signal or tagline, ideally under 60 characters.

---

### `Main Heading` (`op_hero_title`)
- **What it does:** The H1 of the homepage. This is the most important SEO text on the site.
- **What to enter:** Your primary keyword headline. Example: `Custom Sports Uniforms`
- **Common error:** Making this too long. Google truncates title tags around 60 characters, and long headings look broken on mobile.

---

### `Accent Word` (`op_hero_accent_word`)
- **What it does:** One word (or short phrase) that appears highlighted in the accent colour inside the main heading. The theme automatically finds and wraps this word in a `<span>`.
- **What to enter:** Must be a word that also appears in the Main Heading field. Example: if Heading is `Custom Sports Uniforms`, set Accent Word to `Sports`.
- **Common error:** If the accent word does not exactly match a word in the heading (case-sensitive), nothing gets highlighted and no error is shown. Double-check spelling.

---

### `Hero Description` (`op_hero_desc`)
- **What it does:** The paragraph of text below the heading.
- **What to enter:** 1–2 sentences, 120–180 characters. Example: `Sublimation-printed, fully custom uniforms for football, cricket, basketball, and more. Zero MOQ — ship worldwide in 15 days.`

---

### `CTA Button 1 — Text` (`op_hero_cta1_text`) and `URL` (`op_hero_cta1_url`)
- **What it does:** Primary button (filled, accent colour).
- **Text example:** `Get a Free Quote`
- **URL example:** `/contact/`
- **Common error:** Entering a relative URL without the leading `/` (e.g. `contact/` instead of `/contact/`) may work on the homepage but break on other pages.

---

### `CTA Button 2 — Text` (`op_hero_cta2_text`) and `URL` (`op_hero_cta2_url`)
- **What it does:** Secondary button (outline style).
- **Text example:** `View Products`
- **URL example:** `/products/`

---

### `Hero Background Image` (`op_hero_image`)
- **What it does:** Full-bleed background photo behind the hero text. A dark overlay is applied automatically for text legibility.
- **What to upload:** Minimum 1400 × 700 pixels, JPG or WebP, under 500 KB after compression.
- **Common error:** Uploading a small image (e.g. 600px wide) causes it to look blurry or pixelated on large screens. Always use an image at least 1400px wide.

---

## 7. Customizer — Why Choose Us Tiles

**Path:** Appearance → Customize → Your Website Settings → ✅ "Why Choose Us" Tiles

Four tiles that appear in the value proposition grid below the hero.

### Settings per tile (repeat for tiles 1–4):

| Setting | Key | What to enter |
|---|---|---|
| Icon | `op_prop_1_icon` | A single emoji. Example: `🎯` |
| Title | `op_prop_1_title` | Short heading, max 40 chars. Example: `Zero Minimum Order` |
| Description | `op_prop_1_desc` | 1–2 sentences. Example: `Order 1 piece or 10,000 — same quality, same price per unit.` |

- **Common error:** Using multiple emojis in the icon field — only one emoji renders cleanly in the circle icon container.

---

## 8. Customizer — Sport Category Cards

**Path:** Appearance → Customize → Your Website Settings → 🏈 Sport Category Cards

Eight image cards that link to sport-specific product categories on the homepage.

### Settings per card (repeat for cards 1–8):

| Setting | Key | What to enter |
|---|---|---|
| Label | `op_cat_1_label` | Sport name. Example: `Football` |
| URL | `op_cat_1_url` | Full path to category. Example: `/products/football/` |
| Image | `op_cat_1_image` | Media library image (600 × 450 px recommended) |

- **Common error — URL:** Entering a URL that does not exist will show the card but clicking it gives a 404. Always verify the category slug exists under `/products/` first.
- **Common error — Image:** Leaving the image blank will show a grey placeholder. Upload sport-specific product photos for best conversion.

---

## 9. Customizer — Achievement Numbers

**Path:** Appearance → Customize → Your Website Settings → 🏆 Achievement Numbers

Four animated counters that count up when the section scrolls into view.

### Settings per stat (repeat for stats 1–4):

| Setting | Key | What to enter |
|---|---|---|
| Icon | `op_stat_1_icon` | Single emoji. Example: `🌍` |
| Value | `op_stat_1_value` | Number string. Example: `500+` or `15` |
| Label | `op_stat_1_label` | Description. Example: `Countries Served` |

- **Common error — Value format:** The counter animation only works with plain numbers (e.g. `500`). The `+` suffix is fine — the JS strips it before animating, then adds it back. Do **not** use commas (e.g. `1,000` will cause the counter to show `0`). Use `1000` or `1000+` instead.

---

## 10. Customizer — How It Works Steps

**Path:** Appearance → Customize → Your Website Settings → 📋 How It Works

Three steps shown in the process section of the homepage.

### Settings per step (repeat for steps 1–3):

| Setting | Key | What to enter |
|---|---|---|
| Title | `op_step_1_title` | Short step name. Example: `Share Your Design` |
| Description | `op_step_1_desc` | 1–2 sentences. Example: `Send us your logo, colours, and any reference image. We'll create a free mockup within 24 hours.` |

- **Common error:** Leaving a title blank collapses that step card entirely, making the 3-step section look uneven.

---

## 11. Customizer — Footer Settings

**Path:** Appearance → Customize → Your Website Settings → 🔻 Footer

---

### `Footer Tagline` (`op_footer_tagline`)
- **What it does:** Line of text shown under the logo in the footer.
- **Example:** `Premium custom sports uniforms, proudly made in Sialkot, Pakistan.`
- **Character limit:** Keep under 120 characters.

---

### `Copyright Notice` (`op_footer_copyright`)
- **What it does:** Small text in the very bottom bar.
- **Example:** `© 2024 Oria Patel Enterprises. All rights reserved.`
- **Common error:** The year does not update automatically. Update this every January.

---

## 12. Customizer — Quote Form Settings

**Path:** Appearance → Customize → Your Website Settings → 📬 Quote Form Settings

---

### `Success Message` (`op_form_success_message`)
- **What it does:** Text shown to the user after they submit the contact/quote form successfully.
- **Example:** `Thank you! We've received your request and will reply within 24 hours.`

---

### `Reply Time Promise` (`op_form_reply_time`)
- **What it does:** Short text shown inside the form to set expectations.
- **Example:** `We reply within 24 hours on business days.`

---

## 13. Customizer — Section Labels

**Path:** Appearance → Customize → Your Website Settings → 🏷️ Homepage Section Labels

These control the heading text for each section on the homepage. Change them if you want different wording without editing template files.

| Setting | Default | Controls |
|---|---|---|
| Products Section Label | `Our Products` | Heading above the products grid on the homepage |
| Categories Section Label | `Shop by Sport` | Heading above the category cards |
| Stats Section Label | `Our Numbers` | Heading above the achievement counters |
| Process Section Label | `How It Works` | Heading above the 3-step process |
| Reviews Section Label | `What Clients Say` | Heading above any reviews widget on homepage |

- **Common error:** Setting a label to all caps — CSS already applies `text-transform: uppercase` to section sub-labels in some areas, so double-upper-casing creates inconsistent styling.

---

## 14. Customizer — WhatsApp Floating Button

**Path:** Appearance → Customize → Your Website Settings → 💬 WhatsApp Floating Button

The green WhatsApp button that floats in the bottom-right corner of every page.

---

### `Show WhatsApp Button` (`op_whatsapp_bubble_show`)
- **Options:** Toggle on/off
- **When to turn off:** If the business is closed for an extended period and you do not want to receive WhatsApp enquiries.

---

### `WhatsApp Number` (`op_whatsapp_bubble_number`)
- **What to enter:** International format without `+` sign or spaces. Example: `923001234567`
- **Common error:** Including the `+` sign breaks the `wa.me/` URL. The format must be country code followed by number, no spaces, no `+`.

---

### `Pre-filled Message` (`op_whatsapp_bubble_message`)
- **What it does:** Text that pre-populates in WhatsApp when a visitor clicks the button.
- **Example:** `Hello! I'm interested in custom sports uniforms. Can you help?`
- **Common error:** Using special characters like `&` or `#` in the message — these must be URL-encoded by the theme. The theme handles standard text automatically, but complex formatting may not display correctly.

---

## 15. Customizer — SEO & Analytics

**Path:** Appearance → Customize → Your Website Settings → 🔍 SEO & Search Overrides

---

### `Homepage SEO Title` (`op_seo_home_title`)
- **What it does:** The `<title>` tag used for the homepage. This is what Google shows as the blue link in search results.
- **What to enter:** 50–60 characters. Include your primary keyword and brand name. Example: `Custom Sports Uniforms | Oria Patel Enterprises — Sialkot`
- **Common error:** Going over 60 characters — Google will truncate it and may rewrite it.

---

### `Homepage Meta Description` (`op_seo_home_desc`)
- **What it does:** The description snippet shown under the title in Google results.
- **What to enter:** 120–155 characters. Include your main keyword naturally. Example: `Premium custom sports uniforms made in Sialkot. Sublimation printing, zero MOQ, worldwide delivery. Get a free mockup in 24 hours.`
- **Common error:** Going over 155 characters — Google will cut it off mid-sentence.

---

### `Google Analytics 4 ID` (`op_seo_google_code`)
- **What it does:** Adds the GA4 tracking script to every page.
- **What to enter:** Your GA4 Measurement ID, which starts with `G-`. Example: `G-XXXXXXXXXX`
- **Common error:** Entering the old Universal Analytics ID (starts with `UA-`) — this format is deprecated and will not track any data.
- **Where to find it:** Google Analytics → Admin → Data Streams → your stream → Measurement ID

---

## 16. Menus — Primary Navigation

**Path:** Appearance → Menus → select "Primary Navigation" from the dropdown

The primary menu appears in the sticky header on every page.

### How to add a link:
1. On the left panel, expand **Pages**, **Posts**, **Custom Links**, or **Categories**
2. Check the item(s) you want to add
3. Click **Add to Menu**
4. Drag items to reorder them
5. Drag items slightly to the right to create a sub-menu (dropdown)
6. Click **Save Menu**

### Recommended menu structure:
```
Home
Products
  └── Football Uniforms
  └── Cricket Uniforms
  └── Basketball Uniforms
  └── All Products
Blog
Reviews
About
Contact
```

### Common errors:
- **Dropdown not appearing:** The item must be indented exactly one level in the menu builder. If it's at the same level as the parent, it shows as a top-level item.
- **Custom link with relative URL:** Always use the full URL including `https://oriapatel.com/` or just `/page-slug/`. Relative URLs without a leading `/` break on sub-pages.
- **Menu not showing on site:** Make sure "Primary Navigation" is selected under **Menu Settings → Display location** at the bottom of the menu editor.

---

## 17. Menus — Footer Navigation

**Path:** Appearance → Menus → create or select "Footer Navigation"

Appears in the first column of the footer.

- Assign location: check **Footer Navigation** under Menu Settings → Display location
- Keep this menu to 5–8 links maximum for readability
- Common links to include: Home, Products, Blog, Reviews, About, Contact, Privacy Policy, Terms

A second footer menu (**Footer Column 2**) can be assigned separately for a second column of links.

---

## 18. Widget Areas — Blog Sidebar

**Path:** Appearance → Widgets → Blog Sidebar

The blog sidebar appears on the right side of the blog archive (`/blog/`) and on single posts.

### Adding a widget:
1. Click **Blog Sidebar** to expand it
2. Click the **+** icon to add a widget
3. Search for the widget type (Search, Recent Posts, Categories, Tag Cloud, etc.)
4. Configure the widget options
5. Click **Update**

### Recommended widget order:
1. **Search** — lets visitors search blog posts
2. **Recent Posts** — shows 5 latest posts with dates
3. **Categories** — shows blog categories with post counts
4. **Tag Cloud** — visual tag list
5. **Custom HTML** — for a "Get a Quote" CTA button

> **If the widget area is empty:** The theme automatically displays hardcoded fallback widgets (Search, Recent Posts, Categories, Tags, and a CTA). Once you add even one widget here, the fallback disappears and only your widgets show.

---

## 19. Widget Areas — Footer Columns

**Path:** Appearance → Widgets

Three footer widget areas: **Footer Column 1**, **Footer Column 2**, **Footer Column 3**.

### Recommended content per column:

**Footer Column 1** — About blurb + social links
- Use a **Text** or **Custom HTML** widget
- Example: company description and social icon links

**Footer Column 2** — Quick links
- Use a **Navigation Menu** widget pointing to the Footer Menu
- Or use a **Custom HTML** widget for custom links

**Footer Column 3** — Contact details
- Use a **Custom HTML** widget
- Include phone, email, address, WhatsApp link

> **Note:** The footer also displays the Customizer values (email, phone, address) in a dedicated block above these widget columns. The widget areas are for supplementary content.

---

## 20. Products — Adding / Editing Products

**Path:** Products → Add New  *(or the CPT name registered by your plugin)*

---

### Product Title
- This becomes the H1 on the product page and the product card title in the archive.
- Use the full product name with the sport type. Example: `Custom Sublimation Football Jerseys`
- Keep it under 60 characters for clean card display.

---

### Product Description (main editor)
- Full description of the product. Used in the body of the single product page.
- Include: fabric specs, customisation options, available sizes, MOQ, turnaround time.

---

### Featured Image
- Used in the product card (resized to 400 × 300 px) and on the single product page.
- **Recommended size:** 800 × 600 px minimum, JPG or WebP.
- **Common error:** Uploading a square image — the theme crops to 4:3. Upload a 4:3 image to avoid unintended cropping.

---

### Product Specs Meta Field (`_opm_specs`)
- **Where to find:** Below the main editor — look for the "Product Specs" meta box.
- **What to enter:** Comma-separated list of feature bullets. Example: `100% Polyester Sublimation, Custom Name & Number, Anti-Odour Fabric, MOQ: 1, Ships in 15 days`
- These appear as small tag pills on the product card in the archive.
- **Common error:** Using semicolons instead of commas — only commas are used as separators.
- **Common error:** More than 5–6 specs will overflow the card. Keep it to the 4 most important.

---

### Product Inquiries Count (`_opm_inquiries`)
- **Where to find:** In the meta box below the editor.
- **What to enter:** A number representing social proof. Example: `47`
- Displays as "47 enquiries this month" on the product card.
- **Common error:** Leaving this blank shows nothing (not an error, just no social proof).

---

### Assigning a Category
- On the right panel: **Product Categories**
- Check one or more categories from the list, or click **Add New Category**
- The product appears in the category sidebar filter automatically

---

## 21. Products — Managing Categories

**Path:** Products → Product Categories  *(taxonomy `opm_category`)*

---

### Adding a new category:
1. Enter the **Name** (e.g. `Cricket Uniforms`)
2. The **Slug** auto-fills (e.g. `cricket-uniforms`) — this becomes the URL (`/products/cricket-uniforms/`)
3. Select a **Parent Category** if this is a sub-category (e.g. parent: `Team Sports`)
4. Add a **Description** — this appears as the subtitle on the category archive page
5. Click **Add New Category**

---

### Category hierarchy in the sidebar:
- **Parent categories** appear in **bold** in the left sidebar on the products page
- **Child categories** appear indented with a left border below their parent
- The hierarchy is automatic — just set the Parent correctly when creating the category

---

### Common errors:
- **Slug already exists:** WordPress will append `-2` to the slug. Delete the duplicate category instead.
- **Category not appearing in sidebar:** The category must have at least one published product assigned to it. Empty categories are hidden (`hide_empty: true`).
- **Wrong slug in URL:** The slug is set when the category is first created. Changing the Name does not change the slug. Edit the slug field manually if needed, then flush permalinks (Settings → Permalinks → Save Changes).

---

## 22. Reviews — Approving / Rejecting Submissions

**Path:** Reviews → All Reviews

When a visitor submits a review through the frontend form, it is saved with **Pending** status and does **not** appear on the public reviews page until approved.

### To approve a review:
1. Go to **Reviews → All Reviews**
2. Hover over a pending review
3. Click **Quick Edit** or click the review title to open it
4. Change **Status** from **Pending Review** to **Published**
5. Click **Update**

### To reject/delete a review:
1. Hover over the review
2. Click **Trash**

### Bulk approve:
1. Check the boxes next to multiple reviews
2. In the **Bulk Actions** dropdown, select **Edit**
3. Click **Apply**
4. Set **Status** to **Published**
5. Click **Update**

### Checking review quality:
Each review shows:
- Star rating (1–5)
- Reviewer name and company
- Country
- Product reviewed
- Whether they marked "Verified Purchase"
- Review text

> **Spam protection:** The frontend form uses a honeypot field. Most bot submissions are caught automatically. If spam slips through, the **Pending** status ensures it never goes live.

---

## 23. Reviews — Adding a Review Manually

**Path:** Reviews → Add New

Use this to add reviews collected offline, by phone, or via email.

1. **Title:** Short summary of the review. Example: `Great quality football kits!`
2. **Content (editor):** The full review text in the customer's words.
3. **Review Details meta box** (below the editor):

| Field | What to enter |
|---|---|
| Reviewer Name | Full name. Example: `James Whitfield` |
| Reviewer Email | Their email (not shown publicly) |
| Company / Team Name | Example: `West London FC` |
| Country | Example: `United Kingdom` |
| Star Rating | Number 1–5 |
| Review Date | Date they gave the review (YYYY-MM-DD) |
| Product Reviewed | Select from dropdown |
| Verified Purchase | Check if they actually ordered |
| Reviewer Photo | Upload from media library (optional) |

4. Set **Status** to **Published** (since you're adding it yourself, no approval needed)
5. Click **Publish**

---

## 24. Reviews — Placing the Form on a Page

The review submission form is a shortcode. Place it on any page.

### On the Reviews page:
The `page-reviews.php` template already includes the form automatically — you don't need the shortcode.

### On any other page:
1. Create or edit a page
2. Add a **Shortcode** block
3. Enter: `[oria_review_form]`
4. Publish

### Showing a reviews summary widget (e.g. in a sidebar):
Add a **Shortcode** block with: `[oria_reviews_widget count="3"]`

Change `count="3"` to any number (e.g. `count="5"`) to show more reviews.

---

## 25. Blog — Writing and Publishing Posts

**Path:** Posts → Add New

---

### Post Title
- This becomes the H1 and the `<title>` tag (formatted as `Post Title | Oria Patel Enterprises`)
- Use the target keyword naturally at the start. Example: `How to Choose Custom Football Jerseys for Your Club`
- Keep under 60 characters for clean display.

---

### Post Content
- Write in the block editor normally.
- Use **Heading 2** (H2) for main sections and **Heading 3** (H3) for subsections — never use H1 (it's already the title).
- The theme auto-links product names in your content. For example, if you write "custom football jerseys" and a product page has that name, it automatically links to it.

---

### Featured Image
- Used as the 16:9 card thumbnail (720 × 405 px) and the full-width hero on the single post (1400 × 560 px).
- **Recommended size:** 1400 × 560 px, JPG or WebP, under 400 KB.
- **Common error:** Uploading a portrait (tall) image — the theme crops to landscape. Use a wide image.

---

### Excerpt
- If you fill in the **Excerpt** field (below the editor — click the ⚙️ icon → Excerpt), it shows on the blog card.
- If you leave it blank, WordPress auto-generates one from the first ~55 words.
- **Recommended:** Write a custom excerpt of 80–120 characters that describes the post's value.

---

### Categories (blog)
- WordPress **Categories** (not product categories) — assign one per post.
- Examples: `Manufacturing Tips`, `Industry News`, `How-To Guides`, `Customer Stories`
- The category badge appears on the blog card.

---

### Tags
- Add 3–5 relevant tags per post. Example: `football, sublimation, custom kits`
- Tags appear at the bottom of single posts and in the blog sidebar tag cloud.

---

### Author
- Blog posts show the author's name, avatar, and bio in the Author Bio Box at the bottom.
- To edit the author bio: **Users → Your Profile → Biographical Info**
- To add an author avatar: Use a Gravatar account (gravatar.com) for the email linked to the WordPress user.

---

### Scheduling a post:
1. In the right panel under **Publish**, click **Immediately** next to "Publish"
2. Set the date and time
3. Click **Schedule**

---

## 26. Blog — Setting Up the Blog Page

The blog uses WordPress's native Posts system. The blog archive appears at `/blog/`.

### First-time setup:
1. Create a page called **Blog** (leave the content completely empty)
2. Go to **Settings → Reading**
3. Under "Your homepage displays", select **A static page**
4. Set **Homepage** to your homepage page
5. Set **Posts page** to the **Blog** page you just created
6. Click **Save Changes**
7. Go to **Settings → Permalinks → Save Changes** (flush rewrite rules)

The blog archive now appears at `/blog/`.

### Changing posts per page:
- **Settings → Reading → Blog pages show at most:** — set to `9` (the theme shows a 3-column grid, so multiples of 3 look best)

### Common errors:
- **Blog page shows "Page not found":** Flush permalinks (Settings → Permalinks → Save Changes).
- **Blog page shows the page editor content:** The page content must be blank. Any content in the Blog page editor overrides the blog archive template.
- **Blog shows as a list not a grid:** Make sure the page is set as the "Posts page" in Settings → Reading, not just a regular page with the blog URL.

---

## 27. SEO — Sitemap and Robots.txt

### Sitemap at `/sitemap.xml`

The theme generates the sitemap automatically. It includes:
- Homepage
- All published `opm_product` posts
- All `opm_category` taxonomy terms (with products)
- All published blog posts
- All published `oria_review` posts
- Key static pages (About, Contact, Reviews)

**To verify it's working:** Visit `https://oriapatel.com/sitemap.xml` in your browser. You should see an XML file.

**If it shows 404:**
1. Go to **Settings → Permalinks**
2. Click **Save Changes** (do not change anything — just click Save)
3. Visit the sitemap URL again

**Submitting to Google:**
1. Go to Google Search Console
2. Select your property
3. Click **Sitemaps** in the left menu
4. Enter `sitemap.xml` in the URL field
5. Click **Submit**

---

### Robots.txt

The theme serves `robots.txt` at `https://oriapatel.com/robots.txt` automatically via the WordPress `robots_txt` filter. A physical `robots.txt` file is also included in the theme root as a fallback.

**Default content:**
```
User-agent: *
Allow: /
Disallow: /wp-admin/
Disallow: /wp-includes/
Disallow: /wp-content/plugins/
Disallow: /?s=
Sitemap: https://oriapatel.com/sitemap.xml
```

**To customise robots.txt:**
- Do **not** edit the physical `robots.txt` file in the theme — it may be overwritten on theme updates.
- Instead, add a custom filter in a plugin or `functions.php`:
  ```php
  add_filter( 'robots_txt', function( $output ) {
      $output .= "Disallow: /my-private-page/\n";
      return $output;
  });
  ```

**Common error:** If your hosting provider has a physical `robots.txt` file at the server root (not inside WordPress), it will override the WordPress-generated one. Check your hosting file manager and delete any root-level `robots.txt` that is not managed by WordPress.

---

## 28. SEO — Per-Page Settings

The theme sets titles, meta descriptions, and schema automatically. Here is what it sets per page type and how to control each:

| Page type | Title format | Description source |
|---|---|---|
| Homepage | Customizer → SEO → Homepage SEO Title | Customizer → SEO → Homepage Meta Description |
| Product single | `[Product Name] \| Custom Sports Uniforms \| Oria Patel` | First 155 chars of product excerpt |
| Category archive | `[Category Name] Uniforms \| Oria Patel Enterprises` | Category description field |
| Blog post | `[Post Title] \| Oria Patel Enterprises` | Post excerpt |
| Reviews page | `Customer Reviews \| Oria Patel Enterprises` | Auto-generated with star count |
| Page | `[Page Title] \| Oria Patel Enterprises` | Page excerpt |

### To improve a product's meta description:
1. Open the product
2. Click the **Excerpt** panel (or find the Excerpt field below the editor)
3. Write a 120–155 character description with your keyword
4. Update

### To improve a category page's meta description:
1. Go to **Products → Product Categories**
2. Click **Edit** on the category
3. Fill in the **Description** field
4. Click **Update**

---

## 29. Page Templates

The theme includes four special page templates. Assign them when creating or editing a page.

**How to assign a template:**
1. Open the page in the editor
2. In the right panel, find **Page Attributes** → **Template**
3. Select the template from the dropdown
4. Update/Publish

| Template name | When to use | Slug recommendation |
|---|---|---|
| **Default Template** | Standard content pages | — |
| **About Page** | The company about page | `about` |
| **Contact Page** | The quote/contact form page | `contact` |
| **Reviews** | The customer reviews archive | `reviews` |

### About Page template:
- Automatically displays team info, company story, certifications, and a factory section.
- Edit the content by modifying `page-about.php` directly (requires developer access).

### Contact Page template:
- Displays the contact/quote form pulled from `template-parts/contact-form.php`.
- Form submissions go to the email set in Customizer → Business Info → Business Email.

### Reviews template:
- Displays the full reviews archive with star filter, sort, and submission form.
- **Do not** put any content in the page editor — it is ignored by this template.

---

## 30. Troubleshooting Common Errors

---

### "The sitemap returns a 404 error"
**Cause:** WordPress rewrite rules have not been flushed.
**Fix:** Settings → Permalinks → Save Changes. Visit `/sitemap.xml` again.

---

### "The blog page shows a blank page or wrong content"
**Cause:** The Blog page has content in the editor, or it has not been set as the Posts page.
**Fix:** 
1. Edit the Blog page and remove all content from the editor.
2. Settings → Reading → set Posts page to "Blog".
3. Flush permalinks.

---

### "The reviews page shows a 404"
**Cause:** Permalinks need flushing after theme activation or the Reviews page was not created.
**Fix:**
1. Create a page titled "Reviews" with the "Reviews" page template.
2. Settings → Permalinks → Save Changes.

---

### "Review submissions are not showing up"
**Cause:** Submissions are saved as Pending by design.
**Fix:** Go to Reviews → All Reviews. Filter by Pending. Approve the review.

---

### "The WhatsApp button does not open a chat"
**Cause:** The number in the WhatsApp button setting has incorrect formatting.
**Fix:** Customizer → WhatsApp Floating Button → WhatsApp Number. Enter digits only, no `+`, no spaces. Example: `923001234567`.

---

### "Announcement bar items are misaligned or blank"
**Cause:** An item field is left empty.
**Fix:** Fill all four ticker items, or turn off the bar entirely (Customizer → Announcement Bar → toggle off).

---

### "Category archive shows no products"
**Cause:** No products are assigned to that category, or all assigned products are drafts.
**Fix:** Open each product, check the **Product Categories** box on the right, ensure the correct category is ticked, and confirm the product is Published.

---

### "Product card specs are not showing"
**Cause:** The `_opm_specs` meta field is empty.
**Fix:** Edit the product → look for the Product Specs meta box below the editor → enter comma-separated specs. If no meta box is visible, the `opm_product` plugin may not have registered it — contact the developer.

---

### "Brand colour changes in Customizer are not appearing on the site"
**Cause:** A caching plugin or server-side cache is serving a stale page.
**Fix:** Clear all caches (caching plugin → Purge All, or contact your host). Customizer changes take effect immediately in preview — if the live site doesn't update, it's always a cache issue.

---

### "The hero background image looks low quality or blurry"
**Cause:** The uploaded image is too small.
**Fix:** Upload an image at least 1400 × 700 pixels. Re-upload via Customizer → Homepage Hero → Hero Background Image.

---

### "Google Analytics is not tracking visits"
**Cause:** The Measurement ID is entered incorrectly, or a caching plugin is stripping the script tag.
**Fix:** 
1. Customizer → SEO & Search Overrides → Google Analytics 4 ID. 
2. Confirm the ID starts with `G-` (not `UA-`).
3. Inspect the page source and search for `gtag` — if missing, a caching or security plugin may be blocking it.

---

### "The footer copyright year is outdated"
**Cause:** The copyright text is static and must be updated manually.
**Fix:** Customizer → Footer Settings → Copyright Notice → update the year → Publish.

---

### "Custom link in menu returns 404"
**Cause:** Wrong URL format.
**Fix:** Use full URLs (`https://oriapatel.com/contact/`) or root-relative paths with leading slash (`/contact/`). Never use bare slugs like `contact`.

---

*End of User Manual — Oria Patel Pro v1.0.0*

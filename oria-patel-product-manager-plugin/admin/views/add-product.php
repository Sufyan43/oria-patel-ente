<?php
defined( 'ABSPATH' ) || exit;

// Load existing product if editing
$product_id   = absint( $_GET['product_id'] ?? 0 );
$is_edit      = $product_id > 0;
$post         = $is_edit ? get_post( $product_id ) : null;
$page_title   = $is_edit ? 'Edit Product' : 'Add New Product';

// Pull existing meta for editing
$thumb_id     = $is_edit ? (int) get_post_thumbnail_id( $product_id ) : 0;
$thumb_url    = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : '';
$gallery_raw  = $is_edit ? get_post_meta( $product_id, '_product_image_gallery', true ) : '';
$gallery_ids  = array_filter( array_map( 'absint', explode( ',', $gallery_raw ) ) );
$meta         = [];
$meta_keys    = [ '_opm_specs', '_opm_sizes', '_opm_colors', '_opm_custom_text_label', '_opm_moq', '_opm_lead_time', '_opm_fabric', '_opm_printing', '_opm_badge_text' ];
foreach ( $meta_keys as $k ) $meta[ $k ] = $is_edit ? (string) get_post_meta( $product_id, $k, true ) : '';

// Category tree for checkboxes
$cats_tree        = opm_get_category_tree();
$selected_cat_ids = $is_edit ? wp_get_post_terms( $product_id, opm_category_taxonomy(), [ 'fields' => 'ids' ] ) : [];

// Saved notice
if ( isset( $_GET['saved'] ) ) {
	opm_notice( '✅ Product saved successfully! <a href="' . esc_url( get_permalink( $product_id ) ) . '" target="_blank">View on website →</a>' );
}

// Result from form submit
if ( ! empty( $result ) ) {
	opm_notice( $result['message'], $result['success'] ? 'success' : 'error' );
}
?>

<div class="wrap opm-wrap">

	<div class="opm-topbar">
		<div class="opm-topbar__brand">
			<span class="opm-topbar__icon"><?php echo $is_edit ? '✏️' : '➕'; ?></span>
			<div>
				<h1 class="opm-topbar__title"><?php echo esc_html( $page_title ); ?></h1>
				<p class="opm-topbar__sub">
					<?php if ( $is_edit ) : ?>
						Editing: <strong><?php echo esc_html( $post->post_title ); ?></strong>
						&nbsp;|&nbsp; <a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_product' ) ); ?>">+ Add Another</a>
					<?php else : ?>
						Fill in the details below and click "Save Product".
					<?php endif; ?>
				</p>
			</div>
		</div>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_products' ) ); ?>" class="opm-btn opm-btn--outline">← Back to Products</a>
	</div>

	<form method="post" class="opm-product-form" id="opm-product-form">
		<?php wp_nonce_field( 'opm_save_product', 'opm_product_nonce' ); ?>
		<?php if ( $is_edit ) : ?>
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
		<?php endif; ?>

		<div class="opm-form-layout">

			<!-- ── LEFT COLUMN (main fields) ──────────────────────────── -->
			<div class="opm-form-main">

				<!-- Product Name -->
				<div class="opm-card">
					<label class="opm-label">📝 Product Name <span class="opm-required">*</span></label>
					<input type="text" name="product_title" class="opm-input opm-input--lg"
					       value="<?php echo esc_attr( $post->post_title ?? '' ); ?>"
					       placeholder="e.g. American Football Uniform" required>
					<p class="opm-hint">The main title shown in your shop. Be specific and descriptive.</p>
				</div>

				<!-- Description -->
				<div class="opm-card">
					<label class="opm-label">📄 Full Description</label>
					<p class="opm-hint" style="margin-bottom:8px">The detailed product description shown on the product page. Include all fabric details, features, what's included, etc.</p>
					<?php
					wp_editor(
						$is_edit ? ( $post->post_content ?? '' ) : '',
						'product_desc',
						[
							'textarea_name' => 'product_desc',
							'media_buttons' => true,
							'teeny'         => false,
							'textarea_rows' => 10,
						]
					);
					?>
				</div>

				<!-- Short Description -->
				<div class="opm-card">
					<label class="opm-label">📋 Short Description (shown in product listing)</label>
					<textarea name="product_excerpt" class="opm-textarea" rows="3"
					          placeholder="2–3 lines summarising the product. Shown on the shop/category page."><?php echo esc_textarea( $is_edit ? ( $post->post_excerpt ?? '' ) : '' ); ?></textarea>
				</div>

				<!-- Tabs: Specs / Sizes / Colours / Customisation / Shipping -->
				<div class="opm-card">
					<div class="opm-tabs">
						<button type="button" class="opm-tab is-active" data-tab="specs">📐 Specs &amp; Features</button>
						<button type="button" class="opm-tab" data-tab="options">🎨 Customisation Options</button>
						<button type="button" class="opm-tab" data-tab="shipping">🚚 Shipping &amp; MOQ</button>
					</div>

					<!-- SPECS TAB -->
					<div class="opm-tab-panel is-active" id="tab-specs">
						<div class="opm-field-group">
							<label class="opm-label">Key Specs / Features <small>(comma-separated)</small></label>
							<input type="text" name="product_specs" class="opm-input" id="opm-specs-input"
							       value="<?php echo esc_attr( $meta['_opm_specs'] ); ?>"
							       placeholder="100% Sublimation, Moisture-Wicking, MOQ: 1, Custom Numbers">
							<p class="opm-hint">These appear as feature badges on the product card. Separate each with a comma. Examples: <em>100% Sublimation, 4-Way Stretch, Fade-Proof, MOQ: 1</em></p>
							<div class="opm-tag-preview" id="opm-specs-preview"></div>

							<div class="opm-preset-chips">
								<p class="opm-hint" style="margin-bottom:6px">Quick add:</p>
								<?php
								$presets = [ '100% Sublimation', 'Moisture-Wicking', 'Fade-Proof', '4-Way Stretch', 'Lightweight Mesh', 'Breathable Fabric', 'Custom Numbers', 'Custom Names', 'Full Set Included', 'All Sizes Available' ];
								foreach ( $presets as $p ) :
								?>
								<button type="button" class="opm-chip" onclick="opmAddToField('opm-specs-input', '<?php echo esc_js( $p ); ?>')">
									+ <?php echo esc_html( $p ); ?>
								</button>
								<?php endforeach; ?>
							</div>
						</div>

						<div class="opm-field-group">
							<label class="opm-label">Fabric / Material</label>
							<input type="text" name="product_fabric" class="opm-input"
							       value="<?php echo esc_attr( $meta['_opm_fabric'] ); ?>"
							       placeholder="e.g. 100% Polyester, Dri-Fit, Compression Fabric">
						</div>

						<div class="opm-field-group">
							<label class="opm-label">Printing Method</label>
							<input type="text" name="product_printing" class="opm-input"
							       value="<?php echo esc_attr( $meta['_opm_printing'] ); ?>"
							       placeholder="e.g. Full Sublimation, Screen Print, Heat Transfer">
						</div>
					</div>

					<!-- OPTIONS TAB -->
					<div class="opm-tab-panel" id="tab-options">
						<div class="opm-field-group">
							<label class="opm-label">Available Sizes <small>(comma-separated)</small></label>
							<input type="text" name="product_sizes" class="opm-input" id="opm-sizes-input"
							       value="<?php echo esc_attr( $meta['_opm_sizes'] ); ?>"
							       placeholder="XS, S, M, L, XL, XXL, 3XL">
							<div class="opm-tag-preview" id="opm-sizes-preview"></div>
							<div class="opm-preset-chips">
								<button type="button" class="opm-chip" onclick="opmSetField('opm-sizes-input','XS, S, M, L, XL, XXL')">Standard Sizes</button>
								<button type="button" class="opm-chip" onclick="opmSetField('opm-sizes-input','XS, S, M, L, XL, XXL, 3XL, 4XL')">Extended Sizes</button>
								<button type="button" class="opm-chip" onclick="opmSetField('opm-sizes-input','Youth S, Youth M, Youth L, Adult S, M, L, XL')">Youth + Adult</button>
								<button type="button" class="opm-chip" onclick="opmSetField('opm-sizes-input','Custom (any size available)')">Custom Sizing</button>
							</div>
						</div>

						<div class="opm-field-group">
							<label class="opm-label">Available Colours <small>(comma-separated)</small></label>
							<input type="text" name="product_colors" class="opm-input" id="opm-colors-input"
							       value="<?php echo esc_attr( $meta['_opm_colors'] ); ?>"
							       placeholder="Any colour — fully custom sublimation">
							<div class="opm-tag-preview" id="opm-colors-preview"></div>
							<div class="opm-preset-chips">
								<button type="button" class="opm-chip" onclick="opmSetField('opm-colors-input','Any colour — fully custom sublimation')">Fully Custom</button>
								<button type="button" class="opm-chip" onclick="opmAddToField('opm-colors-input','Red')">Red</button>
								<button type="button" class="opm-chip" onclick="opmAddToField('opm-colors-input','Blue')">Blue</button>
								<button type="button" class="opm-chip" onclick="opmAddToField('opm-colors-input','Black')">Black</button>
								<button type="button" class="opm-chip" onclick="opmAddToField('opm-colors-input','White')">White</button>
								<button type="button" class="opm-chip" onclick="opmAddToField('opm-colors-input','Green')">Green</button>
								<button type="button" class="opm-chip" onclick="opmAddToField('opm-colors-input','Gold')">Gold</button>
							</div>
						</div>

						<div class="opm-field-group">
							<label class="opm-label">Custom Text / Personalisation Label</label>
							<input type="text" name="product_custom_text_label" class="opm-input"
							       value="<?php echo esc_attr( $meta['_opm_custom_text_label'] ); ?>"
							       placeholder="e.g. Player Name, Number on Back, Team Name on Front">
							<p class="opm-hint">Describe what text or personalisation customers can add. This shows up on the product page as an option.</p>
						</div>

						<div class="opm-field-group">
							<label class="opm-label">Badge / Highlight Tag <small>(optional)</small></label>
							<input type="text" name="product_badge" class="opm-input"
							       value="<?php echo esc_attr( $meta['_opm_badge_text'] ); ?>"
							       placeholder="e.g. Best Seller, New Arrival, Most Popular">
							<p class="opm-hint">A small label shown on the product card. Leave blank for no badge.</p>
						</div>
					</div>

					<!-- SHIPPING TAB -->
					<div class="opm-tab-panel" id="tab-shipping">
						<div class="opm-field-row">
							<div class="opm-field-group">
								<label class="opm-label">Minimum Order Quantity (MOQ)</label>
								<input type="text" name="product_moq" class="opm-input"
								       value="<?php echo esc_attr( $meta['_opm_moq'] ?: '1' ); ?>"
								       placeholder="1">
								<p class="opm-hint">Minimum number of pieces per order. Usually "1" for custom uniforms.</p>
							</div>
							<div class="opm-field-group">
								<label class="opm-label">Production / Lead Time</label>
								<input type="text" name="product_lead_time" class="opm-input"
								       value="<?php echo esc_attr( $meta['_opm_lead_time'] ); ?>"
								       placeholder="e.g. 2–3 weeks after design approval">
							</div>
						</div>
					</div>

				</div><!-- .opm-card (tabs) -->

			</div><!-- .opm-form-main -->

			<!-- ── RIGHT COLUMN (images, category, status) ────────────── -->
			<div class="opm-form-sidebar">

				<!-- Save Box -->
				<div class="opm-card opm-card--save">
					<h3 class="opm-card__title">💾 Save Product</h3>
					<div class="opm-field-group">
						<label class="opm-label">Status</label>
						<select name="product_status" class="opm-select">
							<option value="publish" <?php selected( $post->post_status ?? 'publish', 'publish' ); ?>>✅ Published (visible on website)</option>
							<option value="draft"   <?php selected( $post->post_status ?? '', 'draft'   ); ?>>📝 Draft (hidden — only you can see)</option>
							<option value="private" <?php selected( $post->post_status ?? '', 'private' ); ?>>🔒 Private (logged-in admins only)</option>
						</select>
					</div>
					<button type="submit" class="opm-btn opm-btn--primary opm-btn--full">
						<?php echo $is_edit ? '💾 Update Product' : '✅ Save Product'; ?>
					</button>
					<?php if ( $is_edit && get_permalink( $product_id ) ) : ?>
						<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="opm-btn opm-btn--ghost opm-btn--full" target="_blank" style="margin-top:8px">
							👁️ View on Website
						</a>
					<?php endif; ?>
				</div>

				<!-- Featured Image -->
				<div class="opm-card">
					<h3 class="opm-card__title">🖼️ Main Product Photo</h3>
					<p class="opm-hint">The primary photo shown on the shop listing and product page. Best size: 600×450px.</p>
					<div class="opm-image-uploader" id="opm-thumb-uploader">
						<?php if ( $thumb_url ) : ?>
							<img src="<?php echo esc_url( $thumb_url ); ?>" class="opm-image-uploader__preview" id="opm-thumb-preview" alt="">
						<?php else : ?>
							<div class="opm-image-uploader__placeholder" id="opm-thumb-placeholder">
								<span>📷</span><br>Click to upload photo
							</div>
						<?php endif; ?>
						<input type="hidden" name="product_thumb_id" id="opm-thumb-id" value="<?php echo esc_attr( $thumb_id ); ?>">
					</div>
					<div style="display:flex;gap:8px;margin-top:10px">
						<button type="button" class="opm-btn opm-btn--outline opm-btn--sm" id="opm-thumb-btn">
							<?php echo $thumb_id ? '🔄 Change Photo' : '⬆️ Upload Photo'; ?>
						</button>
						<?php if ( $thumb_id ) : ?>
						<button type="button" class="opm-btn opm-btn--ghost opm-btn--sm" id="opm-thumb-remove">Remove</button>
						<?php endif; ?>
					</div>
				</div>

				<!-- Gallery -->
				<div class="opm-card">
					<h3 class="opm-card__title">🖼️ Additional Photos (Gallery)</h3>
					<p class="opm-hint">Upload extra photos — front view, back view, detail shots. Up to 8 images.</p>
					<div class="opm-gallery-grid" id="opm-gallery-grid">
						<?php foreach ( $gallery_ids as $gid ) :
							$gurl = wp_get_attachment_image_url( $gid, 'thumbnail' );
							if ( ! $gurl ) continue;
						?>
							<div class="opm-gallery-item" data-id="<?php echo esc_attr( $gid ); ?>">
								<img src="<?php echo esc_url( $gurl ); ?>" alt="">
								<button type="button" class="opm-gallery-item__remove" onclick="opmRemoveGalleryItem(this)">×</button>
							</div>
						<?php endforeach; ?>
					</div>
					<input type="hidden" name="product_gallery_ids" id="opm-gallery-ids"
					       value="<?php echo esc_attr( implode( ',', $gallery_ids ) ); ?>">
					<button type="button" class="opm-btn opm-btn--outline opm-btn--sm" id="opm-gallery-btn" style="margin-top:10px">
						⬆️ Add Gallery Photos
					</button>
				</div>

				<!-- Categories -->
				<div class="opm-card">
					<h3 class="opm-card__title">🗂️ Product Category</h3>
					<p class="opm-hint">Tick the category (or subcategory) this product belongs to. You can select more than one.</p>
					<?php if ( $cats_tree ) : ?>
					<div class="opm-cat-checklist">
						<?php foreach ( $cats_tree as [ 'term' => $t, 'depth' => $d ] ) : ?>
							<label class="opm-cat-check" style="padding-left:<?php echo ( $d * 20 ); ?>px">
								<input type="checkbox" name="product_categories[]"
								       value="<?php echo esc_attr( $t->term_id ); ?>"
								       <?php checked( in_array( $t->term_id, (array) $selected_cat_ids ) ); ?>>
								<?php echo esc_html( $t->name ); ?>
								<span class="opm-muted" style="font-size:11px">(<?php echo (int) $t->count; ?>)</span>
							</label>
						<?php endforeach; ?>
					</div>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_category' ) ); ?>" class="opm-link opm-link--sm" style="display:block;margin-top:12px">
						+ Add a new category
					</a>
					<?php else : ?>
					<div class="opm-empty opm-empty--sm">
						<p>No categories yet.</p>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_category' ) ); ?>" class="opm-btn opm-btn--outline opm-btn--sm">Create First Category</a>
					</div>
					<?php endif; ?>
				</div>

			</div><!-- .opm-form-sidebar -->

		</div><!-- .opm-form-layout -->
	</form>

</div>

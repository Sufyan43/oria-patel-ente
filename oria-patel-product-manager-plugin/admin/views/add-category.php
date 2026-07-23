<?php
defined( 'ABSPATH' ) || exit;

$term_id  = absint( $_GET['term_id'] ?? 0 );
$is_edit  = $term_id > 0;
$term     = $is_edit ? get_term( $term_id, opm_category_taxonomy() ) : null;
$thumb_id = $is_edit ? (int) get_term_meta( $term_id, 'thumbnail_id', true ) : 0;
$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : '';

if ( ! empty( $result ) ) {
	opm_notice( $result['message'], $result['success'] ? 'success' : 'error' );
}
$cats_tree = opm_get_category_tree();
?>

<div class="wrap opm-wrap">

	<div class="opm-topbar">
		<div class="opm-topbar__brand">
			<span class="opm-topbar__icon"><?php echo $is_edit ? '✏️' : '➕'; ?></span>
			<div>
				<h1 class="opm-topbar__title"><?php echo $is_edit ? 'Edit Category' : 'Add New Category'; ?></h1>
				<p class="opm-topbar__sub">
					<?php if ( $is_edit && $term ) echo 'Editing: <strong>' . esc_html( $term->name ) . '</strong>'; else echo 'Create a parent or subcategory'; ?>
				</p>
			</div>
		</div>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_categories' ) ); ?>" class="opm-btn opm-btn--outline">← All Categories</a>
	</div>

	<div class="opm-tip-box">
		💡 <strong>How categories work:</strong> First create a <strong>Parent Category</strong> (e.g. "Team Sports") by leaving Parent set to "None". Then create a <strong>Subcategory</strong> (e.g. "American Football") and set its Parent to "Team Sports".
	</div>

	<form method="post" class="opm-cat-form">
		<?php wp_nonce_field( 'opm_save_category', 'opm_cat_nonce' ); ?>
		<?php if ( $is_edit ) : ?>
			<input type="hidden" name="cat_term_id" value="<?php echo esc_attr( $term_id ); ?>">
		<?php endif; ?>

		<div class="opm-form-layout opm-form-layout--cat">

			<!-- Main fields -->
			<div class="opm-form-main">
				<div class="opm-card">

					<div class="opm-field-group">
						<label class="opm-label">🏷️ Category Name <span class="opm-required">*</span></label>
						<input type="text" name="cat_name" class="opm-input opm-input--lg"
						       value="<?php echo esc_attr( $term->name ?? '' ); ?>"
						       placeholder="e.g. Team Sports, American Football, Soccer" required>
						<p class="opm-hint">Keep it short and clear. This is shown as the category label on your website.</p>
					</div>

					<div class="opm-field-group">
						<label class="opm-label">📁 Parent Category <small>(leave as "None" to make this a top-level category)</small></label>
						<select name="cat_parent" class="opm-select">
							<option value="0">— None (this is a top-level / parent category) —</option>
							<?php foreach ( $cats_tree as [ 'term' => $t, 'depth' => $d ] ) :
								// Don't show the current term as a parent option (can't be its own parent)
								if ( $is_edit && $t->term_id === $term_id ) continue;
							?>
								<option value="<?php echo esc_attr( $t->term_id ); ?>"
								        <?php selected( (int) ( $term->parent ?? 0 ), $t->term_id ); ?>>
									<?php echo str_repeat( '— ', $d ) . esc_html( $t->name ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="opm-field-group">
						<label class="opm-label">📝 Description <small>(optional)</small></label>
						<textarea name="cat_description" class="opm-textarea" rows="3"
						          placeholder="A short description of this category. Shown on the category page."><?php echo esc_textarea( $term->description ?? '' ); ?></textarea>
					</div>

					<div class="opm-field-group">
						<label class="opm-label">🔗 URL Slug <small>(auto-generated if left blank)</small></label>
						<input type="text" name="cat_slug" class="opm-input"
						       value="<?php echo esc_attr( $term->slug ?? '' ); ?>"
						       placeholder="e.g. american-football (lowercase, hyphens only)">
						<p class="opm-hint">This becomes part of your category page URL. Leave blank to auto-generate from the name.</p>
					</div>

				</div><!-- .opm-card -->
			</div>

			<!-- Sidebar -->
			<div class="opm-form-sidebar">

				<!-- Save -->
				<div class="opm-card opm-card--save">
					<h3 class="opm-card__title">💾 Save Category</h3>
					<button type="submit" class="opm-btn opm-btn--primary opm-btn--full">
						<?php echo $is_edit ? '💾 Update Category' : '✅ Create Category'; ?>
					</button>
					<?php if ( ! $is_edit ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_category' ) ); ?>" class="opm-btn opm-btn--ghost opm-btn--full" style="margin-top:8px">
						Add Another Category
					</a>
					<?php endif; ?>
				</div>

				<!-- Category Image -->
				<div class="opm-card">
					<h3 class="opm-card__title">🖼️ Category Background Photo</h3>
					<p class="opm-hint">This photo appears on the sport category card on your homepage. Best size: 600×450px. Use an action shot of athletes in that sport.</p>

					<div class="opm-image-uploader" id="opm-cat-thumb-uploader">
						<?php if ( $thumb_url ) : ?>
							<img src="<?php echo esc_url( $thumb_url ); ?>" class="opm-image-uploader__preview" id="opm-cat-thumb-preview" alt="">
						<?php else : ?>
							<div class="opm-image-uploader__placeholder" id="opm-cat-thumb-placeholder">
								<span>🖼️</span><br>Click to upload photo
							</div>
						<?php endif; ?>
						<input type="hidden" name="cat_image_id" id="opm-cat-thumb-id" value="<?php echo esc_attr( $thumb_id ); ?>">
					</div>
					<div style="display:flex;gap:8px;margin-top:10px">
						<button type="button" class="opm-btn opm-btn--outline opm-btn--sm" id="opm-cat-thumb-btn">
							<?php echo $thumb_id ? '🔄 Change Photo' : '⬆️ Upload Photo'; ?>
						</button>
						<?php if ( $thumb_id ) : ?>
						<button type="button" class="opm-btn opm-btn--ghost opm-btn--sm" id="opm-cat-thumb-remove">Remove</button>
						<?php endif; ?>
					</div>
				</div>

			</div>
		</div>
	</form>

</div>

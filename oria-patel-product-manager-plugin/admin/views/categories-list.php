<?php defined( 'ABSPATH' ) || exit;
do_action( 'opm_notices' );
$tree = opm_get_category_tree();
?>

<div class="wrap opm-wrap">

	<div class="opm-topbar">
		<div class="opm-topbar__brand">
			<span class="opm-topbar__icon">🗂️</span>
			<div>
				<h1 class="opm-topbar__title">Product Categories</h1>
				<p class="opm-topbar__sub"><?php echo count( $tree ); ?> categor<?php echo count( $tree ) === 1 ? 'y' : 'ies'; ?></p>
			</div>
		</div>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_category' ) ); ?>" class="opm-btn opm-btn--primary">➕ Add New Category</a>
	</div>

	<div class="opm-tip-box">
		💡 <strong>Tip:</strong> Create <strong>parent categories</strong> first (e.g. "Team Sports"), then create <strong>subcategories</strong> inside them (e.g. "American Football"). Products are assigned to subcategories.
	</div>

	<?php if ( $tree ) : ?>
	<div class="opm-card" style="padding:0;overflow:hidden">
		<table class="opm-table">
			<thead>
				<tr>
					<th style="width:60px">Image</th>
					<th>Category Name</th>
					<th>Type</th>
					<th>Slug (URL)</th>
					<th># Products</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $tree as [ 'term' => $t, 'depth' => $d ] ) :
					$thumb_id  = (int) get_term_meta( $t->term_id, 'thumbnail_id', true );
					$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'thumbnail' ) : '';
					$edit_url  = admin_url( 'admin.php?page=opm_add_category&term_id=' . $t->term_id );
					$del_url   = wp_nonce_url(
						admin_url( 'admin.php?page=opm_categories&action=delete&term_id=' . $t->term_id ),
						'opm_delete_category'
					);
				?>
				<tr>
					<td>
						<?php if ( $thumb_url ) : ?>
							<img src="<?php echo esc_url( $thumb_url ); ?>" class="opm-table__thumb" alt="">
						<?php else : ?>
							<div class="opm-table__no-img">📁</div>
						<?php endif; ?>
					</td>
					<td style="padding-left:<?php echo 16 + ( $d * 24 ); ?>px">
						<?php if ( $d > 0 ) echo '<span style="color:#ccc;margin-right:4px">└</span>'; ?>
						<strong><?php echo esc_html( $t->name ); ?></strong>
					</td>
					<td>
						<?php if ( $d === 0 ) : ?>
							<span class="opm-status opm-status--publish">Parent</span>
						<?php else : ?>
							<span class="opm-status opm-status--draft">Subcategory</span>
						<?php endif; ?>
					</td>
					<td><code class="opm-code"><?php echo esc_html( $t->slug ); ?></code></td>
					<td><?php echo (int) $t->count; ?></td>
					<td>
						<div class="opm-row-actions">
							<a href="<?php echo esc_url( $edit_url ); ?>" class="opm-btn opm-btn--xs opm-btn--outline">✏️ Edit</a>
							<a href="<?php echo esc_url( $del_url ); ?>"
							   class="opm-btn opm-btn--xs opm-btn--danger"
							   onclick="return confirm('Delete \'<?php echo esc_js( $t->name ); ?>\'? Products inside will not be deleted but will lose this category.')">
								🗑️ Delete
							</a>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php else : ?>
	<div class="opm-card">
		<div class="opm-empty">
			<p style="font-size:48px;margin:0">📂</p>
			<p><strong>No categories yet.</strong></p>
			<p>Create your first category to organise your products.</p>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_category' ) ); ?>" class="opm-btn opm-btn--primary">➕ Add First Category</a>
		</div>
	</div>
	<?php endif; ?>

</div>

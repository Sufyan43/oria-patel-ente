<?php defined( 'ABSPATH' ) || exit;
do_action( 'opm_notices' );

// Filters
$filter_cat    = absint( $_GET['cat'] ?? 0 );
$filter_status = sanitize_text_field( $_GET['status'] ?? '' );
$search        = sanitize_text_field( $_GET['s'] ?? '' );

$query_args = [];
if ( $filter_cat )    $query_args['tax_query']    = [[ 'taxonomy' => opm_category_taxonomy(), 'field' => 'term_id', 'terms' => $filter_cat ]];
if ( $filter_status ) $query_args['post_status']  = [ $filter_status ];
if ( $search )        $query_args['s']            = $search;
$products = opm_get_products( $query_args );

$cats_tree = opm_get_category_tree();
?>

<div class="wrap opm-wrap">

	<div class="opm-topbar">
		<div class="opm-topbar__brand">
			<span class="opm-topbar__icon">📦</span>
			<div>
				<h1 class="opm-topbar__title">All Products</h1>
				<p class="opm-topbar__sub"><?php echo count( $products ); ?> product(s) found</p>
			</div>
		</div>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_product' ) ); ?>" class="opm-btn opm-btn--primary">➕ Add New Product</a>
	</div>

	<!-- Filters bar -->
	<div class="opm-filters">
		<form method="get" class="opm-filters__form">
			<input type="hidden" name="page" value="opm_products">
			<input type="text" name="s" value="<?php echo esc_attr( $search ); ?>" placeholder="🔍 Search products…" class="opm-input opm-input--sm">
			<select name="cat" class="opm-select opm-select--sm">
				<option value="">All Categories</option>
				<?php foreach ( $cats_tree as [ 'term' => $t, 'depth' => $d ] ) : ?>
					<option value="<?php echo esc_attr( $t->term_id ); ?>" <?php selected( $filter_cat, $t->term_id ); ?>>
						<?php echo str_repeat( '— ', $d ) . esc_html( $t->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<select name="status" class="opm-select opm-select--sm">
				<option value="">All Statuses</option>
				<option value="publish" <?php selected( $filter_status, 'publish' ); ?>>Published</option>
				<option value="draft"   <?php selected( $filter_status, 'draft'   ); ?>>Draft</option>
				<option value="private" <?php selected( $filter_status, 'private' ); ?>>Private</option>
			</select>
			<button type="submit" class="opm-btn opm-btn--outline">Filter</button>
			<?php if ( $search || $filter_cat || $filter_status ) : ?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_products' ) ); ?>" class="opm-btn opm-btn--ghost">Clear</a>
			<?php endif; ?>
		</form>
	</div>

	<?php if ( $products ) : ?>
	<div class="opm-card" style="padding:0;overflow:hidden">
		<table class="opm-table">
			<thead>
				<tr>
					<th style="width:60px">Photo</th>
					<th>Product Name</th>
					<th>Category</th>
					<th>Specs</th>
					<th>Status</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $products as $p ) :
					$thumb  = get_the_post_thumbnail_url( $p->ID, 'thumbnail' );
					$terms  = get_the_terms( $p->ID, opm_category_taxonomy() );
					$cats_label = $terms && ! is_wp_error( $terms )
					              ? implode( ', ', wp_list_pluck( $terms, 'name' ) ) : '—';
					$specs  = get_post_meta( $p->ID, '_opm_specs', true );
					$edit_url   = admin_url( 'admin.php?page=opm_add_product&product_id=' . $p->ID );
					$delete_url = wp_nonce_url(
						admin_url( 'admin.php?page=opm_products&action=delete&product_id=' . $p->ID ),
						'opm_delete_product'
					);
					$view_url   = get_permalink( $p->ID );
				?>
				<tr>
					<td>
						<?php if ( $thumb ) : ?>
							<img src="<?php echo esc_url( $thumb ); ?>" class="opm-table__thumb" alt="">
						<?php else : ?>
							<div class="opm-table__no-img">📦</div>
						<?php endif; ?>
					</td>
					<td>
						<strong><a href="<?php echo esc_url( $edit_url ); ?>" class="opm-link"><?php echo esc_html( $p->post_title ); ?></a></strong>
					</td>
					<td><span class="opm-meta-tag"><?php echo esc_html( $cats_label ); ?></span></td>
					<td>
						<?php if ( $specs ) : ?>
						<span class="opm-ellipsis" title="<?php echo esc_attr( $specs ); ?>">
							<?php echo esc_html( strlen( $specs ) > 40 ? substr( $specs, 0, 40 ) . '…' : $specs ); ?>
						</span>
						<?php else : ?>—<?php endif; ?>
					</td>
					<td>
						<span class="opm-status opm-status--<?php echo esc_attr( $p->post_status ); ?>">
							<?php echo esc_html( ucfirst( $p->post_status ) ); ?>
						</span>
					</td>
					<td class="opm-muted"><?php echo esc_html( get_the_date( 'd M Y', $p ) ); ?></td>
					<td>
						<div class="opm-row-actions">
							<a href="<?php echo esc_url( $edit_url ); ?>" class="opm-btn opm-btn--xs opm-btn--outline">✏️ Edit</a>
							<?php if ( $view_url ) : ?>
								<a href="<?php echo esc_url( $view_url ); ?>" class="opm-btn opm-btn--xs opm-btn--ghost" target="_blank">👁️ View</a>
							<?php endif; ?>
							<a href="<?php echo esc_url( $delete_url ); ?>"
							   class="opm-btn opm-btn--xs opm-btn--danger"
							   onclick="return confirm('Delete \'<?php echo esc_js( $p->post_title ); ?>\'? This cannot be undone.')">
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
			<p style="font-size:48px;margin:0">📭</p>
			<p><strong>No products found.</strong></p>
			<?php if ( $search || $filter_cat || $filter_status ) : ?>
				<p>Try changing your filters.</p>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_products' ) ); ?>" class="opm-btn opm-btn--outline">Clear Filters</a>
			<?php else : ?>
				<p>Get started by adding your first product.</p>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_product' ) ); ?>" class="opm-btn opm-btn--primary">➕ Add First Product</a>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

</div>

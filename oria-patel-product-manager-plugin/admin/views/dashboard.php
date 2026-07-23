<?php defined( 'ABSPATH' ) || exit; ?>

<div class="wrap opm-wrap">

	<div class="opm-topbar">
		<div class="opm-topbar__brand">
			<span class="opm-topbar__icon">🎽</span>
			<div>
				<h1 class="opm-topbar__title">Oria Patel — Product Manager</h1>
				<p class="opm-topbar__sub">Your central hub for products &amp; categories</p>
			</div>
		</div>
		<div class="opm-topbar__actions">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_product' ) ); ?>" class="opm-btn opm-btn--primary">
				➕ Add New Product
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_category' ) ); ?>" class="opm-btn opm-btn--outline">
				🗂️ Add Category
			</a>
		</div>
	</div>

	<?php
	$total_products  = wp_count_posts( 'opm_product' );
	$pub_products    = (int) ( $total_products->publish ?? 0 );
	$draft_products  = (int) ( $total_products->draft   ?? 0 );
	$total_cats      = wp_count_terms( [ 'taxonomy' => 'opm_category', 'hide_empty' => false ] );
	$total_cats      = is_wp_error( $total_cats ) ? 0 : (int) $total_cats;
	$recent_products = opm_get_products( [ 'posts_per_page' => 5 ] );
	?>

	<!-- Stat Cards -->
	<div class="opm-stat-cards">
		<div class="opm-stat-card opm-stat-card--amber">
			<span class="opm-stat-card__icon">📦</span>
			<div>
				<p class="opm-stat-card__number"><?php echo number_format( $pub_products ); ?></p>
				<p class="opm-stat-card__label">Published Products</p>
			</div>
		</div>
		<div class="opm-stat-card">
			<span class="opm-stat-card__icon">📝</span>
			<div>
				<p class="opm-stat-card__number"><?php echo number_format( $draft_products ); ?></p>
				<p class="opm-stat-card__label">Draft Products</p>
			</div>
		</div>
		<div class="opm-stat-card">
			<span class="opm-stat-card__icon">🗂️</span>
			<div>
				<p class="opm-stat-card__number"><?php echo number_format( $total_cats ); ?></p>
				<p class="opm-stat-card__label">Categories</p>
			</div>
		</div>
		<div class="opm-stat-card">
			<span class="opm-stat-card__icon">🌍</span>
			<div>
				<p class="opm-stat-card__number">Worldwide</p>
				<p class="opm-stat-card__label">Shipping</p>
			</div>
		</div>
	</div>

	<!-- Quick Actions + Recent Products -->
	<div class="opm-dash-grid">

		<!-- Quick Actions -->
		<div class="opm-card">
			<h2 class="opm-card__title">⚡ Quick Actions</h2>
			<div class="opm-quick-actions">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_product' ) ); ?>" class="opm-quick-action">
					<span class="opm-quick-action__icon">➕</span>
					<span class="opm-quick-action__label">Add New Product</span>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_category' ) ); ?>" class="opm-quick-action">
					<span class="opm-quick-action__icon">🗂️</span>
					<span class="opm-quick-action__label">Add New Category</span>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_products' ) ); ?>" class="opm-quick-action">
					<span class="opm-quick-action__icon">📋</span>
					<span class="opm-quick-action__label">View All Products</span>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_categories' ) ); ?>" class="opm-quick-action">
					<span class="opm-quick-action__icon">🏷️</span>
					<span class="opm-quick-action__label">Manage Categories</span>
				</a>
				<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="opm-quick-action">
					<span class="opm-quick-action__icon">🎨</span>
					<span class="opm-quick-action__label">Customise Theme</span>
				</a>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="opm-quick-action">
					<span class="opm-quick-action__icon">👁️</span>
					<span class="opm-quick-action__label">View Website</span>
				</a>
			</div>
		</div>

		<!-- Recent Products -->
		<div class="opm-card">
			<div class="opm-card__header">
				<h2 class="opm-card__title">🕐 Recently Added Products</h2>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_products' ) ); ?>" class="opm-link">View all →</a>
			</div>

			<?php if ( $recent_products ) : ?>
			<table class="opm-mini-table">
				<thead>
					<tr>
						<th>Product</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $recent_products as $p ) :
						$thumb = get_the_post_thumbnail_url( $p->ID, 'thumbnail' );
					?>
					<tr>
						<td>
							<div style="display:flex;align-items:center;gap:10px">
								<?php if ( $thumb ) : ?>
									<img src="<?php echo esc_url( $thumb ); ?>" style="width:36px;height:36px;object-fit:cover;border-radius:6px;border:1px solid #ddd" alt="">
								<?php else : ?>
									<div style="width:36px;height:36px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:18px">📦</div>
								<?php endif; ?>
								<strong><?php echo esc_html( $p->post_title ); ?></strong>
							</div>
						</td>
						<td>
							<span class="opm-status opm-status--<?php echo esc_attr( $p->post_status ); ?>">
								<?php echo esc_html( ucfirst( $p->post_status ) ); ?>
							</span>
						</td>
						<td>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_product&product_id=' . $p->ID ) ); ?>" class="opm-link">Edit</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php else : ?>
			<div class="opm-empty">
				<p>📭 No products yet.</p>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_product' ) ); ?>" class="opm-btn opm-btn--primary">Add Your First Product</a>
			</div>
			<?php endif; ?>
		</div>

	</div><!-- .opm-dash-grid -->

	<!-- Getting Started Guide -->
	<div class="opm-card opm-card--guide">
		<h2 class="opm-card__title">📖 How to Get Started</h2>
		<div class="opm-steps">
			<div class="opm-step">
				<span class="opm-step__num">1</span>
				<div>
					<strong>Create your categories first</strong>
					<p>Go to <a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_category' ) ); ?>">Add Category</a> and create parent categories (e.g. "Team Sports") then subcategories (e.g. "American Football").</p>
				</div>
			</div>
			<div class="opm-step">
				<span class="opm-step__num">2</span>
				<div>
					<strong>Add your products</strong>
					<p>Go to <a href="<?php echo esc_url( admin_url( 'admin.php?page=opm_add_product' ) ); ?>">Add New Product</a>, fill in the name, description, upload photos, choose a category, and add specs.</p>
				</div>
			</div>
			<div class="opm-step">
				<span class="opm-step__num">3</span>
				<div>
					<strong>Customise your homepage</strong>
					<p>Go to <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>">Appearance → Customize</a> → ⚙️ Your Website Settings to update the hero banner, category cards, colours, and contact info.</p>
				</div>
			</div>
			<div class="opm-step">
				<span class="opm-step__num">4</span>
				<div>
					<strong>Preview and publish</strong>
					<p>Click <a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">View Website</a> to see everything live.</p>
				</div>
			</div>
		</div>
	</div>

</div><!-- .opm-wrap -->

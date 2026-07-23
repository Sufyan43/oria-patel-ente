<?php
/**
 * Lead Capture Functions
 * Handles: DB table creation, AJAX form submission (save to DB + email admin),
 *          exit-intent popup, sticky header bar.
 */

defined( 'ABSPATH' ) || exit;

/* ─── Create leads table on theme activation ────────────────────────────── */
function oria_create_leads_table(): void {
	global $wpdb;
	$table = $wpdb->prefix . 'oria_leads';
	if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table ) return;

	$charset = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE {$table} (
		id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		name       VARCHAR(120)    NOT NULL DEFAULT '',
		email      VARCHAR(200)    NOT NULL DEFAULT '',
		sport      VARCHAR(200)    NOT NULL DEFAULT '',
		message    TEXT            NOT NULL DEFAULT '',
		source_url VARCHAR(500)    NOT NULL DEFAULT '',
		created_at DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id),
		KEY email (email),
		KEY created_at (created_at)
	) {$charset};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
}
add_action( 'after_switch_theme', 'oria_create_leads_table' );

/* ─── AJAX: Lead form submission ────────────────────────────────────────── */
add_action( 'wp_ajax_nopriv_oria_lead_form', 'oria_handle_lead_form' );
add_action( 'wp_ajax_oria_lead_form',        'oria_handle_lead_form' );
function oria_handle_lead_form(): void {
	check_ajax_referer( 'op_nonce', 'nonce' );

	$name    = sanitize_text_field( wp_unslash( $_POST['name']    ?? '' ) );
	$email   = sanitize_email(      wp_unslash( $_POST['email']   ?? '' ) );
	$sport   = sanitize_text_field( wp_unslash( $_POST['sport']   ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );
	$source  = esc_url_raw( wp_unslash( $_POST['source_url'] ?? '' ) );

	// Honeypot — bots fill this hidden field; humans don't
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success( [ 'message' => __( 'Thank you! We will be in touch soon.', 'oria-patel' ) ] );
	}

	if ( ! $name || ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => __( 'Please fill in your name and a valid email address.', 'oria-patel' ) ] );
	}

	global $wpdb;

	// Save to database
	$wpdb->insert(
		$wpdb->prefix . 'oria_leads',
		[
			'name'       => $name,
			'email'      => $email,
			'sport'      => $sport,
			'message'    => $message,
			'source_url' => $source,
		],
		[ '%s', '%s', '%s', '%s', '%s' ]
	);

	// Email notification to admin
	$admin_email = get_theme_mod( 'op_contact_email', get_option( 'admin_email' ) );
	$subject     = sprintf( 'New Mockup Request from %s — %s', $name, $sport ?: 'General Inquiry' );
	$body        = implode( "\n", [
		"You have a new lead from your website:",
		"",
		"Name:        {$name}",
		"Email:       {$email}",
		"Sport/Team:  {$sport}",
		"Message:     {$message}",
		"",
		"Source page: {$source}",
		"",
		"— Oria Patel Pro Theme",
	] );
	wp_mail( $admin_email, $subject, $body, [
		"Reply-To: {$name} <{$email}>",
		'Content-Type: text/plain; charset=UTF-8',
	] );

	wp_send_json_success( [
		'message'   => __( '🎉 Request received! Our designer will contact you within 24 hours.', 'oria-patel' ),
		'redirect'  => home_url( '/thank-you/' ),
	] );
}

/* ─── Sticky lead-capture bar (inline in <head> JS sets cookie) ──────────── */
add_action( 'wp_footer', 'oria_render_lead_bar', 5 );
function oria_render_lead_bar(): void {
	if ( is_admin() ) return;
	?>
<!-- ── Sticky Email Capture Bar ─────────────────────────────────────── -->
<div class="oria-lead-bar" id="oria-lead-bar" role="banner" aria-label="Free mockup offer">
	<div class="oria-lead-bar__inner">
		<p class="oria-lead-bar__text">
			🎨 <strong>Get Your Free Custom Uniform Mockup in 48 Hours</strong> — No minimum order required!
		</p>
		<form class="oria-lead-bar__form" id="oria-bar-form" novalidate>
			<input type="hidden" name="source_url" value="<?php echo esc_url( home_url( $_SERVER['REQUEST_URI'] ?? '/' ) ); ?>">
			<input type="text"  name="website" style="display:none" tabindex="-1" autocomplete="off"> <?php // honeypot ?>
			<input
				type="email"
				name="email"
				class="oria-lead-bar__input"
				placeholder="Enter your email…"
				required
				aria-label="Your email address"
			>
			<button type="submit" class="op-btn op-btn--primary op-btn--sm">
				Get Free Mockup
			</button>
		</form>
		<button class="oria-lead-bar__close" id="oria-bar-close" aria-label="Close">&times;</button>
	</div>
</div>

<!-- ── Exit-Intent Popup ─────────────────────────────────────────────── -->
<div class="oria-exit-popup" id="oria-exit-popup" role="dialog" aria-modal="true" aria-label="Free mockup popup" hidden>
	<div class="oria-exit-popup__backdrop" id="oria-popup-backdrop"></div>
	<div class="oria-exit-popup__box">
		<button class="oria-exit-popup__close" id="oria-popup-close" aria-label="Close">&times;</button>
		<div class="oria-exit-popup__badge">Wait!</div>
		<h2 class="oria-exit-popup__title">Get a Free Design Mockup Before You Go</h2>
		<p class="oria-exit-popup__desc">No obligation. Our designer will create a custom mockup for your team within 48 hours — completely free.</p>
		<form class="oria-lead-form" id="oria-popup-form" novalidate>
			<input type="hidden" name="source_url" value="<?php echo esc_url( home_url( $_SERVER['REQUEST_URI'] ?? '/' ) ); ?>">
			<input type="text"   name="website" style="display:none" tabindex="-1" autocomplete="off">
			<div class="oria-lead-form__row">
				<input type="text"  name="name"  class="oria-lead-form__input" placeholder="Your name *" required aria-label="Your name">
				<input type="email" name="email" class="oria-lead-form__input" placeholder="Email address *" required aria-label="Your email">
			</div>
			<input type="text" name="sport" class="oria-lead-form__input" placeholder="Sport / Team name (e.g. Soccer Club)" aria-label="Sport or team name">
			<button type="submit" class="op-btn op-btn--primary op-btn--full">
				Send My Free Mockup Request
			</button>
			<p class="oria-exit-popup__note">🔒 No spam. We reply within 24 hours.</p>
		</form>
		<div class="oria-lead-form__msg" id="oria-popup-msg" hidden></div>
	</div>
</div>
<?php
}

/* ─── Admin: View leads page ────────────────────────────────────────────── */
add_action( 'admin_menu', function () {
	add_submenu_page(
		'tools.php',
		'Oria Leads',
		'Oria Leads',
		'manage_options',
		'oria-leads',
		'oria_render_leads_admin_page'
	);
} );

function oria_render_leads_admin_page(): void {
	global $wpdb;
	$table = $wpdb->prefix . 'oria_leads';
	$leads = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT 200" );
	?>
	<div class="wrap">
		<h1>Oria Leads <span style="font-size:14px;font-weight:400;color:#666">(last 200)</span></h1>
		<?php if ( empty( $leads ) ) : ?>
			<p>No leads yet. They will appear here once visitors submit the mockup request form.</p>
		<?php else : ?>
		<table class="widefat fixed striped" style="margin-top:16px">
			<thead>
				<tr>
					<th>Date</th><th>Name</th><th>Email</th><th>Sport/Team</th><th>Message</th><th>Source</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $leads as $lead ) : ?>
				<tr>
					<td><?php echo esc_html( $lead->created_at ); ?></td>
					<td><?php echo esc_html( $lead->name ); ?></td>
					<td><a href="mailto:<?php echo esc_attr( $lead->email ); ?>"><?php echo esc_html( $lead->email ); ?></a></td>
					<td><?php echo esc_html( $lead->sport ); ?></td>
					<td><?php echo esc_html( wp_trim_words( $lead->message, 15 ) ); ?></td>
					<td><a href="<?php echo esc_url( $lead->source_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( wp_trim_words( $lead->source_url, 5 ) ); ?></a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>
	<?php
}

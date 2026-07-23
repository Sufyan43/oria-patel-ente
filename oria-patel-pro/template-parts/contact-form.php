<?php
/**
 * Template part: Contact / Quote Request form
 * Include via: get_template_part( 'template-parts/contact-form' );
 * Or shortcode: [op_contact_form]
 */
defined( 'ABSPATH' ) || exit;
?>

<form id="op-contact-form" class="op-form" novalidate>
	<p id="op-form-message" style="display:none;padding:12px 16px;border-radius:8px;font-size:14px;font-weight:600;background:#FAFAFA;border:1px solid #D5D9D9"></p>

	<div class="op-form-row">
		<div class="op-form-group">
			<label class="op-form-label" for="cf-name"><?php esc_html_e( 'Full Name *', 'oria-patel' ); ?></label>
			<input type="text" id="cf-name" name="name" class="op-form-input" required placeholder="<?php esc_attr_e( 'Your name', 'oria-patel' ); ?>" />
		</div>
		<div class="op-form-group">
			<label class="op-form-label" for="cf-email"><?php esc_html_e( 'Email *', 'oria-patel' ); ?></label>
			<input type="email" id="cf-email" name="email" class="op-form-input" required placeholder="<?php esc_attr_e( 'your@email.com', 'oria-patel' ); ?>" />
		</div>
	</div>

	<div class="op-form-row">
		<div class="op-form-group">
			<label class="op-form-label" for="cf-phone"><?php esc_html_e( 'Phone / WhatsApp', 'oria-patel' ); ?></label>
			<input type="tel" id="cf-phone" name="phone" class="op-form-input" placeholder="+1 000 000 0000" />
		</div>
		<div class="op-form-group">
			<label class="op-form-label" for="cf-country"><?php esc_html_e( 'Country', 'oria-patel' ); ?></label>
			<input type="text" id="cf-country" name="country" class="op-form-input" placeholder="<?php esc_attr_e( 'United States', 'oria-patel' ); ?>" />
		</div>
	</div>

	<div class="op-form-row">
		<div class="op-form-group">
			<label class="op-form-label" for="cf-sport"><?php esc_html_e( 'Sport / Product', 'oria-patel' ); ?></label>
			<select id="cf-sport" name="sport" class="op-form-select">
				<option value=""><?php esc_html_e( 'Select a sport…', 'oria-patel' ); ?></option>
				<?php
				$sports = [ 'American Football', 'Baseball', 'Basketball', 'Hockey', 'Soccer', 'Volleyball', 'Wrestling', 'Cycling', 'Track & Field', 'Casual Wear', 'Compression Wear', 'Other' ];
				foreach ( $sports as $s ) echo '<option value="' . esc_attr( $s ) . '">' . esc_html( $s ) . '</option>';
				?>
			</select>
		</div>
		<div class="op-form-group">
			<label class="op-form-label" for="cf-qty"><?php esc_html_e( 'Quantity Needed', 'oria-patel' ); ?></label>
			<select id="cf-qty" name="qty" class="op-form-select">
				<option value="1">1–10</option>
				<option value="11">11–25</option>
				<option value="26">26–50</option>
				<option value="51">51–100</option>
				<option value="101">101–500</option>
				<option value="501">500+</option>
			</select>
		</div>
	</div>

	<div class="op-form-group">
		<label class="op-form-label" for="cf-message"><?php esc_html_e( 'Design Ideas / Message', 'oria-patel' ); ?></label>
		<textarea id="cf-message" name="message" class="op-form-textarea" placeholder="<?php esc_attr_e( 'Tell us about your team colours, logo, any specific design requests…', 'oria-patel' ); ?>"></textarea>
	</div>

	<button type="submit" class="op-btn op-btn--primary" style="height:50px;font-size:15px">
		<?php esc_html_e( 'Send Quote Request', 'oria-patel' ); ?>
	</button>
</form>

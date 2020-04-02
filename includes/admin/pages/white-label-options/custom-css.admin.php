<?php

	// options
		$get_logo 			= $this->plugin()->option('logo');

/**
 * Process the data
 *
 */
if ( isset( $_POST['submit'] ) ){

	$wllform->processing = true;

	if ( ! $wllform->verify_nonce()  ) {
		wp_die($wllform->user_feedback('error','Verification Failed !!!'));
	}

	// get the lcg_value
	$wll_logo = $wllform->input_val('login_logo_url');


	// clean up before we save
	sanitize_text_field($wll_logo);



	// TODO
	// esc url
	update_option('wpwll_logo_url', $wll_logo);


}
?><div class"wll-status">
	<strong>Get Awesome free Photos:</strong> <a target="_blank" href="https://pixabay.com/photos/search/">pixabay.com</a> .
	 Give us a rating on <a target="_blank" href="https://wordpress.org/plugins/wp-white-label-login/">WordPress.org</a>.
</div>
<hr/>
CSS Settings can be updated via the Customizer<br/>
<br/>
<div id="frmwrap" >
	<a class="button button-hero" href="<?php print(admin_url('/customize.php?autofocus[section]=white_label_login')); ?>">Use The Customizer</a>
</div><!--frmwrap-->

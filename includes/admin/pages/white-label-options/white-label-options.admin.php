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
Logo <br/>
<img width="200"src="<?php echo $get_logo; ?>" alt="">
<hr/>
<div id="frmwrap" >
<?php if ( ! $wllform->processing ): ?>
		<form action="" method="POST"	enctype="multipart/form-data"><?php
	    // open table
	    echo $wllform->table('open');

			// Logo
			echo $wllform->input('Login Logo url', $get_logo );

	    // close table
	    echo $wllform->table('close');

	    // nonce_field
	    $wllform->nonce();

	    // submit button
	    echo get_submit_button('Save', 'button-primary button-hero ');

	?></form>
<?php endif;

if ($wllform->processing) {
	echo '<a class="button button-hero" href="'.admin_url('/admin.php?page=wll-white-label-options').'">Back</a>';
}
?>
</div><!--frmwrap-->

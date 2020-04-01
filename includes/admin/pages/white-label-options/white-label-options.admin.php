<?php

	// options
		$get_logo 			= $this->plugin()->option('logo');
		$get_background = $this->plugin()->option('background');
		$get_align 			= $this->plugin()->option('align');

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
	$wll_background = $wllform->input_val('login_background_url');


	// clean up before we save
	sanitize_text_field($wll_logo);
	sanitize_text_field($wll_background);



	// TODO
	// esc url
	// update options
	update_option('wpwll_logo_url', $wll_logo);
	update_option('wpwll_background_url',$wll_background);

}
?><div class"wll-status">
	<strong>Get Awesome free Photos:</strong> <a target="_blank" href="https://pixabay.com/photos/search/">pixabay.com</a> .
	 Give us a rating on <a target="_blank" href="https://wordpress.org/plugins/wp-white-label-login/">WordPress.org</a>.
</div>
<hr/>
Logo <br/>
<img width="200"src="<?php echo $get_logo; ?>" alt="">
<hr/>
Background <br/>
<img width="400"src="<?php echo $get_background; ?>" alt="">
<hr/>
<div id="frmwrap" >
<?php if ( ! $wllform->processing ): ?>
		<form action="" method="POST"	enctype="multipart/form-data"><?php
	    // open table
	    echo $wllform->table('open');

			// Logo
			echo $wllform->input('Login Logo url', $get_logo );

			// background
			echo $wllform->input('Login Background url', $get_background);

			// align
			$align = array('left','right','center');
			echo $wllform->select($align,'Align Form');

	    // close table
	    echo $wllform->table('close');

	    // nonce_field
	    $wllform->nonce();

	    // submit button
	    echo get_submit_button('Save', 'button-primary button-hero ');

	?></form>
<?php endif;

if ($wllform->processing) {
	echo '<a class="browser button button-hero" href="'.admin_url('/admin.php?page=white-label-options').'">Back</a>';
}
?>
</div><!--frmwrap-->

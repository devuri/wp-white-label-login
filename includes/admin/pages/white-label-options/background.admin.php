<style media="all">
.image-preview img {
-webkit-transition: background-color 2s ease-out;
-moz-transition: background-color 2s ease-out;
-o-transition: background-color 2s ease-out;
transition: background-color 2s ease-out;
}

</style> <?php

	// vars
		$background_images = $this->plugin()->background();
		$get_background = $this->plugin()->option('background');


/**
 * Process the data
 *
 */
if ( isset( $_POST['submit'] ) ){

	$wllform->processing = true;

	if ( ! $wllform->verify_nonce()  ) {
		wp_die($wllform->user_feedback('error','Verification Failed !!!'));
	}

	// get the value
	$wll_background = $wllform->input_val('background');


	// clean up before we save
	sanitize_text_field($wll_background);



	// TODO
	// esc url
	update_option('wpwll_background_url',$wll_background);

}
?><div class"wll-status">
	<strong>Get Awesome free Photos:</strong> <a target="_blank" href="https://pixabay.com/photos/search/">pixabay.com</a> .
	 Give us a rating on <a target="_blank" href="https://wordpress.org/plugins/wp-white-label-login/">WordPress.org</a>.
</div>
<hr/>
<?php if ( ! $wllform->processing ): ?>
<img id="image-preview" class="image-preview" width="400"src="<?php echo $get_background; ?>" alt="">
<hr/>
<div id="frmwrap" >
		<form action="" method="POST"	enctype="multipart/form-data"><?php
	    // open table
	    echo $wllform->table('open');

			// background
			echo $wllform->select($background_images ,'Background','wll_preview_bg_image');

			//echo $wllform->input('Login Background url', $get_background);

	    // close table
	    echo $wllform->table('close');

	    // nonce_field
	    $wllform->nonce();

	    // submit button
	    echo get_submit_button('Save', 'button-primary button-hero ');

	?></form>
<?php endif;

if ($wllform->processing) {
	echo '<a class="browser button button-hero" href="'.admin_url('/admin.php?page=wll-background').'">Back</a>';
}
?>
</div><!--frmwrap-->
<script type="text/javascript">
	function wll_preview_bg_image(){
		document.getElementById("image-preview").src = document.getElementById("background").value;
		console.log('bg_value');
	}
</script>

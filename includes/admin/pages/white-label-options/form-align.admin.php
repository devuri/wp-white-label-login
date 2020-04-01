<?php

	// options
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
	$wll_align = $wllform->input_val('align_form');


	// clean up before we save
	sanitize_text_field($wll_align);


	// esc
	update_option('wpwll_align', $wll_align);

}
?><div class"wll-status">
	<!-- graphic -->
	</div>
<hr/>
<div id="frmwrap" >
<?php if ( ! $wllform->processing ): ?>
		<form action="" method="POST"	enctype="multipart/form-data"><?php
	    // open table
	    echo $wllform->table('open');

			// align
			$align = array(
				'left' 		=> 0,
				'right' 	=> 1,
				'center'	=> 2,
			);
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
	echo '<a class="browser button button-hero" href="'.admin_url('/admin.php?page=wll-form-align').'">Back</a>';
}
?>
</div><!--frmwrap-->

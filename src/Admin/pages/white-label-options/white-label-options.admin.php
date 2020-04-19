<?php

	// load the wp media manager
	wp_enqueue_media();
	$wll_logo = get_option('wpwll_logo', 0);

	// Save attachment ID
	if ( isset( $_POST['submit_image'] ) && isset( $_POST['image_attachment_id'] ) ) :

		// lets verify the nonce
		if ( ! $this->form()->verify_nonce()  ) {
			wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
		}

		// get the image ID
		$image_attachment = absint($_POST['image_attachment_id']);

		// update the image and provide feedback
	  update_option( 'wpwll_logo', $image_attachment );
		echo $this->form()->user_feedback('Logo Image has been updated !!!');

	endif;

?><div class"wll-status">

</div>
<div class='logo-preview-wrapper'>
	<img id='logo-preview' src='<?php echo wp_get_attachment_url(  get_option( 'wpwll_logo')); ?>' width="120">
</div>
<hr/>
<div id="frmwrap" >
	<form action="" method="POST"	enctype="multipart/form-data"><?php
	// open table
	echo $this->form()->table('open');

	// upload file
	echo $this->form()->upload('Login Logo Image', 'Choose or Upload Logo Image');

	// image_attachment_id
	echo $this->form()->input_hidden('Image Attachment Id', get_option( 'wpwll_logo' ));

	// close table
	echo $this->form()->table('close');

	// nonce_field
	$this->form()->nonce();

	// submit button
	echo $this->form()->submit_button('Save Logo Image', 'primary large', 'submit_image');


?></form>
<br/>
	<?php echo $this->plugin()->customizer_button(); ?>
</div><!--frmwrap-->
<script type='text/javascript'>
  jQuery( document ).ready( function( $ ) {

		// Uploading files
    var file_frame;
    var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
    var set_to_post_id = <?php echo $wll_logo; ?>; // Set this
    jQuery('#login_logo_image').on('click', function( event ){
      event.preventDefault();

			// If the media frame already exists, reopen it.
      if ( file_frame ) {

				// Set the post ID to what we want
        file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
        file_frame.open();
        return;
      } else {
        // Set the wp.media post id so the uploader grabs the ID we want when initialised
        wp.media.model.settings.post.id = set_to_post_id;
      }

      // Create the media frame.
      file_frame = wp.media.frames.file_frame = wp.media({
        title: 'Select or Upload a Logo Image',
        button: {
          text: 'Use as Logo Image',
        },
        multiple: false	// Set to true to allow multiple files to be selected
      });

      // When an image is selected, run a callback.
      file_frame.on( 'select', function() {

        // We set multiple to false so only get one image from the uploader
        attachment = file_frame.state().get('selection').first().toJSON();

        // Do something with attachment.id and/or attachment.url here
        $( '#logo-preview' ).attr( 'src', attachment.url ).css( 'width', '120px' );
        $( '#image_attachment_id' ).val( attachment.id );

        // Restore the main post ID
        wp.media.model.settings.post.id = wp_media_post_id;
      });
        // Finally, open the modal
        file_frame.open();
    });

    // Restore the main ID when the add media button is pressed
    jQuery( 'a.add_media' ).on( 'click', function() {
      wp.media.model.settings.post.id = wp_media_post_id;
    });
  });
</script>

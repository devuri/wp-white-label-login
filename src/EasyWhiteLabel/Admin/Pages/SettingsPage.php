<?php
/**
 * This file is part of the Easy Video Publisher WordPress PLugin.
 *
 * (c) Uriel Wilson
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel\Admin\Pages;

use EasyWhiteLabel\Admin\Form;
use EasyWhiteLabel\Admin\Validate;

class SettingsPage
{
    /**
     * Generates content.
     */
    public function process( array $post ): bool
    {
        if ( ! isset( $post['save_image_option'] ) ) {
            return false;
        }

        if ( ! Validate::request( 'ewl-update-settings', '_ewl_settings_nonce' ) ) {
            ewl_fail_exit();
        }

        // Save attachment ID
        if ( isset( $post['image_attachment_id'] ) ) {
            // get the image ID
            $image_attachment = absint( $post['image_attachment_id'] );

            // update the image and provide feedback
            update_option( 'wpwll_logo', $image_attachment );

            echo Form::user_feedback( 'Logo Image has been updated !!!' );

            return true;
        }

        return false;
    }

    public function render( ?string $form_title = null ): void
    {
        wp_enqueue_media();

        $wll_logo = get_option( 'wpwll_logo', 0 );

        ?><div class"wll-status">

		</div>
		<div class='logo-preview-wrapper'>
			<img id='logo-preview' src='<?php echo wp_get_attachment_url( get_option( 'wpwll_logo' ) ); ?>' width="120">
		</div>
		<hr/>
		<div id="frmwrap" >
			<form action="" method="POST"	enctype="multipart/form-data">
		    <?php
            // open table
            echo Form::table( 'open' );

			// upload file
			echo Form::upload( 'Login Logo Image', 'Choose or Upload Logo Image' );

			// image_attachment_id
			echo Form::input_hidden( 'Image Attachment Id', get_option( 'wpwll_logo', 0 ) );

			// close table
			echo Form::table( 'close' );

			// nonce_field
			wp_nonce_field( 'ewl-update-settings', '_ewl_settings_nonce' );

			// submit button
			echo Form::submit_button( 'Save Logo Image', 'primary large', 'save_image_option' );

			?>
		    </form>
		<br/>
			<?php echo wpwhitelabel()->customizer_button(); ?>
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
        <?php
    }
}

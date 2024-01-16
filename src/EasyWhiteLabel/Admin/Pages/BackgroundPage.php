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

class BackgroundPage
{
    /**
     * Generates content.
     */
    public function process( array $post ): bool
    {
        if ( ! isset( $post['submit_background_image'] ) ) {
            return false;
        }

        if ( ! Validate::request( 'ewl-update-background-img', '_ewl_background_img_nonce' ) ) {
            ewl_fail_exit();
        }

        // Save attachment ID
        if ( isset( $post['submit_background_image'] ) ) {
            // get the image ID
            $image_id = $post['image_attachment_id'] ?? 0;

            // update the image and provide feedback
            update_option( 'wpwll_background', absint( $image_id ) );

            echo Form::user_feedback( 'Background Image has been updated !!!' );

            return true;
        }

        return false;
    }

    public function render( ?string $form_title = null ): void
    {
        wp_enqueue_media();
        $wll_background = get_option( 'wpwll_background', 0 );

        ?><div class"wll-status">
			<strong>Get free Photos:</strong>
			<?php echo Form::thickboxlink( 'Free Stock Photo Sites', 'freestockphotosites' ); ?>
		</div>
		<hr/>
		<div class='image-preview-wrapper'>
			<img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'wpwll_background' ) ); ?>' width="500">
		</div>
		<hr/>
		<div id="frmwrap" >
			<form action="" method="POST"	enctype="multipart/form-data">
		    <?php
            // open table
            echo Form::table( 'open' );

			// upload file
			echo Form::upload( 'Login Background Image', 'Choose or Upload Background Image' );

			// image_attachment_id
			echo Form::input_hidden( 'Image Attachment Id', get_option( 'wpwll_background' ) );

			// close table
			echo Form::table( 'close' );

			// nonce_field
			wp_nonce_field( 'ewl-update-background-img', '_ewl_background_img_nonce' );

			// submit button
			echo Form::submit_button( 'Save Background Image', 'primary large', 'submit_background_image' );

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
		    var set_to_post_id = <?php echo $wll_background; ?>; // Set this
		    jQuery('#login_background_image').on('click', function( event ){
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
		        title: 'Select or Upload a Background Image',
		        button: {
		          text: 'Use as Background Image',
		        },
		        multiple: false	// Set to true to allow multiple files to be selected
		      });

		      // When an image is selected, run a callback.
		      file_frame.on( 'select', function() {

		        // We set multiple to false so only get one image from the uploader
		        attachment = file_frame.state().get('selection').first().toJSON();

		        // Do something with attachment.id and/or attachment.url here
		        $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', '500px' );
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
        // thickbox for free photo sites list
        wpwhitelabel()->photo_sites( 'freestockphotosites' );
    }
}

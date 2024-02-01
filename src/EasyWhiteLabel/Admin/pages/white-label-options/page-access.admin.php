<?php

use EasyWhiteLabel\Admin\Form;

if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( __( 'You are not allowed to manage options for this page.' ) );
}

?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post">
		<?php
        Form::yield_nonce( 'selective_page_access' );
		do_settings_sections( 'wll-page-access' );
		submit_button( 'Save Settings' );
		?>
	</form>
</div>
<?php

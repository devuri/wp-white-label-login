<?php

if ( ! current_user_can( 'manage_options' ) ) {
    return;
}
?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post">
		<?php
        settings_fields( 'selective_page_access' );
		do_settings_sections( 'wll-page-access' );
		submit_button( 'Save Settings' );
		?>
	</form>
</div>
<?php

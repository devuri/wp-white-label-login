<?php

// options
$get_custom_css = wpwhitelabel()->option( 'custom_css' );

/**
 * Process the data
 * TODO add a way to download/export css.
 */

?>

CSS Settings can be updated via the Customizer
<hr/>
	<br/>
<?php echo wpwhitelabel()->customizer_button(); ?>
	<br/>
<img style="width: 100%;" src="<?php echo EASYWHITELABEL_URL . '/assets/images/screenshot/screenshot-2.png'; ?>" alt="">
<div id="frmwrap" >
	<br/>
	<?php echo wpwhitelabel()->customizer_button(); ?>
</div><!--frmwrap-->

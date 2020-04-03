<?php

	// options
		$get_logo 			= $this->plugin()->option('logo');

?><div class"wll-status">
	<strong>Get Awesome free Photos:</strong> <a target="_blank" href="https://pixabay.com/photos/search/">pixabay.com</a> .
	 Give us a rating on <a target="_blank" href="https://wordpress.org/plugins/wp-white-label-login/">WordPress.org</a>.
</div>
<hr/>
<img width="200"src="<?php echo wp_get_attachment_url($get_logo); ?>" alt="">
<hr/>
<div id="frmwrap" >
	<?php echo $this->plugin()->customizer_button('Change Logo'); ?>
</div><!--frmwrap-->

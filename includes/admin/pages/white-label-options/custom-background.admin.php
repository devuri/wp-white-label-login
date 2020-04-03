<?php

	// options
		$get_background_image = $this->plugin()->option('background');

?><div class"wll-status">
	<strong>Get Awesome free Photos:</strong>
	<a target="_blank" href="https://pixabay.com/photos/search/">pixabay.com</a>
</div>
<hr/>
<img width="600"src="<?php echo wp_get_attachment_url($get_background_image); ?>" alt="">
<hr/>
<div id="frmwrap" >
	<?php echo $this->plugin()->customizer_button('Change Background'); ?>
</div><!--frmwrap-->

<?php

	// options
		$get_custom_css	= $this->plugin()->option('custom_css');

/**
 * Process the data
 * TODO add a way to download css
 */

?>

CSS Settings can be updated via the Customizer
<hr/>

<div id="frmwrap" >
	<?php echo $this->plugin()->customizer_button(); ?>
	<hr/>
	<div class"wll-css">
		<label for="input">CSS</label>
  <textarea class="form-css-text" id="wll-textarea-css" rows="10" disabled>
		<?php echo $get_custom_css ?>
  </textarea>
		</div>
</div><!--frmwrap-->

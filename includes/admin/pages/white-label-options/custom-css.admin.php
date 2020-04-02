<?php

	// options
		$get_custom_css	= $this->plugin()->option('custom_css');

/**
 * Process the data
 * TODO add a way to download css
 */

?>
<hr/>
CSS Settings can be updated via the Customizer<br/>
<div id="frmwrap" >
	<a class="button button-hero" href="<?php print(admin_url('/customize.php?autofocus[section]=white_label_login')); ?>">Use The Customizer</a>
	<hr/>
	<div class"wll-css">
		<label for="input">CSS</label>
  <textarea class="form-css-text" id="wll-textarea-css" rows="10" disabled>
		<?php echo $get_custom_css ?>
  </textarea>
		</div>
</div><!--frmwrap-->

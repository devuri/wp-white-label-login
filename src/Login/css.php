<?php

namespace WPWhiteLabel\Style;

if (! function_exists('css_options')) {
	/**
	 * css options()
	 * @return [type] [description]
	 */
	function css_options(){
		?><style type="text/css">
				body.login {
					color: <?php echo wpwhitelabel()->setting('login_text_color'); ?>;
				}
				body a {
					color: <?php echo wpwhitelabel()->setting('link_color'); ?> !important;
				}
				#login {
					background-color: <?php echo wpwhitelabel()->setting('login_container_color'); ?>;
					background-repeat: repeat-x;
					background-position: left top;
					margin-top: 8%;
					margin-right: auto;
					margin-bottom: 4%;
					padding: 26px;
				}
				.login form {
					box-shadow: 0 1px 3px #ffffff;
					border: none;
					border: none;
					margin-top: 0px;
					box-shadow: none;
					background-color: <?php echo wpwhitelabel()->setting('login_form_color'); ?> !important;
					background: <?php echo wpwhitelabel()->setting('login_form_color'); ?> !important;
					border-radius: 0px;
					opacity: 0.99;
				}
				#wp-submit, input[type="submit"] {
					transition: all 0.2s linear 0s;
					margin-top: 20px;
					background-color: <?php echo wpwhitelabel()->setting('button_background_color'); ?>;
					border-radius: 0px;
					color: <?php echo wpwhitelabel()->setting('button_text_color'); ?>;
					font-size: 18px !important;
					width: 100%;
					font-weight: normal;
					border: solid thin <?php echo wpwhitelabel()->setting('button_background_color'); ?>;
				}
			</style><?php
	}
}
// continue on with php

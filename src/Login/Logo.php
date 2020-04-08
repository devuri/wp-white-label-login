<?php

namespace WPWhiteLabel\Logo;
/**
 *
 */
class LoginLogo {

	/**
	 * logo
	 *
	 * get the logo
	 * @return string
	 */
	public static function logo(){
		echo wp_get_attachment_url(wpwhitelabel()->setting('logo'));
	}

	/**
	 * login_logo
	 *
	 * set the login screen logo
	 * @return
	 */
	public static function login_logo() {
		?><style type="text/css">
			#login h1 a, .login h1 a {
				background-image: url(<?php self::logo(); ?>);
				-webkit-background-size: 120px;
				background-position: <?php echo wpwhitelabel()->setting('logo_position') ?>;
				background-size: 120px;
				height: 120px;
				width: 100%;
			}
			</style><?php
	}
}

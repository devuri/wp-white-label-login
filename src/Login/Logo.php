<?php

namespace WPWhiteLabel\Login;
/**
 *
 */
class Logo {

	/**
	 * logo
	 *
	 * get the logo
	 * @return string
	 */
	protected static function logo(){
		echo wp_get_attachment_url(wpwhitelabel()->option('logo'));
	}

	/**
	 * login_logo
	 *
	 * set the login screen logo
	 * @return
	 */
	protected static function get_logo() {
		?><style type="text/css">
			#login h1 a, .login h1 a {
				background-image: url(<?php self::logo(); ?>);
				-webkit-background-size: 120px;
				background-position: <?php echo wpwhitelabel()->setting('logo_position') ?>;
				background-size: 120px;
				height: 120px;
				width: 100%;
				display: <?php echo wpwhitelabel()->setting('logo_display') ?>;
			}
			</style><?php
	}

	/**
	 * [logo_text description]
	 * @return [type] [description]
	 * TODO this was Introduced in WordPress 5.2.0	check wordpress version.
	 * @link https://developer.wordpress.org/reference/hooks/login_headertext/
	 */
	protected static function set_logo_text() {
			$login_header_text = get_bloginfo( 'name' );
			return $login_header_text;
	}

	/**
	 * [logo_text output
	 */
	public static function logo_text() {
			return self::set_logo_text();
	}

	/**
	 * login_logo output
	 *
	 * @return
	 */
	public static function login_logo() {
		return self::get_logo();
	}
}

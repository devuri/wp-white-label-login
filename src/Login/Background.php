<?php
namespace WPWhiteLabel\Background;

/**
 *
 */
class LoginBackground {

	/**
	 * e_background
	 *
	 * echo the background for background-image css
	 * @return string
	 * @link https://developer.wordpress.org/reference/functions/wp_get_attachment_url/
	 */
	public static function background(){
		$background_img = wp_get_attachment_url(wpwhitelabel()->setting('background_image'));
		echo $background_img;
	}
	/**
	 * Body
	 *
	 * the page body
	 * @return
	 */
	public static function body() {
		?><style type="text/css">
			body {
				background-color: <?php echo wpwhitelabel()->setting('background_color'); ?>;
				background-image: url(<?php self::background(); ?>);
				background-attachment: <?php echo wpwhitelabel()->setting('background_attachment'); ?>;
				background-size: <?php echo wpwhitelabel()->setting('background_size'); ?>;
				background-repeat: <?php echo wpwhitelabel()->setting('background_repeat'); ?>;
				background-position: <?php echo wpwhitelabel()->setting('background_position'); ?>;
			}
			</style><?php
	}
}

<?php

namespace EasyWhiteLabel\Login;

class Background
{
    /**
     * Body.
     *
     * the page body
     *
     * @return
     */
    public static function body()
    {
        return self::css();
    }

    /**
     * background.
     *
     * echo the background for background-image css
     *
     * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_url/
     */
    protected static function background(): void
    {
        $background_img = wp_get_attachment_url( wpwhitelabel()->option( 'background_image' ) );
        echo $background_img;
    }

    /**
     * Body.
     *
     * the page body
     *
     * @return
     */
    protected static function css()
    {
        ?><style type="text/css">
			body {
				background-color: <?php echo wpwhitelabel()->get_setting( 'background_color', '#ffffff' ); ?>;
				background-image: url(<?php self::background(); ?>);
				background-attachment: <?php echo wpwhitelabel()->get_setting( 'background_attachment' ); ?>;
				background-size: <?php echo wpwhitelabel()->get_setting( 'background_size', 'cover' ); ?>;
				background-repeat: <?php echo wpwhitelabel()->get_setting( 'background_repeat', 'no-repeat' ); ?>;
				background-position: <?php echo wpwhitelabel()->get_setting( 'background_position', 'left' ); ?>;
			}
			</style>
            <?php
    }
}

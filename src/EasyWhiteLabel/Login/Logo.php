<?php

namespace EasyWhiteLabel\Login;

class Logo
{
    /**
     * [logo_text output.
     */
    public static function logo_text()
    {
        return self::set_logo_text();
    }

    /**
     * login_logo output.
     *
     * @return void
     */
    public static function login_logo()
    {
        return self::get_logo();
    }

    /**
     * logo.
     *
     * get the logo
     */
    protected static function logo(): void
    {
        echo wp_get_attachment_url( wpwhitelabel()->option( 'logo' ) );
    }

    /**
     * login_logo.
     *
     * set the login screen logo
     *
     * @return
     */
    protected static function get_logo()
    {
        ?><style type="text/css">
			#login h1 a, .login h1 a {
				background-image: url(<?php self::logo(); ?>);
				-webkit-background-size: 120px;
				background-position: <?php echo wpwhitelabel()->get_setting( 'logo_position' ); ?>;
				background-size: 120px;
				height: 120px;
				width: 100%;
				display: <?php echo wpwhitelabel()->get_setting( 'logo_display' ); ?>;
			}
			</style>
            <?php
    }

    /**
     * [logo_text description].
     *
     * @return [type] [description]
     * TODO this was Introduced in WordPress 5.2.0  check WordPress version.
     *
     * @see https://developer.wordpress.org/reference/hooks/login_headertext/
     */
    protected static function set_logo_text()
    {
        return get_bloginfo( 'name' );
    }
}

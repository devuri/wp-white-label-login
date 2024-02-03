<?php

namespace EasyWhiteLabel\Login;

class Logo extends AbstractSettings
{
    public static function logo_text()
    {
        return get_bloginfo( 'name' );
    }

    /**
     * login_logo output.
     *
     * @return void
     */
    public static function login_logo(): void
    {
        $generate_css = self::init()->get_css_rules();
        echo '<style type="text/css">' . $generate_css . '</style>';
    }

    /**
     * Generates the CSS.
     *
     * @return string The CSS rules.
     */
    protected function generate_css(): ?string
    {
        $logo_image_url = wp_get_attachment_url( self::$whitelabel->option( 'logo' ) );
        $logo_position  = esc_attr( self::$whitelabel->get_setting( 'logo_position' ) );
        $logo_display   = esc_attr( self::$whitelabel->get_setting( 'logo_display' ) );

        return "
			#login h1 a, .login h1 a {
				background-image: url({$logo_image_url});
				-webkit-background-size: 120px;
				background-position: {$logo_position};
				background-size: 120px;
				height: 120px;
				width: 100%;
				display: {$logo_display};
			}
		";
    }
}

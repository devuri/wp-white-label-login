<?php

namespace EasyWhiteLabel\Login;

class Background extends AbstractSettings
{
    /**
     * Outputs the CSS for the page body background within a style tag.
     */
    public static function body_css(): void
    {
        $css = self::init()->get_css_rules();
        echo '<style type="text/css">' . $css . '</style>';
    }

    /**
     * Generates the CSS for the page body background.
     *
     * @return string The CSS rules for the body background.
     */
    protected function generate_css(): ?string
    {
        $background_img = wp_get_attachment_url( self::$whitelabel->option( 'background_image' ) );

        $background_color      = self::$whitelabel->get_setting( 'background_color', '#ffffff' );
        $background_image      = esc_url( $background_img );
        $background_attachment = self::$whitelabel->get_setting( 'background_attachment' );
        $background_size       = self::$whitelabel->get_setting( 'background_size', 'cover' );
        $background_repeat     = self::$whitelabel->get_setting( 'background_repeat', 'no-repeat' );
        $background_position   = self::$whitelabel->get_setting( 'background_position', 'left' );

        return "
			body {
				background-color: {$background_color};
				background-image: url({$background_image});
				background-attachment: {$background_attachment};
				background-size: {$background_size};
				background-repeat: {$background_repeat};
				background-position: {$background_position};
			}
		";
    }
}

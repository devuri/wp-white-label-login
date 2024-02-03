<?php

namespace EasyWhiteLabel\Login;

class Header extends AbstractSettings
{
	public static function login_header()
	{
		echo self::_header();
	}

    private static function _header()
    {
        $style = sprintf(
            'background-color: %s; color: %s;',
            esc_attr( self::$whitelabel->get_setting( 'header_background_color' ) ),
            esc_attr( self::$whitelabel->get_setting( 'header_text_color' ) )
        );

        return sprintf(
            '<div class="wrapper">
		        <div id="wll-header" class="wll-header" style="%s" align="%s">
		            <h2 align="%s">
		                <a href="%s" title="%s">%s</a>
		            </h2>
		            <div class="wll-site-description">%s</div>
		        </div>',
            $style,
            esc_attr( self::$whitelabel->get_setting( 'header_alignment' ) ),
            esc_attr( self::$whitelabel->get_setting( 'header_alignment' ) ),
            esc_url( get_bloginfo( 'url' ) ),
            esc_html( get_bloginfo( 'name' ) ),
            esc_html( self::$whitelabel->get_setting( 'header_title' ) ),
            esc_html( self::$whitelabel->get_setting( 'header_description' ) ),
        );
    }
}

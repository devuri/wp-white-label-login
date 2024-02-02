<?php

namespace EasyWhiteLabel\Login;

class Header
{
    /**
     * [header description].
     *
     * @return [type] [description]
     */
    public static function header()
    {
        return self::login_header();
    }

    /**
     * header.
     *
     * add a header section to the login page
     *
     * @return
     */
    protected static function login_header()
    {
        $header  = '<div class="wrapper">';
        $header .= '<div style="background-color: ' . wpwhitelabel()->get_setting( 'header_background_color' ) . '; color: ' . wpwhitelabel()->get_setting( 'header_text_color' ) . ';" id="wll-header" class="wll-header" ';
        $header .= 'align="' . wpwhitelabel()->get_setting( 'header_alignment' ) . '">';
        $header .= '<h2 align="' . wpwhitelabel()->get_setting( 'header_alignment' ) . '">';
        $header .= '<a  href="' . get_bloginfo( 'url' ) . '" title="' . get_bloginfo( 'name' ) . '">';
        $header .= wpwhitelabel()->get_setting( 'header_title' );
        $header .= '</a>';
        $header .= '</h2>';
        $header .= '<div class="wll-site-description">';
        $header .= wpwhitelabel()->get_setting( 'header_description' );
        $header .= '</div>';
        $header .= '</div>';
        echo $header;
    }
}

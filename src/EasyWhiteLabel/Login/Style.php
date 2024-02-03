<?php

namespace EasyWhiteLabel\Login;

class Style extends AbstractSettings
{
    /**
     * login_styles.
     *
     * enqueue the login styles, users can turn these on and off as needed
     *
     * @return
     */
    public static function login_styles()
    {
        self::enqueue_style( 'wll-header-shadow' );
        self::enqueue_style( 'wll-base' );
        self::enqueue_style( 'wll-default' );
        self::align();

        // self::enqueue_style('wll-color-scheme');

        /**
         * enable bootstrap styles.
         */
        // self::enqueue_style('wll-bootstrap');

        /**
         * $user_custom_css.
         *
         * lets add the user defined css to user stylesheet
         * wp_add_inline_style Adds the extra CSS styles.
         *
         * @var string
         *
         * @see https://developer.wordpress.org/reference/functions/wp_add_inline_style/
         */
        self::enqueue_style( 'wll-user-styles' );
        $user_custom_css = self::$whitelabel->option( 'custom_css' );
        wp_add_inline_style( 'wll-user-styles', $user_custom_css );

        /**
         * login form styles inline.
         *
         * @var [type]
         */
        wp_add_inline_style( 'wll-user-styles', self::css_output() );

        // use theme styles (users can turn this on if they want its off by default)
        // wp_enqueue_style('wll-theme-style',get_stylesheet_directory_uri() . '/style.css',array(),wp_get_theme()->get('Version') );
    }

    /**
     * Output custom CSS to the page.
     *
     * @return mixed
     */
    public static function css_output()
    {
        $custom_css = self::init()->get_css_rules();
        echo '<style type="text/css">' . $custom_css . '</style>';
    }

    /**
     * align.
     *
     * get the form alignment as set in the
     * options section
     *
     * @return
     */
    protected static function align(): ?string
    {
        $align = null;

        switch ( self::$whitelabel->get_setting( 'form_layout' ) ) {
            case 'left':
                $align = self::enqueue_style( 'wll-align-left' );

                break;
            case 'right':
                $align = self::enqueue_style( 'wll-align-right' );

                break;
            case 'center':
                $align = '';

                break;
        }

        return $align;
    }

    /**
     * enqueue_style.
     *
     * @param string $style stylesheet
     *
     * @return
     */
    protected static function enqueue_style( $style = 'wll-base' )
    {
        $wp_login_styles = [
            'wll-base'          => 'wll-base.min.css',
            'wll-bootstrap'     => 'wll-bootstrap.css',
            'wll-color-scheme'  => 'wll-color-scheme.css',
            'wll-header-shadow' => 'wll-header-shadow.css',
            'wll-default'       => 'wll-default.css',
            'wll-align-right'   => 'wll-align-right.css',
            'wll-align-left'    => 'wll-align-left.css',
            'wll-user-styles'   => 'wll-user-stylesheet.css',
        ];

        return wp_enqueue_style( $style, EASYWHITELABEL_URL . 'assets/css/' . $wp_login_styles[ $style ], [], EASYWHITELABEL_VERSION, 'all' );
    }


    /**
     * Generate custom CSS rules based on user-defined settings.
     *
     * @return string Custom CSS rules.
     */
    protected function generate_css(): ?string
    {
        $login_text_color        = self::$whitelabel->get_setting( 'login_text_color' );
        $link_color              = self::$whitelabel->get_setting( 'link_color' );
        $login_container_color   = self::$whitelabel->get_setting( 'login_container_color' );
        $login_form_color        = self::$whitelabel->get_setting( 'login_form_color' );
        $button_background_color = self::$whitelabel->get_setting( 'button_background_color' );
        $button_text_color       = self::$whitelabel->get_setting( 'button_text_color' );

        return "
            body.login {
                color: {$login_text_color};
            }
            body a {
                color: {$link_color} !important;
            }
            #login {
                background-color: {$login_container_color};
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
                margin-top: 0px;
                box-shadow: none;
                background-color: {$login_form_color} !important;
                background: {$login_form_color} !important;
                border-radius: 0px;
                opacity: 0.99;
            }
            #wp-submit, input[type='submit'] {
                transition: all 0.2s linear 0s;
                margin-top: 20px;
                background-color: {$button_background_color};
                border-radius: 0px;
                color: {$button_text_color};
                font-weight: normal;
                border: solid thin {$button_background_color};
            }
        ";
    }
}

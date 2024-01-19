<?php

namespace EasyWhiteLabel\Login;

class Style
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
        $user_custom_css = wpwhitelabel()->option( 'custom_css' );
        wp_add_inline_style( 'wll-user-styles', $user_custom_css );

        /**
         * login form styles inline.
         *
         * @var [type]
         */
        wp_add_inline_style( 'wll-user-styles', self::css() );

        // use theme styles (users can turn this on if they want its off by default)
        // wp_enqueue_style('wll-theme-style',get_stylesheet_directory_uri() . '/style.css',array(),wp_get_theme()->get('Version') );
    }

    /**
     * align.
     *
     * get the form alignment as set in the
     * options section
     *
     * @return
     */
    protected static function align()
    {
        $align = null;

        switch ( wpwhitelabel()->setting( 'form_layout' ) ) {
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
     * css().
     *
     * Load up the user defined css rules
     *
     * @return [type] [description]
     */
    protected static function css()
    {
        ?><style type="text/css">
  			body.login {
  				color: <?php echo wpwhitelabel()->setting( 'login_text_color' ); ?>;
  			}
  			body a {
  				color: <?php echo wpwhitelabel()->setting( 'link_color' ); ?> !important;
  			}
  			#login {
  				background-color: <?php echo wpwhitelabel()->setting( 'login_container_color' ); ?>;
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
  				border: none;
  				margin-top: 0px;
  				box-shadow: none;
  				background-color: <?php echo wpwhitelabel()->setting( 'login_form_color' ); ?> !important;
  				background: <?php echo wpwhitelabel()->setting( 'login_form_color' ); ?> !important;
  				border-radius: 0px;
  				opacity: 0.99;
  			}
  			#wp-submit, input[type="submit"] {
  				transition: all 0.2s linear 0s;
  				margin-top: 20px;
  				background-color: <?php echo wpwhitelabel()->setting( 'button_background_color' ); ?>;
  				border-radius: 0px;
  				color: <?php echo wpwhitelabel()->setting( 'button_text_color' ); ?>;
  				font-weight: normal;
  				border: solid thin <?php echo wpwhitelabel()->setting( 'button_background_color' ); ?>;
  			}
  		</style>
        <?php
    }
}

<?php

namespace WPWhiteLabel\Style;
/**
 *
 */
class LoginStyle {

	/**
   * align
   *
   * get the form alignment as set in the
   * options section
   * @return
   */
  public static function align(){
    switch (wpwhitelabel()->setting('form_layout')) {
    case 'left':
        $align = self::enqueue_style('wll-align-left');
        break;
    case 'right':
        $align = self::enqueue_style('wll-align-right');
        break;
    case 'center':
        $align = '';
        break;
    }
    return $align;
  }

  public static function login_form(){
    ?><style type="text/css">
        #login {
        background-color: white;
        }
        /*** LOGIN FORM ***************************/
        .login form {
          box-shadow: 0 1px 3px #ffffff;
          border: none;
          border: none;
        	margin-top: 0px;
          box-shadow: none;
          background-color: <?php echo wpwhitelabel()->setting('form_background_color'); ?>;
          border-radius: 0px;
          background: none;
          opacity: 0.99;
        }
    </style>
  <?php }

  /**
   * styles for the submit button
   * @return [type] [description]
   */
  public static function submit_button(){
    ?><style type="text/css">
      #wp-submit, input[type="submit"] {
        transition: all 0.2s linear 0s;
        margin-top: 20px;
        background-color: <?php echo wpwhitelabel()->setting('button_background_color'); ?>;
        border-radius: 0px;
        color: <?php echo wpwhitelabel()->setting('button_text_color'); ?>;
        font-size: 18px !important;
        width: 100%;
        font-weight: normal;
        border: solid thin <?php echo wpwhitelabel()->setting('button_background_color'); ?>;
      }
    </style><?php
  }

	/**
	 * enqueue_style
	 * @param  string $style stylesheet
	 * @return
	 */
	public static function enqueue_style($style = 'wll-base'){
		$wp_login_styles = array(
			'wll-base'              => 'wll-base.css',
			'wll-bootstrap'         => 'wll-bootstrap.css',
			'wll-color-scheme'      => 'wll-color-scheme.css',
			'wll-header-shadow'     => 'wll-header-shadow.css',
			'wll-default'           => 'wll-default.css',
			'wll-align-right'       => 'wll-align-right.css',
			'wll-align-left'        => 'wll-align-left.css',
			'wll-user-styles'       => 'wll-user-stylesheet.css',
		);
		return wp_enqueue_style( $style, WPWLL_URL . 'assets/css/'.$wp_login_styles[$style], array(), WPWLL_VERSION, 'all' );
	}

	/**
   * login_styles
   *
   * enqueue the login styles, users can turn these on and off as needed
   * @return
   */
	public static function login_styles(){
		self::enqueue_style('wll-header-shadow');
		self::enqueue_style('wll-base');
		self::enqueue_style('wll-default');
    self::align();

		//self::enqueue_style('wll-color-scheme');

    /**
     * enable bootstrap styles
     */
		//self::enqueue_style('wll-bootstrap');

    /**
     * login form styles inline
     * @var [type]
     */
    wp_add_inline_style( 'wll-user-styles', self::login_form() );

		/**
		 * $user_custom_css
		 *
		 * lets add the user defined css to user stylesheet
		 * wp_add_inline_style Adds the extra CSS styles.
		 * @var string
		 * @link https://developer.wordpress.org/reference/functions/wp_add_inline_style/
		 */
		self::enqueue_style('wll-user-styles');
		$user_custom_css = wpwhitelabel()->option('custom_css');
		wp_add_inline_style( 'wll-user-styles', $user_custom_css );

    /**
     * login button
     */
    wp_add_inline_style( 'wll-user-styles', self::submit_button() );

		// use theme styles (users can turn this on if they want its off by default)
		//wp_enqueue_style('wll-theme-style',get_stylesheet_directory_uri() . '/style.css',array(),wp_get_theme()->get('Version') );

	}
}

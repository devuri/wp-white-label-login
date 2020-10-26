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
  protected static function align(){
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

	/**
	 * enqueue_style
	 * @param  string $style stylesheet
	 * @return
	 */
	protected static function enqueue_style($style = 'wll-base'){
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
   * css()
   *
   * Load up the user defined css rules
   * with the css_options() function in css.php
   * @return [type] [description]
   */
  protected static function css(){
    return css_options();
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
     * login form styles inline
     * @var [type]
     */
    wp_add_inline_style( 'wll-user-styles', self::css() );

		// use theme styles (users can turn this on if they want its off by default)
		//wp_enqueue_style('wll-theme-style',get_stylesheet_directory_uri() . '/style.css',array(),wp_get_theme()->get('Version') );


	}
}

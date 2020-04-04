<?php

/**
 * Main class White_Label_Login
 */
final class WhiteLabel {

  /**
   * $on
   *
   * check whether this is turned on or off
   * @var boolean
   */
  public $on;

  /**
   * [__construct description]
   * @param boolean $init on or off
   */
  function __construct( $init = false){

    /**
     * check if the plugin
     * is on or off
     * @var [type]
     */
    $this->on = $init;

    /**
     * if the plugin is on lets make the login pretty
     * @var [type]
     */
    if ($this->on) {
      $this->init();
    }
  }

  /**
   * white_label_login()
   *
   * start up and make the login pretty
   * return status
   * @return boolean
   */
  public function init(){
    add_action( 'admin_menu', array( $this , 'appearance_submenu') );
    add_action( 'login_enqueue_scripts', array( $this , 'login_styles') );
    add_action( 'login_enqueue_scripts', array( $this , 'login_logo') );
    add_filter( 'login_headerurl', array( $this , 'logo_link') );
    add_filter( 'login_head', array( $this , 'header') );
    add_filter( 'login_head', array( $this , 'body') );
    add_filter( 'login_footer', array( $this , 'footer') );

    /**
     * Load up the Customizer
     * lets load up the customizer stuff here
     */
    require_once WPWLL_DIR . '/src/Customizer/WhiteLabelCustomizer.php';
  }

  /**
   * wp_slug
   *
   * WordPress.org repo slug
   * @return [type] [description]
   */
  public function wp_slug(){
    $wpslug = 'wp-white-label-login';
    return $wpslug;
  }


  /**
   * Appearance submenu
   *
   * Lets add a submenu for the Customizer
   * @return [type] [description]
   */
  public function appearance_submenu() {
    add_submenu_page(
      'themes.php',
          __( 'White Label Login Customizer', 'wp-white-label-login' ),
          __( 'White Label Login', 'wp-white-label-login' ),
          'manage_options',
          '/customize.php?url='.urlencode(home_url('/wp-login.php'))
      );
  }

  /**
   * customizer_button()
   *
   * quick link to the customizer
   * @return string
   */
  public function customizer_button($cbutton_text = 'Use The Customizer'){
    // render button
    $customizer_button  = '<a class="button button-hero"';
    $customizer_button .= 'href="'.admin_url('/customize.php?url='.urlencode(home_url('/wp-login.php'))).'">';
    $customizer_button .= $cbutton_text;
    $customizer_button .= '</a>';
    return $customizer_button;
   }

  /**
   * enqueue_style
   * @param  string $style stylesheet
   * @return
   */
  public function enqueue_style($style = 'wll-base'){
    $wp_login_styles = array(
      'wll-base'              => 'wll-base.css',
      'wll-loginform-background'  => 'wll-loginform-background.css',
      'wll-login-background'  => 'wll-login-background.css',
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
  public function login_styles() {
    $this->enqueue_style('wll-header-shadow');
    $this->enqueue_style('wll-base');
    $this->enqueue_style('wll-default');
    $this->align();
    //$this->enqueue_style('wll-loginform-background');
	  $this->enqueue_style('wll-login-background');
	  //$this->enqueue_style('wll-color-scheme');
	  //$this->enqueue_style('wll-bootstrap');


    /**
     * $user_custom_css
     *
     * lets add the user defined css to user stylesheet
     * wp_add_inline_style Adds the extra CSS styles.
     * @var string
     * @link https://developer.wordpress.org/reference/functions/wp_add_inline_style/
     */
    $this->enqueue_style('wll-user-styles');
    $user_custom_css = $this->option('custom_css');
    wp_add_inline_style( 'wll-user-styles', $user_custom_css );

    // use theme styles (users can turn this on if they want its off by default)
    // wp_enqueue_style('wll-theme-style',get_stylesheet_directory_uri() . '/style.css',array(),wp_get_theme()->get('Version') );
  }

  /**
   * align
   *
   * get the form alignment as set in the
   * options section
   * @return
   */
  public function align(){
    switch ($this->setting('form_layout')) {
    case 'left':
        $align = $this->enqueue_style('wll-align-left');
        break;
    case 'right':
        $align = $this->enqueue_style('wll-align-right');
        break;
    case 'center':
        $align = '';
        break;
    }
    return $align;
  }

  /**
   * Options
   *
   * setup some the options array
   * @param  string $opt
   * @return string
   */
  public function option($opt = 'logo'){
    $option = array(
      'wpwll_options' => get_option('wpwll_options'),
      'custom_css'    => get_option('wpwll_custom_css')
    );
    return $option[$opt];
  }

  /**
   * settings
   *
   * setup some the options array
   * @param  string $opt
   * @return string
   */
  public function setting($set = 'background'){
    $setting = $this->option('wpwll_options');
    return $setting[$set];
  }

  /**
   * site_info
   *
   * setup some site specific vars
   * @param  string $info
   * @return string
   */
  public function site_info($info = 'name'){
    $site_info = array(
      'name' => get_bloginfo( 'name' ),
      'url' => get_bloginfo( 'url' ),
      'admin_url' => get_admin_url(),
      'background_color' => 'none',
      'header_text' => get_bloginfo( 'description' ),
      'footer_text' => '...',
    );
    return $site_info[$info];
  }

  /**
   * header
   *
   * add a header section to the login page
   * @return
   */
  public function header() {
    $header  = '<div id="wll-header" class="wll-header" align="center">';
    $header .= '<h2 align="center">';
    $header .= '<a  href="'.$this->site_info('url').'" title="'.$this->site_info('name').'">';
    $header .= $this->site_info('name');
    $header .= '</a>';
    $header .= '</h2>';
    $header .= '<div class="wll-site-description">';
    $header .= $this->site_info('header_text');
    $header .= '</div>';
    $header .= '</div>';
  	echo $header;
  }

  /**
   * e_background
   *
   * Output the CSS property
   * @return string
   */
  public function print_css( $property='background_repeat' ){
    $css = $this->setting('background_repeat');
    echo $css;
  }

  /**
   * e_background
   *
   * echo the background for background-image css
   * @return string
   * @link https://developer.wordpress.org/reference/functions/wp_get_attachment_url/
   */
  public function e_background(){
    $background_img = wp_get_attachment_url($this->setting('background_image'));
    echo $background_img;
  }
  /**
   * Body
   *
   * the page body
   * @return
   */
  public function body() {
    ?><style type="text/css">
      body {
        background-color: <?php echo $this->setting('background_color'); ?>;
        background-image: url(<?php $this->e_background(); ?>);
        background-attachment: <?php echo $this->setting('background_attachment'); ?>;
        background-size: <?php echo $this->setting('background_size'); ?>;
        background-repeat: <?php echo $this->setting('background_repeat'); ?>;
        background-position: <?php echo $this->setting('background_position'); ?>;
      }
      </style><?php
  }

  /**
   * logo
   *
   * get the logo
   * @return string
   */
  public function logo(){
    echo wp_get_attachment_url($this->setting('logo'));
  }

  /**
   * logo_link
   *
   * change the login link to site url
   * @return string
   */
  function logo_link() {
    return $this->site_info('url');
  }

  /**
   * login_logo
   *
   * set the login screen logo
   * @return
   */
  public function login_logo() {
    ?><style type="text/css">
      #login h1 a, .login h1 a {
        background-image: url(<?php $this->logo(); ?>);
      }
      </style><?php
  }


  /**
   * footer
   *
   * add footer section to the login page
   * @return string
   */
  public function footer() {
  	$year = date("Y");

    //$footer  = '<br/><br/> </div>';
    $footer  = '<div id="footer" class="footer-copyright" align="center">';
    $footer .= '<p class="footer_text">';
    $footer .= $this->site_info('footer_text');
    $footer .= '</p>';
    $footer .= 'Copyright © '.$year.' <a href=" '.$this->site_info('url').' ">';
    $footer .= $this->site_info('name');
    $footer .= '</a> ';
    $footer .= '<span class="wll-footer-copyright-text"> ';
    $footer .= $this->setting('copyright_text');
    $footer .= '</span> ';
    $footer .= '</div> ';
  	echo $footer;
  }

}

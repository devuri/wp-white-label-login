<?php

namespace WPWhiteLabel;

use WPWhiteLabel\Style\LoginStyle;
use WPWhiteLabel\Header\LoginHeader;
use WPWhiteLabel\Logo\LoginLogo;
use WPWhiteLabel\Background\LoginBackground;
use WPWhiteLabel\Footer\LoginFooter;
use WPWhiteLabel\Customize\Customizer;

/**
 * Main class White_Label_Login
 */
final class WhiteLabel {

  /**
   * $enable
   *
   * check whether this is turned on or off
   * @var boolean
   */
  public $enable;

  /**
   * $instance
   *
   * setup WPWhiteLabel
   * @var object
   */
  private static $instance;

  /**
   * [instance description]
   * @param  boolean $init active
   * @return object
   */
  public static function instance($init = false) {

    if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPWhiteLabel ) ) {

      self::$instance = new WhiteLabel();
      self::$instance->load_textdomain();
      self::$instance->includes();

      /**
       * check if the plugin is on or off
       * @var [type]
       */
      self::$instance->enable = $init;

      /**
       * if the plugin is on lets make the login pretty
       * @var [type]
       */
      if (self::$instance->enable) {
        self::$instance->init();
      }

      add_action( 'plugins_loaded', array( self::$instance, 'objects' ), 10 );

    }
    return self::$instance;
  }

  /**
   * Loads the plugin language files.
   *
   * @since 1.0.0
   */
  public function load_textdomain() {

    load_plugin_textdomain( 'wp-white-label-login', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
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
    add_action( 'login_enqueue_scripts', array( LoginStyle::class, 'login_styles' ) );
    add_action( 'login_enqueue_scripts', array( LoginLogo::class, 'login_logo') );
    add_filter( 'login_head', array( LoginHeader::class, 'header') );
    add_filter( 'login_head', array( LoginBackground::class, 'body') );
    add_filter( 'login_footer', array( LoginFooter::class, 'footer') );
    add_filter( 'login_headerurl', array( $this , 'logo_link') );
  }



  /**
	 * Include files.
	 *
	 * @since 1.0.0
	 */
	private function includes() {

		// includes
		require_once WPWLL_DIR . '/src/Login/Style.php';
		require_once WPWLL_DIR . '/src/Login/Header.php';
		require_once WPWLL_DIR . '/src/Login/Logo.php';
		require_once WPWLL_DIR . '/src/Login/Background.php';
		require_once WPWLL_DIR . '/src/Login/Footer.php';
		require_once WPWLL_DIR . '/src/Customize/Section.php';
		require_once WPWLL_DIR . '/src/Customize/helpers.php';
		require_once WPWLL_DIR . '/src/Customize/Customizer.php';

		// Admin/Dashboard stuff
		if ( is_admin() ) {
			require_once WPWLL_DIR . '/src/Admin/AdminMenu.php';
			require_once WPWLL_DIR . '/src/Admin/Form/FormHelper.php';
			require_once WPWLL_DIR . '/src/Admin/Menu.php';
		}
	}

  /**
   * Setup objects.
   *
   * @since 1.0.0
   */
  public function objects() {

    // objects
    $this->customizer = new Customizer(self::$instance);

    // ok sparky everything seems to be loaded
    do_action( 'wpwhitelabel_loaded' );
  }

  /**
   * wp_slug
   *
   * WordPress.org repo slug
   * @return [type] [description]
   */
  public function slug(){
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
   * setup some the options array to get a specific setting
   * @param  string $set
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
    );
    return $site_info[$info];
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

}
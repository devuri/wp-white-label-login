<?php
/**
 * Plugin Name: White Label Login
 * Plugin URI:  https://switchwebdev.com/wordpress-plugins/
 * Description: Simple one click, White Label Log in, Registration and Lost Password Page, Activate it and forget it...
 * Author:      SwitchWebdev.com
 * Author URI:  https://switchwebdev.com
 * Version:     4.3.3
 * License:     GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wp-white-label-login
 * Domain Path: languages
 * Usage:
 * Tags:
 *
 * Requires PHP: 5.4+
 * Tested up to PHP: 7.0
 *
 * Copyright 2018 - 2020 Uriel Wilson, support@switchwebdev.com
 * License: GNU General Public License
 * GPLv2 Full license details in license.txt
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 * ----------------------------------------------------------------------------
 * @category  	Plugin
 * @copyright 	Copyright © 2018 Uriel Wilson.
 * @package   	WhiteLabelLogin
 * @author    	Uriel Wilson
 * @link      	https://switchwebdev.com
 *  ----------------------------------------------------------------------------
 */

  # deny direct access
    if ( ! defined( 'WPINC' ) ) {
      die;
    }

  # plugin directory
	  define("WPWLL_VERSION", '4.3.3');

  # plugin directory
    define("WPWLL_DIR", dirname(__FILE__));

  # plugin url
    define("WPWLL_URL", plugins_url( "/",__FILE__ ));
#  -----------------------------------------------------------------------------

	//Activate
	register_activation_hook( __FILE__, 'wpwll_activation' );
	function wpwll_activation() {


		$wpwll_default_logo = plugins_url('images/wpwll-logo.png', __FILE__ );
		$wpwll_default_background = plugins_url('images/wpwll-background.jpeg', __FILE__ );

	// set up some options
		update_option('wpwll_logo_url', '');
		update_option('wpwll_background_url','');

	}

	// Deactivate
	register_deactivation_hook( __FILE__, 'wpwll_deactivation' );
	function wpwll_deactivation() {
		delete_option('wpwll_logo_url');
		delete_option('wpwll_background_url');
	}

/**
 * Main class White_Label_Login
 */
final class White_Label_Login {

  /**
   * __construct
   *
   * do some setting up on initiate
   */
  function __construct(){
    add_action( 'login_enqueue_scripts', array( $this , 'login_styles') );
    add_action( 'login_enqueue_scripts', array( $this , 'login_logo') );
    add_filter( 'login_headerurl', array( $this , 'logo_link') );
    add_filter( 'login_head', array( $this , 'header') );
    add_filter( 'login_footer', array( $this , 'footer') );
  }

  /**
   * enqueue_style
   * @param  string $style stylesheet
   * @return
   */
  public function enqueue_style($style = 'wll-base'){
    $wp_login_styles = array(
      'wll-base'          => 'wll-login-base.css',
      'wll-background'    => 'wll-login-box-bg.css',
      'wll-bootstrap'     => 'login-bootstrap.css',
      'wll-header-shadow' => 'wll-header-box-shadow.css',
      'wll-default'       => 'wll-login-default.css',
      'wll-align-right'   => 'wll-align-right.css',
      'wll-align-left'    => 'wll-align-left.css',
      'wll-user-styles'   => 'wll-user-stylesheet.css',
    );
    return wp_enqueue_style( $style, plugins_url('css/'.$wp_login_styles[$style], __FILE__ ), array(), WPWLL_VERSION, 'all' );
  }

  /**
   * login_styles
   *
   * enqueue the login styles, users can turn these on and off as needed
   * @return
   */
  public function login_styles() {
    //$this->enqueue_style('wll-header-shadow');
    $this->enqueue_style('wll-base');
    $this->enqueue_style('wll-default');
    $this->enqueue_style('wll-align-right');
    //$this->enqueue_style('wll-align-left');
	  $this->enqueue_style('wll-background');
	  //$this->enqueue_style('wll-bootstrap');
	  //$this->enqueue_style('wll-user-styles');

    // use theme styles (users can turn this on if they want its off by default)
    // wp_enqueue_style('wll-theme-style',get_stylesheet_directory_uri() . '/style.css',array(),wp_get_theme()->get('Version') );
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
      'logo'       => get_option('wpwll_logo_url'),
      'background' => get_option('wpwll_background_url'),
      'align'      => get_option('wpwll_align')
    );
    return $option[$opt];
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
    $header  = '<div class="wll-header" align="center">';
    $header .= '<h2 align="center">';
    $header .= '<a  href="'.$this->site_info('url').'" title="'.$this->site_info('name').'">';
    $header .= $this->site_info('name');
    $header .= '</a></h2>';
    $header .= $this->site_info('header_text');
    $header .= '</div>';
    $header .= '<div style="background-repeat: no-repeat; background-color: '.$this->site_info('background_color').'; background-position: center; background-size: 100%; background-image: url('.$this->option('background').');">';
    $header .= '<br/>';
  	echo $header;
  }

  /**
   * logo
   *
   * get the logo
   * @return string
   */
  public function logo(){
    echo $this->option('logo');
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

    $footer  = '<br/><br/> </div>';
    $footer .= '<p class="footer-copyright" align="center">';
    $footer .= '<br/>';
    $footer .= $this->site_info('footer_text');
    $footer .= '<br/><br/>';
    $footer .= 'Copyright © '.$year.' <a href=" '.$this->site_info('url').' ">';
    $footer .= $this->site_info('name');
    $footer .= '</a>';
    $footer .= ' All Rights Reserved. ';
    $footer .= '<br/>';
    $footer .= '<br/></p> ';
  	echo $footer;
  }

}


// initiate --------------------------------------------------------
  $wll = new White_Label_Login();
// initiate --------------------------------------------------------


// Setup the menu builder class
if (!class_exists('Wll_Admin_Menu')) {
  require_once plugin_dir_path( __FILE__ ). 'includes/admin/class-wll-admin-menu.php';
 }

 // Form Class
 if (!class_exists('Wll_Form_Helper')) {
   require_once plugin_dir_path( __FILE__ ). 'includes/admin/class-wll-form-helper.php';
  }

// Menu Item
require_once plugin_dir_path( __FILE__ ). 'includes/admin/menu/wll.php';

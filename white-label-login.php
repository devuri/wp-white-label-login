<?php
/**
 * Plugin Name: White Label Login
 * Plugin URI:  https://switchwebdev.com/wordpress-plugins/
 * Description: White Label Login, Custom Login Page, Registration and Lost Password Page, Activate it and forget it...
 * Author:      SwitchWebdev.com
 * Author URI:  https://switchwebdev.com
 * Version:     5.4.1
 * License:     GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wp-white-label-login
 * Domain Path: languages
 * Usage:
 * Tags:
 *
 * Requires PHP: 5.6+
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
 * @copyright 	Copyright © 2020 Uriel Wilson.
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
	  define("WPWLL_VERSION", '5.4.1');

  # plugin directory
    define("WPWLL_DIR", dirname(__FILE__));

  # plugin url
    define("WPWLL_URL", plugins_url( "/",__FILE__ ));
#  -----------------------------------------------------------------------------

	//Activate
	register_activation_hook( __FILE__, 'wpwll_activation' );
	function wpwll_activation() {
	   /**
      * $wpwlldefauts load some defauts
      * @var array
      */
	   $wpwlldefauts = array(
       'form_layout' => 'center',
       // header
       'header_title' => get_bloginfo('name'),
       'header_description' => get_bloginfo('description'),
       'header_text_color' => '#737373',
       'header_background_color' => '#ffffff',
       'header_alignment' => 'center',
       //logo
       'logo_display' => 'none',
       'logo_position' => 'center',
       //login
       'login_text_color' => '#444444',
       'login_container_color' => '#ffffff',
       //form
       'login_form_color' => '#ffffff',
       //button
       'button_text_color' => '#ffffff',
       'button_background_color' => '#007cba',
       //links
       'link_color' => '#474748',
       //background
       'background_color' => '#ffffff',
       'background_attachment' => 'fixed',
       'background_repeat' => 'no-repeat',
       'background_position' => 'bottom',
       //menu
       'footer_nav' => false,
       'footer_nav_backgorund' => '#dadada',
       'footer_nav_alignment' => 'center',
       // footer
       'footer_text' => '...',
       'copyright_text' => 'All Rights Reserved',
       'footer_text_color' => '#747474',
       'footer_alignment' => 'center',
     );
		update_option('wpwll_options', $wpwlldefauts );
		update_option('wpwll_background', '0' );
		update_option('wpwll_logo', '0' );
		update_option('wpwll_custom_css', '' );
    // TODO redirect to a welcome admin page
	}

	// Deactivate
	// TODO setup an option for uninstall (delete options or keep them)
	// TODO ask the user before we delete these values
	register_deactivation_hook( __FILE__, 'wpwll_deactivation' );
	function wpwll_deactivation() {
		// moved to uninstall.php
	}

  /**
   * require_once // Load the WhiteLabel class.
   * @var [type]
   */
  require_once WPWLL_DIR . '/src/WhiteLabel.php';


  if (! function_exists('wpwhitelabel')) {
    /**
     * wpwhitelabel()
     *
     * we can turn the login style on and off here
     * @param  boolean $enable
     * @return object
     */
    function wpwhitelabel( $enabled = true ) {
      // new up wll object
      return WPWhiteLabel\WhiteLabel::instance($enabled);
    }
  }
// initiate --------------------------------------------------------
  wpwhitelabel();
// initiate --------------------------------------------------------

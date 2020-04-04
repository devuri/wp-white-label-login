<?php
/**
 * Plugin Name: White Label Login
 * Plugin URI:  https://switchwebdev.com/wordpress-plugins/
 * Description: White Label Login, Custom Login Page, Registration and Lost Password Page, Activate it and forget it...
 * Author:      SwitchWebdev.com
 * Author URI:  https://switchwebdev.com
 * Version:     5.1.1
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
	  define("WPWLL_VERSION", '5.0.1');

  # plugin directory
    define("WPWLL_DIR", dirname(__FILE__));

  # plugin url
    define("WPWLL_URL", plugins_url( "/",__FILE__ ));
#  -----------------------------------------------------------------------------

	//Activate
	register_activation_hook( __FILE__, 'wpwll_activation' );
	function wpwll_activation() {
	   // set up some options
	   $wpwlldefauts = array(
       'logo' => '0',
       'background_image' => '0',
       'form_layout' => 'center',
       'copyright_text' => 'All Rights Reserved',
       'background_attachment' => 'fixed',
       'background_repeat' => 'no-repeat',
       'background_position' => 'bottom',
       'background_color' => '#ffffff'
     );
		update_option('wpwll_options', $wpwlldefauts );
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


  // Load the WhiteLabel class.
  require_once WPWLL_DIR . '/src/WhiteLabel.php';

// initiate --------------------------------------------------------
   $wll = new WhiteLabel(true);
   $wll_customizer = new WhiteLabelCustomizer($wll);
// initiate --------------------------------------------------------


// Setup the menu builder class
if (!class_exists('AdminMenu')) {
  require_once plugin_dir_path( __FILE__ ). 'src/Admin/AdminMenu.php';
 }

 // Form Class
 if (!class_exists('FormHelper')) {
   require_once plugin_dir_path( __FILE__ ). 'src/Admin/Form/FormHelper.php';
  }

// Menu Item
require_once plugin_dir_path( __FILE__ ). 'src/Admin/Menu.php';

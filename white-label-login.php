<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Easy White Label
 * Plugin URI:        https://wpbrisko.com/wordpress-plugins/
 * Description:       White Label Login, Custom Login Page, Registration and Lost Password Page, Activate it and forget it...
 * Version:           7.2.1
 * Requires at least: 3.4
 * Requires PHP:      7.4
 * Author:            wpbrisko.com
 * Author URI:        https://wpbrisko.com/
 * Text Domain:       wp-white-label-login
 * Domain Path:       /languages
 * License:           GPLv2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// start plugin.
if ( ! \defined( 'ABSPATH' ) ) {
    exit;
}

// plugin directory
\define( 'EASYWHITELABEL_VERSION', '7.2.1' );

// plugin directory
\define( 'EASYWHITELABEL_DIR', \dirname( __FILE__ ) );

// plugin url
\define( 'EASYWHITELABEL_URL', plugins_url( '/', __FILE__ ) );

// Setup access to the plugin dir path.
\define( 'EASYWHITELABEL_DIR_PATH', plugin_dir_path( __FILE__ ) );

// Load composer.
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// Activate
register_activation_hook(
    __FILE__,
    function(): void {
        EasyWhiteLabel\Activate::init();

        if ( ! wp_next_scheduled( 'ewl_update_plugins_list' ) ) {
            wp_schedule_event( time(), 'twicedaily', 'ewl_update_plugins_list' );
        }
    }
);

// Deactivation
register_deactivation_hook(
    __FILE__,
    function(): void {
        $update_plugins_timestamp = wp_next_scheduled( 'ewl_update_plugins_list' );

        if ( $update_plugins_timestamp ) {
            wp_unschedule_event( $update_plugins_timestamp, 'ewl_update_plugins_list' );
        }
    }
);

// The plugin.
EasyWhiteLabel\Plugin::init()->hooks();

// run events.
EasyWhiteLabel\DailyTask::init()->scheduled();

<?php
/**
 * This file is part of the Easy White Label WordPress PLugin.
 *
 * (c) Uriel Wilson <hello@urielwilson.com>
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel\Lib;

use Plugin_Upgrader;
use WP_Ajax_Upgrader_Skin;

/**
 * Connekt_Plugin_Installer.
 *
 * @author   Darren Cooney
 *
 * @see     https://github.com/dcooney/wordpress-plugin-installer
 * @see     https://connekthq.com
 *
 * @version  1.0
 */
class ConnektInstaller
{
    /*
    * init
    * Initialize the display of the plugins.
    *
    *
    * @param $plugin            Array - plugin data
    *
    * @since 1.0
    */
    public static function init( $plugins ): void
    { ?>

	  <div class="cnkt-plugin-installer">
		<?php

        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

        foreach ( $plugins as $plugin ) {
            $button_classes = 'install button';
            $button_text    = __( 'Install Now', 'framework' );

            $api = plugins_api(
                'plugin_information',
                [
                    'slug'   => sanitize_file_name( $plugin['slug'] ),
                    'fields' => [
                        'short_description' => true,
                        'sections'          => false,
                        'requires'          => false,
                        'downloaded'        => true,
                        'last_updated'      => false,
                        'added'             => false,
                        'tags'              => false,
                        'compatibility'     => false,
                        'homepage'          => false,
                        'donate_link'       => false,
                        'icons'             => true,
                        'banners'           => true,
                    ],
                ]
            );

            if ( ! is_wp_error( $api ) ) {
                // confirm error free
                $main_plugin_file = self::get_plugin_file( $plugin['slug'] );
                // Get main plugin file
                // echo $main_plugin_file;
                if ( self::check_file_extension( $main_plugin_file ) ) {
                    // check file extension
                    if ( is_plugin_active( $main_plugin_file ) ) {
                        // plugin activation, confirmed!
                        $button_classes = 'button disabled';
                        $button_text    = __( 'Activated', 'framework' );
                    } else {
                        // It's installed, let's activate it
                        $button_classes = 'activate button button-primary';
                        $button_text    = __( 'Activate', 'framework' );
                    }
                }

                // Send plugin data to template
                self::render_template( $plugin, $api, $button_text, $button_classes );
            }// end if
        }// end foreach
        ?>
	  </div>
		<?php
    }

    /*
    * render_template
    * Render display template for each plugin.
    *
    *
    * @param $plugin            Array - Original data passed to init()
    * @param $api               Array - Results from plugins_api
    * @param $button_text       String - text for the button
    * @param $button_classes    String - classnames for the button
    *
    * @since 1.0
    */
    public static function render_template( $plugin, $api, $button_text, $button_classes ): void
    {
        ?>
	  <div class="plugin">
		   <div class="plugin-wrap">
			   <img src="<?php echo $api->icons['1x']; ?>" alt="">
			<h2><?php echo $api->name; ?></h2>
			<p><?php echo $api->short_description; ?></p>

			<p class="plugin-author"><?php _e( 'By', 'framework' ); ?> <?php echo $api->author; ?></p>
			</div>
			<ul class="activation-row">
			<li>
			   <a class="<?php echo $button_classes; ?>"
				 data-slug="<?php echo $api->slug; ?>"
							 data-name="<?php echo $api->name; ?>"
								 href="<?php echo get_admin_url(); ?>/update.php?action=install-plugin&amp;plugin=<?php echo $api->slug; ?>&amp;_wpnonce=<?php echo wp_create_nonce( 'install-plugin_' . $api->slug ); ?>">
						 <?php echo $button_text; ?>
			   </a>
			</li>
			<li>
			   <a href="https://wordpress.org/plugins/<?php echo $api->slug; ?>/" target="_blank">
				  <?php _e( 'More Details', 'wp-white-label-login' ); ?>
			   </a>
			</li>
		 </ul>
		</div>
		<?php
    }

    /*
    * An Ajax method for installing plugin.
    *
    * @return $json
    *
    * @since 1.0
    */
    public static function plugin_installer(): void
    {
        if ( ! current_user_can( 'install_plugins' ) ) {
            wp_die( __( 'Sorry, you are not allowed to install plugins on this site.', 'framework' ) );
        }

        $nonce  = self::get_sanitized( 'nonce' );
        $plugin = self::get_sanitized( 'plugin' );

        // Check our nonce, if they don't match then bounce!
        if ( ! wp_verify_nonce( $nonce, 'cnkt_installer_nonce' ) ) {
            wp_die( __( 'Error - unable to verify nonce, please try again.', 'framework' ) );
        }

        // Include required libs for installation
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
        require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

        // Get Plugin Info
        $api = plugins_api(
            'plugin_information',
            [
                'slug'   => $plugin,
                'fields' => [
                    'short_description' => false,
                    'sections'          => false,
                    'requires'          => false,
                    'rating'            => false,
                    'ratings'           => false,
                    'downloaded'        => false,
                    'last_updated'      => false,
                    'added'             => false,
                    'tags'              => false,
                    'compatibility'     => false,
                    'homepage'          => false,
                    'donate_link'       => false,
                ],
            ]
        );

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $upgrader->install( $api->download_link );

        if ( $api->name ) {
            $status = 'success';
            $msg    = $api->name . ' successfully installed.';
        } else {
            $status = 'failed';
            $msg    = 'There was an error installing ' . $api->name . '.';
        }

        $json = [
            'status' => $status,
            'msg'    => $msg,
        ];

        wp_send_json( $json );
    }

    /*
    * Activate plugin via Ajax.
    *
    * @return $json
    *
    * @since 1.0
    */
    public static function plugin_activation(): void
    {
        if ( ! current_user_can( 'install_plugins' ) ) {
            wp_die( __( 'Sorry, you are not allowed to activate plugins on this site.', 'framework' ) );
        }

        $nonce  = self::get_sanitized( 'nonce' );
        $plugin = self::get_sanitized( 'plugin' );

        // Check our nonce, if they don't match then bounce!
        if ( ! wp_verify_nonce( $nonce, 'cnkt_installer_nonce' ) ) {
            die( __( 'Error - unable to verify nonce, please try again.', 'framework' ) );
        }

        // Include required libs for activation
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

        // Get Plugin Info
        $api = plugins_api(
            'plugin_information',
            [
                'slug'   => $plugin,
                'fields' => [
                    'short_description' => false,
                    'sections'          => false,
                    'requires'          => false,
                    'rating'            => false,
                    'ratings'           => false,
                    'downloaded'        => false,
                    'last_updated'      => false,
                    'added'             => false,
                    'tags'              => false,
                    'compatibility'     => false,
                    'homepage'          => false,
                    'donate_link'       => false,
                ],
            ]
        );

        $msg = null;

        if ( $api->name ) {
            $main_plugin_file = self::get_plugin_file( $plugin );
            $status           = 'success';
            if ( $main_plugin_file ) {
                activate_plugin( $main_plugin_file );
                $msg = $api->name . ' successfully activated.';
            }
        } else {
            $status = 'failed';
            $msg    = 'There was an error activating ' . $api->name . '.';
        }

        $json = [
            'status' => $status,
            'msg'    => $msg,
        ];

        wp_send_json( $json );
    }

    /*
    * get_plugin_file
    * A method to get the main plugin file.
    *
    *
    * @param  $plugin_slug    String - The slug of the plugin
    * @return $plugin_file
    *
    * @since 1.0
    */

    public static function get_plugin_file( $plugin_slug )
    {
        require_once ABSPATH . '/wp-admin/includes/plugin.php';
        // Load plugin lib
        $plugins = get_plugins();

        foreach ( $plugins as $plugin_file => $plugin_info ) {
            // Get the basename of the plugin e.g. [askismet]/askismet.php
            $slug = \dirname( plugin_basename( $plugin_file ) );

            if ( $slug ) {
                if ( $slug == $plugin_slug ) {
                    return $plugin_file;
                    // If $slug = $plugin_name
                }
            }
        }

        return null;
    }

    /*
    * check_file_extension
    * A helper to check file extension
    *
    *
    * @param $filename    String - The filename of the plugin
    * @return boolean
    *
    * @since 1.0
    */
    public static function check_file_extension( $filename )
    {
        if ( 'php' === substr( strrchr( $filename, '.' ), 1 ) ) {
            // has .php exension
            return true;
        }

        // ./wp-content/plugins
        return false;
    }

    protected static function get_sanitized( string $key )
    {
        if ( isset( $_POST[ $key ] ) ) {
            $_data = wp_unslash( $_POST );

            return sanitize_text_field( $_data[ $key ] );
        }

        return null;
    }
}

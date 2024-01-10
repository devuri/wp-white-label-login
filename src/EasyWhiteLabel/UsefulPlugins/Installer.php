<?php

namespace EasyWhiteLabel\UsefulPlugins;

use EasyWhiteLabel\Lib\ConnektInstaller;
use EasyWhiteLabel\Transient;

/**
 * usefull plugins list.
 */
final class Installer extends ConnektInstaller
{
    protected const PLUGINS_DATA_TRANSIENT = 'ewl_plugins_data';
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
        $banner_image_url = $api->banners['low'] ?? null;
        ?>
		<div class="plugin">
			<img style="width:100%;" src="<?php echo $banner_image_url; ?>" alt="">
			<div style="padding:20px;" class="plugin-wrap">
				<h2><?php echo $api->name; ?></h2>
				<p><?php echo $api->short_description; ?></p>
				<p class="plugin-author"><?php _e( 'By', 'framework' ); ?> <?php echo $api->author; ?></p>
		 	</div>
				<ul class="activation-row">
					<li>
						<a class="<?php echo $button_classes; ?>" data-slug="<?php echo $api->slug; ?>" data-name="<?php echo $api->name; ?>"
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
    * init
    * Initialize the display of the plugins.
    *
    *
    * @param $plugin            Array - plugin data
    *
    * @since 1.0
    */
    public static function init( $plugins ): void
    {
        ?>
		 <div class="cnkt-plugin-installer">
		 <?php

            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

			// load plugins data array.
			$plugins_data = self::get_plugins_data( $plugins );

			foreach ( $plugins as $plugin ) {
				$button_classes = 'install button';
				$button_text    = __( 'Install Now', 'framework' );

				$plugin_info = self::get_plugin_info( $plugin );

				if ( ! $plugin_info ) {
					continue;
				}

				$main_plugin_file = self::get_plugin_file( $plugin );
				// Get main plugin file
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
				self::render_template( $plugin, $plugin_info, $button_text, $button_classes );
			}// end foreach
			?>
		 </div>
		<?php
    }

    protected static function get_plugins_data( array $plugins )
    {
        $api_data = Transient::get( self::PLUGINS_DATA_TRANSIENT );

        if ( ! $api_data ) {
            $plugin_info = [];

            foreach ( $plugins as $plugin ) {
                $plugin_info[ $plugin ] = plugins_api(
                    'plugin_information',
                    [
                        'slug'   => sanitize_file_name( $plugin ),
                        // 'slug' => sanitize_file_name($plugin['slug']),
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
            }// end foreach

            Transient::set( self::PLUGINS_DATA_TRANSIENT, $plugin_info );
        }// end if

        return $api_data;
    }

    protected static function get_plugin_info( string $plugin )
    {
        $plugins = Transient::get( self::PLUGINS_DATA_TRANSIENT );

        return $plugins[ $plugin ] ?? null;
    }
}

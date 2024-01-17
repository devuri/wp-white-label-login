<?php
/**
 * This file is part of the Easy White Label WordPress PLugin.
 *
 * (c) Uriel Wilson <hello@urielwilson.com>
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel;

use EasyWhiteLabel\Traits\Singleton;

class DailyTask
{
    use Singleton;

    protected const PLUGINS_DATA_TRANSIENT = 'ewl_plugins_data';

    public function scheduled(): void
    {
        if ( ! wp_next_scheduled( 'ewl_update_plugins_list' ) ) {
            wp_schedule_event( time(), 'twicedaily', 'ewl_update_plugins_list' );
        }

        add_action( 'ewl_update_plugins_list', [ $this, 'execute_task' ] );
    }

    public function execute_task(): void
    {
        $this->get_plugins_data( ewl_get_plugins() );
    }

    public function deactivate(): void
    {
        $timestamp = wp_next_scheduled( 'ewl_update_plugins_list' );
        wp_unschedule_event( $timestamp, 'ewl_update_plugins_list' );
    }

    protected function get_plugins_data( array $plugins ): void
    {
        $api_data = Transient::get( self::PLUGINS_DATA_TRANSIENT );

        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

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
    }
}

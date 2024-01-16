<?php
/**
 * This file is part of the Easy Video Publisher WordPress PLugin.
 *
 * (c) Uriel Wilson
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel;

/**
 * WordPress Transients API.
 *
 * Transients should also never be assumed to be in the database, since they may not be stored there at all.
 *
 * @see https://developer.wordpress.org/apis/transients/
 */
class Transient
{
    /**
     * Get the value of a transient.
     *
     * @param string $transient_name Transient name.
     *
     * @return false|mixed The value of the transient, or false if the transient doesn't exist or has expired.
     */
    public static function get( string $transient_name )
    {
        return get_transient( $transient_name );
    }

    /**
     * Set/update a transient.
     *
     * @param string $transient_name Transient name.
     * @param mixed  $value          The value to store in the transient.
     * @param int    $expiration     Optional. Time in seconds until the transient expires. Default is 0 (no expiration).
     *
     * @return bool True if the transient was set successfully, false otherwise.
     */
    public static function set( string $transient_name, $value, int $expiration = 0 )
    {
        if ( empty( $expiration ) ) {
            $expiration = DAY_IN_SECONDS;
        }

        $result = set_transient( $transient_name, $value, $expiration );

        if ( $result ) {
            self::update_transient_cache( $transient_name, $expiration );
        }

        return $result;
    }

    /**
     * Delete a transient.
     *
     * @param string $transient_name Transient name.
     *
     * @return bool True if the transient was deleted successfully, false otherwise.
     */
    public static function delete( string $transient_name )
    {
        $result = delete_transient( $transient_name );

        if ( $result ) {
            self::delete_transient_cache( $transient_name );
        }

        return $result;
    }

    /**
     * Get the value of a site transient.
     *
     * @param string $transient_name Site transient name.
     *
     * @return false|mixed The value of the site transient, or false if the site transient doesn't exist or has expired.
     */
    public static function get_site_transient( string $transient_name )
    {
        return get_site_transient( $transient_name );
    }

    /**
     * Set/update a site transient.
     *
     * @param string $transient_name Site transient name.
     * @param mixed  $value          The value to store in the site transient.
     * @param int    $expiration     Optional. Time in seconds until the site transient expires. Default is 0 (no expiration).
     *
     * @return bool True if the site transient was set successfully, false otherwise.
     */
    public static function set_site_transient( string $transient_name, $value, int $expiration = 0 )
    {
        if ( empty( $expiration ) ) {
            $expiration = DAY_IN_SECONDS;
        }

        $result = set_site_transient( $transient_name, $value, $expiration );

        if ( $result ) {
            self::update_transient_cache( $transient_name, $expiration, true );
        }

        return $result;
    }

    /**
     * Delete a site transient.
     *
     * @param string $transient_name Site transient name.
     *
     * @return bool True if the site transient was deleted successfully, false otherwise.
     */
    public static function delete_site_transient( string $transient_name )
    {
        $result = delete_site_transient( $transient_name );
        if ( $result ) {
            self::delete_transient_cache( $transient_name, true );
        }

        return $result;
    }

    /**
     * Update the transient cache option with the new transient entry.
     *
     * @param string $transient_name    Transient name.
     * @param int    $expiration        Time in seconds until the transient expires.
     * @param bool   $is_site_transient Optional. True if the transient is a site transient, false otherwise. Default is false.
     *
     * @return void
     */
    private static function update_transient_cache( string $transient_name, int $expiration, bool $is_site_transient = false ): void
    {
        $transient_cache = get_option( 'ewl_plugin_transient_cache', [] );

        if ( $is_site_transient ) {
            $transient_cache['site'][ $transient_name ] = $expiration;
        } else {
            $transient_cache['regular'][ $transient_name ] = $expiration;
        }

        update_option( 'ewl_plugin_transient_cache', $transient_cache );
    }

    /**
     * Delete the transient entry from the transient cache option.
     *
     * @param string $transient_name    Transient name.
     * @param bool   $is_site_transient Optional. True if the transient is a site transient, false otherwise. Default is false.
     *
     * @return void
     */
    private static function delete_transient_cache( string $transient_name, bool $is_site_transient = false ): void
    {
        $transient_cache = get_option( 'ewl_plugin_transient_cache', [] );

        if ( $is_site_transient ) {
            if ( isset( $transient_cache['site'][ $transient_name ] ) ) {
                unset( $transient_cache['site'][ $transient_name ] );
            }
        } else {
            if ( isset( $transient_cache['regular'][ $transient_name ] ) ) {
                unset( $transient_cache['regular'][ $transient_name ] );
            }
        }

        update_option( 'ewl_plugin_transient_cache', $transient_cache );
    }
}

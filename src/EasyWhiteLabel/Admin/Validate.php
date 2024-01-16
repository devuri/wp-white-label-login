<?php
/**
 * This file is part of the Easy Video Publisher WordPress PLugin.
 *
 * (c) Uriel Wilson
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel\Admin;

// @codingStandardsIgnoreFile.

class Validate
{
    /**
     * Simplify the form validation checks.
     *
     * Will check nonce and admin referer.
     *
     * Nonces should never be relied on for authentication or authorization,
     * access control. Protect your functions using current_user_can(),
     * always assume Nonces can be compromised.
     *
     * Example usage: Validate::request($action, $nonce);
     *
     * @param string $action The nonce action.
     * @param string $nonce
     *
     * @return false|true
     */
    public static function request( string $action, string $nonce ): bool
    {
        if ( ! self::verify_nonce( $action, $nonce ) ) {
            return false;
        }
        if ( ! self::admin_referer( $action, $nonce ) ) {
            return false;
        }

        return true;
    }

    /**
     * Verifies that a correct security nonce was used.
     *
     * @param string $action
     * @param string $nonce
     *
     * @return false|true
     *
     * @see https://developer.wordpress.org/reference/functions/wp_verify_nonce
     */
    public static function verify_nonce( string $action, string $nonce ): bool
    {
        $validate_nonce = isset( $_REQUEST[ $nonce ] ) && wp_verify_nonce( $_REQUEST[ $nonce ], $action );
        if ( $validate_nonce ) {
            return true;
        }

        return false;
    }

    /**
     * Ensures intent by verifying that a user was referred from another
     * admin page with the correct security nonce.
     *
     * @param string $action
     * @param string $nonce
     *
     * @return bool true if the nonce is valid and generated between 0-12 hours ago.
     *
     * @see https://developer.wordpress.org/reference/functions/check_admin_referer/
     */
    public static function admin_referer( string $action, string $nonce ): bool
    {
        /**
         * check_admin_referer() will return int|false.
         * we will only return true for 1 (0-12 hours ago).
         *
         * 1 if the nonce is valid and generated between 0-12 hours ago,
         * 2 if the nonce is valid and generated between 12-24 hours ago.
         * False if the nonce is invalid.
         *
         * @var false|int.
         */
        $validate = check_admin_referer( $action, $nonce );
        if ( 1 === $validate ) {
            return true;
        }

        return false;
    }

    /**
     * Verifies that the user has the correct capability.
     *
     * @param string $capability
     *
     * @see https://wordpress.org/support/article/roles-and-capabilities/
     */
    public static function user_cap( string $capability = 'manage_options' ): bool
    {
        if ( current_user_can( $capability ) ) {
            return true;
        }

        return false;
    }
}

<?php
/**
 * This file is part of the Easy Video Publisher WordPress PLugin.
 *
 * (c) Uriel Wilson
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel\Admin\Form\Traits\Element;

// @codingStandardsIgnoreFile.

trait Nonce
{
    /**
     * nonce field.
     *
     * @param string $wpnonce
     *
     * @return string the nonce field output.
     *
     * @see https://developer.wordpress.org/reference/functions/wp_nonce_field/
     */
    public static function nonce( $wpnonce = '_swa_page_wpnonce' ): string
    {
        /** @phpstan-ignore-next-line */
        return wp_nonce_field( -1, $wpnonce, true, true );
    }

    /**
     * nonce_check.
     *
     * @param string $noncefield [description]
     *
     * @return bool
     *
     * @see https://developer.wordpress.org/reference/functions/wp_verify_nonce/
     */
    public static function verify_nonce( $noncefield = '_swa_page_wpnonce' ): bool
    {
        /*
         * Lets verify this.
         *
         * @return bool
         */
        if ( ! isset( $_POST[ $noncefield ] ) || ! wp_verify_nonce( $_POST[ $noncefield ] ) ) {
            return false;
        }

        return true;
    }
}

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

class Activate
{
    public static function init(): void
    {
        /**
         * Setup plugin options.
         *
         * DO NOT change the option names this plugin is a rebrand of wp-white-label-login.
         * these need to remain for backwards compat.
         *
         * @see https://github.com/devuri/wp-white-label-login
         */
        update_option( 'wpwll_options', self::setup_defaults() );
        update_option( 'wpwll_background', '0' );
        update_option( 'wpwll_logo', '0' );
        update_option( 'wpwll_custom_css', '' );
        // TODO redirect to a welcome admin page
    }

    protected static function setup_defaults(): array
    {
        return [
            'form_layout'             => 'center',
            // header
            'header_title'            => get_bloginfo( 'name' ),
            'header_description'      => get_bloginfo( 'description' ),
            'header_text_color'       => '#737373',
            'header_background_color' => '#ffffff',
            'header_alignment'        => 'center',
            // logo
            'logo_display'            => 'none',
            'logo_position'           => 'center',
            // login
            'login_text_color'        => '#444444',
            'login_container_color'   => '#ffffff',
            // form
            'login_form_color'        => '#ffffff',
            // button
            'button_text_color'       => '#ffffff',
            'button_background_color' => '#007cba',
            // links
            'link_color'              => '#474748',
            // background
            'background_color'        => '#ffffff',
            'background_attachment'   => 'fixed',
            'background_repeat'       => 'no-repeat',
            'background_position'     => 'bottom',
            // menu
            'footer_nav'              => false,
            'footer_nav_backgorund'   => '#dadada',
            'footer_nav_alignment'    => 'center',
            // footer
            'footer_text'             => '...',
            'copyright_text'          => 'All Rights Reserved',
            'footer_text_color'       => '#747474',
            'footer_alignment'        => 'center',
        ];
    }
}

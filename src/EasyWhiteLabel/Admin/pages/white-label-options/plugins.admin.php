<?php

use EasyWhiteLabel\UsefulPlugins\Installer;

$plugin_list = [
    'application-passwords-manager',
    'disable-dashboard-widgets',
    'wp-auto-updates',
    'membership-lock',
    'iceyi-members-only',
    'sim-clickable-links',
    'better-search-replace',
    'disable-comments',
    'wp-seopress',
    'login-recaptcha',
    'sucuri-scanner',
    'wpforms-lite',
    'wp-mail-smtp',
    'wp-dbmanager',
    'rest-api-featured-image',
];

/**
 * List of plugins.
 */
Installer::init( $plugin_list );

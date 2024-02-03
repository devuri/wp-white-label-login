<?php

if ( ! \function_exists( 'wpwhitelabel' ) ) {
    /**
     * wpwhitelabel().
     *
     * @return object
     */
    function wpwhitelabel()
    {
        // new up wll object
        return EasyWhiteLabel\Plugin::init();
    }
}

function ewl_get_plugins(): array
{
    return [
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
}

/**
 * Exit On form failure.
 *
 * @param null|string $message
 *
 * @return never
 */
function ewl_fail_exit( ?string $message = null )
{
    if ( ! $message ) {
        $message = esc_html__( 'The Link You Followed Has Expired or Verification Failed', 'wp-white-label-login' );
    }
    exit( $message );
}

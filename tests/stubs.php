<?php

if ( ! \defined('EASYWHITELABEL_PATH')) {
    \define('EASYWHITELABEL_PATH', "/plugins/wp-easy-white-label/");
}

if ( ! \defined('EASYWHITELABEL_URL')) {
    \define('EASYWHITELABEL_URL', null);
}

if ( ! \defined('EASYWHITELABEL_DIR')) {
    \define('EASYWHITELABEL_DIR', true);
}

if ( ! \defined('EASYWHITELABEL_VERSION')) {
    \define('EASYWHITELABEL_VERSION', true);
}

// Available unit tests only.
function tests_add_filter($arg1, $arg2): void
{
}

if ( ! \function_exists('__')) {
    /**
     * Retrieve the translation of $text.
     *
     * Override for wp core function  __()
     *
     * @see https://core.trac.wordpress.org/browser/tags/6.0.2/src/wp-includes/l10n.php#L296
     *
     * @param string $text   Text to translate.
     * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
     *
     * @return string
     */
    function __( $text, $domain = 'default' ): string
    {
        return $text;
    }
}

if ( ! \function_exists('esc_html__')) {
    /**
     * Retrieve the translation of $text.
     *
     * Override for wp core function  esc_html__()
     *
     * @see https://developer.wordpress.org/reference/functions/esc_html__/
     *
     * @param string $text   Text to translate.
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     *
     * @return string
     */
    function esc_html__( $text, $domain = 'default' ): string
    {
        return $text;
    }
}


if ( ! \function_exists('wp_cache_flush')) {
    function wp_cache_flush(): bool
    {
        return true;
    }
}

if ( ! \function_exists('flush_rewrite_rules')) {
    function flush_rewrite_rules(): bool
    {
        return true;
    }
}


/**
 * stub the WP_UnitTestCase for unit class.
 */
class WP_UnitTestCase
{
}

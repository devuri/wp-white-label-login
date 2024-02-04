<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;

abstract class AbstractSelectiveRefresh implements SettingInterface
{
    /**
     * Creates settings for the Customizer.
     *
     * This method must be implemented in subclasses to define Customizer settings and controls.
     *
     * @param CustomizerPanel $customize The Customizer panel instance where settings will be added.
     */
    abstract public function create( CustomizerPanel $customize): void;

    /**
     * Adds a selective refresh partial to the Customizer.
     *
     * This method registers a selective refresh partial in the WordPress Customizer,
     * allowing parts of the preview to be updated without a full page reload. It supports
     * a custom render callback, if provided; otherwise, it defaults to a standard callback
     * that fetches the setting based on a specified key from the 'wpwll_options' array.
     *
     * @param string        $setting_id      The ID of the setting. This should match the partial ID.
     * @param object        $customize       The Customizer instance.
     * @param string        $selector        The CSS selector for the container to be refreshed.
     * @param string        $key             The key in the 'wpwll_options' array to fetch the setting value from.
     * @param mixed         $default         Optional. The default value to return if the setting is not found.
     * @param null|callable $render_callback Optional. A custom callback function for rendering the partial.
     */
    protected static function _render_partial( string $setting_id, object $customize, string $selector, string $key, $default = null, ?callable $render_callback = null ): void
    {
        if ( isset( $customize->get_customizer()->selective_refresh ) ) {
            $partial_args = [
                'selector'            => $selector,
                'container_inclusive' => false,
                'render_callback'     => $render_callback ?? function () use ( $key, $default ) {
                    $setting = static::get_wpwll_options();

                    return $setting[ $key ] ?? $default;
                },
                // IMPORTANT: Do not refresh the entire page.
                'fallback_refresh'    => false,
            ];

            $customize->get_customizer()->selective_refresh->add_partial( $setting_id, $partial_args );
        }
    }

    /**
     * Retrieves WPWLL options from cache or database.
     *
     * Attempts to get options from a transient cache; if unavailable, fetches from
     * database and caches them. Improves performance by reducing database queries.
     *
     * @return array wpwll_options, empty array if none set.
     */
    protected static function get_wpwll_options(): array
    {
        $setting = get_transient( '_wpwll_options_cache' );

        if ( false === $setting ) {
            $setting = get_option( 'wpwll_options', [] );
            set_transient( '_wpwll_options_cache', $setting, HOUR_IN_SECONDS );
        }

        return $setting;
    }
}

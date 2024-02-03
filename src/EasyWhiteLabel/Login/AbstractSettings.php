<?php

namespace EasyWhiteLabel\Login;

use EasyWhiteLabel\PluginInterface;

/**
 * Abstract class for managing settings.
 *
 * This class provides a base for managing settings including whitelabel configuration
 * and custom CSS rules. It is designed to be extended to provide specific functionality.
 */
abstract class AbstractSettings
{
    /**
     * Instance of a PluginInterface.
     *
     * @var PluginInterface
     */
    protected static $whitelabel;

    /**
     * Custom CSS rules.
     *
     * @var string
     */
    protected $css_rules;

    /**
     * Constructor for the AbstractSettings class.
     *
     * Initializes the whitelabel plugin interface and generates initial CSS rules.
     * If a PluginInterface instance is provided, it will be used; otherwise, a default
     * PluginInterface instance is obtained via `wpwhitelabel()`.
     *
     * @param null|PluginInterface $wp_whitelabel Optional. Instance of PluginInterface for whitelabel configuration.
     */
    public function __construct( ?PluginInterface $wp_whitelabel = null )
    {
        if ( $wp_whitelabel ) {
            self::$whitelabel = $wp_whitelabel;
        } else {
            self::$whitelabel = wpwhitelabel();
        }

        $this->css_rules = $this->generate_css();
    }

    /**
     * Initializes the settings object.
     *
     * This static method creates and returns an instance of the settings class,
     * optionally using a provided PluginInterface instance for the whitelabel configuration.
     *
     * @param null|PluginInterface $wp_whitelabel Optional. Instance of PluginInterface for whitelabel configuration.
     *
     * @return self An instance of the settings class.
     */
    public static function init( ?PluginInterface $wp_whitelabel = null )
    {
        $called_class = static::class;

        return new $called_class( $wp_whitelabel );
    }

    /**
     * Retrieves the custom CSS rules.
     *
     * This method provides access to the generated CSS rules. It may return null
     * if no rules have been generated.
     *
     * @return null|string The custom CSS rules or null if none are available.
     */
    public function get_css_rules(): ?string
    {
        return $this->css_rules;
    }

    /**
     * Provides access to the whitelabel PluginInterface instance.
     *
     * This method ensures there is a consistent way to access the PluginInterface instance,
     * primarily used for whitelabel configuration within the class.
     *
     * @return PluginInterface An instance of the PluginInterface for whitelabel configuration.
     */
    protected static function whitelabel(): PluginInterface
    {
        return wpwhitelabel();
    }

    /**
     * Generates and returns custom CSS rules.
     *
     * This method should be overridden in a subclass to generate specific CSS rules
     * as needed. By default, it returns null.
     *
     * @return null|string Custom CSS rules or null if none are generated.
     */
    protected function generate_css(): ?string
    {
        return null;
    }
}

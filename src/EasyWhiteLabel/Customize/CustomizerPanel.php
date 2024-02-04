<?php

namespace EasyWhiteLabel\Customize;

use EasyWhiteLabel\Customize\Settings\Advanced;
use EasyWhiteLabel\Customize\Settings\Background;
use EasyWhiteLabel\Customize\Settings\Button;
use EasyWhiteLabel\Customize\Settings\Css;
use EasyWhiteLabel\Customize\Settings\Footer;
use EasyWhiteLabel\Customize\Settings\Form;
use EasyWhiteLabel\Customize\Settings\Header;
use EasyWhiteLabel\Customize\Settings\Layout;
use EasyWhiteLabel\Customize\Settings\Links;
use EasyWhiteLabel\Customize\Settings\Login;
use EasyWhiteLabel\Customize\Settings\Logo;
use EasyWhiteLabel\Customize\Settings\Menu;
use EasyWhiteLabel\Customize\Settings\SettingInterface;
use WP_Customize_Manager;

class CustomizerPanel
{
    /**
     * Type of the preview—either 'postMessage' or 'refresh'.
     *
     * @var string
     *
     * @see https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/
     */
    protected $preview_type = 'postMessage';

    /**
     * Customizer manager instance.
     *
     * @var null|WP_Customize_Manager
     */
    protected $customizer;

    /**
     * Identifier for the options panel.
     *
     * @var string
     */
    protected $options_panel = 'wll_options_panel';

    /**
     * Collection of section identifiers.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Initializes the customizer panel with the customizer manager.
     *
     * @param null|WP_Customize_Manager $wp_customize Customizer manager.
     */
    public function __construct( ?WP_Customize_Manager $wp_customize = null )
    {
        $this->customizer = $wp_customize;
    }

    /**
     * Sets up the customizer panel and sections.
     *
     * @param WP_Customize_Manager $wp_customize Customizer manager.
     */
    public static function setup_customizer_panel( $wp_customize ): void
    {
        $panel = new self( $wp_customize );

        // Add the panel.
        $panel->get_customizer()->add_panel(
            'wll_options_panel',
            [
                'priority'       => 180,
                'capability'     => 'manage_options',
                'theme_supports' => '',
                'title'          => esc_html__( 'White  Label Login Options', 'whitelabel-login' ),
            ]
        );

        $panel->add( 'advanced', __( 'Advanced Settings', 'wp-white-label-login' ), new Advanced() );
        $panel->add( 'background', __( 'Background', 'wp-white-label-login' ), new Background() );
        $panel->add( 'button', __( 'Button Settings', 'wp-white-label-login' ), new Button() );
        $panel->add( 'css', __( 'Custom Login CSS', 'wp-white-label-login' ), new Css() );
        $panel->add( 'footer', __( 'Login Footer', 'wp-white-label-login' ), new Footer() );
        $panel->add( 'form', __( 'Form Settings', 'wp-white-label-login' ), new Form() );
        $panel->add( 'header', __( 'Header Settings', 'wp-white-label-login' ), new Header() );
        $panel->add( 'layout', __( 'Page Layout', 'wp-white-label-login' ), new Layout() );
        $panel->add( 'links', __( 'Page Links', 'wp-white-label-login' ), new Links() );
        $panel->add( 'login', __( 'Login Container', 'wp-white-label-login' ), new Login() );
        $panel->add( 'logo', __( 'Login Logo', 'wp-white-label-login' ), new Logo() );
        $panel->add( 'menu', __( 'Footer Navigation', 'wp-white-label-login' ), new Menu() );
    }

    /**
     * Create settings for a specific section.
     *
     * Initializes settings configuration for the given section if it exists within the allowed sections.
     *
     * @param SettingInterface $settings   The settings interface to create configurations.
     * @param string           $section_id The ID of the section to create settings for.
     *
     * @throws InvalidArgumentException If the section ID does not exist in the available sections.
     */
    public function setting( SettingInterface $settings, string $section_id ): void
    {
        if ( ! \in_array( $section_id, $this->sections, true ) ) {
            throw new \InvalidArgumentException( "The section ID '{$section_id}' does not match any available sections." );
        }

        $settings->create( $this, $section_id );
    }

    /**
     * Sets up the WP_Customize_Manager.
     *
     * @return WP_Customize_Manager
     */
    public function get_customizer(): WP_Customize_Manager
    {
        return $this->customizer;
    }

    /**
     * Get the preview_type.
     *
     * @return string
     */
    public function get_preview(): string
    {
        return $this->preview_type;
    }

    /**
     * Adds a section to the customizer panel.
     *
     * @param string                $section  Section identifier.
     * @param null|string           $title    Section title.
     * @param null|SettingInterface $settings Settings instance.
     *
     * @return self
     */
    public function add( string $section, ?string $title = null, ?SettingInterface $settings = null ): self
    {
        $title      = $title ?? trim( ucwords( $section ) );
        $section_id = 'whitelabel_section_' . trim( $section );

        // save section to array.
        $this->sections[ $section ] = $section_id;

        $this->get_customizer()->add_section(
            $section_id,
            [
                'title'       => ' » ' . $title,
                'capability'  => 'manage_options',
                'description' => $this->description(),
                'panel'       => $this->options_panel,
            ]
        );

        if ( $settings instanceof SettingInterface ) {
            $this->setting( $settings, $section_id );
        }

        return $this;
    }

    /**
     * Description.
     */
    protected static function description()
    {
        return sprintf(
            '<p><h3 class="wp-ui-text-highlight"> %1$s </h3><a href="%2$s" class="external-link" target="_blank">%3$s<span class="screen-reader-text"> %4$s</span>
            </a></p>',
            __( 'White Label Login Options', 'wp-white-label-login' ),
            esc_url( __( 'https://wordpress.org/support/plugin/wp-white-label-login' ) ),
            __( 'Plugins Support Section.', 'wp-white-label-login' ),
            __( '(opens in a new tab)', 'wp-white-label-login' )
        );
    }

    /**
     * JS handlers to make Theme Customizer preview reload changes.
     */
    protected static function enqueue_customize_preview(): void
    {
        wp_enqueue_script( 'wpwll-customizer', EASYWHITELABEL_URL . 'assets/js/customize.js', [ 'customize-preview' ], EASYWHITELABEL_VERSION, true );
    }
}

<?php

namespace EasyWhiteLabel\Customize;

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
use EasyWhiteLabel\Traits\Singleton;
use WP_Customize_Manager;

class CustomizerPanel
{
    use Singleton;

    /**
     * Customizer JavaScript preview settings.
     *
     * 'postMessage' or 'refresh'
     *
     * @see https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/
     */
    protected $preview_type = 'postMessage';

    /**
     * @param WP_Customize_Manager
     */
    protected $customizer;

    /**
     * @param string
     */
    protected $options_panel = 'wll_options_panel';

    /**
     * Setup.
     *
     * @param WP_Customize_Manager $wp_customize
     */
    public function __construct( ?WP_Customize_Manager $wp_customize = null )
    {
        $this->customizer = $wp_customize;
    }

    /**
     * customizer.
     *
     * @param $wp_customize
     *
     * @see https://core.trac.wordpress.org/browser/tags/5.4/src/wp-includes/class-wp-customize-manager.php#L928
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

        $panel->add( 'background' )->setting( new Background() );
        $panel->add( 'button' )->setting( new Button() );
        $panel->add( 'css' )->setting( new Css() );
        $panel->add( 'footer' )->setting( new Footer() );
        $panel->add( 'form' )->setting( new Form() );
        $panel->add( 'header' )->setting( new Header() );
        $panel->add( 'layout' )->setting( new Layout() );
        $panel->add( 'links' )->setting( new Links() );
        $panel->add( 'login' )->setting( new Login() );
        $panel->add( 'logo' )->setting( new Logo() );
        $panel->add( 'menu' )->setting( new Menu() );
    }

    /**
     * Settings.
     *
     * @param SettingInterface $settings
     *
     * @return void
     */
    public function setting( SettingInterface $settings ): void
    {
        $settings->create( $this );
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
     * Description.
     */
    public static function description()
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

    private function add( string $section ): self
    {
        $this->get_customizer()->add_section(
            'whitelabel_section_' . trim( $section ),
            [
                'title'       => ' » ' . trim( ucwords( $section ) ),
                'capability'  => 'manage_options',
                'description' => $this->description(),
                'panel'       => $this->options_panel,
            ]
        );

        return $this;
    }
}

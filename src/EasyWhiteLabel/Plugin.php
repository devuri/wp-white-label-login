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

use EasyWhiteLabel\Admin\OptionSettings;
use EasyWhiteLabel\Admin\WhiteLabelAdmin;
use EasyWhiteLabel\Customize\CustomizerPanel;
use EasyWhiteLabel\Login\Background;
use EasyWhiteLabel\Login\Footer;
use EasyWhiteLabel\Login\Header;
use EasyWhiteLabel\Login\Logo;
use EasyWhiteLabel\Login\Style;
use EasyWhiteLabel\Traits\Singleton;
use EasyWhiteLabel\UsefulPlugins\Installer;

class Plugin implements PluginInterface
{
    use Singleton;

    public const OPTION = [
        'logo'           => 'wpwll_logo',
        'background'     => 'wpwll_background',
        'logo_url'       => 'wpwll_logo_url',
        'background_url' => 'wpwll_background_url',
        'align'          => 'wpwll_align',
        'custom_css'     => 'wpwll_custom_css',
        'copyright'      => 'wpwll_copyright_text',
        'options'        => 'wpwll_options',
        'page_access'    => 'wpwll_page_access',
    ];

    protected $settings;
    protected $options;

    /**
     * Add Hooks.
     *
     * @param mixed $enabled
     */
    public function hooks(): void
    {
        $this->setup_wll_plugin();

        /**
         * Loading the plugin translations.
         */
        add_action( 'init', [ Lang::class, 'i18n' ] );

        /**
         * Register Customizer panel.
         */
        add_action( 'customize_register', [ CustomizerPanel::class, 'setup_customizer_panel' ], 10 );

        /**
         * Footer navigation menu.
         */
        add_action(
            'init',
            function (): void {
                register_nav_menu( 'wll-footer-nav', __( 'Login Page Footer Navigation' ) );
            }
        );

        add_action( 'admin_menu', [ $this, 'appearance_submenu' ] );
		// @phpstan-ignore-next-line.
        add_filter( 'login_head', [ Background::class, 'body_css' ] );
        // @phpstan-ignore-next-line.
        add_filter( 'login_footer', [ Footer::class, 'footer' ] );
        add_filter( 'login_head', [ Header::class, 'login_header' ] );
        add_action( 'login_enqueue_scripts', [ Logo::class, 'login_logo' ] );
        add_filter( 'login_headertext', [ Logo::class, 'logo_text' ] );
        add_action( 'login_enqueue_scripts', [ Style::class, 'login_styles' ] );

        // login url.
        add_filter(
            'login_headerurl',
            function () {
                return get_bloginfo( 'url' );
            }
        );

        // plugins
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'wp_ajax_cnkt_plugin_installer', [ Installer::class, 'plugin_installer' ] );
        add_action( 'wp_ajax_cnkt_plugin_activation', [ Installer::class, 'plugin_activation' ] );

        // all is loaded.
        do_action( 'easy_whitelabel_loaded' );
    }

    /*
    * enqueue_scripts
    * Enqueue admin scripts and scripts localization
    *
    *
    * @since 1.0
    */
    public function enqueue_scripts(): void
    {
        wp_enqueue_script( 'plugin-installer', EASYWHITELABEL_URL . 'assets/connekt/installer.js', [ 'jquery' ], EASYWHITELABEL_VERSION );
        wp_localize_script(
            'plugin-installer',
            'cnkt_installer_localize',
            [
                'ajax_url'      => admin_url( 'admin-ajax.php' ),
                'admin_nonce'   => wp_create_nonce( 'cnkt_installer_nonce' ),
                'install_now'   => __( 'Are you sure you want to install this plugin?', 'framework' ),
                'install_btn'   => __( 'Install Now', 'framework' ),
                'activate_btn'  => __( 'Activate', 'framework' ),
                'installed_btn' => __( 'Activated', 'framework' ),
            ]
        );

        wp_enqueue_style( 'plugin-installer', EASYWHITELABEL_URL . 'assets/connekt/installer.css', [], EASYWHITELABEL_VERSION );
    }

    /**
     * wp_slug.
     *
     * WordPress.org repo slug
     *
     * @return [type] [description]
     */
    public function slug()
    {
        return 'wp-white-label-login';
    }

    /**
     * [photo_sites_list description].
     *
     * @param string $thikbox_id [description]
     *
     * @return [type]            [description]
     */
    public function photo_sites( $thikbox_id = 'freestockphotosites' )
    {
        ?>
	    <div id="<?php echo $thikbox_id; ?>" style="display:none;">
	    <table class="widefat">
	    <tr style="background:#CFCFCF;">
	    <th> <b>Website</b></th>
	    </tr>
        <?php
            // sites list
            $listofsites = [
                'stocksnap.io',
                'pixabay.com',
                'pexels.com',
                'unsplash.com',
                'burst.shopify.com',
                'reshot.com',
                'foodiesfeed.com',
                'gratisography.com',
                'gratisography.com',
                'freestocks.org',
                'picography.co',
                'focastock.com',
                'picjumbo.com',
                'kaboompics.com',
                'skitterphoto.com',
                'lifeofpix.com',
                'littlevisuals.co',
                'jaymantri.com',
                'picspree.com',
                'isorepublic.com',
                'styledstock.co',
                'pikwizard.com',
                'rawpixel.com',
            ];

			// sort the array
			sort( $listofsites );
			foreach ( $listofsites as $skey => $site ) {
				echo '<tr>';
				echo '<td>';
				echo '<a target="_blank" href="https://' . $site . '">' . ucfirst( $site ) . '</a>';
				echo '</td>';
				echo '</tr>';
			}
			?>
        </table></div>
		<?php
    }

    /**
     * Appearance submenu.
     *
     * Lets add a submenu for the Customizer
     *
     * @return void [type] [description]
     */
    public function appearance_submenu(): void
    {
        add_submenu_page(
            'themes.php',
            __( 'White Label Login Customizer', 'wp-white-label-login' ),
            __( 'White Label Login', 'wp-white-label-login' ),
            'manage_options',
            '/customize.php?url=' . urlencode( home_url( '/wp-login.php' ) )
        );
    }

    /**
     * customizer_button().
     *
     * quick link to the customizer
     *
     * @param mixed $cbutton_text
     *
     * @return string
     */
    public function customizer_button( $cbutton_text = 'Use The Customizer' )
    {
        // render button
        $customizer_button  = '<a class="button button-hero"';
        $customizer_button .= 'href="' . admin_url( '/customize.php?url=' . urlencode( home_url( '/wp-login.php' ) ) ) . '">';
        $customizer_button .= $cbutton_text;
        $customizer_button .= '</a>';

        return $customizer_button;
    }

    /**
     * settings.
     *
     * setup some the options array to get a specific setting
     *
     * @param string $set
     * @param mixed  $default
     *
     * @return string
     */
    public function option( $set = 'background', $default = '' )
    {
        if ( isset( $this->settings[ $set ] ) ) {
            return $this->settings[ $set ];
        }

        return $default;
    }

    public function get_setting( string $key = 'background', $default = '' )
    {
        return $this->settings['options'][ $key ] ?? $default;
    }

    protected static function admin_menu(): void
    {
        if ( ! is_admin() ) {
            return;
        }// end if

        // main menu args.
        $admin = [
            'page_title'  => 'White Label Login Settings ',
            'menu_title'  => 'WP White Label',
            'capability'  => 'manage_options',
            'menu_slug'   => 'white-label-options',
            'function'    => 'wllmenu_callback',
            'icon_url'    => 'dashicons-art',
            'prefix'      => 'wll',
            'admin_views' => WhiteLabelAdmin::admin_views_dir(),
        ];

        // init menu
        WhiteLabelAdmin::init(
            $admin,
            [
                esc_html__( 'Settings', 'wp-white-label-login' ),
                'background'  => [
                    'name' => esc_html__( 'Background', 'wp-white-label-login' ),
                    // 'hidden' => true,
                    'icon' => 'dashicons-format-image',
                ],
                'css'         => [
                    'name' => esc_html__( 'CSS Settings', 'wp-white-label-login' ),
                    // 'hidden' => true,
                    'icon' => 'dashicons-admin-customizer',
                ],
                'page-access' => [
                    'name' => esc_html__( 'Page Access Redirect', 'wp-white-label-login' ),
                    'icon' => 'dashicons-lock',
                ],
                'plugins'     => [
                    'name' => esc_html__( 'Useful Plugins', 'wp-white-label-login' ),
                    // 'hidden' => true,
                    'icon' => 'dashicons-plugins-checked',
                ],
            ]
        );
    }

    private function setup_wll_plugin(): void
    {
        $this->settings = [
            'logo'             => get_option( self::OPTION['logo'] ),
            'background_image' => get_option( self::OPTION['background'] ),
            'logo_url'         => get_option( self::OPTION['logo_url'] ),
            'background_url'   => get_option( self::OPTION['background_url'] ),
            'align'            => get_option( self::OPTION['align'] ),
            'custom_css'       => get_option( self::OPTION['custom_css'] ),
            'copyright'        => get_option( self::OPTION['copyright'] ),
            'options'          => get_option( self::OPTION['options'] ),
            'page_access'      => get_option( self::OPTION['page_access'] ),
        ];

        // add admin menu.
        self::admin_menu();

        // add page access.
        PageAccess::init( new OptionSettings( self::OPTION['page_access'], 'selective_page_access', 'wll-page-access' ) );
    }
}

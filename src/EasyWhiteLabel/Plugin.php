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

use EasyWhiteLabel\Admin\WhiteLabelAdmin;
use EasyWhiteLabel\Customize\Customizer;
use EasyWhiteLabel\Login\Background;
use EasyWhiteLabel\Login\Footer;
use EasyWhiteLabel\Login\Header;
use EasyWhiteLabel\Login\Logo;
use EasyWhiteLabel\Login\Style;
use EasyWhiteLabel\Traits\Singleton;
use EasyWhiteLabel\UsefulPlugins\Installer;

class Plugin
{
    use Singleton;

    public $enabled;
    public $customizer;

    /**
     * Add Shortcode [wpoption opt="myoption"].
     *
     * @param mixed $enabled
     */
    public function hooks( $enabled = true ): void
    {
        $this->enabled    = $enabled;
        $this->customizer = new Customizer();

        if ( is_admin() ) {
            $admin_menu = [
                'page_title'  => 'White Label Login Settings ',
                'menu_title'  => 'WP White Label',
                'capability'  => 'manage_options',
                'menu_slug'   => 'white-label-options',
                'function'    => 'wllmenu_callback',
                'icon_url'    => 'dashicons-art',
                'prefix'      => 'wll',
                'admin_views' => WhiteLabelAdmin::admin_views_dir(),
            ];
            WhiteLabelAdmin::init(
                $admin_menu,
                [
                    esc_html__( 'Settings', 'wp-white-label-login' ),
                    'background' => [
                        'name' => esc_html__( 'Background', 'wp-white-label-login' ),
                        // 'hidden' => true,
                        'icon' => 'dashicons-format-image',
                    ],
                    'css'        => [
                        'name' => esc_html__( 'CSS Settings', 'wp-white-label-login' ),
                        // 'hidden' => true,
                        'icon' => 'dashicons-admin-customizer',
                    ],
                    'plugins'    => [
                        'name' => esc_html__( 'Useful Plugins', 'wp-white-label-login' ),
                        // 'hidden' => true,
                        'icon' => 'dashicons-plugins-checked',
                    ],
                ]
            );
        }// end if

        /**
         * Loading the plugin translations.
         */
        add_action( 'init', [ Lang::class, 'i18n' ] );

        add_action( 'admin_menu', [ $this, 'appearance_submenu' ] );
        add_action( 'init', [ $this, 'footer_navigation' ] );
        add_action( 'login_enqueue_scripts', [ Style::class, 'login_styles' ] );
        add_action( 'login_enqueue_scripts', [ Logo::class, 'login_logo' ] );
        add_filter( 'login_headertext', [ Logo::class, 'logo_text' ] );
        add_filter( 'login_head', [ Header::class, 'header' ] );
        add_filter( 'login_head', [ Background::class, 'body' ] );
        add_filter( 'login_footer', [ Footer::class, 'footer' ] );
        add_filter( 'login_headerurl', [ $this, 'logo_link' ] );

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
     * Footer Navigation.
     *
     * @return void
     */
    public function footer_navigation(): void
    {
        register_nav_menu( 'wll-footer-nav', __( 'Login Page Footer Navigation' ) );
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
     * plugin directory.
     *
     * WordPress.org repo slug
     *
     * @return [type] [description]
     */
    public function dir()
    {
        return EASYWHITELABEL_DIR;
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
     * Options.
     *
     * setup some the options array
     *
     * @param string $opt
     *
     * @return string
     */
    public function option( $opt = 'logo' )
    {
        $option = [
            'wpwll_options'    => get_option( 'wpwll_options' ),
            'background_image' => get_option( 'wpwll_background' ),
            'logo'             => get_option( 'wpwll_logo' ),
            'custom_css'       => get_option( 'wpwll_custom_css' ),
        ];

        return $option[ $opt ];
    }

    /**
     * settings.
     *
     * setup some the options array to get a specific setting
     *
     * @param string $set
     *
     * @return string
     */
    public function setting( $set = 'background' )
    {
        $setting = $this->option( 'wpwll_options' );
        if ( isset( $setting[ $set ] ) ) {
            return $setting[ $set ];
        }

        return '';
    }

    /**
     * site_info.
     *
     * setup some site specific vars
     *
     * @param string $info
     *
     * @return string
     */
    public function site_info( $info = 'name' )
    {
        $site_info = [
            'name'             => get_bloginfo( 'name' ),
            'url'              => get_bloginfo( 'url' ),
            'admin_url'        => get_admin_url(),
            'background_color' => 'none',
            'header_text'      => get_bloginfo( 'description' ),
        ];

        return $site_info[ $info ];
    }

    /**
     * logo_link.
     *
     * change the login link to site url
     *
     * @return string
     */
    public function logo_link()
    {
        return $this->site_info( 'url' );
    }
}

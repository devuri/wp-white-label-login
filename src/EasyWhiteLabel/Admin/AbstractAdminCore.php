<?php

/**
 * This file is part of the Easy Video Publisher WordPress PLugin.
 *
 * (c) Uriel Wilson
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel\Admin;

use function define;

use Exception;

abstract class AbstractAdminCore implements AdminCoreInterface
{
    /**
     * Class version.
     */
    public const ADMINVERSION = '6.0.0';

    /**
     * Sets up the submenu hooks.
     *
     * @var array
     */
    protected $submenu_hooks = [];

    /**
     * Define a generic icon.
     *
     * @var string
     */
    protected $generic_icon;
    /**
     * Get the current plugin dir path
     * set this in the $main_menu array.
     *
     * @var string.
     */
    private $plugin_path;

    /**
     * $page_title.
     *
     * (Required) The text to be displayed in the title tags of the page when the menu is selected.
     *
     * @var string
     */
    private $page_title;

    /**
     * $menu_title.
     *
     * (string) (Required) The text to be used for the menu.
     *
     * @var string
     *
     * @see https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $menu_title;

    /**
     * $capability.
     *
     * (string) (Required) The capability required for this menu to be displayed to the user.
     *
     * @var string
     *
     * @see https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $capability;

    /**
     * $menu_slug.
     *
     * (string) (Required) The slug name to refer to this menu by.
     * Should be unique for this menu page and only include lowercase alphanumeric,
     * dashes, and underscores characters to be compatible with sanitize_key().
     *
     * @var string
     *
     * @see https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $menu_slug;

    /**
     * $function.
     *
     * (callable) (Optional) The function to be called
     * to output the content for this page.Default value: ''
     *
     * @var string
     *
     * @see https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $function;

    /**
     * $icon_url.
     *
     * (string) (Optional) The URL to the icon to be used for this menu.
     * Pass a base64-encoded SVG using a data URI,
     * which will be colored to match the color scheme.
     * This should begin with 'data:image/svg+xml;base64,'.
     * Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
     * Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
     * Default value: ''
     *
     * @var string
     *
     * @see https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $icon_url;

    /**
     * $position.
     *
     * (int) (Optional) The position in the menu order this item should appear.
     * Default value: null
     *
     * @var int
     *
     * @see https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $position;

    /**
     * $prefix.
     *
     * Main menu prefix used to add prefix for page=$prefix-menu-slug.
     *
     * @var string
     */
    private $prefix;

    /**
     * $submenu_items.
     *
     * @var array submenu_items
     *
     * @see https://developer.wordpress.org/reference/functions/add_submenu_page/
     */
    private $submenu_items;

    /**
     * Menu color.
     *
     * @var string
     */
    private $mcolor = '#0071A1';

    /**
     * If Multisite is enabled.
     * Add menu page on multisite.
     *
     * @var bool
     *
     * @see https://developer.wordpress.org/reference/hooks/network_admin_menu/
     */
    private $network_admin = false;

    /**
     * Indicates whether the current menu is for a multisite network admin.
     *
     * This property is used to identify if the menu being rendered or processed
     * is specific to a multisite network administration panel. It is set internally
     * by the class constructor based on the context in which the menu is used.
     * When dealing with a multisite admin menu, this property is set to true,
     * otherwise it is set to false.
     *
     * Note: This is a private property and should be accessed or modified
     * through appropriate class methods, respecting its intended use within
     * the class's internal logic.
     *
     * @var bool True if the menu is for a multisite network admin, false otherwise.
     *
     * @see is_network_admin() method for context-dependent initialization.
     */
    private $_is_network_admin;

    /**
     * List of hidden submenu items.
     *
     * @var array
     */
    private $_hidden_submenus = [];

    /**
     * Initialization.
     *
     * @param array $menu_args
     *
     * @since 1.0
     */
    public function __construct( array $menu_args )
    {
        // user set menu title.
        $menu_title = static::get_user_title( get_option( 'ewl_menu_title', null ) );

        // define menu vars.
        $this->function      = [ $this, 'callback' ];
        $this->mcolor        = $menu_args['mcolor'] ?? $this->mcolor;
        $this->page_title    = $menu_args['page_title'] ?? 'Page Title';
        $this->menu_title    = $menu_args['menu_title'] ?? $menu_title;
        $this->capability    = $menu_args['capability'] ?? $this->manage_access();
        $this->menu_slug     = $menu_args['menu_slug'] ?? null;
        $this->icon_url      = $menu_args['icon_url'] ?? null;
        $this->position      = $menu_args['position'] ?? null;
        $this->prefix        = $menu_args['prefix'] ?? null;
        $this->plugin_path   = $menu_args['admin_views'] ?? plugin_dir_path( __FILE__ );
        $this->network_admin = $menu_args['network_admin'] ?? false;

        // is it network admin.
        $this->_is_network_admin = $this->is_network_admin();

        // Define a generic icon
        $this->generic_icon = 'dashicons-admin-generic';
    }

    /**
     * Make private/protected properties readable.
     *
     * @param string $name Property to get.
     *
     * @return mixed Property.
     */
    public function __get( $name )
    {
        if ( ! property_exists( $this, $name ) ) {
            throw new Exception( "Property:$name does not exist." );
        }

        return $this->$name;
    }

    /**
     * Array of submenu items.
     *
     * @return static
     *
     * @psalm-return array{0: string, 'role-access': array{name: string}, audio: array{name: string, sidebar: false}, youtube: array{name: string, sidebar: false}, 'channel-import': array{name: string}, 'playlist-import': array{name: string}, 'video-search': array{name: string}, 'add-channel': array{name: string}, 'video-manager': array{name: string}, queue: array{name: string}, 'user-queue': array{name: string, capability: 'read', hidden: false}, automation: array{name: string, hidden: false}, failed: array{name: string}, 'restrict-categories': array{name: string}, campaign: array{name: string, hidden: true}, apikey?: array{name: string, sidebar: true, hidden: false}}
     */
    public function set_submenus( ?array $submenus = null ): self
    {
        if ( ! empty( $submenus ) && \is_array( $submenus ) ) {
            /**
             * set submenu and apply filter.
             *
             * @var array
             */
            $this->submenu_items = apply_filters( '_ewl_admin_submenu', $submenus );

            return $this;
        }
        if ( \is_array( $submenus ) ) {
            /**
             * set submenu and apply filter.
             *
             * @var array
             */
            $this->submenu_items = apply_filters( '_ewl_admin_submenu', $submenus );

            return $this;
        }

        return $this;
    }

    /**
     * Initializes the menu with submenu items.
     *
     * @param array $menu_args     Arguments for the menu.
     * @param array $submenu_items Items for the submenu.
     *
     * @return void
     */
    public static function init( array $menu_args, array $submenu_items = [] ): void
    {
        $instance = static::class;

        // Instance creation of the current class
        $factory = new $instance( $menu_args );

        // Setting submenus and creating the menu
        $factory->set_submenus( $submenu_items )->create();
    }

    /**
     * Lets create the menu.
     *
     * We can Initialize as network only by setting `network_admin` or is_network to true.
     * else just setup regular website admin.
     *
     * @param bool $is_network set this to true if its a network admin.
     *
     * @see https://developer.wordpress.org/reference/hooks/network_admin_menu/
     * @see https://developer.wordpress.org/reference/hooks/admin_menu/
     */
    public function create( $is_network = false ): void
    {
        // setup hooks.
        $this->submenu_hooks = $this->set_submenu_hooks();

        if ( $this->_is_network_admin || $is_network ) {
            add_action( 'network_admin_menu', [ $this, 'build_menu' ] );
        } else {
            add_action( 'admin_menu', [ $this, 'build_menu' ] );
        }

        // load styles.
        add_action( 'admin_enqueue_scripts', [ $this, 'load_assets' ] );
    }

    /**
     * Admin Page Title.
     *
     * @since 1.0
     *
     * @return string
     */
    public function menu_title(): string
    {
        $menu_title  = '<h2 style="font-size:small;" class="wll-admin-dashicons-before ';
        $menu_title .= $this->icon_url;
        $menu_title .= '">';
        // $menu_title .= '<span class="wll-admin-title">';
        // $menu_title .= $this->page_title;
        // $menu_title .= '</span>';
        $menu_title .= '</h2>';

        return $menu_title;
    }

    /**
     * Load the admin page header.
     *
     * @return void
     */
    public function header( ?string $slug ): void
    {
        if ( ! is_user_logged_in() ) {
            wp_die();
        }

        do_action( '_ewl_admin_init', $slug );

        do_action( '_ewl_admin_head', $slug );

        // thickbox support
        add_thickbox();

        $this->notice_section_banner(); ?><header class="wll-header" style="box-shadow: 0 0 10px -5px rgb(0 0 0 / 50%); padding: 0px;">
			<div class="container-fluid">
			  <div class="row">
				<!-- <div class="col col-lg-2">
                    // echo $this->menu_title();
				</div> -->
				<div class="col">
					<?php $this->dynamic_tabs(); ?>
				</div>
			  </div>
			</div>
		</header>
		<div class="container-fluid">
			<?php $this->render_hidden_submenu( $slug ); ?>
		</div>
			<div class="wrap">
				<h2><!----></h2>
				<?php static::admin_notice_section( $this ); ?>
			  </div><!---wrap admin notices -->
		<div class="container-fluid">
			<div class="row">
			<div class="col">
				<div class="wll-main" style="box-shadow: none;">
		<?php
    }

    /**
     * Display section for ewl_admin_notice.
     *
     * @param object $instance The instance of the current class (AdminCore).
     *
     * @return
     */
    public static function admin_notice_section( $instance ): void
    {
        /**
         * Hook for attaching admin notices and related functionality.
         *
         * This action hook allows you to add custom admin notices and perform
         * additional actions when necessary. It provides both the unprefixed and
         * prefixed page names for flexibility in targeting specific pages.
         *
         * @since 18.0.0
         *
         * @param [type] $instance The instance of the current class (AdminCore).
         *
         * @example Usage:
         * ```php
         * add_action( 'ewl_admin_notice', 'your_custom_notice_function' );
         * function your_custom_notice_function( $instance ) {
         *     // Your custom admin notice logic here.
         * }
         * ```
         *
         * @phpstan-ignore-next-line
         */
        do_action( 'ewl_admin_notice', $instance );
    }

    /**
     * Display notice section.
     *
     * @param bool $display
     *
     * @return
     */
    public function notice_section_banner()
    {
        ?>
		<div id="wll-important-notice" style="color:white; background-color:<?php echo $this->mcolor; ?>;">
			  <span class="wll-banner-notice">
				<?php do_action( '_ewl_admin_banner' ); ?>
			  </span>
		</div>
		<?php
    }

    /**
     * Renders the content for a specific admin page.
     *
     * This method is responsible for generating the content of an admin page
     * within the WordPress admin area. It utilizes WordPress action hooks to
     * manage the output. The content is determined based on the provided page
     * name and optional submenu item details.
     *
     * @param null|string $spage        Optional. The specific page to render. Default null.
     * @param mixed       $submenu_item Optional. Details of the submenu item, if applicable. Default null.
     * @param null|string $submenu_slug Optional. The slug of the submenu, if applicable. Default null.
     *
     * @return void This method does not return any value.
     *
     * @hook "_ewl_admin_page_{$admin_page_hook}" Allows for custom actions to be executed during the rendering of the admin page. The dynamic part of the hook name is derived from the page name, converted to snake_case. The `$hooked_args` array is passed as a parameter, containing details such as the object instance, hook name, page name, slug, and submenu items.
     */
    public function page_content( ?string $spage = null, $submenu_item = null, ?string $submenu_slug = null ): void
    {
        $admin_page_hook = str_replace( '-', '_', $this->page_name() );

        /**
         * Prepares arguments for the admin page hook.
         *
         * This associative array is used to pass necessary data to the hook associated with the admin page.
         * It encapsulates various details about the current admin page in a structured format. This array is
         * later used as a parameter in the `do_action` call to provide context and information to any functions
         * hooked to the admin page action. It includes the object instance, the hook name, page name, submenu slug,
         * and submenu items. This structured approach allows hooked functions to have standardized access to
         * important data regarding the admin page.
         *
         * @var array       $hooked_args {
         *                  Array of arguments for the admin page hook.
         * @var object      $object The current object instance, $this in the context of the method.
         * @var string      $hook The admin page hook name, a sanitized version of the page name.
         * @var string      $page_name The name of the current admin page, as returned by `$this->page_name()`.
         * @var null|string $slug The slug of the submenu, if applicable, otherwise null.
         * @var array       $items An array of submenu items, as defined in `$this->submenu_items`.
         *                  }
         */
        $hooked_args = [
            'object'    => $this,
            'hook'      => $admin_page_hook,
            'page_name' => $this->page_name(),
            'slug'      => $submenu_slug,
            'items'     => $this->submenu_items,
        ];

        // if a view file exists we will override hook.
        $this->maybe_load_view_file( $spage );

        /**
         * Fires an action hook specific to the admin page.
         *
         * This function executes a custom action hook in WordPress, specifically designed
         * for the admin page. The hook name is dynamically generated using the admin page hook name
         * (converted to snake_case). It allows for extending or modifying the behavior of the admin page
         * by attaching custom functions to this hook. The function passes an associative array of
         * admin page arguments to any hooked functions.
         *
         * Usage of this hook enables developers to add custom functionality or data specific to
         * the admin page context, enhancing the flexibility and customizability of admin pages.
         *
         * "_ewl_admin_page_{$admin_page_hook}" The dynamic part of the hook name, derived from the admin page name.
         *
         * @param array $hooked_args An associative array of arguments related to the admin page. It includes:
         *                           - 'object' (object) The current object instance.
         *                           - 'hook' (string) The admin page hook name.
         *                           - 'page_name' (string) The name of the page.
         *                           - 'slug' (string|null) The slug of the submenu, if applicable.
         *                           - 'items' (array) The submenu items, if available.
         */
        do_action( "_ewl_admin_page_{$admin_page_hook}", $hooked_args );

        if ( ! \defined( 'WP_DEBUG' ) || false === WP_DEBUG ) {
            return;
        }

        if ( ! has_action( "_ewl_admin_page_{$admin_page_hook}" ) && current_user_can( $this->manage_access() ) ) {
            echo __( 'The following hook is missing a callback: ', 'wp-white-label-login' ) . "<strong>_ewl_admin_page_{$admin_page_hook}</strong>";
        }
    }


    /**
     * Load the admin page header.
     *
     * @param mixed $submenu_item
     *
     * @return void
     */
    public function footer( $submenu_item ): void
    {
        if ( isset( $submenu_item['name'] ) && 'YouTube' === $submenu_item['name'] ) {
            wp_enqueue_media();
            $this->print_media_uploader();
        }

        $submenu_hook = str_replace( '-', '_', $this->page_name() );

        ?>
        </p></div><!--wll-main -->
	</div><!---col-md-8 -->

		<?php if ( $this->get_submenu( 'sidebar', $submenu_item ) ) { ?>
		<div class="col-md-3">
			<?php do_action( "_ewl_admin_sidebar_{$submenu_hook}", $this ); ?>
			<?php do_action( '_ewl_admin_sidebar', $this ); ?>
		</div><!---col-md-4-->
	<?php } ?>
	  </div><!---row-->
	<div style="padding-left: 20px; padding-right: 40px;color: #b9b9b9;font-weight: 300;" class="">
			<?php do_action( '_ewl_admin_footer' ); ?>
			<?php echo esc_html( EASYWHITELABEL_VERSION ); ?>
			<hr>
		</div>
	  </div><!---container-fluid -->
		<?php
    }

    /**
     * Sidebar action hook.
     *
     * @return string the slug name.
     */
    public function sidebar(): string
    {
        return self::get_page_info( 'slug' );
    }

    public function print_media_uploader(): void
    {
        ?>
		<script type="text/javascript">
	    jQuery(document).ready(function($){
	        $('#upload_podcast_audio_file').click(function(e) {
	            e.preventDefault();

				function audioPreview(audioTitle) {
					return `<br><span class="dashicons dashicons-format-audio"></span> ${audioTitle}`;
				}

	            // Create a new media frame,
	            var frame = wp.media({
	                title: 'Select Podcast Audio MP3 File',
	                button: { text: 'Use this file' },
	                library: { type: 'audio/mpeg' },
	                multiple: false
	            });

	            // Handle file selection.
	            frame.on('select', function() {
	                var attachment = frame.state().get('selection').first().toJSON();
					console.log(attachment);
	                $('#mp3_audio_file_id').val(attachment.id); // Set the hidden field value
	                $('#desc_add_podcast_audio_file').fadeIn().html(audioPreview(attachment.filename)); // Set the hidden field value
	            });

	            // Open the frame.
	            frame.open();
	        });
	    });
	    </script>
		<?php
    }

    /**
     * Load admin assets.
     *
     * @param mixed $hook_suffix
     */
    public function load_assets( $hook_suffix )
    {
        $parent_slug = get_admin_page_parent( $this->menu_slug );

        if ( $parent_slug !== $this->menu_slug ) {
            return null;
        }

        wp_enqueue_style(
            'ewl-admin-css',
            EASYWHITELABEL_URL . 'assets/admin/admin.min.css',
            [],
            self::ADMINVERSION,
            'all'
        );
    }

    /**
     * Whats the version.
     *
     * @return null|string
     *
     * @psalm-return '6.0.0'|null
     */
    public function admin_gui_version(): ?string
    {
        if ( current_user_can( $this->manage_access() ) ) {
            return self::ADMINVERSION;
        }

        return null;
    }

    /**
     * Get the Page.
     *
     * @return string
     *
     * @since 1.0
     */
    public function current_page_title(): string
    {
        /**
         * WP page vars.
         *
         * @see https://developer.wordpress.org/reference/functions/get_current_screen/
         */
        $screen = get_current_screen();

        // get specific page name.
        $id_page_name = explode( '_', $screen->id );
        $current_page = $id_page_name[2];

        return sanitize_text_field( $current_page );
    }

    /**
     * The Callback.
     *
     * @since 1.0
     */
    public function callback()
    {
        return null;
    }

    /**
     * Get the page name.
     *
     * @return string
     */
    public function page_name(): string
    {
        return str_replace( $this->prefix . '-', '', $this->current_page_title() );
    }

    /**
     * Build the admin url.
     *
     * @param string $slug .
     *
     * @return string .
     */
    public function make_admin_url( $slug ): string
    {
        $slug = strtolower( $slug );

        if ( $this->_is_network_admin ) {
            return esc_url( network_admin_url( '/admin.php?page=' . $slug . '' ) );
        }

        return esc_url( admin_url( '/admin.php?page=' . $slug . '' ) );
    }

    /**
     * Menu_slug.
     *
     * Get the menu slug without the $prefix
     *
     * @return string
     */
    public function menu_slug(): string
    {
        return str_replace( $this->prefix . '-', '', $this->menu_slug );
    }

    /**
     * Main Menu.
     *
     * @see https://developer.wordpress.org/reference/functions/add_menu_page/
     * @since 1.0
     */
    public function build_menu(): void
    {
        // Prefix the slug to avoid any conflicts.
        $this->menu_slug = $this->prefix . '-' . $this->menu_slug;

        // if we have sub menu items ignore 'callback'.
        $main_callback = ( $this->submenu_items ) ? null : [ $this, 'callback' ];

        // Main Menu.
        add_menu_page(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            $main_callback,
            $this->icon_url,
            $this->position
        );

        /*
         * The admin submenu section.
         *
         * Here we build out the admin menus submenu items
         * for item 0 we will set the same slug as the main item
         *
         * @see https://developer.wordpress.org/reference/functions/add_submenu_page/
         * @see https://developer.wordpress.org/reference/functions/__/
         */
        foreach ( $this->submenu_items as $key => $submenus ) {
            $submenu_item = self::normalize( (int) $key, $submenus );

            // Access slugs and name.
            if ( 0 === $key ) {
                $submenu_slug   = $this->menu_slug;
                $submenu_access = $this->manage_access();
            } else {
                $submenu_access = $this->sub_capability( $key ) ?? $this->manage_access();
                // $submenu_slug   = sanitize_title( $this->prefix . '-' . $this->get_submenu( 'name' , $submenu_item ) );
                $submenu_slug = sanitize_title( $this->prefix . '-' . $key );
            }

            // Submenu page dir path.
            $spage = $this->get_submenu( 'views_dir', $submenu_item );

            // Parent menu slug (null to hide in main menu).
            if ( self::is_hidden( $submenu_item ) ) {
                $parent_id = null;
            } else {
                $parent_id = $this->get_submenu( 'parent', $submenu_item );
            }

            // ad submenu.
            add_submenu_page(
                $parent_id,
                ucfirst( $this->get_submenu( 'name', $submenu_item ) ),
                ucwords( $this->get_submenu( 'name', $submenu_item ) ),
                $submenu_access,
                $submenu_slug,
                function () use ( $spage, $submenu_item, $submenu_slug ): void {
                    $this->header( $submenu_slug );
                    $this->page_content( $spage, $submenu_item, $submenu_slug );
                    $this->footer( $submenu_item );
                }
            );
        }// end foreach
    }

    /**
     * Retrieves a specific submenu property based on a given key.
     *
     * This method is designed to fetch a specific property value from a submenu array.
     * It merges a predefined set of default parameters with the provided submenu parameters.
     * After merging, it returns the value associated with the specified key.
     * The method is useful for obtaining submenu properties like
     * name, parent menu slug, views directory, and flags for sidebar, visibility, or premium status.
     *
     * @since 1.0.0 [Add the version number since when this method is available]
     *
     * @param string $key      The key for the submenu parameter to retrieve. Expected keys include 'name', 'parent', 'views_dir', 'sidebar', 'hidden', 'premium'.
     * @param array  $submenus The associative array of submenu parameters. It should contain one or more of the following keys: 'name', 'parent', 'views_dir', 'sidebar', 'hidden', 'premium'.
     *
     * @return mixed Returns the value associated with the specified key in the submenu array. The return type can vary based on the key's corresponding value in the array.
     */
    public function get_submenu( $key, array $submenus )
    {
        $params = array_merge(
            [
                'name'      => $submenus['name'],
                'parent'    => $this->menu_slug,
                'views_dir' => null,
                'sidebar'   => true,
                'hidden'    => false,
                'premium'   => false,
            ],
            $submenus,
        );

        return $params[ $key ];
    }

    /**
     * Set submenu capability.
     *
     * @param string the submenu item key.
     *
     * @return null|string
     *
     * @psalm-return 'manage_network'|'manage_options'|null
     */
    public function sub_capability( ?string $subkey = null ): ?string
    {
        if ( \is_null( $subkey ) ) {
            return $this->manage_access();
        }

        return null;
    }

    /**
     * Get hidden submenu items.
     *
     * @return array
     */
    public function get_hidden(): array
    {
        return $this->_hidden_submenus;
    }

    public function is_network_managed(): bool
    {
        return is_network_admin();
    }

    /**
     * Get some info about the current admin screen.
     *
     * @param string $info the array item to return.
     *
     * @return array|string.
     */
    public static function admin_page_info( $info = null )
    {
        if ( ! is_admin() ) {
            return false;
        }
        $get_slug  = explode( '_page_', $GLOBALS['hook_suffix'] );
        $page_info = [
            'title'  => get_admin_page_title(),
            'slug'   => $get_slug[1],
            'suffix' => $GLOBALS['hook_suffix'],
            'screen' => get_current_screen(),
            'parent' => get_admin_page_parent(),
        ];

        if ( \is_null( $info ) ) {
            return $page_info;
        }

        return $page_info[ $info ];
    }

    protected static function get_user_title( ?string $menu_title ): string
    {
        // @phpstan-ignore-next-line
        if ( ! $menu_title || empty( $menu_title ) ) {
            return 'Podcast Import';
        }

        return $menu_title;
    }

    /**
     * Output for the dynamic tabs.
     *
     * @since 1.0
     */
    protected function dynamic_tabs(): void
    {
        echo '<span style="border: unset; padding-top: 0px;" class="wll-admin nav-tab-wrapper wp-clearfix">';

        foreach ( $this->submenu_items as $key => $submenus ) {
            $submenu_item = self::normalize( (int) $key, $submenus );

            // First item is always admin only.
            if ( 0 === $key ) {
                $submenu_slug   = $this->menu_slug;
                $submenu_access = $this->manage_access();
            } else {
                $submenu_slug   = sanitize_title( $this->prefix . '-' . $key );
                $submenu_access = $this->sub_capability( $key ) ?? $this->manage_access();
            }

            // Check if user has access for the menu.
            if ( ! current_user_can( $submenu_access ) ) {
                continue;
            }

            // Set Hidden Navigation Bar item.
            if ( self::is_hidden( $submenu_item ) ) {
                $this->_hidden_submenus[] = [
                    'slug' => $submenu_slug,
                    'item' => $submenu_item,
                ];

                continue;
            }

            // Build out the sub menu items.
            echo $this->nav_item( $submenu_slug, $submenu_item );
        }// end foreach
        echo '</span>';
    }

    /**
     * @param null|array $submenu_item
     */
    protected function nav_item( string $submenu_slug, ?array $submenu_item, bool $hidden = false )
    {
        if ( $submenu_slug === $this->current_page_title() ) {
            $tab_is_active = 'wll-admin-tab nav-tab-active';
            $color_style   = 'style="color:#787c82"';
        } else {
            $tab_is_active = 'wll-admin-tab';
            $color_style   = 'style="color:' . $this->mcolor . '"';
        }

        // handle hidden items.
        $tab_is_active = $hidden ? 'wll-hidden-tab' : $tab_is_active;
        $icocss        = $hidden ? 'wlh-icons' : 'wll-icons';

        // item icon
        $icon = $submenu_item['icon'] ?? 'dashicons-menu-alt2';

        $nav_link = '<a ' . $color_style . ' href="' . $this->make_admin_url( $submenu_slug ) . '">' . ucwords( $this->get_submenu( 'name', $submenu_item ) ) . '</a>';

        return '<span class="' . $tab_is_active . '"><span class="' . $icocss . ' dashicons ' . $icon . '"></span>' . $nav_link . '</span>';
    }

    protected function render_hidden_submenu( ?string $slug ): void
    {
        foreach ( $this->get_hidden() as $key => $submenu_item ) {
            // Build out hidden sub menu items.
            echo $this->nav_item( $submenu_item['slug'], $submenu_item['item'], true );
        }// end foreach
    }

    /**
     * @param null|string $spage
     */
    protected function maybe_load_view_file( ?string $spage ): void
    {
        if ( \is_null( $spage ) ) {
            $admin_path = $this->plugin_path;
        } else {
            $admin_path = $spage;
        }

        $adminfile = $admin_path . $this->menu_slug() . '/' . $this->page_name() . '.admin.php';

        if ( file_exists( $adminfile ) ) {
            require_once $adminfile;
        }
    }

    /**
     * Set access control.
     *
     * @return string
     *
     * @psalm-return 'manage_network'|'manage_options'
     */
    protected function manage_access(): string
    {
        if ( $this->_is_network_admin ) {
            return 'manage_network';
        }

        return 'manage_options';
    }

    /**
     * Initializes submenu item-specific hooks.
     *
     * Iterates over submenu items, assigning a unique hook for each. Handles special case for
     * the first item to use a default 'ewl-settings' key. Hook names are generated by sanitizing
     * the key names and prefixing with '_ewl_admin_page_'.
     *
     * @return array An associative array of submenu hooks.
     */
    private function set_submenu_hooks(): array
    {
        foreach ( $this->submenu_items as $key => $submenus ) {
            $submenu_item = self::normalize( (int) $key, $submenus );

            $named_hook_key = str_replace( '-', '_', sanitize_title( $submenu_item['name'] ) );

            $this->submenu_hooks[ $key ] = "_ewl_admin_page_{$named_hook_key}";
        }

        return $this->submenu_hooks;
    }

    /**
     * Check if this is a network menu.
     *
     * @return bool
     */
    private function is_network_admin(): bool
    {
        if ( $this->network_admin && is_multisite() ) {
            return true;
        }

        return false;
    }

    /**
     * Check if this is a hidden menu item.
     *
     * @param array|string $submenu_item
     *
     * @return bool
     */
    private static function is_hidden( $submenu_item ): bool
    {
        if ( isset( $submenu_item['hidden'] )
        && true === $submenu_item['hidden'] ) {
            return true;
        }

        return false;
    }

    /**
     * Sanitizes a given field name to ensure its safety for use as a key or file name.
     *
     * This method employs two WordPress-sanitization functions. Firstly, `sanitize_file_name`
     * is applied to the field name to remove special characters and ensure valid file name characters.
     * Secondly, `sanitize_key` is used to sanitize the string for use as a key, which involves
     * lowercasing and removing characters that are not alphanumeric or dashes.s
     *
     * @param string $fieldname The field name to be sanitized.
     *
     * @return string Returns the sanitized version of the field name suitable for use as a key or file name.
     */
    private static function sanitize( string $fieldname, bool $use_dashes = false ): string
    {
        $field_id = sanitize_key(
            sanitize_file_name( $fieldname )
        );

        if ( $use_dashes ) {
            return $field_id;
        }

        return str_replace( '-', '_', $field_id );
    }

    /**
     * Set submenu item as array since first item may be string.
     *
     * @param int          $key
     * @param array|string $submenu_item
     * @param mixed        $submenus
     *
     * @return array
     */
    private static function normalize( int $key, $submenus ): ?array
    {
        if ( \is_array( $submenus ) ) {
            return $submenus;
        }
        if ( \is_string( $submenus ) ) {
            return [ 'name' => $submenus ];
        }

        return null;
    }

    /**
     * Get some info about the current admin screen.
     *
     * @param string $info the array item to return.
     *
     * @return array|string.
     */
    private static function get_page_info( ?string $info = null )
    {
        if ( ! is_admin() ) {
            return false;
        }
        $get_slug  = explode( '_page_', $GLOBALS['hook_suffix'] );
        $page_info = [
            'title'  => get_admin_page_title(),
            'slug'   => $get_slug[1],
            'suffix' => $GLOBALS['hook_suffix'],
            'screen' => get_current_screen(),
            'parent' => get_admin_page_parent(),
        ];

        if ( \is_null( $info ) ) {
            return $page_info;
        }

        return $page_info[ $info ];
    }
}

<?php
/**
 * ----------------------------------------------------------------------------
 * @copyright 	Copyright © 2020 Uriel Wilson.
 * @package   	Wll_Admin_Menu
 * @version   	3.1.5
 * @license   	GPL-2.0+
 * @author    	Uriel Wilson
 * @link      	https://switchwebdev.com
 *
 * ----------------------------------------------------------------------------
 * How to use
 *
 * put in /includes/admin/class-sim-admin-menu.php
 * new up in /includes/admin/menu/my-new-custom-menu.php
 *
 * new Wll_Admin_Menu($my_new_menu);
 *
 * ----------------------------------------------------------------------------
 */

use Switchwebdev\Admin\Wll_Form\Wll_Form_Helper as Wll_Form;

final class Wll_Admin_Menu {

    /**
     * class version
     */
    const WPWLL_ADMIN_VERSION = '3.1.5';

    /**
     * $page_title
     *
     * (Required) The text to be displayed in the title tags of the page when the menu is selected.
     * @var string
     */
    private $page_title;

    /**
     * $menu_title
     *
     * (string) (Required) The text to be used for the menu.
     * @var string
     * @link https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $menu_title;

    /**
     * $capability
     *
     * (string) (Required) The capability required for this menu to be displayed to the user.
     * @var string
     * @link https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $capability;

    /**
     * $menu_slug
     *
     * (string) (Required) The slug name to refer to this menu by.
     * Should be unique for this menu page and only include lowercase alphanumeric,
     * dashes, and underscores characters to be compatible with sanitize_key().
     * @var string
     * @link https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $menu_slug;

    /**
     * $function
     *
     * (callable) (Optional) The function to be called
     * to output the content for this page.Default value: ''
     * @var string
     * @link https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $function;

    /**
     * $icon_url
     *
     * (string) (Optional) The URL to the icon to be used for this menu.
     * Pass a base64-encoded SVG using a data URI,
     * which will be colored to match the color scheme.
     * This should begin with 'data:image/svg+xml;base64,'.
     * Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
     * Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
     * Default value: ''
     * @var string
     * @link https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $icon_url;

    /**
     * $position
     *
     * (int) (Optional) The position in the menu order this item should appear.
     * Default value: null
     * @var int
     * @link https://developer.wordpress.org/reference/functions/add_menu_page/
     */
    private $position;

    /**
     * $prefix
     *
     * main menu prefix used to add prefix for page=$prefix-menu-slug
     * @var string
     */
    private $prefix;

    /**
     * $plugin
     *
     * get the current plugin object which gives access to plugin methods etc
     * @var object
     */
    private $plugin;

    /**
     * $wp_slug
     *
     * set the current plugin slug if its not
     * available in the WordPress repo use github user/slug
     * we will get this from the $plugin object
     * @var string
     */
    public $wp_slug;

    /**
     * $submenu_args
     *
     * @var array submenu_args
     * @link https://developer.wordpress.org/reference/functions/add_submenu_page/
     */
    private $submenu_args;

    /**
     * Stand alone Submenu for settings (options-general.php)
     *
     * Setup a seperate admin only menu without any sub menus
     * @link https://developer.wordpress.org/reference/functions/add_submenu_page/
     *
     * @var array $settings_args List of settings items
     * @var string $parent_slugs the parent page, defaults to WordPress Settings Menu
     * @var string $admin_only_capability who can access, defaults to Admin user Role
     * @var string $admin_smenu The admin menu
     * @since 1.0
     */
    private $settings_args;
    private $parent_slug  = 'options-general.php';
    private $admin_only_capability  = 'manage_options';
    private $admin_smenu;

    /**
     * Initialization
     *
     * @param array $main_menu     Main menu
     * @param array $submenu_items submenu items
     * @param array $admin_only special admin only menu
     * @since 1.0
     */
    function __construct(array $main_menu, array $submenu_items = array(), array $admin_only = array()) {

      // define main menu args
      $this->page_title = $main_menu[0];
      $this->menu_title = $main_menu[1];
      $this->capability = $main_menu[2];
      $this->menu_slug  = $main_menu[3];
      $this->function   = array( $this, 'menu_callback' );
      $this->icon_url   = $main_menu[5];
      $this->position   = $main_menu[6];
      $this->prefix     = $main_menu[7];
      $this->plugin     = $main_menu[8];

      // setup the slug
      $this->wp_slug     = $this->plugin->wp_slug();

      // submenu
      $this->submenu_args = $submenu_items;

      // Admin Only Settings Menu
      $this->settings_args = $admin_only;


      // ok lets create the menu
      add_action( 'admin_menu',array( $this, 'build_menu' ) );

      // styles_admin
      add_action( 'admin_enqueue_scripts',array( $this, 'admin_page_styles') );

      // footer_separator
      add_action( 'swa_footer',array( $this, 'footer_separator' ) );

    }

    /**
     * menu_args
     *
     * @return array get the menu args
     */
    public function menu_args(){
      $menu_args = array(
        $this->page_title,
        $this->menu_title,
        $this->capability,
        $this->menu_slug,
        $this->function,
        $this->icon_url,
        $this->position,
        $this->prefix,
        $this->plugin
      );
      return $menu_args;
    }

    /**
     * Compare PHP Version
     *
     * Chect to see if the PHP_VERSION matches the required version
     * for this plugin to work if not wp error with explanation "Minimum PHP Version 5.6 required"
     *
     * @param  string $min_version this is our min required version.
     * @return boolean if false then wp error
     */
    public static function compare_php_version($min_version = '5.6'){
      if (version_compare(PHP_VERSION, $min_version) >= 0) {
        return true;
      } else {
        return false;
      }
    }

    /**
     * get the instance
     * @return object
     */
    public function instance(){
      return new self($this->menu_args(),$this->submenu_args,$this->settings_args);
    }



    /**
     * Get the current plugin object
     *
     * this is an object passed in as the last param
     * when you define the $main_menu array that will give uss access
     * to all the methods vars etc if we need them.
     * @return object
     */
    public function plugin(){
      return $this->plugin;
    }

    /**
     * Styles on header action
     *
     * Simple CSS Styles
     */
    public function admin_page_styles() {
        wp_enqueue_style( 'wll-admin-style', plugin_dir_url( __FILE__ ) . 'css/wll-admin.css', array(), self::WPWLL_ADMIN_VERSION, 'all' );
    }

    /**
     * Footer action
     *
     * add <hr/>  to the footer section
     */
    public function footer_separator(){
      echo '<hr/>';
    }

    /**
     * Get the Page
     *
     * @return string
     * @since 1.0
     */
    public function get_thepage_name() {
      /**
       * wp page vars
       * @link https://developer.wordpress.org/reference/functions/get_current_screen/
       */
      $screen = get_current_screen();

      # get specific page name
      $id_page_name = explode('_', $screen->id);
      $current_page = $id_page_name[2];
      $current_page = sanitize_text_field($current_page);
      return $current_page;
    }

    /**
     * The Callback
     *
     * @since 1.0
     */
    public function menu_callback() {
      # get page name
      # we dont need the prefix here so remove it
      $mpage = str_replace($this->prefix.'-', '', $this->get_thepage_name());
      $this->admin_page($mpage);
    }

    /**
     * Admin Only Callback
     *
     * @since 2.0
     */
    public function adminonly_callback() {
      # get page name
      $mpage = $this->get_thepage_name();
      $this->admin_submenu_page($mpage);
    }

    /**
     * Admin Submenu
     *
     * @param  string $page_name
     * @since 2.0
     */
    public function admin_submenu_page() {
      # set page title
      $page_title = ucfirst($this->get_thepage_name());
      $this->admin_smenu = true;


      require_once plugin_dir_path( __FILE__ ). 'head.php';
      $this->autoload_admin_page($page_name);
      require_once plugin_dir_path( __FILE__ ). 'footer.php';
    }

    /**
     * Output for the dynamic tabs
     *
     * @since 1.0
     */
    public function dynamic_tab_menu() {

      echo '<h2 class="wll-admin nav-tab-wrapper wp-clearfix">';
      foreach ($this->submenu_args as $key => $subm_item) {
         #slugs
        if ($key == 0) {
            $subm_slug = $this->menu_slug;
        } else {
            $subm_slug = sanitize_title($this->prefix.'-'.$subm_item);
        }

          // build out the sub menu items
          if ($subm_slug == $this->get_thepage_name()) {
            echo '<a href="'.admin_url('/admin.php?page='.strtolower($subm_slug).'').'" class="wll-admin-tab nav-tab nav-tab-active">'.ucwords($subm_item).'</a>';
          } else {
            echo '<a href="'.admin_url('/admin.php?page='.strtolower($subm_slug).'').'" class="wll-admin-tab nav-tab nav-tab">'.ucwords($subm_item).'</a>';
          }
        }
      echo '</h2>';
    }

    /**
     * menu_slug
     *
     * get the menu slug without the $prefix
     * @return [type] [description]
     */
    public function menu_slug(){
      $m_slug = str_replace($this->prefix.'-','',$this->menu_slug);
      return $m_slug;
    }

    /**
     * Load the admin page
     *
     * @since 1.0
     * @param  string $admin_page the admin page name
     * @return
     */
    public function autoload_admin_page($admin_page) {

      if ($this->admin_smenu) {
        $wllform = new Wll_Form();
        $admin_file = plugin_dir_path( __FILE__ ). 'pages/admin-options/'.$admin_page.'.admin.php';
      } else {
        $wllform = new Wll_Form();
        $admin_file = plugin_dir_path( __FILE__ ). 'pages/'.$this->menu_slug().'/'.$admin_page.'.admin.php';
      }

      /**
       * Missing Admin file error
       *
       * provide some feedback here if we cant find the admin file
       * only show this to the admin user
       *
       */
      if (file_exists($admin_file)) {
        require_once $admin_file;
      } else {
        $file_location_error = '<h1> Menu file location error : Experiencing Technical Issues, Please Contact Admin </h1>';
          # only show full file path to admin user
        if ( current_user_can('manage_options') ) {
          $file_location_error  = '<h2> Please check file location, Page Does not Exist</h2>';
          $file_location_error .= '<span class="alert-danger">'.$admin_file . '</span> location of file was not found </p>';
        }
          // user feedback
          echo $file_location_error;
      }
    }

    /**
     * Admin Page
     *
     * @since 1.0
     * @param  string $page_name
     * @return
     */
    public function admin_page($page_name = 'admin') {

      $page_title = ucfirst($this->get_thepage_name());

      require_once plugin_dir_path( __FILE__ ). 'head.php';
      $this->autoload_admin_page($page_name);
      require_once plugin_dir_path( __FILE__ ). 'footer.php';
    }

    /**
     * Add Header Action
     *
     * @since 1.0
     * @return
     */
    public static function admin_header() {
      do_action('swa_head');
    }

    /**
     * Add Footer Action
     *
     * @since 1.0
     * @return
     */
    public static function admin_footer() {
      do_action('swa_footer');
    }

    /**
     * Build the menu
     *
     * @since 1.0
     * @return
     */
    public static function make_menu() {

      $menu_items = func_get_args();
      foreach ($menu_items as $menu_key => $menu_name) {
        /**
         * lets make it pretty
         * @link https://developer.wordpress.org/reference/functions/sanitize_title/
         */
        $menu_name = sanitize_title($menu_name);
        if ( file_exists( plugin_dir_path( __FILE__ ). 'menu/'.$menu_name.'.php' ) ) {
          require_once plugin_dir_path( __FILE__ ). 'menu/'.$menu_name.'.php';
        } else {
          $debug['make_menu_error'] = plugin_dir_path( __FILE__ ). 'menu/'.$menu_name.'.php';
        }
      }
    }

    /**
     * Admin Page Title
     *
     * @return
     * @since 1.0
     */
    public function get_menu_title(){
      $menu_title = '<h2 class="wll-admin-dashicons-before ';
      $menu_title .= $this->icon_url;
      $menu_title .= '">';
      $menu_title .= $this->page_title;
      $menu_title .= '</h2>';
      return $menu_title;
    }

    /**
     * Main Menu
     *
     * @return
     * @link https://developer.wordpress.org/reference/functions/add_menu_page/
     * @since 1.0
     */
    public function build_menu() {

      // prefix the slug to avoid any conflicts
      $this->menu_slug = $this->prefix.'-'.$this->menu_slug;

      // Main Menu
      add_menu_page(
        $this->page_title,
        $this->menu_title,
        $this->capability,
        $this->menu_slug,
        array( $this, 'menu_callback' ),
        $this->icon_url,
        $this->position
      );

      /**
       * The admin submenu section
       *
       * here we build out the admin menus submenu items
       * for item 0 we will set the same slug as the main item
       * @link https://developer.wordpress.org/reference/functions/add_submenu_page/
       */
      foreach ($this->submenu_args as $key => $subm_item) {
        #slugs
        if ($key == 0) {
          // change the slug for first item to match parent slug
          $subm_slug = $this->menu_slug;
        } else {
          // keep current slug
          $subm_slug = sanitize_title($this->prefix.'-'.$subm_item);
        }
          // build out the sub menu items
          add_submenu_page(
            $this->menu_slug,
            ucfirst($subm_item),
            ucwords($subm_item),
            $this->capability,
            $subm_slug,
            array( $this, 'menu_callback' )
          );
        }

        /**
         * Admin Only Settings Menu
         *
         * Here is where we build a custom settings section under
         * the settings menu in WordPress Admin Backend
         * this is only accessible to Administrators
         */
        foreach ($this->settings_arg() as $akey => $admin_item) {
          $admin_slug = sanitize_title($admin_item);
          add_submenu_page(
            $this->parent_slug,
            ucfirst($admin_item),
            ucwords($admin_item),
            $this->admin_only_capability,
            $admin_slug,
            array( $this, 'adminonly_callback' )
          );
        }
    }

    /**
     * Admin Only Settings Menu
     *
     * @since 1.0
     * @return
     */
    public function settings_arg(){
        return $this->settings_args;
    }

}

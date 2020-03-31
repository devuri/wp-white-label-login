<?php

/**
 * Admin Menu
 */
class WPWLL_Settings {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {
        add_submenu_page( 'options-general.php', __( 'White Label Login', 'white-label-login' ), __( 'White Label Login', 'white-label-login' ), 'manage_options', 'white-label-login-options', array( $this, 'plugin_page' ) );

        // add page without menu
        //add_submenu_page( 'options.php', __( 'White Label Login', 'white-label-login' ), __( 'White Label Login', 'white-label-login' ), 'manage_options', 'white-label-login-options', array( $this, 'plugin_page' ) );
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
      $template = dirname( __FILE__ ) . '/admin/views/wll-options.php';
      require_once $template;
    }
}

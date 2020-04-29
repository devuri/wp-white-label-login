<?php

namespace WPWhiteLabel;

use WPAdminPage\AdminPage;

class WhiteLabelAdmin {
  /**
   * admin_menu()
   *
   * Main top level admin menus
   * @return [type] [description]
   */
  private static function admin_menu(){
    $menu = array();
    $menu[] = 'White Label Login Settings';
    $menu[] = 'WP White Label';
    $menu[] = 'manage_options';
    $menu[] = 'white-label-options';
    $menu[] = 'wllmenu_callback';
    $menu[] = 'dashicons-art';
    $menu[] = 6.5;
    $menu[] = 'wll';
    $menu[] = wpwhitelabel();
    return $menu;
  }

  /**
   * submenu()
   * array of submenu items
   * @return [type] [description]
   */
  private static function submenu(){
    $submenu = array();
    $submenu[] = 'Logo';
    $submenu[] = 'Background';
    $submenu[] = 'CSS';
    $submenu[] = 'Useful Plugins';
    return $submenu;
  }
  /**
   * [whitelabeladmin description]
   * @return [type] [description]
   */
  public static function init(){
    return new AdminPage(self::admin_menu(),self::submenu());
  }
}

  // create admin pages
  WhiteLabelAdmin::init();

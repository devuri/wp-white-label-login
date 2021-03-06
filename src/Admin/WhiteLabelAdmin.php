<?php

namespace WPWhiteLabel\Admin;

use WPWhiteLabel\WPAdmin\AdminPage;

final class WhiteLabelAdmin extends AdminPage {
	/**
	 * admin_menu()
	 *
	 * Main top level admin menus
	 * @return [type] [description]
	 */
	private static function admin_menu(){

		$menu = array();
		//$menu['mcolor']       = '#009688';
		$menu['page_title']   = 'White Label Login Settings ';
		$menu['menu_title']   = 'WP White Label';
		$menu['capability']   = 'manage_options';
		$menu['menu_slug']    = 'white-label-options';
		$menu['function']     = 'wllmenu_callback';
		$menu['icon_url']     = 'dashicons-art';
		$menu['prefix']       = 'wll';
		$menu['plugin_path']  =  plugin_dir_path( __FILE__ );
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
	 * @return self
	 */
	public static function init(){
	    return new WhiteLabelAdmin(self::admin_menu(),self::submenu());
	}
}

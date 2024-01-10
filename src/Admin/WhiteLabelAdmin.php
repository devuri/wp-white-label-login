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
	    return array(
			'page_title'  => 'White Label Login Settings ',
			'menu_title'  => 'WP White Label',
			'capability'  => 'manage_options',
			'menu_slug'   => 'white-label-options',
			'function'    => 'wllmenu_callback',
			'icon_url'    => 'dashicons-art',
			'prefix'      => 'wll',
			'plugin_path' => plugin_dir_path( __FILE__ )
		);
	}

	/**
	 * submenu()
	 * array of submenu items
	 * @return [type] [description]
	 */
	private static function submenu(){
	    return array(
			'Logo',
			'Background',
			'CSS',
			'Useful Plugins'
		);
	}

	/**
	 * [whitelabeladmin description]
	 * @return self
	 */
	public static function init(){
	    return new WhiteLabelAdmin(self::admin_menu(),self::submenu());
	}
}

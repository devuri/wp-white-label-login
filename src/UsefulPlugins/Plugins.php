<?php

namespace WPWhiteLabel\UsefulPlugins;

use \Connekt_Plugin_Installer;

/**
 *
 */
final class Plugins extends Connekt_Plugin_Installer {

	/**
	 * Build the plugin list
	 * @return [type] [description]
	 */
	public static function useful_plugins(){
	    $plugin_list = array();
			$plugin_list[]	= 'membership-lock';
			$plugin_list[]	= 'wp-white-label-login';
	    $plugin_list[]	= 'iceyi-members-only';
	    $plugin_list[]	= 'sim-clickable-links';
	    $plugin_list[]	= 'better-search-replace';
	    $plugin_list[]	= 'disable-comments';
	    $plugin_list[]	= 'wp-seopress';
	    $plugin_list[]	= 'login-recaptcha';
	    $plugin_list[]	= 'sucuri-scanner';
	    $plugin_list[]	= 'wpforms-lite';
	    $plugin_list[]	= 'wp-mail-smtp';
	    $plugin_list[]	= 'wp-dbmanager';


	    if(class_exists('Connekt_Plugin_Installer')){
	      self::init($plugin_list);
	    }

	}

}

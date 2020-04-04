<?php
/**
 *  Uninstall stuff.
 *  do some cleanup after user uninstalls the plugin
 *  ----------------------------------------------------------------------------
 *  -remove stuff
 * ----------------------------------------------------------------------------
 * @category  	Plugin
 * @copyright 	Copyright © 2020 Uriel Wilson.
 * @package   	WhiteLabelLogin
 * @author    	Uriel Wilson
 * @link      	https://switchwebdev.com
 * ----------------------------------------------------------------------------
 */

	# deny direct access
  if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	  die;
  }

  # delete settings in the options table.
	delete_option('wpwll_logo_url');
	delete_option('wpwll_background_url');
	delete_option('wpwll_align');
	delete_option('wpwll_custom_css');
	delete_option('wpwll_copyright_text');
	delete_option('wpwll_options');

<?php
/**
*---------------------------------------------------------------------------------
*	@package  WP White Label Login by DeVision7.com
*	@copyright  Copyright (c) 2017
*---------------------------------------------------------------------------------
*
*	Plugin Name: WP White Label Login
*	Plugin URI: http://alpha.devision7.com/wordpress-plugins/
* GitHub Plugin URI: devuri/wp-white-label-login
*	Description: Simple one click very light weight, White Label Log in, Registration and Lost Password Page, Activate it and forget it...
*	Version: 1.0.0
*	Author: DeVision7.com
*	Author URI: http://devision7.com
*	Contributors: DeVision7.com
*	License: GPLv2 or later
*	License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*	Text Domain: wp-white-label-login
*	Domain Path: /languages
*	Usage: .
*	Tags:
*
*
*	Requires PHP: 5.2+
*	Tested up to PHP: 7.0
*
*	Copyright 2017 DeVision7.com	(email : uriel.zipteq@gmail.com)
*	License: GNU General Public License
*	GPLv2 Full license details in license.txt
*---------------------------------------------------------------------------------------------------------------------------------------------------------
*
*	WP White Label Login is built using the Dv7 Plugin QuickStarter @ http://wp.deVision7.com/, (C) 2015- 2017 DeVision7.
*
*	WP White Label Login , like WordPress, is licensed under the GPL.
*	Use it to make something cool, have fun, and share.
*
*	WP White Label Login  is free software; you can redistribute it and/or
*	modify it under the terms of the GNU General Public License
*	as published by the Free Software Foundation; either version 2
*	of the License, or (at your option) any later version.
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details.
*
*	You should have received a copy of the GNU General Public License
*	along with WP White Label Login. If not, see http://www.gnu.org/licenses/
*---------------------------------------------------------------------------------------------------
*/


	// * DIRECT ACCESS DENIED *
	if ( ! defined( "WPINC" ) ) {
		die;
	}


	//plugin directory CONSTANT
	define("D7WPWHITELABELLOGIN_DIR", dirname(__FILE__));

	//PLUGIN URL
	define("D7WPWHITELABELLOGIN_URL", plugins_url( "/",__FILE__ ));

    /*
    *--------------------------------------------------------------------------
    * Start Plugin Code Here
    *--------------------------------------------------------------------------
    *
    * Ok .
    *
    */

		/* ====================================== LOGIN CSS =======================================*/


			function d7wpwll_login_styles() {

				wp_enqueue_style( 'style-login-styles', plugins_url('styles/login-style.css', __FILE__ ) );

			}
			add_action( 'login_enqueue_scripts', 'd7wpwll_login_styles' );

		/* ====================================== LOGIN HEAD =======================================*/


function d7wpwll_login_header() {

	$wpsite_title = get_bloginfo( 'name' );
	$site_url = get_bloginfo( 'url' );

// -----------HEADER
	echo '<h1 align="center"> '.$wpsite_title.' </h1> </<br/><br/> <hr/><p align="center"> <a href=" '.$site_url.' ">'.$wpsite_title.'</a> | <a href="'.$site_url.'/wp-admin">Dashboard</a> </p>';

	}

	add_filter('login_head', 'd7wpwll_login_header');


//----------- CHANGE LOGO link

function d7wpwll_loginlogo_url() {

	$site_url = get_bloginfo( 'url' );
	return $site_url;
}

add_filter( 'login_headerurl', 'd7wpwll_loginlogo_url' );


/* ====================================== LOGIN FOOTER =======================================*/

function d7wpwll_login_footer() {

	$wpsite_title = get_bloginfo( 'name' );
	$site_url = get_bloginfo( 'url' );

// ----------- FOOTER
	echo '<hr/><p align="center"> <br/><br/> © 2017 <a href=" '.$site_url.' ">'.$wpsite_title.'</a> All Rights Reserved. <br/><br/></p> ';

	}

	add_filter('login_footer', 'd7wpwll_login_footer');

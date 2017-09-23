<?php
/**
*---------------------------------------------------------------------------------
*	@package  WP White Label Login  by DeVision7.com
*	@copyright  Copyright (c) 2017
*---------------------------------------------------------------------------------
*
*	Plugin Name: WP White Label Login
*	Plugin URI: http://devision7.com/wordpress-plugins/
*	Description: Simple one click very light weight, White Label Log in, Registration and Lost Password Page, Activate it and forget it....
*	Version: 1.4.0
*	Author: Devuri
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
*----------------------------------------------------------------------------------------------------
*	WP White Label Login  , like WordPress, is licensed under the GPL.
*	Use it to make something cool, have fun, and share.
*
*	WP White Label Login   is free software; you can redistribute it and/or
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
*	along with WP White Label Login . If not, see http://www.gnu.org/licenses/
*---------------------------------------------------------------------------------------------------
*/

	// * DIRECT ACCESS DENIED *
	if ( ! defined( "WPINC" ) ) {
		die;
	}


	//plugin directory CONSTANT
	define("DVWPWHITELABELLOGIN_DIR", dirname(__FILE__));

	//PLUGIN URL
	define("DVWPWHITELABELLOGIN_URL", plugins_url( "/",__FILE__ ));


//enqueue scripts and styles------------------------------------>
function wpwll_login_styles() {

	wp_enqueue_style( 'style-login-styles', plugins_url('css/login-style.css', __FILE__ ) );

}
add_action( 'login_enqueue_scripts', 'wpwll_login_styles' );

//header-------------------------------------------------------->
		function wpwll_login_header() {

			$wpsite_title = get_bloginfo( 'name' );
			$site_url = get_bloginfo( 'url' );
			$admin_url = get_admin_url();
			//$wpllbackground = '/wp-content/uploads/pexels-photo-577585.jpeg';
			$wpllbackground_color = '#ffffff';
			echo '<br/><br/><h2 align="center"><a  href="'.$site_url.'" title="'.$wpsite_title.'">'.$wpsite_title.'</a></h2><br/><br/> ';
			echo '<hr/><div style="background-color: '.$wpllbackground_color.'; background-position: center; background-image: url('.$wpllbackground.'); background-attachment: fixed;"><br/>';

		}
		add_filter('login_head', 'wpwll_login_header');

//change logo link----------------------------------------------->
		function wpwll_loginlogo_url() {

			$site_url = get_bloginfo( 'url' );
			return $site_url;
		}
		add_filter( 'login_headerurl', 'wpwll_loginlogo_url' );

//change logo link title----------------------------------------->
		function wpwll_loginlogo_title() {

			$site_description = get_bloginfo( 'description' );
		  return $site_description;
		}
		add_filter( 'login_headertitle', 'wpwll_loginlogo_title' );

//footer-------------------------------------------------------->
		function wpwll_login_footer() {

			$wpsite_title = get_bloginfo( 'name' );
			$site_url = get_bloginfo( 'url' );
			$c_year = date("Y");
			echo '<br/><br/> </div>';
			echo '<hr/><p align="center"> <br/><br/> © '.$c_year.' <a href=" '.$site_url.' ">'.$wpsite_title.'</a> All Rights Reserved. <br/><br/></p> ';

		}
		add_filter('login_footer', 'wpwll_login_footer');

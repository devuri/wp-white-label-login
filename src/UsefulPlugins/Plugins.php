<?php

namespace WPWhiteLabel\UsefulPlugins;

use \Connekt_Plugin_Installer;

/**
 * usefull plugins list
 */
final class Plugins extends Connekt_Plugin_Installer {

	/*
		* render_template
		* Render display template for each plugin.
		*
		*
		* @param $plugin            Array - Original data passed to init()
		* @param $api               Array - Results from plugins_api
		* @param $button_text       String - text for the button
		* @param $button_classes    String - classnames for the button
		*
		* @since 1.0
		*/
	public static function render_template($plugin, $api, $button_text, $button_classes){?>
		 <div class="plugin">
			 <img style="width:100%;" src="<?php echo $api->banners['low']; ?>" alt="">
			<div style="padding:20px;" class="plugin-wrap">
					 <h2><?php echo $api->name; ?></h2>
					 <p><?php echo $api->short_description; ?></p>
					 <p class="plugin-author"><?php _e('By', 'framework'); ?> <?php echo $api->author; ?></p>
		 </div>
		 <ul class="activation-row">
					 <li>
							<a class="<?php echo $button_classes; ?>"
								data-slug="<?php echo $api->slug; ?>"
						data-name="<?php echo $api->name; ?>"
							href="<?php echo get_admin_url(); ?>/update.php?action=install-plugin&amp;plugin=<?php echo $api->slug; ?>&amp;_wpnonce=<?php echo wp_create_nonce('install-plugin_'. $api->slug) ?>">
					<?php echo $button_text; ?>
							</a>
					 </li>
					 <li>
							<a href="https://wordpress.org/plugins/<?php echo $api->slug; ?>/" target="_blank">
								 <?php _e('More Details', 'frameworks'); ?>
							</a>
					 </li>
				</ul>
	 </div>
	<?php
	}

	/*
	* init
	* Initialize the display of the plugins.
	*
	*
	* @param $plugin            Array - plugin data
	*
	* @since 1.0
	*/
	public static function init($plugins){ ?>
		 <div class="cnkt-plugin-installer">
		 <?php
				require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

		 foreach($plugins as $plugin) :

					 $button_classes = 'install button';
					 $button_text = __('Install Now', 'framework');

					 $api = plugins_api( 'plugin_information',
							array(
								 'slug' => sanitize_file_name($plugin),
								 //'slug' => sanitize_file_name($plugin['slug']),
								 'fields' => array(
										'short_description' => true,
										'sections' => false,
										'requires' => false,
										'downloaded' => true,
										'last_updated' => false,
										'added' => false,
										'tags' => false,
										'compatibility' => false,
										'homepage' => false,
										'donate_link' => false,
										'icons' => true,
										'banners' => true,
								 ),
							)
					 );

			if ( !is_wp_error( $api ) ) {
						 $main_plugin_file = Connekt_Plugin_Installer::get_plugin_file($plugin); // Get main plugin file
						 if(self::check_file_extension($main_plugin_file)){ // check file extension
							if(is_plugin_active($main_plugin_file)){
									// plugin activation, confirmed!
									$button_classes = 'button disabled';
									$button_text = __('Activated', 'framework');
								} else {
									 // It's installed, let's activate it
									$button_classes = 'activate button button-primary';
									$button_text = __('Activate', 'framework');
								}
						 }
						 // Send plugin data to template
						 self::render_template($plugin, $api, $button_text, $button_classes);
					 }
		endforeach;
		?>
		 </div>
	<?php
	}
	/**
	 * Build the plugin list
	 * @return [type] [description]
	 */
	public static function useful_plugins(){

		$plugin_list = array();
		$plugin_list[]	= 'membership-lock';
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

			/**
			 * load the plugins list
			 *
			 * uses the Connekt_Plugin_Installer class
			 * @var [type]
			 */
	    if(class_exists('Connekt_Plugin_Installer')){
	      self::init($plugin_list);
	    }

	}

}

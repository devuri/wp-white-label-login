<?php

/**
 *
 */
final class Customizer {


	/**
	 * Registered instances of WP_Customize_Setting.
	 *
	 * @since 3.4.0
	 * @var array
	 */
	public $plugin;

	function __construct($white_label_login){

		/**
		 * Register a section.
		 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
		 * @credit WordPress Customize Manager classes
		 */
		add_action( 'customize_register', array( $this , 'setup') , 12, 1 );

		//load the plugin
		$this->plugin = $white_label_login;
	}

	/**
   * Sets up the WP_Customize_Manager
   * @return object WP_Customize_Manager
   */
  public function customizer(){
    global $wp_customize;
    return $wp_customize;
  }

	/**
	 * customizer
	 * @param   $wp_customize [description]
	 * @return object
	 * @link https://core.trac.wordpress.org/browser/tags/5.4/src/wp-includes/class-wp-customize-manager.php#L928
	 */
	public function setup() {
		// Add Panel.
		$this->customizer()->add_panel( 'wll_options_panel', array(
			'priority'       => 180,
			'capability'     => 'manage_options',
			'theme_supports' => '',
			'title'          => esc_html__( 'White  Label Login Options', 'whitelabel-login' ),
			)
		);

		/**
		 * [$this->sections description]
		 * @var [type]
		 */
		$this->sections();

		/**
		 * Load up the Settings
		 * @var [type]
		 */
		$this->settings();
	}

	/**
	 * [description description]
	 * @return [type] [description]
	 */
	public function description(){
		/**
		 * [$description panel description ]
		 * @var string
		 */
		$description  = '<h3 class="wp-ui-text-highlight"> White Label Login Options </h3>';
		$description .= '<p>';
		$description .= __( 'If you found a bug or have suggestions head over to the.' );
		$description .= sprintf(
			' <a href="%1$s" class="external-link" target="_blank">%2$s<span class="screen-reader-text"> %3$s</span></a>',
			esc_url( __( 'https://wordpress.org/support/plugin/wp-white-label-login' ) ),
			__( 'Plugins Support Section.' ),
			/* translators: Accessibility text. */
			__( '(opens in a new tab)' )
		);
		$description .= '</p>';
		return $description;
	}

	/**
	 * [sections description]
	 * @return [type] [description]
	 */
	public function sections(){

		foreach (WPWhiteLabel\customizer_sections() as $seckey => $section) {

			/**
			 * build out each section.
			 * @var [type]
			 */
			$this->customizer()->add_section( 'white_label_'.trim($section),
				array(
					'title'              => __( '* '. trim(ucwords($section)) ),
					'capability'				 => 'manage_options',
					'description'        => $this->description(),
					'panel'        			 => 'wll_options_panel',
				)
			);

		} // foreach
	}

	/**
	 * [settings description]
	 * @return [type] [description]
	 */
	public function settings(){
		/**
		 * Autoload the options page
		 * @var [type]
		 */
		foreach (WPWhiteLabel\customizer_sections() as $optkey => $option) {
			require_once plugin_dir_path( __FILE__ )	. 'Settings/'.$option.'.php';
		}
	}
}

<?php
/**
 * Upgrade Control
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Displays the upgrade message .
	 */
	class WllCustomizeProControl extends WP_Customize_Control {
		/**
		 * Render Control
		 */
		public function render_content() {
			?>

			<div class="upgrade-pro-version">

				<span class="customize-control-title"><?php esc_html_e( 'Pro Version Add-on', 'whitelabel-login' ); ?></span>

				<span class="textfield">
					<?php printf( esc_html__( 'Purchase the %s Add-on to get additional features and advanced customization options.', 'whitelabel-login' ), 'White Label Login Pro' ); ?>
				</span>

				<p>
					<a href="<?php echo esc_url( __( 'https://whitelabelwp.net/add-ons/whitelabel-login-pro/', 'whitelabel-login' ) ); ?>" target="_blank" class="button button-secondary">
						<?php printf( esc_html__( 'Learn more about %s', 'whitelabel-login' ), 'White Label Login Pro' ); ?>
					</a>
				</p>

			</div>

			<?php
		}
	}

endif;
/**
 *
 */
final class WhiteLabelCustomizer {


	/**
	 * Registered instances of WP_Customize_Setting.
	 *
	 * @since 3.4.0
	 * @var array
	 */
	public $plugin;

	function __construct($wll){
		/**
		 * Register a section.
		 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
		 * @credit WordPress Customize Manager classes
		 */
		add_action( 'customize_register', array( $this , 'customizer') , 12, 1 );

		//load the plugin
		$this->plugin = $wll;
	}

	/**
	 * customizer
	 * @param   $wp_customize [description]
	 * @return object
	 * @link https://core.trac.wordpress.org/browser/tags/5.4/src/wp-includes/class-wp-customize-manager.php#L928
	 */
	public function customizer( $wp_customize ) {

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

		// Add Panel.
		$wp_customize->add_panel( 'wll_options_panel', array(
			'priority'       => 180,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => esc_html__( 'White  Label Login Options', 'whitelabel-login' ),
			)
		);

		// Add Section.
		$wp_customize->add_section( 'white_label_layout',
			array(
				'title'              => __( 'Layout' ),
				//'priority'           => 210,
				'capability'				 => 'manage_options',
				//'description_hidden' => true,
				'description'        => $description,
				'panel'        			 => 'wll_options_panel',
			)
		);

		// Add Section.
		$wp_customize->add_section( 'white_label_logo',
			array(
				'title'              => __( 'Login Logo' ),
				//'priority'           => 210,
				'capability'				 => 'manage_options',
				//'description_hidden' => true,
				'description'        => $description,
				'panel'        			 => 'wll_options_panel',
			)
		);

		/**
		 * [$wp_customize->add_section description]
		 * @var [type]
		 */
		$wp_customize->add_section( 'white_label_background',
			array(
				'title'              => __( 'Login Background' ),
				//'priority'           => 210,
				'capability'				 => 'manage_options',
				//'description_hidden' => true,
				'description'        => $description,
				'panel'        			 => 'wll_options_panel',
			)
		);

		/**
		 * [$wp_customize->add_section description]
		 * @var [type]
		 */
		$wp_customize->add_section( 'white_label_css',
			array(
				'title'              => __( 'Custom Login CSS' ),
				//'priority'           => 210,
				'capability'				 => 'manage_options',
				//'description_hidden' => true,
				'description'        => $description,
				'panel'        			 => 'wll_options_panel',
			)
		);

		/**
		 * [$wp_customize->add_section description]
		 * @var [type]
		 */
		$wp_customize->add_section( 'white_label_footer',
			array(
				'title'              => __( 'Login Footer' ),
				//'priority'           => 210,
				'capability'				 => 'manage_options',
				//'description_hidden' => true,
				'description'        => $description,
				'panel'        			 => 'wll_options_panel',
			)
		);

		/**
		 * [$wp_customize->add_section description]
		 * @var [type]
		 */
		$wp_customize->add_section( 'white_label_extras',
			array(
				'title'              => __( 'Extras' ),
				//'priority'           => 210,
				'capability'				 => 'manage_options',
				'description_hidden' => true,
				'description'        => $description,
				'panel'        			 => 'wll_options_panel',
			)
		);

		/**
		 * Load up the Settings
		 * @var [type]
		 */
		require_once plugin_dir_path( __FILE__ )	. 'Settings/Logo.php';
		require_once plugin_dir_path( __FILE__ )	. 'Settings/Layout.php';
		require_once plugin_dir_path( __FILE__ )	. 'Settings/Background.php';
		require_once plugin_dir_path( __FILE__ )	. 'Settings/Css.php';
		require_once plugin_dir_path( __FILE__ )	. 'Settings/Copyright.php';
		require_once plugin_dir_path( __FILE__ )	. 'Settings/Extras.php';
	}
}

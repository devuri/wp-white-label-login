<?php


/**
 *
 */
final class Wll_Customizer {

		function __construct($wll){
			/**
			 * Register a section.
			 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
			 * @credit WordPress Customize Manager classes
			 */
			add_action( 'customize_register', array( $this , 'customizer') , 12, 1 );
		}

		/**
		 * customizer
		 * @param   $wp_customize [description]
		 * @return object
		 * @link https://core.trac.wordpress.org/browser/tags/5.4/src/wp-includes/class-wp-customize-manager.php#L928
		 */
		public function customizer( $wp_customize ) {
			/* White_Label_Login CSS */
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
			$description .= '<p id="editor-keyboard-trap-help-1">' . __( 'When using a keyboard to navigate:' ) . '</p>';
			$description .= '<ul>';
			$description .= '<li id="editor-keyboard-trap-help-2">' . __( 'In the editing area, the Tab key enters a tab character.' ) . '</li>';
			$description .= '<li id="editor-keyboard-trap-help-3">' . __( 'To move away from this area, press the Esc key followed by the Tab key.' ) . '</li>';
			$description .= '<li id="editor-keyboard-trap-help-4">' . __( 'Screen reader users: when in forms mode, you may need to press the Esc key twice.' ) . '</li>';
			$description .= '</ul>';

			// Add Theme Options Panel.
			$wp_customize->add_panel( 'wll_options_panel', array(
				'priority'       => 180,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => esc_html__( 'White  Label Login Options', 'gridbox' ),
			) );

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

			// logo
				require_once plugin_dir_path( __FILE__ ). 'setting/logo.php';

			// background
				require_once plugin_dir_path( __FILE__ ). 'setting/background.php';

			// css
				require_once plugin_dir_path( __FILE__ ). 'setting/custom-css.php';

				require_once plugin_dir_path( __FILE__ ). 'setting/blogname.php';

			// copyright
				require_once plugin_dir_path( __FILE__ ). 'setting/copyright-text.php';

		}
}

	$wll_customizer = new Wll_Customizer($wll);

<?php
/**
 * Register a section.
 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
 * @credit WordPress Customize Manager classes
 */
add_action( 'customize_register', function( $wp_customize ) {
	/* White_Label_Login CSS */
	$wll_section_description  = '<h3 class="wp-ui-text-highlight"> White Label Login Options </h3>';
	$wll_section_description .= '<p>';
	$wll_section_description .= __( 'If you found a bug or have suggestions head over to the.' );
	$wll_section_description .= sprintf(
		' <a href="%1$s" class="external-link" target="_blank">%2$s<span class="screen-reader-text"> %3$s</span></a>',
		esc_url( __( 'https://wordpress.org/support/plugin/wp-white-label-login' ) ),
		__( 'Plugins Support Section.' ),
		/* translators: Accessibility text. */
		__( '(opens in a new tab)' )
	);
	$wll_section_description .= '</p>';
	$wll_section_description .= '<p id="editor-keyboard-trap-help-1">' . __( 'When using a keyboard to navigate:' ) . '</p>';
	$wll_section_description .= '<ul>';
	$wll_section_description .= '<li id="editor-keyboard-trap-help-2">' . __( 'In the editing area, the Tab key enters a tab character.' ) . '</li>';
	$wll_section_description .= '<li id="editor-keyboard-trap-help-3">' . __( 'To move away from this area, press the Esc key followed by the Tab key.' ) . '</li>';
	$wll_section_description .= '<li id="editor-keyboard-trap-help-4">' . __( 'Screen reader users: when in forms mode, you may need to press the Esc key twice.' ) . '</li>';
	$wll_section_description .= '</ul>';

	$wp_customize->add_section( 'white_label_login',
		array(
			'title'              => __( 'White Label Login' ),
			'priority'           => 210,
			'capability'				 => 'manage_options',
			//'description_hidden' => true,
			'description'        => $wll_section_description,
		)
	);

	//adding setting for copyright text
	/*
	$wp_customize->add_setting( 'wpwll_copyright_text',
		array(
		  //'type' => 'option', //  setup the option here
		  'capability' => 'manage_options',
		  'default' => 'Switch Webdev All Rights Reserved.',
		  'transport' => 'postMessage', // or 'refresh'
		  'sanitize_callback' => 'sanitize_text_field'
		) );

	$wp_customize->add_control('wpwll_copyright_text', array(
			'label'   => 'Change Copyright Text',
			'section' => 'white_label_login',
			'type'    => 'text',
	));
*/

	// CSS
	$wp_customize->add_setting( 'wpwll_custom_css',
		array(
		  'type' => 'option', // or 'option'
		  'capability' => 'manage_options',
		  'default' => '',
		  'transport' => 'postMessage',
		  //'transport' => 'refresh', // or postMessage
		  'sanitize_callback' => 'wp_strip_all_tags',
		) );

	// add control
	$wp_customize->add_control(
		new WP_Customize_Code_Editor_Control(
			$wp_customize,
			'wpwll_custom_css',
			array(
				'label'       => __( 'Login Page CSS' ),
				'section'     => 'white_label_login',
				'code_type'   => 'text/css',
				'input_attrs' => array(
					'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
				),
			)
		)
	);

}, 12, 1 );

<?php


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

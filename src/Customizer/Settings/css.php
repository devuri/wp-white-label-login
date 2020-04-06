<?php


// CSS
$this->customizer()->add_setting( 'wpwll_custom_css',
	array(
		'type' => 'option', // or 'option'
		'capability' => 'manage_options',
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'wp_strip_all_tags',
	) );

// add control
$this->customizer()->add_control(
	new WP_Customize_Code_Editor_Control(
		$this->customizer(),
		'wpwll_custom_css',
		array(
			'label'       => __( 'Login Page CSS' ),
			'section'     => 'white_label_css',
			'code_type'   => 'text/css',
			'input_attrs' => array(
				'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
			),
		)
	)
);

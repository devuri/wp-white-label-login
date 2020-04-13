<?php

/**
* Background Color
* @var [type]
*/
$this->customizer()->add_setting( 'wpwll_options[login_container_color]',
array(
	'type' 							=> 'option',
	'capability' 				=> 'manage_options',
	'default' 					=> '#ffffff',
	'transport' 				=> $this->preview_type,
	'sanitize_callback' => 'sanitize_hex_color',
) );

$this->customizer()->add_control(
 new WP_Customize_Color_Control(
	$this->customizer(), 'wpwll_options[login_container_color]',
	 array(
		 'label' => __( 'Login Container Background Color' ),
		 'description' => __( 'Select a color for the login container div' ),
		 'section' => 'whitelabel_section_login', // Add a default or your own section
		)
) );


/**
 * Text Color
 * @var [type]
 */
$this->customizer()->add_setting( 'wpwll_options[login_text_color]',
	array(
		'type' 							=> 'option',
		'capability' 				=> 'manage_options',
		'default' 					=> '#444444',
		'transport' 				=> $this->preview_type,
		'sanitize_callback' => 'sanitize_hex_color',
	) );

$this->customizer()->add_control(
	 new WP_Customize_Color_Control(
		$this->customizer(), 'wpwll_options[login_text_color]',
		 array(
			 'label' => __( 'Text Color' ),
			 'description' => __( 'input field label colors' ),
			 'section' => 'whitelabel_section_login', // Add a default or your own section
			)
	) );

<?php

/**
* Form Background
* @var [type]
*/
$this->customizer()->add_setting( 'wpwll_options[login_form_color]',
array(
	'type' 							=> 'option',
	'capability' 				=> 'manage_options',
	'default' 					=> '#ffffff',
	'transport' 				=> $this->preview_type,
	'sanitize_callback' => 'sanitize_hex_color',
) );

$this->customizer()->add_control(
 new WP_Customize_Color_Control(
	$this->customizer(), 'wpwll_options[login_form_color]',
	 array(
		 'label' => __( 'Login Form Background Color' ),
		 'description' => __( 'Select a color' ),
		 'section' => 'whitelabel_section_form',
		)
) );

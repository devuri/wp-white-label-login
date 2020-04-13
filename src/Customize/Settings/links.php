<?php

/**
* Links
* @var [type]
*/
$this->customizer()->add_setting( 'wpwll_options[link_color]',
array(
	'type' 							=> 'option',
	'capability' 				=> 'manage_options',
	'default' 					=> '#474748',
	'transport' 				=> $this->preview_type,
	'sanitize_callback' => 'sanitize_hex_color',
) );

$this->customizer()->add_control(
 new WP_Customize_Color_Control(
	$this->customizer(), 'wpwll_options[link_color]',
	 array(
		 'label' => __( 'Link Color' ),
		 'description' => __( ' change page link color' ),
		 'section' => 'whitelabel_section_links',
		)
) );

<?php

// LOGO
$wp_customize->add_setting( 'wpwll_logo_url',
	array(
		'type' 							=> 'option', //  setup the option here
		'capability' 				=> 'manage_options',
		'default' 					=> '',
		'transport' 				=> 'refresh', // or 'refresh'
		'sanitize_callback' => 'absint'
	) );

$wp_customize->add_control(
	new WP_Customize_Cropped_Image_Control(
		$wp_customize, 'wpwll_logo_url',
			array(
				'label' 		=> __( 'Login logo' ),
				'section' 	=> 'white_label_logo',
				'mime_type' => 'image',
				'width' => 120,
    		'height' => 120
			)
		)
	);

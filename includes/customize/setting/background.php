<?php

// Background
$wp_customize->add_setting( 'wpwll_background_url',
	array(
		'type' 							=> 'option', //  setup the option here
		'capability' 				=> 'manage_options',
		'default' 					=> '',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'absint',
	) );

$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize, 'wpwll_background_url',
			array(
				'label' 		=> __( 'Background' ),
				'section' 	=> 'white_label_login',
				'mime_type' => 'image',
			)
		)
	);

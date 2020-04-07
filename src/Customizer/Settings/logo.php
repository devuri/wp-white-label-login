<?php

// LOGO
$this->customizer()->add_setting( 'wpwll_options[logo]',
	array(
		'type' 							=> 'option', //  setup the option here
		'capability' 				=> 'manage_options',
		'default' 					=> '',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'absint'
	) );

$this->customizer()->add_control(
	new WP_Customize_Cropped_Image_Control(
		$this->customizer(), 'wpwll_options[logo]',
			array(
				'label' 		=> __( 'Login logo' ),
				'section' 	=> 'white_label_logo',
				'mime_type' => 'image',
				'width' => 120,
    		'height' => 120
			)
		)
	);

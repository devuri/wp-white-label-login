<?php

/**
 * Background Color
 * @var [type]
 */
$wp_customize->add_setting( 'wpwll_options[background_color]',
	array(
		'type' 							=> 'option', //  setup the option here
		'capability' 				=> 'manage_options',
		'default' 					=> '#ffffff',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'sanitize_hex_color',
	) );

$wp_customize->add_control(
	 new WP_Customize_Color_Control(
		$wp_customize, 'wpwll_options[background_color]',
		 array(
		   'label' => __( 'Background Color' ),
		   'description' => __( 'Select a color' ),
		   'section' => 'white_label_background', // Add a default or your own section
			)
	) );


/**
 * background image
 * @var [type]
 */
$wp_customize->add_setting( 'wpwll_options[background_image]',
	array(
		'type' 							=> 'option', //  setup the option here
		'capability' 				=> 'manage_options',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'absint',
	) );

$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize, 'wpwll_options[background_image]',
			array(
				'label' 		=> __( 'Background' ),
				'section' 	=> 'white_label_background',
				'mime_type' => 'image',
			)
		)
	);

/**
 * Background Attachment
 * @var [type]
 */
$wp_customize->add_setting( 'wpwll_options[background_attachment]',
	array(
		'type' 							=> 'option',
		'capability' 				=> 'manage_options',
		'default' 					=> 'fixed',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'sanitize_title',
	) );

$wp_customize->add_control( 'wpwll_options[background_attachment]',
	array(
		 'type' 				=> 'radio',
		 'section' 			=> 'white_label_background',
		 'label' 				=> __( 'Background Attachment' ),
		 'description' 	=> __( 'Set background attachment property, works with background image.' ),
		 'choices' => array(
		   'scroll' 	=> __( 'Scroll' ),
		   'fixed' 		=> __( 'Fixed' ),
		   'inherit' 	=> __( 'Inherit' ),
		 ),
	) );

/**
 * Background Size
 * @var [type]
 */
$wp_customize->add_setting( 'wpwll_options[background_size]',
	array(
		'type' 							=> 'option',
		'capability' 				=> 'manage_options',
		'default' 					=> 'cover',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'sanitize_title',
	) );

$wp_customize->add_control( 'wpwll_options[background_size]',
	array(
			'type' 				=> 'radio',
			'section' 			=> 'white_label_background',
			'label' 				=> __( 'Background Size' ),
			'description' 	=> __( 'The background-size property specifies the size of the background images.' ),
			'choices' => array(
				'auto' 		=> __( 'Auto'),
				'cover'	 	=> __( 'Cover'),
				'contain' 	=> __( 'Contain'),
				'initial'	=> __( 'Initial'),
				'inherit' 	=> __( 'Inherit')
			),
	) );


/**
 * Background Repeat
 * @var [type]
 */
$wp_customize->add_setting( 'wpwll_options[background_repeat]',
	array(
		'type' 							=> 'option',
		'capability' 				=> 'manage_options',
		'default' 					=> 'no-repeat',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'sanitize_title',
	) );

$wp_customize->add_control( 'wpwll_options[background_repeat]',
	array(
			'type' 				=> 'radio',
			'section' 			=> 'white_label_background',
			'label' 				=> __( 'Background Repeat' ),
			'description' 	=> __( 'The background-repeat property sets if/how a background image will be repeated.' ),
			'choices' => array(
				'repeat' 		=> __('Repeat'),
				'repeat-x'	 	=> __('Repeat-x'),
				'repeat-y' 	=> __('Repeat-y'),
				'no-repeat'	=> __('No-repeat'),
				'initial'		=> __('Initial'),
				'inherit' 		=> __('Inherit')
			),
	) );

/**
 * Background Position
 * @var [type]
 */
$wp_customize->add_setting( 'wpwll_options[background_position]',
	array(
		'type' 							=> 'option',
		'capability' 				=> 'manage_options',
		'default' 					=> 'bottom',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'sanitize_title',
	) );

$wp_customize->add_control( 'wpwll_options[background_position]',
	array(
			'type' 				=> 'radio',
			'section' 			=> 'white_label_background',
			'label' 				=> __( 'Background Position' ),
			'description' 	=> __( 'The background-position property sets the starting position of a background image.' ),
			'choices' => array(
				'top' 			=> __('Top'),
				'bottom' 	=> __('Bottom'),
				'center' 	=> __('Center'),
				'left' 		=> __('Left'),
				'right' 		=> __('Right'),
				'initial'	=> __('Initial'),
				'inherit'	=> __('Inherit')
			),
	) );

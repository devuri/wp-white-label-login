<?php
/**
 * [$transport_type description]
 * @var string //'postMessage' or 'refresh'
 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
 */
$footer_preview_type = 'refresh';

$wp_customize->add_setting( 'wpwll_options[copyright_text]',
	array(
		'type' => 'option', //  setup the option here
		'capability' => 'manage_options',
		'default' => 'All Rights Reserved.',
		'transport' => $footer_preview_type,
		'sanitize_callback' => 'sanitize_text_field'
	) );

$wp_customize->add_control('wpwll_options[copyright_text]', array(
		'label'   => 'Change Copyright Text',
		'section' => 'white_label_footer',
		'type'    => 'text',
));

/**
 * Footer Color
 * @var [type]
 */
$wp_customize->add_setting( 'wpwll_options[footer_text_color]',
	array(
		'type' 							=> 'option',
		'capability' 				=> 'manage_options',
		'default' 					=> '#747474',
		'transport' 				=> $header_preview_type,
		'sanitize_callback' => 'sanitize_hex_color',
	) );

$wp_customize->add_control(
	 new WP_Customize_Color_Control(
		$wp_customize, 'wpwll_options[footer_text_color]',
		 array(
			 'label' => __( 'Text Color' ),
			 'description' => __( 'Select a color' ),
			 'section' => 'white_label_footer', // Add a default or your own section
			)
	) );
/**
 * Footer Alignment
 * @var [type]
 */
$wp_customize->add_setting( 'wpwll_options[footer_alignment]',
	array(
		'type' 							=> 'option',
		'capability' 				=> 'manage_options',
		'default' 					=> 'center',
		'transport' 				=> $footer_preview_type, // or 'refresh'
		'sanitize_callback' => 'sanitize_title',
	) );

$wp_customize->add_control( 'wpwll_options[footer_alignment]',
	array(
			'type' 				=> 'radio',
			'section' 			=> 'white_label_footer',
			'label' 				=> __( 'Footer Alignment' ),
			'description' 	=> __( 'Sets the alignment of the footer text.' ),
			'choices' => array(
				'center' 	=> __('Center'),
				'left' 		=> __('Left'),
				'right' 		=> __('Right')
			),
	) );

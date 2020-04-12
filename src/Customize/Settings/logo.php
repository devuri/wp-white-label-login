<?php
/**
 * turn on logo display
 * @var [type]
 */
$this->customizer()->add_setting( 'wpwll_options[logo_display]',
	array(
		'type' 							=> 'option',
		'capability' 				=> 'manage_options',
		'default' 					=> 'none',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'sanitize_title',
	) );
$this->customizer()->add_control( 'wpwll_options[logo_display]',
	array(
			'type' 					=> 'radio',
			'section' 			=> 'white_label_logo',
			'label' 				=> __( 'Logo Display' ),
			'description' 	=> __( 'set logo image display.' ),
			'choices' => array(
				'block' 	=> __('Image'),
				'contents' 	=> __('Text'),
				'none' 			=> __('none'),
			),
	) );

/**
 * Logo Image
 * @var [type]
 */
$this->customizer()->add_setting( 'wpwll_logo',
	array(
		'type' 							=> 'option', //  setup the option here
		'capability' 				=> 'manage_options',
		'default' 					=> '',
		'transport' 				=> 'postMessage', // or 'refresh'
		'sanitize_callback' => 'absint'
	) );

$this->customizer()->add_control(
	new WP_Customize_Cropped_Image_Control(
		$this->customizer(), 'wpwll_logo',
			array(
				'label' 		=> __( 'Login logo' ),
				'section' 	=> 'white_label_logo',
				'mime_type' => 'image',
				'width' => 120,
    		'height' => 120
			)
		)
	);


	/**
	 * Background Position
	 * @var [type]
	 */
	$this->customizer()->add_setting( 'wpwll_options[logo_position]',
		array(
			'type' 							=> 'option',
			'capability' 				=> 'manage_options',
			'default' 					=> 'center',
			'transport' 				=> 'postMessage', // or 'refresh'
			'sanitize_callback' => 'sanitize_title',
		) );

	$this->customizer()->add_control( 'wpwll_options[logo_position]',
		array(
				'type' 				=> 'radio',
				'section' 			=> 'white_label_logo',
				'label' 				=> __( 'Logo Position' ),
				'description' 	=> __( 'Sets the alignment of the logo image.' ),
				'choices' => array(
					'center' 	=> __('Center'),
					'left' 		=> __('Left'),
					'right' 		=> __('Right'),
				),
		) );

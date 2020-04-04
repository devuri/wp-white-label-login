<?php

$wp_customize->add_setting( 'wpwll_options[copyright_text]',
	array(
		'type' => 'option', //  setup the option here
		'capability' => 'manage_options',
		'default' => 'All Rights Reserved.',
		'transport' => 'postMessage', // or 'refresh'
		'sanitize_callback' => 'sanitize_text_field'
	) );

$wp_customize->add_control('wpwll_options[copyright_text]', array(
		'label'   => 'Change Copyright Text',
		'section' => 'white_label_footer',
		'type'    => 'text',
));

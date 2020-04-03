<?php

$wp_customize->add_setting( 'blogname',
	array(
		'type' => 'option', //  setup the option here
		'capability' => 'manage_options',
		'default' => 'Switch Webdev.',
		'transport' => 'postMessage', // or 'refresh'
		'sanitize_callback' => 'sanitize_text_field'
	) );

$wp_customize->add_control('blogname', array(
		'label'   => 'Blog Name',
		'section' => 'white_label_login',
		'type'    => 'text',
));

<?php


	/**
	 * Header settings
	 * @var [type]
	 */
	$white_label_customizer->new_setting('header')->text('title');
	$white_label_customizer->new_setting('header')->text('description');
	$white_label_customizer->new_setting('header')->color('text');
	$white_label_customizer->new_setting('header')->color('background');
	$white_label_customizer->new_setting('header')->alignment();

	/**
	 * Logo settings
	 * @var [type]
	 */
	$white_label_customizer->new_setting('logo')->image();
	$white_label_customizer->new_setting('logo')->url();

	/**
	 * Background settings
	 * @var [type]
	 * TODO write css rules set to automate styles
	 */
	$white_label_customizer->new_setting('background')->color('background');
	$white_label_customizer->new_setting('background')->css('scroll','fixed','inherit');
	$white_label_customizer->new_setting('background')->size('cover','contain','inherit');
	$white_label_customizer->new_setting('background')->repeat('repeat','repeat-x','repeat-y','no-repeat');

<?php

/**
 * Background Color.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[button_background_color]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => '#007cba',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_hex_color',
    ]
);

$this->customizer()->add_control(
    new WP_Customize_Color_Control(
        $this->customizer(),
        'wpwll_options[button_background_color]',
        [
            'label'       => __( 'Background Color' ),
            'description' => __( 'Select a color' ),
            'section'     => 'whitelabel_section_button',
            // Add a default or your own section
        ]
    )
);


/**
 * Text Color.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[button_text_color]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => '#ffffff',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_hex_color',
    ]
);

$this->customizer()->add_control(
    new WP_Customize_Color_Control(
        $this->customizer(),
        'wpwll_options[button_text_color]',
        [
            'label'       => __( 'Text Color' ),
            'description' => __( 'Select a color' ),
            'section'     => 'whitelabel_section_button',
            // Add a default or your own section
        ]
    )
);

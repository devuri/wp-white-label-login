<?php
/**
 * Footer Alignment.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[footer_alignment]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => 'center',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_title',
    ]
);

$this->customizer()->add_control(
    'wpwll_options[footer_alignment]',
    [
        'type'        => 'radio',
        'section'     => 'whitelabel_section_footer',
        'label'       => __( 'Footer Alignment' ),
        'description' => __( 'Sets the alignment of the footer text.' ),
        'choices'     => [
            'center' => __( 'Center' ),
            'left'   => __( 'Left' ),
            'right'  => __( 'Right' ),
        ],
    ]
);

/**
 * footer_text.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[footer_text]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => '...',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_textarea_field',
    ]
);

$this->customizer()->add_control(
    'wpwll_options[footer_text]',
    [
        'label'       => 'Footer Text',
        'description' => __( 'Add Text to the footer.' ),
        'section'     => 'whitelabel_section_footer',
        'type'        => 'textarea',
    ]
);
/**
 * Footer Text Color.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[footer_text_color]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => '#747474',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_hex_color',
    ]
);

$this->customizer()->add_control(
    new WP_Customize_Color_Control(
        $this->customizer(),
        'wpwll_options[footer_text_color]',
        [
            'label'       => __( 'Text Color' ),
            'description' => __( 'Select a color' ),
            'section'     => 'whitelabel_section_footer',
        ]
    )
);

/**
 * copyright_text.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[copyright_text]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => 'All Rights Reserved.',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_text_field',
    ]
);

$this->customizer()->add_control(
    'wpwll_options[copyright_text]',
    [
        'label'   => 'Copyright Text',
        'section' => 'whitelabel_section_footer',
        'type'    => 'text',
    ]
);

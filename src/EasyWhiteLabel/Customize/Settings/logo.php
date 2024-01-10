<?php
/**
 * turn on logo display.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[logo_display]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => 'none',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_title',
    ]
);
$this->customizer()->add_control(
    'wpwll_options[logo_display]',
    [
        'type'        => 'radio',
        'section'     => 'whitelabel_section_logo',
        'label'       => __( 'Logo Display' ),
        'description' => __( 'set logo image display.' ),
        'choices'     => [
            'block'    => __( 'Image' ),
            'contents' => __( 'Text' ),
            'none'     => __( 'none' ),
        ],
    ]
);

/**
 * Logo Image.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_logo',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => '',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'absint',
    ]
);

$this->customizer()->add_control(
    new WP_Customize_Cropped_Image_Control(
        $this->customizer(),
        'wpwll_logo',
        [
            'label'     => __( 'Login logo' ),
            'section'   => 'whitelabel_section_logo',
            'mime_type' => 'image',
            'width'     => 120,
            'height'    => 120,
        ]
    )
);


/**
 * Background Position.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[logo_position]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => 'center',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_title',
    ]
);

$this->customizer()->add_control(
    'wpwll_options[logo_position]',
    [
        'type'        => 'radio',
        'section'     => 'whitelabel_section_logo',
        'label'       => __( 'Logo Position' ),
        'description' => __( 'Sets the alignment of the logo image.' ),
        'choices'     => [
            'center' => __( 'Center' ),
            'left'   => __( 'Left' ),
            'right'  => __( 'Right' ),
        ],
    ]
);

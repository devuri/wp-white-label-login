<?php



$this->customizer()->add_setting(
    'wpwll_options[header_title]',
    [
        'type'              => 'option',
        // setup the option here
        'capability'        => 'manage_options',
        'default'           => get_bloginfo( 'name' ),
        'transport'         => $this->preview_type,
        // or 'refresh'
        'sanitize_callback' => 'sanitize_text_field',
    ]
);

$this->customizer()->add_control(
    'wpwll_options[header_title]',
    [
        'label'       => 'Title',
        'section'     => 'whitelabel_section_header',
        'description' => __( 'The header title text.' ),
        'type'        => 'text',
    ]
);


$this->customizer()->add_setting(
    'wpwll_options[header_description]',
    [
        'type'              => 'option',
        // setup the option here
        'capability'        => 'manage_options',
        'default'           => get_bloginfo( 'description' ),
        'transport'         => $this->preview_type,
        // or 'refresh'
        'sanitize_callback' => 'sanitize_text_field',
    ]
);

$this->customizer()->add_control(
    'wpwll_options[header_description]',
    [
        'label'       => 'Change the description',
        'section'     => 'whitelabel_section_header',
        'description' => __( 'The header description text.' ),
        'type'        => 'text',
    ]
);

/**
 * Text Color.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[header_text_color]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => '#000000',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_hex_color',
    ]
);

$this->customizer()->add_control(
    new WP_Customize_Color_Control(
        $this->customizer(),
        'wpwll_options[header_text_color]',
        [
            'label'       => __( 'Text Color' ),
            'description' => __( 'Select a color' ),
            'section'     => 'whitelabel_section_header',
            // Add a default or your own section
        ]
    )
);

/**
 * Background Color.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[header_background_color]',
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
        'wpwll_options[header_background_color]',
        [
            'label'       => __( 'Background Color' ),
            'description' => __( 'Select a color' ),
            'section'     => 'whitelabel_section_header',
            // Add a default or your own section
        ]
    )
);

/**
 * Background Alignment.
 *
 * @var [type]
 */
$this->customizer()->add_setting(
    'wpwll_options[header_alignment]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => 'center',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_title',
    ]
);

$this->customizer()->add_control(
    'wpwll_options[header_alignment]',
    [
        'type'        => 'radio',
        'section'     => 'whitelabel_section_header',
        'label'       => __( 'Header Alignment' ),
        'description' => __( 'The header alignment sets the alignment of text.' ),
        'choices'     => [
            'center' => __( 'Center' ),
            'left'   => __( 'Left' ),
            'right'  => __( 'Right' ),
        ],
    ]
);

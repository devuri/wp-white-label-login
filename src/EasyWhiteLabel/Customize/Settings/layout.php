<?php


$this->customizer()->add_setting(
    'wpwll_options[form_layout]',
    [
        'type'              => 'option',
        'capability'        => 'manage_options',
        'default'           => 'center',
        'transport'         => $this->preview_type,
        'sanitize_callback' => 'sanitize_title',
    ]
);

$this->customizer()->add_control(
    'wpwll_options[form_layout]',
    [
        'type'        => 'radio',
        'section'     => 'whitelabel_section_layout',
        'label'       => __( 'Custom Form Alignment' ),
        'description' => __( 'Choose how to align the login form.' ),
        'choices'     => [
            'left'   => __( 'Left' ),
            'right'  => __( 'Right' ),
            'center' => __( 'Center' ),
        ],
    ]
);

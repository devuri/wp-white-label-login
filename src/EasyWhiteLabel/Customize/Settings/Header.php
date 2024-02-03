<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;

class Header implements SettingInterface
{
    /**
     * Setting.
     *
     * @param CustomizerPanel $customize
     *
     * @return void
     */
    public function create( CustomizerPanel $customize ): void
    {
        $customize->get_customizer()->add_setting(
            'wpwll_options[header_title]',
            [
                'type'              => 'option',
                // setup the option here
                'capability'        => 'manage_options',
                'default'           => get_bloginfo( 'name' ),
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[header_title]',
            [
                'label'       => 'Title',
                'section'     => 'whitelabel_section_header',
                'description' => __( 'The header title text.' ),
                'type'        => 'text',
            ]
        );

        $customize->get_customizer()->add_setting(
            'wpwll_options[header_description]',
            [
                'type'              => 'option',
                // setup the option here
                'capability'        => 'manage_options',
                'default'           => get_bloginfo( 'description' ),
                'transport'         => $customize->get_preview(),
                // or 'refresh'
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $customize->get_customizer()->add_control(
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
        $customize->get_customizer()->add_setting(
            'wpwll_options[header_text_color]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '#000000',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_hex_color',
            ]
        );

        $customize->get_customizer()->add_control(
            new WP_Customize_Color_Control(
                $customize->get_customizer(),
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
        $customize->get_customizer()->add_setting(
            'wpwll_options[header_background_color]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '#ffffff',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_hex_color',
            ]
        );

        $customize->get_customizer()->add_control(
            new WP_Customize_Color_Control(
                $customize->get_customizer(),
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
        $customize->get_customizer()->add_setting(
            'wpwll_options[header_alignment]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'center',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
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
    }
}

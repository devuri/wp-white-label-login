<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Cropped_Image_Control;

class Logo implements SettingInterface
{
	/**
     * Initializes settings for the Customizer panel.
     *
     * @param CustomizerPanel $customize The Customizer panel instance where settings will be added.
	 * @param string $section_id The Customizer panel section ID.
     *
     * @return void
     */
    public function create( CustomizerPanel $customize, string $section_id ): void
    {
        $customize->get_customizer()->add_setting(
            'wpwll_options[logo_display]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'none',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );
        $customize->get_customizer()->add_control(
            'wpwll_options[logo_display]',
            [
                'type'        => 'radio',
                'section'     => $section_id,
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
        $customize->get_customizer()->add_setting(
            'wpwll_logo',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'absint',
            ]
        );

        $customize->get_customizer()->add_control(
            new WP_Customize_Cropped_Image_Control(
                $customize->get_customizer(),
                'wpwll_logo',
                [
                    'label'     => __( 'Login logo' ),
                    'section'   => $section_id,
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
        $customize->get_customizer()->add_setting(
            'wpwll_options[logo_position]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'center',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[logo_position]',
            [
                'type'        => 'radio',
                'section'     => $section_id,
                'label'       => __( 'Logo Position' ),
                'description' => __( 'Sets the alignment of the logo image.' ),
                'choices'     => [
                    'center' => __( 'Center' ),
                    'left'   => __( 'Left' ),
                    'right'  => __( 'Right' ),
                ],
            ]
        );
    }
}

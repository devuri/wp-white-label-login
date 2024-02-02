<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;
use WP_Customize_Media_Control;

class Background implements SettingInterface
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
            'wpwll_options[background_color]',
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
                'wpwll_options[background_color]',
                [
                    'label'       => __( 'Background Color' ),
                    'description' => __( 'Select a color' ),
                    'section'     => 'whitelabel_section_background',
                ]
            )
        );

        /**
         * background image.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_background',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'absint',
            ]
        );

        $customize->get_customizer()->add_control(
            new WP_Customize_Media_Control(
                $customize->get_customizer(),
                'wpwll_background',
                [
                    'label'     => __( 'Background' ),
                    'section'   => 'whitelabel_section_background',
                    'mime_type' => 'image',
                ]
            )
        );

        /**
         * Background Attachment.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[background_attachment]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'fixed',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[background_attachment]',
            [
                'type'        => 'radio',
                'section'     => 'whitelabel_section_background',
                'label'       => __( 'Background Attachment' ),
                'description' => __( 'Set background attachment property, works with background image.' ),
                'choices'     => [
                    'scroll'  => __( 'Scroll' ),
                    'fixed'   => __( 'Fixed' ),
                    'inherit' => __( 'Inherit' ),
                ],
            ]
        );

        /**
         * Background Size.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[background_size]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'cover',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[background_size]',
            [
                'type'        => 'radio',
                'section'     => 'whitelabel_section_background',
                'label'       => __( 'Background Size' ),
                'description' => __( 'The background-size property specifies the size of the background images.' ),
                'choices'     => [
                    'auto'    => __( 'Auto' ),
                    'cover'   => __( 'Cover' ),
                    'contain' => __( 'Contain' ),
                    'initial' => __( 'Initial' ),
                    'inherit' => __( 'Inherit' ),
                ],
            ]
        );

        /**
         * Background Repeat.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[background_repeat]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'no-repeat',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[background_repeat]',
            [
                'type'        => 'radio',
                'section'     => 'whitelabel_section_background',
                'label'       => __( 'Background Repeat' ),
                'description' => __( 'The background-repeat property sets if/how a background image will be repeated.' ),
                'choices'     => [
                    'repeat'    => __( 'Repeat' ),
                    'repeat-x'  => __( 'Repeat-x' ),
                    'repeat-y'  => __( 'Repeat-y' ),
                    'no-repeat' => __( 'No-repeat' ),
                    'initial'   => __( 'Initial' ),
                    'inherit'   => __( 'Inherit' ),
                ],
            ]
        );

        /**
         * Background Position.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[background_position]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'bottom',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[background_position]',
            [
                'type'        => 'radio',
                'section'     => 'whitelabel_section_background',
                'label'       => __( 'Background Position' ),
                'description' => __( 'The background-position property sets the starting position of a background image.' ),
                'choices'     => [
                    'top'     => __( 'Top' ),
                    'bottom'  => __( 'Bottom' ),
                    'center'  => __( 'Center' ),
                    'left'    => __( 'Left' ),
                    'right'   => __( 'Right' ),
                    'initial' => __( 'Initial' ),
                    'inherit' => __( 'Inherit' ),
                ],
            ]
        );
    }
}

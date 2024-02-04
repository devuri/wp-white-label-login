<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;

class Footer extends AbstractSelectiveRefresh
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
        /**
         * Footer Alignment.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[footer_alignment]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'center',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[footer_alignment]',
            [
                'type'        => 'radio',
                'section'     => $section_id,
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
        $customize->get_customizer()->add_setting(
            'wpwll_options[footer_text]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '...',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_textarea_field',
            ]
        );

        $customize->get_customizer()->add_control(
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
        $customize->get_customizer()->add_setting(
            'wpwll_options[footer_text_color]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '#747474',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_hex_color',
            ]
        );

        $customize->get_customizer()->add_control(
            new WP_Customize_Color_Control(
                $customize->get_customizer(),
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
        $customize->get_customizer()->add_setting(
            'wpwll_options[copyright_text]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'All Rights Reserved.',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[copyright_text]',
            [
                'label'   => 'Copyright Text',
                'section' => 'whitelabel_section_footer',
                'type'    => 'text',
            ]
        );

        /**
         * render the setting callback.
         */
        static::_render_partial(
            'wpwll_options[copyright_text]',
            // The ID of the setting.
            $customize,
            // The Customizer instance.
            '.wll-footer-copyright-text',
            // The CSS selector for the container
            'copyright_text',
            // The key in the 'wpwll_options' array
            'All Rights Reserved.'
            // default
        );
    }
}

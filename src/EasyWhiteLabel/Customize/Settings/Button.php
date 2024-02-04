<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;

class Button implements SettingInterface
{
    /**
     * Initializes settings for the Customizer panel.
     *
     * @param CustomizerPanel $customize  The Customizer panel instance where settings will be added.
     * @param string          $section_id The Customizer panel section ID.
     *
     * @return void
     */
    public function create( CustomizerPanel $customize, string $section_id ): void
    {
        /**
         * Background Color.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[button_background_color]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '#007cba',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_hex_color',
            ]
        );

        $customize->get_customizer()->add_control(
            new WP_Customize_Color_Control(
                $customize->get_customizer(),
                'wpwll_options[button_background_color]',
                [
                    'label'       => __( 'Background Color' ),
                    'description' => __( 'Select a color' ),
                    'section'     => $section_id,
                    // Add a default or your own section
                ]
            )
        );

        /**
         * Text Color.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[button_text_color]',
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
                'wpwll_options[button_text_color]',
                [
                    'label'       => __( 'Text Color' ),
                    'description' => __( 'Select a color' ),
                    'section'     => $section_id,
                    // Add a default or your own section
                ]
            )
        );
    }
}

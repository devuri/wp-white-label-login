<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;

class Links implements SettingInterface
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
            'wpwll_options[link_color]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '#474748',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_hex_color',
            ]
        );

        $customize->get_customizer()->add_control(
            new WP_Customize_Color_Control(
                $customize->get_customizer(),
                'wpwll_options[link_color]',
                [
                    'label'       => __( 'Link Color' ),
                    'description' => __( ' change page link color' ),
                    'section'     => $section_id,
                ]
            )
        );
    }
}

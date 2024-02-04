<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;

class Layout implements SettingInterface
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
            'wpwll_options[form_layout]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'center',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[form_layout]',
            [
                'type'        => 'radio',
                'section'     => $section_id,
                'label'       => __( 'Custom Form Alignment' ),
                'description' => __( 'Choose how to align the login form.' ),
                'choices'     => [
                    'left'   => __( 'Left' ),
                    'right'  => __( 'Right' ),
                    'center' => __( 'Center' ),
                ],
            ]
        );
    }
}

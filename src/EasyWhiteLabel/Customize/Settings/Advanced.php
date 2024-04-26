<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;

class Advanced implements SettingInterface
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
        $customize->get_customizer()->add_setting(
            'wpwll_options[wll_is_enabled]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 1,
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_key',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[wll_is_enabled]',
            [
                'type'        => 'checkbox',
                'section'     => $section_id,
                'label'       => __( 'Enable/Disable White Label Login' ),
                'description' => __( 'enable or disable the login form styles.' ),
            ]
        );
    }
}

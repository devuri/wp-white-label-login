<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;

class Layout implements SettingInterface
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
    }
}

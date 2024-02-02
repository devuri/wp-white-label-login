<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;

class Form implements SettingInterface
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
        /**
         * Form Background.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[login_form_color]',
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
                'wpwll_options[login_form_color]',
                [
                    'label'       => __( 'Login Form Background Color' ),
                    'description' => __( 'Select a color' ),
                    'section'     => 'whitelabel_section_form',
                ]
            )
        );
    }
}

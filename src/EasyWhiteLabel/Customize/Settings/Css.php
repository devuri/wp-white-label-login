<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Code_Editor_Control;

class Css implements SettingInterface
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
        // CSS
        $customize->get_customizer()->add_setting(
            'wpwll_custom_css',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'wp_strip_all_tags',
            ]
        );

        // add control
        $customize->get_customizer()->add_control(
            new WP_Customize_Code_Editor_Control(
                $customize->get_customizer(),
                'wpwll_custom_css',
                [
                    'label'       => __( 'Login Page CSS' ),
                    'section'     => 'whitelabel_section_css',
                    'code_type'   => 'text/css',
                    'input_attrs' => [
                        'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
                    ],
                ]
            )
        );
    }
}

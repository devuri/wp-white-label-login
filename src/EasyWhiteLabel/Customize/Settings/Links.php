<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;

class Links implements SettingInterface
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
                    'section'     => 'whitelabel_section_links',
                ]
            )
        );
    }
}

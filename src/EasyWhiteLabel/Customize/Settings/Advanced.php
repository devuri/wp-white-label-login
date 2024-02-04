<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;

class Advanced implements SettingInterface
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
                'section'     => 'whitelabel_section_advanced',
                'label'       => __( 'Enable/Disable White Label Login' ),
                'description' => __( 'enable or disable the login form styles.' ),
            ]
        );
    }
}

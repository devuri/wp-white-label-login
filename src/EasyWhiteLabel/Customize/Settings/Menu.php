<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;
use WP_Customize_Color_Control;

class Menu implements SettingInterface
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
            'wpwll_options[footer_nav]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'false',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );
        $customize->get_customizer()->add_control(
            'wpwll_options[footer_nav]',
            [
                'type'        => 'radio',
                'section'     => 'whitelabel_section_menu',
                'label'       => __( 'Footer Navigation Display' ),
                'description' => __( 'Turn on the login footer navigation you can find this in the "Login Page Footer Navigation" Apperance >> Menu settings' ),
                'choices'     => [
                    true  => __( 'On' ),
                    false => __( 'Off' ),
                ],
            ]
        );

        /**
         * Navigation Alignment.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[footer_nav_alignment]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => 'center',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_title',
            ]
        );

        $customize->get_customizer()->add_control(
            'wpwll_options[footer_nav_alignment]',
            [
                'type'        => 'radio',
                'section'     => 'whitelabel_section_menu',
                'label'       => __( 'Navigation Alignment' ),
                'description' => __( 'Set the alignment.' ),
                'choices'     => [
                    'center' => __( 'Center' ),
                    'left'   => __( 'Left' ),
                    'right'  => __( 'Right' ),
                ],
            ]
        );

        /**
         * Footer background.
         *
         * @var [type]
         */
        $customize->get_customizer()->add_setting(
            'wpwll_options[footer_nav_backgorund]',
            [
                'type'              => 'option',
                'capability'        => 'manage_options',
                'default'           => '#dadada',
                'transport'         => $customize->get_preview(),
                'sanitize_callback' => 'sanitize_hex_color',
            ]
        );

        $customize->get_customizer()->add_control(
            new WP_Customize_Color_Control(
                $customize->get_customizer(),
                'wpwll_options[footer_nav_backgorund]',
                [
                    'label'       => __( 'Background Color' ),
                    'description' => __( 'Select a Background color' ),
                    'section'     => 'whitelabel_section_menu',
                ]
            )
        );
    }
}

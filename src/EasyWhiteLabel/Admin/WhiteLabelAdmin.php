<?php

namespace EasyWhiteLabel\Admin;

final class WhiteLabelAdmin extends AbstractAdminCore
{
    public static function admin_views_dir(): string
    {
        return plugin_dir_path( __FILE__ ) . 'pages/';
    }
    private static function options_menus()
    {
        return [
            'Logo',
            'Background',
            'CSS',
            'Useful Plugins',
        ];
    }

    public static function change_footer_text(): void
    {
        echo '&copy; ' . esc_html( gmdate( 'Y' ) ) . ' <a href="' . esc_url( home_url() ) . '" target="_blank">' . esc_html( get_bloginfo( 'name' ) ) . '</a> All Rights Reserved.';
    }
}

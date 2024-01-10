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
}

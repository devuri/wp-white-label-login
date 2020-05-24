<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit22cf752e2e4cb05153d3d107863bdf1f
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPAdminPage\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPAdminPage\\' => 
        array (
            0 => __DIR__ . '/..' . '/devuri/wp-admin-page/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit22cf752e2e4cb05153d3d107863bdf1f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit22cf752e2e4cb05153d3d107863bdf1f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfad86c4de6683a712b18e6702e3e65b3
{
    public static $files = array (
        '536316a08db3d840f2ffee3f1fc26715' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Includes/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'EasyWhiteLabel\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'EasyWhiteLabel\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/EasyWhiteLabel',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'EasyWhiteLabel\\Activate' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Activate.php',
        'EasyWhiteLabel\\Admin\\AbstractAdminCore' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/AbstractAdminCore.php',
        'EasyWhiteLabel\\Admin\\AdminCoreInterface' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/AdminCoreInterface.php',
        'EasyWhiteLabel\\Admin\\AdminPageFactory' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/AdminPageFactory.php',
        'EasyWhiteLabel\\Admin\\Form' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Form.php',
        'EasyWhiteLabel\\Admin\\Form\\Traits\\Element\\CategoryList' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Form/Traits/Element/CategoryList.php',
        'EasyWhiteLabel\\Admin\\Form\\Traits\\Element\\DataList' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Form/Traits/Element/DataList.php',
        'EasyWhiteLabel\\Admin\\Form\\Traits\\Element\\Image' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Form/Traits/Element/Image.php',
        'EasyWhiteLabel\\Admin\\Form\\Traits\\Element\\Input' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Form/Traits/Element/Input.php',
        'EasyWhiteLabel\\Admin\\Form\\Traits\\Element\\Nonce' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Form/Traits/Element/Nonce.php',
        'EasyWhiteLabel\\Admin\\Form\\Traits\\Element\\Select' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Form/Traits/Element/Select.php',
        'EasyWhiteLabel\\Admin\\Form\\Traits\\Element\\TextArea' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Form/Traits/Element/TextArea.php',
        'EasyWhiteLabel\\Admin\\PageInterface' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/PageInterface.php',
        'EasyWhiteLabel\\Admin\\Pages\\BackgroundPage' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Pages/BackgroundPage.php',
        'EasyWhiteLabel\\Admin\\Pages\\SettingsPage' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Pages/SettingsPage.php',
        'EasyWhiteLabel\\Admin\\Validate' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/Validate.php',
        'EasyWhiteLabel\\Admin\\WhiteLabelAdmin' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Admin/WhiteLabelAdmin.php',
        'EasyWhiteLabel\\Customize\\Customizer' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Customize/Customizer.php',
        'EasyWhiteLabel\\Customize\\Section' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Customize/Section.php',
        'EasyWhiteLabel\\Lang' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Lang.php',
        'EasyWhiteLabel\\Lib\\ConnektInstaller' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Lib/ConnektInstaller.php',
        'EasyWhiteLabel\\Login\\Background' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Login/Background.php',
        'EasyWhiteLabel\\Login\\Footer' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Login/Footer.php',
        'EasyWhiteLabel\\Login\\Header' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Login/Header.php',
        'EasyWhiteLabel\\Login\\Logo' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Login/Logo.php',
        'EasyWhiteLabel\\Login\\Style' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Login/Style.php',
        'EasyWhiteLabel\\Plugin' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Plugin.php',
        'EasyWhiteLabel\\Traits\\Singleton' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Traits/Singleton.php',
        'EasyWhiteLabel\\Transient' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/Transient.php',
        'EasyWhiteLabel\\UsefulPlugins\\Installer' => __DIR__ . '/../..' . '/src/EasyWhiteLabel/UsefulPlugins/Installer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfad86c4de6683a712b18e6702e3e65b3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfad86c4de6683a712b18e6702e3e65b3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfad86c4de6683a712b18e6702e3e65b3::$classMap;

        }, null, ClassLoader::class);
    }
}

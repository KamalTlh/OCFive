<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd226ab8d3572cd73b1f7e3ef965176b3
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MyApp\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MyApp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'MyApp\\Controller\\CommentController' => __DIR__ . '/../..' . '/src/controller/CommentController.php',
        'MyApp\\Controller\\Controller' => __DIR__ . '/../..' . '/src/controller/Controller.php',
        'MyApp\\Controller\\ErrorController' => __DIR__ . '/../..' . '/src/controller/ErrorController.php',
        'MyApp\\Controller\\FavoritesController' => __DIR__ . '/../..' . '/src/controller/FavoritesController.php',
        'MyApp\\Controller\\ProSanteController' => __DIR__ . '/../..' . '/src/controller/ProSanteController.php',
        'MyApp\\Controller\\Router' => __DIR__ . '/../..' . '/src/controller/Router.php',
        'MyApp\\Controller\\UserController' => __DIR__ . '/../..' . '/src/controller/UserController.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd226ab8d3572cd73b1f7e3ef965176b3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd226ab8d3572cd73b1f7e3ef965176b3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd226ab8d3572cd73b1f7e3ef965176b3::$classMap;

        }, null, ClassLoader::class);
    }
}

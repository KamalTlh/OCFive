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
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MyApp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd226ab8d3572cd73b1f7e3ef965176b3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd226ab8d3572cd73b1f7e3ef965176b3::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

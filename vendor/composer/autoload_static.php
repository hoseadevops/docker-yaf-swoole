<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb8716b93832a64646c6302b133faa119
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Swoole\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Swoole\\' => 
        array (
            0 => __DIR__ . '/..' . '/eaglewu/swoole-ide-helper/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb8716b93832a64646c6302b133faa119::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb8716b93832a64646c6302b133faa119::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

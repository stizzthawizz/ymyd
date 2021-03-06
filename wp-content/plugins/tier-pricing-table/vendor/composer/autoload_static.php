<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitadef34095bb7305b75f45d6cc3eedf75
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TierPricingTable\\' => 17,
        ),
        'P' => 
        array (
            'Premmerce\\SDK\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TierPricingTable\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Premmerce\\SDK\\' => 
        array (
            0 => __DIR__ . '/..' . '/premmerce/wordpress-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitadef34095bb7305b75f45d6cc3eedf75::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitadef34095bb7305b75f45d6cc3eedf75::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

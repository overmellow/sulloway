<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd1e9372a7a8892f93c6f4270a9775aac
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPHtmlParser\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPHtmlParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/paquettg/php-html-parser/src/PHPHtmlParser',
        ),
    );

    public static $prefixesPsr0 = array (
        's' => 
        array (
            'stringEncode' => 
            array (
                0 => __DIR__ . '/..' . '/paquettg/string-encode/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd1e9372a7a8892f93c6f4270a9775aac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd1e9372a7a8892f93c6f4270a9775aac::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitd1e9372a7a8892f93c6f4270a9775aac::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit89873b7370552e9da5a9a8caad21319a
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        '9c67151ae59aff4788964ce8eb2a0f43' => __DIR__ . '/..' . '/clue/stream-filter/src/functions_include.php',
        '8cff32064859f4559445b89279f3199c' => __DIR__ . '/..' . '/php-http/message/src/filters.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tectalic\\OpenAi\\' => 16,
        ),
        'S' => 
        array (
            'Spatie\\DataTransferObject\\' => 26,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
        ),
        'N' => 
        array (
            'Nyholm\\Psr7\\' => 12,
        ),
        'H' => 
        array (
            'Http\\Message\\MultipartStream\\' => 29,
            'Http\\Message\\' => 13,
            'Http\\Discovery\\' => 15,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'C' => 
        array (
            'Clue\\StreamFilter\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tectalic\\OpenAi\\' => 
        array (
            0 => __DIR__ . '/..' . '/tectalic/openai/src',
        ),
        'Spatie\\DataTransferObject\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/data-transfer-object/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'Nyholm\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/nyholm/psr7/src',
        ),
        'Http\\Message\\MultipartStream\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/multipart-stream-builder/src',
        ),
        'Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/message/src',
            1 => __DIR__ . '/..' . '/php-http/message-factory/src',
        ),
        'Http\\Discovery\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/discovery/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Clue\\StreamFilter\\' => 
        array (
            0 => __DIR__ . '/..' . '/clue/stream-filter/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit89873b7370552e9da5a9a8caad21319a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit89873b7370552e9da5a9a8caad21319a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit89873b7370552e9da5a9a8caad21319a::$classMap;

        }, null, ClassLoader::class);
    }
}
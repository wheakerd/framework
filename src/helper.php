<?php
declare (strict_types=1);

use wheakerd\App;
use wheakerd\Container;

if (!function_exists('app')) {
    /**
     * @param string $name
     * @param array $args
     * @param bool $newInstance
     * @return App|object
     */
    function app(string $name = '', array $args = [], bool $newInstance = false)
    {
        return Container::getInstance()->make($name ?: App::class, $args, $newInstance);
    }
}

if (!function_exists('root_path')) {
    function root_path()
    {
        return app();
    }
}
<?php
declare(strict_types=1);

namespace Wheakerd;
/**
 * 单例模式
 */
class Facade
{

    public function __callStatic($name, $arguments)
    {
        echo "Calling static method '$name' " . implode(', ', $arguments) . "\n";
    }
}
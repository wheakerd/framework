<?php
declare(strict_types=1);

namespace flute;
/**
 * App 基础类
 * @property Config $config
 * @property Response $response
 * @property Request $request
 * @property Server $server
 */
class App extends Container
{
    /**
     * 架构函数
     */
    public function __construct()
    {
        static::setInstance($this);
    }
}
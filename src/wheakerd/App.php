<?php
declare(strict_types=1);

namespace Wheakerd;
class App
{
    /**
     * @var array|string[]
     */
    protected array $container = [
        'Request' => Request::class,
    ];

    protected array $path = [];

    /**
     * 架构函数
     */
    public function __construct()
    {
        $this->path ['root_path'] = dirname(__DIR__);
    }

    public function init()
    {
    }

    public function run()
    {
    }

    public function getRootPath()
    {
        return $this->path ['root_path'];
    }

    public function __get(string $name)
    {
        return new $name;
    }
}
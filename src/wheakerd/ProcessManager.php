<?php
declare(strict_types=1);

namespace flute;

use http\Exception\RuntimeException;
use Swoole\Process\Manager;

class ProcessManager
{
    protected null|Manager $manager = null;

    /**
     * 架构函数
     */
    public function __construct()
    {
        $this->manager = new Manager();
    }

    /**
     * 添加单个进程
     * @return void
     */
    public function add(callable $func, bool $enableCoroutine = false)
    {
        if (!is_callable($func)) throw new RuntimeException("参数错误", 500);

        $this->manager->add($func, $enableCoroutine);
    }
}
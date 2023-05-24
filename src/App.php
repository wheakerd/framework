<?php
declare(strict_types=1);

namespace Wheakerd;
class App
{

    protected array $container = [
        'Request'   =>  Request::class,
    ];

    /**
     * 架构函数
     */
    public function __construct()
    {

    }
}
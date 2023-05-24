<?php
declare(strict_types=1);

namespace Wheakerd\Request;
interface RequestInterface
{
    public function __constrcut();

    /**
     * HTTP 请求的头部信息。类型为数组，所有 key 均为小写。
     * @param string $key
     * @return array|string|int
     */
    public function header(string $key = ''): array|string|int;


    /**
     * 相当于 PHP 的 $_SERVER 数组。包含了 HTTP 请求的方法，URL 路径，客户端 IP 等信息。
     * @param string $key
     * @return mixed
     */
    public function server (string $key = ''):array;
}
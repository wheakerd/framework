<?php
declare(strict_types=1);

namespace flute;

use http\Exception\RuntimeException;
use Swoole\Http\Server as SwooleHttpServer;
use Swoole\Server as SwooleServer;
use Swoole\WebSocket\Server as SwooleWebSocketServer;
use Wheakerd\Server\InterFace\ServerInterface;

class Server
{

    protected array $config = [];

    protected object|null $server = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    // init to server
    public function initServer()
    {
        if (!isset($this->config ['host'])) throw new RuntimeException('Host information not defined！', 500);
        if (!isset($this->config ['port'])) throw new RuntimeException('Port information not defined！', 500);
        $this->start();
        return $this->server;
    }

    public function start()
    {
        $this->server = $this->makeServer(
            $this->config ['type'],
            $this->config ['host'],
            $this->config ['port'],
            $this->config ['mode'],
            $this->config ['socket_type'],
        );
    }

    public function makeServer(string $type, string $host = '0.0.0.0', int $port = 0, int $mode = SWOOLE_BASE, int $sock_type = SWOOLE_SOCK_TCP): SwooleServer
    {
        return match ($type) {
            'http' => new SwooleHttpServer($host, $port, $mode, 1),
            default => throw new \Wheakerd\Server\Exception\RuntimeException('Server config is invalid.'),
        };
    }
}
<?php
declare(strict_types=1);

namespace flute;

use \Exception;

class Config
{
    protected array $config = [];

    protected null|App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function load(string $file, string $name = ""): array
    {
        if (is_file($file)) {
            return $this->set(include $file, $name);
        }

        return $this->config;
    }

    public function set(array $config, string $name = "")
    {
        if ("" == $name) {
            $result = $this->config = array_merge($this->config, array_change_key_case($config));
        } else {
            $result = $this->config [$name] = isset($this->config [$name]) ? array_merge($this->config [$name], $config) : $config;
        }

        return $result;
    }

    public function get(string $name = "", $default = "")
    {
        if ("" == $name) {
            return $this->config;
        }

        if (false === strpos($name, ".")) {
            return $this->config [$name] ?? [];
        }

        $names = explode('.', $name);
        $config = $this->config;

        foreach ($names as $val) {
            if (isset($config [$val])) {
                $config = $config [$val];
            } else {
                return $default;
            }
        }

        return $config;
    }
}
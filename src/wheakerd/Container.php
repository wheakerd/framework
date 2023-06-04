<?php
declare(strict_types=1);

namespace flute;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * 当前类的实例化（单例）
     * @var Container|null
     */
    protected static $container;
    /**
     * 标识
     * @var array
     */
    protected array $bind = [
        "app" => App::class,
        "config" => Config::class,
        "request" => Request::class,
        "response" => Request::class,
    ];

    /**
     * 容器
     * @var array
     */
    protected array $instances = [];

    /**
     * 设置当前容器的实例
     * @param object $instance
     * @return void
     */
    public static function setInstance(object $instance): void
    {
        static::$container = $instance;
    }

    /**
     * 返回单例的实例化
     * @param string $abstract
     * @return object
     */
    public function get(string $abstract): object
    {
//        var_dump($abstract);
        if ($this->has($abstract)) {
            return $this->make($abstract);
        }

        throw new \Exception('class not exists: ' . $abstract, 500);
    }

    /**
     * 检查依赖是否已经被实例化
     * @param string $abstract
     * @return bool
     */
    public function has(string $abstract): bool
    {
        return isset($this->bind [$abstract]) || isset($this->instances [$abstract]);
    }

    /**
     * 创建容器
     * @param string|class-string<T> $abstract 类名或者标识
     * @param array $vars 变量
     * @param bool $newInstance 是否每次创建新的实例
     * @return void
     * @throws \ReflectionException
     */
    public function make(string $abstract, array $vars = [], bool $newInstance = false)
    {
        $abstract = $this->getAlias($abstract);

        if (isset($this->instances [$abstract]) && !$newInstance) {
            return $this->instances [$abstract];
        }

        $object = $this->invokeClass($abstract, $vars);

        if (!$newInstance) {
            $this->instances [$abstract] = $object;
        }

        return $object;

    }

    public function getAlias(string $abstract): string
    {
        if (isset($this->bind[$abstract])) {
            $bind = $this->bind[$abstract];

            if (is_string($bind)) {
                return $this->getAlias($bind);
            }
        }

        return $abstract;
    }

    public function invokeClass(string $abstract, array $vars = [])
    {
        try {
            $reflectionCLass = new \ReflectionClass ($abstract);
        } catch (\Exception $exception) {
            throw new \RuntimeException("class not exists: " . $abstract, 500);
        }

        $constructor = $reflectionCLass->getConstructor();

        $args = null != $constructor ? $this->bindParams($constructor, $vars) : [];

        $object = $reflectionCLass->newInstanceArgs($args);

        $this->instances [$abstract] = $object;

        return $object;
    }

    /**
     * @param ReflectionFunctionAbstract $reflect
     * @param array $vars
     * @return array|void
     */
    public function bindParams(\ReflectionFunctionAbstract $reflect, array $vars = [])
    {
        if (0 == $reflect->getNumberOfParameters()) {
            return [];
        }

        $params = $reflect->getParameters();
        $args = [];

        foreach ($params as $param) {
            $name = $param->getName();
            $reflectionType = $param->getType();

            if ($param->isVariadic()) {
                return array_merge($args, array_values($vars));
            } elseif ($reflectionType && $reflectionType instanceof \ReflectionNamedType && $reflectionType->isBuiltin() === false) {
                $args[] = $this->getObjectParam($reflectionType->getName(), $vars);
            } elseif (1 == $type && !empty($vars)) {
                $args[] = array_shift($vars);
            } elseif (0 == $type && array_key_exists($name, $vars)) {
                $args[] = $vars[$name];
            } elseif ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();
            } else {
                throw new \Exception('method param miss:' . $name);
            }
        }

        return $args;
    }

    protected function getObjectParam(string $className, array &$vars)
    {
        $array = $vars;
        $value = array_shift($array);

        if ($value instanceof $className) {
            $result = $value;
            array_shift($vars);
        } else {
            $result = $this->make($className);
        }

        return $result;
    }

    public function __get(string $name)
    {
        return $this->get($name);
    }

    public function __set(string $name, mixed $value)
    {
    }
}
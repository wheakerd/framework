<?php
declare(strict_types=1);

namespace wheakerd;

use flute\App;

/**
 * 框架事宜
 */
class Application
{
    /**
     * 路径
     * @var array
     */
    protected array $path = [];

//    protected array $config = [
//        "debug" => true,
//    ];

    /**
     * 控制器 （DI）
     * @var array
     */
    protected array $controller = [];

    /**
     * 容器 （IOC）
     * @var object|null
     */
    protected null|object $app = null;

    /**
     * 架构函数
     */
    public function __construct()
    {
        $this->path ['this_path'] = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
        $this->path ['root_path'] = dirname($this->path ['this_path'], 4);
        // 引入助手函数
//        if (is_file($this->path ['this_path'] . 'helper.php')) include_once $this->path ['this_path'] . 'helper.php';

        // 获取依赖
        $this->app = new App();
    }

    public function load()
    {
        if (is_dir($configPath = $this->getRootPath("config"))) {
            $files = glob($configPath . '*php');
        }

        foreach ($files as $file) {
            $this->app->config->load($file, pathinfo($file, PATHINFO_FILENAME));
        }

        var_dump($this->app->config->get("app"));
    }

    // 控制器
    public function initController(string $dir)
    {
    }

    // 启动
    public function run()
    {
        $this->load();

        $serverConfig = $this->getRootPath("config") . ".php";
    }

    public function getRootPath(string $dirname = "")
    {
        if ("" == $dirname) return $this->path ['root_path'];
        return $this->path ['root_path'] . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR;
    }
}
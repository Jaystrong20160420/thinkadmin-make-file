<?php

namespace ThinkadminMakeFile\MakeFile;

use think\App;

abstract class Make
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @var string
     */
    protected $type = '';

    public function __construct(App $app, $mode)
    {
        $this->app  = $app;
        $this->mode = $mode;
    }

    /**
     * 获取模板
     *
     * @return mixed
     */
    abstract protected function getStub();

    /**
     * 执行
     *
     * @param $name
     * @return bool
     */
    public function execute($name)
    {
        $classname = $this->getClassName($name);

        $pathname = $this->getPathName($classname);

        if (is_file($pathname)) {
            echo '<error>' . $this->type . ':' . $classname . ' already exists!</error>' . PHP_EOL;
            return false;
        }

        if (!is_dir(dirname($pathname))) {
            mkdir(dirname($pathname), 0755, true);
        }

        file_put_contents($pathname, $this->buildClass($classname));

        echo '<info>' . $this->type . ':' . $classname . ' created successfully.</info>' . PHP_EOL;

        return true;
    }

    /**
     * 构建类
     *
     * @param string $name
     * @return array|false|string|string[]
     */
    protected function buildClass(string $name)
    {
        $stub = file_get_contents($this->getStub());

        $namespace = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');

        $class = str_replace($namespace . '\\', '', $name);

        return str_replace(['{%className%}', '{%actionSuffix%}', '{%namespace%}', '{%app_namespace%}'], [
            $class,
            $this->app->config->get('route.action_suffix'),
            $namespace,
            $this->app->getNamespace(),
        ], $stub);
    }

    /**
     * 获取文件路径
     *
     * @param string $name
     * @return string
     */
    protected function getPathName(string $name): string
    {
        $name = substr($name, 4);

        return $this->app->getBasePath() . ltrim(str_replace('\\', '/', $name), '/') . '.php';
    }

    /**
     * 获取类名
     *
     * @param string $name
     * @return string
     */
    protected function getClassName(string $name): string
    {
        if (strpos($name, '\\') !== false) {
            return $name;
        }

        if (strpos($name, '@')) {
            [$app, $name] = explode('@', $name);
        } else {
            $app = '';
        }

        if (strpos($name, '/') !== false) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->getNamespace($app) . '\\' . $name;
    }

    /**
     * 获取命名空间
     *
     * @param string $app
     * @return string
     */
    protected function getNamespace(string $app): string
    {
        return 'app' . ($app ? '\\' . $app : '');
    }
}
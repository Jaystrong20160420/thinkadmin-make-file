<?php

namespace ThinkadminMakeFile\MakeFile;

use think\App;
use think\console\Input;
use ThinkadminMakeFile\Services\NamespaceService;

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

    /**
     * @var Input $input
     */
    protected $input;

    /**
     * @var string $mode
     */
    protected $mode;

    /**
     * @var NamespaceService
     */
    protected $namespaceService;

    public function __construct(App $app, Input $input, NamespaceService $namespaceService)
    {
        $this->app   = $app;
        $this->input = $input;
        $this->mode  = $input->getOption('mode');
        $this->namespaceService = $namespaceService;
    }

    /**
     * 执行
     *
     * @return bool
     */
    public function execute()
    {
        $classname = $this->getClassName();

        $pathname = $this->getPathName();

        if (is_file($pathname)) {
            echo '<error>' . $this->type . ':' . $classname . ' already exists!</error>' . PHP_EOL;
            return false;
        }

        if (!is_dir(dirname($pathname))) {
            mkdir(dirname($pathname), 0755, true);
        }

        file_put_contents($pathname, $this->buildClass());

        echo '<info>' . $this->type . ':' . $classname . ' created successfully.</info>' . PHP_EOL;

        return true;
    }



    /**
     * 构建类
     *
     * @return array|false|string|string[]
     */
    protected function buildClass()
    {
        $stub = file_get_contents($this->getStub());

        if (!empty($this->stubSearches())) {
            $stub = str_replace($this->stubSearches(), $this->stubReplaces(), $stub);
        }

        return $stub;
    }

    /**
     * 获取模板
     *
     * @return mixed
     */
    abstract protected function getStub();

    /**
     * 模板替换标记列表
     *
     * @return mixed
     */
    abstract protected function stubSearches();

    /**
     * 模板替换内容列表
     *
     * @return mixed
     */
    abstract protected function stubReplaces();

    /**
     * 获取文件路径
     *
     * @return string
     */
    abstract protected function getPathName();

    /**
     * 获取类名
     *
     * @return string
     */
    abstract protected function getClassName();
}
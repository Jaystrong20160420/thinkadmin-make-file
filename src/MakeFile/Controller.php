<?php

namespace ThinkadminMakeFile\MakeFile;

class Controller extends Make
{
    /**
     * @var string
     */
    protected $type = 'Controller';

    /**
     * 获取模板
     *
     * @return string
     */
    protected function getStub()
    {
        $dir =  __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR;

        return ($this->mode == '--layui' || $this->mode == '-l') ? $dir . 'controller.laytable.stub' : $dir . 'controller.stub';
    }

    protected function getClassName(string $name): string
    {
        return parent::getClassName($name) . ($this->app->config->get('route.controller_suffix') ? 'Controller' : '');
    }

    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\controller';
    }
}
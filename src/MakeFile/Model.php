<?php

namespace ThinkadminMakeFile\MakeFile;

class Model extends Make
{
    /**
     * @var string
     */
    protected $type = 'Model';

    /**
     * 获取模板
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'model.stub';
    }

    /**
     * 获取类名
     *
     * @param string $name
     * @return string
     */
    protected function getClassName(string $name): string
    {
        return parent::getClassName($name) . 'Model';
    }

    /**
     * 获取命名空间
     *
     * @param string $app
     * @return string
     */
    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\model';
    }
}
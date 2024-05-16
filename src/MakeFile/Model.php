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

    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\model';
    }
}
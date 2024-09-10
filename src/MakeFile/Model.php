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
     * @return string
     */
    protected function getClassName(): string
    {
        return $this->namespaceService->modelName();
    }

    /**
     * 获取模型文件路径
     *
     * @return string
     */
    protected function getPathName()
    {
        return $this->namespaceService->getModelPathName();
    }

    /**
     * 模板替换标记列表
     *
     * @return string[]
     */
    protected function stubSearches()
    {
        return ['{%className%}', '{%tableName%}', '{%namespace%}'];
    }

    /**
     * 模板替换内容列表
     *
     * @return array
     */
    protected function stubReplaces()
    {
        return [
            $this->namespaceService->getModelClassName(),
            $this->namespaceService->getTableName(),
            $this->namespaceService->getModelNamespace()
        ];
    }
}
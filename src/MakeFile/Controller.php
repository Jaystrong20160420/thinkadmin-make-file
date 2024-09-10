<?php

namespace ThinkadminMakeFile\MakeFile;

use ThinkadminMakeFile\Consts\OptionConst;

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
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR;

        return ($this->mode == OptionConst::MODE_LAYUI) ? $dir . 'controller.laytable.stub' : $dir . 'controller.stub';
    }

    /**
     * 获取类名
     *
     * @return string
     */
    protected function getClassName(): string
    {
        return $this->namespaceService->controllerName();
    }

    /**
     * 获取控制器文件路径
     *
     * @return string
     */
    protected function getPathName()
    {
        return $this->namespaceService->getControllerPathName();
    }

    /**
     * 模板替换标记列表
     *
     * @return string[]
     */
    protected function stubSearches()
    {
        return ['{%className%}', '{%actionSuffix%}', '{%namespace%}'];
    }

    /**
     * 模板替换内容列表
     *
     * @return array
     */
    protected function stubReplaces()
    {
        return [
            $this->namespaceService->getControllerClassName(),
            $this->app->config->get('route.action_suffix'),
            $this->namespaceService->getControllerNamespace()
        ];
    }
}
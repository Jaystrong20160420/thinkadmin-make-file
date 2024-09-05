<?php

namespace ThinkadminMakeFile\Services;

use think\App;
use think\console\Input;

class NamespaceService
{
    /**
     * @var mixed|\think\console\input\Option 自定义控制器名 ,允许二级目录如mydir/test
     */
    private $customControllerName;
    /**
     * @var string 表名
     */
    private $tablename;
    /**
     * @var string 模式
     */
    private $mode;

    /**
     * @var App app
     */
    private $app;

    /**
     * @var string 命名空间 : app\admin\
     */
    private $namespace = 'app' . '\\' . 'admin';

    /**
     * @var mixed|string 二级目录
     */
    private $controllerDir;


    public function __construct($tablename, Input $input)
    {
        $this->tablename = $tablename;
        $this->mode      = $input->getOption('mode');
        $this->app       = app();

        $this->customControllerName = $input->getOption('controller');

        if ($this->customControllerName) {// 自定义控制器名称
            if (strpos($this->customControllerName, '\\') !== false) {// 存在二级目录 格式：mydir\test
                $arr = explode('\\', $this->customControllerName);

                $this->controllerDir        = $arr[0];
                $this->customControllerName = $this->controllerDir . '\\' . ucfirst($arr[1]);
            } else if (strpos($this->customControllerName, '/') !== false) {// 存在二级目录 格式：mydir/test
                $arr = explode('/', $this->customControllerName);

                $this->controllerDir        = $arr[0];
                $this->customControllerName = $this->controllerDir . '\\' . ucfirst($arr[1]);
            } else {// 不存在二级目录，例：testManager => TestManager
                $this->customControllerName = ucfirst($this->customControllerName);
            }
        }
    }


    /**
     * 控制器名
     *
     * @return string
     */
    public function controllerName()
    {
        $controllerName = $this->customControllerName ?: $this->getUpperCaseTableName();

        return $this->namespace . '\\' . 'controller' . '\\' . $controllerName . ($this->app->config->get('route.controller_suffix') ? 'Controller' : '');
    }

    /**
     * 模型名
     *
     * @return string
     */
    public function modelName()
    {
        return $this->namespace . '\\' . 'model'.  ($this->controllerDir ? '\\' . $this->controllerDir : '') . '\\' . $this->getUpperCaseTableName() . 'Model';
    }

    public function viewName()
    {
        return $this->viewRoot() . '\\' . $this->tablename;
    }

    /**
     * 视图文件名
     * index.html
     * form.html
     *
     * @return string[]
     */
    public function viewList()
    {
        return [
            'index' => $this->viewRoot() . '\\' . $this->tablename . '\\' . 'index.html',
            'form'  => $this->viewRoot() . '\\' . $this->tablename . '\\' . 'form.html',
        ];
    }

    /**
     * 视图文件根目录
     *
     * @return string
     */
    private function viewRoot()
    {
        return $this->namespace . '\\' . 'view' .  ($this->controllerDir ? '\\' . $this->controllerDir : '');
    }

    /**
     * 获取表名：首字母大写
     * test => Test
     *
     * @return string
     */
    private function getUpperCaseTableName()
    {
        return ucfirst($this->tablename);
    }
}
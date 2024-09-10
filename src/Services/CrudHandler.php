<?php

namespace ThinkadminMakeFile\Services;

use think\App;
use think\console\Input;
use ThinkadminMakeFile\Consts\OptionConst;
use ThinkadminMakeFile\MakeFile\Controller;
use ThinkadminMakeFile\MakeFile\FormView;
use ThinkadminMakeFile\MakeFile\IndexView;
use ThinkadminMakeFile\MakeFile\Model;

class CrudHandler
{
    /**
     * @var NamespaceService
     */
    private $namespaceService;
    /**
     * @var App $app
     */
    private $app;
    /**
     * @var Input $input
     */
    private $input;

    public function __construct(App $app, NamespaceService $namespaceService, Input $input)
    {
        $this->app   = $app;
        $this->input = $input;

        $this->namespaceService = $namespaceService;
    }

    /**
     * 一键创建CRUD
     *
     * @return void
     */
    public function create()
    {
        // 创建控制器
        (new Controller($this->app, $this->input, $this->namespaceService))->execute();

        // 创建模型
        if ($this->input->getOption('mode') == OptionConst::MODE_LAYUI) {
            (new Model($this->app, $this->input, $this->namespaceService))->execute();
        }

        // 创建视图index.html
        (new IndexView($this->app, $this->input, $this->namespaceService))->execute();

        // 创建视图form.html
        (new FormView($this->app, $this->input, $this->namespaceService))->execute();
    }

    /**
     * 一键删除CRUD
     *
     * @return void
     */
    public function delete()
    {
        $needDeleteFiles = [
            $this->namespaceService->getControllerPathName(),
            $this->namespaceService->getModelPathName(),
            $this->namespaceService->getViewIndexPathName(),
            $this->namespaceService->getViewFormPathName(),
            $this->namespaceService->getViewDirPathName(),
        ];

        foreach ($needDeleteFiles as $file) {
            if (is_file($file)) {
                if (file_exists($file)) {
                    if (unlink($file)) {
                        echo "成功删除文件: $file\n";
                    } else {
                        echo "无法删除文件: $file\n";
                    }
                } else {
                    echo "文件不存在: $file\n";
                }
            } else if (is_dir($file)) {
                if (rmdir($file)) {
                    echo "成功删除文件夹: $file\n";
                } else {
                    echo "删除文件夹失败: $file\n";
                }
            }
        }
    }
}
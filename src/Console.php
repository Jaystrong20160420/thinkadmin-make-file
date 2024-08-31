<?php

namespace ThinkadminMakeFile;

use think\App;
use ThinkadminMakeFile\Commands\CrudCommand;
use think\admin\service\ProcessService;
use think\admin\service\RuntimeService;
use ThinkadminMakeFile\Commands\MenuCommand;
use ThinkadminMakeFile\Consts\MakeConst;

class Console
{
    private $app;

    /**
     * @param App $app
     * @param $argv
     */
    public function __construct(App $app)
    {
        // 初始化应用、加载全局配置
        $this->app = $app;
    }

    /**
     * 一键生成控制器、模型和视图
     *
     * @return void
     */
    public function run()
    {
        $this->app->console->addCommand(CrudCommand::class, 'crud');
        $this->app->console->addCommand(MenuCommand::class, 'menu');

        try {
            return $this->app->console->run();
        } catch (\Exception $exception) {
            ProcessService::message($exception->getMessage());
            return 0;
        }
    }
}
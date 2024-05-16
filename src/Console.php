<?php

namespace ThinkadminMakeFile;

use think\App;
use ThinkadminMakeFile\MakeFile\Controller;
use ThinkadminMakeFile\MakeFile\Make;
use ThinkadminMakeFile\MakeFile\Model;
use ThinkadminMakeFile\MakeFile\View;

class Console
{
    /**
     * @var mixed 命令参数
     */
    private $argv;

    private $app;

    protected $defaultCommands = [
//        'make:set'        => Controller::class,
        'make:controller' => Controller::class,
        'make:model'      => Model::class,
        'make:view'       => View::class,
    ];

    /**
     * @param App $app
     * @param $argv
     */
    public function __construct(App $app, $argv = null)
    {
        // 去除命令名
        array_shift($argv);
        $this->argv = $argv;

        $this->app = $app;

        if (!in_array($this->argv[0], array_keys($this->defaultCommands))) {
            echo "命令不存在";
        }

        if (!isset($this->argv[1])) {
            echo '请输出要创建的类名';
        }
    }

    /**
     * 一键生成控制器、模型和视图
     *
     * @return void
     */
    public function run()
    {
        /*
         Array
            (
                [0] => make:controller
                [1] => admin@Test
            )
         Array
            (
                [0] => make:controller
                [1] => app\admin\controller\Test
            )
         */

        $command = $this->argv[0];
        $name = $this->argv[1];

        if ($command == 'make:set') {
            (new Controller($this->app))->execute($name);
            (new Model($this->app))->execute($name);
            (new View($this->app))->execute($name);
        } else {
            /**@var Make $make */
            $make = $this->defaultCommands[$command];
            (new $make($this->app))->execute($name);
        }
    }
}
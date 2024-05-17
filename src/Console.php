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

    const MODE_LIST = [
        '--layui',
        '-l',
        '--static',
        '-s'
    ];

    protected $defaultCommands = [
        'make:set'        => '',
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
            return false;
        }

        if (!isset($this->argv[1])) {
            echo '请输出要创建的类名';
            return false;
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
        $mode = $this->argv[2] ?? '--layui';

        if (!in_array($mode, self::MODE_LIST)) {
            echo '错误的模式。可用模式：--layui、-l、--static、-s';
            return false;
        }

        if ($command == 'make:set') {
            (new Controller($this->app, $mode))->execute($name);
            if (in_array($mode, ['--layui', '-l'])) {
                (new Model($this->app, $mode))->execute($name);
            }
            (new View($this->app, $mode))->execute($name);
        } else {
            /**@var Make $make */
            $make = $this->defaultCommands[$command];
            (new $make($this->app, $mode))->execute($name);
        }
    }
}
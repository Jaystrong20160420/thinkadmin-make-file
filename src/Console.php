<?php

namespace ThinkadminMakeFile;

use think\App;

class Console
{
    /**
     * @var mixed 命令参数
     */
    private $argv;

    private $app;

    /**
     * @param App $app
     * @param $argv
     */
    public function __construct(App $app, $argv = null)
    {
        if (null === $argv) {
            $this->argv = $_SERVER['argv'];

            // 去除命令名
            array_shift($this->argv);
        }
        print_r($app->getBasePath());die;
    }
}
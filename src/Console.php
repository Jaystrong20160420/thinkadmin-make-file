<?php

namespace ThinkadminCustomTools\ThinkadminMakeFile;

class Console
{
    /**
     * @var mixed 命令参数
     */
    private $argv;

    /**
     * @param $argv
     */
    public function __construct($argv = null)
    {
        if (null === $argv) {
            $this->argv = $_SERVER['argv'];

            // 去除命令名
            array_shift($this->argv);
        }
    }
}
<?php
declare (strict_types = 1);

namespace ThinkadminMakeFile\Commands;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use ThinkadminMakeFile\Consts\MakeConst;
use ThinkadminMakeFile\MakeFile\Controller;
use ThinkadminMakeFile\MakeFile\Make;
use ThinkadminMakeFile\MakeFile\Model;
use ThinkadminMakeFile\MakeFile\View;
class CrudCommand extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('crud')
            ->setDescription('一键生成CRUD代码');
    }

    protected function execute(Input $input, Output $output)
    {

//        if ($command == 'make:set') {
//            (new Controller($this->app, $mode))->execute($name);
//            if (in_array($mode, ['--layui', '-l'])) {
//                (new Model($this->app, $mode))->execute($name);
//            }
//            (new View($this->app, $mode))->execute($name);
//        } else {
//            /**@var Make $make */
//            $make = $this->defaultCommands[$command];
//            (new $make($this->app, $mode))->execute($name);
//        }
        echo '你这只猫呀';echo PHP_EOL;

        $output->writeln('一键生成CRUD代码');
    }
}

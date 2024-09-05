<?php
declare (strict_types=1);

namespace ThinkadminMakeFile\Commands;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use ThinkadminMakeFile\Consts\MakeConst;
use ThinkadminMakeFile\Consts\OptionConst;
use ThinkadminMakeFile\MakeFile\Controller;
use ThinkadminMakeFile\MakeFile\Make;
use ThinkadminMakeFile\MakeFile\Model;
use ThinkadminMakeFile\MakeFile\View;
use ThinkadminMakeFile\Services\NamespaceService;
use ThinkadminMakeFile\Services\TableInfoService;
use think\facade\Validate;

class CrudCommand extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('crud')
            ->addOption('mode', 'm', Option::VALUE_OPTIONAL, '模式，默认为layui', OptionConst::MODE_LAYUI)
            ->addOption('table', 't', Option::VALUE_REQUIRED, '表名', null)
            ->addOption('menu', 'u', Option::VALUE_OPTIONAL, '是否生成菜单', OptionConst::NO)
            ->addOption('delete', 'd', Option::VALUE_OPTIONAL, '删除模式,将删除之前使用CRUD命令生成的相关文文件', OptionConst::NO)
            ->addOption('controller', 'c', Option::VALUE_OPTIONAL, '生成控制器名，包括生成二级目录', OptionConst::NO)
            ->setDescription('一键生成CRUD代码');
    }

    protected function execute(Input $input, Output $output)
    {
        // 验证参数与选项
        $this->validateParametersAndOptions($input, $output);
        // -t 创建 -c 创建指定的二级目录和控制器名
        // app\admin\controller
        // app\admin\model
        // app\admin\view\test\index
        // app\admin\view\test\form
        // -d 删除
        // -u 生成菜单
        // -u -d 删除菜单
//        if ($input->getOption('mode'))

        $tablename = $input->getOption('table');
        $namespaceService = new NamespaceService($tablename, $input);
        echo '<pre>'; var_dump($namespaceService->controllerName(),
        $namespaceService->modelName(),
        $namespaceService->viewName(),
        $namespaceService->viewList());
die;


        $info = (new TableInfoService())->getTableInfo('image');
        echo '<pre>';
        print_r($info);
        die;
        // -t 表名 根据表名获取
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

        $output->writeln('一键生成CRUD代码');
    }

    /**
     * 验证参数与选项
     *
     * @param Input $input
     * @param Output $output
     * @return void
     */
    private function validateParametersAndOptions(Input $input, Output $output)
    {
        $validate = Validate::rule([
            'mode'   => 'require|in:' . implode(',', OptionConst::$modeList),
            'table'  => 'require',
            'menu'   => 'in:' . implode(',', OptionConst::$yesNoList),
            'delete' => 'in:' . implode(',', OptionConst::$yesNoList),
        ]);

        $data = [
            'mode'   => $input->getOption('mode'),
            'table'  => $input->getOption('table'),
            'menu'   => $input->getOption('menu'),
            'delete' => $input->getOption('delete'),
        ];

        $validate->message([
            'table' => '请输入表名',
        ]);

        if (!$validate->check($data)) {
            $output->writeln($validate->getError());
            die;
        }
    }
}

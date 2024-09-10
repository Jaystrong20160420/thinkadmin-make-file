<?php
declare (strict_types=1);

namespace ThinkadminMakeFile\Commands;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use ThinkadminMakeFile\Consts\OptionConst;
use ThinkadminMakeFile\Services\CrudHandler;
use ThinkadminMakeFile\Services\NamespaceService;
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

        $tablename = $input->getOption('table');
        $isDelete  = $input->getOption('delete');
        $isMenu    = $input->getOption('menu');

        // 命名空间服务
        $namespaceService = new NamespaceService($tablename, $input);
        $crudHandler      = new CrudHandler($this->app, $namespaceService, $input);

        if ($isDelete == OptionConst::NO) {
            $crudHandler->create();// 一键创建
            if (!$isMenu == OptionConst::YES) {
                // 创建菜单********************************************
            }
            $output->writeln('一键生成CRUD代码');
        } else {
            $crudHandler->delete();// 一键删除
        }
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

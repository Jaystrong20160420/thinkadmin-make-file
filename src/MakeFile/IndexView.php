<?php

namespace ThinkadminMakeFile\MakeFile;

use ThinkadminMakeFile\Consts\OptionConst;

class IndexView extends Make
{
    protected $type = 'View';

    protected function getStub()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;

        return ($this->mode == OptionConst::MODE_LAYUI) ? $dir . 'index.laytable.stub' : $dir . 'index.stub';
    }

    protected function stubSearches()
    {
        return [];
    }

    protected function stubReplaces()
    {
        return [];
    }

    protected function getPathName()
    {
        return $this->namespaceService->getViewIndexPathName();
    }

    protected function getClassName()
    {
        return $this->namespaceService->viewList()['index'];
    }
}
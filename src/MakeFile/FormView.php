<?php

namespace ThinkadminMakeFile\MakeFile;

class FormView extends Make
{
    protected $type = 'View';

    protected function getStub()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;

        return $dir . 'form.stub';
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
        return $this->namespaceService->getViewFormPathName();
    }

    protected function getClassName()
    {
        return $this->namespaceService->viewList()['form'];
    }
}
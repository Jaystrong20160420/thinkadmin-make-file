<?php

namespace ThinkadminMakeFile\MakeFile;

use think\helper\Str;

class View extends Make
{
    /**
     * @var string
     */
    protected $type = 'View';


    public function execute($name)
    {

        $viewDirName = $this->getViewDirName($name);

        $pathname = $this->getPathName($viewDirName);

        foreach ($this->getStub() as $htmlname => $stub) {
            $filename = $pathname . DIRECTORY_SEPARATOR . $htmlname . '.html';

            if (is_file($filename)) {
                echo '<error>' . $this->type . ':' . $filename . ' already exists!</error>';
                return false;
            }

            if (!is_dir(dirname($filename))) {
                mkdir(dirname($filename), 0755, true);
            }

            file_put_contents($filename, $stub);

            echo '<info>' . $this->type . ':' . $filename . ' created successfully.</info>' . PHP_EOL;
        }


        return true;
    }

    protected function getViewDirName(string $name): string
    {
        if (strpos($name, '\\') !== false) {
            return $name;
        }

        if (strpos($name, '@')) {
            [$app, $name] = explode('@', $name);
        } else {
            $app = '';
        }

        if (strpos($name, '/') !== false) {
            $name = str_replace('/', '\\', $name);
        }

        $name = Str::snake($name);

        return $this->getNamespace($app) . '\\' . $name;
    }

    protected function getStub()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;

        return [
            'index' => file_get_contents(($this->mode == '--layui' || $this->mode == '-l') ? $dir . 'index.laytable.stub' : $dir . 'index.stub'),
            'form'  => file_get_contents($dir . 'form.stub'),
        ];
    }

    protected function getPathName(string $name): string
    {
        $name = substr($name, 4);

        return $this->app->getBasePath() . ltrim(str_replace('\\', '/', $name), '/');
    }

    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\view';
    }
}
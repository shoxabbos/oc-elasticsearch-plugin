<?php namespace Shohabbos\Elasticsearch;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function register()
    {
        $this->registerConsoleCommand('shohabbos.reindex', 'Shohabbos\Elasticsearch\Console\ReindexCommand');
    }

}

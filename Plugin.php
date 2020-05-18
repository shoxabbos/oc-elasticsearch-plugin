<?php namespace Shohabbos\Elasticsearch;

use App;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use System\Classes\PluginBase;
use Shohabbos\Elasticsearch\Classes\ElasticsearchclientServiceProvider;

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

        App::register(ElasticsearchclientServiceProvider::class);
    }

}

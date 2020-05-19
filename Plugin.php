<?php namespace Shohabbos\Elasticsearch;

use App;
use Backend;
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
        return [
            'settings' => [
                'label'       => 'Elasticsearch settings',
                'description' => 'Manage hosts and other settings of the plugin.',
                'category'    => 'Elasticsearch',
                'icon'        => 'icon-cog',
                'class'       => 'Shohabbos\Elasticsearch\Models\Settings',
                'order'       => 500,
                'keywords'    => 'elasticsearch search',
                'permissions' => ['shohabbos.elasticsearch.manage_settings']
            ],
            'settings-indexes' => [
                'label'       => 'Elasticsearch indexes',
                'description' => 'Manage available indexes, create new indexex, reindex avaiable data.',
                'category'    => 'Elasticsearch',
                'icon'        => 'icon-search',
                'url'         => Backend::url('shohabbos/elasticsearch/indexes'),
                'order'       => 500,
                'keywords'    => 'elasticsearch index add index create new index'
            ]
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('shohabbos.reindex', 'Shohabbos\Elasticsearch\Console\ReindexCommand');

        App::register(ElasticsearchclientServiceProvider::class);
    }

}

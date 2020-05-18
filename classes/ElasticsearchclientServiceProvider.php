<?php namespace Shohabbos\Elasticsearch\Classes;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use October\Rain\Support\ServiceProvider;

class ElasticsearchclientServiceProvider extends ServiceProvider
{

    public function register()
    {
    	$this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts(["localhost:9200"])
                ->build();
        });
    }

}
<?php namespace Shohabbos\Elasticsearch\Classes;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use October\Rain\Support\ServiceProvider;
use Shohabbos\Elasticsearch\Models\Settings;

class ElasticsearchclientServiceProvider extends ServiceProvider
{

    public function register()
    {

    	\App::before(function($request) {
    		$data = Settings::get('fields', []);	

    		$hosts = [];
    		foreach ($data as $key => $value) {
    			$hosts[] = implode(":", $value);
    		}

    		$this->app->bind(Client::class, function ($app) use ($hosts) {
	            return ClientBuilder::create()
	                ->setHosts($hosts)
	                ->build();
	        });
    	});
    	
    	
    }

}
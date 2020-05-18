<?php namespace Shohabbos\Elasticsearch\Classes;

trait Searchable
{
    public $elasticrawdata;

    // Add observable class 
    public static function bootSearchable()
    {
        static::observe(ElasticsearchObserver::class);
    }

    public function getSearchIndex()
    {
        return $this->getTable();
    }

    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray()
    {
        if (method_exists($this, 'useSearchArrayData')) {
            return $this->useSearchArrayData();
        }

        return $this->toArray();
    }

    // model::elasticsearch()->find($id);
    public static function elasticsearch() {
        return new ElasticsearchRepository(new self);
    }
    
}
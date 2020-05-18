<?php namespace Shohabbos\Elasticsearch\Classes;

use Shohabbos\Elasticsearch\Models\Index;

trait Searchable
{
    public $elasticrawdata;
    public $indexInfo;

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
        $this->indexInfo = Index::where('model', self::class)->first();

        if (method_exists($this, 'useSearchArrayData')) {
            return $this->useSearchArrayData();
        }

        if (isset($this->indexInfo) && is_array($this->indexInfo->fields)) {
            $data = [];

            foreach ($this->indexInfo->fields as $value) {
                if (isset($this->{$value['key']})) {
                    $data[$value['key']] = $this->{$value['key']};
                }
            }

            return $data;
        }

        return $this->toArray();
    }

    // model::elasticsearch()->find($id);
    public static function elasticsearch() {
        return new ElasticsearchRepository(new self);
    }
    
}
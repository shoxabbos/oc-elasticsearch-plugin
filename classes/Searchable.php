<?php namespace Shohabbos\Elasticsearch\Classes;

use App;
use Elasticsearch\Client;
use Shohabbos\Elasticsearch\Models\Index;

class Searchable extends \October\Rain\Extension\ExtensionBase
{   
    public $elasticrawdata;
    public $indexInfo;
    protected $parent;

    /** @var \Elasticsearch\Client */
    private $es;

    public function __construct($parent)
    {
        $this->parent = $parent;
        $this->es = App::make(Client::class);

        $this->parent->bindEvent('model.afterSave', function() {
            $this->es->index([
                'index' => $this->parent->getSearchIndex(),
                'type' => $this->parent->getSearchType(),
                'id' => $this->parent->getKey(),
                'body' => $this->parent->toSearchArray(),
            ]);
        });

        $this->parent->bindEvent('model.afterDelete', function() {
            $this->es->delete([
                'index' => $this->parent->getSearchIndex(),
                'type' => $this->parent->getSearchType(),
                'id' => $this->parent->getKey(),
            ]);
        });
    }

    public function getSearchIndex()
    {
        if (property_exists($this->parent, 'useSearchIndex')) {
            return $this->parent->useSearchIndex;
        }

        return $this->parent->getTable();
    }

    public function getSearchType()
    {
        if (property_exists($this->parent, 'useSearchType')) {
            return $this->parent->useSearchType;
        }

        return $this->parent->getTable();
    }

    public function toSearchArray()
    {
        $this->parent->indexInfo = Index::where('model', $this->parent->class)->first();

        if (method_exists($this->parent, 'useSearchArrayData')) {
            return $this->parent->useSearchArrayData();
        }

        if (isset($this->parent->indexInfo) && is_array($this->parent->indexInfo->fields)) {
            $data = [];

            foreach ($this->parent->indexInfo->fields as $value) {
                if (isset($this->parent->{$value['key']})) {
                    $data[$value['key']] = $this->parent->{$value['key']};
                }
            }

            return $data;
        }

        return $this->parent->toArray();
    }

    public function scopeElasticsearch($query) {
        return new ElasticsearchRepository($this->parent);
    }
    
}
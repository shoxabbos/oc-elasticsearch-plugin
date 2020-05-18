<?php namespace Shohabbos\Elasticsearch\Classes;

use App;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use Shohabbos\Elasticsearch\Models\Index;

class ElasticsearchRepository
{
    private $model;
    private $size;
    private $source;
    private $query;
    private $sort = [];
    private $indexInfo;

    /** @var \Elasticsearch\Client */
    private $es;


    public function __construct($model) {
        $this->model = $model;
        $this->es = \App::make(Client::class);

        if ($this->model) {
            $this->indexInfo = Index::where('model', $this->model->class)->first();
        }
    }

    public function select($source) {
        $this->source = $source;

        return $this;
    }

    public function limit($size) {
        $this->size = $size;

        return $this;
    }

    public function orderBy($field) {
        if (in_array($this->getType($field), ['integer', 'date'])) {
            $this->sort[] = [$field => "asc"];
        }
        
        return $this;
    }

    public function orderByDesc($field) {
        if (in_array($this->getType($field), ['integer', 'date'])) {
            $this->sort[] = [$field => "desc"];
        }

        return $this;
    }

    public function dumpParams() {
        return $this->buildQueryParams();
    }

    public function get() {
        $params = [
            'index' => $this->model->getSearchIndex(),
            'type' => $this->model->getSearchType(),
            'body' => $this->buildQueryParams()
        ];

        $result = $this->es->search( $params);

        return $this->buildCollection($result);
    }

    public function find($id) {
        $params = [
            'index' => $this->model->getSearchIndex(),
            'type' => $this->model->getSearchType(),
            'id' => (string) $id,
        ];

        try {
            return $this->makeModel($this->es->get($params));
        } catch (\Exception $e) {
            return null;
        }
    }

    public function rawQuery($query) {
        $this->query = $query;

        return $this;
    }

    public function whereIn($query, array $fields) {
        $this->query['multi_match'] = [
            'fields' => $fields,
            'query' => $query
        ];

        return $this;
    }

    public function where($match) {
        $this->query['match'] = $match;

        return $this;
    }

    private function buildQueryParams() {
        $params = [
            'query' => $this->query
        ];

        if ($this->size) {
            $params['size'] = $this->size;
        }

        if (!empty($this->source)) {
            $params['_source'] = $this->source;
        }

        if (!empty($this->sort)) {
            $params['sort'] = $this->sort;
        }

        return $params;
    }

    private function makeModel($result) {
        if (!$result['found']) {
            return null;
        }

        foreach ($result['_source'] as $key => $value) {
            $this->model->{$key} = $value;
        }

        $this->model->elasticrawdata = $result;

        return $this->model;
    }

    private function buildCollection(array $items)
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return $this->model::findMany($ids)
            ->sortBy(function ($item) use ($ids) {
                return array_search($item->getKey(), $ids);
            });
    }

    private function getType($field) {
        if (isset($this->indexInfo) && is_array($this->indexInfo->fields)) {
            return $this->indexInfo->fields[$field];
        } else {
            return null;
        }
    }

}
<?php namespace Shohabbos\Elasticsearch\Models;

use Model;
use Schema;
/**
 * Model
 */
class Index extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_elasticsearch_indexes';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = ['fields'];

    public function getModelOptions() {
        return [];
    }
    
    public function getKeyOptions() {
        $object = new $this->model;

        if ($object) {
            return Schema::getColumnListing($object->getTable());    
        }

        return [];
    }

    public function beforeSave() {
        $object = new $this->model;
    }
}

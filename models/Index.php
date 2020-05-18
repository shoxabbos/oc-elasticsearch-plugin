<?php namespace Shohabbos\Elasticsearch\Models;

use Model;

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
    
}

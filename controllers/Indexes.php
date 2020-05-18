<?php namespace Shohabbos\Elasticsearch\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Artisan;

class Indexes extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_indexes' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Shohabbos.Elasticsearch', 'elasticsearch-menu', 'elasticsearch-menu-indexes');
    }

    public function onReindex ()
    {
        Artisan::call('shohabbos:reindex', ['--index' => input('id')]);
    }


}

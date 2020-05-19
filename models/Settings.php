<?php namespace Shohabbos\Elasticsearch\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'shohabbos_elasticsearch_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
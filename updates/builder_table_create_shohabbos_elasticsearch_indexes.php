<?php namespace Shohabbos\Elasticsearch\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosElasticsearchIndexes extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_elasticsearch_indexes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('model')->unique();
            $table->text('fields')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_elasticsearch_indexes');
    }
}

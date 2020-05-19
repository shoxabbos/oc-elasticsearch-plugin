<?php namespace Shohabbos\Elasticsearch\Console;

use App;
use Flash;
use Elasticsearch\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Shohabbos\Elasticsearch\Models\Index;

class ReindexCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'shohabbos:reindex';

    /**
     * @var string The console command description.
     */
    protected $description = 'Does reindex tables.';

    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->elasticsearch = \App::make(Client::class);
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->info('Indexing all items. This might take a while...');

        $index = Index::find($this->option('index'));

        if (!$index) {
            $this->error('Index not found!');
            return;
        }

        $model = App::make($index->model); 

        if (!$model->methodExists('getSearchIndex') || !$model->methodExists('getSearchType')) {
            Flash::error('You forgot use **Searchable** trait for this class');
            return;
        }


        foreach ($index->model::cursor() as $item)
        {
            $this->elasticsearch->index([
                'index' => $item->getSearchIndex(),
                'type' => $item->getSearchType(),
                'id' => $item->getKey(),
                'body' => $item->toSearchArray(),
            ]);

            $this->output->write(".");
        }


        Flash::info('Done!');
        $this->info('Done!');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['index', null, InputOption::VALUE_REQUIRED, 'Index number.', null],
        ];
    }

}
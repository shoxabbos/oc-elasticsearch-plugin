<?php namespace Shohabbos\Elasticsearch\Console;

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

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->info('Indexing all articles. This might take a while...');

        $


        foreach (Article::cursor() as $article)
        {
            $this->elasticsearch->index([
                'index' => $article->getSearchIndex(),
                'type' => $article->getSearchType(),
                'id' => $article->getKey(),
                'body' => $article->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->info('\nDone!');

    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['index', InputArgument::REQUIRED, 'Index number.'],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
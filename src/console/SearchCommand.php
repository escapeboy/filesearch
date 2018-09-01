<?php

namespace FileSearch\Console;

use FileSearch\Search;
use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class SearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search {query} {--path=storage/data/test1/}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search in files for given query';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    public function handle()
    {
        $search = new Search($this->argument('query'), $this->option('path'));
        $results = $search->get();
        if(!count($results)){
            $this->info('No results found for "'.$this->argument('query').'" in '.$this->option('path'));
        }
        $table_data = [];
        $table_headers = ['File', 'Line #', 'Content'];
        $outputStyle = new OutputFormatterStyle(null,'blue', array('bold'));
        $this->output->getFormatter()->setStyle('mark', $outputStyle);

        foreach($results as $file => $lines){
            $file_name = substr($file, 0, 10).'...'.substr($file, -30);
            foreach($lines as $line_num => $content){
                $content = preg_replace('/('.$this->argument('query').')/i', '<mark>$1</mark>', $content);
                $table_data[] = [$file_name, '<comment>'.$line_num.'</comment>', trim($content)];
            }
        }
        $this->output->table($table_headers, $table_data);
    }
}

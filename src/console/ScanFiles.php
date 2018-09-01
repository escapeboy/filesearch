<?php

namespace FileSearch\Console;

use FileSearch\Scan;
use Illuminate\Console\Command;

class ScanFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan {--path=storage/data/test1/}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan files and insert them into database';

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
        $scan = new Scan($this->option('path'));
        $scan->save();
    }
}

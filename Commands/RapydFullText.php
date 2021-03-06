<?php

namespace App\Rapyd\Modules\System\Commands;

use Illuminate\Console\Command;

class RapydFullText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rapyd:fulltext {--action=indexall}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handles the data creation, migration and seeding of a module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      ini_set('memory_limit',-1);
      if ($this->option('action') == 'indexall') {
        $this->info('Beginning to reindex all full text models');
        \FullText::reindex_all(true);
        $this->info('Successfully reindexed all full text models');
      }
    }
}

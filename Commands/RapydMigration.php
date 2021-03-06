<?php

namespace App\Rapyd\Modules\System\Commands;

use Illuminate\Console\Command;

class RapydMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rapyd:migration';

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
        //
    }
}

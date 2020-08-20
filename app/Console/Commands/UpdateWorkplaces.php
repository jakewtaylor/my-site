<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use WorkplaceSeeder;

class UpdateWorkplaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-workplaces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the workplaces table and reseeds.';

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
        Artisan::call('migrate:refresh', [
            '--path' => 'database/migrations/2018_09_21_104641_create_workplaces_table.php',
        ]);

        Artisan::call('db:seed', [
            '--class' => WorkplaceSeeder::class,
        ]);
    }
}

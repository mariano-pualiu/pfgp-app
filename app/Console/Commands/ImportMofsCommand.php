<?php

namespace App\Console\Commands;

use App\Imports\MofsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Excel;

class ImportMofsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-mofs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a csv MOFs file into the mongoDB database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Importing MOFs...');
        (new MofsImport)->import('pfgp/Database.csv', 'local', Excel::CSV);
        $this->info('Import successful!');
    }
}

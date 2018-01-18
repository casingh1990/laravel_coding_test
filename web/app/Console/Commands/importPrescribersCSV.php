<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class importPrescribersCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importPrescribersCSV {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a CSV File of Prescribers.\n Columns supported are:\n
    id, npi, name, email, password, phone, phone_extension, fax, role, is_admin,created_at,updated_at';

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

    }
}

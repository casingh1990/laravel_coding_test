<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class importPrescribersCSV extends Command
{
    /**
     * @var string Filename
     **/
    private $file;
    /**
     * @var string error values
     **/
    private $errors;

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
    protected $description = 'Imports a CSV File of Prescribers. Columns supported are:
    id, npi, name, email, password, phone, phone_extension, fax, role, is_admin,created_at,updated_at';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->errors = "";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Get Name of file
        $this->file = $this->argument("file");

        //validate input
        if ($this->validate()){
            return $this->outputError();
        }
    }

    private function validate(){
        $fs = new Filesystem();
        if (!$fs->exists($this->file)){
            $this->addError("File {$this->file} does not exist");
        }
        else if ($fs->extension($this->file) !== "csv"){
            $this->addError("File must be csv");
        }
        return $this->hasErrors();
    }

    private function hasErrors(){
        return ($this->errors !== "");
    }

    /**
     * Outputs any error to the console
     * @return mixed
     */
    private function outputError(){
        return $this->error($this->errors);
    }

    private function addError($error_message){
        $this->errors .= ($this->errors === "")?$error_message:("\n" . $error_message);
    }


}

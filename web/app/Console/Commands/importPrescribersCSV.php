<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

use App\Prescriber;

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

        $this->processImport();
    }

    /**
     * Does the import operation
     * Assumes file has already been validated (exists and is csv)
     **/
    private function processImport(){
        try{
            //open file and read in lines to PHP Array
            $prescribers = file($this->file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            //convert first row to keys
            $keys=$this->setupkeys($prescribers[0]);

            //get and show number of entries in file
            $no_prescribers = count($prescribers) - 1;
            $this->info("Importing $no_prescribers prescribers from {$this->file}");

            //progress bar
            $bar = $this->output->createProgressBar($no_prescribers);

            /**
             * variables to track
             * $imported
             * $failed
             * $failed message
             **/
            $imported = 0;
            $failed=0;
            $failed_message = "";
            for ($i=1; $i<=$no_prescribers; $i++){
                //using try catch so that any individual issues are captured separately
                try{
                    $prescriber_data = $this->convert_csv_to_prescriber($keys, $prescribers[$i]);
                    $prescriber_data->save();
                    //if no error, assuming that import was successful
                    $imported++;
                }
                catch(\Illuminate\Database\QueryException $e){
                    $failed++;
                    //right now just storing the message
                    $failed_message .= $e->getMessage() . "\n";
                }
                $bar->advance();
            }
            $bar->finish();
            $this->info("\n\nSummary\n\nImported $imported records");

            if ($failed > 0){
                $this->error("Failed to import $failed records");
            }
        }catch(Exception $e){

        }//end of catch block
    }//end of import function

    /**
     * Convert prescrive csv to Prescriber Object
     * @param $keys -> Column Heading in csv
     * @param $prescriber_csv -> Prescriber data in csv format
     * @return Prescriber
     **/
    private function convert_csv_to_prescriber(&$keys, &$prescriber_csv){
        $row_data = explode(",", $prescriber_csv);
        $prescriber = new Prescriber();
        foreach($keys as $key => $value){

            //adding only rows that contain data
            //depending on database to validate required fields
            if ($row_data[$key] !== ""){
                    //matching column heading with data
                    $prescriber->$value = $row_data[$key];
            }
        }
        return $prescriber;
    }//end of function convert_csv_to_prescriber

    //Converts keys comma separated into php array
    private function setupkeys($keys_string){
      $keys = explode(",",$keys_string);
      foreach($keys as &$key){
        switch($key){
          case "phone_ext":
            $key = "phone_extension";
            break;
        }
      }
      return $keys;
    }

    /**
     * Performs basic validation
     *
     */
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

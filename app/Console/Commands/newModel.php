<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\content\modelContent;

class newModel extends Command
{
  
    protected $signature = 'newModel:go {modelName}';

   
    protected $description = 'build new model.php with createUpdate file ';

    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $modelName=$this->argument('modelName');
        $folderPath="app/Models/";
        if (!file_exists( $folderPath)) 
                    mkdir( $folderPath, 0777, true);


        //create Controller
        $path =$modelName.'.php' ;
        $file = fopen( $folderPath.$path, "wb") ;
        fwrite($file, modelcontent::index($modelName));
        fclose($file);


        $this->info("create model of {$modelName} successfully by mostafa ramdan");

    }
    public static function controllerFile($modelName){

    }
}

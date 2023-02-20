<?php

namespace App\Console\Commands;
use App\Console\Commands\content\controllerContent;
use App\Console\Commands\content\ruleContent;
use Illuminate\Console\Command;

class ncr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ncr:go {folderName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'build new folder contain rules.php and controller.php ';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $folderName=$this->argument('folderName');
        $folderPath="app/Http/Controllers/Apis/Controllers/{$folderName}/";
        if (!file_exists( $folderPath)) 
                    mkdir( $folderPath, 0777, true);


        //create Controller
        $path =$folderName.'Controller'.'.php' ;
        $file = fopen( $folderPath.$path, "wb") ;
        fwrite($file, controllerContent::index($folderName));
        fclose($file);

       //create rules
        $path =$folderName.'Rules'.'.php' ;
        $file = fopen( $folderPath.$path, "wb") ;
        fwrite($file, ruleContent::index($folderName));
        fclose($file);

        $myfile = fopen("routes/api.php", "a") or die("Unable to open file!");
        $txt = "route::post('{$folderName}','index@index');";
        fwrite($myfile, "\n". $txt);
        fclose($myfile);

        $this->info("create controller and rule  of {$folderName} successfully by mostafa ramdan");

    }
    public static function controllerFile($folderName){

    }
}

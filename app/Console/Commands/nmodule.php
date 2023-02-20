<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\content\modueControllerContent;

class nmodule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nmodule:go {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command used to create new module of view , five route , all views with js';

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
        $moduleName=$this->argument('moduleName');
        $blades =['addEditModal','index','viewModal','tableInfo'];
        $folderPath="app/Http/Controllers/dashboard/";
        $bladePath="resources/views/dashboard/".$moduleName."/";
        if (!file_exists( $folderPath)) 
            mkdir( $folderPath, 0777, true);

        if (!file_exists( $bladePath)) 
            mkdir( $bladePath, 0777, true);


        //create Controller
        $path =$moduleName.'.php' ;
        $file = fopen( $folderPath.$path, "wb") ;
        fwrite($file, modueControllerContent::Controller($moduleName));
        fclose($file);

       //create views
        foreach($blades as $blade ){
            $path =$blade.'.blade'.'.php' ;
            $file = fopen( $bladePath.$path, "wb") ;
            $funcNAme= $blade.'BladeContent';
            fwrite($file, modueControllerContent::{$funcNAme}($moduleName));
            fclose($file);
    
        }
        
        $myfile = fopen("routes/dashboard.php", "a") or die("Unable to open file!");
        $txt = "\n route::get('{$moduleName}','{$moduleName}@index')->name('dashboard.{$moduleName}.index');
        route::post('{$moduleName}/createUpdate','{$moduleName}@createUpdate')->name('dashboard.{$moduleName}.createUpdate');
        route::post('{$moduleName}','{$moduleName}@indexPageing')->name('dashboard.{$moduleName}.indexPageing');
        route::get('{$moduleName}/delete/{id}','{$moduleName}@delete')->name('dashboard.{$moduleName}.delete');
        route::get('{$moduleName}/check/{check}/{id}','{$moduleName}@check')->name('dashboard.{$moduleName}.check');
        route::get('{$moduleName}/getRecord/{id}','{$moduleName}@getRecord')->name('dashboard.{$moduleName}.getRecord');";
        fwrite($myfile, "\n". $txt);
        fclose($myfile);
        $this->info("create module of {$moduleName} successfully by mostafa ramdan");

    }
}

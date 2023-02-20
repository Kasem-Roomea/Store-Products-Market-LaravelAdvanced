<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Categories\CategoriesContrller;
use App\Http\Controllers\products\ExportImportProducts;
use App\Models\sections;
use App\Models\brands;
use App\Models\categories;
use App\Models\products;
use App\Models\images;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use app\Http\Controllers;
route::get("/test",function(){
      // foreach(DB::table('images')->cursor() as $data){
      //       return $date;
      //       return explode($data['/uploads/products/']);
      // }
      // products::where('createdAt','>','2021-12-18 02:53:24')->delete();
      // return  $_SERVER['DOCUMENT_ROOT'].'/../app/Http/Controllers/Apis/Controllers/lang.php' ;
      foreach (DB::table('table_name')->cursor() as $data){
            $product = products::create([
                  'nameAr'=>$data->Name,
                  'ID_'=>$data->ID_,
                  'nameEn'=>$data->Name,
                  'descriptionAr'=>$data->Content,
                  'descriptionEn'=>$data->Content,
                  'sections_id'=>sections::where('nameAr',$data->Section)->first()->id??NULL,
                  'price'=>(double)$data->price_test,
                  'old_price'=>$data->Old_Price,
                  'categories_id'=>categories::where('nameAr',$data->Sub_category)->first()->id??NULL,
                  'brands_id'=>brands::where('nameAr',$data->Brand)->first()->id??NULL,
                  'product_type'=>$data->Product_type,
            ]);
            if($data->_Image_File)
            images::create([
                  'products_id'=>$product->id,
                  'image'=>'/uploads/products/'.$data->_Image_File,
            ]);
            // brands::firstOrCreate([
            //       'nameAr'=>$data->Brand,
            //       'nameEn'=>$data->Brand,
            // ]);
            // $category= categories::where('nameAr',$data->Sub_category)
            //             ->where('id','<',109)
            //             ->where('categories_id','!=',null)
            //             ->first();
            // if(!$category  )
            //       $sub_category=categories::firstOrCreate(
            //             ['nameEn' => $data->Sub_category,
            //             'nameAr' => $data->Sub_category, "isActive"=>1,
            //             'categories_id'=>categories::where('nameAr',$data->Category)->first()->id??NULL]
            //       );
            // else
            // return response()->json(['category'=>$category,'data'=>$data]);
      }
});


route::get("/alaa",function(){
      $count=0;
      foreach(\App\Models\categories::all() as $category){
            $category->update(['orderNum'=>++$count]);
      }
      return  $_SERVER['DOCUMENT_ROOT'].'/../app/Http/Controllers/Apis/Controllers/lang.php' ;
});

route::get('/',function(){
            return view("landingPage");
});


route::Get('chat/{msg}',function ($msg){
    event(new \App\Events\chat($msg));

});
route::view('writemessage','writemessage');
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('socket', 'SocketController@index');
Route::post('sendmessage', 'SocketController@sendMessage');
// Route::get('writemessage', 'SocketController@writemessage');
route::view('socketJquery','socketJquery');
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
// Route::group(array('dashboard' => '{subdomain}.project.dev'), function() {

//     Route::get('foo', function($subdomain) {
//         echo "a";
//     });

//     $subdomain = Route::input('subdomain');

// });

Route::get('/backupdb', function () {
      $DbName             = env('DB_DATABASE');
      $get_all_table_query = "SHOW TABLES ";
      $result = DB::select(DB::raw($get_all_table_query));
  
      $prep = "Tables_in_$DbName";
      foreach ($result as $res){
          $tables[] =  $res->$prep;
      }
  
  
  
      $connect = DB::connection()->getPdo();
  
      $get_all_table_query = "SHOW TABLES";
      $statement = $connect->prepare($get_all_table_query);
      $statement->execute();
      $result = $statement->fetchAll();
  
  
      $output = '';
      foreach(['products','images'] as $table)
      {
          $show_table_query = "SHOW CREATE TABLE " . $table . "";
          $statement = $connect->prepare($show_table_query);
          $statement->execute();
          $show_table_result = $statement->fetchAll();
  
          foreach($show_table_result as $show_table_row)
          {
              $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
          }
          $select_query = "SELECT * FROM " . $table . "";
          $statement = $connect->prepare($select_query);
          $statement->execute();
          $total_row = $statement->rowCount();
  
          for($count=0; $count<$total_row; $count++)
          {
              $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
              $table_column_array = array_keys($single_result);
              $table_value_array = array_values($single_result);
              $output .= "\nINSERT INTO $table (";
              $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
              $output .= '"' . implode('","', $table_value_array) . '");\n';
          }
      }
      $file_name = env("DB_DATABASE") . '-'.now() . '.sql';
      $file_handle = fopen($file_name, 'w+');
      fwrite($file_handle, $output);
      fclose($file_handle);
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . basename($file_name));
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file_name));
      ob_clean();
      flush();
      readfile($file_name);
      unlink($file_name);
  
  });



//Route New Dashboard


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['CheckLogin']
    ],  function() {


    Route::group(
        [
            'namespace'=>'App\Http\Controllers'
        ],  function() {
                //============================================ Section = Categories , الاقسام ==========================================
                Route::resource('Categories', 'Categories\CategoriesContrller');
                Route::resource('Categories_part', 'Categories\Categories_part');
                        //=============================== Section = Categories , تصدير ============================
                        Route::get('categories/export/', 'Categories\CategoriesContrller@export')->name('exportCategories');
                        Route::get('categories_part/export', 'Categories\Categories_part@export')->name('exportCategoriesPart');
                        Route::post('Categories/import', [CategoriesContrller::class, 'import']);


                //============================================priceKm و سعر التوصيل=======================================================
                Route::resource('priceKm', 'priceKm\priceKmController');


                //============================================daysKm و الوقت المتوقع=======================================================
                Route::resource('daysKm', "daysKm\daysKmController");


                //===========================================cityEmirate , الامارات والمدن=======================================================
                Route::resource('cityEmirate', "cityEmirate\cityEmirateController");


                //===========================================  Drivers , السائقسن =======================================================
                Route::resource('drivers', "drivers\driversController");


                //===========================================  Orders , الطلبات =======================================================
                Route::resource('orders', "orders\ordersController");
                route::get('orders/getRecordInfo/{id}', 'orders\ordersController@getRecordInfo')->name('dashboard.orders.getRecordInfo');


                //===========================================  appInfo , معلومات التطبيق =======================================================
                Route::resource('appInfo', "appInfo\appInfoController");


                //===========================================  Ads ,  الأعلانات =======================================================
                Route::resource('ads', "ads\adsController");


                //===========================================  Users ,  المستخدمين =======================================================
                Route::resource('users', "users\usersController");


                //===========================================  notify ,  الأشعارات =======================================================
                Route::resource('notify', "Notify\NotifyController");


                //===========================================  Admin ,  المسؤولين =======================================================
                Route::resource('admins', "admins\adminsController");
                Route::post('permission', "admins\adminsController@updatePermissions")->name('permission');


                //===========================================  products ,  المنتجات =======================================================
                Route::resource('products', "products\productsController");
                // =================  products ,  تصدير واستيراد ======================
                Route::get('Products/export', [ExportImportProducts::class, 'export']);
                Route::post('Products/import', [ExportImportProducts::class, 'import']);


                //===========================================  offers ,  العروض =======================================================
                Route::resource('offers', "offers\offersController");


                //===========================================  reports ,  التقارير =======================================================
                route::get('reports', 'reports@index')->name('dashboard.reports.index');
                route::post('reports/createUpdate', 'reports@createUpdate')->name('dashboard.reports.createUpdate');
                route::post('reports', 'reports@indexPageing')->name('dashboard.reports.indexPageing');
                route::get('reports/delete/{id}', 'reports@delete')->name('dashboard.reports.delete');
                route::get('reports/check/{check}/{id}', 'reports@check')->name('dashboard.reports.check');
                route::get('reports/getRecord/{id}', 'reports@getRecord')->name('dashboard.reports.getRecord');
                route::get('reports/print', 'reports@print')->name('dashboard.reports.print');


                //============================================Controller Basic , المتحكم الاساسي ============================================
                Route::get('/{page}', 'AdminController@index');
        });
    });
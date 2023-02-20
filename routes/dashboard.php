<?php

use App\Http\Controllers\products\ExportImportProducts;
use App\Http\Controllers\products\productsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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




//============================================LOGIN , تحويل الى صفحة تسجيل الدخول ===================================================
Auth::routes(['register' => false]);
Route::group(['middleware'=>'guest'] , function (){
    Route::get('/loginAdmin', function()
    {
        return view('auth.login');
    })->name('adminLogin');
});



route::post('/login','dashboard\authentication@login')->name('dashboard.login');
route::get('/loginX','dashboard\authentication@index')->name('dashboard.login.index');

//============================================Group Localization and Auth , مجموعة الترجمة والتحقق ========================================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['CheckLogin']
    ],  function() {

    //============================================Home Page   وتسجيل الدخول والصفحة الرئيسية====================================================


    route::get('/logout','dashboard\authentication@logout')->name('dashboard.logout');
    route::get('changeLang','general@changeLang')->name('dashboard.changeLang');
    route::get('/loginX','dashboard\authentication@index')->name('dashboard.login.index');


    //============================================ Section = Categories , الاقسام ==========================================
    Route::resource('Categories', 'Categories\CategoriesContrller');
    Route::resource('Categories_part', 'Categories\Categories_part');
            //=============================== Section = Categories , تصدير ============================
                Route::get('categories/export/', 'Categories\CategoriesContrller@export')->name('exportCategories');
                Route::get('categories_part/export', 'Categories\Categories_part@export')->name('exportCategoriesPart');


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
    route::get('orders/getRecordInfo/{id}','orders\ordersController@getRecordInfo')->name('dashboard.orders.getRecordInfo');



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
    route::get('reports','reports@index')->name('dashboard.reports.index');
    route::post('reports/createUpdate','reports@createUpdate')->name('dashboard.reports.createUpdate');
    route::post('reports','reports@indexPageing')->name('dashboard.reports.indexPageing');
    route::get('reports/delete/{id}','reports@delete')->name('dashboard.reports.delete');
    route::get('reports/check/{check}/{id}','reports@check')->name('dashboard.reports.check');
    route::get('reports/getRecord/{id}','reports@getRecord')->name('dashboard.reports.getRecord');
    route::get('reports/print','reports@print')->name('dashboard.reports.print');



    //============================================Controller Basic , المتحكم الاساسي ============================================
    Route::get('/{page}', 'AdminController@index');
});
//============================================ End Group Localization and Auth==========================================

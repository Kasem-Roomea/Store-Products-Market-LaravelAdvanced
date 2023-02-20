<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\orders;

class reports extends Controller
{

      public static function index()
      {
        try {
            $records = orders::all()->where("online_payment_confirm", 1)->where('status', 'finished');

            $totalPrice = $records->sum("totalPrice");
            $productPrice = $records->sum("products_price");
            $deliveryPrice = $records->sum("deliveryPrice");
            $storeFees = $records->sum("storeFees");
            $driverFees = $records->sum("driverFees");
            $totalDistance = $records->sum("distance");

            $totalPages = ceil($records->count() / config('helperDashboard.itemPerPage'));
            $currentPage = 1;
            $records = $records->forpage(1, config('helperDashboard.itemPerPage'));
            return view('reports.index', compact('totalDistance', "records", "totalPages", 'currentPage', 'totalPrice', 'productPrice', 'deliveryPrice', 'storeFees', 'driverFees'));
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
      }

      public static function indexPageing(Request $request)
      {
            $sort=$request->sortType??'sortBy';
            $records= orders::all()->$sort($request->sortBy??"id",)->where("online_payment_confirm",1)->where('status','finished');
            if($request->search){
                  $search= $request->search;
                  $records= $records->filter(function($item) use ($search) {
                        if(stripos($item['statusAr'],$search) !== false ||
                              stripos($item['user']['name']??'',$search) !== false ||
                              stripos($item['driver']['name']??'',$search) !== false  )
                              return true;
                        ;
                  });
            }
      //     $records=$records->where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") );
          if($request->stores_id!=null){
                  $records= $records->where("stores_id",$request->stores_id);
          }
          if($request->drivers_id !=null){
                  $records= $records->where("drivers_id",$request->drivers_id);
          }
          if($request->users_id !=null ){
                  $records= $records->where("users_id",$request->users_id);
          }
          $totalPrice= $records->sum("totalPrice");
          $productPrice= $records->sum("products_price");
          $deliveryPrice= $records->sum("deliveryPrice");
          $storeFees= $records->sum("storeFees");
          $driverFees= $records->sum("driverFees");
          $totalDistance= $records->sum("distance");

          $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
          $currentPage= $request->currentPage;
          $records=$records->forpage($request->currentPage??1,config('helperDashboard.itemPerPage'));
          $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
          $tableInfo= (string) view('dashboard.reports.tableInfo',compact('records'));
          return [
                'paging'=>$paging,
                'tableInfo'=>$tableInfo,
                "totalPrice"=>$totalPrice,
                "productPrice"=>$productPrice,
                "deliveryPrice"=>$deliveryPrice,
                "storeFees"=>$storeFees,
                "driverFees"=>$driverFees,
                "totalDistance"=>$totalDistance,
                "request"=>$request,
          ];
      }


      public static function print(Request $request)
      {
            // dd($request);
            $sort=$request->sortType??'sortBy';
            $records= orders::all()->$sort($request->sortBy??"id",);
            $records=$records->where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") );

            if($request->stores_id!=null){
                  $records= $records->where("stores_id",$request->stores_id);
            }
            if($request->drivers_id !=null){
                  $records= $records->where("drivers_id",$request->drivers_id);
            }
            if($request->users_id !=null ){
                  $records= $records->where("users_id",$request->users_id);
            }
            $totalPrice= $records->sum("totalPrice");
            $productPrice= $records->sum("products_price");
            $deliveryPrice= $records->sum("deliveryPrice");
            $storeFees= $records->sum("storeFees");
            $driverFees= $records->sum("driverFees");

            return view('reports.indexPrint',compact("records",'totalPrice','productPrice','deliveryPrice','storeFees','driverFees'));
      }

}

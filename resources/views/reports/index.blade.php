@extends ('layouts.master')
@section('title', 'التقارير')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># التقارير</h2>
        </div>

        <form class="mb-4" id="getOptions">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-row">
            <div class="m-2">
              <input type="search" class="form-control" placeholder="بحث" name="search">
            </div>
            <div class="m-2">
              <select class="form-control"  name="sortBy">
                <option selected disabled>الترتيب علي حسب </option>
                <option value="statusAr"  >الحالة</option>
                <option value="createdAt"> تاريخ الانشاء</option>
              </select>
            </div>
            <div class="m-2">
              <select class="form-control"  name="sortType">
                <option selected disabled>  نوع الترتيب </option>
                <option value="sortBy">تصاعدي</option>
                <option value="sortByDesc">تنازلي</option>
              </select>
            </div>
            <div class="flex-grow-1"></div>
              <div class="m-2">
              </div>
            <div class="row">
            <div class="col-4">
              <div class="form-group " >
                  <label for="users_id" class="col-form-label ">  أدخل المستخدم:</label>
                  <input type="search" class="form-control" name="searchFor" data-model="users" data-col="name" >
                  <select  class="form-control" name="users_id" onchange="getRecords(1)">
                  </select>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group " >
                  <label for="drivers_id" class="col-form-label">   أدخل السائق:</label>
                  <input type="search" class="form-control" name="searchFor" data-model="drivers" data-col="name" >
                  <select  class="form-control" name="drivers_id" onchange="getRecords(1)">
                  </select>
              </div>
            </div>
            <div class=" col-4">
              <div class="form-group " >
                  <label for="stores_id" class="col-form-label">  ادخل المتجر:</label>
                  <input type="search" class="form-control" name="searchFor" data-model="stores" data-col="name" >
                  <select  class="form-control" name="stores_id" onchange="getRecords(1)">
                  </select>
              </div>
            </div>
              <div class="col-md-5">
                <div class="m-2">
                    <label for="from">  :من </label>
                    <input type="date" name="from" class="form-control" onchange="getRecords(1)"  value="{{date('Y')-2}}{{date('-m-d')}}"/>
                </div>
              </div>
              <div class="col-md-5">
                <div class="m-2">
                    <label for="to"> :الى </label>
                    <input type="date" name="to" class="form-control" onchange="getRecords(1)" value="{{date('Y-m-d')}}"/>
                </div>
              </div>
              <div class="col-md-12">
                <div class="m-2">
                    <button class="btn btn-warning print" onClick="event.preventDefault();print();" data-toggle="modal" data-target="#addEdit-new-modal"> طباعة <i class='ml-2 fas fa-print'></i>   </button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div class="row mb-4">
          <div class="col-md-2 col-sm-6">
            <div class="card  bg-primary mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                اجمالي سعر المنتجات
                <i class="fas fa-users mr-2 fa-2x "></i>
              </div>
              <div class="card-body">
                <h5 class="card-title productPrice">{{$productPrice}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card  bg-success  mb-3" style="max-width: 18rem;height:90%" >
              <div class="card-header align-items-center font-weight-bold">
                اجمالي اسعار التوصيل
                <i class="fas fa-road"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title deliveryPrice">{{$deliveryPrice}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card bg-danger  mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                أجمالي الفواتير
                <i class="fas fa-money-bill-alt"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title totalPrice">{{$totalPrice}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card bg-info  mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                 عمولة السائقين
                <i class="fas fa-car-alt  mr-2 fa-2x"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title driverFees">{{$driverFees}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card bg-secondary  mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                 عمولة المتاجر
                <i class="fas fa-store-alt  mr-2 fa-2x"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title storeFees">{{$storeFees}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card bg-dark  mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                 أجمالي العمولة
                <i class="fas fa-coins  mr-2 fa-2x"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title totalFees">{{$storeFees + $driverFees}}   </h5>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="card bg-danger  mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                أجمالي المسافة
                <i class="fas fa-car"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title totalDistance">{{$totalDistance}} KM   </h5>
              </div>
            </div>
          </div>

        <div class="flex-grow-1"></div>
          <div class="m-2">
          </div>
        </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('reports.tableInfo')
          </table>
        </div>

        <!-- pagination -->
        <div class="paging">
          @include('reportAddFile.paging')
        </div>
        <!-- end pagination -->
    </div>
      <!-- Large modal -->
      @include('reports.viewModal')
      <!-- end Large modal -->

      <!-- addEdit new modal -->
      <!-- end add user modal -->
        @include('reports.orderInfoModal')

      <!-- end main content -->
</div>
@push('script')

<script>
  $("body").on("click",".get-record",function(){
    let id = $(this).parents('tr').data("id");
    $.ajax({
      url: "orders/getRecord/"+id,
      type: 'GET',
      processData: false,
      contentType: false,
      beforeSend: function(){
        $(".view-modal .loading-container").toggleClass("d-none d-flix");
      },
      success: function(record) {
        $(".view-modal .loading-container").toggleClass("d-none d-flix");
        for (var k in record) {
          if (record.hasOwnProperty(k)) {
            if(k.includes('image')  ){
              $(".carousel-item ."+k).attr("src","{{url('/')}}"+record[k]);
            }else{
              $(".view-modal ."+k).html(record[k])
            }
          }
        }
        $(".view-modal .userName").html(record.user.name);
        $(".view-modal .userPhone").html(record.user.phone);
        if(record.driver){
          $(".view-modal .driverName").html(record.driver.name);
          $(".view-modal .driverPhone").html(record.driver.phone);
        }
        if(record.bill){
          $(".view-modal .deliveryPrice").html(record.bill.deliveryPrice.toFixed(2));
          $(".view-modal .products_price").html(record.bill.products_price.toFixed(2));
          $(".view-modal .fees").html(record.bill.fees);
          $(".view-modal .totalPrice").html(record.bill.totalPrice.toFixed(2));
        }
        $(".view-modal .storeName").html(record.store.name);
        $(".view-modal .storePhone").html(record.store.phone);
        $(".view-modal .map_link").find("a").attr("href",record.mapLink);
      }
    });
  });
  $("body").on("click",".orderInfo",function(){
        let id = $(this).parents('tr').data("id");
        $.ajax({
          url: "orders/getRecordInfo/"+id,
          type: 'GET',
          processData: false,
          contentType: false,
          beforeSend: function(){
            $(".orderInfo-modal .loading-container").toggleClass("d-none d-flix");
          },
          success: function(response) {
            $(".orderInfo-modal .loading-container").toggleClass("d-none d-flix");
            $("table.orderTableInfo").html(response);
          }
        });
  });
  function print(){
    window.location.href = "{{Request::segment(2)}}/print?to="+$("input[name='to']").val()+"&from="+$("input[name='from']").val();
  }

</script>
@endpush
@endsection

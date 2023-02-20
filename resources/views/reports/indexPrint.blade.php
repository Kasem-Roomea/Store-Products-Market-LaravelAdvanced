@extends ('dashboard.layouts.master')
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
            <div class="row mb-4">
              <div class="col-md-5">
                  <div class="m-2">
                      <label for="from" class="list-lang" ar="من" en="from"> : </label>
                      <input type="date" name="from" class="form-control" onchange="getRecords(1)"  value="{{Carbon\Carbon::parse('now')->subMonth(1)->format('Y-m-d')}}"/>
                  </div>
                </div>
              <div class="col-md-5">
                  <div class="m-2">
                      <label for="to"  class="list-lang" ar="إلي" en="to"> : </label>
                      <input type="date" name="to" class="form-control" onchange="getRecords(1)" value="{{date('Y-m-d')}}"/>
                  </div>
                </div>
            </div>
        </form>
        <div class="row mb-4">
          <div class="col-md-2 col-sm-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                <span class="list-lang" ar="اجمالي سعر المنتجات"en="The total price of the products"></span> 
                <i class="fas fa-users mr-2 fa-2x "></i>
              </div>
              <div class="card-body">
                <h5 class="card-title productPrice">{{$productPrice}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card text-white bg-success  mb-3" style="max-width: 18rem;height:90%" >
              <div class="card-header align-items-center font-weight-bold">
                <span class="list-lang" ar="اجمالي اسعار التوصيل"en="Total delivery prices"></span> 
                <i class="fas fa-road"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title deliveryPrice">{{$deliveryPrice}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card text-white bg-danger  mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                <span class="list-lang" ar="أجمالي الفواتير"en="Total bills"></span> 
                <i class="fas fa-money-bill-alt"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title totalPrice">{{$totalPrice}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card text-white bg-info  mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">                  
                 <span class="list-lang" ar="عمولة السائقين"en="drivers commission"></span> 
                <i class="fas fa-car-alt  mr-2 fa-2x"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title driverFees">{{$driverFees}}   </h5>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6">
            <div class="card text-white bg-secondary  mb-3" style="max-width: 18rem;height:90%">
              <div class="card-header align-items-center font-weight-bold">
                  
                 <span class="list-lang" ar="عمولة المتاجر"en="store commission"></span> 
                <i class="fas fa-store-alt  mr-2 fa-2x"></i>
              </div>
              <div class="card-body">
              <h5 class="card-title storeFees">{{$storeFees}}   </h5>
              </div>
            </div>
          </div>
        </div>

        <div class="flex-grow-1"></div>
          <div class="m-2">
          </div>
        </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('reports.tableInfoPrint')
          </table>
        </div>

        <!-- pagination -->
        <!-- end pagination --> 
    </div>
      <!-- Large modal -->

      <!-- end main content -->
</div>
@include('dashboard.layouts.end')
<script>
  $(".main-sidebar").addClass("d-none");
  $(document).ready(function() { 
    $(".loading-container").toggleClass("d-none");
    window.print();
  });

</script> 

@endsection

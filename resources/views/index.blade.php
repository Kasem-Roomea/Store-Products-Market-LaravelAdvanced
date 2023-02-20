@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')

@endsection
@section('content')

    <div class="content" >
        <div  id="alert">
        </div>
        <div class="d-flex align-items-center mb-4">
            <h2 class="m-0"> الأحصائيات</h2>
        </div>
        <form class="mb-4" id="getOptions">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-row">
                <div class="m-2">
                    <label> <span class="from"> من </span>: </label>
                    <input type="date" name="fromDate" class="form-control" placeholder="Search">
                </div>
                <div class="m-2">
                    <label> <span class="to"> إلي</span>  : </label>
                    <input type="date" name="toDate" class="form-control" placeholder="Search">
                </div>
                <div  style="margin-top:40px">
                    <a class="btn btn-primary text-white getByRang mt" > <span class="send"> ارسال</span></a>
                </div>
            </div>
        </form>
    </div>
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class=" align-items-center font-weight-bold">
                    <span class="total-users" > أجمالي المستخدمين</span>
                    <i class="fas fa-users mr-2 fa-2x "></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title usersCount">{{$usersCount}}   </h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-success  mb-3" style="max-width: 18rem;">
                <div class="align-items-center font-weight-bold">
                    <span class="total-drivers"> أجمالي السائقين</span>
                    <i class="fas fa-car  mr-2 fa-2x"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title driversCount">{{$driversCount}}   </h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-danger  mb-3" style="max-width: 18rem;">
                <div class=" align-items-center font-weight-bold">
                    <span class="total-stores"> أجمالي المتاجر</span>
                    <i class="fas fa-store-alt  mr-2 fa-2x"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title storesCount">{{$storesCount}}   </h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-info  mb-3" style="max-width: 18rem;">
                <div class=" align-items-center font-weight-bold">
                    <span class="total-orders"> أجمالي الطلبات</span>
                    <i class="fas fa-luggage-cart  mr-2 fa-2x"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title ordersCount">{{$ordersCount}}   </h5>
                </div>
            </div>
        </div>
    </div>




    <div class="row" style="margin-bottom: 20px">
        <div class="col-sm-12">
            <canvas id="myChart" height="100px"></canvas></div>
    </div>




    <!-- Container closed -->
@endsection



@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">


        const NUMBER_CFG0 = {January: {!!$users1!!}, February: {!!$users2!!} ,March: {!!$users3!!},April: {!!$users4!!}, may: {!!$users5!!} , June: {!!$users6!!}, July: {!!$users7!!}, August: {!!$users8!!}, September: {!!$users9!!} ,October: {!!$users10!!}, November: {!!$users11!!} ,December: {!!$users12!!}};
        const NUMBER_CFG1 = {January: {!!$drivers1!!}, February: {!!$drivers2!!} ,March: {!!$drivers3!!},April: {!!$drivers4!!}, may: {!!$drivers5!!} , June: {!!$drivers6!!}, July: {!!$drivers7!!}, August: {!!$drivers8!!}, September: {!!$drivers9!!} ,October: {!!$drivers10!!}, November: {!!$drivers11!!} ,December: {!!$drivers12!!}};
        const NUMBER_CFG2 = {January: {!!$stores1!!}, February: {!!$stores2!!} ,March: {!!$stores3!!},April: {!!$stores4!!}, may: {!!$stores5!!} , June: {!!$stores6!!}, July: {!!$stores7!!}, August: {!!$stores8!!}, September: {!!$stores9!!} ,October: {!!$stores10!!}, November: {!!$stores11!!} ,December: {!!$stores12!!}};
        const NUMBER_CFG3 = {January: {!!$orders1!!}, February: {!!$orders2!!} ,March: {!!$orders3!!},April: {!!$orders4!!}, may: {!!$orders5!!} , June: {!!$orders6!!}, July: {!!$orders7!!}, August: {!!$orders8!!}, September: {!!$orders9!!} ,October: {!!$orders10!!}, November: {!!$orders11!!} ,December: {!!$orders12!!}};

        const data = {
            datasets: [
                {
                    label: 'Order',
                    backgroundColor: '#00b9ff',
                    borderColor: '#00b9ff',
                    data: NUMBER_CFG3,
                },

                {
                    label: 'Stores',
                    backgroundColor: '#ee335e',
                    borderColor: '#ee335e',
                    data: NUMBER_CFG2,
                },

                {
                    label: 'Drivers',
                    backgroundColor: '#22c03c',
                    borderColor: '#22c03c',
                    data: NUMBER_CFG1,
                },

                {
                    label: 'Users',
                    backgroundColor: '#0162e8',
                    borderColor: '#0162e8',
                    data: NUMBER_CFG0,
                },


            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: (ctx) => 'أحصائيات المتجر '
                    },
                    tooltip: {
                        mode: 'index'
                    },
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        stacked: false,
                        min:0,
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

    </script>
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--Internal  Flot js-->
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
    <script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
    <script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
    <!--Internal Apexchart js-->
    <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
    <!-- Internal Map -->
    <script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
    <!--Internal  index js -->
    <script src="{{URL::asset('assets/js/index.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
@endsection


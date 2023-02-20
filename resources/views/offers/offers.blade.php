@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

@endsection
@section('title')
       العروض
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">العروض</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate offers -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    <!-- end action validate offers -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-primary btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                أضافة عرض جديد
                                            </button>
                                        </div>


                                    </div>
                                <br><br>
                                <!-- start table -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='10'>
                                            <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th> نوع العرض </th>
                                                <th >المنتج</th>
                                                <th>تاريخ البداية</th>
                                                <th >تاريخ النهاية</th>
                                                <th>الحالة</th>
                                                <th>العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($offers as $x)
                                                <?php $i++ ; ?>
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>عرض منتج</td>
                                                    <td>
                                                        @if (App::isLocale('en'))
                                                            {{$x->products->nameEn??''}}
                                                        @else
                                                            {{$x->products->nameAr??''}}
                                                        @endif
                                                    </td>
                                                    <td>{{$x->startAt}}</td>
                                                    <td>{{$x->endAt}}</td>
                                                    @if($x->isActive == 1)
                                                        <td class="text-success">مفعل</td>
                                                    @else
                                                        <td class="text-danger">معطل</td>
                                                    @endif
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#edit{{ $x->id }}"
                                                                title="تعديل" id="editor"><i class="fa fa-edit"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#delete{{ $x->id }}"
                                                                title="حذف"><i
                                                                class="fa fa-trash"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#details{{ $x->id }}"
                                                                title="التفاصيل"><i class="fa fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- start edit_modal_offers-->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل العرض
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ route('offers.update', 'test') }}" method="POST" >
                                                                    {{ method_field('patch') }}
                                                                    @csrf
                                                                    <div class="row">

                                                                        <div class="col-12">
                                                                            <label for="discount" class="mr-sm-2">نسبة الخصم</label>
                                                                            <input id="discount" type="number" name="discount" class="form-control" value="{{$x->discount}}" required >
                                                                            <input id="id" type="hidden" name="id" class="form-control" value="{{ $x->id }}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="startAt" class="mr-sm-2">بداية العرض</label>
                                                                            <input id="startAt" type="date" name="startAt" class="form-control" value="{{$x->startAt}}" required>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="endAt" class="mr-sm-2">نهاية العرض</label>
                                                                            <input id="endAt" type="date" name="endAt" class="form-control" value="{{$x->endAt}}" required>
                                                                        </div>




                                                                        <div class="col-12" >
                                                                            <label for="typeOffers" class="mr-sm-2">نوع العرض </label>
                                                                            <select id='typeOffers' type="text" class="form-control" name="typeOffers">
                                                                                <option value="product">منتج</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-12" >
                                                                            <label for="products_id" class="mr-sm-2">المنتج </label>
                                                                            <select id='products_id'  class="form-control" name="products_id">

                                                                                <option value="{{$x->products->id}}" >
                                                                                    @if (App::isLocale('en'))
                                                                                        {{$x->products->nameEn}}
                                                                                    @else
                                                                                        {{$x->products->nameAr}}
                                                                                    @endif
                                                                                </option>
                                                                                @foreach($products as $p)
                                                                                    <option value="{{$p->id}}" >
                                                                                        @if (App::isLocale('en'))
                                                                                            {{$p->nameEn}}
                                                                                        @else
                                                                                            {{$p->nameAr}}
                                                                                        @endif
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="isActive" class="mr-sm-2">الحالة </label>
                                                                            <select id="isActive" name="isActive" class="form-control" required>
                                                                                @if($x->isActive==0)
                                                                                    <option value=0 selected >معطل</option>
                                                                                @else
                                                                                    <option value=1 selected>مفعل</option>
                                                                                @endif
                                                                                <option value=0>معطل</option>
                                                                                <option value=1>مفعل</option>
                                                                            </select>
                                                                        </div>
                                                                        <br>

                                                                        <br>
                                                                        <br>
                                                                    </div>

                                                                    <br><br>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">اغلاق</button>
                                                                        <button type="submit"
                                                                                class="btn btn-info">تعديل البيانات</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end edit_modal_offers-->

                                                <!-- start delete_modal_offers -->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف العرض
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('offers.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد حذف العرض؟
                                                                    <input id="id" type="hidden" name="id" class="form-control"
                                                                           value="{{ $x->id }}">
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">اغلاق</button>
                                                                        <button type="submit"
                                                                                class="btn btn-danger">حذف</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end  delete_modal_offers -->

                                                <!-- start details_modal_offers-->
                                                <div class="modal fade" id="details{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تفاصيل العرض
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="card" style="width:100%;">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  نوع العرض:  </label><span>منتج</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  المنتج:  </label><span>
                                                                                 @if (App::isLocale('en'))
                                                                                    {{$x->products->nameEn??''}}
                                                                                @else
                                                                                    {{$x->products->nameAr??''}}
                                                                                @endif
                                                                            </span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  نسبة الحسم:  </label><span>{{$x->discount}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    تاريخ بداية العرض :  </label><span> {{$x->startAt}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    تاريخ نهاية العرض :  </label><span> {{$x->endAt}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    تاريخ الأنشاء :  </label><span> {{$x->created_at}}</span></li>
                                                                    </ul>
                                                                </div>

                                                             </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--end  details_modal_offers -->


                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end table -->



                            </div>
                        </div>

                        <!-- start add_modal_products-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                            أضافة عرض جديد
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('offers.store') }}" method="POST" >
                                            @csrf
                                            <div class="row">

                                                <div class="col-12">
                                                    <label for="discount" class="mr-sm-2">نسبة الخصم</label>
                                                    <input id="discount" type="number" name="discount" class="form-control" required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="startAt" class="mr-sm-2">بداية العرض</label>
                                                    <input id="startAt" type="date" name="startAt" class="form-control" required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="endAt" class="mr-sm-2">نهاية العرض</label>
                                                    <input id="endAt" type="date" name="endAt" class="form-control" required>
                                                </div>




                                                <div class="col-12" >
                                                    <label for="typeOffers" class="mr-sm-2">نوع العرض </label>
                                                    <select id='typeOffers' type="text" class="form-control" name="typeOffers">
                                                        <option value="">أختر نوع العرض</option>
                                                        <option value="product">منتج</option>
                                                    </select>
                                                </div>

                                                <div class="col-12" >
                                                    <label for="products_id" class="mr-sm-2">المنتج </label>
                                                    <select id='products_id'  class="form-control" name="products_id">
                                                        @foreach($products as $p)
                                                            <option value="{{$p->id}}" >
                                                            @if (App::isLocale('en'))
                                                                {{$p->nameEn}}
                                                            @else
                                                                {{$p->nameAr}}
                                                            @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <br>

                                                <br>
                                                <br>
                                            </div>
                                            <br><br>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">أغلاق</button>
                                                <button type="submit" class="btn btn-success">أضافة</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end add_modal_products -->

                    </div>





@endsection
@section('js')

    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->

    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>
    <script>
        $(document).ready(function() {
            $('#offers_start_date').hide();
            $('#offers_end_date').hide();
            $('#offers_discount').hide();

            $('input[type="checkbox"]').click(function() {
                if ($(this).is(":checked"))
                {
                    $('#offers_start_date').show();
                    $('#offers_end_date').show();
                    $('#offers_discount').show();
                }
                else
                {
                    $('#offers_start_date').hide();
                    $('#offers_end_date').hide();
                    $('#offers_discount').hide();
                }
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('.offers_start_date').hide();
            $('.offers_end_date').hide();
            $('.offers_discount').hide();

            $('input[type="checkbox"]').click(function() {
                if ($(this).is(":checked"))
                {
                    $('.offers_start_date').show();
                    $('.offers_end_date').show();
                    $('.offers_discount').show();
                }
                else
                {
                    $('.offers_start_date').hide();
                    $('.offers_end_date').hide();
                    $('.offers_discount').hide();
                }
            });
        });

    </script>



@endsection

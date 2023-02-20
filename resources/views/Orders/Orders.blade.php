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
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
       الطلبات
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الطلبات</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate order  -->
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
    <!-- end action validate order -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-danger btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                    حذف جميع الطلبات
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
                                                <th >#</th>
                                                <th >كود الطلب</th>
                                                <th > السائق</th>
                                                <th > الحالة</th>
                                                <th > وقت الأنشاء</th>
                                                <th >تفاصيل</th>
                                                <th >العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($orders as $x)
                                                <?php $i++ ; ?>
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>{{$x->code}}</td>
                                                    <td>
                                                        @if($x->drivers_id==Null)
                                                            لا يوجد سائق
                                                        @else
                                                            {{$x->nameDriverOrders->name}}
                                                        @endif
                                                    </td>
                                                    <td>{{$x->status}}</td>
                                                    <td>{{$x->createdAt}}</td>
                                                    <td>
                                                        <button class="btn-sm btn btn-success orderInfo mb-1" data-toggle="modal" data-target="#orderInfo-modal"><i class="fas fa-shopping-cart"></i></button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#edit{{ $x->id }}"
                                                                title="تعديل"><i class="fa fa-edit"></i>
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




                                                <!-- start edit_modal_orders -->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل  حالة الطلب
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ url('orders/update') }}" method="POST" enctype="multipart/form-data">
                                                                    {{method_field('patch')}}
                                                                    @csrf
                                                                    <div class="row">
                                                                        <input id="id" type="hidden" name="id" class="form-control"
                                                                               value="{{ $x->id }}">
                                                                        <div class="col-12">
                                                                            <label for="status"
                                                                                   class="mr-sm-2">حالة الطلب </label>
                                                                            <select id="status" name="status"
                                                                                    class="form-control"
                                                                                    required>
                                                                                <option value='{{$x->status}}'>{{$x->status}}</option>
                                                                                <option value='waiting'>في الأنتظار</option>
                                                                                <option value='accept'>قبول</option>
                                                                                <option value='progressing'>جاري التنفيذ</option>
                                                                                <option value='finished'>تم الانتهاء</option>
                                                                                <option value='cancel'>الغاء</option>
                                                                                <option value='faildPayment'>فشل الطلب</option>
                                                                                <option value='returned'>تم الأرجاع</option>
                                                                                <option value='scheduled'>الطلب في الطريق </option>
                                                                            </select>
                                                                        </div>

                                                                        <br><br>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                    data-dismiss="modal">اغلاق</button>
                                                                            <button type="submit"
                                                                                    class="btn btn-info">تعديل البيانات</button>
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end edit_modal_orders -->

                                                <!-- start delete_modal_orders -->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف الطلب
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('orders.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد حذف الطلب؟
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
                                                <!--end  delete_modal_orders -->


                                                <!-- start details_modal_order-->
                                                <div class="modal fade" id="details{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تفاصيل الطلب
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card" style="width:100%;">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  الكود :  </label><span> {{$x->code}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    وقت التوصيل:  </label><span> {{$x->status}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   طريقة الدفع:  </label> <span>{{$x->paymentMethod}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  سعر المنتجات:  </label> <span></span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  سعر التوصيل:  </label> <span>{{$x->deliveryPrice}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  وقت التوصيل:  </label> <span>{{$x->deliveryTime}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   الرسوم:  </label> <span></span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   الأجمالي:  </label> <span></span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   اسم الزبون:  </label> <span>{{$x->nameUserOrder->name}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   رقم الزبون:  </label> <span>{{$x->nameUserOrder->phone}}</span></li>

                                                                        @if($x->drivers_id==Null)
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   اسم السائق:  </label> <span>لا يوجد سائق محدد</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    رقم السائق:  </label> <span>لا يوجد رقم محدد</span></li>
                                                                        @else
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   اسم السائق:  </label> <span>{{$x->nameDriverOrders->name}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    رقم السائق:  </label> <span>{{$x->nameDriverOrders->phone}}</span></li>
                                                                        @endif

                                                                        @if($x->stores_id==Null)
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    اسم التجر:  </label> <span>لا يوجد متجر محدد</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">     رقم المتجر:  </label> <span>لا يوجد رقم محدد</span></li>
                                                                        @else
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    اسم التجر:  </label> <span>{{$x->nameStoreOrder->name}}</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">     رقم المتجر:  </label> <span> {{$x->nameStoreOrder->phone}}</span></li>
                                                                        @endif


                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">     تاريخ الأنشاء:  </label> <span>{{$x->createdAt}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    عنوان الطلب :  </label> <span></span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end  details_modal_order-->


                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                                <!-- end table -->

                            </div>
                        </div>

                        <!-- start delete all Order -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                              حذف جميع الطلبات
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('orders.destroy', 'test') }}" method="post">
                                            {{ method_field('Delete') }}
                                            @csrf
                                            هل تريد حذف جميع الطلبات؟
                                            <input id="id" type="hidden" name="id" class="form-control"
                                                   value="all">
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
                        <!-- end delete all Order -->

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

@endsection

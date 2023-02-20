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

    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
      معلومات التطبيق
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"> معلومات التطبيق</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate app info  -->
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
    <!-- end action validate app info -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-success btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                 تعديل المعلومات
                                            </button>
                                        </div>


                                    </div>
                                <br><br>
                                <!-- start view info -->
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <div class="card" style="width:100%;">
                                            @foreach($info as $x)
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    رسالة الترحيب:  </label> <span>{{$x->welcomeAr}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   رسالة الترحيب بالأنكليزي:  </label> <span>{{$x->welcomeEn}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   حول التطبيق بالعربي:  </label> <span>{{$x->aboutAr}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   حول التطبيق بالأنكليزي:  </label> <span>{{$x->aboutEn}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   سياسة الأستخدام بالعربي:  </label> <span>{{$x->policyAr}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   سياسة الأستخدام بالأنكليزي:  </label> <span>{{$x->policyEn}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    رسوم المتاجر:  </label> <span>{{$x->storeFees}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    رسوم السائقين:  </label> <span>{{$x->driverFees}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    النطاق بالكيلو متر:  </label> <span>{{$x->pricePerKM }}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      سعر التوصيل لكل 20 كيلو متر:  </label> <span>{{$x->pricePer20Km}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      سعر النقطة:  </label> <span>{{$x->priceOfPoint }}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      أقل عدد نقاط يمكن إستبدالها:  </label> <span>{{$x->maxStorePoints}}</span></li>
                                                <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">       رسوم أستخدام الكاش:  </label> <span>{{$x->cashFees}}</span></li>
                                            </ul>
                                                @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- end view info  -->

                            </div>
                        </div>

                        <!-- start edit_modal_app info -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                              تعديل معلومات التطبيق
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ url('appInfo/update') }}" method="POST">
                                            @csrf
                                            {{ method_field('PATCH') }}
                                            <div class="row">


                                                <div class="col-12">
                                                    <label for="welcomeEn"
                                                           class="mr-sm-2"> رسالة الترحيب بالأنكليزية</label>
                                                    <textarea id="welcomeEn"  name="welcomeEn"
                                                           class="form-control" required >{{$x->welcomeEn}}</textarea>

                                                    <input id="id" type="hidden" name="id"
                                                           class="form-control"
                                                           required value="{{$x->id}}">
                                                </div>


                                                <div class="col-12">
                                                    <label for="welcomeAr"
                                                           class="mr-sm-2"> رسالة الترحيب بالعربية</label>
                                                    <textarea id="welcomeAr"  name="welcomeAr"
                                                           class="form-control"
                                                              required >{{$x->welcomeAr}}</textarea>
                                                </div>

                                                <div class="col-12">
                                                    <label for="aboutEn"
                                                           class="mr-sm-2">حول التطبيق بالانكليزي</label>
                                                    <textarea id="aboutEn" type="text" name="aboutEn"
                                                           class="form-control"
                                                              required >{{$x->aboutEn}}</textarea>
                                                </div>

                                                <div class="col-12">
                                                    <label for="aboutAr"
                                                           class="mr-sm-2">حول التطبيق بالعربية</label>
                                                    <textarea id="aboutAr" type="text" name="aboutAr"
                                                           class="form-control"
                                                              required>{{$x->aboutAr}}</textarea>
                                                </div>

                                                <div class="col-12">
                                                    <label for="policyEn"
                                                           class="mr-sm-2">سياسة الخصوصية بالأنكليزي</label>
                                                    <textarea id="policyEn" type="text" name="policyEn"
                                                           class="form-control"
                                                              required>{{$x->policyEn}}</textarea>
                                                </div>


                                                <div class="col-12">
                                                    <label for="policyAr"
                                                           class="mr-sm-2">ساسة التطبيق بالعربية</label>
                                                    <textarea id="policyAr" type="text" name="policyAr"
                                                           class="form-control"
                                                              required>{{$x->policyAr}}</textarea>
                                                </div>


                                                <div class="col-12">
                                                    <label for="storeFees"
                                                           class="mr-sm-2">رسوم المتاجر</label>
                                                    <input id="storeFees" type="number" name="storeFees"
                                                           class="form-control"
                                                           required value="{{$x->storeFees}}">
                                                </div>

                                                <div class="col-12">
                                                    <label for="driverFees"
                                                           class="mr-sm-2">رسوم السائقين</label>
                                                    <input id="driverFees" type="number" name="driverFees"
                                                           class="form-control"
                                                           required value="{{$x->driverFees}}">
                                                </div>

                                                <div class="col-12">
                                                    <label for="pricePerKM"
                                                           class="mr-sm-2">النطاق بالكيلو متر</label>
                                                    <input id="pricePerKM" type="number" name="pricePerKM"
                                                           class="form-control"
                                                           required value="{{$x->pricePerKM}}">
                                                </div>


                                                <div class="col-12">
                                                    <label for="pricePer20Km"
                                                           class="mr-sm-2"> سعر التوصيل لكل 20 كيلو متر</label>
                                                    <input id="pricePer20Km" type="number" name="pricePer20Km"
                                                           class="form-control"
                                                           required value="{{$x->pricePer20Km}}">
                                                </div>


                                                <div class="col-12">
                                                    <label for="priceOfPoint"
                                                           class="mr-sm-2">  سعر النقطة</label>
                                                    <input id="priceOfPoint" type="number" name="priceOfPoint"
                                                           class="form-control"
                                                           required value="{{$x->priceOfPoint}}">
                                                </div>

                                                <div class="col-12">
                                                    <label for="maxStorePoints"
                                                           class="mr-sm-2"> أقل عدد نقاط يمكن إستبداله</label>
                                                    <input id="maxStorePoints" type="number" name="maxStorePoints"
                                                           class="form-control"
                                                           required value="{{$x->maxStorePoints}}">
                                                </div>


                                                <div class="col-12">
                                                    <label for="cashFees"
                                                           class="mr-sm-2"> رسوم أستخدام الكاش</label>
                                                    <input id="cashFees" type="number" name="cashFees"
                                                           class="form-control"
                                                           required value="{{$x->cashFees}}">
                                                </div>

                                            </div>

                                            <br><br>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">أغلاق</button>
                                                <button type="submit" class="btn btn-success">تعديل البيانات</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end  edit_modal_app info-->

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

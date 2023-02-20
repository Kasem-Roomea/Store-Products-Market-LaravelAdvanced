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
       المستخدمين
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المستخدمين</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate users  -->
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
    <!-- end action validate users -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-primary btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                أضافة مستخدم جديد
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
                                                <th> الأسم </th>
                                                <th >رقم الهاتف </th>
                                                <th > البريد الألكتروني</th>
                                                <th >الرصيد</th>
                                                <th > وقت الأنشاء</th>
                                                <th > الحالة</th>
                                                <th >العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($users as $x)
                                                <?php $i++ ; ?>
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>{{$x->name}}</td>
                                                    <td>{{$x->phone}}</td>
                                                    <td>{{$x->email}}</td>
                                                    <td>{{$x->balance}}</td>
                                                    <td>{{$x->createdAt}}</td>
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



                                                <!-- start delete_modal_users-->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف المستخدم
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('users.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد حذف المستخدم؟
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
                                                <!--end  delete_modal_users-->

                                                <!-- start details_modal_users-->
                                                <div class="modal fade" id="details{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تفاصيل المستخدم
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                    <div class="col-12">
                                                                        <div class="card custom-card">
                                                                            <div class="card-body ht-100p">
                                                                                <div>
                                                                                    <h6 class="card-title mb-1">صورة المستخدم </h6>
                                                                                </div>
                                                                                <div class="">
                                                                                    <div class="carousel slide" data-ride="carousel" id="carouselExampleSlidesOnly">
                                                                                        <div class="carousel-inner">
                                                                                            <div class="carousel-item active">
                                                                                                <img alt="img" class="d-block w-100 op-3" src="{{URL::asset('Attachments/users/'.$x->phone.'/'.$x->image)}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  </div>
                                                                <div class="card" style="width:100%;">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  الأسم :  </label><span>{{$x->name}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    ارقم الهاتف :  </label><span> {{$x->phone}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   البريد الألكتروني:  </label> <span>{{$x->email}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   الرصيد:  </label> <span>{{$x->balance}}</span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--end  details_delete_modal_users -->

                                                <!-- start edit_modal_users-->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل معلومات المستخدم
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ route('users.update', 'test') }}" method="POST" enctype="multipart/form-data">
                                                                    {{ method_field('patch') }}
                                                                    @csrf
                                                                    <div class="row">

                                                                        <div class="col-12">
                                                                            <label for="name" class="mr-sm-2">الأسم</label>
                                                                            <input id="name" type="text" name="name"
                                                                                   class="form-control"
                                                                                   required value="{{$x->name}}">
                                                                            <input type="hidden" id="id" name="id" value="{{$x->id}}">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="email" class="mr-sm-2">البريد الألكتروني</label>
                                                                            <input id="email" type="text" name="email"
                                                                                   class="form-control"
                                                                                   required value="{{$x->email}}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="phone" class="mr-sm-2">رقم الهاتف</label>
                                                                            <input id="phone" type="number" name="phone"
                                                                                   class="form-control"
                                                                                   required value="{{$x->phone}}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="password" class="mr-sm-2">كلمة السر</label>
                                                                            <input id="password" type="text" name="password"
                                                                                   class="form-control">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="cashback" class="mr-sm-2"> كاش باك</label>
                                                                            <input id="cashback" type="number" name="cashback" class="form-control" value="{{$x->cashback}}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="balance" class="mr-sm-2">الرصيد</label>
                                                                            <input id="balance" type="number" name="balance" class="form-control" value="{{$x->balance}}">
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

                                                                        <div class="col-sm-12 col-md-12 mt-4">
                                                                            <label for="image" class="mr-sm-2"> صورة للمستخدم</label>
                                                                            <input type="file" name="image" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                   data-height="70" />
                                                                        </div>



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
                                                <!-- end edit_modal_users -->

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end table -->



                            </div>
                        </div>


                        <!-- start add_modal_users-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                            أضافة مستخدم جديد
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                <div class="col-12">
                                                    <label for="name" class="mr-sm-2">الأسم</label>
                                                    <input id="name" type="text" name="name"
                                                           class="form-control"
                                                           required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="email" class="mr-sm-2">البريد الألكتروني</label>
                                                    <input id="email" type="text" name="email"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="phone" class="mr-sm-2">رقم الهاتف</label>
                                                    <input id="phone" type="number" name="phone"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="password" class="mr-sm-2">كلمة السر</label>
                                                    <input id="password" type="password" name="password"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="cashback" class="mr-sm-2">أضافة كاش باك</label>
                                                    <input id="cashback" type="number" name="cashback" class="form-control">
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <label for="image" class="mr-sm-2">أضافة صورة للمستخدم</label>
                                                    <input type="file" name="image" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                           data-height="70" />
                                                </div>



                                            </div>
                                            <br>
                                            <br>


                                            <br><br>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">أغلاق</button>
                                                <button type="submit" id="add" class="btn btn-success">أضافة</button>
                                            </div>


                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end add_modal_users -->

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

    <!--add-->
    <script>
        $(document).ready(function() {
            $('#link_select').hide();
            $('#categories_part_select').hide();
            $('#stores_select2').hide();
            $('#categories_select').hide();
            $('#stores_select').hide();


            $('select[id="screen"]').click(function() {
                if ($(this).val() == 'categories')
                {
                    $('#categories_select').show();
                    $('#stores_select').hide();
                }

                else if($(this).val() == 'stores')
                {
                    $('#categories_select').hide();
                    $('#stores_select').show();
                }
                else
                {
                    $('#categories_select').hide();
                    $('#stores_select').hide();
                }
            });

            $('select[id="action"]').click(function() {
                if ($(this).val() == 'categories')
                {
                    $('#link_select').hide();
                    $('#categories_part_select').show();
                    $('#stores_select2').hide();
                }

                else if($(this).val() == 'link')
                {
                    $('#link_select').show();
                    $('#categories_part_select').hide();
                    $('#stores_select2').hide();
                }
                else if($(this).val() == 'stores')
                {
                    $('#link_select').hide();
                    $('#categories_part_select').hide();
                    $('#stores_select2').show();
                }
                else
                {
                    $('#link_select').hide();
                    $('#categories_part_select').hide();
                    $('#stores_select2').hide();
                    //here select product
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.link_select_edit').hide();
            $('.categories_part_select_edit').hide();
            $('.stores_select2_edit').hide();
            $('.categories_select_edit').hide();
            $('.stores_select_edit').hide();


            $(".screen_edit").click(function()
            {
                if ($(this).val() == 'categories')
                {
                    $('.categories_select_edit').show();
                    $('.stores_select_edit').hide();
                }

                else if($(this).val() == 'stores')
                {
                    $('.categories_select_edit').hide();
                    $('.stores_select_edit').show();
                }
                else
                {
                    $('.categories_select_edit').hide();
                    $('.stores_select_edit').hide();
                }
            });

            $('.action_edit').click(function() {
                if ($(this).val() == 'categories')
                {
                    $('.link_select_edit').hide();
                    $('.categories_part_select_edit').show();
                    $('.stores_select2_edit').hide();
                }

                else if($(this).val() == 'link')
                {
                    $('.link_select_edit').show();
                    $('.categories_part_select_edit').hide();
                    $('.stores_select2_edit').hide();
                }
                else if($(this).val() == 'stores')
                {
                    $('.link_select_edit').hide();
                    $('.categories_part_select_edit').hide();
                    $('.stores_select2_edit').show();
                }
                else
                {
                    $('.link_select_edit').hide();
                    $('.categories_part_select_edit').hide();
                    $('.stores_select2_edit').hide();
                    //here select product
                }
            });
        });


    </script>


@endsection

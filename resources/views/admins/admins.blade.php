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
       الأدارة العامة
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الأدارة العامة</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate notify  -->
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
    <!-- end action validate notify -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-primary btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                أضافة مسؤول جديد
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
                                                <th>الأسم </th>
                                                <th> البريد الألكتروني</th>
                                                <th >سوبر أدمن</th>
                                                <th > وقت الأنشاء</th>
                                                <th >العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($admins as $x)
                                                <?php $i++ ; ?>
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>{{$x->name}}</td>
                                                    <td>{{$x->email}}</td>
                                                    @if($x->isSuperAdmin == 1)
                                                        <td class="text-success">مفعل</td>
                                                    @else
                                                        <td class="text-danger">معطل</td>
                                                    @endif
                                                    <td>{{$x->createdAt}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#edit{{ $x->id }}"
                                                                title="تعديل" id="editor"><i class="fa fa-edit"></i>
                                                        </button>

                                                        <a class="modal-effect btn btn-sm btn-success" data-effect="effect-scale"
                                                           data-id="{{ $x->id }}" data-toggle="modal" href="#permissions"
                                                           title="الصلاحيات"><i class="las la-pen"></i></a>

                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#delete{{ $x->id }}"
                                                                title="حذف"><i
                                                                class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>



                                                <!-- start delete_modal_admin-->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف المسؤول
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admins.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد حذف المسؤول؟
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
                                                <!--end  delete_modal_admins-->


                                                <!-- start edit_modal_admins-->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل معلومات المسؤول
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ route('admins.update', 'test') }}" method="POST" >
                                                                    {{ method_field('patch') }}
                                                                    @csrf
                                                                    <div class="row">

                                                                        <div class="col-12">
                                                                            <label for="name" class="mr-sm-2">الاسم</label>
                                                                            <input id="name" type="text" name="name"
                                                                                   class="form-control"
                                                                                   required value="{{$x->name}}">
                                                                            <input type="hidden" name="id" id="id" value="{{$x->id}}">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="email" class="mr-sm-2">البريد الالكتروني</label>
                                                                            <input id="email" type="text" name="email"
                                                                                   class="form-control"
                                                                                   required value="{{$x->email}}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="password" class="mr-sm-2">كلمة المرور</label>
                                                                            <input id="password" type="password" name="password"
                                                                                   class="form-control">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="isSuperAdmin" class="mr-sm-2">سوبر أدمن </label>
                                                                            <select id="isSuperAdmin" name="isSuperAdmin" class="form-control" required>
                                                                                @if($x->isSuperAdmin==0)
                                                                                    <option value=0 selected >معطل</option>
                                                                                @else
                                                                                    <option value=1 selected>مفعل</option>
                                                                                @endif
                                                                                <option value=0>معطل</option>
                                                                                <option value=1>مفعل</option>
                                                                            </select>

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
                                                <!-- end edit_modal_admins -->




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
                                            أضافة مسؤول جديد
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                <div class="col-12">
                                                    <label for="name" class="mr-sm-2">الاسم</label>
                                                    <input id="name" type="text" name="name"
                                                           class="form-control"
                                                           required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="email" class="mr-sm-2">البريد الالكتروني</label>
                                                    <input id="email" type="text" name="email"
                                                           class="form-control"
                                                           required >
                                                </div>

                                                <div class="col-12">
                                                    <label for="password" class="mr-sm-2">كلمة المرور</label>
                                                    <input id="password" type="password" name="password"
                                                           class="form-control"
                                                           required >
                                                </div>

                                                <br>
                                                <br>
                                                <table class="table bg-light mb-4 mt-3 tablePermission" id="tablePermission" dir="rtl">
                                                    @include('admins.permission')
                                                </table>
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



                        <!-- start edit modal permission-->
                        <div class="modal fade" id="permissions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                            id="exampleModalLabel">
                                              أختار صلاحيات جديدة للمسؤول
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{route("permission")}}" method="post">
                                            {{csrf_field()}}
                                            <h5 class="modal-title" id="exampleModalLabel">تعديل الصلاحيات</h5>
                                            <div class="form-group">
                                                <input type="hidden" name="id" id="id" value="">
                                            </div>
                                            <table class="table">
                                                @include('admins.permission')
                                            </table>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">تاكيد</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end modal edit section -->


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
        $('#permissions').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>


@endsection

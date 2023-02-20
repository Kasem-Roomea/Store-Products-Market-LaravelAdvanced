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
    الأقسام الفرعية
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الأقسام الفرعية</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate section  -->
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
    <!-- end action validate section -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-primary btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                               أضافة قسم فرعي
                                            </button>

                                            <a class="modal-effect btn btn-outline-success btn-blockx-small ml-4" href="{{url('categories_part/export')}}">
                                                تصدير البيانات
                                            </a>
                                            <form action="{{url('Categories/import')}}" method="POST" enctype="multipart/form-data" >
                                                @csrf
                                                <input type="file" name="Categories_file" class="dropify" data-height="70" required />
                                                <button class="modal-effect btn btn-outline-indigo btn-blockx-small w-100"  type="submit">استيراد بيانات</button>
                                            </form>

                                        </div>


                                    </div>
                                <br><br>
                                <!-- start table -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='25'>
                                            <thead>
                                            <tr class="text-center">
                                                <th class="col-1">#</th>
                                                <th class="col-1" > القسم الفرعي </th>
                                                <th class="col-1" >القسم الرئيسي</th>
                                                <th class="col-1" >ترتيب القسم</th>
                                                <th class="col-1">الحالة</th>
                                                <th class="col-1" >العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($categories_part as $x)
                                                <?php $i++ ; ?>
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>
                                                        @if (App::isLocale('en'))
                                                            {{$x->nameEn}}
                                                        @else
                                                            {{$x->nameAr}}
                                                         @endif
                                                     </td>
                                                     <td>
                                                        @if (App::isLocale('en'))
                                                            {{$x->Categorie_perant->nameEn}}
                                                        @else
                                                            {{$x->Categorie_perant->nameAr}}
                                                         @endif
                                                     </td>
                                                    <td>{{$x->orderNum}}</td>
                                                    @if($x->isActive == 1)
                                                    <td class="text-success">مفعل</td>
                                                    @else
                                                      <td class="text-danger">معطل</td>
                                                    @endif
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
                                                                data-target="#view{{ $x->id }}"
                                                                title="عرض"><i
                                                                class="fa fa-eye"></i>
                                                        </button>

                                                    </td>
                                                </tr>



                                                <!-- start edit_modal_section -->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل القسم الفرعي
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ route('Categories_part.update', 'test') }}" method="POST" enctype="multipart/form-data">
                                                                    {{ method_field('patch') }}
                                                                    @csrf
                                                                    <div class="row">


                                                                        <div class="col-12">
                                                                            <label for="Name"
                                                                                   class="mr-sm-2">اسم القسم الفرعي بالعربي </label>
                                                                            <input id="Name" type="text" name="Name"
                                                                                   class="form-control mr-sm-2"
                                                                                   value="{{$x->nameAr}}"
                                                                                   required>
                                                                            <input id="id" type="hidden" name="id" class="form-control"
                                                                                   value="{{ $x->id }}">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="Name_en"
                                                                                   class="mr-sm-2">اسم القسم الفرعي بالانكليزي
                                                                                :</label>
                                                                            <input type="text" class="form-control mr-sm-2"
                                                                                   value="{{$x->nameEn}}"
                                                                                   name="Name_en" required>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="Categories_id" class="mr-sm-2">اسم القسم الرئيسي التابع ل</label>
                                                                            <select  id ='Categories_id' class="form-control mr-sm-2" data-live-search="true"  name="Categories_id" required>
                                                                                @if (App::isLocale('en'))
                                                                                    <option value="{{$x->Categorie_perant->id}}" selected >{{$x->Categorie_perant->nameEn}}</option>
                                                                                    @foreach($categories as $y)
                                                                                        <option value="{{$y->id}}" data-tokens="{{$y->nameEn}}">{{$y->nameEn}}</option>
                                                                                    @endforeach

                                                                                    @else
                                                                                    <option value="{{$x->Categorie_perant->id}}" selected >{{$x->Categorie_perant->nameAr}}</option>
                                                                                    @foreach($categories as $y)
                                                                                        <option value="{{$y->id}}" data-tokens="{{$y->nameAr}}">{{$y->nameAr}}</option>
                                                                                    @endforeach

                                                                                @endif

                                                                            </select>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="orderNum"
                                                                                   class="mr-sm-2"> ترتيب القسم
                                                                                :</label>
                                                                            <input type="number" class="form-control mr-sm-2"
                                                                                   value="{{$x->orderNum}}"
                                                                                   name="orderNum" required>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="status"
                                                                                   class="mr-sm-2"> الحالة
                                                                                :</label>
                                                                            <select type="text" class="form-control mr-sm-2 " name="status" required>
                                                                                    @if($x->isActive == 1)
                                                                                    <option selected  value=1 class="text-success" >مفعل</option>
                                                                                    @else
                                                                                    <option selected  value=0 class="text-danger" >معطل</option>
                                                                                    @endif
                                                                                <option value=1> مفعل </option>
                                                                                <option value=0>معطل</option>
                                                                            </select>

                                                                        </div>

                                                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                                        <label for="formFile" class="mr-sm-2"> المرفقات :</label>
                                                                        <div class="col-sm-12 col-md-12">
                                                                            <input class="form-control" name="pic" type="file" id="formFile" accept=".pdf,.jpg, .png, image/jpeg, image/png">
                                                                        </div><br>
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
                                                <!-- end edit_modal_section -->

                                                <!-- start delete_modal_section -->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف القسم الفرعي
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('Categories_part.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد حذف القسم الفرعي؟
                                                                    <input id="id" type="hidden" name="id" class="form-control"
                                                                           value="{{ $x->id }}">
                                                                    <input id="nameEn" type="hidden" name="nameEn" class="form-control"
                                                                           value="{{ $x->nameEn }}">
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
                                                <!--end  delete_modal_section -->

                                                <!-- start view image_modal_section -->
                                                <div class="modal fade" id="view{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                      صورة القسم الفرعي
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
                                                                                <h6 class="card-title mb-1">صورة القسم </h6>
                                                                            </div>
                                                                            <div class="">
                                                                                <div class="carousel slide" data-ride="carousel" id="carouselExampleSlidesOnly">
                                                                                    <div class="carousel-inner">
                                                                                        <div class="carousel-item active">
                                                                                            <img alt="img" class="d-block w-100 op-3" src="{{URL::asset('Attachments/categories/'.$x->orderNum.'/'.$x->image)}}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end  view image_modal_section -->

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end table -->

                            </div>
                        </div>

                        <!-- start add_modal_section -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                            أضافة قسم فرعي
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('Categories_part.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="Name" class="mr-sm-2"> اسم القسم باللغة العربية
                                                        :</label>
                                                    <input id="Name" type="text" name="Name" class="form-control" required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="Name_en" class="mr-sm-2"> اسم القسم باللغة الانكليزية
                                                        :</label>
                                                    <input type="text" class="form-control" name="Name_en" required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="Categories_id" class="mr-sm-2">اسم القسم الرئيسي التابع ل</label>
                                                    <select type="text" class="form-control selectpicker"  data-live-search="true" name="Categories_id"required>
                                                        @if (App::isLocale('en'))
                                                            @foreach($categories as $y)
                                                                <option value="{{$y->id}}"  data-tokens="{{$y->nameEn}}">{{$y->nameEn}}</option>
                                                            @endforeach

                                                        @else
                                                            @foreach($categories as $y)
                                                                <option value="{{$y->id}}" data-tokens="{{$y->nameAr}}">{{$y->nameAr}}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <label for="orderNum" class="mr-sm-2">ترتيب القسم :</label>
                                                    <input type="number" class="form-control" name="orderNum" required>
                                                </div>
                                            </div>

                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                            <label for="pic" class="mr-sm-2"> المرفقات :</label>
                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                       data-height="70" />
                                            </div><br>
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
                        <!-- end add_modal_section -->

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

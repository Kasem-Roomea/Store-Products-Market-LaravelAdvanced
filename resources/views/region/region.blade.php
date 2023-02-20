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
      الأمارات والمدن
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"> الأمارات والمدن</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate Km  -->
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
    <!-- end action validate Km -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-primary btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                أضافة جديد
                                            </button>
                                            <!--
                                            <a class="modal-effect btn btn-outline-success btn-blockx-small ml-4" href="">
                                                تصدير البيانات
                                            </a>
                                            <a class="modal-effect btn btn-outline-indigo btn-blockx-small" href="">
                                                استيراد البيانات
                                            </a>
                                            -->
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
                                                <th class="col-1" > الأمارة</th>
                                                <th class="col-1"> المدينة</th>
                                                <th class="col-1" >المنطقة</th>
                                                <th class="col-1" > النوع</th>
                                                <th class="col-1" > الحالة</th>
                                                <th class="col-1" >العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($region as $x)
                                                <?php $i++ ; ?>

                                                <!--أمارة-->
                                                @if($x->type=='emirate')
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>
                                                        @if (App::isLocale('en'))
                                                            {{$x->nameEn}}
                                                        @else
                                                            {{$x->nameAr}}
                                                        @endif
                                                    </td>

                                                    <td class="text-success">--</td>
                                                    <td class="text-success">--</td>
                                                    <td>{{$x->type}}</td>
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
                                                    </td>
                                                </tr>
                                                <!-- start edit_modal_regions Emirate -->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل المعلومات
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ route('cityEmirate.update', 'test') }}" method="POST" >
                                                                    {{ method_field('patch') }}
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label for="nameEn"
                                                                                   class="mr-sm-2">الأمارة بالانكليزي</label>
                                                                            <input id="nameEn" type="text" name="nameEn"
                                                                                   class="form-control"
                                                                                   value="{{$x->nameEn}}"
                                                                                   required>
                                                                            <input id="id" type="hidden" name="id" class="form-control"
                                                                                   value="{{ $x->id }}">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="nameAr"
                                                                                   class="mr-sm-2">الأمارة بالعربي</label>
                                                                            <input id="nameAr" type="text" name="nameAr"
                                                                                   class="form-control"
                                                                                   value="{{$x->nameAr}}"
                                                                                   required>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="type"
                                                                                   class="mr-sm-2">النوع</label>

                                                                            <input id="type" type="text" name="type"
                                                                                   class="form-control"
                                                                                   value="{{$x->type}}"
                                                                                   required disabled>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="Active"
                                                                                   class="mr-sm-2"> الحالة</label>
                                                                            <select id='Active' type="text" class="form-control" name="Active" required>
                                                                                @if($x->isActive == 1)
                                                                                    <option selected disabled value="1" class="text-success" >مفعل</option>
                                                                                @else
                                                                                    <option selected disabled  value="0" class="text-danger" >معطل</option>
                                                                                @endif
                                                                                <option value="1"> مفعل </option>
                                                                                <option value="0">معطل</option>
                                                                            </select>
                                                                        </div>
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
                                                <!-- end edit_modal_regions Emirate -->






                                                <!--مدينة-->
                                                @elseif($x->type=='city')
                                                    <tr class="text-center">
                                                        <td>{{$i}}</td>
                                                        <td>
                                                            @if (App::isLocale('en'))
                                                                {{$x->cityEmirateParent->nameEn}}
                                                            @else
                                                                {{$x->cityEmirateParent->nameAr}}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if (App::isLocale('en'))
                                                                {{$x->nameEn}}
                                                            @else
                                                                {{$x->nameAr}}
                                                            @endif
                                                        </td>
                                                        <td class="text-success">--</td>                                                         <td>{{$x->type}}</td>
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
                                                        </td>
                                                    </tr>

                                                    <!-- start edit_modal_regions City -->
                                                    <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                        id="exampleModalLabel">
                                                                        تعديل المعلومات
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!--edit form -->
                                                                    <form action="{{ route('cityEmirate.update', 'test') }}" method="POST" >
                                                                        {{ method_field('patch') }}
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label for="nameEn"
                                                                                       class="mr-sm-2">المدينة بالانكليزي</label>
                                                                                <input id="nameEn" type="text" name="nameEn"
                                                                                       class="form-control"
                                                                                       value="{{$x->nameEn}}"
                                                                                       required>
                                                                                <input id="id" type="hidden" name="id" class="form-control"
                                                                                       value="{{ $x->id }}">
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <label for="nameAr"
                                                                                       class="mr-sm-2">المدينة بالعربي</label>
                                                                                <input id="nameAr" type="text" name="nameAr"
                                                                                       class="form-control"
                                                                                       value="{{$x->nameAr}}"
                                                                                       required>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <label for="emirate"
                                                                                       class="mr-sm-2"> الامارة </label>
                                                                                <select id='emirate' type="text" class="form-control" name="emirate" required>
                                                                                    <option selected disabled value="{{$x->cityEmirateParent->id}}" class="text-success" >
                                                                                        @if (App::isLocale('en'))
                                                                                            {{$x->cityEmirateParent->nameEn}}
                                                                                        @else
                                                                                            {{$x->cityEmirateParent->nameAr}}
                                                                                        @endif
                                                                                    </option>
                                                                                    @foreach($emirate as $e)
                                                                                        <option value="{{$e->id}}" class="text-success" >
                                                                                            @if (App::isLocale('en'))
                                                                                                {{$e->nameEn}}
                                                                                            @else
                                                                                                {{$e->nameAr}}
                                                                                            @endif
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <label for="type"
                                                                                       class="mr-sm-2">النوع</label>

                                                                                <input id="type" type="text" name="type"
                                                                                       class="form-control"
                                                                                       value="{{$x->type}}"
                                                                                       required disabled>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <label for="Active"
                                                                                       class="mr-sm-2"> الحالة</label>
                                                                                <select id='Active' type="text" class="form-control" name="Active" required>
                                                                                    @if($x->isActive == 1)
                                                                                        <option selected disabled value="1" class="text-success" >مفعل</option>
                                                                                    @else
                                                                                        <option selected disabled  value="0" class="text-danger" >معطل</option>
                                                                                    @endif
                                                                                    <option value="1"> مفعل </option>
                                                                                    <option value="0">معطل</option>
                                                                                </select>
                                                                            </div>
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
                                                    <!-- end edit_modal_regions City -->







                                                    <!--منطقة-->
                                                @elseif($x->type=='district')
                                                    <tr class="text-center">
                                                        <td>{{$i}}</td>
                                                        <td>
                                                            @if (App::isLocale('en'))
                                                                {{$x->cityEmirateParent->cityEmirateParent->nameEn}}
                                                            @else
                                                                {{$x->cityEmirateParent->cityEmirateParent->nameAr}}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if (App::isLocale('en'))
                                                                {{$x->cityEmirateParent->nameEn}}
                                                            @else
                                                                {{$x->cityEmirateParent->nameAr}}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if (App::isLocale('en'))
                                                                {{$x->nameEn}}
                                                            @else
                                                                {{$x->nameAr}}
                                                            @endif
                                                        </td>
                                                        <td>{{$x->type}}</td>
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
                                                        </td>
                                                    </tr>

                                                <!-- start edit_modal_regions distract-->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل المعلومات
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ route('cityEmirate.update', 'test') }}" method="POST" >
                                                                    {{ method_field('patch') }}
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label for="nameEn"
                                                                                   class="mr-sm-2">المنطقة بالانكليزي</label>
                                                                            <input id="nameEn" type="text" name="nameEn"
                                                                                   class="form-control"
                                                                                   value="{{$x->nameEn}}"
                                                                                   required>
                                                                            <input id="id" type="hidden" name="id" class="form-control"
                                                                                   value="{{ $x->id }}">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="nameAr"
                                                                                   class="mr-sm-2">المنطقة بالعربي</label>
                                                                            <input id="nameAr" type="text" name="nameAr"
                                                                                   class="form-control"
                                                                                   value="{{$x->nameAr}}"
                                                                                   required>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="city"
                                                                                   class="mr-sm-2">االمدينة </label>
                                                                            <select id='city' type="text" class="form-control" name="city" required>
                                                                                <option selected disabled value="{{$x->cityEmirateParent->id}}" class="text-success" >
                                                                                    @if (App::isLocale('en'))
                                                                                        {{$x->cityEmirateParent->nameEn}}
                                                                                    @else
                                                                                        {{$x->cityEmirateParent->nameAr}}
                                                                                    @endif
                                                                                </option>
                                                                                @foreach($city as $e)
                                                                                    <option value="{{$e->id}}" class="text-success" >
                                                                                        @if (App::isLocale('en'))
                                                                                            {{$e->nameEn}}
                                                                                        @else
                                                                                            {{$e->nameAr}}
                                                                                        @endif
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            @if (App::isLocale('en'))
                                                                                <h6 hidden> {{$emara = $x->cityEmirateParent->cityEmirateParent->nameEn}}</h6>
                                                                            @else
                                                                                <h6 hidden> {{$emara = $x->cityEmirateParent->cityEmirateParent->nameAr}}</h6>
                                                                            @endif
                                                                            <label for="emirate"
                                                                                   class="mr-sm-2">الأمارة</label>
                                                                            <input id='emirate' type="text" class="form-control" name="emirate" disabled value="{{$emara}}"/>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="type"
                                                                                   class="mr-sm-2">النوع</label>

                                                                            <input id="type" type="text" name="type"
                                                                                   class="form-control"
                                                                                   value="{{$x->type}}"
                                                                                   required disabled>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="Active"
                                                                                   class="mr-sm-2"> الحالة</label>
                                                                            <select id='Active' type="text" class="form-control" name="Active" required>
                                                                                @if($x->isActive == 1)
                                                                                    <option selected disabled value="1" class="text-success" >مفعل</option>
                                                                                @else
                                                                                    <option selected disabled  value="0" class="text-danger" >معطل</option>
                                                                                @endif
                                                                                <option value="1"> مفعل </option>
                                                                                <option value="0">معطل</option>
                                                                            </select>
                                                                        </div>
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
                                                <!-- end edit_modal_regions distract -->
                                                @endif



                                                <!-- start delete_modal_regions -->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('cityEmirate.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد االحذف ؟
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
                                                <!--end  delete_modal_section -->




                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end table -->

                            </div>
                        </div>

                        <!-- start add_modal_region-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                            أضافة معلومات جديدة
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('cityEmirate.store') }}" method="POST">
                                            @csrf
                                           <div class="row">
                                            <div class="col-12">
                                                   <label for="type"
                                                          class="mr-sm-2">النوع</label>
                                                   <div class="col-lg-3">
                                                       <label class="rdiobox">
                                                           <input checked name="rdio" type="radio" value="emirate" id="em"> <span>أمارة</span>
                                                       </label>
                                                   </div>

                                                   <div class="col-lg-3">
                                                       <label class="rdiobox">
                                                           <input checked name="rdio" type="radio" value="city" id="ci"> <span>مدينة</span>
                                                       </label>
                                                   </div>

                                                   <div class="col-lg-3">
                                                       <label class="rdiobox">
                                                           <input checked name="rdio" type="radio" value="district" id="di"> <span>منطقة</span>
                                                       </label>
                                                   </div>
                                               </div>
                                            <div class="col-12">
                                                <label for="nameEn"
                                                       class="mr-sm-2">الأسم بالانكليزي</label>
                                                <input id="nameEn" type="text" name="nameEn"
                                                       class="form-control"
                                                       required>
                                            </div>
                                            <div class="col-12">
                                                <label for="nameAr"
                                                       class="mr-sm-2">الأسم بالعربي</label>
                                                <input id="nameAr" type="text" name="nameAr"
                                                       class="form-control"
                                                       required>
                                            </div>
                                               <div class="col-12" id="citys">
                                                   <label for="city_select" class="mr-sm-2">االمدينة </label>
                                                   <select id='city_select' type="text" class="form-control" name="city">
                                                       @foreach($city as $c)
                                                           <option value="{{$c->id}}" >
                                                               @if (App::isLocale('en'))
                                                                   {{$c->nameEn}}
                                                               @else
                                                                   {{$c->nameAr}}
                                                               @endif
                                                           </option>
                                                       @endforeach
                                                   </select>

                                               </div>
                                               <div class="col-12" id="emirates">
                                                   <label for="emirate_select" class="mr-sm-2">الأمارة</label>
                                                   <select id='emirate_select' type="text" class="form-control" name="emirate">
                                                       @foreach($emirate as $e)
                                                           <option value="{{$e->id}}" >
                                                               @if (App::isLocale('en'))
                                                                   {{$e->nameEn}}
                                                               @else
                                                                   {{$e->nameAr}}
                                                               @endif
                                                           </option>
                                                       @endforeach
                                                   </select>

                                               </div>
                                               <div class="col-12">
                                                <label for="Active"
                                                       class="mr-sm-2"> الحالة</label>
                                                <select id='Active' type="text" class="form-control" name="Active" required>
                                                    <option value="1"> مفعل </option>
                                                    <option value="0">معطل</option>
                                                </select>
                                            </div>
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
                        <!-- end add_modal_region -->

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
    <!-- Internal Select2.min js -->
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
    <script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>

    <script>
        $(document).ready(function() {
            $('#citys').hide();
            $('#emirates').hide();

            $('input[type="radio"]').click(function() {
                if ($(this).attr('id') == 'em')
                {
                    $('#citys').hide();
                    $('#emirates').hide();
                }
                else if($(this).attr('id') == 'ci') {
                    $('#citys').hide();
                    $('#emirates').show();
                }
                else
                {
                    $('#citys').show();
                    $('#emirates').hide();
                }
            });
        });

    </script>
@endsection

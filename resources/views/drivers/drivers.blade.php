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
       السائقين
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">السائقين</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate driver  -->
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
    <!-- end action validate driver -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-primary btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                أضافة سائق جديد
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
                                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='10'>
                                            <thead>
                                            <tr class="text-center">
                                                <th >#</th>
                                                <th  >أسم السائق</th>
                                                <th >رقم الجوال</th>
                                                <th >البريد الالكتروني</th>
                                                <th > الرصيد</th>
                                                <th > الحالة</th>
                                                <th > الموافقة</th>
                                                <th >العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($drivers as $x)
                                                <?php $i++ ; ?>
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>{{$x->name}}</td>
                                                    <td>{{$x->phone}}</td>
                                                    <td>{{$x->email}}</td>
                                                    <td>{{$x->balance}}</td>
                                                    @if($x->isActive == 1)
                                                        <td class="text-success">مفعل</td>
                                                    @else
                                                        <td class="text-danger">معطل</td>
                                                    @endif

                                                    @if($x->isApproved == 1)
                                                        <td class="text-success"> تمت الموافقة <i class="far fa-check-circle"></i> </td>
                                                    @else
                                                        <td class="text-danger"> بأنتظار الموافقة <i class="far fa-clock"></i></td>
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
                                                                data-target="#details{{ $x->id }}"
                                                                title="التفاصيل"><i class="fa fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>



                                                <!-- start edit_modal_drivers -->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل  معلومات السائق
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ url('drivers/update') }}" method="POST" enctype="multipart/form-data">
                                                                    {{method_field('patch')}}
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <label for="name"
                                                                                   class="mr-sm-2">الأسم</label>
                                                                            <input id="name" type="text" name="name"
                                                                                   class="form-control"
                                                                                   required value="{{$x->name}}">
                                                                            <input id="id" type="hidden" name="id" class="form-control"
                                                                                   value="{{ $x->id }}">
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="phone"
                                                                                   class="mr-sm-2">رقم الهاتف</label>
                                                                            <input id="phone" type="tel" name="phone"
                                                                                   class="form-control"
                                                                                   required value="{{$x->phone}}">
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label for="email"
                                                                                   class="mr-sm-2">البريد الالكتروني</label>
                                                                            <input id="email" type="email" name="email"
                                                                                   class="form-control"
                                                                                   required value="{{$x->email}}">
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="password"
                                                                                   class="mr-sm-2">الرقم السري </label>
                                                                            <input id="password" type="password" name="password"
                                                                                   class="form-control">
                                                                        </div>



                                                                        <div class="col-6">
                                                                            <label for="balance"
                                                                                   class="mr-sm-2">الرصيد </label>
                                                                            <input id="balance" type="number" name="balance"
                                                                                   class="form-control"
                                                                                   required value="{{$x->balance}}">
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="fees"
                                                                                   class="mr-sm-2">الرسوم </label>
                                                                            <input id="fees" type="number" name="fees"
                                                                                   class="form-control"
                                                                                   required value="{{$x->fees}}">
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="vehicles_id"
                                                                                   class="mr-sm-2">الشاحنة </label>
                                                                            <select id="vehicles_id" name="vehicles_id"
                                                                                    class="form-control"
                                                                                    required>
                                                                                @if($x->vehicles_id==Null)
                                                                                    <option value="{{null}}">__تحديد نوع الشاحنة</option>
                                                                                    @foreach($vehicle as $v)
                                                                                        @if (App::isLocale('en'))
                                                                                            <option value="{{$v->id}}">{{$v->nameEr}}</option>
                                                                                        @else
                                                                                            <option value="{{$v->id}}">{{$v->nameAr}}</option>
                                                                                        @endif
                                                                                    @endforeach

                                                                                @else
                                                                                @if (App::isLocale('en'))
                                                                                    <option selected  value="{{$x->nameCarDrivers->id}}">{{$x->nameCarDrivers->nameEr}}</option>
                                                                                @else
                                                                                    <option selected value="{{$x->nameCarDrivers->id}}">{{$x->nameCarDrivers->nameAr}}</option>
                                                                                @endif
                                                                                @foreach($vehicle as $v)
                                                                                    @if (App::isLocale('en'))
                                                                                        <option value="{{$v->id}}">{{$v->nameEr}}</option>
                                                                                    @else
                                                                                        <option value="{{$v->id}}">{{$v->nameAr}}</option>
                                                                                    @endif

                                                                                @endforeach
                                                                                    @endif
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="model"
                                                                                   class="mr-sm-2">طراز السيارة </label>
                                                                            <input id="model" type="text" name="model"
                                                                                   class="form-control"
                                                                                   required value="{{$x->model}}">
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="licenseNumber"
                                                                                   class="mr-sm-2"> رقم الرخصة </label>
                                                                            <input id="licenseNumber" type="number" name="licenseNumber"
                                                                                   class="form-control"
                                                                                   required value="{{$x->licenseNumber}}">
                                                                        </div>


                                                                        <div class="col-6">
                                                                            <label for="delivery_methods_id"
                                                                                   class="mr-sm-2">طريقة التوصيل </label>
                                                                            <select id="delivery_methods_id" name="delivery_methods_id"
                                                                                    class="form-control"
                                                                                    required>
                                                                                @if (App::isLocale('en'))
                                                                                    <option selected  value="{{$x->nameDeleveryDrivers->id}}">{{$x->nameDeleveryDrivers->nameEn}}</option>
                                                                                @else
                                                                                    <option selected  value="{{$x->nameDeleveryDrivers->id}}">{{$x->nameDeleveryDrivers->nameAr}}</option>
                                                                                @endif
                                                                                @foreach($delivery as $d)
                                                                                    @if (App::isLocale('en'))
                                                                                        <option value="{{$d->id}}">{{$d->nameEn}}</option>
                                                                                    @else
                                                                                        <option value="{{$d->id}}">{{$d->nameAr}}</option>
                                                                                    @endif

                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="isActive"
                                                                                   class="mr-sm-2">الحالة </label>
                                                                            <select id="isActive" name="isActive"
                                                                                    class="form-control"
                                                                                    required>

                                                                                    @if($x->isActive==0)
                                                                                    <option value=0 selected >معطل</option>
                                                                                    @else
                                                                                    <option value=1 selected >مفعل</option>
                                                                                    @endif
                                                                                <option value=0>معطل</option>
                                                                                <option value=1>مفعل</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="isVerified"
                                                                                   class="mr-sm-2">الموافقة </label>
                                                                            <select id="isVerified" name="isVerified"
                                                                                    class="form-control"
                                                                                    required>

                                                                                    @if($x->isApproved==0)
                                                                                    <option value=0 selected >بانتظار الموافقة</option>
                                                                                    @else
                                                                                    <option value=1 selected >مع الموافقة</option>
                                                                                    @endif

                                                                                <option value=0>بانتظار الموافقة</option>
                                                                                <option value=1>مع الموافقة</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-sm-12 col-md-12 m-2">
                                                                            <label for="personal" class="mr-sm-2">الصورة الشخصية</label><br>
                                                                            <input type="file" name="personal" class="form-control" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                   data-height="70" value="" />
                                                                        </div>

                                                                        <div class="col-sm-12 col-md-12 m-2">
                                                                            <label for="idPhoto" class="mr-sm-2">صورة الهوية</label><br>
                                                                            <input type="file" name="idPhoto" class="form-control" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                   data-height="70" value=""/>
                                                                        </div>

                                                                        <div class="col-sm-12 col-md-12 m-2">
                                                                            <label for="licenseDriver" class="mr-sm-2">صورة رخصة السائق</label><br>
                                                                            <input type="file" name="licenseDriver" class="form-control" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                   data-height="70" value="" />
                                                                        </div>

                                                                        <div class="col-sm-12 col-md-12 m-2">
                                                                            <label for="carPhoto" class="mr-sm-2">صورة السيارة</label><br>
                                                                            <input type="file" name="carPhoto" class="form-control" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                   data-height="70" value="" />
                                                                        </div>

                                                                        <div class="col-sm-12 col-md-12 m-2">
                                                                            <label for="licenseCar" class="mr-sm-2">صورة رخصة السيارة</label><br>
                                                                            <input type="file" name="licenseCar" class="form-control" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                   data-height="70" value="" />
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
                                                <!-- end edit_modal_drivers -->

                                                <!-- start delete_modal_drivers -->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف السائق
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('drivers.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد حذف السائق؟
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
                                                <!--end  delete_modal_drivers -->

                                                <!-- start details_modal_drivers -->
                                                <div class="modal fade" id="details{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تفاصيل السائق
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class=" col">
                                                                    <div class="card custom-card">
                                                                        <div class="card-body ht-100p">
                                                                            <div>
                                                                                <h6 class="card-title mb-1">الصور المتعلقة بالسائق</h6>
                                                                            </div>
                                                                            <div>
                                                                                <div class="carousel slide" data-ride="carousel" id="carouselExample4{{$i}}">
                                                                                    <ol class="carousel-indicators">
                                                                                        <li class="active" data-slide-to="0" data-target="#carouselExample4{{$i}}"></li>
                                                                                        <li data-slide-to="1" data-target="#carouselExample4{{$i}}"></li>
                                                                                        <li data-slide-to="2" data-target="#carouselExample4{{$i}}"></li>
                                                                                        <li data-slide-to="3" data-target="#carouselExample4{{$i}}"></li>
                                                                                        <li data-slide-to="4" data-target="#carouselExample4{{$i}}"></li>
                                                                                    </ol>
                                                                                    <div class="carousel-inner bg-dark">
                                                                                        <div class="carousel-item active">
                                                                                            <img alt="img" class="d-block w-100 op-3" src="{{URL::asset('Attachments/drivers/'.$x->phone.'/'.$x->image)}}">
                                                                                            <div class="carousel-caption d-none d-md-block">
                                                                                                <h5>الصورة الشخصية </h5>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="carousel-item">
                                                                                            <img alt="img" class="d-block w-100 op-3" src="{{URL::asset('Attachments/drivers/'.$x->phone.'/'.$x->IdPhoto)}}">
                                                                                            <div class="carousel-caption d-none d-md-block">
                                                                                                <h5>صورة الهوية </h5>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="carousel-item">
                                                                                            <img alt="img" class="d-block w-100 op-3" src="{{URL::asset('Attachments/drivers/'.$x->phone.'/'.$x->driverLicenseImage)}}">
                                                                                            <div class="carousel-caption d-none d-md-block">
                                                                                                <h5>صورة رخصة السائق </h5>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="carousel-item">
                                                                                            <img alt="img" class="d-block w-100 op-3" src="{{URL::asset('Attachments/drivers/'.$x->phone.'/'.$x->carImage)}}">
                                                                                            <div class="carousel-caption d-none d-md-block">
                                                                                                <h5>صورة السيارة </h5>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="carousel-item">
                                                                                            <img alt="img" class="d-block w-100 op-3" src="{{URL::asset('Attachments/drivers/'.$x->phone.'/'.$x->carLicenseImage)}}">
                                                                                            <div class="carousel-caption d-none d-md-block">
                                                                                                <h5>صورة رخصة السيارة </h5>
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
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  اسم المركبة:  </label><span>
                                                                            @if($x->vehicles_id==Null)
                                                                                    لا يوجد مركبة
                                                                                @else
                                                                                    @if (App::isLocale('en'))
                                                                                        {{$x->nameCarDrivers->nameEr}}
                                                                                    @else
                                                                                        {{$x->nameCarDrivers->nameAr}}
                                                                                    @endif
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   طراز السيارة:  </label><span> {{$x->model}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  رقم الرخصة:  </label> <span>{{$x->licenseNumber}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  الرسوم:  </label> <span>{{$x->fees}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  العمولة:  </label> <span>{{$x->balance}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  طريقة التوصيل:  </label> <span>{{$x->nameDeleveryDrivers->nameAr}}</span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end  details_delete_modal_drivers -->




                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end table -->
                                <div>  </div>
                            </div>
                        </div>

                        <!-- start add_modal_drivers -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                            أضافة سائق جديد
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="name"
                                                           class="mr-sm-2">الأسم</label>
                                                    <input id="name" type="text" name="name"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-6">
                                                    <label for="phone"
                                                           class="mr-sm-2">رقم الهاتف</label>
                                                    <input id="phone" type="tel" name="phone"
                                                           class="form-control"
                                                           required>
                                                </div>
                                                <div class="col-6">
                                                    <label for="email"
                                                           class="mr-sm-2">البريد الالكتروني</label>
                                                    <input id="email" type="email" name="email"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-6">
                                                    <label for="password"
                                                           class="mr-sm-2">الرقم السري </label>
                                                    <input id="password" type="password" name="password"
                                                           class="form-control"
                                                           required>
                                                </div>



                                                <div class="col-6">
                                                    <label for="balance"
                                                           class="mr-sm-2">الرصيد </label>
                                                    <input id="balance" type="number" name="balance"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-6">
                                                    <label for="fees"
                                                           class="mr-sm-2">الرسوم </label>
                                                    <input id="fees" type="number" name="fees"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-6">
                                                    <label for="vehicle"
                                                           class="mr-sm-2">الشاحنة </label>
                                                    <select id="vehicle" name="vehicle"
                                                           class="form-control"
                                                            required>
                                                        @foreach($vehicle as $v)
                                                            @if (App::isLocale('en'))
                                                                <option value="{{$v->id}}">{{$v->nameEr}}</option>
                                                            @else
                                                                <option value="{{$v->id}}">{{$v->nameAr}}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-6">
                                                    <label for="model"
                                                           class="mr-sm-2">طراز السيارة </label>
                                                    <input id="model" type="text" name="model"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-6">
                                                    <label for="licenseNumber"
                                                           class="mr-sm-2"> رقم الرخصة </label>
                                                    <input id="licenseNumber" type="number" name="licenseNumber"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-6">
                                                    <label for="delivery"
                                                           class="mr-sm-2">طريقة التوصيل </label>
                                                    <select id="delivery" name="delivery"
                                                            class="form-control"
                                                            required>
                                                        @foreach($delivery as $d)
                                                            @if (App::isLocale('en'))
                                                                <option value="{{$d->id}}">{{$d->nameEn}}</option>
                                                            @else
                                                                <option value="{{$d->id}}">{{$d->nameAr}}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>

                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="personal" class="mr-sm-2">الصورة الشخصية</label>
                                                        <input type="file" name="personal" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                              data-height="70" />
                                                    </div>

                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="idPhoto" class="mr-sm-2">صورة الهوية</label>
                                                        <input type="file" name="idPhoto" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                              data-height="70" />
                                                    </div>

                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="licenseDriver" class="mr-sm-2">صورة رخصة السائق</label>
                                                        <input type="file" name="licenseDriver" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                              data-height="70" />
                                                    </div>

                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="carPhoto" class="mr-sm-2">صورة السيارة</label>
                                                        <input type="file" name="carPhoto" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                              data-height="70" />
                                                    </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <label for="licenseCar" class="mr-sm-2">صورة رخصة السيارة</label>
                                                        <input type="file" name="licenseCar" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                              data-height="70" />
                                                    </div>

                                            <br><br>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">أغلاق</button>
                                                <button type="submit" class="btn btn-success">أضافة</button>
                                            </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end add_modal_drivers -->

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

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Owl Carousel js-->
    <script src="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.js')}}"></script>
    <!---Internal  Multislider js-->
    <script src="{{URL::asset('assets/plugins/multislider/multislider.js')}}"></script>
    <script src="{{URL::asset('assets/js/carousel.js')}}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>

@endsection

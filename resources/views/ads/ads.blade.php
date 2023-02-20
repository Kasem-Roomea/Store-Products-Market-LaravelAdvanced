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
       الأعلانات
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الأعلانات</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate ads  -->
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
    <!-- end action validate ads -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-primary btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                أضافة أعلان جديد
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
                                                <th> العنوان </th>
                                                <th >تاريخ البداية</th>
                                                <th >تاريخ النهاية</th>
                                                <th > وقت الأنشاء</th>
                                                <th > الحالة</th>
                                                <th >العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($ads as $x)
                                                <?php $i++ ; ?>
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>
                                                        @if (App::isLocale('en'))
                                                            {{$x->titleEn}}
                                                        @else
                                                            {{$x->titleAr}}
                                                        @endif
                                                    </td>
                                                    <td>{{$x->startAt}}</td>
                                                    <td>{{$x->endAt}}</td>
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



                                                <!-- start delete_modal_ads -->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف الأعلان
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('ads.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد حذف الأعلان؟
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
                                                <!--end  delete_modal_ads -->

                                                <!-- start details_modal_ads-->
                                                <div class="modal fade" id="details{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تفاصيل الأعلان
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
                                                                                    <h6 class="card-title mb-1">صورة الأعلان </h6>
                                                                                </div>
                                                                                <div class="">
                                                                                    <div class="carousel slide" data-ride="carousel" id="carouselExampleSlidesOnly">
                                                                                        <div class="carousel-inner">
                                                                                            <div class="carousel-item active">
                                                                                                <img alt="img" class="d-block w-100 op-3" src="{{URL::asset('Attachments/ads/'.$x->titleEn.'/'.$x->image)}}">
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
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2"> العنوان بالعربي:  </label><span>{{$x->titleAr}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   العنوان بالأنكليزي :  </label><span> {{$x->titleEn}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  عدد المشاهدات:  </label> <span>{{$x->viewers}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  تاريخ البداية:  </label> <span>{{$x->startAt}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  تاريخ النهاية:  </label> <span>{{$x->endAt}}</span></li>


                                                                        @if($x->screen == 'categories')
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   مكان الأعلان في التطبيق:  </label><span>شاشة الاقسام الرئيسية</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  القسم الرئيسي:  </label><span>{{$x->nameCategoriesAds->nameEn??''}}</span></li>
                                                                        @elseif($x->screen == 'stores')
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   مكان الأعلان في التطبيق:  </label><span>شاشة  المتجر</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  المتجر :  </label><span>{{$x->nameStoresAds->name}}</span></li>
                                                                        @elseif($x->screen == 'offer')
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   مكان الأعلان في التطبيق:  </label><span>شاشة العروض</span></li>
                                                                         @else
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   مكان الأعلان في التطبيق:  </label><span>الشاشة الرئيسية</span></li>
                                                                        @endif




                                                                        @if($x->action == 'categories')
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   مكان توجيه الأعلان في التطبيق:  </label> <span>شاشة الاقسام الفرعية</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  القسم الفرعي :  </label>
                                                                                <span>
                                                                                    @if (App::isLocale('en'))
                                                                                        {{$x->nameCategoriesActionAds->nameEn??''}}
                                                                                    @else
                                                                                        {{$x->nameCategoriesActionAds->nameAr??''}}
                                                                                    @endif
                                                                                </span>
                                                                            </li>
                                                                        @elseif($x->action == 'stores')
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   مكان توجيه الأعلان في التطبيق:  </label> <span>شاشة المتاجر</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  المتجر :  </label><span>{{$x->nameStoresActionAds->name}}</span></li>
                                                                        @elseif($x->action == 'link')
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   مكان توجيه الأعلان في التطبيق:  </label> <span>مصدر خارجي</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  الرابط :  </label><a href="{{$x->link}}">أنقر هنا</a></li>
                                                                        @elseif($x->action == 'products')
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   مكان توجيه الأعلان في التطبيق:  </label> <span>شاشة المنتجات</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   المنتج:</label>
                                                                                <span>
                                                                                    @if (App::isLocale('en'))
                                                                                        {{$x->nameProductActionAds->nameEn??''}}
                                                                                    @else
                                                                                        {{$x->nameProductActionAds->nameAr??''}}
                                                                                    @endif
                                                                                </span>
                                                                            </li>
                                                                        @endif

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--end  details_delete_modal_ads -->

                                                <!-- start edit_modal_ads -->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل  الأعلان
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ url('ads/update') }}" method="POST" enctype="multipart/form-data">
                                                                    {{method_field('patch')}}
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label for="titleEn" class="mr-sm-2">العنوان بالانكليزي</label>
                                                                            <input id="titleEn" type="text" name="titleEn"
                                                                                   class="form-control"
                                                                                   required value="{{$x->titleEn}}">
                                                                            <input type="hidden" id="id"  name="id" value="{{$x->id}}">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="titleAr" class="mr-sm-2">العنوان بالعربي</label>
                                                                            <input id="titleAr" type="text" name="titleAr"
                                                                                   class="form-control"
                                                                                   required value="{{$x->titleAr}}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="startAt" class="mr-sm-2">تاريخ البداية</label>
                                                                            <input id="startAt" type="date" name="startAt"
                                                                                   class="form-control"
                                                                                   required value="{{$x->startAt}}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="endAt" class="mr-sm-2">تاريخ النهاية</label>
                                                                            <input id="endAt" type="date" name="endAt"
                                                                                   class="form-control"
                                                                                   required value="{{$x->endAt}}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="screen_edit" class="mr-sm-2">مكان ظهور الأعلان في التطبيق</label>
                                                                            <select id='screen_edit' class="form-control screen_edit" name="screen">
                                                                                <option value="{{$x->screen}}" selected>
                                                                                    @if($x->screen=='welcome')
                                                                                        الشاشة الرئيسية
                                                                                    @elseif($x->screen=='categories')
                                                                                        شاشة الأقسام الرئيسية
                                                                                    @elseif($x->screen=='offer')
                                                                                        شاشة العروض
                                                                                    @else
                                                                                        شاشة المتاجر
                                                                                    @endif
                                                                                </option>
                                                                                <option value="welcome">الشاشة الرئيسية</option>
                                                                                <option value="categories">شاشة الأقسام الرئيسية </option>
                                                                                <option value="offer">شاشة العروض</option>
                                                                                <option value="stores">شاشة المتاجر</option>
                                                                            </select>
                                                                        </div>

                                                                            <div class="col-12 stores_select_edit">
                                                                                <label for="stores_id" class="mr-sm-2">المتجر</label>
                                                                                <select id='stores_id' class="form-control" name="stores_id">
                                                                                    @if($x->stores_id != null)
                                                                                    <option value="{{$x->nameStoresAds->id}}" selected disabled>{{$x->nameStoresAds->name}}</option>
                                                                                    @endif
                                                                                    @foreach($stores as $s)
                                                                                        <option value="{{$s->id}}">{{$s->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-12 categories_select_edit">
                                                                                <label for="categories_id" class="mr-sm-2">القسم الرئيسي </label>
                                                                                <select id='categories_id' class="form-control" name="categories_id">
                                                                                    @if($x->categories_id  != null)
                                                                                    <option value="{{$x->nameCategoriesAds->id}}" selected disabled>
                                                                                        @if (App::isLocale('en'))
                                                                                            {{$x->nameCategoriesAds->nameEn}}
                                                                                        @else
                                                                                            {{$x->nameCategoriesAds->nameAr}}
                                                                                        @endif
                                                                                    </option>
                                                                                    @endif

                                                                                    @foreach($categories as $c)
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





                                                                        <div class="col-12" >
                                                                            <label for="action_edit" class="mr-sm-2">مكان توجيه الأعلان في التطبيق</label>
                                                                            <select id='action_edit' class="form-control action_edit" name="action">
                                                                                <option value="{{$x->action}}" selected >
                                                                                    @if($x->action=='link')
                                                                                        مصدر خارجي
                                                                                    @elseif($x->action=='categories')
                                                                                        قسم فرعي
                                                                                    @elseif($x->action=='products')
                                                                                        منتج
                                                                                    @else
                                                                                        متجر
                                                                                    @endif
                                                                                </option>
                                                                                <option value="link">مصدر خارجي</option>
                                                                                <option value="categories">قسم فرعي</option>
                                                                                <option value="products">منتج</option>
                                                                                <option value="stores">متجر</option>

                                                                            </select>
                                                                        </div>


                                                                            <div class="col-12 link_select_edit">
                                                                                <label for="link" class="mr-sm-2">الرابط</label>
                                                                                <input id="link" type="text" name="link"
                                                                                       class="form-control"
                                                                                        value="{{$x->link}}">
                                                                            </div>

                                                                            <div class="col-12 categories_part_select_edit">
                                                                                <label for="action_categories_id" class="mr-sm-2">القسم الفرعي </label>
                                                                                <select id='action_categories_id' class="form-control" name="action_categories_id">
                                                                                    @if($x->action_categories_id != null)
                                                                                    <option value="{{$x->nameCategoriesActionAds->id}}"  selected >
                                                                                        @if (App::isLocale('en'))
                                                                                            {{$x->nameCategoriesActionAds->nameEn}}
                                                                                        @else
                                                                                            {{$x->nameCategoriesActionAds->nameAr}}
                                                                                        @endif
                                                                                    </option>
                                                                                    @endif
                                                                                    @foreach($categories_part as $c)
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

                                                                            <div class="col-12 stores_select2_edit">
                                                                                <label for="action_stores_id" class="mr-sm-2">المتجر</label>
                                                                                <select id='action_stores_id' class="form-control" name="action_stores_id">
                                                                                    @if($x->action_stores_id  != null)
                                                                                    <option value="{{$x->nameStoresActionAds->id}}">{{$x->nameStoresActionAds->name}}</option>
                                                                                    @endif
                                                                                    @foreach($stores as $s)
                                                                                        <option value="{{$s->id}}">{{$s->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                        <div class="col-12 products_select_edit">
                                                                            <label for="action_products_id" class="mr-sm-2">المنتج</label>
                                                                            <select id='action_products_id' class="form-control" name="action_products_id">
                                                                                @if($x->action_products_id  != null)
                                                                                    <option value="{{$x->nameProductActionAds->id}}">
                                                                                        @if (App::isLocale('en'))
                                                                                            {{$x->nameProductActionAds->nameEn}}
                                                                                        @else
                                                                                            {{$x->nameProductActionAds->nameAr}}
                                                                                        @endif
                                                                                    </option>
                                                                                @endif
                                                                                @foreach($products as $p)
                                                                                    <option value="{{$p->id}}">
                                                                                        @if (App::isLocale('en'))
                                                                                            {{$c->nameEn}}
                                                                                        @else
                                                                                            {{$c->nameAr}}
                                                                                        @endif
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>


                                                                        <div class="col-12">
                                                                            <label for="isActive"
                                                                                   class="mr-sm-2">الحالة </label>
                                                                            <select id="isActive" name="isActive"
                                                                                    class="form-control"
                                                                                    required>

                                                                                @if($x->isActive==0)
                                                                                    <option value=0 >معطل</option>
                                                                                @elseif($x->isActive==1)
                                                                                    <option value=1 >مفعل</option>
                                                                                @endif
                                                                                <option value=0>معطل</option>
                                                                                <option value=1>مفعل</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-12">
                                                                            <label for="image" class="mr-sm-2"> صورة للأعلان</label>
                                                                            <input type="file" name="image" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                   data-height="70"  />
                                                                        </div>
                                                                    </div>
                                                                        <br><br>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                                                            <button type="submit" class="btn btn-info">تعديل البيانات</button>
                                                                        </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end edit_modal_ads -->




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
                                            أضافة اعلان جديد
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                <div class="col-12">
                                                    <label for="titleEn" class="mr-sm-2">العنوان بالانكليزي</label>
                                                    <input id="titleEn" type="text" name="titleEn"
                                                           class="form-control"
                                                           required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="titleAr" class="mr-sm-2">العنوان بالعربي</label>
                                                    <input id="titleAr" type="text" name="titleAr"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="startAt" class="mr-sm-2">تاريخ البداية</label>
                                                    <input id="startAt" type="date" name="startAt"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="endAt" class="mr-sm-2">تاريخ النهاية</label>
                                                    <input id="endAt" type="date" name="endAt"
                                                           class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="screen" class="mr-sm-2">مكان ظهور الأعلان في التطبيق</label>
                                                    <select id='screen' class="form-control" name="screen">
                                                        <option value="welcome">الشاشة الرئيسية</option>
                                                        <option value="categories">شاشة الأقسام الرئيسية </option>
                                                        <option value="offer">شاشة العروض</option>
                                                        <option value="stores">شاشة المتاجر</option>
                                                    </select>
                                                </div>

                                                <div class="col-12" id="categories_select">
                                                    <label for="categories_id" class="mr-sm-2">القسم الرئيسي </label>
                                                    <select id='categories_id' class="form-control" name="categories_id">
                                                        @foreach($categories as $c)
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

                                                <div class="col-12" id="stores_select">
                                                    <label for="stores_id" class="mr-sm-2">المتجر</label>
                                                    <select id='stores_id' class="form-control" name="stores_id">
                                                        @foreach($stores as $s)
                                                            <option value="{{$s->id}}">{{$s->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="col-12" >
                                                    <label for="action" class="mr-sm-2">مكان توجيه الأعلان في التطبيق</label>
                                                    <select id='action' class="form-control" name="action">
                                                        <option>اختر مكان التوجيه</option>
                                                        <option value="link">مصدر خارجي</option>
                                                        <option value="categories">قسم فرعي</option>
                                                        <option value="products">منتج</option>
                                                        <option value="stores">متجر</option>
                                                    </select>
                                                </div>

                                                <div class="col-12" id="categories_part_select">
                                                    <label for="action_categories_id" class="mr-sm-2">القسم الفرعي </label>
                                                    <select id='action_categories_id' class="form-control" name="action_categories_id">
                                                        @foreach($categories_part as $c)
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

                                                <div class="col-12" id="stores_select2">
                                                    <label for="action_stores_id" class="mr-sm-2">المتجر</label>
                                                    <select id='action_stores_id' class="form-control" name="action_stores_id">
                                                        @foreach($stores as $s)
                                                            <option value="{{$s->id}}">{{$s->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-12" id="products_select">
                                                    <label for="action_products_id" class="mr-sm-2">المنتج</label>
                                                    <select id='action_products_id' class="form-control" name="action_products_id">
                                                        @foreach($products as $p)
                                                            <option value="{{$p->id}}">
                                                                @if (App::isLocale('en'))
                                                                    {{$c->nameEn}}
                                                                @else
                                                                    {{$c->nameAr}}
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-12" id="link_select">
                                                    <label for="link" class="mr-sm-2">الرابط</label>
                                                    <input id="link" type="text" name="link"
                                                           class="form-control">
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <label for="image" class="mr-sm-2">أضافة صورة للأعلان</label>
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
            $('#products_select').hide();


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
                    $('#products_select').hide();
                }

                else if($(this).val() == 'link')
                {
                    $('#link_select').show();
                    $('#categories_part_select').hide();
                    $('#stores_select2').hide();
                    $('#products_select').hide();
                }
                else if($(this).val() == 'stores')
                {
                    $('#link_select').hide();
                    $('#categories_part_select').hide();
                    $('#stores_select2').show();
                    $('#products_select').hide();
                }
                else if($(this).val() == 'products')
                {
                    $('#link_select').hide();
                    $('#categories_part_select').hide();
                    $('#stores_select2').hide();
                    $('#products_select').show();
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
            $('.products_select_edit').hide();


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
                    $('.products_select_edit').hide();

                }

                else if($(this).val() == 'link')
                {
                    $('.link_select_edit').show();
                    $('.categories_part_select_edit').hide();
                    $('.stores_select2_edit').hide();
                    $('.products_select_edit').hide();

                }
                else if($(this).val() == 'stores')
                {
                    $('.link_select_edit').hide();
                    $('.categories_part_select_edit').hide();
                    $('.stores_select2_edit').show();
                    $('.products_select_edit').hide();

                }
                else if($(this).val() == 'products')
                {
                    $('.link_select_edit').hide();
                    $('.categories_part_select_edit').hide();
                    $('.stores_select2_edit').hide();
                    $('.products_select_edit').show();
                }
            });
        });


    </script>


@endsection

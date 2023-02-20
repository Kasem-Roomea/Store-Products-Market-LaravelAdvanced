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
       المننتجات
@stop
@section('page-header')
				<!-- start header -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المننتجات</h4>
						</div>
					</div>
				</div>
				<!-- end header -->
@endsection
@section('content')
    <!-- start action validate products  -->
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
    <!-- end action validate products -->


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">


                                    <div class="card-header pb-0">
                                        <div class="d-flex ">
                                            <button type="button" class="modal-effect btn btn-outline-primary btn-blockx-small ml-4" data-toggle="modal" data-target="#exampleModal">
                                                أضافة منتج جديد
                                            </button>

                                               <a class="modal-effect btn btn-outline-success btn-blockx-small ml-4" href="{{url('Products/export')}}" style="horiz-align: center">
                                                تصدير البيانات
                                             </a>


                                            <form action="{{url('Products/import')}}" method="POST" enctype="multipart/form-data" >
                                                @csrf
                                                    <input type="file" name="products_file" class="dropify" data-height="70" required />
                                                <button class="modal-effect btn btn-outline-indigo btn-blockx-small w-100"  type="submit">استيراد بيانات</button>
                                            </form>

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
                                                <th> الباركود </th>
                                                <th >المنتج</th>
                                                <th>الوصف</th>
                                                <th >الكمية</th>
                                                <th>السعر</th>
                                                <th>الصورة</th>
                                                <th class="col-1" >القسم التابع له</th>
                                                <th >الحالة</th>
                                                <th  >العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0 ;?>
                                            @foreach($products as $x)
                                                <?php $i++ ; ?>
                                                <tr class="text-center">
                                                    <td>{{$i}}</td>
                                                    <td>{{$x->ID_}}</td>
                                                    <td>
                                                        @if (App::isLocale('en'))
                                                            {{$x->nameEn}}
                                                        @else
                                                            {{$x->nameAr}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (App::isLocale('en'))
                                                            {{$x->descriptionEn}}
                                                        @else
                                                            {{$x->descriptionAr}}
                                                        @endif
                                                    </td>
                                                    <td>{{$x->quantity}}</td>
                                                    <td>{{$x->price}}</td>
                                                    <td>
                                                        @if(isset($x->images->first()->image) && !empty($x->images->first()->image))
                                                        <img style="height:100px;width:100px" src="{{URL::asset('Attachments/products/'.$x->ID_.'/'.$x->images->first()->image)}}">
                                                            @else
                                                            <img style="height:100px;width:100px" src="" alt="image">
                                                        @endif
                                                    </td>
                                                        <td>
                                                            @if (App::isLocale('en'))
                                                                {{$x->nameCategoriesProduct->nameEn??""}}
                                                            @else
                                                                {{$x->nameCategoriesProduct->nameAr??""}}
                                                            @endif
                                                        </td>


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

                                                <!-- start edit_modal_products-->
                                                <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تعديل المنتج
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--edit form -->
                                                                <form action="{{ route('products.update', 'test') }}" method="POST" enctype="multipart/form-data" >
                                                                    {{ method_field('patch') }}
                                                                    @csrf
                                                                    <div class="row">

                                                                        <div class="col-12">
                                                                            <label for="ID_" class="mr-sm-2">الباركود</label>
                                                                            <input id="ID_" type="number" name="ID_" class="form-control" value="{{$x->ID_}}" required>
                                                                            <input id="id" type="hidden" name="id" class="form-control"
                                                                                   value="{{ $x->id }}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="nameEn" class="mr-sm-2">الأسم بالانكليزي</label>
                                                                            <input id="nameEn" type="text" name="nameEn" class="form-control" value="{{$x->nameEn}}" required>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="nameAr" class="mr-sm-2">الأسم بالعربي</label>
                                                                            <input id="nameAr" type="text" name="nameAr" class="form-control" value="{{$x->nameAr}}" required >
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="descriptionEn" class="mr-sm-2">الوصف بالانكليزي</label>
                                                                            <input id="descriptionEn" type="text" name="descriptionEn" class="form-control" value="{{$x->descriptionEn}}">
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="descriptionAr" class="mr-sm-2">الوصف بالعربي</label>
                                                                            <input id="descriptionAr" type="text" name="descriptionAr" class="form-control" value="{{$x->descriptionAr}}" >
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="quantity" class="mr-sm-2">الكمية</label>
                                                                            <input id="quantity" type="number" name="quantity" class="form-control" value="{{$x->quantity}}" required>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="price" class="mr-sm-2">سعر البيع</label>
                                                                            <input id="price" type="number" name="price" class="form-control" value="{{$x->price}}" required>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label for="points" class="mr-sm-2">النقاط</label>
                                                                            <input id="points" type="number" name="points" class="form-control" value="{{$x->points}}" required>
                                                                        </div>

                                                                        <div class="col-12" >
                                                                            <label for="stores_id" class="mr-sm-2">المتجر </label>
                                                                            <select id='stores_id' type="text" class="form-control" name="stores_id">
                                                                                <option value="{{$x->nameStoresProduct->id}}" >{{$x->nameStoresProduct->name}}</option>
                                                                            @foreach($stores as $s)
                                                                                    <option value="{{$s->id}}" >{{$s->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-12" >
                                                                            <label for="categories_id" class="mr-sm-2">القسم التابع له </label>
                                                                            <select id='categories_id'  class="form-control" name="categories_id">
                                                                                <option value="{{$x->nameCategoriesProduct->id}}" >
                                                                                    @if (App::isLocale('en'))
                                                                                        {{$x->nameCategoriesProduct->nameEn}}
                                                                                    @else
                                                                                        {{$x->nameCategoriesProduct->nameAr}}
                                                                                    @endif
                                                                                </option>

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
                                                                        <div class="col-12">
                                                                            <label for="isFreeDelivered" class="mr-sm-2 ml-3">توصيل مجاني</label>
                                                                            @if($x->isFreeDelivered == 1)
                                                                                <input class="form-check-input" type="checkbox" name="isFreeDelivered" checked>
                                                                            @else
                                                                                <input class="form-check-input" type="checkbox" name="isFreeDelivered">
                                                                            @endif
                                                                        </div>
                                                                        <br>

                                                                            <div class="col-12 offers_check"  id="offers_check">
                                                                                <label for="offers" class="mr-sm-2 ml-3">عرض</label>
                                                                                <input class="form-check-input " type="checkbox" id="offers" name="offers"
                                                                                       @if($x->discount != 0)
                                                                                        checked
                                                                                        @endif
                                                                                >
                                                                            </div>

                                                                            <div class="col-12 offers_discount"  id="offers_discount">
                                                                                <label for="discount" class="mr-sm-2" >نسبة الخصم </label>
                                                                                <input id="discount" type="number" name="discount" class="form-control" value="{{$x->discount??''}}">
                                                                            </div>

                                                                            <div class="col-12 offers_start_date"  id="offers_start_date">
                                                                                <label for="startAt" class="mr-sm-2"> تاريخ البداية </label>
                                                                                <input id="startAt" type="date" name="startAt" class="form-control" value="{{$x->start_at_offer??''}}">
                                                                            </div>

                                                                            <div class="col-12 offers_end_date"  id="offers_end_date">
                                                                            <label for="endAt" class="mr-sm-2">تاريخ النهاية </label>
                                                                            <input id="endAt" type="date" name="endAt" class="form-control" value="{{$x->end_at_offer??''}}">
                                                                        </div>




                                                                        <br>
                                                                        <div class="col-sm-12 col-md-12">
                                                                            <label for="image" class="mr-sm-2">صورة المنتج </label>
                                                                            <input type="file" name="image" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                   data-height="70" />
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
                                                <!-- end edit_modal_products-->

                                                <!-- start delete_modal_products -->
                                                <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    حذف المنتج
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('products.destroy', 'test') }}" method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    هل تريد حذف المنتج؟
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
                                                <!--end  delete_modal_products -->

                                                <!-- start details_modal_products-->
                                                <div class="modal fade" id="details{{ $x->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                    id="exampleModalLabel">
                                                                    تفاصيل المنتج
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="card" style="width:100%;">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  الباركود:  </label><span>{{$x->ID_}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2"> الاسم بالعربي:  </label><span>{{$x->nameAr}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   الاسم بالأنكليزي :  </label><span> {{$x->nameEn}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   الوصف بالعربي :  </label><span> {{$x->descriptionAr}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   الوصف بالأنكليزي :  </label><span> {{$x->descriptionEn}}</span></li>
                                                                        @if($x->isFreeDelivered != 0)
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  التوصيل المجاني  :  </label> <span>مدعوم</span></li>
                                                                        @else
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">  التوصيل المجاني  :  </label> <span>غير مدعوم</span></li>
                                                                         @endif
                                                                        @if($x->stres_id != Null)
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   المتجر:  </label> <span>{{$x->nameStoresProduct->name}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">   هاتف المتجر:  </label> <span>{{$x->nameStoresProduct->phone}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">    البريد الألكتروني للمتجر:  </label> <span>{{$x->nameStoresProduct->email}}</span></li>
                                                                        @endif
                                                                        @if($x->start_at_offer != Null)
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      عرض:  </label> <span>موجود</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      تاريخ بداية العرض:  </label> <span>{{$x->start_at_offer}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      تاريخ نهاية العرض:  </label> <span>{{$x->end_at_offer}}</span></li>
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      نسبة الخصم :  </label> <span>{{$x->discount}}</span></li>
                                                                        @else
                                                                            <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      عرض:  </label> <span>غير موجود</span></li>
                                                                        @endif
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      النقاط:  </label> <span>{{$x->points}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">      تكلفة المنتج:  </label> <span>{{$x->price}}</span></li>
                                                                        <li class="list-group-item"><label class="mr-sm-2 text-success ml-2">       تاريخ أدخال االمنتج :  </label> <span>{{$x->createdAt}}</span></li>
                                                                    </ul>
                                                                </div>

                                                                  </div>








                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--end  details_modal_products -->


                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{ $products->links() }}
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
                                            أضافة منتج جديد
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- add_form -->
                                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" >
                                            @csrf
                                            <div class="row">

                                                <div class="col-12">
                                                    <label for="ID_" class="mr-sm-2">الباركود</label>
                                                    <input id="ID_" type="number" name="ID_" class="form-control" required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="nameEn" class="mr-sm-2">الأسم بالانكليزي</label>
                                                    <input id="nameEn" type="text" name="nameEn" class="form-control" required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="nameAr" class="mr-sm-2">الأسم بالعربي</label>
                                                    <input id="nameAr" type="text" name="nameAr" class="form-control" required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="descriptionEn" class="mr-sm-2">الوصف بالانكليزي</label>
                                                    <input id="descriptionEn" type="text" name="descriptionEn" class="form-control">
                                                </div>

                                                <div class="col-12">
                                                    <label for="descriptionAr" class="mr-sm-2">الوصف بالعربي</label>
                                                    <input id="descriptionAr" type="text" name="descriptionAr" class="form-control" >
                                                </div>

                                                <div class="col-12">
                                                    <label for="quantity" class="mr-sm-2">الكمية</label>
                                                    <input id="quantity" type="number" name="quantity" class="form-control" required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="price" class="mr-sm-2">سعر البيع</label>
                                                    <input id="price" type="number" name="price" class="form-control" required>
                                                </div>

                                                <div class="col-12">
                                                    <label for="points" class="mr-sm-2">النقاط</label>
                                                    <input id="points" type="number" name="points" class="form-control" required>
                                                </div>

                                                <div class="col-12" >
                                                    <label for="stores_id" class="mr-sm-2">المتجر </label>
                                                    <select id='stores_id' type="text" class="form-control" name="stores_id">
                                                        @foreach($stores as $s)
                                                            <option value="{{$s->id}}" >{{$s->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-12" >
                                                    <label for="categories_id" class="mr-sm-2">القسم التابع له </label>
                                                    <select id='categories_id'  class="form-control" name="categories_id">
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
                                                <br>
                                                <div class="col-12">
                                                    <label for="isFreeDelivered" class="mr-sm-2 ml-3">توصيل مجاني</label>
                                                    <input class="form-check-input" type="checkbox" name="isFreeDelivered">
                                                </div>
                                                <br>
                                                <div class="col-12"  id="offers_check">
                                                    <label for="offers" class="mr-sm-2 ml-3">عرض</label>
                                                    <input class="form-check-input " type="checkbox" id="offers" name="offers">
                                                </div>

                                                <div class="col-12"  id="offers_discount">
                                                    <label for="discount" class="mr-sm-2">نسبة الخصم </label>
                                                    <input id="discount" type="number" name="discount" class="form-control">
                                                </div>

                                                <div class="col-12"  id="offers_start_date">
                                                    <label for="startAt" class="mr-sm-2"> تاريخ البداية </label>
                                                    <input id="startAt" type="date" name="startAt" class="form-control">
                                                </div>

                                                <div class="col-12"  id="offers_end_date">
                                                    <label for="endAt" class="mr-sm-2">تاريخ النهاية </label>
                                                    <input id="endAt" type="date" name="endAt" class="form-control">
                                                </div>
                                                <br>
                                                <div class="col-sm-12 col-md-12">
                                                    <label for="image" class="mr-sm-2">صورة المنتج </label>
                                                    <input type="file" name="image" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                           data-height="70" />
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

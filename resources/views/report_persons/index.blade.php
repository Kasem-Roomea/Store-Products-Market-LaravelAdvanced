@extends ('dashboard.layouts.master')
@section('title', 'report_persons')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0">#البلاغات</h2>
        </div>

        <form class="mb-4" id="getOptions">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-row">
            <div class="m-2">
            <input type="search" class="form-control" placeholder="بحث" name="search">
          </div>
          <div class="m-2">
            <select class="custom-select" name="sortBy">
              <option selected disabled>ترتيب علي حسب</option>
              <option value="created_at">تاريخ الإنشاء</option>
              <option value="reports_types">نوع البلاغ</option>
            </select>
          </div>
          <div class="m-2">
            <select class="custom-select"  name="sortType">
              <option selected disabled>نوع الترتيب</option>
              <option value="sortBy">تصاعدياََ</option>
              <option value="sortByDesc">تنازلياََ</option>
            </select>
          </div>
          </div>
        </form>
      
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
              @include('dashboard.report_persons.tableInfo')
          </table>
        </div>
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
    </div>
      @include('dashboard.report_persons.viewModal')
      @include('dashboard.report_persons.addEditModal')
     
</div>
@push('script')
<script>
  $("body").on("click",".get-record",function(){
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      var data = record.users;
      for (var k in data) {
        if (data.hasOwnProperty(k)) {
          if(k.includes('image')  ){
            $(".carousel-item ."+k).attr("src",data[k]);
          }else{
            $(".list-group-item ."+k).html(data[k])
          }
        }
      }
      var data = record.reported_users;
      for (var k in data) {
        $(".reported_users ."+k).html(data[k])
      }
      
      $(".list-group-item .message").html(record['message'])
    });
  });
  $("body").on("click",".edit",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل General Room ");
    $(".addEdit-new-modal input[name='id']").val($(this).parents("tr").data("id"));
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      for (var k in record) {
        if (record.hasOwnProperty(k)) {
          if(k.includes('image')  ){
            if(record[k]){  
              $('#'+k).attr('src', record[k]).attr("hidden",false);
            }else{
              $('#'+k).attr("hidden",true);
            }
          }else if(k == 'password'){
            $(".addEdit-new-modal input[name='"+k+"']").val(null);
            continue;
          }else{
            $(".addEdit-new-modal input[name='"+k+"']").val(record[k]);
            $(".addEdit-new-modal select[name='"+k+"'] option[value='"+record[k]+"']").prop('selected', true);
          }
        }
      }
    });
  });
</script> 
@endpush
@endsection
        
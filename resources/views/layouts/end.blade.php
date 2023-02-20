</div>
<script src="{{asset('dashboard/jquery.js')}}"></script>
<script src="{{asset('dashboard/popper.min.js')}}"></script>
<script src="{{asset('dashboard/bootstrap.min.js')}}"></script>
<script src="{{asset('dashboard/vedors/tagsinput.js')}}"></script>
<script src="{{asset('dashboard/imageuploadify.min.js')}}"></script>
<script src="{{asset('dashboard/sweetAlert.min.js')}}"></script>
<script src="{{asset('dashboard/bootstrap-select.js')}}"></script>

<script>

    $(document).ready(function() {
        $(".loading-container").toggleClass("d-none d-flix");

        $('input[name="image[]"]').imageuploadify();

        $('#addEdit-new-modal #submit').on('click', function(e) {
            e.preventDefault();
            let form = $("#createUpdate");
            let url  = form.attr('action');
            let data = new FormData(form[0]);
            let resultOfFilter = document.getElementById('result-of-multi-select');
            resultOfFilter =  resultOfFilter == null ?  '' : resultOfFilter.innerHTML ;
            if(resultOfFilter.length > 0){
                data.append('resultOfFilter',resultOfFilter.replaceAll(' ', ''));
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.progress-bar').text(percentComplete + '%');
                            $('.progress-bar').css('width', percentComplete + '%');
                        }
                    }, false);
                      return xhr;
                },beforeSend: function(){
                        $(".addEdit-new-modal .submit").attr("disabled",true).append(` <i class="fas fa-cog fa-spin"></i>`);
                },
                success: function(response) {
                    $(".addEdit-new-modal .submit").attr("disabled",false).find("i").remove();
                    if(response.status!= 200 ){
                        $(".modal .alert").attr("hidden",false);
                        $(".alert").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"  >
                                <p >${response.message}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);

                    }else {
                        // $(".toast .toast-body").html(`
                        //     <i  class="fas fa-check-circle fa-2x"></i>
                        //     <span style="margin-right:100px;font-size:20px;font-weight:bold">
                        //         ${response.message}
                        //     </span>
                        // `);
                        // $(".toast").toast("show");
                        // setTimeout(function(){  $(".toast .toast-body").html(""); },  $(".toast ").data("delay"));
                        swal(response.message);
                        swal({
                            title: response.message,
                            icon: "success",
                            button: "Ok",
                        });

                        $(".modal .alert").attr("hidden",true).find("p").html("");
                        $('.progress-bar').text(0 + '%');
                        $('.progress-bar').css('width', 0 + '%');
                        getRecords($(".pagination .active").find("a").attr("href")??1);
                        form[0].reset();
                        $('#openImage').attr('src', "");
                        $("#addEdit-new-modal").modal("toggle")
                    }

                },
                error: function(response) {
                    $(".addEdit-new-modal .submit").attr("disabled",false);
                    $('#custom-message').show();
                    $('#custom-message ul').empty();
                    $('#custom-message').addClass('custom-message-error');
                    console.log(data.responseText);
                    $('#progressBar').text('0%');
                    $('#progressBar').css('width', '0%');
                }
            });
        });

        $("body").on("click", '.page-link', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var currentPage=$(this).attr("href");
            var currentPageActive=$(".pagination li.active a").attr("href");
            if(currentPage!= "#" && currentPageActive!= currentPage ){

                let formData = new FormData($('#getOptions')[0]);
                formData.append('currentPage',currentPage);
                formData.append('_token', $('input[name=_token]').val());
                $.ajax({
                    url: "{{route('dashboard.'.Request::segment(2).'.indexPageing')}}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".loading-container").toggleClass("d-none d-flix");
                    },
                    success: function(response) {
                        $(".loading-container").toggleClass("d-none d-flix");
                        $('.tableInfo').html(response.tableInfo);
                        $('.paging').html(response.paging);
                        changeLang();

                    },
                    error: function(response) {
                        $(".loading-container").toggleClass("d-none d-flix");
                        alert('error');
                    }
                });
            }

        });

        $( "select[name='sortBy'] ,select[name='sortType']").on("change",function(){
            getRecords(1);
        });


        $("body").on("click",".edit",function(){
            $(".modal .alert").attr("hidden",true).find("p").html("");
        });

        $(".add").on("click",function(){
            let form = $("#createUpdate");
            form[0].reset();
            form.find("input[name='image']").val('')
            $('.addEdit-new-modal img').attr('src', null).attr("hidden",true);
            $(".addEdit-new-modal .modal-title").html("إضافة جديد");
            $(".addEdit-new-modal input[name='id']").val(null);
        });


        search($('input[name="search"]'));


        $("body").on("click",'.slider-check-box input',function(e){
            let type= $(this).data('type');
            $.ajax({
                url: "/dashboard/{{Request::segment(2)}}/check/"+type+"/"+$(this).parents('tr').data("id"),
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                error: function(response) {
                    alert('error');
                }
            });
        });

        $( "input[name='isApproved']").on("click",function(){
            getRecords(1);
        });


        $(":file").change(function() {
            let input= this;
            let INPUT= $(this);
            if (this) {
                if(this.files[0].size>1048576000) {
                    alert('حجم الصورة اكبر من 1 ميجا ');
                    $(':file').val("");
                }else{
                    if (this.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                            $('#'+INPUT.data('image')).attr('src', e.target.result).attr("hidden",false);
                            $("input[name='"+INPUT.data('image')+"']").val( reader.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            }
            else {
                alert('يجب ادخال صورة حقيقية');
                $(':file').val("");
            }
        });

        permissions() ;

    });


    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;  //time in ms, 1 second for example

    //on keyup, start the countdown
   $("input[name='searchFor']").on('keyup', function () {
        clearTimeout(typingTimer);
        var $input = $(this);
        window.select = $input.parents(".form-group").find("select");
        window.model =$input.data("model");
        window.col =$input.data("col");
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //on keydown, clear the countdown
    $("input[name='searchFor']").on('keydown', function () {
        window.$input=$(this);
        clearTimeout(typingTimer);
    });

    $("input[name='searchFor']").on('search', function (e) {
        e.preventDefault();
        window.$input=$(this);
        doneTyping();
    });

    //user is "finished typing," do something
    function doneTyping () {
        getBySearch();
    }

    $("input[name='searchFor']").bind("paste", function(e){
        // access the clipboard using the api
        window.$input=$(this);
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    function getBySearch(){
        var select =  window.$input.parents(".form-group").find("select");
        var model =window.$input.data("model");
        var col =window.$input.data("col");
        $.ajax({
            url: "searchFor/"+window.model+"/"+window.col+"/"+ window.$input.val(),
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
            },
            success: function(response) {
                $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
                window.select.html(response);
            },
            error: function(response) {
                $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
                alert('error');
            }
        });
    }

    function search ($input){
            var typingTimer;                //timer identifier
            var doneTypingInterval = 1000;  //time in ms, 1 second for example

            //on keyup, start the countdown
            $input.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });

            //on keydown, clear the countdown
            $input.on('keydown', function () {
                clearTimeout(typingTimer);
            });

            $input.on('search', function (e) {
                e.preventDefault();
                doneTyping();
            });

            //user is "finished typing," do something
            function doneTyping () {
                getRecords(1);
            }

            $("input[name='search']").bind("paste", function(e){
                // access the clipboard using the api
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });
        }

    function getRecords(page){
        let formData = new FormData($('#getOptions')[0]);
            formData.append('currentPage',page);
            formData.append('_token', $('input[name=_token]').val());

            $.ajax({
                url: "{{route('dashboard.'.Request::segment(2).'.indexPageing')}}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".loading-container").toggleClass("d-none d-flix");
                },
                success: function(response) {
                    $(".loading-container").toggleClass("d-none d-flix");
                    $('.tableInfo').html(response.tableInfo);
                    $('.paging').html(response.paging);


                        //reports
                    if("{{Request::segment(2)}}" == "reports"){
                        $(".productPrice").html(response.productPrice.toFixed(2));
                        $(".deliveryPrice").html(response.deliveryPrice.toFixed(2));
                        $(".totalPrice").html(response.totalPrice.toFixed(2));
                        $(".driverFees").html(response.driverFees.toFixed(2));
                        $(".storeFees").html(response.storeFees.toFixed(2));
                        $(".totalDistance").html(response.totalDistance.toFixed(2));
                        $(".totalFees").html( (response.driverFees + response.storeFees).toFixed(2) );
                    }
                    changeLang();
                },
                error: function(response) {
                    $(".loading-container").toggleClass("d-none d-flix");
                    alert('error');
                }
            });

    }

    function permissions() {
        if("{{Auth::guard('dashboard')->check()}}"){
            if("{{Auth::guard('dashboard')->user()->isSuperAdmin??''}}" != "1"){
                var permissionsAuth = JSON.parse("{{Auth::guard('dashboard')->user()->permissions??''}}".replace(/&quot;/g, '\"'));
                for( var k in permissionsAuth){
                    if(permissionsAuth[k]['view']==0){
                        $("aside ."+k).addClass('d-none');
                    }
                    if( typeof(permissionsAuth["{{Request::segment(2)}}"]) !== 'undefined' && permissionsAuth["{{Request::segment(2)}}"]['add']==0){
                        $(".add").addClass('d-none');
                    }
                    if(typeof(permissionsAuth["{{Request::segment(2)}}"]) !== 'undefined' &&  permissionsAuth["{{Request::segment(2)}}"]['edit']==0){
                        $(" .edit").addClass('d-none');
                        $(" .slider-check-box input[type='checkbox']").attr('disabled',true);
                    }
                    if( typeof(permissionsAuth["{{Request::segment(2)}}"]) !== 'undefined' &&  permissionsAuth["{{Request::segment(2)}}"]['delete']==0){
                        $('[data-target="#delete-modal"]').addClass('d-none');
                    }
                }
            }

        }else if("{{Auth::guard('stores')->check()}}"){
            var storeModules= JSON.parse('{{json_encode(config("helperDashboard.closedModule"))}}'.replace(/&quot;/g, '\"'));
            console.log(storeModules);
            for( var k in storeModules){
                $("aside ."+k).addClass('d-none');
            }

        }
        }

</script>
@stack('script')
</body>
</html>
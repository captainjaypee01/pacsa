var protocol = window.location.protocol + "//";
var host = window.location.host;
var path = "/pacsa/"; 
var app_url = protocol + host + path; 


$(document).ready(function(){

    var page = 1;
    var url_user = app_url + "/backend/getUsers/";
    console.log(url_user);
    function load_user_data(page, search = null)
    {
        var url = url_user + page + (search ? "?search="+search : '');
        $.ajax({
            url: url,
            method:"GET",
            dataType:"json",
            success:function(response){
                if(response.success){
                    $('#user_table').html(response.userTable);
                    $('#pagination_link_user').html(response.pagination_link);
                }
                else{
                    $('#user_table').html(response.empty_message);
                }

                // console.log(response);
                // console.table(response);
            },
            error:function(response){
                console.log(response);
            }
        });
    }

    $("#frm-user-update").submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: app_url + "backend/updateUser",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response){
                console.log(response);
                if(response.success){
                    notify(response.message, "success");
                    setTimeout(() => {
                        window.location = "../user";
                    }, 1000);
                }
                else{
                    notify(response.message, "warning");
                }
            },
            error: function(response){
                console.log(response);
            }
        })
    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            // Get Image size
            // var fileInput = $(this).find("#imgInp")[0],
            //     file = fileInput.files && fileInput.files[0];
            var file = input.files && input.files[0];
            if( file ) {
                var img = new Image();

                img.src = window.URL.createObjectURL( file );

                img.onload = function() {
                    var width = img.naturalWidth,
                        height = img.naturalHeight;

                    window.URL.revokeObjectURL( img.src );

                    reader.onload = function(e) {
                        console.log(e);
                        $('#imagePayment').attr('src', e.target.result);
                        $("#blah").hide();
                        $("#imagePayment").show();
                        // $("#imagePayment").css('background-image','url('+ e.target.result + ')'); 
                        // $("#imagePayment").css('height',"350px");
                        // $("#imagePayment").css('width',"350px");
                    }
                    reader.readAsDataURL(input.files[0]);
                };
            }
            

        }
    }

    $(document).on("change", "#imgInp",function() {
        readURL(this);
    });

    
    $(document).on("click", "#pagination_link_user .pagination li a", function(event){
        event.preventDefault();
        page = $(this).data("ci-pagination-page"); 
    });

    $(document).on("keyup", "#txt-search-user", function(event){
        var s = $(this).val();
        load_user_data(page, s); 
    });

    
    load_user_data(page);

    function notify(title, type){
        swal({
            title: title,
            icon: type,
        });
    }
    
    function showError(id, message){
        if(message != ""){
            $("#error-"+id).show();
            $("#error-"+id).html(message);
        }
        else{
            $("#error-"+id).show();
            $("#error-"+id).html("");
        }
    }


});
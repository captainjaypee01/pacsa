
var protocol = window.location.protocol + "//";
var host = window.location.host;
var path = "/pacsa"; 
var app_url = protocol + host + path; 

    $(document).ready(function() {
       
        $("#school").keyup(function(e){
            var search = $(this).val();
            fetch_schools(search);
        });
        function fetch_schools(search = null){
            // console.log()
            $.ajax({
            
                type: "POST",
                url: app_url + "/frontend/fetch_schools",
                data: { search : search },
                dataType:"json",    
                success: function(response) {
                    var schools = response.schools;
                    $("#school-list").html(response.html);
                    // console.log(response);
                },
                error: function(response){
                    // console.log('hey');
                    console.log(response);
                }
            });
        }

        $("#frm-add-school").submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            console.log(formData);
            $.ajax({
                type: "POST",
                url: app_url + "/frontend/add_school",
                dataType: "json",
                data: formData ,
                success: function(response){ 

                    if(response.success)
                        swal({ title: response.message, icon: "success" });
                    else{
                        swal({ text: "Please Try Again!", icon: "warning"});
                    }
                    $("#frm-add-school").trigger("reset");
                    fetch_schools();
                    close_modals();
                },
                error: function(response){
                    console.log(response);
                }
            });
        });
        window.school_id = 0;
        $(document).on("click", ".btn-school", function(){
            var id = $(this).data("id");
            window.school_id = id;
            $("#school-id1").val(id);
            $("#section-school").hide();
            $("#section-type").show(); 
        });
        $(document).on("change", "input[name=is_batch]", function(){
            var val = $(this).val();
            
            $("#section-reg2").hide();
            if(val == 1){
                $("#batch-content").show();
                $("#section-reg1").hide();
            }
            else{
                $("#section-reg1").show();
                $("#batch-content").hide();
            } 
        });
        $("#no-delegates").keyup(function(e){
            
            var val = $(this).val(); ;

        });
        $("#btn-no-delegates").click(function(e){
            var val = $("#no-delegates").val();
            var school_id = window.school_id;
            
            if(val > 1){
                $.ajax({
                    type: "POST",
                    url: app_url + "/frontend/generateBatchForms",
                    data: { total_delegates : val, school_id : school_id},
                    dataType: "json",
                    beforeSend:function(){
                        $("#loading").show();
                    },
                    success: function(response){ 
                        
                        $("#loading").hide();
                        $("#section-reg2").show();
                        $("#section-reg2").html(response);
    
                    },
                    error: function(response){
                        console.log(response);
                    }
    
                });
                
                // $("#section-reg2").html(html);
            }
            else{
                swal({ text: "Number of Delegates must be greater than 1", icon: "warning"});
            }
        });

        $(document).on("submit","#frm-batch-registration", function(e){
            e.preventDefault();
            var formData = $(this).serialize(); 
            $.ajax({
                type: "POST",
                url: app_url + "/frontend/batch_registration",
                data: formData,
                beforeSend:function(){
                    $("#loading").show();
                },
                dataType: "json",
                success: function(response){
                    if(response.success){
                        swal({ title: response.message, icon: "success" });                    
                        $("#frm-batch-registration").trigger("reset");
                        resetAll();
                    }
                    else{
                        swal({ text: "Please Try Again!", icon: "warning"});
                    }
                    fetch_schools();
                }, 
                error: function(response){
                    console.log(response);
                }
            });
        });
        $("#frm-registration").submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize(); 
            $.ajax({
                type: "POST",
                url: app_url + "/frontend/individualRegister",
                data: formData,
                beforeSend:function(){
                    $("#loading").show();
                },
                dataType: "json",
                success: function(response){
                    
                    $("#loading").hide();
                    if(response.success){
                        swal({ title: response.message, icon: "success" });                    
                        $(this).trigger("reset");
                        resetAll();
                    }
                    else{
                        swal({ text: "Please Try Again!", icon: "warning"});
                    }
                    fetch_schools();
                }, 
                error: function(response){
                    console.log(response);
                }
            });
        });
        function close_modals(){
            var modals = $('.modal'); 
            for(var i = 0;i < modals.length;i++){ 
                $("#" + modals[i].id).modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            } 
        } 
        function resetAll(){
            
            $("#section-school").show();
            $("#school-id").val("");
            $("#section-type").hide();
            $("#section-reg1").hide();
            $("#section-reg2").html("");
        }
        fetch_schools();
    });

    
var btn_prev_reg = function(){
    $("#section-school").show();
    $("#section-type").hide();
    $("#school-id").val("");
    $("#section-reg1").hide();
    $("#section-reg2").html("");
}
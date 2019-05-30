
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
                $("#section-reg2").show();
                var html = `<form id="frm-batch-registration">`;
                for(var i = 0; i < val; i++){
                    html += `<div class="row justify-content-center align-items-center mt-5 mb-5">
                                <div class="col-md-6 col-sm-8 align-self-center">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <strong>
                                                Delegate ` + (i + 1) + `
                                            </strong>
                                        </div><!--card-header-->
                        
                                        <div class="card-body"> 
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" name="first_name[]" placeholder="First name" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" name="middle_name[]" placeholder="Middle name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" name="last_name[]" placeholder="Last name" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" name="email[]" placeholder="Email Address" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" name="contact[]" placeholder="Contact Number" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div> 
                    
                                            <div class="row">
                    
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h6 class="pl-2 form-label_w">Shirt Size</h6>
                                                        <select name="shirt_size[]" class="" required>
                                                            <option value=""></option>
                                                            <option value="XS">Extra Small</option>
                                                            <option value="S">Small</option>
                                                            <option value="M">Medium</option>
                                                            <option value="L">Large</option>
                                                            <option value="XL">Extra Large</option>
                                                        </select>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h6 class="form-label_w">Gender</h6>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="gender[` + i +`]" value="m">
                                                            <label class="form-check-label" for="gender">Male</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="gender[` + i +`]" value="f">
                                                            <label class="form-check-label" for="gender">Female</label>
                                                        </div> 
                                                    </div>
                                                </div>
                    
                                            </div>
                    
                                            <div class="row">
                    
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h6 class="pl-2 form-label_w">Delegate Type</h6>
                                                        <select name="delegate_type[]" id="delegate_type" class="" required>
                                                            <option value=""></option>
                                                            <option value="student">Student</option>
                                                            <option value="adviser">Adviser</option> 
                                                        </select>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h6 class="form-label_w">Is Head Delegate?</h6>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="is_head[` + i +`]" value="1">
                                                            <label class="form-check-label" for="is_head">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="is_head[` + i +`]" value="0">
                                                            <label class="form-check-label" for="is_head">No</label>
                                                        </div> 
                                                    </div>
                                                </div>
                    
                                            </div> 
                                        </div>
                                    </div>  
                                </div>
                            </div>`;
                }

                html += `
                
                    <input type="number" name="school_id" id="school_id2" value="`+ school_id + `" hidden>
                    <div class="row">
                        <div class="col mx-auto">
                            <button type="submit" class="btn btn-warning ">Submit</button>
                        </div>
                    </div>
                </form>`;
                $("#section-reg2").html(html);
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
            })
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
}
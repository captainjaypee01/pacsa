
<section class="section-wrapper">
    <div class="container-fluid">


        <div class="row justify-content-center align-items-center mt-5">
            <div class="col col-sm-8 align-self-center">
                <div class="card">
                    <div class="card-header text-center">
                        <strong>
                            Registration
                        </strong>
                    </div><!--card-header-->

                    <div class="card-body">
                        <div id="section-school">
                            <div class="row">
                                
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addSchoolModal">Add New School</button>
                                        <p class="text-muted" style="font-size: 8px;"> If you can't find your school, please click the button to add your school into the system</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="school">School</label>
                                        <input type="text" id="school" onchange="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="school-list">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display:none;" id="section-type">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-info btn-sm" onclick="btn_prev_reg()" id="btn-prev-reg">Back</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <h6 class="form-label_w">Registration Type</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_batch" value="0">
                                        <label class="form-check-label" for="is_batch">Individual</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_batch" value="1">
                                        <label class="form-check-label" for="is_batch">Batch</label>
                                    </div> 
                                </div>
                            </div>
                            <div class="row mt-3" style="display:none;" id="batch-content">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="number" placeholder="No. of Delegates" min="2" id="no-delegates" name="no_delegates" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-info btn-sm" id="btn-no-delegates">Submit</button>
                                </div>
                            </div>
                        </div> 

                    </div>

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center"  >
            <div class="spinner-grow text-warning" id="loading" style="width: 5rem; height: 5rem; display: none;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Individual Registration -->
        <div id="section-reg1" style="display: none; " class="row justify-content-center align-items-center mt-5 mb-5">
            <div class="col col-sm-8 align-self-center">
                <div class="card">
                    <div class="card-header text-center">
                        <strong>
                            Individual Delegate
                        </strong>
                    </div><!--card-header-->

                    <div class="card-body"> 
                        <form id="frm-registration">
                            <input type="text" name="school_id" id="school_id" value="0" hidden>
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="first_name" id="first_name" placeholder="First name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="middle_name" id="middle_name" placeholder="Middle name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="email" id="email" placeholder="Email Address" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="contact" id="contact" placeholder="Contact Number" class="form-control" required>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h6 class="pl-2 form-label_w">Shirt Size</h6>
                                        <select name="shirt_size" id="shirt_size" class="" required>
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
                                            <input class="form-check-input" type="radio" name="gender" value="m">
                                            <label class="form-check-label" for="gender">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="f">
                                            <label class="form-check-label" for="gender">Female</label>
                                        </div> 
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h6 class="pl-2 form-label_w">Delegate Type</h6>
                                        <select name="delegate_type" id="delegate_type" class="" required>
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
                                            <input class="form-check-input" type="radio" name="is_head" value="1">
                                            <label class="form-check-label" for="is_head">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_head" value="0">
                                            <label class="form-check-label" for="is_head">No</label>
                                        </div> 
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" name="submit-walk_in" id="submit-walk_in" class="btn btn-warning btn-sm float-right">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>

        <!-- Batch Registration -->
        <div id="section-reg2">
            

        </div> 

        <div class="modal fade " tabindex="-1" role="dialog" id="addSchoolModal" aria-labelledby="addSchoolModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add School Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm-add-school" method='post' name="frm_add_school">
                            <div class='container unpaid_wrapper py-3 px-3'>
                                
                                <div class='row'>
                                    <div class='col-md-6 col-sm-12'>
                                        <div class='form-group'>
                                            <h6 class='form-label_w'>School Name</h6>
                                            <input type='text' class='form-control' id='school_name' name='school_name' value='' placeholder="School Name">
                                        </div>
                                    </div>
                                    <div class='col-md-6 col-sm-12'>
                                        <div class='form-group'>
                                            <h6 class='form-label_w'>REGION</h6>
                                            <select name='region' id='region'>
                                                <option value='NCR'>NCR</option>
                                                <option value='LUZON' >LUZON</option>
                                                <option value='VISAYAS' >VISAYAS</option>
                                                <option value='MINDANAO' >MINDANAO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            
                                <button type='submit' class='btn btn-warning float-right'>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php //Prospectus Start

include "../authentication.php"; 
include "../config.php";


        if($_GET["action"] == "get_prospectus"){
        ?>
            <table id="example1" class="table table-bordered table-striped table-responsive-lg">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th>Prospectus No</th>
                        <th>Applicant Name</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th class="project-actions text-center">Action</th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                       $limit = 10;
                       if (isset($_GET["page"])) {
                           $page  = $_GET["page"];
                       } else {
                           $page = 1;
                       };

                       $start_from = ($page - 1) * $limit;
                       $s_no = $start_from + 1;

                        $sql = "SELECT * FROM `tbl_prospectus`
                                WHERE `status` = '$visible'
                                ORDER BY `id` DESC  LIMIT $start_from, $limit 
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                  <td><?php echo $s_no; ?></td>
                                  <td><?php echo $row["post_at"]; ?></td>
                                  <td><?php echo $row["prospectus_no"]; ?></td>
                                  <td><?php echo $row["prospectus_applicant_name"]; ?></td>
                                  <td><?php echo $row["prospectus_rate"]; ?></td>
                                  <td><?php 
                                        if($row["type"] == "enquiry")
                                            echo $row["post_at"];
                                        else
                                            echo $row["transaction_date"];
                                     ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_prospectus<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_prospectus<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Prospectus Edit Section Start -->
                                    <div id="edit_prospectus<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:55%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_prospectus<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Prospectus</h2>
                                            </header>
                                            <form id="edit_prospectus_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="row">
                                                       
                                                            <div class="col-4">
                                                              <label>Prospectus No.</label>
                                                              <input type="text" name="edit_prospectus_no" id="edit_prospectus_no<?php echo $row["id"]; ?>"  value="<?php echo $row["prospectus_no"]; ?>" class="form-control" required>
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Applicant Name</label>
                                                              <input type="text" name="edit_prospectus_applicant_name" id="edit_prospectus_applicant_name<?php echo $row["id"]; ?>" value="<?php echo $row["prospectus_applicant_name"]; ?>" class="form-control" required>  
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Gender</label>
                                                              <select  name="edit_prospectus_gender" id="edit_prospectus_gender<?php echo $row["id"]; ?>" class="form-control">  
                                                              <option value="<?php echo $row["prospectus_gender"]; ?>"><?php echo $row["prospectus_gender"]; ?></option>                      
                                                              <option value="Male">Male</option>
                                                              <option value="Female">Female</option>
                                                              </select>               
                                                            </div>
                                                             <div class="col-4">
                                                              <label>Father Name</label>
                                                               <input type="text" name="edit_prospectus_father_name" id="edit_prospectus_father_name<?php echo $row["id"]; ?>" value="<?php echo $row["prospectus_father_name"]; ?>" class="form-control">  
                                                            </div>
                                                          
                                                            <div class="col-4">
                                                              <label>Address</label>
                                                              <textarea name="edit_prospectus_address" id="edit_prospectus_address<?php echo $row["id"]; ?>" value="<?php echo $row["prospectus_address"]; ?>" class="form-control" style="height:38px;"><?php echo $row["prospectus_address"]; ?></textarea>  
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Country</label>
                                                              <select name="edit_prospectus_country"  id="edit_prospectus_country<?php echo $row["id"]; ?>" class="form-control">  
                                                              <option value="<?php echo $row["prospectus_country"]; ?>"><?php echo $row["prospectus_country"]; ?></option>                    
                                                              </select>  
                                                          </div>
                                                            <div class="col-4"> 
                                                              <label>State</label>
                                                              <input type="text" name="edit_prospectus_state" id="edit_prospectus_state<?php echo $row["id"]; ?>" value="<?php echo $row["prospectus_state"]; ?>" class="form-control" >  
                                                             <!-- <select id="edit_prospectus_state<?php echo $row["id"]; ?>" name="edit_prospectus_state"  class="form-control" >-->
                                                                <!--<option value="<?php echo $row["prospectus_state"]; ?>"><?php echo $row["prospectus_state"]; ?></option>-->
                                                                <!--</select>                 -->
                                                            </div>                                                    
                                                            <div class="col-4">   
                                                             <label>City</label>
                                                            <input type="text" name="edit_prospectus_city" id="edit_prospectus_city<?php echo $row["id"]; ?>" value="<?php echo $row["prospectus_city"]; ?>" class="form-control" >  
                                                            <!--<select id="edit_prospectus_city<?php echo $row["id"]; ?>" name="edit_prospectus_city"  class="form-control" >-->
                                                            <!--    <option value="<?php echo $row["prospectus_city"]; ?>"><?php echo $row["prospectus_city"]; ?></option>              -->
                                                            <!--    <option value="Jamshedpur">Jamshedpur</option>-->
                                                            <!--    <option value="Ranchi">Ranchi</option>-->
                                                            <!--    </select>-->
                                                                </div>                           
                                                          
                                                          <div class="col-4">
                                                              <label>Postal Code</label>
                                                              <input type="text" name="edit_prospectus_postal_code" id="edit_prospectus_postal_code<?php echo $row["id"]; ?>" value="<?php echo $row["prospectus_postal_code"]; ?>" class="form-control" >  
                                                            </div>
                                                           <div class="col-4">   
                                                             <label>Email ID</label>
                                                              <input type="email" name="edit_prospectus_emailid" id="edit_prospectus_emailid<?php echo $row["id"]; ?>" value="<?php echo $row["prospectus_emailid"]; ?>" class="form-control" required>             
                                                            </div>                           
                                                          
                                                          <div class="col-4">
                                                              <label>DOB</label>
                                                              <input type="date" name="edit_prospectus_dob" id="edit_prospectus_dob<?php echo $row["id"]; ?>" value="<?php echo $row["prospectus_dob"]; ?>" class="form-control" required>  
                                                            </div>
                                                            <div class="col-4">  
                                                             <label>Mobile No</label>
                                                              <input type="text" name="edit_mobile" id="edit_mobile<?php echo $row["id"]; ?>" value="<?php echo $row["mobile"]; ?>" class="form-control" required>                            
                                                          </div>
                                                          
                                                            <div class="col-4">
                                                              <label>Course</label>
                                                               <select name="edit_prospectus_course_name" id="edit_prospectus_course_name<?php echo $row["id"]; ?>" class="form-control select2" style="width: 100%;">
                                                                <?php 
                                                                $sql_course = "SELECT * FROM `tbl_course`
                                                                               WHERE `status` = '$visible'
                                                                               ";
                                                                $result_course = $con->query($sql_course);
                                                                while($row_course = $result_course->fetch_assoc()){
                                                                ?>
                                                                    <option value="<?php echo $row_course["course_id"]; ?>" <?php if($row_course["course_id"] == $row["prospectus_course_name"]) echo 'selected'; ?> ><?php echo $row_course["course_name"]; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Academic Year</label>
                                                               <select name="edit_prospectus_session" id="edit_prospectus_session<?php echo $row["id"]; ?>" class="form-control select2" style="width: 100%;">
                                                               <?php 
                                                                $sql_ac_year = "SELECT * FROM `tbl_university_details`
                                                                               WHERE `status` = '$visible';
                                                                               ";
                                                                $result_ac_year = $con->query($sql_ac_year);
                                                                while($row_ac_year = $result_ac_year->fetch_assoc()){
                                                                 ?>
                                                                    <option value="<?php echo $row_ac_year["university_details_id"]; ?>" <?php if($row_ac_year["university_details_id"] == $row["prospectus_session"]) echo 'selected'; ?> ><?php echo $row_ac_year["university_details_academic_start_date"]; ?> to <?php echo $row_ac_year["university_details_academic_end_date"]; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            </div>
                                                           <div class="col-4">  
                                                             <label>Prospectus Rate</label>
                                                              <input type="text" name="edit_prospectus_rate" value="<?php echo $row["prospectus_rate"]; ?>" id="edit_prospectus_rate<?php echo $row["id"]; ?>"  class="form-control" readonly>              
                                                            </div> 
                                                                            
                                                            <script>
                                                                function PaymentModeSelect<?php echo $row["id"]; ?>(PaymentMode){
                                                                    var bankName_div = document.getElementById('bankName_div<?php echo $row["id"]; ?>');
                                                                    var chequeNo_div = document.getElementById('chequeNo_div<?php echo $row["id"]; ?>');
                                                                    var receiptDate_div = document.getElementById('receiptDate_div<?php echo $row["id"]; ?>');
                                                                    if(PaymentMode == "Cash"){
                                                                        // cash_div.style.display = "block";
                                                                        bankName_div.style.display = "none";
                                                                        chequeNo_div.style.display = "none";
                                                                        receiptDate_div.style.display = "block";
                                                                    } else if(PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS"){
                                                                                bankName_div.style.display = "block";
                                                                                chequeNo_div.style.display = "block";
                                                                                receiptDate_div.style.display = "block";
                                                                            } else{
                                                                                bankName_div.style.display = "none";
                                                                                chequeNo_div.style.display = "none";
                                                                                receiptDate_div.style.display = "none";
                                                                            }
                                                                }
                                                            </script>
                                                            <div class="col-4">
                                                 <label>Payment Mode</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <select id="edit_prospectus_payment_mode<?php echo $row["id"]; ?>" name="edit_prospectus_payment_mode" class="form-control" onchange="PaymentModeSelect<?php echo $row["id"]; ?>(this.value);">
                                                              <option value="<?php echo $row["prospectus_payment_mode"]; ?>"><?php echo $row["prospectus_payment_mode"]; ?></option>
                                                              <option value="Cash">Cash</option>
                                                              <option value="Cheque">Cheque</option>
                                                              <option value="DD">DD</option>
                                                              <option value="Online">Online</option>
                                                              <option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
                                                          </select>
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <div class="col-4" id="bankName_div<?php echo $row["id"]; ?>" style="display:none">
                                                  <label>Bank Name</label>
                                                  <div class="form-group">
                                                      <div class="input-group"> 
                                                          <input id="edit_bank_name<?php echo $row["id"]; ?>" value="<?php echo $row["bank_name"]; ?>" name="edit_bank_name" type="text" class="form-control" />
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <div class="col-4" id="chequeNo_div<?php echo $row["id"]; ?>" style="display:none">
                                                  <label>Cheque/DD/NEFT No</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input name="edit_transaction_no" id="edit_transaction_no<?php echo $row["id"]; ?>" value="<?php echo $row["transaction_no"]; ?>" type="text" class="form-control" />
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <div class="col-4" id="receiptDate_div<?php echo $row["id"]; ?>" style="display:none">
                                                  <label>Cash/Cheque/DD/NEFT Date</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input name="edit_transaction_date" id="edit_transaction_date<?php echo $row["id"]; ?>" value="<?php echo $row["transaction_date"]; ?>" type="date" class="form-control" />
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                                          
                                                            <div class="form-group">
                                                           
                                                        </div>

                                                    </div>
                                                    <input type='hidden' name='edit_id' id="edit_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                    <input type='hidden' name='action' id="action<?php echo $row["id"]; ?>" value='edit_prospectus' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["id"]; ?>"></div>
                                                    <button type="button" id="edit_prospectus_button<?php echo $row["id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#edit_prospectus_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_prospectus_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["id"]; ?>").val();
                                                        var edit_id = $("#edit_id<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_no = $("#edit_prospectus_no<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_applicant_name = $("#edit_prospectus_applicant_name<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_gender = $("#edit_prospectus_gender<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_father_name = $("#edit_prospectus_father_name<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_address = $("#edit_prospectus_address<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_country = $("#edit_prospectus_country<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_state = $("#edit_prospectus_state<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_city = $("#edit_prospectus_city<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_postal_code = $("#edit_prospectus_postal_code<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_dob = $("#edit_prospectus_dob<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_emailid = $("#edit_prospectus_emailid<?php echo $row["id"]; ?>").val();
                                                        var edit_mobile = $("#edit_mobile<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_course_name = $("#edit_prospectus_course_name<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_session = $("#edit_prospectus_session<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_rate = $("#edit_prospectus_rate<?php echo $row["id"]; ?>").val();
                                                        var edit_prospectus_payment_mode = $("#edit_prospectus_payment_mode<?php echo $row["id"]; ?>").val();
                                                        var edit_bank_name = $("#edit_bank_name<?php echo $row["id"]; ?>").val();
                                                        var edit_transaction_no = $("#edit_transaction_no<?php echo $row["id"]; ?>").val();
                                                        var edit_transaction_date = $("#edit_transaction_date<?php echo $row["id"]; ?>").val();
                                                        
                                                        var dataString = 'action='+ action + '&edit_id='+ edit_id + '&edit_prospectus_no='+ edit_prospectus_no + 
                                                        '&edit_prospectus_applicant_name='+ edit_prospectus_applicant_name + '&edit_prospectus_gender='+ edit_prospectus_gender + '&edit_prospectus_father_name='+ edit_prospectus_father_name + '&edit_prospectus_address='+ edit_prospectus_address + '&edit_prospectus_country='+ edit_prospectus_country +'&edit_prospectus_state='+ edit_prospectus_state + '&edit_prospectus_city='+ edit_prospectus_city + '&edit_prospectus_postal_code='+ edit_prospectus_postal_code + '&edit_prospectus_dob=' + edit_prospectus_dob + '&edit_prospectus_emailid=' + edit_prospectus_emailid + '&edit_mobile=' + edit_mobile + '&edit_prospectus_course_name=' + edit_prospectus_course_name  + '&edit_prospectus_session=' + edit_prospectus_session + '&edit_prospectus_rate=' + edit_prospectus_rate + '&edit_prospectus_payment_mode=' + edit_prospectus_payment_mode + '&edit_bank_name=' + edit_bank_name + '&edit_transaction_no=' + edit_transaction_no + '&edit_transaction_date=' + edit_transaction_date;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#edit_response').remove();
                                                                if(result == "exsits"){
                                                                    $('#edit_error_section<?php echo $row["id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This No have already exsits!!!</div></div>');
                                                                }
                                                                if(result == "error"){
                                                                    $('#edit_error_section<?php echo $row["id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#edit_error_section<?php echo $row["id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out Prospectus No!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#edit_error_section<?php echo $row["id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i>  Updated successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_prospectus',
                                                                            type: 'GET',
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#edit_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#edit_prospectus_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Prospectus Edit Section End -->
                        
                                    <!-- Prospectus delete Section Start -->
                                    <div id="delete_prospectus<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_prospectus<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_prospectus_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_id' id="delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_prospectus' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="delete_prospectus_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_prospectus<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_prospectus_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_prospectus_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["id"]; ?>").val();
                                                        var delete_id = $("#delete_id<?php echo $row["id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_id='+ delete_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_prospectus',
                                                                            type: 'GET',
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#delete_prospectus_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Courses delete Section End -->
                                </tr>
                            <?php 
                                $s_no++;
                            }
                        } else
                            echo '
                                <div class="alert alert-warning alert-dismissible">
                                    <i class="icon fas fa-exclamation-triangle"></i>  No data available now!!!
                                </div>';
                    ?>
                </tbody>
            </table>
           
        <?php
        }
                //Prospectus End
        ?>

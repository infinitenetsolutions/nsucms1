
<?php
    //Starting Session
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "config.php";
    include "db_class.php";
    // Setting Time Zone in India Standard Timing
    $random_number = rand(111111,999999); // Random Number
    $s_no = 1; //Serial Number
    $visible = md5("visible");
    $trash = md5("trash");
    date_default_timezone_set("Asia/Calcutta");
    $date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
    //All File Directries Start
    $university_logos_dir = "../images/university_logos";
    $admission_profile_image_dir = "images/student_images";
    $certificates = "images/student_certificates";
    //Creating Object NSUNIV
    $objectDefault = new DBEVAL();
    $objectDefault->sql = "";
    $objectDefault->hostName = "";
    $objectDefault->password = "";
    $objectDefault->dbName =   "";
    $objectDefault->new_db("localhost", "nsucms_demo_nsuniv", "4rp5NsX7", "nsucms_demo_nsuniv");
    //Creating Object NSUCMS
    $objectSecond = new DBEVAL();
    $objectSecond->sql = "";
    $objectSecond->hostName = "";
    $objectSecond->userName = "";
    $objectSecond->password = "";
    $objectSecond->dbName =   "";
    $objectSecond->new_db("localhost", "nsucms_cms", "wpNnnOv5", "nsucms_cms");
    //All File Directries End
    if(isset($_GET["action"])){
    //Action Section Start
        /* ---------- All Admin(Backend) View Codes Start ---------- */
        
        /* ---------- All View Codes Start ------------------------- */
        //University Details Start
        if($_GET["action"] == "get_university_details"){
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Financial Year</th>
                        <th>Academic Year</th>
                        <th>Address </th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
                        $sql = "SELECT * FROM `tbl_university_details`
                                WHERE `status` = '$visible'
                                ORDER BY `university_details_id` DESC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <td><?php echo $row["university_details_university_name"]; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($row["university_details_financial_start_date"])); ?> To <?php echo date("d/m/Y", strtotime($row["university_details_financial_end_date"])); ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($row["university_details_academic_start_date"])); ?> To <?php echo date("d/m/Y", strtotime($row["university_details_academic_end_date"])); ?></td>
                                    <td><?php echo $row["university_details_address"]; ?>
                                        Phone :<?php echo $row["university_details_contact"]; ?>
                                        Email:<?php echo $row["university_details_email"]; ?></td>

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
            </table>
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //University Details End
      
      
      
      //Nsuniv Get Started Enquiry Start
    if ($_GET["action"] == "get_nsuniv-admission-enquiry") {
        $objectSecond->update("tbl_alert", "`get_started_enquiry` = '0' WHERE `id`='1'");
        $objectSecond->sql = "";
    ?>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Seleted Course</th>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Referred By</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Last Qualification</th>
                    <th>Timing</th>
                    <th class="project-actions text-center">Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $objectDefault->select("admission_enquiry_tbl");
                $objectDefault->where("`is_deleted` = '0' ORDER BY `id` DESC");
                $result = $objectDefault->get();
               
                if ($result->num_rows > 0) {
                    while ($row = $objectDefault->get_row()) {
                ?>
                        <tr>
                            <td><?php echo $s_no; ?></td>
                            <td><?php echo $row["admission_course"] ?></td>
                            <td><?php echo $row["admission_name"] ?></td>
                            <td><?php echo $row["admission_email"] ?></td>
                            <td><?php echo $row["admission_phone"] ?></td>
                            <td><?php echo $row["revert_by"] ?></td>
                            <td><?php echo $row["admission_state"] ?></td>
                            <td><?php echo $row["admission_city"] ?></td>
                            <td><?php echo $row["admission_last_qualify"] ?></td>
                            <td><?php echo $row["time"] ?></td>
                            <td class="project-actions text-center">
                                <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_university_get_enquiry<?php echo $row["id"]; ?>').style.display='block'">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </button>
                            </td>

                            <!-- Delete Section Start -->
                            <div id="delete_university_get_enquiry<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                    <header class="w3-container" style="background:#343a40; color:white;">
                                        <span onclick="document.getElementById('delete_university_get_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                        <h2 align="center">Are you sure???</h2>
                                    </header>
                                    <form id="delete_university_get_enquiry_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                        <div class="card-body">
                                            <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                            <div class="col-md-12" align="center">
                                                <input type='hidden' name='delete_id' id="delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_university_get_enquiry' />
                                                <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                <button type="button" id="delete_university_get_enquiry_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                <button type="button" onclick="document.getElementById('delete_university_get_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                            </div>

                                            <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                        </div>
                                    </form>
                                    <script>
                                        $(function() {

                                            $('#delete_university_get_enquiry_button<?php echo $row["id"]; ?>').click(function() {
                                                $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                $('#delete_university_get_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                var action = $("#action_delete<?php echo $row["id"]; ?>").val();
                                                var delete_id = $("#delete_id<?php echo $row["id"]; ?>").val();
                                                var dataString = 'action=' + action + '&delete_id=' + delete_id;

                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: dataString,
                                                    success: function(result) {
                                                        //                                                                console.log(dataString);
                                                        //                                                                console.log(result);
                                                        $('#delete_response').remove();
                                                        if (result == "error") {
                                                            $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                        }
                                                        if (result == "empty") {
                                                            $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                        }
                                                        if (result == "success") {
                                                            $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Enquiry Delete successfully!!!</div></div>');
                                                            showDeletedData();

                                                            function showDeletedData() {
                                                                $.ajax({
                                                                    url: 'include/view.php?action=get_nsuniv_get_enquiry',
                                                                    type: 'GET',
                                                                    success: function(result) {
                                                                        $("#data_table").html(result);
                                                                    }
                                                                });
                                                            }
                                                        }
                                                        $('#delete_loading').fadeOut(500, function() {
                                                            $(this).remove();
                                                            $('#delete_university_get_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                        });
                                                    }

                                                });
                                            });

                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- Delete Section End -->
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
        <script>
            $(function() {
                $("#example1").DataTable();
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                });
            });
        </script>
    <?php
    }
    //Nsuniv Get Started Enquiry End
      
      
           // Student Examination  fee start
        if($_GET["action"] == "fetch_student_examfee_details"){
            $studentRegistrationNo = $_POST["studentRegistrationNo"];
            if(!empty($studentRegistrationNo)){
                $sql = "SELECT *
                        FROM `tbl_admission`
                        INNER JOIN `tbl_university_details` ON `tbl_admission`.`admission_session` = `tbl_university_details`.`university_details_id`
                        INNER JOIN `tbl_course` ON `tbl_admission`.`admission_course_name` = `tbl_course`.`course_id`
                        WHERE `tbl_admission`.`admission_id` = '$studentRegistrationNo' && `tbl_admission`.`status` = '$visible' && `tbl_course`.`status` = '$visible' && `tbl_university_details`.`status` = '$visible'
                        ";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    //Define Variables Section Start
                    //Numeric Veriables
                    $arrayFee = array(); //In Amount or In Number
                    $arrayFine = array(); //In Amount or In Number
                    $arrayRemaining = array(); //In Amount or In Number
                    $arrayRebate = array(); //In Amount or In Number
                    $totalFee = 0; //In Amount or In Number
                    $totalFine = 0; //In Amount or In Number
                    $totalRemaining = 0; //In Amount or In Number
                    $totalRemainings = 0; //In Amount or In Number
                    $totalRebate = 0; //In Amount or In Number
                    $totalPaid = 0; //In Amount or In Number
                    //String Variables
                    $arrayPerticular = array();
                    $arrayTblFee = array();
                    $objTblFee = "";
                    //Checking If Hostel If Available Or Not
                    //if(strtolower($row["admission_hostel"]) == "yes")
                        $sqlTblFee = "SELECT *
                                     FROM `tbl_examination_fee`
                                     WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `exfee_academic_year` = '".$row["admission_session"]."' ORDER BY `exfee_particulars` ASC
                                     ";

                                     //  $sqlTblFee = "SELECT *
                                     // FROM `tbl_fee`
                                     // WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' ORDER BY `fee_particulars` ASC
                                     // ";
                    // else
                    //     $sqlTblFee = "SELECT *
                    //                  FROM `tbl_fee`
                    //                  WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' AND `fee_particulars` NOT IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees', '1st Year Hostel Fee', '1ST YEAR HOSTEL FEE', '2nd Year Hostel Fee', '2ND YEAR HOSTEL FEE', '3rd Year Hostel Fee', '3RD YEAR HOSTEL FEE', '4th Year Hostel Fee', '4TH YEAR HOSTEL FEE', '5th Year Hostel Fee', '5TH YEAR HOSTEL FEE', '6th Year Hostel Fee', '6TH YEAR HOSTEL FEE') ORDER BY `fee_particulars` ASC
                    //                  ";
                    $resultTblFee = $con->query($sqlTblFee);
                    if($resultTblFee->num_rows > 0)
                        while($rowTblFee = $resultTblFee->fetch_assoc()){
                            $totalFee = $totalFee + intval($rowTblFee["exfee_amount"]);
                            if(strtotime(date($rowTblFee["exfee_lastdate"])) < strtotime(date("Y-m-d")))
                                $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["exfee_lastdate"])))/60/60/24;
                            else
                                $noOfDays = 0;
                            if($rowTblFee["exfee_astatus"] == "Active")
                                $fine_particular = $rowTblFee["exfee_fine"];
                            else
                                $fine_particular = 0;
                            $completeArray = array(
                                                "exfee_id" => $rowTblFee["exfee_id"],
                                                "exfee_particulars" => $rowTblFee["exfee_particulars"],
                                                "exfee_amount" => $rowTblFee["exfee_amount"],
                                                "exfee_paid" => 0,
                                                "exfee_fine" => $fine_particular,
                                                "exfee_rebate" => 0,
                                                "exfee_remaining" => $rowTblFee["exfee_amount"],
                                                "exfee_fine_days" => $noOfDays
                                            );
                            array_push($arrayTblFee, $completeArray);
                        }
                    $arrayTblFee = json_decode(json_encode($arrayTblFee));

                   // echo "<pre>";
                   // print_r($arrayTblFee);  exit; 

                   
                         // echo "<pre>";
                         //   print_r($arrayPaidAmount);  exit;
                    //Define Variables Section End
                    ?>
                        <div class="row">
                            <div class="col-md-4">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <?php 
                                      if(!empty($row["admission_profile_image"])){ 
                                  ?>
                                      <img class="profile-user-img " src="images/student_images/<?php echo $row["admission_profile_image"]; ?>" alt="Student profile picture">
                                  <?php 
                                      } else if(strtolower($row["admission_gender"]) == "female"){  
                                  ?>
                                      <img class="profile-user-img img-fluid img-circle" src="images/womenIcon.png" alt="Student profile picture">
                                  <?php } else{   ?>
                                      <img class="profile-user-img img-fluid img-circle" src="images/menIcon.png" alt="Student profile picture">
                                  <?php } ?>
                                </div>

                                <h3 class="profile-username text-center"><?php echo $row["admission_first_name"]." ".$row["admission_last_name"]; ?></h3>
                                <?php 
                                  $completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
                                  $completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
                                  $completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];
                                ?>
                                <p class="text-muted text-center">( <?php echo $row["course_name"]." | ".$completeSessionOnlyYear ; ?> )</p>

                                  <p>
                                    <b>Reg. No</b> <a class="float-right"><?php echo $row["admission_id"]; ?></a></br>


                                    <b>Course Name</b> <a class="float-right"><?php echo $row["course_name"]; ?></a></br>

                                    <b>Session</b> <a class="float-right"><?php echo $completeSessionOnlyYear; ?></a></br>

                                    <b>Hostel</b> <a class="float-right"><?php echo $row["admission_hostel"]; ?></a></br>

                                    <b>User Name</b> <a class="float-right"><?php echo $row["admission_username"]; ?></a></br>

                                    <b>Status</b> <a class="float-right">Active</a>
                                    </p>

                              </div>
                              <!-- /.card-body -->
                            </div>
                            </div>
                            <div class="col-md-4">  
                            <div class="card card-primary">
                            <div class="card-header">
                            <h3 class="card-title">About <?php echo $row["admission_first_name"]; ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i> Personal Details</strong>
                             <p class="text-muted">
                              <b>Name - </b><?php echo $row["admission_first_name"]." ".$row["admission_last_name"]; ?><br/>
                              <b>Gender - </b><?php echo $row["admission_gender"]; ?><br/>
                              <b>DOB - </b><?php echo $row["admission_dob"]; ?><br/>
                              <b> Nationality - </b><?php echo $row["admission_nationality"]; ?><br/>
                              <b> Blood Group - </b><?php echo $row["admission_blood_group"]; ?><br/>
                              <b> Email - </b><?php echo $row["admission_emailid_student"]; ?><br/>
                              <b>Contact No - </b><?php echo $row["admission_mobile_student"]; ?><br/>
                              <b>Father's Name - </b><?php echo $row["admission_father_name"]; ?><br/>
                              <b>Father's Email - </b><?php echo $row["admission_emailid_father"]; ?><br/>
                              <b>Father's Contact - </b><?php echo $row["admission_father_phoneno"]; ?><br/>
                              <b>Father's Whatsapp - </b><?php echo $row["admission_father_whatsappno"]; ?><br/>
                              <b> Mother's Name - </b><?php echo $row["admission_mother_name"]; ?><br/>
                            </p>
                            </div>
                             </div>
                              </div>
                            <div class="col-md-4">  <!-- About Me Box -->
                            <div class="card card-primary">
                            <div class="card-header">
                            <h3 class="card-title">More Informations</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <h6><i class="fas fa-book mr-1"></i> Educational Details (10th)</h6>
                            <p class="text-muted">
                            University - <?php echo $row["admission_high_school_board_university"]; ?><br/>
                            College - <?php echo $row["admission_high_school_college_name"]; ?><br/>
                            Passing Year - <?php echo $row["admission_high_school_passing_year"]; ?><br/>
                            Percentage - <?php echo $row["admission_high_school_per"]; ?> %<br/>
                            </p>

                            <h6><i class="fas fa-map-marker-alt mr-1"></i> Location</h6>
                            <p class="text-muted">
                            <?php echo $row["admission_residential_address"]; ?>,<br/>
                            <?php echo $row["admission_city"]; ?>, </br><?php echo $row["admission_state"]; ?><br/>
                            <?php echo $row["admission_district"]; ?>,<br/>
                            <?php echo $row["admission_pin_code"]; ?><br/>
                            </p>
                            </div>
                            <!-- /.card-body -->

                            </div>
                            <!-- /.card-body -->
                            </div>

                          <div class="col-md-12">
                            <div class="card">
                              <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                  <li class="nav-item"><a class="nav-link active" href="#payfee" data-toggle="tab">Fee Payment</a></li>
                                  <li class="nav-item"><a class="nav-link" href="#paidfee" data-toggle="tab">Paid Info</a></li>
                                </ul>
                              </div><!-- /.card-header -->
                              <div class="card-body">
                                <div class="tab-content">
                                  <div class="active tab-pane" id="payfee">
                                   <form method="POST" id="PayFeeForm">
                                    <!-- Table row -->
                                      <div class="row">
                                       <input type="hidden" name="registrationNumber" value="<?php echo $studentRegistrationNo; ?>" readonly />
                                       <input type="hidden" name="courseId" value="<?php echo $row["course_id"]; ?>" readonly />
                                       <input type="hidden" name="academicYear" value="<?php echo $row["university_details_id"]; ?>" readonly />
                                        <div class="col-12 table-responsive">
                                          <h5>Fee Details of  <b><a href="javascript:void(0);"><?php echo $row["course_name"]." | ".$completeSessionOnlyYear; ?></a></b></h5>
                                          <table class="table table-bordered table-sm">
                                            <thead>
                                            <tr>
                                              <th>S. No</th>
                                              <th>Particulars</th>
                                              <th>Amount</th>
                                              <th>Paid</th>
                                              <!-- <th>Rebate</th> -->
                                              <!-- <th>Remaining</th> -->
                                              <th>Fine</th>
                                              <th><span class="text-red">Total<sup class="text-yellow ml-1 text-xs">(Including Fine)</sup></span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php 


                                                    $query = "SELECT * FROM `tbl_examfee_paid`  WHERE `status` = '$visible' AND `student_id` = '".$studentRegistrationNo."' AND `payment_status` IN ('cleared', 'pending')";
                                                    $results = mysqli_query($con, $query) or die("database error:". mysqli_error($con));                                   
                                                    $allOrders = array();
                                                    while( $order = mysqli_fetch_assoc($results) ) {
                                                    $no = 1;
                                                    $allOrders[] = $order;
                                                    }

                                                    // $sqlTblFeePaid = "SELECT *
                                                    // FROM `tbl_examfee_paid`
                                                    // WHERE `status` = '$visible' AND `student_id` = '".$studentRegistrationNo."' AND `payment_status` IN ('cleared', 'pending')
                                                    // ";

                                                     $tmpSNo=1; 
                                                     $total_exam_fee = 0;            
                                                     $total_paid_amount = 0;            
                                                     $total_fine = 0;            
                                                     $grand_total = 0;            
                                                    foreach($allOrders as $order){
                                                    // echo "<pre>";
                                                    // print_r($order); 
                                                    if($order["paid_amount"] != ""){

                                                
                                                    ?>
                                                    
                                                        <tr>
                                                            <td><?php echo $tmpSNo; ?></td>

                                                             <?php 
                                                     $sql_course = "SELECT * FROM `tbl_examination_fee` WHERE `exfee_id` = '".$order["particular_id"]."'";
                                                 $result_fee = $con->query($sql_course);
                                                 $row_fee = $result_fee->fetch_assoc();
                                                 $total_exam_fee =  $total_exam_fee + intval($row_fee['exfee_amount']);
                                                 $total_paid_amount =  $total_paid_amount + intval($order['paid_amount']);
                                                 $total_fine  += $total_fine + intval($order['extra_fine']);
                                                 $grand_total =  $grand_total + (intval($order['paid_amount']) + intval($order['extra_fine']));
                                                    ?>

                                                fgbj
                                                            <td><?php echo $row_fee['exfee_particulars']; ?></td>
                                                            <td>&#8377; <?php echo $row_fee['exfee_amount']; ?></td>
                                                            <td>&#8377; <?php echo $order['paid_amount']; ?></td>
                                                            <td>&#8377; <?php echo $order['extra_fine']; ?></td>
                                                        <td><span class="text-red text-bold">&#8377; <?php echo number_format(($order['paid_amount']) + ($order['extra_fine'])); ?></span></td>

                                                        </tr>
                                                <?php 
                                                        $tmpSNo++;
                                                        //$i++;
                                                    } 

                                                  }  
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td class="text-right text-bold">Total</td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($total_exam_fee); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($total_paid_amount); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($totalFine); ?></td>
                                                    <td class="text-bold"><span class="text-red"> &#8377; <?php echo number_format($grand_total); ?></span></td>
                                                </tr>
                                            </tbody>
                                          </table>
                                           <div class="col-md-6" style="float:right">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">Payment Date</span>
                                                </div>
                                                <input type="date" name="paymentDate"   class="form-control" value="<?php echo date("Y-m-d"); ?>" onkeyup="completeCalculation();" onclick="completeCalculation();" onchange="completeCalculation();" />
                                              </div>
                                              <!-- /.input group -->
                                            </div>
                                        </div>
                                         <h5>Pay Remaining<b><a href="javascript:void(0);"> Fee</a></b></h5>
                                          <p id="errorMessage" class="text-red"></p>
                                          <table class="table table-bordered table-sm">
                                            <thead>
                                            <tr>
                                              <th>S.No</th>
                                              <th>Particulars</th>
                                              <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $tmpSNo = 1;
                                                    $Idno = 0;
                                                    
                                                 
                                                    foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                ?>
                                                <tr> 
                                                    <td><?php echo $tmpSNo; ?></td> 
                                                    <td><?php echo $arrayTblFeeUpdate->exfee_particulars; ?></td> 
                                                    <td>
                                                         <input type="hidden" name="particular_paid_id[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->exfee_id; ?>" />
                                                         <div class="input-group">
                                                          <div class="input-group-prepend">
                                                            <span class="input-group-text">&#8377;</span>
                                                          </div>
                                                          <input id="particular_paid_amount[<?php echo $Idno; ?>]"  name="particular_paid_amount[<?php echo $Idno; ?>]" min="0" max="" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();">
                                                        </div>
                                                    </td> 
                                                </tr>
                                                <?php 
                                                        $Idno++;
                                                        $tmpSNo++;
                                                    } 
                                                ?>
                                          <!--   <tr> 
                                                <td><?php echo $tmpSNo; ?></td> 
                                                <td>Fine</td> 
                                                <td>
                                                    <div class="input-group">
                                                      <div class="input-group-prepend">
                                                        <span class="input-group-text">&#8377;</span>
                                                      </div>
                                                      <input id="fine_amount" name="fine_amount" min="0" max="<?php echo $totalFine; ?>" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" <?php if($totalFine == 0) echo "readonly"; ?>>
                                                    </div>
                                                </td> 
                                            </tr> -->
                                            <tr> 
                                                <td><?php echo ++$tmpSNo; ?></td> 
                                                <td>Fine</td> 
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">&#8377;</span>
                                                        </div>
                                                        <input id="fine_amount" name="fine_amount" min="0" max="" type="number" class="form-control">
                                                        <div class="input-group-prepend">
                                                            <input type="text" name="extra_fine_description" placeholder="Fine Description"  class="form-control" style="border: 2px solid #dc3545; width: 400px" />
                                                        </div>
                                                    </div>
                                                </td> 
                                            </tr>
                                           
                                            <tr>
                                              <td></td>
                                              <td class="text-right text-bold">Total</td>
                                              <td class="text-bold">
                                                 <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">&#8377;</span>
                                                  </div>
                                                  <input id="total_amount" name="total_amount" min="0" max="<?php echo $totalRemainings ?>" type="number" class="form-control" readonly>
                                                 </div>
                                                 <small class="text-red" id="totalErr"></small>
                                              </td>
                                            </tr>
                                           <!--  <tr>
                                              <td></td>
                                              <td class="text-right text-bold">Remaining</td>
                                              <td class="text-bold">
                                                 <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">&#8377;</span>
                                                  </div>
                                                  <input id="remaining_amount" name="remaining_amount" min="0" value="<?php echo $totalRemainings ?>" type="number" style="font-weight: 900;color: #dc3545;" class="form-control" readonly>
                                                 </div>
                                                 <small class="text-red" id="remainingErr"></small>
                                              </td>
                                            </tr> -->
                                            </tbody>
                                          </table>


                                        </div>
                                        <!-- /.col -->

                                      </div>
                                      <br/>
                                      <div class="row">
                                          <div class="col-md-3">
                                             <label>Payment Mode</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fa fa-university"></i></span>
                                                      </div>
                                                      <select id="PaymentMode" name="PaymentMode" class="form-control" onchange="PaymentModeSelect(this.value);">
                                                          <option value="0">Select</option>
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
                                          <div class="col-md-3" id="cash_div" style="display:none">
                                             <label>Cash Deposit To</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                                                      </div>
                                                      <select id="cashDepositTo" name="cashDepositTo" class="form-control">
                                                          <option value="0">Select</option>
                                                          <option value="University Office">University Office</option>
                                                          <option value="Deposit to Bank">Deposit to Bank</option>
                                                          <option value="City Office">City Office</option>
                                                      </select>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-3" id="bankName_div" style="display:none">
                                              <label>Bank Name</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                                                      </div>
                                                      <input id="bankName" name="bankName" type="text" class="form-control" />
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-4" id="chequeNo_div" style="display:none">
                                              <label>Cheque/DD/NEFT/IMPS/RTGS No</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                                      </div>
                                                      <input id="chequeAndOthersNumber" name="chequeAndOthersNumber" type="text" class="form-control" />
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-4" id="receiptDate_div" style="display:none">
                                              <label>Receipt Date</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                      </div>
                                                      <input id="paidDate" max="<?php echo date("Y-m-d"); ?>"  name="paidDate" type="date" class="form-control datepicker" value="<?php echo date("Y-m-d"); ?>"/>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-6" id="notes_div" style="display:none">
                                              <label>Notes</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                                      </div>
                                                      <textarea id="NotesByAdmin" name="NotesByAdmin" type="text" class="form-control" ></textarea>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-12"></div>
                                          <div class="col-md-12" id="error_on_pay_fee" style="margin-top:20px;"></div>
                                          <div class="col-md-3" id="pay_div" style="display:none; margin-top:20px;">
                                              <div class="form-group">
                                                  <div class="input-group">
                                                     <input type="hidden" name="action" value="pay_examfees" />
                                                      <button id="PayFeeButton" name="PayFeeButton" class="btn btn-primary btn-lg btn-block"><span id="loader_section_on_pay_fee"></span> <span id="PayText">Pay</span></button>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                         <!--  <div class="col-md-3" id="reset_div" style="margin-top:20px;">
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <button class="btn btn-danger btn-lg btn-block" type="reset" onclick="return confirm('Are you sure you want to reset all Informations???');" >Reset</button>
                                                  </div>-->
                                                  <!-- /.input group -->
                                              <!-- </div> 
                                          </div> --> 


                                      </div>
                                      <!-- /.row -->
                                      </form>
                                      <?php 
                                          // $sql = "SELECT * FROM `tbl_fee_paid`
                                          //         WHERE `status` = '$visible' && `student_id` = '$studentRegistrationNo'
                                          //         ORDER BY `feepaid_id` DESC
                                          //           ";
                                          // $result = $con->query($sql);
                                          // $row = $result->fetch_assoc();
                                          ?>
                                          <!-- <form action="print" method="POST"> 
                                          <input type="hidden" name="paidId" value="<?php echo $row["feepaid_id"]; ?>" />
                                              <div class="col-md-3" id="" style="margin-top:20px;">
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <button class="btn btn-danger btn-lg btn-block" type="" >Print Receipt</button>
                                                      </div>-->
                                                      <!-- /.input group -->
                                                     <!-- </div>
                                              </div>
                                          </form>-->
                                    <script>
                                        function completeCalculation(){
                                            var totalPaid = 0;
                                            var totalParticular = 0;
                                            var fineAmount = 0;
                                           // var rebateAmount = Number(document.getElementById("rebate_amount").value);
                                            // if(rebateAmount > 0){
                                            //     if(document.getElementById("rebate_from").value == ""){
                                            //         $("#rebate_amount").addClass("is-invalid");
                                            //         $("#rebateErr").html("~ Please select 'Rebate From'");
                                            //     } else{
                                            //         $("#rebate_amount").removeClass("is-invalid");
                                            //         $("#rebateErr").html("");
                                            //     }
                                            // } else{
                                            //         $("#rebate_amount").removeClass("is-invalid");
                                            //         $("#rebateErr").html("");
                                            // }
                                            var remainingAmount = 0;
                                            <?php 
                                                $Idno = 0;
                                                foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                    ?>
                                                        if(document.getElementById("particular_paid_amount[<?php echo $Idno; ?>]").value != "")
                                                            totalParticular = totalParticular + parseInt(document.getElementById("particular_paid_amount[<?php echo $Idno; ?>]").value);
                                                    <?php
                                                    $Idno++;
                                                }
                                            ?>
                                            if(document.getElementById("fine_amount").value != "")
                                                fineAmount = parseInt(document.getElementById("fine_amount").value);
                                            totalPaid = totalPaid + parseInt(totalParticular);
                                            totalPaid = totalPaid + parseInt(fineAmount);
                                            remainingAmount = parseInt(<?php echo $totalRemainings; ?>) - parseInt(totalPaid);
                                            $("#total_amount").val(totalPaid);
                                            // $("#remaining_amount").val(remainingAmount);
                                            // if(0 > parseInt(remainingAmount)){
                                            //     $("#remaining_amount").addClass("is-invalid");
                                            //     $("#remainingErr").html("~ Cannot use negative value, Remaining value must be 'greater than or equal to 0'");
                                            //     $("#totalErr").html("~ Total value must be 'less than or equal to <?php echo $totalRemainings; ?>'");
                                            //     $("#total_amount").addClass("is-invalid");
                                            // } else{
                                            //     $("#remaining_amount").removeClass("is-invalid");
                                            //     $("#total_amount").removeClass("is-invalid");
                                            //     $("#remainingErr").html("");
                                            //     $("#totalErr").html("");
                                            // }
                                        }
                                    </script>
                                    <script>
                                        function PaymentModeSelect(PaymentMode){
                                            var cash_div = document.getElementById('cash_div');
                                            var bankName_div = document.getElementById('bankName_div');
                                            var chequeNo_div = document.getElementById('chequeNo_div');
                                            var receiptDate_div = document.getElementById('receiptDate_div');
                                            var notes_div = document.getElementById('notes_div');
                                            var pay_div = document.getElementById('pay_div');
                                            if(PaymentMode == "Cash"){
                                                cash_div.style.display = "block";
                                                bankName_div.style.display = "none";
                                                chequeNo_div.style.display = "none";
                                                receiptDate_div.style.display = "block";
                                                notes_div.style.display = "block";
                                                pay_div.style.display = "block";
                                            } else if(PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS"){
                                                        cash_div.style.display = "none";
                                                        bankName_div.style.display = "block";
                                                        chequeNo_div.style.display = "block";
                                                        receiptDate_div.style.display = "block";
                                                        notes_div.style.display = "block";
                                                        pay_div.style.display = "block";
                                                    } else{
                                                        cash_div.style.display = "none";
                                                        bankName_div.style.display = "none";
                                                        chequeNo_div.style.display = "none";
                                                        receiptDate_div.style.display = "none";
                                                        notes_div.style.display = "none";
                                                        pay_div.style.display = "none";
                                                    }
                                        }
                                    </script>
                                    <script>
                                        $(document).ready(function() {
                                            $('#PayFeeForm').submit(function(event) {
                                                $('#PayText').hide();
                                                $('#loader_section_on_pay_fee').append('<img id = "loading" width="30px" src = "images/ajax-loader.gif" alt="Currently loading" />');
                                                $('#PayFeeButton').prop('disabled', true);
                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: $('#PayFeeForm').serializeArray(),
                                                    success: function(result) {
                                                        $('#response_on_pay_fee').remove();
                                                        if(result == "success"){
                                                           $('#error_on_pay_fee').append('<div id = "response_on_pay_fee"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Paid Successfully!!!</div></div>');
                                                            $('#PayFeeForm')[0].reset();
                                                            $('#loading').fadeOut(1000, function() {
                                                                $(this).remove();
                                                                $('#PayText').show();
                                                                $('#PayFeeButton').prop('disabled', false);
                                                                $.ajax({
                                                                    url: 'include/view.php?action=fetch_student_examfee_details',
                                                                    type: 'POST',
                                                                    data: $('#fetchStudentDataForm').serializeArray(),
                                                                    success: function(result) {
                                                                        //$("#data_table").html(result);
                                                                        $('#response').remove();
                                                                        if(result == 0){
                                                                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please enter Registration Number!!!</div></div>');
                                                                        } else if(result == 1){
                                                                                    $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                                                                                } else{
                                                                                    //$('#fetchStudentDataForm')[0].reset();
                                                                                    $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                                }
                                                                        $('#loading').fadeOut(500, function() {
                                                                            $(this).remove();
                                                                        });
                                                                        $('#fetchStudentDataButton').prop('disabled', false);
                                                                    }
                                                                });
                                                            });
                                                        } else
                                                            $('#error_on_pay_fee').append('<div id = "response_on_pay_fee">' + result + '</div>');
                                                        $('#loading').fadeOut(500, function() {
                                                            $(this).remove();
                                                            $('#PayText').show();
                                                            $('#PayFeeButton').prop('disabled', false);
                                                        });
                                                    }
                                                });
                                                event.preventDefault();
                                            });
                                        });
                                    </script>
                                  </div>

                                  <!-- /.tab-pane -->
                                  <div class="tab-pane" id="paidfee">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                     <?php 
                                        $sql_paid_time = "SELECT * FROM `tbl_fee_paid`
                                                        WHERE `status` = '$visible' && `student_id` = '$studentRegistrationNo' && `payment_status` != 'deleted'
                                                        ORDER BY `receipt_date` DESC
                                                        ";
                                        $result_paid_time = $con->query($sql_paid_time);
                                        if($result_paid_time->num_rows > 0){
                                        while($row_paid_time = $result_paid_time->fetch_assoc()){
                                            $allPerticulars = explode(",", $row_paid_time["paid_amount"]);
                                            $totalPerticular = 0;
                                            for($i=0; $i<count($allPerticulars); $i++)
                                                $totalPerticular = $totalPerticular + intval($allPerticulars[$i]);
                                            $totalAmount = $totalPerticular + intval($row_paid_time["fine"]) - intval($row_paid_time["rebate_amount"]);

                                     ?>
                                      <!-- Timeline Section Start -- >
                                          <!-- timeline time label -->
                                          <div class="time-label">
                                            <span class="bg-success">
                                              <?php echo date("d M, Y", strtotime($row_paid_time["receipt_date"])); ?>
                                            </span>
                                          </div>
                                          <!-- /.timeline-label -->
                                          <!-- timeline item -->
                                          <div>
                                            <i class="fas fa-money-check bg-info"></i>

                                            <div id="fee_Status_section_full<?php echo $row_paid_time["feepaid_id"]; ?>" class="timeline-item" style="background-color:<?php if(strtolower($row_paid_time["payment_status"]) == "bounced") echo '#ffcccb'; if(strtolower($row_paid_time["payment_status"]) == "pending") echo '#ffffed'; if(strtolower($row_paid_time["payment_status"]) == "refunded") echo '#ffa7a7'; ?>;">
                                              <span class="time"><i class="far fa-clock"></i> <?php echo $row_paid_time["fee_paid_time"]; ?> </span>

                                              <h3 class="timeline-header"><a href="javascript:void(0);">Payment Information</a></h3>

                                              <div class="timeline-body">
                                                 <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                      <th>Total Perticular</th>
                                                      <th>Fine</th>
                                                      <th>Extra Fine</th>
                                                      <th>Rebate</th>
                                                      <th>Total Paid</th>
                                                      <th><span class="text-red">Remaining</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                      <td>&#8377; <?php echo number_format(intval($totalPerticular)); ?></td>
                                                      <td>&#8377; <?php echo number_format(intval($row_paid_time["fine"])); ?></td>
                                                      <?php
                                                        $show_extra_fine = 0;
                                                        $show_extra_fine_msg = "";
                                                        if(!empty($row_paid_time["extra_fine"])){
                                                            $show_extra = explode("|separator|", $row_paid_time["extra_fine"]);
                                                            $show_extra_fine = $show_extra[0];
                                                            if(isset($show_extra[1])){
                                                                $show_extra_fine_msg = $show_extra[1];
                                                            }
                                                        }
                                                      ?>
                                                      <?php 
                                                        if(empty($show_extra_fine_msg)):
                                                      ?>
                                                      <td>&#8377; <?php echo number_format(intval($show_extra_fine)); ?></td>
                                                      <?php 
                                                        else:
                                                      ?>
                                                      <td>&#8377; <?php echo number_format(intval($show_extra_fine)); ?> <br/> <small class="text-danger"><?= htmlspecialchars_decode($show_extra_fine_msg) ?></small></td>
                                                      <?php 
                                                        endif;
                                                      ?>
                                                      <td>&#8377; <?php echo number_format(intval($row_paid_time["rebate_amount"])); ?></td>
                                                      <td>&#8377; <?php echo number_format(intval($totalAmount) + intval($row_paid_time["rebate_amount"]) + intval($show_extra_fine)); ?></td>
                                                      <td>&#8377; <?php echo number_format(intval($row_paid_time["balance"])); ?></td>
                                                    </tr>
                                                    </tbody>
                                                  </table>

                                                <h5 class="timeline-header"><a href="javascript:void(0);">Payment Mode</a> ~ <?php echo $row_paid_time["payment_mode"]; ?></h5>
                                                <h5 class="timeline-header"><a href="javascript:void(0);">Payment Status</a> ~ <span id="fee_Status_section<?php echo $row_paid_time["feepaid_id"]; ?>"><span class="<?php if(strtolower($row_paid_time["payment_status"]) == "bounced") echo 'bg-danger';
                                            if(strtolower($row_paid_time["payment_status"]) == "refunded") echo 'bg-danger'; else if(strtolower($row_paid_time["payment_status"]) == "pending") echo 'bg-warning'; ?>"><?php echo strtoupper($row_paid_time["payment_status"]); ?></span></span> </h5>
                                              </div>
                                              <div class="timeline-footer" align="right">
                                               <h5 class="timeline-header"><a href="javascript:void(0);">Give Status Here</a></h5>
                                                <?php if($row_paid_time["payment_status"] == "refunded"){ ?>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'cleared')" class="btn btn-info btn-sm">Add this Fee</a>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'deleted')" class="btn btn-danger btn-sm">Delete</a>
                                                <?php } else{
                                                    ?>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'refunded')" class="btn btn-info btn-sm">Refund</a>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'deleted')" class="btn btn-danger btn-sm">Delete</a>
                                                    <?php    
                                                } ?>
                                                <?php if($row_paid_time["payment_mode"] == "Cheque"){ ?>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'cleared')" class="btn btn-success btn-sm">Cleared</a>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'pending')" class="btn btn-warning btn-sm">Pending</a>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'bounced')" class="btn btn-danger btn-sm">Bounced</a>
                                              <?php } ?>
                                              </div>
                                            </div>
                                          </div>
                                          <!-- END timeline item -->
                                      <!-- Timeline Section End -->
                                      <?php } 
                                        } else{
                                            ?>
                                            <center><b class="text-red">No any Payment Yet!!!</b></center>
                                            <?php
                                        }?>
                                      <div>
                                        <i class="fas fa-money-bill-alt bg-danger"></i>
                                      </div>
                                      <script>
                                          function statusChange(feepaid_id, statusUpdate){
                                              $('#paidfee').css("opacity", "0.4");
                                              $('#paidfee').css("pointer-events", "none");
                                              var action = "change_Fee_Status";
                                              var dataString = 'action='+ action + '&feepaid_id='+ feepaid_id + '&status='+ statusUpdate;
                                              $.ajax({
                                                url: 'include/controller.php',
                                                type: 'POST',
                                                data: dataString,
                                                success: function(result) {
                                                    if(result != "error" && result != "empty"){
                                                        console.log(result);
                                                        var fullinfo = result.split(',');
                                                        $('#fee_Status_section'+feepaid_id).html(fullinfo[0]);
                                                        $('#fee_Status_section_full'+feepaid_id).css("background-color", fullinfo[1]);
                                                        $.ajax({
                                                            url: 'include/view.php?action=fetch_student_fee_details',
                                                            type: 'POST',
                                                            data: $('#fetchStudentDataForm').serializeArray(),
                                                            success: function(result) {
                                                                //$("#data_table").html(result);
                                                                $('#response').remove();
                                                                if(result == 0){
                                                                    $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please enter Registration Number!!!</div></div>');
                                                                } else if(result == 1){
                                                                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                                                                        } else{
                                                                            //$('#fetchStudentDataForm')[0].reset();
                                                                            $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                        }
                                                                $('#loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#fetchStudentDataButton').prop('disabled', false);
                                                            }
                                                        });
                                                    }
                                                }
                                            });
                                          }
                                      </script>
                                    </div>
                                  </div>
                                  <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                              </div><!-- /.card-body -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                          </div>
                          <!-- /.col -->
                        </div>
                    <?php
                } else
                    echo '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  No Student Found!!!</div>';
            } else
                echo "0"; 
        }
        //Student  Examination fee End

        //Courses Start
        if($_GET["action"] == "get_courses"){
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_course`
                                WHERE `status` = '$visible'
                                ORDER BY `course_id` ASC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <td><?php echo $row["course_name"] ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_courses<?php echo $row["course_id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_courses<?php echo $row["course_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                      
                                    
                                    <!-- Courses Edit Section Start -->
                                    <div id="edit_courses<?php echo $row["course_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_courses<?php echo $row["course_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Course</h2>
                                            </header>
                                            <form id="edit_course_form<?php echo $row["course_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["course_id"]; ?>"></div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Course Name</label>
                                                                <input type="text" name="edit_course_name" id="edit_course_name<?php echo $row["course_id"]; ?>" class="form-control" value="<?php echo $row["course_name"]; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <input type='hidden' name='edit_course_id' id="edit_course_id<?php echo $row["course_id"]; ?>" value='<?php echo $row["course_id"]; ?>' />
                                                    <input type='hidden' name='action' id="action<?php echo $row["course_id"]; ?>" value='edit_courses' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["course_id"]; ?>"></div>
                                                    <button type="button" id="edit_course_button<?php echo $row["course_id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#edit_course_button<?php echo $row["course_id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["course_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_course_button<?php echo $row["course_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["course_id"]; ?>").val();
                                                        var edit_course_id = $("#edit_course_id<?php echo $row["course_id"]; ?>").val();
                                                        var edit_course_name = $("#edit_course_name<?php echo $row["course_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&edit_course_id='+ edit_course_id + '&edit_course_name='+ edit_course_name;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#edit_response').remove();
                                                                if(result == "exsits"){
                                                                    $('#edit_error_section<?php echo $row["course_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Course have already exsits!!!</div></div>');
                                                                }
                                                                if(result == "error"){
                                                                    $('#edit_error_section<?php echo $row["course_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#edit_error_section<?php echo $row["course_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out Course Name!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#edit_error_section<?php echo $row["course_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Updated successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_courses',
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
                                                                $('#edit_course_button<?php echo $row["course_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Courses Edit Section End -->
                        
                                    <!-- Courses delete Section Start -->
                                    <div id="delete_courses<?php echo $row["course_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_courses<?php echo $row["course_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_course_form<?php echo $row["course_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["course_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_course_id' id="delete_course_id<?php echo $row["course_id"]; ?>" value='<?php echo $row["course_id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["course_id"]; ?>" value='delete_courses' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["course_id"]; ?>"></div>
                                                        <button type="button" id="delete_course_button<?php echo $row["course_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_courses<?php echo $row["course_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_course_button<?php echo $row["course_id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["course_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_course_button<?php echo $row["course_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["course_id"]; ?>").val();
                                                        var delete_course_id = $("#delete_course_id<?php echo $row["course_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_course_id='+ delete_course_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_courses',
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
                                                                $('#delete_course_button<?php echo $row["course_id"]; ?>').prop('disabled', false);
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Courses End
        //Subject Start
        if($_GET["action"] == "get_subjects"){
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course Name</th>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_subject`
                                WHERE `status` = '$visible'
                                ORDER BY `subject_id` DESC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <?php 
                                        $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["subject_course_name"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                    ?>
                                    <td><?php echo $row_course["course_name"]; ?></td>
                                    <td><?php echo $row["subject_code"] ?></td>
                                    <td><?php echo $row["subject_name"] ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_subjects<?php echo $row["subject_id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_subjects<?php echo $row["subject_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Subjects Edit Section Start -->
                                    <div id="edit_subjects<?php echo $row["subject_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_subjects<?php echo $row["subject_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Subject</h2>
                                            </header>
                                            <form id="edit_subject_form<?php echo $row["subject_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["subject_id"]; ?>"></div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label>Course Name</label>
                                                            <select name="edit_subject_course_name" id="edit_subject_course_name<?php echo $row["subject_id"]; ?>" class="form-control select2" style="width: 100%;">
                                                                <?php 
                                                                $sql_course = "SELECT * FROM `tbl_course`
                                                                               WHERE `status` = '$visible'
                                                                               ";
                                                                $result_course = $con->query($sql_course);
                                                                while($row_course = $result_course->fetch_assoc()){
                                                                ?>
                                                                    <option value="<?php echo $row_course["course_id"]; ?>" <?php if($row_course["course_id"] == $row["subject_course_name"]) echo 'selected'; ?> ><?php echo $row_course["course_name"]; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Subject Code</label>
                                                            <input type="text" name="edit_subject_code" id="edit_subject_code<?php echo $row["subject_id"]; ?>" class="form-control" value="<?php echo $row["subject_code"]; ?>">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Subject Name</label>
                                                            <input type="text" name="edit_subject_name" id="edit_subject_name<?php echo $row["subject_id"]; ?>" class="form-control" value="<?php echo $row["subject_name"]; ?>">
                                                        </div>

                                                    </div>
                                                    <input type='hidden' name='edit_subject_id' id="edit_subject_id<?php echo $row["subject_id"]; ?>" value='<?php echo $row["subject_id"]; ?>' />
                                                    <input type='hidden' name='action' id="action<?php echo $row["subject_id"]; ?>" value='edit_subjects' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["subject_id"]; ?>"></div>
                                                    <button type="button" id="edit_subject_button<?php echo $row["subject_id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#edit_subject_button<?php echo $row["subject_id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["subject_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_subject_button<?php echo $row["subject_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["subject_id"]; ?>").val();
                                                        var edit_subject_id = $("#edit_subject_id<?php echo $row["subject_id"]; ?>").val();
                                                        var edit_subject_course_name = $("#edit_subject_course_name<?php echo $row["subject_id"]; ?>").val();
                                                        var edit_subject_code = $("#edit_subject_code<?php echo $row["subject_id"]; ?>").val();
                                                        var edit_subject_name = $("#edit_subject_name<?php echo $row["subject_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&edit_subject_id='+ edit_subject_id + '&edit_subject_course_name='+ edit_subject_course_name + '&edit_subject_code='+ edit_subject_code + '&edit_subject_name='+ edit_subject_name;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#edit_response').remove();
                                                                if(result == "exsits"){
                                                                    $('#edit_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Subject Code already exsits!!!</div></div>');
                                                                }
                                                                if(result == "error"){
                                                                    $('#edit_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#edit_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out All Required fields!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#edit_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Subject Updated successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_subjects',
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
                                                                $('#edit_subject_button<?php echo $row["subject_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Subjects Edit Section End -->
                        
                                    <!-- Subjects delete Section Start -->
                                    <div id="delete_subjects<?php echo $row["subject_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_subjects<?php echo $row["subject_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_subject_form<?php echo $row["subject_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["subject_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_subject_id' id="delete_subject_id<?php echo $row["subject_id"]; ?>" value='<?php echo $row["subject_id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["subject_id"]; ?>" value='delete_subjects' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["subject_id"]; ?>"></div>
                                                        <button type="button" id="delete_subject_button<?php echo $row["subject_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_subjects<?php echo $row["subject_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_subject_button<?php echo $row["subject_id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["subject_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_subject_button<?php echo $row["subject_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["subject_id"]; ?>").val();
                                                        var delete_subject_id = $("#delete_subject_id<?php echo $row["subject_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_subject_id='+ delete_subject_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Subject Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_subjects',
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
                                                                $('#delete_subject_button<?php echo $row["subject_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Subjects delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Subject End
        //All Deleted Lists Start
        if($_GET["action"] == "get_trash"){
        ?>
            <!-- Deleted Items From Course Start -->
            <label style="color:red;"> Course Deleted List </label>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course Name</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_course`
                                WHERE `status` = '$trash'
                                ORDER BY `course_id` DESC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <td><?php echo $row["course_name"]; ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-primary btn-sm" onclick="document.getElementById('trase_courses_restore<?php echo $row["course_id"]; ?>').style.display='block'">
                                            <i class="far fa-circle nav-icon">
                                            </i>
                                            Restore
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('trase_courses_delete<?php echo $row["course_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash nav-icon">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Courses delete Section Start -->
                                    <div id="trase_courses_delete<?php echo $row["course_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('trase_courses_delete<?php echo $row["course_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="trase_courses_delete_form<?php echo $row["course_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="trase_courses_delete_error_section<?php echo $row["course_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='action' id="action_trase_courses_delete<?php echo $row["course_id"]; ?>" value='trash_delete' />
                                                        <input type='hidden' name='action_tbl' id="action_trase_courses_delete_tbl<?php echo $row["course_id"]; ?>" value='tbl_course' />
                                                        <input type='hidden' name='delete_id' id="trase_courses_delete_course_id<?php echo $row["course_id"]; ?>" value='<?php echo $row["course_id"]; ?>' />
                                                        <div class="col-md-12" id="trase_courses_delete_loader_section<?php echo $row["course_id"]; ?>"></div>
                                                        <button type="button" id="trase_courses_delete_course_button<?php echo $row["course_id"]; ?>" class="btn btn-danger">Delete Permanently</button>
                                                        <button type="button" onclick="document.getElementById('trase_courses_delete<?php echo $row["course_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#trase_courses_delete_course_button<?php echo $row["course_id"]; ?>').click(function() {
                                                        $('#trase_courses_delete_loader_section<?php echo $row["course_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#trase_courses_delete_course_button<?php echo $row["course_id"]; ?>').prop('disabled', true);
                                                        
                                                        var action = $("#action_trase_courses_delete<?php echo $row["course_id"]; ?>").val();
                                                        var action_tbl = $("#action_trase_courses_delete_tbl<?php echo $row["course_id"]; ?>").val();
                                                        var delete_id = $("#trase_courses_delete_course_id<?php echo $row["course_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&action_tbl='+ action_tbl + '&delete_id='+ delete_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#trase_courses_delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#trase_courses_delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#trase_courses_delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_trash',
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
                                                                $('#trase_courses_delete_course_button<?php echo $row["course_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Courses delete Section End -->
                                    <!-- Courses restore Section Start -->
                                    <div id="trase_courses_restore<?php echo $row["course_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('trase_courses_restore<?php echo $row["course_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="trase_courses_restore_form<?php echo $row["course_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="trase_courses_restore_error_section<?php echo $row["course_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='action' id="action_trase_courses_restore<?php echo $row["course_id"]; ?>" value='trash_restore' />
                                                        <input type='hidden' name='action_tbl' id="action_trase_courses_restore_tbl<?php echo $row["course_id"]; ?>" value='tbl_course' />
                                                        <input type='hidden' name='restore_id' id="trase_courses_restore_course_id<?php echo $row["course_id"]; ?>" value='<?php echo $row["course_id"]; ?>' />
                                                        <div class="col-md-12" id="trase_courses_restore_loader_section<?php echo $row["course_id"]; ?>"></div>
                                                        <button type="button" id="trase_courses_restore_course_button<?php echo $row["course_id"]; ?>" class="btn btn-danger">Restore Now</button>
                                                        <button type="button" onclick="document.getElementById('trase_courses_restore<?php echo $row["course_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#trase_courses_restore_course_button<?php echo $row["course_id"]; ?>').click(function() {
                                                        $('#trase_courses_restore_loader_section<?php echo $row["course_id"]; ?>').append('<center id = "restore_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#trase_courses_restore_course_button<?php echo $row["course_id"]; ?>').prop('disabled', true);
                                                        
                                                        var action = $("#action_trase_courses_restore<?php echo $row["course_id"]; ?>").val();
                                                        var action_tbl = $("#action_trase_courses_restore_tbl<?php echo $row["course_id"]; ?>").val();
                                                        var restore_id = $("#trase_courses_restore_course_id<?php echo $row["course_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&action_tbl='+ action_tbl + '&restore_id='+ restore_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#restore_response').remove();
                                                                if(result == "error"){
                                                                    $('#trase_courses_restore_error_section<?php echo $row["course_id"]; ?>').append('<div id = "restore_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#trase_courses_restore_error_section<?php echo $row["course_id"]; ?>').append('<div id = "restore_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#trase_courses_restore_error_section<?php echo $row["course_id"]; ?>').append('<div id = "restore_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Restore successfully!!!</div></div>');
                                                                    showRestoredData();
                                                                    function showRestoredData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_trash',
                                                                            type: 'GET',
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#restore_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#trase_courses_restore_course_button<?php echo $row["course_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Courses restore Section End -->
                                </tr>
                            <?php 
                                $s_no++;
                            }
                        } else
                            echo '
                                <div class="alert alert-warning alert-dismissible">
                                    <i class="icon fas fa-exclamation-triangle"></i>  No Any Deleted Items Now!!!
                                </div>';
                    ?>
                </tbody>
            </table>
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
            <!-- Deleted Items From Course End -->
            <br/><br/>
            <!-- Deleted Items From Subject Start -->
            <label style="color:red;"> Subject Deleted List </label>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course Name</th>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_subject`
                                WHERE `status` = '$trash'
                                ORDER BY `subject_id` DESC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <?php 
                                        $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["subject_course_name"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                    ?>
                                    <td><?php echo $row_course["course_name"]; ?></td>
                                    <td><?php echo $row["subject_code"] ?></td>
                                    <td><?php echo $row["subject_name"] ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-primary btn-sm" onclick="document.getElementById('trase_subjects_restore<?php echo $row["subject_id"]; ?>').style.display='block'">
                                            <i class="far fa-circle nav-icon">
                                            </i>
                                            Restore
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('trase_subjects_delete<?php echo $row["subject_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash nav-icon">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Subjects delete Section Start -->
                                    <div id="trase_subjects_delete<?php echo $row["subject_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('trase_subjects_delete<?php echo $row["subject_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="trase_subjects_delete_form<?php echo $row["subject_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="trase_subjects_delete_error_section<?php echo $row["subject_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='action' id="action_trase_subjects_delete<?php echo $row["subject_id"]; ?>" value='trash_delete' />
                                                        <input type='hidden' name='action_tbl' id="action_trase_subjects_delete_tbl<?php echo $row["subject_id"]; ?>" value='tbl_subject' />
                                                        <input type='hidden' name='delete_id' id="trase_subjects_delete_subject_id<?php echo $row["subject_id"]; ?>" value='<?php echo $row["subject_id"]; ?>' />
                                                        <div class="col-md-12" id="trase_subjects_delete_loader_section<?php echo $row["subject_id"]; ?>"></div>
                                                        <button type="button" id="trase_subjects_delete_subject_button<?php echo $row["subject_id"]; ?>" class="btn btn-danger">Delete Permanently</button>
                                                        <button type="button" onclick="document.getElementById('trase_subjects_delete<?php echo $row["subject_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#trase_subjects_delete_subject_button<?php echo $row["subject_id"]; ?>').click(function() {
                                                        $('#trase_subjects_delete_loader_section<?php echo $row["subject_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#trase_subjects_delete_subject_button<?php echo $row["subject_id"]; ?>').prop('disabled', true);
                                                        
                                                        var action = $("#action_trase_subjects_delete<?php echo $row["subject_id"]; ?>").val();
                                                        var action_tbl = $("#action_trase_subjects_delete_tbl<?php echo $row["subject_id"]; ?>").val();
                                                        var delete_id = $("#trase_subjects_delete_subject_id<?php echo $row["subject_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&action_tbl='+ action_tbl + '&delete_id='+ delete_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#trase_subjects_delete_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#trase_subjects_delete_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#trase_subjects_delete_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Subject Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_trash',
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
                                                                $('#trase_subjects_delete_subject_button<?php echo $row["subject_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Subjects delete Section End -->
                                    <!-- Subjects restore Section Start -->
                                    <div id="trase_subjects_restore<?php echo $row["subject_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('trase_subjects_restore<?php echo $row["subject_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="trase_subjects_restore_form<?php echo $row["subject_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="trase_subjects_restore_error_section<?php echo $row["subject_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='action' id="action_trase_subjects_restore<?php echo $row["subject_id"]; ?>" value='trash_restore' />
                                                        <input type='hidden' name='action_tbl' id="action_trase_subjects_restore_tbl<?php echo $row["subject_id"]; ?>" value='tbl_subject' />
                                                        <input type='hidden' name='restore_id' id="trase_subjects_restore_subject_id<?php echo $row["subject_id"]; ?>" value='<?php echo $row["subject_id"]; ?>' />
                                                        <div class="col-md-12" id="trase_subjects_restore_loader_section<?php echo $row["subject_id"]; ?>"></div>
                                                        <button type="button" id="trase_subjects_restore_subject_button<?php echo $row["subject_id"]; ?>" class="btn btn-danger">Restore Now</button>
                                                        <button type="button" onclick="document.getElementById('trase_subjects_restore<?php echo $row["subject_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#trase_subjects_restore_subject_button<?php echo $row["subject_id"]; ?>').click(function() {
                                                        $('#trase_subjects_restore_loader_section<?php echo $row["subject_id"]; ?>').append('<center id = "restore_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#trase_subjects_restore_subject_button<?php echo $row["subject_id"]; ?>').prop('disabled', true);
                                                        
                                                        var action = $("#action_trase_subjects_restore<?php echo $row["subject_id"]; ?>").val();
                                                        var action_tbl = $("#action_trase_subjects_restore_tbl<?php echo $row["subject_id"]; ?>").val();
                                                        var restore_id = $("#trase_subjects_restore_subject_id<?php echo $row["subject_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&action_tbl='+ action_tbl + '&restore_id='+ restore_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#restore_response').remove();
                                                                if(result == "error"){
                                                                    $('#trase_subjects_restore_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "restore_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#trase_subjects_restore_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "restore_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#trase_subjects_restore_error_section<?php echo $row["subject_id"]; ?>').append('<div id = "restore_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Subject Restore successfully!!!</div></div>');
                                                                    showRestoredData();
                                                                    function showRestoredData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_trash',
                                                                            type: 'GET',
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#restore_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#trase_subjects_restore_subject_button<?php echo $row["subject_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Subjects restore Section End -->
                                </tr>
                            <?php 
                                $s_no++;
                            }
                        } else
                            echo '
                                <div class="alert alert-warning alert-dismissible">
                                    <i class="icon fas fa-exclamation-triangle"></i>  No Any Deleted Items Now!!!
                                </div>';
                    ?>
                </tbody>
            </table>
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
            <!-- Deleted Items From Subject End -->
             <!-- Deleted Items From prospectus Start -->
            <label style="color:red;"> Prospectus Deleted List </label>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Prospectus No</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_prospectus`
                                WHERE `status` = '$trash'
                                ORDER BY `id` DESC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <td><?php echo $row["prospectus_no"]; ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-primary btn-sm" onclick="document.getElementById('trase_prospectus_restore<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="far fa-circle nav-icon">
                                            </i>
                                            Restore
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('trase_prospectus_delete<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash nav-icon">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- prospectus delete Section Start -->
                                    <div id="trase_prospectus_delete<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('trase_prospectus_delete<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="trase_prospectus_delete_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="trase_prospectus_delete_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='action' id="action_trase_prospectus_delete<?php echo $row["id"]; ?>" value='trash_delete' />
                                                        <input type='hidden' name='action_tbl' id="action_trase_prospectus_delete_tbl<?php echo $row["id"]; ?>" value='tbl_prospectus' />
                                                        <input type='hidden' name='delete_id' id="trase_prospectus_delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <div class="col-md-12" id="trase_prospectus_delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="trase_prospectus_delete_prospectus_button<?php echo $row["id"]; ?>" class="btn btn-danger">Delete Permanently</button>
                                                        <button type="button" onclick="document.getElementById('trase_prospectus_delete<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#trase_prospectus_delete_prospectus_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#trase_prospectus_delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#trase_prospectus_delete_prospectus_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        
                                                        var action = $("#action_trase_prospectus_delete<?php echo $row["id"]; ?>").val();
                                                        var action_tbl = $("#action_trase_prospectus_delete_tbl<?php echo $row["id"]; ?>").val();
                                                        var delete_id = $("#trase_prospectus_delete_id<?php echo $row["id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&action_tbl='+ action_tbl + '&delete_id='+ delete_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#trase_prospectus_delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#trase_prospectus_delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#trase_prospectus_delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_trash',
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
                                                                $('#trase_prospectus_delete_prospectus_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- prospectus delete Section End -->
                                    <!-- prospectus restore Section Start -->
                                    <div id="trase_prospectus_restore<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('trase_prospectus_restore<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="trase_prospectus_restore_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="trase_prospectus_restore_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='action' id="action_trase_prospectus_restore<?php echo $row["id"]; ?>" value='trash_restore' />
                                                        <input type='hidden' name='action_tbl' id="action_trase_prospectus_restore_tbl<?php echo $row["id"]; ?>" value='tbl_prospectus' />
                                                        <input type='hidden' name='restore_id' id="trase_prospectus_restore_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <div class="col-md-12" id="trase_prospectus_restore_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="trase_prospectus_restore_course_button<?php echo $row["id"]; ?>" class="btn btn-danger">Restore Now</button>
                                                        <button type="button" onclick="document.getElementById('trase_prospectus_restore<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#trase_prospectus_restore_prospectus_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#trase_prospectus_restore_loader_section<?php echo $row["id"]; ?>').append('<center id = "restore_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#trase_prospectus_restore_prospectus_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        
                                                        var action = $("#action_trase_prospectus_restore<?php echo $row["id"]; ?>").val();
                                                        var action_tbl = $("#action_trase_prospectus_restore_tbl<?php echo $row["id"]; ?>").val();
                                                        var restore_id = $("#trase_prospectus_restore_id<?php echo $row["id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&action_tbl='+ action_tbl + '&restore_id='+ restore_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#restore_response').remove();
                                                                if(result == "error"){
                                                                    $('#trase_prospectus_restore_error_section<?php echo $row["id"]; ?>').append('<div id = "restore_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#trase_prospectus_restore_error_section<?php echo $row["id"]; ?>').append('<div id = "restore_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#trase_prospectus_restore_error_section<?php echo $row["id"]; ?>').append('<div id = "restore_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Restore successfully!!!</div></div>');
                                                                    showRestoredData();
                                                                    function showRestoredData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_trash',
                                                                            type: 'GET',
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#restore_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#trase_prospectus_restore_prospectus_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- prospectus restore Section End -->
                                </tr>
                            <?php 
                                $s_no++;
                            }
                        } else
                            echo '
                                <div class="alert alert-warning alert-dismissible">
                                    <i class="icon fas fa-exclamation-triangle"></i>  No Any Deleted Items Now!!!
                                </div>';
                    ?>
                </tbody>
            </table>
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
            <!-- Deleted Items From prospectus End -->
        <?php
        }
        //All Deleted Lists End
        /* ---------- All View Codes End ------------------------- */
        /* ---------- All Fetch Codes Start ---------------------- */
        //Fetching Precious Fees Due Dates Start
        if($_GET["action"] == "fetch_previous_due_date"){
            $data = $_GET["data"];
            $sql = "SELECT * FROM `tbl_fee_due_date`
                    WHERE `status` = '$visible' && `fee_due_date_academic_year` = '$data'
                    ";
            $result = $con->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $months = explode(",", $row["fee_due_date_month_array"]);
                $dates = explode(",", $row["fee_due_date_month_date"]);
                ?>
                    <div class="row">
                     <?php 
                        for($i = 0; $i<count($months); $i++){
                     ?>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label><?php echo $months[$i]; ?></label>
                              <input type="date" name="<?php echo strtolower($months[$i]); ?>_date" class="form-control" value="<?php echo $dates[$i]; ?>">
                            </div>              
                          </div>
                    <?php } ?>
                    </div>
                <?php
            } else{
                echo "nodata";
            }
        }
      
            //Fetching Precious Fees Due Dates Start
    if ($_GET["action"] == "fetch_fees") {
        $data = $_POST["data"];
    ?>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Course Name</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                    <th>Fine</th>
                    <th>Fee Last Date</th>
                    <th>Status</th>
                    <th class="project-actions text-center">Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `tbl_fee`
                                WHERE `status` = '$visible' && `fee_academic_year` = '$data'
                                ORDER BY `course_id` ASC
                                ";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $s_no; ?></td>
                            <?php
                            $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '" . $row["course_id"] . "';
                                                       ";
                            $result_course = $con->query($sql_course);
                            $row_course = $result_course->fetch_assoc();
                            ?>
                            <td><?php echo $row_course["course_name"]; ?></td>
                            <td><?php echo $row["fee_particulars"] ?></td>
                            <td><?php echo $row["fee_amount"] ?></td>
                            <td><?php echo $row["fee_fine"] ?></td>
                            <td><?php echo date("d-m-Y", strtotime($row["fee_lastdate"])) ?></td>
                            <td> <button type="button" id="edit_fee_status_button<?php echo $row["fee_id"]; ?>" class="btn <?php if ($row["fee_astatus"] == "Active") echo "btn-success";
                                                                                                                            else echo "btn-warning" ?> btn-sm"><span id="loader_id<?php echo $row["fee_id"]; ?>"></span> <?php echo  $row["fee_astatus"] ?></button></td>
                            <td class="project-actions text-center">
                                <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_fees<?php echo $row["fee_id"]; ?>').style.display='block'">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_fees<?php echo $row["fee_id"]; ?>').style.display='block'">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </button>
                            </td>

                            <!-- Fees Edit Section Start -->
                            <div id="edit_fees<?php echo $row["fee_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                    <header class="w3-container" style="background:#343a40; color:white;">
                                        <span onclick="document.getElementById('edit_fees<?php echo $row["fee_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                        <h2 align="center">Edit Fee</h2>
                                    </header>
                                    <form id="edit_fee_form<?php echo $row["fee_id"]; ?>" role="form" method="POST">
                                        <div class="card-body">
                                            <div class="col-md-12" id="edit_error_section<?php echo $row["fee_id"]; ?>"></div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Course Name</label>
                                                        <select name="" id="edit_fee_course_name<?php echo $row["fee_id"]; ?>" class="form-control">
                                                            <?php
                                                            $sql_c = "SELECT * FROM `tbl_course`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                            $result_c = $con->query($sql_c);
                                                            while ($row_c = $result_c->fetch_assoc()) {
                                                            ?>
                                                                <option value="<?php echo $row_c["course_id"]; ?>" <?php if ($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?>><?php echo $row_c["course_name"]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Particular</label>
                                                        <input type="text" name="" id="edit_fee_particulars<?php echo $row["fee_id"]; ?>" class="form-control" value="<?php echo $row["fee_particulars"]; ?>">
                                                    </div>

                                                    <div class="form-group">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Amount</label>
                                                        <input type="text" name="" id="edit_fee_amount<?php echo $row["fee_id"]; ?>" class="form-control" value="<?php echo $row["fee_amount"]; ?>">
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fine</label>
                                                        <input type="text" name="" id="edit_fee_fine<?php echo $row["fee_id"]; ?>" class="form-control" value="<?php echo $row["fee_fine"]; ?>">
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fee Last Date</label>
                                                        <input type="date" name="" id="edit_fee_latedate<?php echo $row["fee_id"]; ?>" class="form-control" value="<?php echo $row["fee_lastdate"]; ?>">
                                                    </div>

                                                </div>

                                            </div>
                                            <input type='hidden' name='edit_fee_id' id="edit_fee_id<?php echo $row["fee_id"]; ?>" value='<?php echo $row["fee_id"]; ?>' />
                                            <input type='hidden' name='edit_fee_status' id="edit_fee_status<?php echo $row["fee_id"]; ?>" value='<?php echo $row["fee_astatus"] ?>' />
                                            <input type='hidden' name='action' id="action<?php echo $row["fee_id"]; ?>" value='edit_fees' />
                                            <div class="col-md-12" id="edit_loader_section<?php echo $row["fee_id"]; ?>"></div>
                                            <button type="button" id="edit_fee_button<?php echo $row["fee_id"]; ?>" class="btn btn-primary">Update</button>
                                            <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                        </div>
                                    </form>
                                    <script>
                                        $(function() {
                                            $('#edit_fee_status_button<?php echo $row["fee_id"]; ?>').click(function() {
                                                $('#loader_id<?php echo $row["fee_id"]; ?>').append('<img id = "edit_load" width="20px" src = "images/ajax-loader.gif" alt="Currently loading" />');
                                                $('#edit_fee_status_button<?php echo $row["fee_id"]; ?>').prop('disabled', true);
                                                var action = $("#action<?php echo $row["fee_id"]; ?>").val();
                                                var edit_fee_id = $("#edit_fee_id<?php echo $row["fee_id"]; ?>").val();
                                                var edit_fee_status = $("#edit_fee_status<?php echo $row["fee_id"]; ?>").val();

                                                var dataString = 'action=' + action + '&edit_fee_id=' + edit_fee_id + '&edit_fee_status=' + edit_fee_status;

                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: dataString,
                                                    success: function(result) {
                                                        console.log(result);
                                                        showUpdatedData();

                                                        function showUpdatedData() {
                                                            $.ajax({
                                                                url: 'include/view.php?action=fetch_fees',
                                                                type: 'POST',
                                                                data: $('#feeDetailsForm').serializeArray(),
                                                                success: function(result) {
                                                                    $('#response').remove();
                                                                    $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                }
                                                            });
                                                        }
                                                        $('#loader_id<?php echo $row["fee_id"]; ?>').fadeOut(500, function() {
                                                            $(this).remove();
                                                            $('#edit_fee_status_button<?php echo $row["fee_id"]; ?>').prop('disabled', false);
                                                        });

                                                    }

                                                });

                                            });
                                            $('#edit_fee_button<?php echo $row["fee_id"]; ?>').click(function() {
                                                $('#edit_loader_section<?php echo $row["fee_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                $('#edit_fee_button<?php echo $row["fee_id"]; ?>').prop('disabled', true);
                                                var action = $("#action<?php echo $row["fee_id"]; ?>").val();
                                                var edit_fee_id = $("#edit_fee_id<?php echo $row["fee_id"]; ?>").val();
                                                var edit_fee_course_name = $("#edit_fee_course_name<?php echo $row["fee_id"]; ?>").val();
                                                var edit_fee_particulars = $("#edit_fee_particulars<?php echo $row["fee_id"]; ?>").val();
                                                var edit_fee_amount = $("#edit_fee_amount<?php echo $row["fee_id"]; ?>").val();
                                                var edit_fee_fine = $("#edit_fee_fine<?php echo $row["fee_id"]; ?>").val();
                                                var edit_fee_latedate = $("#edit_fee_latedate<?php echo $row["fee_id"]; ?>").val();

                                                var dataString = 'action=' + action + '&edit_fee_id=' + edit_fee_id + '&edit_fee_course_name=' + edit_fee_course_name + '&edit_fee_particulars=' + edit_fee_particulars + '&edit_fee_amount=' + edit_fee_amount + '&edit_fee_fine=' + edit_fee_fine + '&edit_fee_latedate=' + edit_fee_latedate;

                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: dataString,
                                                    success: function(result) {
                                                        $('#edit_response').remove();
                                                        if (result == "exsits") {
                                                            $('#edit_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Fee Details have already exsits!!!</div></div>');
                                                        }
                                                        if (result == "error") {
                                                            $('#edit_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                        }
                                                        if (result == "empty") {
                                                            $('#edit_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out required Fields!!!</div></div>');
                                                        }
                                                        if (result == "success") {
                                                            $('#edit_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Details Updated successfully!!!</div></div>');
                                                            showUpdatedData();

                                                            function showUpdatedData() {
                                                                $.ajax({
                                                                    url: 'include/view.php?action=fetch_fees',
                                                                    type: 'POST',
                                                                    data: $('#feeDetailsForm').serializeArray(),
                                                                    success: function(result) {
                                                                        $('#response').remove();
                                                                        $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                    }
                                                                });
                                                            }
                                                        }
                                                        $('#edit_loading').fadeOut(500, function() {
                                                            $(this).remove();
                                                        });
                                                        $('#edit_fee_button<?php echo $row["fee_id"]; ?>').prop('disabled', false);
                                                    }

                                                });

                                            });

                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- Fees Edit Section End -->

                            <!-- Fees delete Section Start -->
                            <div id="delete_fees<?php echo $row["fee_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                    <header class="w3-container" style="background:#343a40; color:white;">
                                        <span onclick="document.getElementById('delete_fees<?php echo $row["fee_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                        <h2 align="center">Are you sure???</h2>
                                    </header>
                                    <form id="delete_fee_form<?php echo $row["fee_id"]; ?>" role="form" method="POST">
                                        <div class="card-body">
                                            <div class="col-md-12" id="delete_error_section<?php echo $row["fee_id"]; ?>"></div>
                                            <div class="col-md-12" align="center">
                                                <input type='hidden' name='delete_fee_id' id="delete_fee_id<?php echo $row["fee_id"]; ?>" value='<?php echo $row["fee_id"]; ?>' />
                                                <input type='hidden' name='action' id="action_delete<?php echo $row["fee_id"]; ?>" value='delete_fees' />
                                                <div class="col-md-12" id="delete_loader_section<?php echo $row["fee_id"]; ?>"></div>
                                                <button type="button" id="delete_fee_button<?php echo $row["fee_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                <button type="button" onclick="document.getElementById('delete_fees<?php echo $row["fee_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        $(function() {
                                            $('#delete_fee_button<?php echo $row["fee_id"]; ?>').click(function() {
                                                $('#delete_loader_section<?php echo $row["fee_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                $('#delete_fee_button<?php echo $row["fee_id"]; ?>').prop('disabled', true);
                                                var action = $("#action_delete<?php echo $row["fee_id"]; ?>").val();
                                                var delete_fee_id = $("#delete_fee_id<?php echo $row["fee_id"]; ?>").val();
                                                var dataString = 'action=' + action + '&delete_fee_id=' + delete_fee_id;

                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: dataString,
                                                    success: function(result) {
                                                        $('#delete_response').remove();
                                                        if (result == "error") {
                                                            $('#delete_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                        }
                                                        if (result == "empty") {
                                                            $('#delete_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                        }
                                                        if (result == "success") {
                                                            $('#delete_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Delete successfully!!!</div></div>');
                                                            showUpdatedData();

                                                            function showUpdatedData() {
                                                                $.ajax({
                                                                    url: 'include/view.php?action=fetch_fees',
                                                                    type: 'POST',
                                                                    data: $('#feeDetailsForm').serializeArray(),
                                                                    success: function(result) {
                                                                        $('#response').remove();
                                                                        $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                    }
                                                                });
                                                            }
                                                        }
                                                        console.log(result);
                                                        $('#delete_loading').fadeOut(500, function() {
                                                            $(this).remove();
                                                        });
                                                        $('#delete_fee_button<?php echo $row["fee_id"]; ?>').prop('disabled', false);
                                                    }

                                                });
                                            });

                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- Fees delete Section End -->
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
        <script>
            $(function() {
                $("#example1").DataTable();
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                });
            });
        </script>
        <?php
    }
      
        //Fetching Precious Fees Due Dates Start
      
        if($_GET["action"] == "fetch_examfees"){
            $data = $_POST["data"];

                // $page_no = "7";
                // $autority = json_decode($_SESSION["authority"],true);
                // $permissionVal=explode('||',$autority[$page_no]);
                // $superadmin = $_SESSION["logger_type"];


            ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course Name</th>
                        <th>Particulars</th>
                        <th>Amount</th>
                        <th>Fine</th>
                        <th>Fee Last Date</th>
                        <th>Status</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_examination_fee`
                                WHERE `status` = '$visible' && `exfee_academic_year` = '$data'
                                ORDER BY `course_id` ASC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <?php 
                                        $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["course_id"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                    ?>
                                    <td><?php echo $row_course["course_name"]; ?></td>
                                    <td><?php echo $row["exfee_particulars"] ?></td>
                                    <td><?php echo $row["exfee_amount"] ?></td>
                                    <td><?php echo $row["exfee_fine"] ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row["exfee_lastdate"])) ?></td>
                                    <td> <button type="button" id="edit_examfee_status_button<?php echo $row["exfee_id"]; ?>" class="btn <?php if($row["exfee_astatus"] == "Active") echo "btn-primary"; else echo "btn-warning" ?> btn-sm"><span id="loader_id<?php echo $row["exfee_id"]; ?>"></span> <?php echo $row["exfee_astatus"] ?></button></td>
                                    <td class="project-actions text-center">
                                         <?php
                           // if ((in_array('7_2',$permissionVal))   ||   ($_SESSION["logger_type"] == 'admin')){

                                            ?>

                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_examfees<?php echo $row["exfee_id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </button>

                                    <?php //}  ?>



                                      <?php
                            //if ((in_array('7_3',$permissionVal))   ||   ($_SESSION["logger_type"] == 'admin')){

                                            ?>

                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_examfees<?php echo $row["exfee_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                     <?php //}  ?>

                                    </td>
                                    
                                    <!-- Fees Edit Section Start -->
                                    <div id="edit_examfees<?php echo $row["exfee_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_examfees<?php echo $row["exfee_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Examination Fee</h2>
                                            </header>
                                            <form id="edit_fee_form<?php echo $row["exfee_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["exfee_id"]; ?>"></div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Course Name</label>
                                                                <select name="" id="edit_examfee_course_name<?php echo $row["exfee_id"]; ?>" class="form-control">
                                                                   <?php
                                                                        $sql_c = "SELECT * FROM `tbl_course`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                                        $result_c = $con->query($sql_c);
                                                                        while($row_c = $result_c->fetch_assoc()){
                                                                    ?>
                                                                    <option value="<?php echo $row_c["course_id"]; ?>" <?php if($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?> ><?php echo $row_c["course_name"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Particular</label>
                                                                <input type="text" name="" id="edit_examfee_particulars<?php echo $row["exfee_id"]; ?>" class="form-control" value="<?php echo $row["exfee_particulars"]; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Amount</label>
                                                                <input type="text" name="" id="edit_examfee_amount<?php echo $row["exfee_id"]; ?>" class="form-control" value="<?php echo $row["exfee_amount"]; ?>">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Fine</label>
                                                        <input type="text" name="" id="edit_examfee_fine<?php echo $row["exfee_id"]; ?>" class="form-control" value="<?php echo $row["exfee_fine"]; ?>">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Fee Last Date</label>
                                                        <input type="date" name="" id="edit_examfee_latedate<?php echo $row["exfee_id"]; ?>" class="form-control" value="<?php echo $row["exfee_lastdate"]; ?>">
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <input type='hidden' name='edit_examfee_id' id="edit_examfee_id<?php echo $row["exfee_id"]; ?>" value='<?php echo $row["exfee_id"]; ?>' />
                                                    <input type='hidden' name='edit_examfee_status' id="edit_examfee_status<?php echo $row["exfee_id"]; ?>" value='<?php echo $row["exfee_astatus"] ?>' />
                                                    <input type='hidden' name='action' id="action<?php echo $row["exfee_id"]; ?>" value='edit_examfees' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["exfee_id"]; ?>"></div>
                                                    <button type="button" id="edit_examfee_button<?php echo $row["exfee_id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {
                                                    $('#edit_examfee_status_button<?php echo $row["exfee_id"]; ?>').click(function() {
                                                        $('#loader_id<?php echo $row["exfee_id"]; ?>').append('<img id = "edit_load" width="20px" src = "images/ajax-loader.gif" alt="Currently loading" />');
                                                        $('#edit_examfee_status_button<?php echo $row["exfee_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["exfee_id"]; ?>").val();
                                                        var edit_examfee_id = $("#edit_examfee_id<?php echo $row["exfee_id"]; ?>").val();
                                                        var edit_examfee_status = $("#edit_examfee_status<?php echo $row["exfee_id"]; ?>").val();
                    
                                                        var dataString = 'action='+ action + '&edit_examfee_id='+ edit_examfee_id + '&edit_examfee_status='+ edit_examfee_status;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                console.log(result);
                                                                showUpdatedData();
                                                                function showUpdatedData(){
                                                                    $.ajax({
                                                                        url: 'include/view.php?action=fetch_examfees',
                                                                        type: 'POST',
                                                                        data: $('#feeDetailsForm').serializeArray(),
                                                                        success: function(result) {
                                                                            $('#response').remove();
                                                                            $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                        }
                                                                    });
                                                                }
                                                                $('#loader_id<?php echo $row["exfee_id"]; ?>').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                    $('#edit_examfee_status_button<?php echo $row["exfee_id"]; ?>').prop('disabled', false);
                                                                });
                                                                
                                                            }

                                                        });
                                                        
                                                    });
                                                    $('#edit_examfee_button<?php echo $row["exfee_id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["exfee_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_examfee_button<?php echo $row["exfee_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["exfee_id"]; ?>").val();
                                                        var edit_examfee_id = $("#edit_examfee_id<?php echo $row["exfee_id"]; ?>").val();
                                                        var edit_examfee_course_name = $("#edit_examfee_course_name<?php echo $row["exfee_id"]; ?>").val();
                                                        var edit_examfee_particulars = $("#edit_examfee_particulars<?php echo $row["exfee_id"]; ?>").val();
                                                        var edit_examfee_amount = $("#edit_examfee_amount<?php echo $row["exfee_id"]; ?>").val();
                                                        var edit_examfee_fine = $("#edit_examfee_fine<?php echo $row["exfee_id"]; ?>").val();
                                                        var edit_examfee_latedate = $("#edit_examfee_latedate<?php echo $row["exfee_id"]; ?>").val();
                                                        
                                                        var dataString = 'action='+ action + '&edit_examfee_id='+ edit_examfee_id + '&edit_examfee_course_name='+ edit_examfee_course_name + '&edit_examfee_particulars='+ edit_examfee_particulars + '&edit_examfee_amount='+ edit_examfee_amount+ '&edit_examfee_fine='+ edit_examfee_fine+ '&edit_examfee_latedate='+ edit_examfee_latedate;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#edit_response').remove();
                                                                if(result == "exsits"){
                                                                    $('#edit_error_section<?php echo $row["exfee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Fee Details have already exsits!!!</div></div>');
                                                                }
                                                                if(result == "error"){
                                                                    $('#edit_error_section<?php echo $row["exfee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#edit_error_section<?php echo $row["exfee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out required Fields!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#edit_error_section<?php echo $row["exfee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Details Updated successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=fetch_examfees',
                                                                            type: 'POST',
                                                                            data: $('#feeDetailsForm').serializeArray(),
                                                                            success: function(result) {
                                                                                $('#response').remove();
                                                                                $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#edit_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#edit_examfee_button<?php echo $row["exfee_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                        
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Fees Edit Section End -->
                        
                                    <!-- Fees delete Section Start -->
                                    <div id="delete_examfees<?php echo $row["exfee_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_examfees<?php echo $row["exfee_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_fee_form<?php echo $row["exfee_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["exfee_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_examfee_id' id="delete_examfee_id<?php echo $row["exfee_id"]; ?>" value='<?php echo $row["exfee_id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["exfee_id"]; ?>" value='delete_examfees' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["exfee_id"]; ?>"></div>
                                                        <button type="button" id="delete_examfee_button<?php echo $row["exfee_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_examfees<?php echo $row["exfee_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <script>
                                                $(function() {
                                                    $('#delete_examfee_button<?php echo $row["exfee_id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["exfee_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_examfee_button<?php echo $row["exfee_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["exfee_id"]; ?>").val();
                                                       var delete_examfee_id = $("#delete_examfee_id<?php echo $row["exfee_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_examfee_id='+ delete_examfee_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["exfee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["exfee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["exfee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Exam Fee Delete successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=fetch_examfees',
                                                                            type: 'POST',
                                                                            data: $('#feeDetailsForm').serializeArray(),
                                                                            success: function(result) {
                                                                                $('#response').remove();
                                                                                $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                console.log(result);
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#delete_examfee_button<?php echo $row["exfee_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Fees delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php       
        }

        //Fetching Precious Fees Due Dates Start
        if($_GET["action"] == "fetch_fees"){
            $data = $_POST["data"];
            ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course Name</th>
                        <th>Particulars</th>
                        <th>Amount</th>
                        <th>Fine</th>
                        <th>Fee Last Date</th>
                        <th>Status</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_fee`
                                WHERE `status` = '$visible' && `fee_academic_year` = '$data'
                                ORDER BY `course_id` ASC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <?php 
                                        $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["course_id"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                    ?>
                                    <td><?php echo $row_course["course_name"]; ?></td>
                                    <td><?php echo $row["fee_particulars"] ?></td>
                                    <td><?php echo $row["fee_amount"] ?></td>
                                    <td><?php echo $row["fee_fine"] ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row["fee_lastdate"])) ?></td>
                                     <td> <button type="button" id="edit_fee_status_button<?php echo $row["fee_id"]; ?>" class="btn <?php if($row["fee_astatus"] == "Active") echo "btn-success"; else echo "btn-warning" ?> btn-sm"><span id="loader_id<?php echo $row["fee_id"]; ?>"></span> <?php echo ($row["fee_astatus"] == "Active")?"active":"Inactive"; ?></button></td>

                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_fees<?php echo $row["fee_id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_fees<?php echo $row["fee_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Fees Edit Section Start -->
                                    <div id="edit_fees<?php echo $row["fee_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_fees<?php echo $row["fee_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Fee</h2>
                                            </header>
                                            <form id="edit_fee_form<?php echo $row["fee_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["fee_id"]; ?>"></div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Course Name</label>
                                                                <select name="" id="edit_fee_course_name<?php echo $row["fee_id"]; ?>" class="form-control">
                                                                   <?php
                                                                        $sql_c = "SELECT * FROM `tbl_course`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                                        $result_c = $con->query($sql_c);
                                                                        while($row_c = $result_c->fetch_assoc()){
                                                                    ?>
                                                                    <option value="<?php echo $row_c["course_id"]; ?>" <?php if($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?> ><?php echo $row_c["course_name"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Particular</label>
                                                                <input type="text" name="" id="edit_fee_particulars<?php echo $row["fee_id"]; ?>" class="form-control" value="<?php echo $row["fee_particulars"]; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Amount</label>
                                                                <input type="text" name="" id="edit_fee_amount<?php echo $row["fee_id"]; ?>" class="form-control" value="<?php echo $row["fee_amount"]; ?>">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Fine</label>
                                                                <input type="text" name="" id="edit_fee_fine<?php echo $row["fee_id"]; ?>" class="form-control" value="<?php echo $row["fee_fine"]; ?>">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Fee Last Date</label>
                                                                <input type="date" name="" id="edit_fee_latedate<?php echo $row["fee_id"]; ?>" class="form-control" value="<?php echo $row["fee_lastdate"]; ?>">
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <input type='hidden' name='edit_fee_id' id="edit_fee_id<?php echo $row["fee_id"]; ?>" value='<?php echo $row["fee_id"]; ?>' />
                                                    <input type='hidden' name='edit_fee_status' id="edit_fee_status<?php echo $row["fee_id"]; ?>" value='<?php echo $row["fee_astatus"] ?>' />
                                                    <input type='hidden' name='action' id="action<?php echo $row["fee_id"]; ?>" value='edit_fees' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["fee_id"]; ?>"></div>
                                                    <button type="button" id="edit_fee_button<?php echo $row["fee_id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {
                                                    $('#edit_fee_status_button<?php echo $row["fee_id"]; ?>').click(function() {
                                                        $('#loader_id<?php echo $row["fee_id"]; ?>').append('<img id = "edit_load" width="20px" src = "images/ajax-loader.gif" alt="Currently loading" />');
                                                        $('#edit_fee_status_button<?php echo $row["fee_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["fee_id"]; ?>").val();
                                                        var edit_fee_id = $("#edit_fee_id<?php echo $row["fee_id"]; ?>").val();
                                                        var edit_fee_status = $("#edit_fee_status<?php echo $row["fee_id"]; ?>").val();
                    
                                                        var dataString = 'action='+ action + '&edit_fee_id='+ edit_fee_id + '&edit_fee_status='+ edit_fee_status;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                console.log(result);
                                                                showUpdatedData();
                                                                function showUpdatedData(){
                                                                    $.ajax({
                                                                        url: 'include/view.php?action=fetch_fees',
                                                                        type: 'POST',
                                                                        data: $('#feeDetailsForm').serializeArray(),
                                                                        success: function(result) {
                                                                            $('#response').remove();
                                                                            $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                        }
                                                                    });
                                                                }
                                                                $('#loader_id<?php echo $row["fee_id"]; ?>').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                    $('#edit_fee_status_button<?php echo $row["fee_id"]; ?>').prop('disabled', false);
                                                                });
                                                                
                                                            }

                                                        });
                                                        
                                                    });
                                                    $('#edit_fee_button<?php echo $row["fee_id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["fee_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_fee_button<?php echo $row["fee_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["fee_id"]; ?>").val();
                                                        var edit_fee_id = $("#edit_fee_id<?php echo $row["fee_id"]; ?>").val();
                                                        var edit_fee_course_name = $("#edit_fee_course_name<?php echo $row["fee_id"]; ?>").val();
                                                        var edit_fee_particulars = $("#edit_fee_particulars<?php echo $row["fee_id"]; ?>").val();
                                                        var edit_fee_amount = $("#edit_fee_amount<?php echo $row["fee_id"]; ?>").val();
                                                        var edit_fee_fine = $("#edit_fee_fine<?php echo $row["fee_id"]; ?>").val();
                                                        var edit_fee_latedate = $("#edit_fee_latedate<?php echo $row["fee_id"]; ?>").val();
                                                        
                                                        var dataString = 'action='+ action + '&edit_fee_id='+ edit_fee_id + '&edit_fee_course_name='+ edit_fee_course_name + '&edit_fee_particulars='+ edit_fee_particulars + '&edit_fee_amount='+ edit_fee_amount+ '&edit_fee_fine='+ edit_fee_fine+ '&edit_fee_latedate='+ edit_fee_latedate;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#edit_response').remove();
                                                                if(result == "exsits"){
                                                                    $('#edit_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Fee Details have already exsits!!!</div></div>');
                                                                }
                                                                if(result == "error"){
                                                                    $('#edit_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#edit_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out required Fields!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#edit_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Details Updated successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=fetch_fees',
                                                                            type: 'POST',
                                                                            data: $('#feeDetailsForm').serializeArray(),
                                                                            success: function(result) {
                                                                                $('#response').remove();
                                                                                $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#edit_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#edit_fee_button<?php echo $row["fee_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                        
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Fees Edit Section End -->
                        
                                    <!-- Fees delete Section Start -->
                                    <div id="delete_fees<?php echo $row["fee_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_fees<?php echo $row["fee_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_fee_form<?php echo $row["fee_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["fee_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_fee_id' id="delete_fee_id<?php echo $row["fee_id"]; ?>" value='<?php echo $row["fee_id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["fee_id"]; ?>" value='delete_fees' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["fee_id"]; ?>"></div>
                                                        <button type="button" id="delete_fee_button<?php echo $row["fee_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_fees<?php echo $row["fee_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <script>
                                                $(function() {
                                                    $('#delete_fee_button<?php echo $row["fee_id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["fee_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_fee_button<?php echo $row["fee_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["fee_id"]; ?>").val();
                                                        var delete_fee_id = $("#delete_fee_id<?php echo $row["fee_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_fee_id='+ delete_fee_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["fee_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Delete successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=fetch_fees',
                                                                            type: 'POST',
                                                                            data: $('#feeDetailsForm').serializeArray(),
                                                                            success: function(result) {
                                                                                $('#response').remove();
                                                                                $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                console.log(result);
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#delete_fee_button<?php echo $row["fee_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Fees delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php       
        }
        //Fetching Precious Fees Due Dates Start
        if($_GET["action"] == "fetch_student_list_details"){
            $course_id = $_POST["course_id"];
            $academic_year = $_POST["academic_year"];
            if($academic_year != 0){
            ?>
            <div class="card">
                <div class="card-header card-warning">
                    <form method="POST" action="export-list">
                        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
                        <input type="hidden" name="academic_year" value="<?php echo $academic_year; ?>" />
                        <input type="hidden" name="action" value="export_student_details" />
                        <button type="submit" class="btn btn-warning pull-right float-right"><i class="fa fa-download"></i> Export All</button>
                    </form>
                </div>
            </div>
            <table id="example1" class="table table-bordered table-striped" style="overflow-x:auto;">
                <thead>
                    <tr>
                         <th width="10%">S.No</th>
                        <th  width="10%">Reg. No</th>
                        <th width="10%">Student Name</th>
                        <th width="10%">Course</th>
                        <th width="10%">Father Name</th>
                        <th width="10%">Mother Name</th>
                        <th width="10%">Student Contact No.</th>
                        <th width="10%">Father Contact No.</th>
                        <th width="10%">Father Whatsapp No.</th>
                        <th width="10%">DOB</th>
                        <th width="10%">Gender</th>
                        <!--<th width="10%">Mobile No.</th>-->
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        if($course_id == "all")
                            $sql = "SELECT * FROM `tbl_admission`
                                    WHERE `status` = '$visible' && `admission_session` = '$academic_year'
                                    ORDER BY `admission_id` ASC
                                    ";
                        else
                            $sql = "SELECT * FROM `tbl_admission`
                                    WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_course_name` = '$course_id'
                                    ORDER BY `admission_id` ASC
                                    ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                           $orgDate = $row["admission_dob"];
                            $newDate = date("d-m-Y", strtotime($orgDate));
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <?php 
                                        $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                    ?>
                                     <td><?php echo $row["admission_id"] ?></td>
                                      <td><?php echo $row["admission_first_name"] ?> <?php echo $row["admission_middle_name"] ?> <?php echo $row["admission_last_name"] ?></td>
                                    <td><?php echo $row_course["course_name"]; ?></td>
                                    <td><?php echo $row["admission_father_name"] ?></td>
                                   <td><?php echo $row["admission_mother_name"] ?></td>
                                 <td><?php echo $row["admission_mobile_student"]; ?></td>
                                  <td><?php echo $row["admission_father_phoneno"]; ?></td>
                                  <td><?php echo $row["admission_father_whatsappno"]; ?></td>
                                    <td><?php echo $newDate; ?></td>
                                    <td><?php echo $row["admission_gender"]; ?></td>
                                    <!--<td><?php //echo $row["admission_mobile_student"]; ?></td>-->
                                    <td class="project-actions text-center" id="row_id_<?=$row['admission_id']?>">
                                         <button class="btn btn-info btn-sm" onclick="document.getElementById('view_student_lists<?php echo $row["admission_id"]; ?>').style.display='block'">
                                            <i class="fas fa-eye">
                                            </i>
                                            
                                        </button>
                                        <!--<button class="btn btn-info btn-sm" onclick="document.getElementById('edit_student_lists<?php echo $row["admission_id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </button>-->
                                        <a href="edit_student?id=<?php echo $row['admission_id'];?>"><button class="update btn btn-warning btn-sm"><i class="fas fa-pencil-alt">
                                            </i>
                                            </span></button></a>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            
                                        </button>
                                        
                                         <button onclick="update_status(<?=$row['admission_id']?>,<?=$row['stud_status']?>)" class="btn btn-<?=($row['stud_status']==1?'success':'danger')?>"><?=($row['stud_status']==1?'Active':'Inactive')?></button>
                                    </td>
                                    
                                    <!-- Fees Edit Section Start -->
                                    <div id="edit_student_lists<?php echo $row["admission_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Fee</h2>
                                            </header>
                                            <form id="edit_student_list_form<?php echo $row["admission_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["admission_id"]; ?>"></div>
                                                    <div class="row">
                                                       <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Registration Number</label>
                                                                <input type="text" name="" id="edit_student_list_reg_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_id"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Admission Number</label>
                                                                <input type="text" name="" id="edit_student_list_admission_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_no"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Course Name</label>
                                                                <select name="" id="edit_student_list_course_name<?php echo $row["admission_id"]; ?>" class="form-control">
                                                                   <?php
                                                                        $sql_c = "SELECT * FROM `tbl_course`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                                        $result_c = $con->query($sql_c);
                                                                        while($row_c = $result_c->fetch_assoc()){
                                                                    ?>
                                                                    <option value="<?php echo $row_c["course_id"]; ?>" <?php if($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?> ><?php echo $row_c["course_name"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Session</label>
                                                                <select name="" id="edit_student_list_session<?php echo $row["admission_id"]; ?>" class="form-control">
                                                                   <?php
                                                                        $sql_c = "SELECT * FROM `tbl_university_details`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                                        $result_c = $con->query($sql_c);
                                                                        while($row_c = $result_c->fetch_assoc()){
                                                                    ?>
                                                                    <option value="<?php echo $row_c["university_details_id"]; ?>" <?php if($row_c["university_details_id"] == $row["admission_session"]) echo 'selected'; ?> ><?php echo $row_c["university_details_academic_start_date"]; ?> to <?php echo $row_c["university_details_academic_end_date"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>First Name</label>
                                                                <input type="text" name="" id="edit_student_list_first_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_first_name"]; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Last Name</label>
                                                                <input type="text" name="" id="edit_student_list_last_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_last_name"]; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Contact No</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_mobile_student"]; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="text" name="" id="edit_student_list_email<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_emailid_student"]; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Father's Name</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_name"]; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Contact No</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_phoneno"]; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Hostel</label>
                                                                <select name="" id="edit_student_list_hostel<?php echo $row["admission_id"]; ?>" class="form-control">
                                                                    <option <?php if($row["admission_hostel"] == "Yes") echo "selected"; ?> value="Yes">Yes</option>
                                                                    <option <?php if($row["admission_hostel"] == "No") echo "selected"; ?>  value="No">No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Transport</label>
                                                                <select name="" id="edit_student_list_transport<?php echo $row["admission_id"]; ?>" class="form-control">
                                                                    <option <?php if($row["admission_transport"] == "Yes") echo "selected"; ?> value="Yes">Yes</option>
                                                                    <option <?php if($row["admission_transport"] == "No") echo "selected"; ?>  value="No">No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Username</label>
                                                                <input type="text" name="" id="edit_student_list_username<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_username"]; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="text" name="" id="edit_student_list_password<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_password"]; ?>" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <input type='hidden' name='edit_admission_id' id="edit_admission_id<?php echo $row["admission_id"]; ?>" value='<?php echo $row["admission_id"]; ?>' />
                                                    <input type='hidden' name='action' id="action_student<?php echo $row["admission_id"]; ?>" value='edit_student_lists' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["admission_id"]; ?>"></div>
                                                    <button type="button" id="edit_student_list_button<?php echo $row["admission_id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                            
                                            function update_status(id,status){
                                            //   alert('working');
                                            //   alert(id);
                                            //   alert(status); exit;
                                                  $.ajax({
                                                    type: "POST",
                                                    url: 'include/controller.php',
                                                    data:{"action":"student_status_update","id":id,"status":status},
                                                    success: function(data){
                                                     if(data == "success"){
                                                          $("#row_id_"+id).html(data);
                                                        //  $('#status_response').remove();
                                                        //     $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "status_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Status Updated successfully!!!</div></div>');
                                                                  
                                                                }                                                    
                                                        
                                                    }
                                                
                                                });
                                            }
                                            
                                                $(function() {

                                                    $('#edit_student_list_button<?php echo $row["admission_id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["admission_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_student<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_admission_id = $("#edit_admission_id<?php echo $row["admission_id"]; ?>").val();
                                                        
                                                        var edit_student_list_reg_no = $("#edit_student_list_reg_no<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_admission_no = $("#edit_student_list_admission_no<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_course_name = $("#edit_student_list_course_name<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_session = $("#edit_student_list_session<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_first_name = $("#edit_student_list_first_name<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_last_name = $("#edit_student_list_last_name<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_contact_no = $("#edit_student_list_contact_no<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_email = $("#edit_student_list_email<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_fathers_name = $("#edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_fathers_contact = $("#edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_hostel = $("#edit_student_list_hostel<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_transport = $("#edit_student_list_transport<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_username = $("#edit_student_list_username<?php echo $row["admission_id"]; ?>").val();
                                                        var edit_student_list_password = $("#edit_student_list_password<?php echo $row["admission_id"]; ?>").val();
                                                        
                                                        var dataString = 'action='+ action + '&edit_admission_id='+ edit_admission_id + '&edit_student_list_reg_no='+ edit_student_list_reg_no+ '&edit_student_list_admission_no='+ edit_student_list_admission_no+ '&edit_student_list_course_name='+ edit_student_list_course_name+ '&edit_student_list_session='+ edit_student_list_session+ '&edit_student_list_first_name='+ edit_student_list_first_name+ '&edit_student_list_last_name='+ edit_student_list_last_name+ '&edit_student_list_contact_no='+ edit_student_list_contact_no+ '&edit_student_list_email='+ edit_student_list_email+ '&edit_student_list_fathers_name='+ edit_student_list_fathers_name+ '&edit_student_list_fathers_contact='+ edit_student_list_fathers_contact+ '&edit_student_list_hostel='+ edit_student_list_hostel+ '&edit_student_list_transport='+ edit_student_list_transport+ '&edit_student_list_username='+ edit_student_list_username+ '&edit_student_list_password='+ edit_student_list_password;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                console.log(result);
                                                                $('#edit_response').remove();
                                                                if(result == "exsits"){
                                                                    $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Fee Details have already exsits!!!</div></div>');
                                                                }
                                                                if(result == "error"){
                                                                    $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out required Fields!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Details Updated successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=fetch_student_list_details',
                                                                            type: 'POST',
                                                                            data: $('#fetchStudentDataForm').serializeArray(),
                                                                            success: function(result) {
                                                                                $('#response').remove();
                                                                                $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#edit_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#edit_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                        
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Fees Edit Section End -->
                                    
                                    <!-- Student List view Section Start -->
                                    <div id="view_student_lists<?php echo $row["admission_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:70%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('view_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Student Details</h2>
                                            </header>
                                            <form id="view_student_list_form<?php echo $row["admission_id"]; ?>" role="form" method="POST">
                                                <div class="card-body" style="margin-bottom: 50px;">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["admission_id"]; ?>"></div>
                                                    <div class="row">
                                                       <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Registration Number</label>
                                                                <input type="text" name="" id="edit_student_list_reg_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_id"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Prospectus Number</label>
                                                                <input type="text" name="" id="edit_student_list_reg_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_form_no"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Admission Number</label>
                                                                <input type="text" name="" id="edit_student_list_admission_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_no"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Course Name</label>
                                                                <select name="" id="edit_student_list_course_name<?php echo $row["admission_id"]; ?>" class="form-control" readonly>
                                                                   <?php
                                                                        $sql_c = "SELECT * FROM `tbl_course`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                                        $result_c = $con->query($sql_c);
                                                                        while($row_c = $result_c->fetch_assoc()){
                                                                    ?>
                                                                    <option value="<?php echo $row_c["course_id"]; ?>" <?php if($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?> ><?php echo $row_c["course_name"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Session</label>
                                                                <select name="" id="edit_student_list_session<?php echo $row["admission_id"]; ?>" class="form-control" readonly>
                                                                   <?php
                                                                        $sql_c = "SELECT * FROM `tbl_university_details`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                                        $result_c = $con->query($sql_c);
                                                                        while($row_c = $result_c->fetch_assoc()){
                                                                    ?>
                                                                    <option value="<?php echo $row_c["university_details_id"]; ?>" <?php if($row_c["university_details_id"] == $row["admission_session"]) echo 'selected'; ?> ><?php echo $row_c["university_details_academic_start_date"]; ?> to <?php echo $row_c["university_details_academic_end_date"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Student Name</label>
                                                                <input type="text" name="" id="edit_student_list_first_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_first_name"]; ?>&nbsp;&nbsp;<?php echo $row["admission_middle_name"]; ?>&nbsp;&nbsp;<?php echo $row["admission_last_name"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>DOB</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_dob"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Nationality</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_nationality"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Adhar No</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_aadhar_no"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Date Of Admission</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["date_of_admission"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Category</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_category"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Gender</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_gender"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Username</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_username"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_password"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Blood Group</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_blood_group"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Hostel</label>
                                                                <input type="text" name="" id="edit_student_list_email<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_hostel"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Transport</label>
                                                                <input type="text" name="" id="edit_student_list_email<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_transport"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Image</label>
                                                                <img src="images/student_images/<?php echo $row["admission_profile_image"]; ?>" style="height:100%">
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Student Contact No</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_mobile_student"]; ?>" readonly/>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Student EmailID</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_emailid_student"]; ?>" readonly/>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Father's Name</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_name"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Father Contact No</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_phoneno"]; ?>" readonly/>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Mother's Name</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_mother_name"]; ?>" readonly/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </form>
                                 
                                        </div>
                                    </div>
                                    <!-- student list view Section End -->
                                    
                                    <!-- Fees delete Section Start -->
                                    <div id="delete_student_lists<?php echo $row["admission_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_student_list_form<?php echo $row["admission_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["admission_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_admission_id' id="delete_admission_id<?php echo $row["admission_id"]; ?>" value='<?php echo $row["admission_id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["admission_id"]; ?>" value='delete_student_lists' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["admission_id"]; ?>"></div>
                                                        <button type="button" id="delete_student_list_button<?php echo $row["admission_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <script>
                                                $(function() {
                                                    $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["admission_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["admission_id"]; ?>").val();
                                                        var delete_admission_id = $("#delete_admission_id<?php echo $row["admission_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_admission_id='+ delete_admission_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Student Delete successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=fetch_student_list_details',
                                                                            type: 'POST',
                                                                            data: $('#fetchStudentDataForm').serializeArray(),
                                                                            success: function(result) {
                                                                                $('#response').remove();
                                                                                $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                console.log(result);
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Fees delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php      
            } else
                echo "0";
        }
        //Fetching Precious Fees Due Dates end
        
   /* ------------------------------------------------- Fee Payment Start -------------------------------------------------- */
        // Student fee start
        if($_GET["action"] == "fetch_student_fee_details"){
            $studentRegistrationNo = $_POST["studentRegistrationNo"];
            if(!empty($studentRegistrationNo)){
                $sql = "SELECT *
                        FROM `tbl_admission`
                        INNER JOIN `tbl_university_details` ON `tbl_admission`.`admission_session` = `tbl_university_details`.`university_details_id`
                        INNER JOIN `tbl_course` ON `tbl_admission`.`admission_course_name` = `tbl_course`.`course_id`
                        WHERE `tbl_admission`.`admission_id` = '$studentRegistrationNo' && `tbl_admission`.`status` = '$visible' && `tbl_course`.`status` = '$visible' && `tbl_university_details`.`status` = '$visible'
                        ";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    //Define Variables Section Start
                    //Numeric Veriables
                    $arrayFee = array(); //In Amount or In Number
                    $arrayFine = array(); //In Amount or In Number
                    $arrayRemaining = array(); //In Amount or In Number
                    $arrayRebate = array(); //In Amount or In Number
                    $totalFee = 0; //In Amount or In Number
                    $totalFine = 0; //In Amount or In Number
                    $totalRemaining = 0; //In Amount or In Number
                    $totalRemainings = 0; //In Amount or In Number
                    $totalRebate = 0; //In Amount or In Number
                    $totalPaid = 0; //In Amount or In Number
                    $total_fine_payment=0; //total fine amount 
                    $total_fine_payment_remaining=0;
                    //String Variables
                    $arrayPerticular = array();
                    $arrayTblFee = array();
                    $objTblFee = "";
                    $overall_total_paid=0;
                    $total_fine_after_paying=0;
                    $total_fine_remaining=0;
                    $fee_remaining_from_database=0;
                    $rebate_fine_by_particular=0;
                    $total_rebate_fine_payment=0;
                    $fine_by_particular_remaning=0;

                    function rebate_fine_calculator_by_particular($con,$visible,$studentRegistrationNo,$particular_id){
                        $fine=0; //fine variable is used for calculating the total fine for a particular id 
                        
                      $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND rebate_amount!='' ORDER BY `rebate_amount` ASC ";
                        $resultTblFeePaid = $con->query($sqlTblFeePaid);
            
                        if($resultTblFeePaid->num_rows > 0){
                       
                                while($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()){
    
                                    if($rowTblFeePaid['rebate_amount']>0){

                                    $after_expoide_id=explode(",",$rowTblFeePaid['particular_id']);
                                    $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                                   // echo "<pre>";
                                  //  print_r($after_expoide_id);
                                    for($i=0; $i<count($after_expoide_id); $i++){
                                        if($after_PaidAmount[$i]!=''){
                                            if($particular_id== $after_expoide_id[$i]){
                                            $rebate_fine=  explode(",", $rowTblFeePaid['rebate_amount']) ;
                                            if($rebate_fine[1]==='fine'){
                                              $fine=$fine+$rebate_fine[0];

                                            }
                                            }   
                                        }
                                    }
                                }
                            }
                      }
                        return $fine;
                    }


                    function remaining_fine_calculator_by_particular($con,$visible,$studentRegistrationNo,$particular_id){
                        $fine=0; //fine variable is used for calculating the total fine for a particular id 
                        
                       $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND remaining_fine!='' ORDER BY `remaining_fine` ASC ";
                        $resultTblFeePaid = $con->query($sqlTblFeePaid);
            
                        if($resultTblFeePaid->num_rows > 0){
                       
                                while($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()){
    
                                    if($rowTblFeePaid['remaining_fine']>0){

                                    $after_expoide_id=explode(",",$rowTblFeePaid['particular_id']);
                                    $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                                    for($i=0; $i<count($after_expoide_id); $i++){
                                        if($after_PaidAmount[$i]!=''){
                                            if($particular_id== $after_expoide_id[$i]){
                                            $fine= $rowTblFeePaid['remaining_fine'] ;
                                            }   
                                        }
                                    }
                                }
                            }
                      }
                        return $fine;
                    }



                    //  this function is making for finding the particular paid  fine amount
                    //  $con -> is the connection object for making the connection with the database
                    // $student-> visible is the md5 of string "visible"
                    // $studentRegistration -> number is the student id actully it is stored into the tbl_admission table the id name is 
                        // student_id
                    // $particular_id is the main variable for finding the fine for particular send the particulr id and function return for the particular id 
                      // have any paid fine amount or not if any amout have then return the amount if or it simply retern 0
                    
                      function fine_calculator_by_particular($con,$visible,$studentRegistrationNo,$particular_id){
                        $fine=0; //fine variable is used for calculating the total fine for a particular id 
                        
                       $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND fine!=''";
                        $resultTblFeePaid = $con->query($sqlTblFeePaid);
            
                        if($resultTblFeePaid->num_rows > 0){
                       
                                while($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()){
    
                                    if($rowTblFeePaid['fine']>0){

                                    $after_expoide_id=explode(",",$rowTblFeePaid['particular_id']);
                                    $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                
                                    for($i=0; $i<count($after_expoide_id); $i++){
                                        if($after_PaidAmount[$i]!=''){
                                            if($particular_id== $after_expoide_id[$i]){
                                         $fine=$fine+ $rowTblFeePaid['fine'] ;
                                            }   
                                        }
                                    }
                                }
                            }
                        }
                        return $fine;
                    }

                        // fine calculting total
                        // this function is the so easy function in this function taking 3 arguments
                        //  $con -> is the connection object for making the connection with the database
                        // $student-> visible is the md5 of string "visible"
                        // $studentRegistration -> number is the student id actully it is stored into the tbl_admission table the id name is 
                        // student_id
                        function fine_calculator_by_total($con,$visible,$studentRegistrationNo){
                            $fine=0; //fine variable is used for calculating the total fine for a particular student 
                            
                           $sqlTblFeePaid = "SELECT SUM(fine) as fine
                            FROM `tbl_fee_paid`
                            WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                            AND fine!=''";
                            $resultTblFeePaid = $con->query($sqlTblFeePaid);
                
                            if($resultTblFeePaid->num_rows > 0){
                                $rowTblFeePaid = $resultTblFeePaid->fetch_assoc();
                                    $fine=$rowTblFeePaid['fine'];
                                
                            }
                            return $fine;
                        }



                    //Checking If Hostel If Available Or Not
                    if(strtolower($row["admission_hostel"]) == "yes")
                        $sqlTblFee = "SELECT *
                                     FROM `tbl_fee`
                                     WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."'   ORDER BY `fee_particulars` ASC
                                     ";
                    else
                         $sqlTblFee = "SELECT *
                                     FROM `tbl_fee`
                                     WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."'  AND `fee_particulars` NOT IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees', '1st Year Hostel Fee', '1ST YEAR HOSTEL FEE', '2nd Year Hostel Fee', '2ND YEAR HOSTEL FEE', '3rd Year Hostel Fee', '3RD YEAR HOSTEL FEE', '4th Year Hostel Fee', '4TH YEAR HOSTEL FEE', '5th Year Hostel Fee', '5TH YEAR HOSTEL FEE', '6th Year Hostel Fee', '6TH YEAR HOSTEL FEE','Caution Fee') ORDER BY `fee_particulars` ASC
                                     ";
                    $resultTblFee = $con->query($sqlTblFee);
                    if($resultTblFee->num_rows > 0)
                        while($rowTblFee = $resultTblFee->fetch_assoc()){
                            $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                            if(strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                                $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"])))/60/60/24;
                            else
                                $noOfDays = 0;
                            if($rowTblFee["fee_astatus"] == "Active")
                                $fine_particular = $rowTblFee["fee_fine"];
                            else
                                $fine_particular = 0;
                     
                            $completeArray = array(
                                                "fee_id" => $rowTblFee["fee_id"],
                                                "fee_particulars" => $rowTblFee["fee_particulars"],
                                                "fee_amount" => $rowTblFee["fee_amount"],
                                                "fee_paid" => 0,
                                                "fee_fine" => $fine_particular,
                                                "fee_rebate" => 0,
                                                "fee_remaining" => $rowTblFee["fee_amount"],
                                                "fee_fine_days" => $noOfDays,
                                                "fee_last_date" => $rowTblFee["fee_lastdate"],
                                                "balace_amount"=>0,
                                            );
                            array_push($arrayTblFee, $completeArray);
                        }
                    $arrayTblFee = json_decode(json_encode($arrayTblFee));
                   // echo "<pre>";
                   // print_r($arrayTblFee);
                   $lastpaymentDate ="";
                     $sqlTblFeePaid = "SELECT *
                                     FROM `tbl_fee_paid`
                                     WHERE `status` = '$visible' AND `student_id` = '".$studentRegistrationNo."' AND `payment_status` IN ('cleared', 'pending')
                                     ";
                    $resultTblFeePaid = $con->query($sqlTblFeePaid);
                    
                    if($resultTblFeePaid->num_rows > 0)
                        while($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()){
                            $lastpaymentDate = $rowTblFeePaid; //get last payment data
                           
                            $arrayPaidId = explode(",", $rowTblFeePaid["particular_id"]);
                            $arrayPaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                            for($i=0; $i<count($arrayPaidId); $i++){
                                foreach($arrayTblFee as $arrayTblFeeUpdate){
                                    if($arrayTblFeeUpdate->fee_id == $arrayPaidId[$i]){
                                        $totalPaid = $totalPaid + intval($arrayPaidAmount[$i]);
                                        if($rowTblFeePaid["rebate_amount"] != ""){
                                            $arrayRebateAmount = explode(",", $rowTblFeePaid["rebate_amount"]);
                                            if($arrayTblFeeUpdate->fee_id == intval($arrayRebateAmount[1])){
                                                $totalRebate = $totalRebate + intval($arrayRebateAmount[0]);
                                                $arrayTblFeeUpdate->fee_rebate = $arrayTblFeeUpdate->fee_rebate + intval($arrayRebateAmount[0]);
                                            }
                                        }
                                        $arrayTblFeeUpdate->fee_paid = $arrayTblFeeUpdate->fee_paid + intval($arrayPaidAmount[$i]);
                                        $arrayTblFeeUpdate->fee_remaining = $arrayTblFeeUpdate->fee_remaining - intval($arrayPaidAmount[$i]);
                                    }
                                }
                            }
                               $total_balance_amount_after_pay = ($arrayTblFeeUpdate->balace_amount+$rowTblFeePaid["balance"]);
                        }
                    //Define Variables Section End

                    // echo "<pre>";
                    // print_r( $fineArray);
                   

                    ?>
                        <div class="row">
                            <div class="col-md-4">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <?php 
                                      if(!empty($row["admission_profile_image"])){ 
                                  ?>
                                      <img class="profile-user-img " src="images/student_images/<?php echo $row["admission_profile_image"]; ?>" alt="Student profile picture">
                                  <?php 
                                      } else if(strtolower($row["admission_gender"]) == "female"){  
                                  ?>
                                      <img class="profile-user-img img-fluid img-circle" src="images/womenIcon.png" alt="Student profile picture">
                                  <?php } else{   ?>
                                      <img class="profile-user-img img-fluid img-circle" src="images/menIcon.png" alt="Student profile picture">
                                  <?php } ?>
                                </div>

                                <h3 class="profile-username text-center"><?php echo $row["admission_first_name"]." ".$row["admission_last_name"]; ?></h3>
                                <?php 
                                  $completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
                                  $completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
                                  $completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];
                                ?>
                                <p class="text-muted text-center">( <?php echo $row["course_name"]." | ".$completeSessionOnlyYear ; ?> )</p>

                                  <p>
                                    <b>Reg. No</b> <a class="float-right"><?php echo $row["admission_id"]; ?></a></br>


                                    <b>Course Name</b> <a class="float-right"><?php echo $row["course_name"]; ?></a></br>

                                    <b>Session</b> <a class="float-right"><?php echo $completeSessionOnlyYear; ?></a></br>

                                    <b>Hostel</b> <a class="float-right"><?php echo $row["admission_hostel"]; ?></a></br>

                                    <b>User Name</b> <a class="float-right"><?php echo $row["admission_username"]; ?></a></br>

                                    <b>Status</b> <a class="float-right">Active</a>
                                    </p>

                              </div>
                              <!-- /.card-body -->
                            </div>
                            </div>
                            <div class="col-md-4">  
                            <div class="card card-primary">
                            <div class="card-header">
                            <h3 class="card-title">About <?php echo $row["admission_first_name"]; ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i> Personal Details</strong>
                             <p class="text-muted">
                              <b>Name - </b><?php echo $row["admission_first_name"]." ".$row["admission_last_name"]; ?><br/>
                              <b>Gender - </b><?php echo $row["admission_gender"]; ?><br/>
                              <b>DOB - </b><?php echo $row["admission_dob"]; ?><br/>
                              <b> Nationality - </b><?php echo $row["admission_nationality"]; ?><br/>
                              <b> Blood Group - </b><?php echo $row["admission_blood_group"]; ?><br/>
                              <b> Email - </b><?php echo $row["admission_emailid_student"]; ?><br/>
                              <b>Contact No - </b><?php echo $row["admission_mobile_student"]; ?><br/>
                              <b>Father's Name - </b><?php echo $row["admission_father_name"]; ?><br/>
                              <b>Father's Email - </b><?php echo $row["admission_emailid_father"]; ?><br/>
                              <b>Father's Contact - </b><?php echo $row["admission_father_phoneno"]; ?><br/>
                              <b>Father's Whatsapp - </b><?php echo $row["admission_father_whatsappno"]; ?><br/>
                              <b> Mother's Name - </b><?php echo $row["admission_mother_name"]; ?><br/>
                            </p>
                            </div>
                             </div>
                              </div>
                            <div class="col-md-4">  <!-- About Me Box -->
                            <div class="card card-primary">
                            <div class="card-header">
                            <h3 class="card-title">More Informations</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <h6><i class="fas fa-book mr-1"></i> Educational Details (10th)</h6>
                            <p class="text-muted">
                            University - <?php echo $row["admission_high_school_board_university"]; ?><br/>
                            College - <?php echo $row["admission_high_school_college_name"]; ?><br/>
                            Passing Year - <?php echo $row["admission_high_school_passing_year"]; ?><br/>
                            Percentage - <?php echo $row["admission_high_school_per"]; ?> %<br/>
                            </p>

                            <h6><i class="fas fa-map-marker-alt mr-1"></i> Location</h6>
                            <p class="text-muted">
                            <?php echo $row["admission_residential_address"]; ?>,<br/>
                            <?php echo $row["admission_city"]; ?>, </br><?php echo $row["admission_state"]; ?><br/>
                            <?php echo $row["admission_district"]; ?>,<br/>
                            <?php echo $row["admission_pin_code"]; ?><br/>
                            </p>
                            </div>
                            <!-- /.card-body -->

                            </div>
                            <!-- /.card-body -->
                            </div>

                          <div class="col-md-12">
                            <div class="card">
                              <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                  <li class="nav-item"><a class="nav-link active" href="#payfee" data-toggle="tab">Fee Payment</a></li>
                                  <li class="nav-item"><a class="nav-link" href="#paidfee" data-toggle="tab">Paid Info</a></li>
                                </ul>
                              </div><!-- /.card-header -->
                              <div class="card-body">
                                <div class="tab-content">
                                  <div class="active tab-pane" id="payfee">
                                   <form method="POST" id="PayFeeForm">
                                    <!-- Table row -->
                                      <div class="row">
                                       <input type="hidden" name="registrationNumber" value="<?php echo $studentRegistrationNo; ?>" readonly />
                                       <input type="hidden" name="courseId" value="<?php echo $row["course_id"]; ?>" readonly />
                                       <input type="hidden" name="academicYear" value="<?php echo $row["university_details_id"]; ?>" readonly />
                                        <div class="col-12 table-responsive" style="overflow-x:auto;">
                                          <h5>Fee Details of  <b><a href="javascript:void(0);"><?php echo $row["course_name"]." | ".$completeSessionOnlyYear; ?></a></b></h5>
                                          <table class="table table-bordered table-sm table-responsive-lg">
                                            <thead>
                                            <tr>
                                              <th>S.No</th>
                                              <th>Particulars</th>
                                              <th>Last Date</th>
                                              <th>Amount</th>
                                              <th>Paid</th>
                                              <th>Rebate</th>
                                              <th>Remaining</th>
                                              <th>Fine</th>
                                              <th>Fine paid</th>
                                              <th>Fine Rebate </th>
                                              <th>Fine Remaining</th>
                                              <th>Total Paid</th>
                                              <!-- <sup class="text-yellow ml-1 text-xs">(Including Fine)</sup> -->
                                              <th><span class="text-red">Total Due</span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $Idno = 0;
                                                    $tmpSNo = 1;
                                                    $fine_array=0;
                                                    foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                 
                                                        if(($arrayTblFeeUpdate->fee_remaining-$arrayTblFeeUpdate->fee_rebate)===0){
                                                            $arrayTblFeeUpdate->fee_fine_days=0;
                                                            $arrayTblFeeUpdate->fee_fine=0;
                                                            $fee_remaining_from_database= remaining_fine_calculator_by_particular($con,$visible,$studentRegistrationNo,$arrayTblFeeUpdate->fee_id);
                                                        }else{
                                                          
                                                            $fee_remaining_from_database= 0;
                                                        }
                                                    
                                                      
                                                        
                                                ?>
                                                        <tr>
                                                            <td><?php echo $tmpSNo; ?></td> <!-- serial number -->
                                                            <td><?php echo $arrayTblFeeUpdate->fee_particulars; ?></td>  <!-- particular -->
                                                            <td><?php echo  date("d-m-Y", strtotime($arrayTblFeeUpdate->fee_last_date))  ?></td> <!--  last date -->
                                                            <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_amount); ?></td>  <!-- amount -->
                                                            <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_paid); ?></td>  <!-- paid -->
                                                            <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_rebate); ?></td>  <!-- rebate -->
                                                            
                                                            <!-- Remaining -->
                                                             <td>&#8377; <?php  echo $total_remaining_amount= ($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate); ?></td>
                                                             <?php $totalRemaining= $totalRemaining+$total_remaining_amount;
                                                                        

                                                             ?>
                                                             
                                                                            <!-- Fine -->
                                                                             <td>&#8377; <?php echo $all_fine= ($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days)+$fee_remaining_from_database ?></td> 
                                                                            <!-- total fine -->
                                                                              <?php  $totalFine = $totalFine + $all_fine ?>
                                                                             <!-- Fine paid -->
                                                                             <td>&#8377; <?php echo $fine_by_particular= fine_calculator_by_particular($con,$visible,$studentRegistrationNo,$arrayTblFeeUpdate->fee_id)?></td> 
                                                                           <!-- total fine paid -->
                                                                              <?php $total_fine_payment=$total_fine_payment+$fine_by_particular;   ?>
                                                                           <!-- fine rebate -->
                                                                              <td>&#8377; <?php
                                                                              echo $rebate_fine_by_particular=  rebate_fine_calculator_by_particular($con,$visible,$studentRegistrationNo,$arrayTblFeeUpdate->fee_id);?></td> 
                                                                           <!-- total fine paid -->
                                                                              <?php
                                                                              
                                                                              $total_rebate_fine_payment=$total_rebate_fine_payment+$rebate_fine_by_particular;   ?>

                                                                              <!-- fine remaining  -->
                                                                              <td>&#8377;   <?php
                                                                              if($fine_by_particular_remaning>0){
                                                                              echo $fine_by_particular_remaning=  $all_fine-$fine_by_particular-$rebate_fine_by_particular;
                                                                              } elseif(($all_fine-$fine_by_particular)>0){
                                                                                echo    $fine_by_particular_remaning=  $all_fine-$fine_by_particular;
                                                                              }else{
                                                                                echo    $fine_by_particular_remaning=  $all_fine-$fine_by_particular;

                                                                              } ?></td> 
                                                                            
                                                                              <!-- total fine remaining -->
                                                                              <?php   $total_fine_payment_remaining= $total_fine_payment_remaining+ $fine_by_particular_remaning ?>                                       
                                                                             
                                                                              <!-- Total paid particular -->
                                                                              <td>&#8377; <?php echo $overall_total_paid_particular=  ($arrayTblFeeUpdate->fee_paid)+fine_calculator_by_particular($con,$visible,$studentRegistrationNo,$arrayTblFeeUpdate->fee_id)+$arrayTblFeeUpdate->fee_rebate+$rebate_fine_by_particular ?></td> 
                                                                             
                                                                              <!-- total paid -->
                                                                              <?php   $overall_total_paid= $overall_total_paid+$overall_total_paid_particular ?>
                                                                            
                                                                            
                                                                                <!-- total remaining including fine -->

                                                                             <td><span class="text-red text-bold">&#8377; <?php echo  $total_remaing_amount_final=$total_remaining_amount+$fine_by_particular_remaning  ?></span></td>
                                                                             <?php  $totalRemainings=$totalRemainings+$total_remaing_amount_final;  ?>
                                                                            <?php //} ?>
                                                                             <!--check last payment date -->  
                                                                                <input type="hidden" id="particular_paid_id[<?php echo $Idno; ?>]" name="particular_paid_id[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_id; ?>" />
                                                                                <input type="hidden" id="particular_paid_lastDate[<?php echo $Idno; ?>]" name="particular_paid_lastDate[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_last_date; ?>" />
                                                                                <input type="hidden" id="particular_paid_fineAmount[<?php echo $Idno; ?>]" name="particular_paid_fineAmount[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_fine; ?>" />
                                                                                <input type="hidden" id="particular_paid_amount1[<?php echo $Idno; ?>]" name="particular_paid_amount1[<?php echo $Idno; ?>]" value="<?php echo ($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate) ?>" />
                                                                                <input type="hidden" id="particular_fine_remaining[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="particular_fine_remaining[<?php echo $Idno; ?>]" value="<?php echo $fine_by_particular_remaning  ?>" />
                                                                                <input type="hidden" id="fine_by_particular[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="fine_by_particular[<?php echo $Idno; ?>]" value="<?php echo $fine_by_particular  ?>" />
                     
                                                                                <input type="hidden" id="particular_fine_for_database[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="particular_fine_for_database[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" value="<?php echo $all_fine  ?>" />

                                                                    <?php
                                                            //} ?>

                                                        </tr>
                                                <?php 
                                                        $tmpSNo++;
                                                        $fine_array++;
                                                        $Idno++;
                                                    } 
                                                ?>
                                                <input type="hidden" id="total_fine_payment_remaining" value="<?php echo $total_fine_payment_remaining  ?>" />

                                                <tr>
                                                    <td></td>
                                                    <td class="text-right text-bold"></td>

                                                    <td class="text-right text-bold">Total</td>

                                                    <td class="text-bold">&#8377; <?php echo number_format($totalFee); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($totalPaid); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($totalRebate); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($totalRemaining); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($totalFine); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($total_fine_payment); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($total_rebate_fine_payment); ?></td>
                                                    <td class="text-bold">&#8377; <?php echo number_format($total_fine_payment_remaining); ?></td> 
                                                    <td class="text-bold">&#8377; <?php echo number_format($overall_total_paid); ?></td> 

                                                    <td class="text-bold"><span class="text-red"> &#8377; <?php echo number_format($totalRemainings); ?></span></td>
                                                </tr>
                                            </tbody>
                                          </table>
                                           <div class="col-md-6" style="float:right">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">Payment Date</span>
                                                </div>
                                                <input type="date" name="paymentDate" max="<?php echo date("Y-m-d"); ?>"  id="paymentDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" onkeyup="completeCalculation();" onclick="completeCalculation();" onchange="completeCalculation();" />
                                              </div>
                                              <!-- /.input group -->
                                            </div>
                                        </div>
                                         <h5>Pay Remaining<b><a href="javascript:void(0);"> Fee</a></b></h5>
                                          <p id="errorMessage" class="text-red"></p>
                                          <table class="table table-bordered table-sm">
                                            <thead>
                                            <tr>
                                              <th>S.No</th>
                                              <th>Particulars</th>
                                              <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $tmpSNo = 1;
                                                    $Idno = 0;
                                            
                                                    foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                      
                                                ?>
                                                <tr> 
                                                    <td><?php echo $tmpSNo; ?></td> 
                                                    <td><?php echo $arrayTblFeeUpdate->fee_particulars; ?></td> 
                                                    <td>
                                                       

                                                         <div class="input-group">
                                                          <div class="input-group-prepend">
                                                            <span class="input-group-text">&#8377;</span>
                                                          </div>
                                                          <input id="particular_paid_amount[<?php echo $Idno; ?>]"  name="particular_paid_amount[<?php echo $Idno; ?>]" min="0" max="<?php //echo (($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)); ?>" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" <?php if((($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)) == 0) echo "readonly"; ?> >

                                                        </div>
                                                    </td> 
                                                </tr>
                                                <?php 
                                                        $Idno++;
                                                        $tmpSNo++;
                                                    } 
                                                ?>
                                            <tr> 
                                                <td><?php echo $tmpSNo; ?></td> 
                                                <td>Fine</td> 
                                                <td>
                                                    <div class="input-group">
                                                      <div class="input-group-prepend">
                                                        <span class="input-group-text">&#8377;</span>
                                                      </div>
                                                      <input value="<?php echo $totalFine ?>" id="fine_amount1" name="fine_amount" min="0" max="<?php echo $totalFine; ?>" type="hidden"  >
                                                      <input value="" id="fine_amount" name="fine_amount" min="0" max="<?php echo $totalFine; ?>" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" <?php if($totalFine == 0) echo "readonly"; ?>>
                                                  
                                                      <div class="input-group-prepend">
                                                        <select id="fine_from" onchange="fine_by_remain(this.value)"  name="fine_from" class="btn btn-default btn-block form-control"  >
                                                          <option selected disabled >Fine For</option>
                                                          <?php
                                                              foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                          ?>
                                                          <option value="<?php echo $arrayTblFeeUpdate->fee_id; ?>">For - <?php echo $arrayTblFeeUpdate->fee_particulars; ?></option>
                                                          <?php } ?>
                                                        </select>
                                                      </div>
                                                   
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr> 
                                                <td><?php echo ++$tmpSNo; ?></td> 
                                                <td>Extra Fine</td> 
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">&#8377;</span>
                                                        </div>
                                                        <input id="extra_fine" name="extra_fine" min="0" max="" type="number" class="form-control">
                                                        <div class="input-group-prepend">
                                                            <input type="text" name="extra_fine_description" placeholder="Extra Fine Description"  class="form-control" style="border: 2px solid #dc3545; width: 400px" />
                                                        </div>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr> 
                                                <td><?php echo ++$tmpSNo; ?></td> 
                                                <td>Rebate</td> 
                                                <td>
                                                    <div class="input-group">
                                                      <div class="input-group-prepend">
                                                        <span class="input-group-text">&#8377;</span>
                                                      </div>
                                                      <input id="rebate_amount" name="rebate_amount" min="0" max="" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" >
                                                      <div class="input-group-prepend">
                                                        <select id="rebate_from" name="rebate_from" class="btn btn-default btn-block form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" >
                                                          <option value="">Rebate From</option>
                                                          <?php
                                                              foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                          ?>
                                                          <option value="<?php echo $arrayTblFeeUpdate->fee_id; ?>">From - <?php echo $arrayTblFeeUpdate->fee_particulars; ?></option>
                                                          <?php } ?>
                                                          <option value="fine">From - Fine</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <small class="text-red" id="rebateErr"></small>
                                                </td> 
                                            </tr>
                                            <tr>
                                              <td></td>
                                              <td class="text-right text-bold">Total</td>
                                              <td class="text-bold">
                                                 <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">&#8377;</span>
                                                  </div>
                                                  <input id="total_amount" name="total_amount" min="0" max="<?php echo $totalRemainings ?>" type="number" class="form-control" readonly>
                                                 </div>
                                                 <small class="text-red" id="totalErr"></small>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                              <td class="text-right text-bold">Remaining</td>
                                              <td class="text-bold">
                                                 <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">&#8377;</span>
                                                  </div>
                                                  <input id="remaining_amount" name="remaining_amount" min="0" value="<?php echo $totalRemainings ?>" type="number" style="font-weight: 900;color: #dc3545;" class="form-control" readonly>
                                                 </div>
                                                 <small class="text-red" id="remainingErr"></small>
                                              </td>
                                            </tr>
                                            </tbody>
                                          </table>


                                        </div>
                                        <!-- /.col -->

                                      </div>
                                      <br/>
                                      <div class="row">
                                          <div class="col-md-3">
                                             <label>Payment Mode</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fa fa-university"></i></span>
                                                      </div>
                                                      <select id="PaymentMode" name="PaymentMode" class="form-control" onchange="PaymentModeSelect(this.value);">
                                                          <option value="0">Select</option>
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
                                          <div class="col-md-3" id="cash_div" style="display:none">
                                             <label>Cash Deposit To</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                                                      </div>
                                                      <select id="cashDepositTo" name="cashDepositTo" class="form-control">
                                                          <option value="0">Select</option>
                                                          <option value="University Office">University Office</option>
                                                          <option value="Deposit to Bank">Deposit to Bank</option>
                                                          <option value="City Office">City Office</option>
                                                      </select>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-3" id="bankName_div" style="display:none">
                                              <label>Bank Name</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                                                      </div>
                                                      <input id="bankName" name="bankName" type="text" class="form-control" />
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-4" id="chequeNo_div" style="display:none">
                                              <label>Cheque/DD/NEFT/IMPS/RTGS No</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                                      </div>
                                                      <input id="chequeAndOthersNumber" name="chequeAndOthersNumber" type="text" class="form-control" />
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-4" id="receiptDate_div" style="display:none">
                                              <label>Receipt Date</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                      </div>
                                                      <input id="paidDate" name="paidDate"  type="date" class="form-control datepicker " value="<?php echo date("Y-m-d"); ?>"/>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-6" id="notes_div" style="display:none">
                                              <label>Notes</label>
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                                      </div>
                                                      <textarea id="NotesByAdmin" name="NotesByAdmin" type="text" class="form-control" ></textarea>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-12"></div>
                                          <div class="col-md-12" id="error_on_pay_fee" style="margin-top:20px;"></div>
                                          <div class="col-md-3" id="pay_div" style="display:none; margin-top:20px;">
                                              <div class="form-group">
                                                  <div class="input-group">
                                                     <input type="hidden" name="action" value="pay_fees" />
                                                      <button id="PayFeeButton" name="PayFeeButton" class="btn btn-primary btn-lg btn-block"><span id="loader_section_on_pay_fee"></span> <span id="PayText">Pay</span></button>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>
                                          <div class="col-md-3" id="reset_div" style="margin-top:20px;">
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <button class="btn btn-danger btn-lg btn-block" type="reset" onclick="return confirm('Are you sure you want to reset all Informations???');" >Reset</button>
                                                  </div>
                                                  <!-- /.input group -->
                                              </div>
                                          </div>


                                      </div>
                                      <!-- /.row -->
                                      </form>
                                      <?php 
                                          $sql = "SELECT * FROM `tbl_fee_paid`
                                                  WHERE `status` = '$visible' && `student_id` = '$studentRegistrationNo'
                                                  ORDER BY `feepaid_id` DESC
                                                    ";
                                          $result = $con->query($sql);
                                          $row = $result->fetch_assoc();
                                          ?>
                                          <form action="print" method="POST">
                                          <input type="hidden" name="paidId" value="<?php echo $row["feepaid_id"]; ?>" />
                                              <div class="col-md-3" id="" style="margin-top:20px;">
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                           <button class="btn btn-danger btn-lg btn-block" type="" >Print Receipt</button> 
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                          </form>
                                    <script>

                                 // i have making the function for on which of the semester to getting the fine
                                   function fine_by_remain(particular_id){
                                   var particular_fine_remaining_amount=  document.getElementById("particular_fine_remaining["+particular_id+"]").value
                                    $("#fine_amount").val(particular_fine_remaining_amount);
                                      }



                                     function difference(date1, date2) {  
                                    const date1utc = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
                                    const date2utc = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());
                                    day = 1000*60*60*24;
                                    total_days=(date2utc - date1utc)/day;
                                    if(total_days>0){
                                        return total_days
                                    }else{
                                      return 0;
                                    }
                                     
                                            }


                                        function completeCalculation(){
                                            var total_calculated_fine1=0;
                                            var total_calculated_fine=0;

                                            var particular_fine_remaining_amount=0;
                                            var total_fine_calculated_after=0;
                                            var total_calculated_fine=0;
                                            var particular_id=0;
                                            var totalPaid = 0;
                                            var totalParticular = 0;
                                            var fineAmount = 0;
                                            var rebateAmount = Number(document.getElementById("rebate_amount").value);
                                            if(rebateAmount > 0){
                                                if(document.getElementById("rebate_from").value == ""){
                                                    $("#rebate_amount").addClass("is-invalid");
                                                    $("#rebateErr").html("~ Please select 'Rebate From'");
                                                } else{
                                                    $("#rebate_amount").removeClass("is-invalid");
                                                    $("#rebateErr").html("");
                                                }
                                            } else{
                                                    $("#rebate_amount").removeClass("is-invalid");
                                                    $("#rebateErr").html("");
                                            }
                                            var remainingAmount = 0;
                                            <?php 
                                                $Idno = 0;
                                                foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                    ?>
                                                        if(document.getElementById("particular_paid_amount[<?php echo $Idno; ?>]").value != "")
                                                            totalParticular = totalParticular + parseInt(document.getElementById("particular_paid_amount[<?php echo $Idno; ?>]").value);
                                                    <?php
                                                    $Idno++;
                                                }
                                            ?>
                                            if(document.getElementById("fine_amount").value != 0)
                                                fineAmount = parseInt(document.getElementById("fine_amount").value);
                                                totalPaidd = totalPaid + parseInt(totalParticular);
                                                totalPaid = totalPaidd + parseInt(fineAmount);
                                                paymentDate = document.getElementById("paymentDate").value;  // get payment date
                                           
                                                 //get Last date by id
                                            <?php 
                                                $Idno = 0;
                                                
                                                foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                    ?>
                                                    if(document.getElementById("particular_paid_lastDate[<?php echo $Idno; ?>]").value != "")
                                                      lastDate =  document.getElementById("particular_paid_lastDate[<?php echo $Idno; ?>]").value;
                                                      fineAmount =  document.getElementById("particular_paid_fineAmount[<?php echo $Idno; ?>]").value;
                                                    amountparticularafterpaying= document.getElementById("particular_paid_amount1[<?php echo $Idno; ?>]").value; 
                                                     particular_paid_id1=  document.getElementById("particular_paid_id[<?php echo $Idno; ?>]").value
                                                     // calling fine calculator function
                                                    finecalculator(lastDate,amountparticularafterpaying,particular_paid_id1 )
                                                    <?php
                                                    $Idno++;
                                                } ?>

                                                // fine calculator function
                                               function finecalculator(lastDate,particular_paid_amount1,particular_id){
                                                
                      

                                              if(lastDate <= paymentDate){
                                                 if(particular_paid_amount1!=0){
                                                   // console.log(particular_paid_amount1)
                                                   fine_by_particular=   document.getElementById("fine_by_particular["+particular_id+"]").value

                                                date1 = new Date(lastDate),
                                                date2 = new Date(paymentDate),
                                                noOfDays = difference(date1,date2); 
                                                particular_fine_remaining_amount= (fineAmount * noOfDays)-fine_by_particular;
                                                
     								            document.getElementById("particular_fine_remaining["+particular_id+"]").value=particular_fine_remaining_amount
                                                document.getElementById("particular_fine_for_database["+particular_id+"]").value=particular_fine_remaining_amount

                                               total_calculated_fine= total_calculated_fine+ Number(particular_fine_remaining_amount)
                                                //    console.log(total_calculated_fine)
                                               }else{
                                                particular_fine_remaining_amount= Number(document.getElementById("particular_fine_remaining["+particular_id+"]").value)
                                                total_calculated_fine1=total_calculated_fine1+Number(particular_fine_remaining_amount);
                                                // console.log(total_calculated_fine1)

                                               }
                                             }
                                               }
                                                // Total fine
                                                total_fine_calculated_after=Number(total_calculated_fine1)+Number(total_calculated_fine);

                                                total_fine_paying= Number(document.getElementById("fine_amount").value);
                                                //console.log(total_fine_calculated_after);

                                                remainingAmount = parseInt(<?php echo $totalRemaining; ?>)  - parseInt(totalPaidd)-parseInt(rebateAmount)+parseInt(total_fine_calculated_after)-parseInt(total_fine_paying);

                                               
                                              
                                             


                                            $("#total_amount").val(totalPaid);
                                            $("#remaining_amount").val(remainingAmount);
                                            if(0 > parseInt(remainingAmount)){
                                                $("#remaining_amount").addClass("is-invalid");
                                                $("#remainingErr").html("~ Cannot use negative value, Remaining value must be 'greater than or equal to 0'");
                                                $("#totalErr").html("~ Total value must be 'less than or equal to <?php echo $totalRemainings; ?>'");
                                                $("#total_amount").addClass("is-invalid");
                                            } else{
                                                $("#remaining_amount").removeClass("is-invalid");
                                                $("#total_amount").removeClass("is-invalid");
                                                $("#remainingErr").html("");
                                                $("#totalErr").html("");
                                            }
                                        }

                                    </script>
                                    <script>
                                        function PaymentModeSelect(PaymentMode){
                                            var cash_div = document.getElementById('cash_div');
                                            var bankName_div = document.getElementById('bankName_div');
                                            var chequeNo_div = document.getElementById('chequeNo_div');
                                            var receiptDate_div = document.getElementById('receiptDate_div');
                                            var notes_div = document.getElementById('notes_div');
                                            var pay_div = document.getElementById('pay_div');
                                            if(PaymentMode == "Cash"){
                                                cash_div.style.display = "block";
                                                bankName_div.style.display = "none";
                                                chequeNo_div.style.display = "none";
                                                receiptDate_div.style.display = "block";
                                                notes_div.style.display = "block";
                                                pay_div.style.display = "block";
                                            } else if(PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS"){
                                                        cash_div.style.display = "none";
                                                        bankName_div.style.display = "block";
                                                        chequeNo_div.style.display = "block";
                                                        receiptDate_div.style.display = "block";
                                                        notes_div.style.display = "block";
                                                        pay_div.style.display = "block";
                                                    } else{
                                                        cash_div.style.display = "none";
                                                        bankName_div.style.display = "none";
                                                        chequeNo_div.style.display = "none";
                                                        receiptDate_div.style.display = "none";
                                                        notes_div.style.display = "none";
                                                        pay_div.style.display = "none";
                                                    }
                                        }
                                    </script>
                                    <script>
                                        $(document).ready(function() {
                                            $('#PayFeeForm').submit(function(event) {
                                                $('#PayText').hide();
                                                $('#loader_section_on_pay_fee').append('<img id = "loading" width="30px" src = "images/ajax-loader.gif" alt="Currently loading" />');
                                                $('#PayFeeButton').prop('disabled', true);
                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: $('#PayFeeForm').serializeArray(),
                                                    success: function(result) {
                                                        $('#response_on_pay_fee').remove();
                                                        if(result == "success"){
                                                           $('#error_on_pay_fee').append('<div id = "response_on_pay_fee"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Paid Successfully!!!</div></div>');
                                                            $('#PayFeeForm')[0].reset();
                                                            $('#loading').fadeOut(1000, function() {
                                                                $(this).remove();
                                                                $('#PayText').show();
                                                                $('#PayFeeButton').prop('disabled', false);
                                                                $.ajax({
                                                                    url: 'include/view.php?action=fetch_student_fee_details',
                                                                    type: 'POST',
                                                                    data: $('#fetchStudentDataForm').serializeArray(),
                                                                    success: function(result) {
                                                                        //$("#data_table").html(result);
                                                                        $('#response').remove();
                                                                        if(result == 0){
                                                                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please enter Registration Number!!!</div></div>');
                                                                        } else if(result == 1){
                                                                                    $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                                                                                } else{
                                                                                    //$('#fetchStudentDataForm')[0].reset();
                                                                                    $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                                }
                                                                        $('#loading').fadeOut(500, function() {
                                                                            $(this).remove();
                                                                        });
                                                                        $('#fetchStudentDataButton').prop('disabled', false);
                                                                    }
                                                                });
                                                            });
                                                        } else
                                                            $('#error_on_pay_fee').append('<div id = "response_on_pay_fee">' + result + '</div>');
                                                        $('#loading').fadeOut(500, function() {
                                                            $(this).remove();
                                                            $('#PayText').show();
                                                            $('#PayFeeButton').prop('disabled', false);
                                                        });
                                                    }
                                                });
                                                event.preventDefault();
                                            });
                                        });
                                    </script>
                                  </div>

                                  <!-- /.tab-pane -->
                                  <div class="tab-pane" id="paidfee">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                     <?php 
                                        $sql_paid_time = "SELECT * FROM `tbl_fee_paid`
                                                        WHERE `status` = '$visible' && `student_id` = '$studentRegistrationNo' && `payment_status` != 'deleted'
                                                        ORDER BY `receipt_date` DESC
                                                        ";
                                        $result_paid_time = $con->query($sql_paid_time);
                                        if($result_paid_time->num_rows > 0){
                                        while($row_paid_time = $result_paid_time->fetch_assoc()){
                                            $allPerticulars = explode(",", $row_paid_time["paid_amount"]);
                                            $totalPerticular = 0;
                                            for($i=0; $i<count($allPerticulars); $i++)
                                                $totalPerticular = $totalPerticular + intval($allPerticulars[$i]);
                                            $totalAmount = $totalPerticular + intval($row_paid_time["fine"]) - intval($row_paid_time["rebate_amount"]);

                                     ?>
                                      <!-- Timeline Section Start -- >
                                           timeline time label -->
                                          <div class="time-label">
                                            <span class="bg-success">
                                              <?php echo date("d M, Y", strtotime($row_paid_time["receipt_date"])); ?>
                                            </span>
                                          </div>
                                          <!-- /.timeline-label -->
                                          <!-- timeline item -->
                                          <div>
                                            <i class="fas fa-money-check bg-info"></i>

                                            <div id="fee_Status_section_full<?php echo $row_paid_time["feepaid_id"]; ?>" class="timeline-item" style="background-color:<?php if(strtolower($row_paid_time["payment_status"]) == "bounced") echo '#ffcccb'; if(strtolower($row_paid_time["payment_status"]) == "pending") echo '#ffffed'; if(strtolower($row_paid_time["payment_status"]) == "refunded") echo '#ffa7a7'; ?>;">
                                              <span class="time"><i class="far fa-clock"></i> <?php echo $row_paid_time["fee_paid_time"]; ?> </span>

                                              <h3 class="timeline-header"><a href="javascript:void(0);">Payment Information</a></h3>

                                              <div class="timeline-body">
                                                 <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                      <th>Total Perticular</th>
                                                      <th>Fine</th>
                                                      <th>Extra Fine</th>
                                                      <th>Rebate</th>
                                                      <th>Total Paid</th>
                                                      <th><span class="text-red">Remaining</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                      <td>&#8377; <?php echo number_format(intval($totalPerticular)); ?></td>
                                                      <td>&#8377; <?php echo number_format(intval($row_paid_time["fine"])); ?></td>
                                                      <?php
                                                        $show_extra_fine = 0;
                                                        $show_extra_fine_msg = "";
                                                        if(!empty($row_paid_time["extra_fine"])){
                                                            $show_extra = explode("|separator|", $row_paid_time["extra_fine"]);
                                                            $show_extra_fine = $show_extra[0];
                                                            if(isset($show_extra[1])){
                                                                $show_extra_fine_msg = $show_extra[1];
                                                            }
                                                        }
                                                      ?>
                                                      <?php 
                                                        if(empty($show_extra_fine_msg)):
                                                      ?>
                                                      <td>&#8377; <?php echo number_format(intval($show_extra_fine)); ?></td>
                                                      <?php 
                                                        else:
                                                      ?>
                                                      <td>&#8377; <?php echo number_format(intval($show_extra_fine)); ?> <br/> <small class="text-danger"><?= htmlspecialchars_decode($show_extra_fine_msg) ?></small></td>
                                                      <?php 
                                                        endif;
                                                      ?>
                                                      <td>&#8377; <?php echo number_format(intval($row_paid_time["rebate_amount"])); ?></td>
                                                      <td>&#8377; <?php echo number_format(intval($totalAmount) + intval($row_paid_time["rebate_amount"]) + intval($show_extra_fine)); ?></td>
                                                      <td>&#8377; <?php echo number_format(intval($row_paid_time["balance"])); ?></td>
                                                    </tr>
                                                    </tbody>
                                                  </table>

                                                <h5 class="timeline-header"><a href="javascript:void(0);">Payment Mode</a> ~ <?php echo $row_paid_time["payment_mode"]; ?></h5>
                                                <h5 class="timeline-header"><a href="javascript:void(0);">Payment Status</a> ~ <span id="fee_Status_section<?php echo $row_paid_time["feepaid_id"]; ?>"><span class="<?php if(strtolower($row_paid_time["payment_status"]) == "bounced") echo 'bg-danger';
                                            if(strtolower($row_paid_time["payment_status"]) == "refunded") echo 'bg-danger'; else if(strtolower($row_paid_time["payment_status"]) == "pending") echo 'bg-warning'; ?>"><?php echo strtoupper($row_paid_time["payment_status"]); ?></span></span> </h5>
                                              </div>
                                              <div class="timeline-footer" align="right">
                                               <h5 class="timeline-header"><a href="javascript:void(0);">Give Status Here</a></h5>
                                                <?php if($row_paid_time["payment_status"] == "refunded"){ ?>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'cleared')" class="btn btn-info btn-sm">Add this Fee</a>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'deleted')" class="btn btn-danger btn-sm">Delete</a>
                                                <?php } else{
                                                    ?>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'refunded')" class="btn btn-info btn-sm">Refund</a>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'deleted')" class="btn btn-danger btn-sm">Delete</a>
                                                    <?php    
                                                } ?>
                                                <?php if($row_paid_time["payment_mode"] == "Cheque"){ ?>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'cleared')" class="btn btn-success btn-sm">Cleared</a>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'pending')" class="btn btn-warning btn-sm">Pending</a>
                                                    <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'bounced')" class="btn btn-danger btn-sm">Bounced</a>
                                              <?php } ?>
                                              </div>
                                            </div>
                                          </div>
                                          <!-- END timeline item -->
                                      <!-- Timeline Section End -->
                                      <?php } 
                                        } else{
                                            ?>
                                            <center><b class="text-red">No any Payment Yet!!!</b></center>
                                            <?php
                                        }?>
                                      <div>
                                        <i class="fas fa-money-bill-alt bg-danger"></i>
                                      </div>
                                      <script>
                                          function statusChange(feepaid_id, statusUpdate){
                                              $('#paidfee').css("opacity", "0.4");
                                              $('#paidfee').css("pointer-events", "none");
                                              var action = "change_Fee_Status";
                                              var dataString = 'action='+ action + '&feepaid_id='+ feepaid_id + '&status='+ statusUpdate;
                                              $.ajax({
                                                url: 'include/controller.php',
                                                type: 'POST',
                                                data: dataString,
                                                success: function(result) {
                                                    if(result != "error" && result != "empty"){
                                                        console.log(result);
                                                        var fullinfo = result.split(',');
                                                        $('#fee_Status_section'+feepaid_id).html(fullinfo[0]);
                                                        $('#fee_Status_section_full'+feepaid_id).css("background-color", fullinfo[1]);
                                                        $.ajax({
                                                            url: 'include/view.php?action=fetch_student_fee_details',
                                                            type: 'POST',
                                                            data: $('#fetchStudentDataForm').serializeArray(),
                                                            success: function(result) {
                                                                //$("#data_table").html(result);
                                                                $('#response').remove();
                                                                if(result == 0){
                                                                    $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please enter Registration Number!!!</div></div>');
                                                                } else if(result == 1){
                                                                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                                                                        } else{
                                                                            //$('#fetchStudentDataForm')[0].reset();
                                                                            $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                        }
                                                                $('#loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#fetchStudentDataButton').prop('disabled', false);
                                                            }
                                                        });
                                                    }
                                                }
                                            });
                                          }
                                      </script>
                                    </div>
                                  </div>
                                  <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                              </div><!-- /.card-body -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                          </div>
                          <!-- /.col -->
                        </div>
                    <?php
                } else
                    echo '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  No Student Found!!!</div>';
            } else
                echo "0"; 
        }
        //Student fee End
        //Student fee End
        //  fee Calculations Details start
        if($_GET["action"] == "completeCalculationForFees"){
            $completeCalculationArray = array();
            $totalAmountArry = array();
            $totalPerticularArry = array();
            $completeCalculation = "";
            $paid_perticular_amount = 0;
            $remaining_perticular_amount = 0;
            $fine_perticular_amount = 0;
            $total_perticular_amount = 0;
            $total_paid_perticular_amount = 0;
            $total_remaining_perticular_amount = 0;
            $total_fine_perticular_amount = 0;
            $total_total_perticular_amount = 0;
            $particular_paid_amount = 0;
            $fine_amount = 0;
            $rebate_amount = 0;
            $total_amount = 0;
            $remaining_amount = 0;
            $last_fine = 0;
            $errorMessage = "";
            $registrationNumber = $_POST["registrationNumber"];
            $academicYear = $_POST["academicYear"];
            $courseId = $_POST["courseId"];
            $hostelCheck = $_POST["hostelCheck"];
            $paymentDate = $_POST["paymentDate"];
            $sql_paid = "SELECT * FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' && `student_id` = '$registrationNumber' && `university_details_id` = '$academicYear'
                        ";
            $result_paid = $con->query($sql_paid);
            while($row_paid = $result_paid->fetch_assoc()){
                $last_balance = $row_paid["balance"];
                $last_fine = intval($row_paid["fine"]);
                $amountsPaid = explode(",",$row_paid["paid_amount"]);
                $totalPerticularArry = explode(",",$row_paid["particular_id"]);
                $totalAmountVal = 0;
                for($i=0; $i<count($amountsPaid); $i++){
                    if(!isset($totalAmountArry[$i]) && empty($totalAmountArry[$i]))
                        $totalAmountArry[$i] = 0;
                    $totalAmountArry[$i] = $totalAmountArry[$i] + intval($amountsPaid[$i]);
                }
                if($last_balance == 0)
                    $submitClose = "";
            }
            $sql_fee = "SELECT * FROM `tbl_fee`
                        WHERE `status` = '$visible' && `course_id` = '$courseId' && `fee_academic_year` = '$academicYear'
                       ";
            $result_fee = $con->query($sql_fee);
            $sno = 0;
            $Idno = 0;
            $total_fees = 0;
            $total_paid = 0;
            $total_remaining = 0;
            $total_fine = 0;
            while($row_fee = $result_fee->fetch_assoc()){
                $fee_perticular = 0;
                if(strtolower($hostelCheck) == "yes"){
                    $sno++;
                    $total_fees = $total_fees + $row_fee["fee_amount"];
                    $fine_perticular_amountArray[$Idno] = 0;
                    $total_perticular_amountArray[$Idno] = 0;
                    if(isset($totalAmountArry[$Idno])){ 
                        $total_paid = $total_paid + $totalAmountArry[$Idno];
                        if($totalAmountArry[$Idno] == $row_fee["fee_amount"]){
                            $total_fine = $total_fine + 0;
                            $fee_perticular = 0;
                            $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                            $total_perticular_amountArray[$Idno] = $fee_perticular; 
                        } else{
                            $beforeDate = date($row_fee["fee_lastdate"]);
                            if( $paymentDate > $beforeDate){
                                if($row_fee["fee_astatus"] == "Active"){
                                    $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate))/60/60/24; 
                                    $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fee_perticular = $fee_perticular + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fine_perticular_amountArray[$Idno] = $fee_perticular;  
                                }   
                            }
                            $total_perticular_amountArray[$Idno] = $row_fee["fee_amount"] + ($fee_perticular + $totalAmountArry[$Idno]); 
                        }
                    } else{ 
                        $beforeDate = date($row_fee["fee_lastdate"]);
                        if( $paymentDate > $beforeDate){
                            if($row_fee["fee_astatus"] == "Active"){
                                $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate))/60/60/24; 
                                $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                $fee_perticular = $fee_perticular + ($numberOfDays * intval($row_fee["fee_fine"]));
                                $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                            }
                        }
                        $total_perticular_amountArray[$Idno] = $fee_perticular + $row_fee["fee_amount"];
                    } 
                    $Idno++; 
                }   
                else{
                    if(strtolower($row_fee["fee_particulars"]) != "hostel fee"){
                        $sno++;
                        $total_fees = $total_fees + $row_fee["fee_amount"];
                        $fine_perticular_amountArray[$Idno] = 0;
                        if(isset($totalAmountArry[$Idno])){ 
                            $total_paid = $total_paid + $totalAmountArry[$Idno];
                            if($totalAmountArry[$Idno] == $row_fee["fee_amount"]){
                                $total_fine = $total_fine + 0;
                                $fee_perticular = 0;
                                $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                                $total_perticular_amountArray[$Idno] = $fee_perticular; 
                            } else{
                                $beforeDate = date($row_fee["fee_lastdate"]);
                                if( $paymentDate > $beforeDate){
                                    if($row_fee["fee_astatus"] == "Active"){
                                        $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate))/60/60/24; 
                                        $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                        $fee_perticular = $numberOfDays * intval($row_fee["fee_fine"]);
                                        $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                                        $total_perticular_amountArray[$Idno] = $fee_perticular + $totalAmountArry[$Idno]; 
                                    }
                                }
                                $total_perticular_amountArray[$Idno] = $row_fee["fee_amount"] + ($fee_perticular + $totalAmountArry[$Idno]); 
                            }
                        } else{ 
                            $beforeDate = date($row_fee["fee_lastdate"]);
                            if( $paymentDate > $beforeDate){
                                if($row_fee["fee_astatus"] == "Active"){
                                    $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate))/60/60/24; 
                                    $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fee_perticular = $fee_perticular + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fine_perticular_amountArray[$Idno] = $fee_perticular; 
                                }
                                    
                            }
                            $total_perticular_amountArray[$Idno] = $fee_perticular + $row_fee["fee_amount"]; 
                        }
                        $Idno++;
                    }
                } 
            }
            $total_remaining = $total_fine + ($total_fees-$total_paid);
            
            if(!empty($_POST["fine_amount"]))
                $fine_amount = $_POST["fine_amount"];
            if(!empty($_POST["rebate_amount"]))
                $rebate_amount = $_POST["rebate_amount"];
            for($i=0; $i<count($_POST["particular_paid_amount"]); $i++)
            {
                if(!empty($_POST["particular_paid_amount"][$i]))
                    $total_amount = $total_amount + intval($_POST["particular_paid_amount"][$i]);
            }
            //Total Amount With Fee
            $total_amount = $total_amount + $fine_amount;
            //Total Amount With Rebate
            $total_amount = $total_amount - $rebate_amount;
            //Remaining Total
            $remaining_amount = $total_remaining - $total_amount;
            //Remaining Total Amount With Rebate
            $remaining_amount = $remaining_amount - $rebate_amount;
            //Fine Arrays
            $fine_perticular_amount = implode("|", $fine_perticular_amountArray);
            $total_perticular_amount = implode("|", $total_perticular_amountArray);
            //Set Negative Error
            if($total_amount<0 || $remaining_amount<0 || $fine_perticular_amount<0)
                $errorMessage .= " Connot Use Negative Values.";
            if($total_amount>$total_remaining)
                $errorMessage .= " Your total amount Should be less than or equal to ~ $total_remaining.";
            //Complete Calculation
            $completeCalculationArray[] = $total_remaining;
            $completeCalculationArray[] = $total_amount;
            $completeCalculationArray[] = $remaining_amount;
            $completeCalculationArray[] = $fine_perticular_amount;
            $completeCalculationArray[] = $total_perticular_amount;
            $completeCalculationArray[] = $errorMessage;
            //Implode all the Calculations
            $completeCalculation = implode(",", $completeCalculationArray);
            echo $completeCalculation;
        }
        // fee Calculations Details End
        /* ------------------------------------------------ Fee Payment End ------------------------------------------------------- */
        
        //  Hostel Fee List start
        if($_GET["action"] == "fetch_hostel_list_details"){
            $course_id = $_POST["course_id"];
            $academic_year = $_POST["academic_year"]; ?>
            <div class="card">
                <div class="card-header">
                    <form method="POST" action="export_hostel_fee_list.php">
                        <input type="hidden" name="course_id" value="<?= $course_id ?>" />
                        <input type="hidden" name="academic_year" value="<?= $academic_year ?>" />
                        <input type="hidden" name="action" value="export_hostelfees_details" />
                        <button type="submit" class="btn btn-warning float-right"><i class="fa fa-download"></i> Export All</button>
                    </form>
                </div>
            </div>
            
              <?php if(!empty($course_id && $academic_year)){ ?> 
                
                <table id="example1" class="table table-bordered table-striped table-responsive" style="overflow-x:auto;">
                    <thead>
                        <tr>
                             <th width="10%">S.No</th>
                            <th  width="10%">Reg. No</th>
                            <th  width="10%">Hostel</th>
                            <th width="10%">Student Name</th>
                            <th width="10%">Course</th>
                            <th width="10%">Father Name</th>
                            <th width="10%">Mother Name</th>
                            <th width="10%">Contact</th>
                            <th width="10%">Session</th>
                            <th class="project-actions text-center">Paid Status </th>
                        </tr>
                    </thead>
                    <tbody>         
                       <?php 
                            if($course_id == "all" && $academic_year == "all")
                            $sql = "SELECT * FROM `tbl_admission`
                                        WHERE `status` = '$visible' && `admission_hostel` = 'Yes'
                                        ORDER BY `admission_id` ASC
                                        ";
                               
                            elseif($academic_year == "all")
                                $sql = "SELECT * FROM `tbl_admission`
                                        WHERE `status` = '$visible' && `admission_course_name` = '$course_id' && `admission_hostel` = 'Yes'
                                        ORDER BY `admission_id` ASC
                                        ";
                            elseif($course_id == "all")
                                $sql = "SELECT * FROM `tbl_admission`
                                        WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_hostel` = 'Yes'
                                        ORDER BY `admission_id` ASC
                                        ";
                            else
                                $sql = "SELECT * FROM `tbl_admission`
                                        WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_course_name` = '$course_id' && `admission_hostel` = 'Yes'
                                        ORDER BY `admission_id` ASC
                                        ";
                            $result = $con->query($sql);
                            if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                ?>
                                    <tr>
                                        <td><?php echo $s_no; ?></td>
                                        <?php 
                                            $sql_course = "SELECT * FROM `tbl_course`
                                                           WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';
                                                           ";
                                            $result_course = $con->query($sql_course);
                                            $row_course = $result_course->fetch_assoc();
                                        ?>
                                         <td><?php echo $row["admission_id"] ?></td>
                                         <td>Yes</td>
                                          <td><?php echo $row["admission_first_name"] ?> <?php echo $row["admission_middle_name"] ?> <?php echo $row["admission_last_name"] ?></td>
                                        <td><?php echo $row_course["course_name"]; ?></td>

                                        <td><?php echo $row["admission_father_name"] ?></td>
                                       <td><?php echo $row["admission_mother_name"] ?></td>
                                     <td>  <?php echo $row["admission_mobile_student"]; ?></td>
  <?php 
                        $sql_session = "SELECT * FROM `tbl_university_details` WHERE `university_details_id` = '".$row["admission_session"]."' ";
                                   $result_session = $con->query($sql_session);
                                   $row_session = $result_session->fetch_assoc();
                                   ?>

                                     <td><?php echo intval($row_session["university_details_academic_start_date"])." - ".intval($row_session["university_details_academic_end_date"]); ?></td>                                          <td class="project-actions text-center">
                                            <table class="table table-bordered table-striped table-responsive">
                                                <thead>
                                                    <tr>
                                                    <th width="10%">S.No</th>
                                                    <th width="10%">Particular Name</th>
                                                    <th  width="10%">Amount </th>
                                                    <th  width="10%">Paid</th>
                                                    <th width="10%">Rebate</th>
                                                    <th width="10%">Fine</th>
                                                    <th width="10%">Balance</th>
                                                    <th width="10%">Fee Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $arrayFee = array(); //In Amount or In Number
                                                    $arrayFine = array(); //In Amount or In Number
                                                    $arrayRemaining = array(); //In Amount or In Number
                                                    $arrayRebate = array(); //In Amount or In Number
                                                    $totalFee = 0; //In Amount or In Number
                                                    $totalFine = 0; //In Amount or In Number
                                                    $totalRemaining = 0; //In Amount or In Number
                                                    $totalRemainings = 0; //In Amount or In Number
                                                    $totalRebate = 0; //In Amount or In Number
                                                    $totalPaid = 0; //In Amount or In Number
                                                    //String Variables
                                                    $arrayPerticular = array();
                                                    $arrayTblFee = array();
                                                    $objTblFee = "";
                                                    //Checking If Hostel If Available Or Not
                                                    $sqlTblFee = "SELECT *
                                                                 FROM `tbl_fee`
                                                                 WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' AND `fee_particulars` IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees', '1st Year Hostel Fee', '1ST YEAR HOSTEL FEE', '2nd Year Hostel Fee', '2ND YEAR HOSTEL FEE', '3rd Year Hostel Fee', '3RD YEAR HOSTEL FEE', '4th Year Hostel Fee', '4TH YEAR HOSTEL FEE', '5th Year Hostel Fee', '5TH YEAR HOSTEL FEE', '6th Year Hostel Fee', '6TH YEAR HOSTEL FEE') ORDER BY `fee_particulars` ASC
                                                                 ";
                                                    $resultTblFee = $con->query($sqlTblFee);
                                                    if($resultTblFee->num_rows > 0)
                                                        while($rowTblFee = $resultTblFee->fetch_assoc()){
                                                            $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                                                            if(strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                                                                $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"])))/60/60/24;
                                                            else
                                                                $noOfDays = 0;
                                                        if($rowTblFee["fee_astatus"] == "Active")
                                                                $fine_particular = $rowTblFee["fee_fine"];
                                                            else
                                                                $fine_particular = 0;
                                                            $completeArray = array(
                                                                                "fee_id" => $rowTblFee["fee_id"],
                                                                                "fee_particulars" => $rowTblFee["fee_particulars"],
                                                                                "fee_amount" => $rowTblFee["fee_amount"],
                                                                                "fee_paid" => 0,
                                                                                "fee_fine" => $fine_particular,
                                                                                "fee_rebate" => 0,
                                                                                "fee_remaining" => $rowTblFee["fee_amount"],
                                                                                "fee_fine_days" => $noOfDays
                                                                            );
                                                            array_push($arrayTblFee, $completeArray);
                                                        }
                                                    $arrayTblFee = json_decode(json_encode($arrayTblFee));
                                                    $sqlTblFeePaid = "SELECT *
                                                                     FROM `tbl_fee_paid`
                                                                     WHERE `status` = '$visible' AND `student_id` = '".$row["admission_id"]."' AND `payment_status` IN ('cleared', 'pending')
                                                                     ";
                                                    $resultTblFeePaid = $con->query($sqlTblFeePaid);
                                                    if($resultTblFeePaid->num_rows > 0)
                                                        while($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()){
                                                            $arrayPaidId = explode(",", $rowTblFeePaid["particular_id"]);
                                                            $arrayPaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                                                            for($i=0; $i<count($arrayPaidId); $i++){
                                                                foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                                    if($arrayTblFeeUpdate->fee_id == $arrayPaidId[$i]){
                                                                        $totalPaid = $totalPaid + intval($arrayPaidAmount[$i]);
                                                                        if($rowTblFeePaid["rebate_amount"] != ""){
                                                                            $arrayRebateAmount = explode(",", $rowTblFeePaid["rebate_amount"]);
                                                                            if($arrayTblFeeUpdate->fee_id == intval($arrayRebateAmount[1])){
                                                                                $totalRebate = $totalRebate + intval($arrayRebateAmount[0]);
                                                                                $arrayTblFeeUpdate->fee_rebate = $arrayTblFeeUpdate->fee_rebate + intval($arrayRebateAmount[0]);
                                                                            }
                                                                        }
                                                                        $arrayTblFeeUpdate->fee_paid = $arrayTblFeeUpdate->fee_paid + intval($arrayPaidAmount[$i]);
                                                                        $arrayTblFeeUpdate->fee_remaining = $arrayTblFeeUpdate->fee_remaining - intval($arrayPaidAmount[$i]);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        $tmpSNo = 1;
                                                        foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                            if((($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)) == 0){
                                                                $totalRemainings = $totalRemainings + 0;
                                                                $totalRemaining = $totalRemaining + 0;
                                                                $totalFine = $totalFine + 0;
                                                            }
                                                            else{
                                                                $totalRemainings = $totalRemainings + (($arrayTblFeeUpdate->fee_remaining) + (($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days)) - ($arrayTblFeeUpdate->fee_rebate));
                                                                $totalRemaining = $totalRemaining + (($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate));
                                                                $totalFine = $totalFine + (($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days));
                                                            }

                                                    ?>
                                                            <tr>
                                                                <td><?php echo $tmpSNo; ?></td>
                                                                <td><?php echo $arrayTblFeeUpdate->fee_particulars; ?></td>
                                                                <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_amount); ?></td>
                                                                <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_paid); ?></td>
                                                                <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_rebate); ?></td>
                                                                <?php
                                                                    if((($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)) == 0){
                                                                ?>
                                                                    <td>&#8377; <?php echo 0; ?></td>
                                                                    <td>&#8377; <?php echo 0; ?></td>
                                                                    <?php
                                                                        $sqlTblFeeStatus = "SELECT *
                                                                                             FROM `tbl_fee_status`
                                                                                             WHERE `particular_id` = '".$arrayTblFeeUpdate->fee_id."' AND `admission_id` = '".$row["admission_id"]."' AND `course_id` = '".$row["admission_course_name"]."' AND `academic_year` = '".$row["admission_session"]."'
                                                                                             ";
                                                                        $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                                                                        if($resultTblFeeStatus->num_rows > 0){
                                                                            $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                                                                            if(strtolower($rowTblFeeStatus["fee_status"]) == "dues"){
                                                                            ?>
                                                                            <td> <button type="button" id="edit_fee_status_button<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>" class="btn btn-warning btn-sm"><span id="loader_id<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>"></span> Dues</button></td>
                                                                            <!--<td><button type="button" class="btn btn-danger"><?= $rowTblFeeStatus["fee_status"] ?></button></td>-->
                                                                            <?php 
                                                                            } else{
                                                                                ?>
                                                                            <td> <button type="button" id="edit_fee_status_button<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>" class="btn btn-primary btn-sm"><span id="loader_id<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>"></span> No Dues</button></td>
                                                                            <?php 
                                                                            }
                                                                        } else{
                                                                    ?>
                                                                            <td> <button type="button" id="edit_fee_status_button<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>" class="btn btn-warning btn-sm"><span id="loader_id<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>"></span> Dues</button></td>
                                                                        <?php } } else{
                                                                        ?>
                                                                        <td>&#8377; <?php echo number_format(($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days)); ?></td>
                                                                            <!--<td>&#8377; <?php echo number_format(($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate)); ?></td>-->                                 
                                                                        <td><span class="text-red text-bold">&#8377; <?php echo number_format(($arrayTblFeeUpdate->fee_remaining) + (($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days)) - ($arrayTblFeeUpdate->fee_rebate)); ?></span></td>
                                                                            <?php
                                                                                $sqlTblFeeStatus = "SELECT *
                                                                                                     FROM `tbl_fee_status`
                                                                                                     WHERE `particular_id` = '".$arrayTblFeeUpdate->fee_id."' AND `admission_id` = '".$row["admission_id"]."' AND `course_id` = '".$row["admission_course_name"]."' AND `academic_year` = '".$row["admission_session"]."'
                                                                                                     ";
                                                                                $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                                                                                if($resultTblFeeStatus->num_rows > 0){
                                                                                    $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                                                                                    if(strtolower($rowTblFeeStatus["fee_status"]) == "dues"){
                                                                                    ?>
                                                                            <td> <button type="button" id="edit_fee_status_button<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>" class="btn btn-warning btn-sm"><span id="loader_id<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>"></span> Dues</button></td>
                                                                                    <?php 
                                                                                    } else{
                                                                                        ?>
                                                                            <td> <button type="button" id="edit_fee_status_button<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>" class="btn btn-primary btn-sm"><span id="loader_id<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>"></span> No Dues</button></td>
                                                                                    <?php 
                                                                                    }
                                                                                } else{
                                                                            ?>
                                                                            <td> <button type="button" id="edit_fee_status_button<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>" class="btn btn-warning btn-sm"><span id="loader_id<?= $arrayTblFeeUpdate->fee_id."_".$s_no ?>"></span> Dues</button></td>



                                                                        <?php
                                                                                }
                                                                } ?>
                                                            </tr>

                                                    <?php 
                                                            $tmpSNo++;
                                                        } 
                                                    ?>

                                                </tbody>
                                            </table>
                                        </td>

                                        
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
                <script>
                    $(function() {
                        $("#example1").DataTable();
                        $('#example2').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                        });
                    });

                </script>
           <?php
            } else
                echo "0";      
        }
        // Hostel Fee List End
        
        
        
      //Fetching course & year Exam wise fee report Start
        if($_GET["action"] == "fetch_examfee_list_details"){
            $course_id = $_POST["course_id"];
            $academic_year = $_POST["academic_year"];

            //echo "<pre>"; 
            //print_r($_POST); exit;         
            ?>
            <div class="card">
                <div class="card-header">
                    <form method="POST" action="export_exam_course_yearwise.php">
                        <input type="hidden" name="course_id" value="<?= $course_id ?>" />
                        <input type="hidden" name="academic_year" value="<?= $academic_year ?>" />
                        <input type="hidden" name="action" value="export_examfees_details" />
                        <button type="submit" class="btn btn-warning float-right"><i class="fa fa-download"></i> Export All</button>
                    </form>
                </div>
            </div>
            <table id="example1" class="table table-bordered table-striped" style="overflow-x:auto;">
             <!-- <table id="dtHorizontalExample" class="table table-bordered table-striped">-->
                <thead>
                    <tr>
                        <th width="10%">S.No</th>
                        <th  width="10%">Reg. No</th>
                         <th  width="10%">Course</th>
                        <th width="10%">Students Name</th>       
                        <th width="10%">Fees Detail</th>                                               
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        if($course_id == "all")
                            $sql = "SELECT * FROM `tbl_admission`
                                    WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `stud_status` = 1
                                    ORDER BY `admission_id` ASC
                                    ";
                        else
                            $sql = "SELECT * FROM `tbl_admission`
                                    WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_course_name` = '$course_id'  && `stud_status` = 1
                                    ORDER BY `admission_id` ASC
                                    ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <?php 
                                        $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                    ?>
                                    <td><?php echo $row["admission_id"] ?></td>
                                    <td><?php echo $row_course["course_name"] ?></td>
                                    <td><?php echo $row["admission_first_name"] ?> <?php echo $row["admission_middle_name"] ?> <?php echo $row["admission_last_name"] ?></td>
                                         <td>
                                        <table>
                                            <thead>
                                                <tr>
                                                <th width="10%">S.No</th>
                                                <th width="10%">Particular Name</th>
                                                <th width="10%">Amount</th>
                                                <th width="10%">Paid</th>
                                                <!-- <th width="10%">Rebate</th> -->
                                                <th width="10%">Fine</th>
                                                <!-- <th width="10%">Balance</th> -->
                                                <th width="10%">Fee Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php 

                                                    $query = "SELECT * FROM `tbl_examfee_paid`  WHERE `status` = '$visible' AND `student_id` = '".$row["admission_id"]."' AND `payment_status` IN ('cleared', 'pending')";
                                                    $results = mysqli_query($con, $query) or die("database error:". mysqli_error($con));                                   
                                                    $allOrders = array();
                                                    while( $order = mysqli_fetch_assoc($results) ) {
                                                    $no = 1;
                                                    $allOrders[] = $order;
                                                    }

                                                    // $sqlTblFeePaid = "SELECT *
                                                    // FROM `tbl_examfee_paid`
                                                    // WHERE `status` = '$visible' AND `student_id` = '".$studentRegistrationNo."' AND `payment_status` IN ('cleared', 'pending')
                                                    // ";

                                                     $tmpSNo=1; 
                                                     // $total_exam_fee = 0;            
                                                     // $total_paid_amount = 0;            
                                                     // $total_fine = 0;            
                                                     // $grand_total = 0;            
                                                    foreach($allOrders as $order){
                                                    // echo "<pre>";
                                                    // print_r($order); 
                                                    if($order["paid_amount"] != ""){
                                                    ?>

                                                     <tr>
                                                            <td><?php echo $tmpSNo; ?></td>

                                                           
                                                            <?php 
                                                            $sql_course = "SELECT * FROM `tbl_examination_fee` WHERE `exfee_id` = '".$order["particular_id"]."'";
                                                            $result_fee = $con->query($sql_course);
                                                            $row_fee = $result_fee->fetch_assoc();
                                                            ?>

                                                            <td><?php echo $row_fee['exfee_particulars']; ?></td>
                                                            <td>&#8377; <?php echo $row_fee['exfee_amount']; ?></td>
                                                            <td>&#8377; <?php echo $order['paid_amount']; ?></td>
                                                            <td>&#8377; <?php echo $order['extra_fine']; ?></td>
                                                            
                                                                 <?php
                                                                        $sqlTblFeeStatus = "SELECT *
                                                                        FROM `tbl_examfee_status`
                                                                        WHERE `particular_id` = '".$row_fee['exfee_id']."' AND `admission_id` = '".$row["admission_id"]."' AND `course_id` = '".$row["admission_course_name"]."' AND `academic_year` = '".$row["admission_session"]."'
                                                                        ";
                                                                        $resultTblFeeStatus = $con->query($sqlTblFeeStatus);
                                                                        if($resultTblFeeStatus->num_rows > 0){
                                                                            $rowTblFeeStatus = $resultTblFeeStatus->fetch_assoc();
                                                                            if(strtolower($rowTblFeeStatus["fee_status"]) == "dues"){
                                                                            ?>
                                                                            <td> <button type="button" id="edit_examfee_status_button<?= $row_fee['exfee_id']."_".$s_no ?>" class="btn btn-warning btn-sm"><span id="loader_id<?= $row_fee->exfee_id."_".$s_no ?>"></span> Dues</button></td>
                                                                            <!--<td><button type="button" class="btn btn-danger"><?= $rowTblFeeStatus["fee_status"] ?></button></td>-->
                                                                            <?php 
                                                                            } else{
                                                                                ?>
                                                                            <td> <button type="button" id="edit_examfee_status_button<?= $row_fee['exfee_id']."_".$s_no ?>" class="btn btn-primary btn-sm"><span id="loader_id<?= $row_fee->exfee_id."_".$s_no ?>"></span> No Dues</button></td>
                                                                            <?php 
                                                                            }
                                                                        } else{
                                                                    ?>
                                                                            <td> <button type="button" id="edit_examfee_status_button<?= $row_fee['exfee_id']."_".$s_no ?>" class="btn btn-warning btn-sm"><span id="loader_id<?= $row_fee['exfee_id']."_".$s_no ?>"></span> Dues</button></td>
                                                                        <?php } ?>                                                          
                                                        </tr>

                                                         <input type="hidden" id="particular_id<?= $row_fee['exfee_id']."_".$s_no ?>" value="<?= $row_fee['exfee_id'] ?>" >
                                                        <input type="hidden" id="admission_id<?= $row_fee['exfee_id']."_".$s_no ?>" value="<?= $row["admission_id"] ?>">
                                                        <input type="hidden" id="course_id<?= $row_fee['exfee_id']."_".$s_no ?>" value="<?= $row["admission_course_name"] ?>">
                                                        <input type="hidden" id="academic_year<?= $row_fee['exfee_id']."_".$s_no ?>" value="<?= $row["admission_session"] ?>">

                                                        <script>
                                                    $(function() {
                                                        $('#edit_examfee_status_button<?= $row_fee['exfee_id']."_".$s_no ?>').click(function() {
                                                            $('#loader_id<?= $row_fee['exfee_id']."_".$s_no ?>').append('<img id = "edit_load" width="20px" src = "images/ajax-loader.gif" alt="Currently loading" />');
                                                            $('#edit_fee_status_button<?= $row_fee['exfee_id']."_".$s_no ?>').prop('disabled', true);
                            
                                                            var dataString = "action=checkExamStatus&particular_id="+$("#particular_id<?= $row_fee['exfee_id']."_".$s_no ?>").val()+"&admission_id="+$("#admission_id<?= $row_fee['exfee_id']."_".$s_no ?>").val()+"&course_id="+$("#course_id<?= $row_fee['exfee_id']."_".$s_no ?>").val()+"&academic_year="+$("#academic_year<?= $row_fee['exfee_id']."_".$s_no ?>").val();

                                                                $.ajax({
                                                                    url: 'include/controller.php',
                                                                    type: 'POST',
                                                                    data: dataString,
                                                                    success: function(result) {
                                                                        console.log(result);
                                                                        if(result == "success")
                                                                            showUpdatedData();
                                                                        function showUpdatedData(){
                                                                            $.ajax({
                                                                                url: 'include/view.php?action=fetch_examfee_list_details',
                                                                                type: 'POST',
                                                                                data: $('#fetchFeeDataForm').serializeArray(),
                                                                                success: function(result) {
                                                                                    $('#response').remove();
                                                                                    $('#data_table').html('<div id = "response">' + result + '</div>');
                                                                                }
                                                                            });
                                                                        }
                                                                        $('#loader_id<?= $row_fee['exfee_id']."_".$s_no ?>').fadeOut(500, function() {
                                                                            $(this).remove();
                                                                            $('#edit_examfee_status_button<?= $row_fee['exfee_id']."_".$s_no ?>').prop('disabled', false);
                                                                        });
                                                                        
                                                                    }

                                                                });
                                                            });
                                                            
                                                        });
                                                        </script>



                                                     <?php 
                                                        $tmpSNo++;
                                                    } 

                                                  }  
                                                ?>
                                               
                                               
                                            </tbody>
                                        </table>
                                        </td>                                                                           
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
        //Fetching course & year wise exam fee report end


        
        //  fee receipt start
        if($_GET["action"] == "fetch_receipt_details"){
            $studentRegistrationNo = $_POST["studentRegistrationNo"];
            if(!empty($studentRegistrationNo)){
                $sql = "SELECT * FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' && `student_id` = '$studentRegistrationNo' && `payment_status` != 'deleted'
                        ORDER BY `feepaid_id` DESC
                        ";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                ?>
                <div class="col-md-12">
                    <form action="print?studentId=<?php echo $studentRegistrationNo; ?>" method="POST" align="right">
                        <input type="hidden" name="studentId" value="<?php echo $studentRegistrationNo; ?>" />
                        <input type="hidden" name="action" value="printAllReceipts" />
                        <button type="submit" class="btn btn-warning btn-md">
                            <i class="fas fa-print">
                            </i>
                           Student Fee Card
                        </button>
                    </form>
                </div>
                <div class="col-md-12 card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped table-responsiv">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Payment Mode</th>
                            <th>Payment Status</th>
                            <th>Receipt Number</th>
                            <th>Payment Date</th>
                            <th>Student Name</th>
                            <th>Rebate On</th>
                            <th>Rebate Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance Amount</th>
                            <th>Receipt Generated By</th>
                            <th class="project-actions text-center">Action </th>
                        </tr>
                    </thead>
                    <tbody>         
                       <?php 
                            while($row = $result->fetch_assoc()){
                                ?>
                                    <tr>
                                        <td><?php echo $s_no; ?></td>
                                        <td><?php echo date("Y-m-d"); ?></td>
                                        <td><?php echo strtoupper($row["payment_mode"]); ?></td>
                                        <td class="<?php if($row["payment_status"] == "cleared") echo "bg-green"; if($row["payment_status"] == "bounced") echo "bg-red"; if($row["payment_status"] == "pending") echo "bg-yellow"; if($row["payment_status"] == "refunded") echo "bg-orange" ?> "><?php echo strtoupper($row["payment_status"]); ?></td>
                                        <td><span class="text-red text-bold"><?php echo $row["receipt_no"] ?></span></td>
                                        <td><span class="text-red text-bold"><?php echo $row["receipt_date"] ?></span></td>
                                        <?php 
                                            $sql_student = "SELECT * FROM `tbl_admission`
                                                            WHERE `status` = '$visible' && `admission_id` = '".$row["student_id"]."'
                                                            ";
                                            $result_student = $con->query($sql_student);
                                            $row_student = $result_student->fetch_assoc();
                                        ?>
                                        <td><?php echo $row_student["admission_first_name"]." ".$row_student["admission_middle_name"]." ".$row_student["admission_last_name"] ?></td>
                                        <?php 
                                            if($row["rebate_amount"] != ""){
                                                $rebateAmountArray = explode(",", $row["rebate_amount"]);
                                                if($rebateAmountArray[1] == "fine")
                                                    $rebate_for = "FINE";
                                                else{
                                                    $sql_feeFor = "SELECT * FROM `tbl_fee`
                                                                    WHERE `status` = '$visible' && `fee_id` = '".$rebateAmountArray[1]."'
                                                                    ";
                                                    $result_feeFor = $con->query($sql_feeFor);
                                                    $row_feeFor = $result_feeFor->fetch_assoc();
                                                    $rebate_for = $row_feeFor["fee_particulars"];
                                                }
                                                ?>
                                                <td><?php echo $rebate_for; ?></td>
                                                <td><?php echo $rebateAmountArray[0]; ?></td>
                                                <?php 
                                            } else{
                                                ?>
                                                 <td></td>
                                                 <td></td>
                                                <?php 
                                            }
                                            
                                        ?>
                                        <?php 
                                            $sumAmount = 0;
                                            $amountsPaid = explode(",",$row["paid_amount"]);
                                            for($i=0; $i<count($amountsPaid); $i++){
                                                $sumAmount = $sumAmount + intval($amountsPaid[$i]);
                                            }
                                            unset($amountsPaid);
                                        ?>
                                        <td><?php echo $sumAmount+intval($row["fine"]); ?></td>
                                        <td><?php echo $row["balance"] ?></td>
                                        <td><?php echo $row["print_generated_by"] ?></td>
                                        <td class="project-actions text-center">
                                            <form action="print" method="POST">
                                                <input type="hidden" name="paidId" value="<?php echo $row["feepaid_id"]; ?>" />
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-print">
                                                    </i>
                                                    Print Receipt
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('delete_print_receipts<?php echo $row["feepaid_id"]; ?>').style.display='block'">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    Delete
                                                </button>
                                            </form>

                                        </td>

                                        <!-- Fees delete Section Start -->
                                        <div id="delete_print_receipts<?php echo $row["feepaid_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                            <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                                <header class="w3-container" style="background:#343a40; color:white;">
                                                    <span onclick="document.getElementById('delete_print_receipts<?php echo $row["feepaid_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                    <h2 align="center">Are you sure???</h2>
                                                </header>
                                                <form id="delete_print_receipt_form<?php echo $row["feepaid_id"]; ?>" role="form" method="POST">
                                                    <div class="card-body">
                                                        <div class="col-md-12" id="delete_error_section<?php echo $row["feepaid_id"]; ?>"></div>
                                                        <div class="col-md-12" align="center">
                                                            <input type='hidden' name='delete_feepaid_id' id="delete_feepaid_id<?php echo $row["feepaid_id"]; ?>" value='<?php echo $row["feepaid_id"]; ?>' />
                                                            <input type='hidden' name='action' id="action_delete<?php echo $row["feepaid_id"]; ?>" value='delete_print_receipts' />
                                                            <div class="col-md-12" id="delete_loader_section<?php echo $row["feepaid_id"]; ?>"></div>
                                                            <button type="button" id="delete_print_receipt_button<?php echo $row["feepaid_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                            <button type="button" onclick="document.getElementById('delete_print_receipts<?php echo $row["feepaid_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <script>
                                                    $(function() {
                                                        $('#delete_print_receipt_button<?php echo $row["feepaid_id"]; ?>').click(function() {
                                                            $('#delete_loader_section<?php echo $row["feepaid_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                            $('#delete_print_receipt_button<?php echo $row["feepaid_id"]; ?>').prop('disabled', true);
                                                            var action = $("#action_delete<?php echo $row["feepaid_id"]; ?>").val();
                                                            var delete_feepaid_id = $("#delete_feepaid_id<?php echo $row["feepaid_id"]; ?>").val();
                                                            var dataString = 'action='+ action + '&delete_feepaid_id='+ delete_feepaid_id;

                                                            $.ajax({
                                                                url: 'include/controller.php',
                                                                type: 'POST',
                                                                data: dataString,
                                                                success: function(result) {
                                                                    $('#delete_response').remove();
                                                                    if(result == "error"){
                                                                        $('#delete_error_section<?php echo $row["feepaid_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                    }
                                                                    if(result == "empty"){
                                                                        $('#delete_error_section<?php echo $row["feepaid_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                    }
                                                                    if(result == "success"){
                                                                        $('#delete_error_section<?php echo $row["feepaid_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Delete successfully!!!</div></div>');
                                                                        showUpdatedData();
                                                                        function showUpdatedData(){
                                                                            $.ajax({
                                                                                url: 'include/view.php?action=fetch_receipt_details',
                                                                                type: 'POST',
                                                                                data: $('#fetchStudentDataForm').serializeArray(),
                                                                                success: function(result) {
                                                                                    $('#response').remove();
                                                                                    $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                                }
                                                                            });
                                                                        }
                                                                    }
                                                                    console.log(result);
                                                                    $('#delete_loading').fadeOut(500, function() {
                                                                        $(this).remove();
                                                                    });
                                                                    $('#delete_print_receipt_button<?php echo $row["feepaid_id"]; ?>').prop('disabled', false);
                                                                }

                                                            });
                                                        });

                                                    });

                                                </script>
                                            </div>
                                        </div>
                                        <!-- Fees delete Section End -->
                                    </tr>
                                <?php 
                                    $s_no++;
                                }
                        ?>
                    </tbody>
                </table>
                </div>
                <script>
                    $(function() {
                        $("#example1").DataTable();
                        $('#example2').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                        });
                    });

                </script>
           <?php
                    } else
                        echo '
                            <div class="col-md-12"><div class="alert alert-warning alert-dismissible">
                                <i class="icon fas fa-exclamation-triangle"></i>  No data available now!!!
                            </div></div>';
            } else
                echo "0";      
        }
        // fee receipt End
        
        //Prospectus Start
        if($_GET["action"] == "get_prospectus"){
          echo  "working";
        ?>
            <table id="example1" class="table table-bordered table-striped">
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
                        $sql = "SELECT * FROM `tbl_prospectus`
                                WHERE `status` = '$visible'
                                ORDER BY `id` DESC
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Prospectus End
         //  fee Prospectus Details start
        if($_GET["action"] == "fetch_prospectus_info"){
            $form_no = $_POST["add_admission_form_no"];
            if(!empty($form_no)){
                $sql = "SELECT * FROM `tbl_prospectus`
                        WHERE `status` = '$visible' && `prospectus_no` = '$form_no'
                        ";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    $nameFull = explode(" ", $row["prospectus_applicant_name"]);
                    $completeInfo[] = $nameFull[0];
                    if(isset($nameFull[1])) 
                        $completeInfo[] = $nameFull[1]; 
                    else 
                        $completeInfo[] = "";
                    $completeInfo[] = $row["prospectus_gender"];
                    $completeInfo[] = $row["prospectus_father_name"];
                    $completeInfo[] = $row["prospectus_address"];
                    $completeInfo[] = $row["prospectus_country"];
                    $completeInfo[] = $row["prospectus_state"];
                    $completeInfo[] = $row["prospectus_city"];
                    $completeInfo[] = $row["prospectus_postal_code"];
                    $completeInfo[] = $row["prospectus_emailid"];
                    $completeInfo[] = $row["prospectus_dob"];
                    $completeInfo[] = $row["mobile"];
                    $completeInfo[] = $row["prospectus_course_name"];
                    $completeInfo[] = $row["prospectus_session"];
                    $completeInfo[] = $row["prospectus_mother_name"];
                    $info = implode("|||", $completeInfo);
                    echo $info;
                } else
                    echo "";
            } else
                echo "";
        }
        // fee Prospectus Details End
        
        //Extra Income Start
        if($_GET["action"] == "get_extra_income"){
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Received Date</th>
                        <th>Particulars</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Bank Name</th>
                        <th>Transaction No</th>
                        <th>Received From</th>
                        <th>Remarks</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_extra_income`
                                WHERE `status` = '$visible'
                                ORDER BY `id` DESC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                  <td><?php echo $s_no; ?></td>
                                  <td><?php echo $row["received_date"]; ?></td>
                                  <td><?php echo $row["particulars"]; ?></td>
                                  <td><?php echo $row["amount"]; ?></td>
                                  <td><?php echo $row["payment_mode"]; ?></td>
                                  <td><?php echo $row["bank_name"]; ?></td>
                                  <td><?php echo $row["account_number"]; ?></td>
                                   <td><?php echo $row["received_from"]; ?></td>
                                  <td><?php echo $row["remarks"]; ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_extra_income<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_extra_income<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Extra Income Edit Section Start -->
                                    <div id="edit_extra_income<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:55%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_extra_income<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Extra Income</h2>
                                            </header>
                                            <form id="edit_extra_income_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="row">
                                                       
                                                            <div class="col-4">
                                                              <label>Received Date</label>
                                                              <input type="date" name="received_date" id="received_date<?php echo $row["id"]; ?>"  value="<?php echo $row["received_date"]; ?>" class="form-control" required>
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Particulars</label>
                                                              <input type="text" name="particulars" id="particulars<?php echo $row["id"]; ?>" value="<?php echo $row["particulars"]; ?>" class="form-control" required>  
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Amount</label>
                                                              <input type="text" name="amount" id="amount<?php echo $row["id"]; ?>" value="<?php echo $row["amount"]; ?>" class="form-control" required>  
                                                            </div>
                                                         <div class="col-4">
                                                              <label>Received From</label>
                                                               <input type="text" name="received_from" id="received_from<?php echo $row["id"]; ?>" value="<?php echo $row["received_from"]; ?>" class="form-control" required>  
                                                            </div>
                                                          
                                                            <div class="col-4">
                                                              <label>Remarks</label>
                                                              <textarea name="remarks" id="remarks<?php echo $row["id"]; ?>" value="<?php echo $row["remarks"]; ?>" class="form-control" style="height:38px;"><?php echo $row["remarks"]; ?></textarea>  
                                                            </div>     
                                                            <div class="col-4">
                                                              <label>Payment Mode</label>
                                                              <select  name="payment_mode" id="payment_mode<?php echo $row["id"]; ?>" class="form-control" onchange="PaymentModeSelect(this.value);"> 
                                                              <option value="<?php echo $row["payment_mode"]; ?>"><?php echo $row["payment_mode"]; ?></option>                    
                                                              <option value="Cash">Cash</option>
                                                              <option value="DD">DD</option>
                                                              <option value="Cheque">Cheque</option>                                      
                                                              <option value="Online">Online</option>
                                                              <option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
                                                              </select>               
                                                            </div>
                                                             <div class="col-4" id="bankName_div" style="display:none">
                                                  <label>Bank Name</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input  name="bank_name" id="bank_name<?php echo $row["id"]; ?>" value="<?php echo $row["bank_name"]; ?>"  type="text" class="form-control" />
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <div class="col-4" id="chequeNo_div" style="display:none">
                                                  <label>Cheque/DD/NEFT No</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input id="account_number<?php echo $row["id"]; ?>" value="<?php echo $row["account_number"]; ?>" name="account_number" type="text" class="form-control" />
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <div class="col-4" id="receiptDate_div" style="display:none">
                                                  <label>Cash/Cheque/DD/NEFT Date</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input id="branch_name<?php echo $row["id"]; ?>" value="<?php echo $row["branch_name"]; ?>"  name="branch_name" type="date" class="form-control" />
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                                    <script>
                                                        function PaymentModeSelect(PaymentMode){
                                                            var bankName_div = document.getElementById('bankName_div');
                                                            var chequeNo_div = document.getElementById('chequeNo_div');
                                                            var receiptDate_div = document.getElementById('receiptDate_div');
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
                                                       <!-- <script>
                                                        function changeMode(str){
                                                            if (str == 'Cheque' || str == 'DD' || str == 'Online' || str == 'NEFT/RTGS/IMPS'){
                                                                document.getElementById('bank').style.display = "block";
                                                            } else {
                                                                document.getElementById('bank').style.display = "none";
                                                            }
                                                        }
                                                    </script>
                                                    <div style='display:none;' id="bank" >                  
                                                      <div class="row">
                                                     <div class="col-4">  
                                                     <label>Account Number</label>
                                                      <input type="text"  name="account_number"  id="account_number<?php echo $row["id"]; ?>" value="<?php echo $row["account_number"]; ?>" class="form-control" style="width: 86%;">               
                                                    </div>
                                                          <div class="col-4">  
                                                     <label>Bank Name</label>
                                                      <input type="text"  name="bank_name"  id="bank_name<?php echo $row["id"]; ?>" value="<?php echo $row["bank_name"]; ?>" class="form-control" style="width: 86%;">              
                                                    </div>
                                                          <div class="col-4">  
                                                     <label>Branch Name</label>
                                                      <input type="text"  name="branch_name"  id="branch_name<?php echo $row["id"]; ?>" value="<?php echo $row["branch_name"]; ?>" class="form-control" style="width: 86%;">                
                                                    </div>
                                                          <div class="col-4">  
                                                     <label>Ifsc Code</label>
                                                      <input type="text"  name="ifsc_code"  id="ifsc_code<?php echo $row["id"]; ?>" value="<?php echo $row["ifsc_code"]; ?>" class="form-control" style="width: 86%;">              
                                                    </div>
                                                     <div class="col-4">  
                                                     <label>Cheque/DD/NEFT No</label>
                                                      <input type="text"  name="transaction_no" id="transaction_no<?php echo $row["id"]; ?>" value="<?php echo $row["transaction_no"]; ?>"  class="form-control" style="width: 86%;">               
                                                    </div>
                                                    </div>
                                                    </div>-->                                                                                  

                                                    </div>
                                                    <input type='hidden' name='edit_id' id="edit_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                    <input type='hidden' name='action' id="action<?php echo $row["id"]; ?>" value='edit_extra_income' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["id"]; ?>"></div>
                                                    <button type="button" id="edit_extra_income_button<?php echo $row["id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#edit_extra_income_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_extra_income_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["id"]; ?>").val();
                                                        var edit_id = $("#edit_id<?php echo $row["id"]; ?>").val();
                                                        var received_date = $("#received_date<?php echo $row["id"]; ?>").val();
                                                        var particulars = $("#particulars<?php echo $row["id"]; ?>").val();
                                                        var amount = $("#amount<?php echo $row["id"]; ?>").val();
                                                        var payment_mode = $("#payment_mode<?php echo $row["id"]; ?>").val();
                                                        var account_number = $("#account_number<?php echo $row["id"]; ?>").val();
                                                        var bank_name = $("#bank_name<?php echo $row["id"]; ?>").val();
                                                        var branch_name = $("#branch_name<?php echo $row["id"]; ?>").val();
                                                        var ifsc_code = $("#ifsc_code<?php echo $row["id"]; ?>").val();
                                                        var transaction_no = $("#transaction_no<?php echo $row["id"]; ?>").val();
                                                        var received_from = $("#received_from<?php echo $row["id"]; ?>").val();
                                                        var remarks = $("#remarks<?php echo $row["id"]; ?>").val();
                                                        
                                                        var dataString = 'action='+ action + '&edit_id='+ edit_id + '&received_date='+ received_date + '&particulars='+ particulars + '&amount='+ amount + '&payment_mode='+ payment_mode + '&account_number='+ account_number  + '&bank_name='+ bank_name +'&branch_name='+ branch_name + '&ifsc_code='+ ifsc_code  +'&transaction_no='+ transaction_no  + '&received_from='+ received_from + '&remarks='+ remarks ;

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
                                                                            url: 'include/view.php?action=get_extra_income',
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
                                                                $('#edit_extra_income_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- extra income Edit Section End -->
                        
                                    <!-- Extra income delete Section Start -->
                                    <div id="delete_extra_income<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_extra_income<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_extra_income_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_id' id="delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_extra_income' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="delete_extra_income_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_extra_income<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_extra_income_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_extra_income_button<?php echo $row["id"]; ?>').prop('disabled', true);
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
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i>Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_extra_income',
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
                                                                $('#delete_extra_income_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Extra_income delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Extra_income End
        
        //Expenses Start
        if($_GET["action"] == "get_expenses"){
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Payment Date</th>
                        <th>Particulars</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Paid To</th>
                        <th>Remarks</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_expenses`
                                WHERE `status` = '$visible'
                                ORDER BY `id` DESC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                  <td><?php echo $s_no; ?></td>
                                  <td><?php echo $row["payment_date"]; ?></td>
                                  <td><?php echo $row["particulars"]; ?></td>
                                  <td><?php echo $row["amount"]; ?></td>
                                  <td><?php echo $row["payment_mode"]; ?></td>
                                  <td><?php echo $row["paid_to"]; ?></td>
                                  <td><?php echo $row["remarks"]; ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_expenses<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_expenses<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Expenses Edit Section Start -->
                                    <div id="edit_expenses<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:55%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_expenses<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Expenses</h2>
                                            </header>
                                            <form id="edit_expenses_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="row">
                                                       
                                                            <div class="col-4">
                                                              <label>Payment Date</label>
                                                              <input type="date" name="payment_date" id="payment_date<?php echo $row["id"]; ?>"  value="<?php echo $row["payment_date"]; ?>" class="form-control" required>
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Particulars (Paid For)</label>
                                                              <input type="text" name="particulars" id="particulars<?php echo $row["id"]; ?>"  value="<?php echo $row["particulars"]; ?>" class="form-control" required>
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Amount</label>
                                                              <input type="text" name="amount" id="amount<?php echo $row["id"]; ?>" value="<?php echo $row["amount"]; ?>" class="form-control" required>  
                                                            </div>
                                                            <div class="col-4">
                                                              <label>Paid To</label>
                                                              <input type="text" name="paid_to" id="paid_to<?php echo $row["id"]; ?>" value="<?php echo $row["paid_to"]; ?>" class="form-control" required>  
                                                            </div>
                                                        
                                                            <div class="col-4">
                                                              <label>Remarks</label>
                                                              <textarea name="remarks" id="remarks<?php echo $row["id"]; ?>" value="<?php echo $row["remarks"]; ?>" class="form-control" style="height:38px;"><?php echo $row["remarks"]; ?></textarea>  
                                                            </div>    
                                                                    <div class="col-4">
                                                              <label>Payment Mode</label>
                                                              <select  name="payment_mode" id="payment_mode<?php echo $row["id"]; ?>" class="form-control" onchange="changeMode(this.value);">  
                                                              <option value="<?php echo $row["payment_mode"]; ?>"><?php echo $row["payment_mode"]; ?></option>                    
                                                              <option value="Cash">Cash</option>
                                                              <option value="DD">DD</option>
                                                              <option value="Cheque">Cheque</option>                                      
                                                              <option value="Online">Online</option>
                                                              <option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
                                                              </select>               
                                                            </div>
                                                        <script>
                                                        function changeMode(str){
                                                            if (str == 'Cheque' || str == 'DD' || str == 'Online' || str == 'NEFT/IMPS/RTGS'){
                                                                document.getElementById('bank').style.display = "block";
                                                            } else {
                                                                document.getElementById('bank').style.display = "none";
                                                            }
                                                        }
                                                    </script>
                                                    <div style='display:none;' id="bank" >                  
                                                      <div class="row">
                                                    <div class="col-4">  
                                                     <label>Account Number</label>
                                                      <input type="text"  name="account_number"  id="account_number<?php echo $row["id"]; ?>" value="<?php echo $row["account_number"]; ?>" class="form-control" style="width: 86%;">               
                                                    </div>
                                                          <div class="col-4">  
                                                     <label>Bank Name</label>
                                                      <input type="text"  name="bank_name"  id="bank_name<?php echo $row["id"]; ?>" value="<?php echo $row["bank_name"]; ?>" class="form-control" style="width: 86%;">              
                                                    </div>
                                                          <div class="col-4">  
                                                     <label>Branch Name</label>
                                                      <input type="text"  name="branch_name"  id="branch_name<?php echo $row["id"]; ?>" value="<?php echo $row["branch_name"]; ?>" class="form-control" style="width: 86%;">                
                                                    </div>
                                                          <div class="col-4">  
                                                     <label>Ifsc Code</label>
                                                      <input type="text"  name="ifsc_code"  id="ifsc_code<?php echo $row["id"]; ?>" value="<?php echo $row["ifsc_code"]; ?>" class="form-control" style="width: 86%;">              
                                                    </div>
                                                     <div class="col-4">  
                                                     <label>Cheque/DD/NEFT No</label>
                                                      <input type="text"  name="transaction_no" id="transaction_no<?php echo $row["id"]; ?>" value="<?php echo $row["transaction_no"]; ?>"  class="form-control" style="width: 86%;">               
                                                    </div>
                                                    </div>
                                                    </div>
                                                          
                                                    </div>
                                                    <input type='hidden' name='edit_id' id="edit_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                    <input type='hidden' name='action' id="action<?php echo $row["id"]; ?>" value='edit_expenses' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["id"]; ?>"></div>
                                                    <button type="button" id="edit_expenses_button<?php echo $row["id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#edit_expenses_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_expenses_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        var action = $("#action<?php echo $row["id"]; ?>").val();
                                                        var edit_id = $("#edit_id<?php echo $row["id"]; ?>").val();
                                                        var payment_date = $("#payment_date<?php echo $row["id"]; ?>").val();
                                                        var particulars = $("#particulars<?php echo $row["id"]; ?>").val();
                                                        var amount = $("#amount<?php echo $row["id"]; ?>").val();
                                                        var payment_mode = $("#payment_mode<?php echo $row["id"]; ?>").val();
                                                        var account_number = $("#account_number<?php echo $row["id"]; ?>").val();
                                                        var bank_name = $("#bank_name<?php echo $row["id"]; ?>").val();
                                                        var branch_name = $("#branch_name<?php echo $row["id"]; ?>").val();
                                                        var ifsc_code = $("#ifsc_code<?php echo $row["id"]; ?>").val();
                                                        var transaction_no = $("#transaction_no<?php echo $row["id"]; ?>").val();
                                                        var paid_to = $("#paid_to<?php echo $row["id"]; ?>").val();
                                                        var remarks = $("#remarks<?php echo $row["id"]; ?>").val();
                                                        
                                                        var dataString = 'action='+ action + '&edit_id='+ edit_id + '&payment_date='+ payment_date + '&particulars='+ particulars + '&amount='+ amount + '&payment_mode='+ payment_mode + '&account_number='+ account_number  + '&bank_name='+ bank_name +  '&branch_name='+ branch_name + '&ifsc_code='+ ifsc_code  + '&transaction_no='+ transaction_no + '&paid_to='+ paid_to + '&remarks='+ remarks ;

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
                                                                            url: 'include/view.php?action=get_expenses',
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
                                                                $('#edit_expenses_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Expenses Edit Section End -->
                        
                                    <!-- Expenses delete Section Start -->
                                    <div id="delete_expenses<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_expenses<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_expenses_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_id' id="delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_expenses' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="delete_expenses_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_expenses<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_expenses_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_expenses_button<?php echo $row["id"]; ?>').prop('disabled', true);
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
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i>Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_expenses',
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
                                                                $('#delete_expenses_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Expenses delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Expenses End
//Admin List Start
        if($_GET["action"] == "get_admin"){
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Username</th>
<!--                        <th>Password</th>-->
                        <th>Email ID</th>
                        <th>Contact</th>
                        <th>User Type</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $sql = "SELECT * FROM `tbl_admin`
                                WHERE `status` = '$visible' && `admin_id` != 1
                                ORDER BY `admin_id` ASC
                                ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                  <td><?php echo $s_no; ?></td>
                                  <td><?php echo $row["admin_name"]; ?></td>
                                  <td><?php echo $row["admin_username"]; ?></td>
<!--                              <td><?php echo $row["admin_password"]; ?></td>-->
                                  <td><?php echo $row["admin_email"]; ?></td>
                                  <td><?php echo $row["admin_mobile"]; ?></td>
                                  <td><?php echo $row["admin_type"]; ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_admin<?php echo $row["admin_id"]; ?>').style.display='block'">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                           
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_admin<?php echo $row["admin_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            
                                        </button>
                                    </td>                                
                                    <?php 
                                        $autority = $row["admin_permission"];
                                        $allAutority = json_decode($autority);
                                    ?>
                                    <!-- Admin Edit Section Start -->
                                    <div id="edit_admin<?php echo $row["admin_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:60%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('edit_admin<?php echo $row["admin_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Edit Admin Details</h2>
                                            </header>
                                            <form id="edit_admin_form<?php echo $row["admin_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["admin_id"]; ?>"></div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label> Name</label>
                                                            <input type="text" name="edit_admin_name" id="edit_admin_name<?php echo $row["admin_id"]; ?>" class="form-control" value="<?php echo $row["admin_name"]; ?>">
                                                        </div>
                                                        <div class="col-6">
                                                            <label>User Name</label>
                                                            <input readonly type="text" name="edit_admin_username" id="edit_admin_username<?php echo $row["admin_id"]; ?>" class="form-control" value="<?php echo $row["admin_username"]; ?>">
                                                        </div>
                                                         <!--<div class="col-6">
                                                            <label>Password</label>
                                                            <input type="text" name="edit_admin_password" id="edit_admin_password<?php echo $row["admin_id"]; ?>" class="form-control" value="<?php echo $row["admin_password"]; ?>">
                                                        </div>-->
                                                        <div class="col-6">
                                                            <label>Email</label>
                                                            <input type="text" name="edit_admin_email" id="edit_admin_email<?php echo $row["admin_id"]; ?>" class="form-control" value="<?php echo $row["admin_email"]; ?>">
                                                        </div>
                                                        <div class="col-6">
                                                            <label>Mobile</label>
                                                            <input type="text" name="edit_admin_mobile" id="edit_admin_mobile<?php echo $row["admin_id"]; ?>" class="form-control" value="<?php echo $row["admin_mobile"]; ?>">
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <br/>
                                                            <div class="card card-danger">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">Select Permissions</h3>
                                                                </div>
                                                                <div class="card-body">
                                                                <!-- Minimal style -->
                                                                    <div class="row">
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">SetUp</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                     <!--<div class="col-sm-6">-->
                                                                                        <!-- checkbox -->
                                                                                     <!--   <div class="form-group clearfix">-->
                                                                                     <!--     <div class="icheck-danger d-inline">-->
                                                                                     <!--       <input type="checkbox" id="checkboxPrimary1_all" name="permission_3[]" value="">-->
                                                                                     <!--       <label for="checkboxPrimary1_all">All </label>-->
                                                                                     <!--     </div>-->
                                                                                     <!--   </div>-->
                                                                                     <!-- </div>-->
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary1_1<?php echo $row["admin_id"]; ?>" name="permission_3[]" value="3_1" <?php if(isset($autority)){ $page_no_temp = 3; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "3_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary1_1<?php echo $row["admin_id"]; ?>">University Details </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary1_2<?php echo $row["admin_id"]; ?>" name="permission_3[]" value="3_2" <?php if(isset($autority)){ $page_no_temp = 3; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "3_2"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary1_2<?php echo $row["admin_id"]; ?>">Courses </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Front Office</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <!--  <div class="col-sm-6">-->
                                                                                        <!-- checkbox -->
                                                                                      <!--  <div class="form-group clearfix">-->
                                                                                      <!--    <div class="icheck-danger d-inline">-->
                                                                                      <!--      <input type="checkbox" id="checkboxPrimary2_all" name="permission_4[]" value="">-->
                                                                                      <!--      <label for="checkboxPrimary2_all">All </label>-->
                                                                                      <!--    </div>-->
                                                                                      <!--  </div>-->
                                                                                      <!--</div>-->
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary2_1<?php echo $row["admin_id"]; ?>" name="permission_4[]" value="4_1" <?php if(isset($autority)){ $page_no_temp = 4; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "4_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary2_1<?php echo $row["admin_id"]; ?>">Prospectus </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Admission</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <!--  <div class="col-sm-6">-->
                                                                                        <!-- checkbox -->
                                                                                      <!--  <div class="form-group clearfix">-->
                                                                                      <!--    <div class="icheck-danger d-inline">-->
                                                                                      <!--      <input type="checkbox" id="checkboxPrimary3_all" name="permission_5[]" value="">-->
                                                                                      <!--      <label for="checkboxPrimary3_all">All </label>-->
                                                                                      <!--    </div>-->
                                                                                      <!--  </div>-->
                                                                                      <!--</div>-->
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary3_1<?php echo $row["admin_id"]; ?>" name="permission_5[]" value="5_1" <?php if(isset($autority)){ $page_no_temp = 5; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "5_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary3_1<?php echo $row["admin_id"]; ?>">Admission Form </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Student</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <!--  <div class="col-sm-6">-->
                                                                                        <!-- checkbox -->
                                                                                      <!--  <div class="form-group clearfix">-->
                                                                                      <!--    <div class="icheck-danger d-inline">-->
                                                                                      <!--      <input type="checkbox" id="checkboxPrimary4_all" name="permission_6[]" value="">-->
                                                                                      <!--      <label for="checkboxPrimary4_all">All </label>-->
                                                                                      <!--    </div>-->
                                                                                      <!--  </div>-->
                                                                                      <!--</div>-->
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary4_1<?php echo $row["admin_id"]; ?>" name="permission_6[]" value="6_4" <?php if(isset($autority)){ $page_no_temp = 6; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "6_4"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary4_1<?php echo $row["admin_id"]; ?>">Student List </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                       <div class="col-sm-6" style="display:none;">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary4_2<?php echo $row["admin_id"]; ?>" name="permission_6[]" value="6_5" <?php if(isset($autority)){ $page_no_temp = 6; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "6_5"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary4_2<?php echo $row["admin_id"]; ?>">Student Edit </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Fee Payment</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <!--  <div class="col-sm-6">-->
                                                                                        <!-- checkbox -->
                                                                                      <!--  <div class="form-group clearfix">-->
                                                                                      <!--    <div class="icheck-danger d-inline">-->
                                                                                      <!--      <input type="checkbox" id="checkboxPrimary5_all" name="permission_7[]" value="">-->
                                                                                      <!--      <label for="checkboxPrimary5_all">All </label>-->
                                                                                      <!--    </div>-->
                                                                                      <!--  </div>-->
                                                                                      <!--</div>-->
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary5_1<?php echo $row["admin_id"]; ?>" name="permission_7[]" value="7_1" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary5_1<?php echo $row["admin_id"]; ?>">Add Fees </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary5_2<?php echo $row["admin_id"]; ?>" name="permission_7[]" value="7_4" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_4"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary5_2<?php echo $row["admin_id"]; ?>">Fee Details </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary5_3<?php echo $row["admin_id"]; ?>" name="permission_7[]" value="7_7" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_7"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary5_3<?php echo $row["admin_id"]; ?>">Pay Fee </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary5_4<?php echo $row["admin_id"]; ?>" name="permission_7[]" value="7_8" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_8"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary5_4<?php echo $row["admin_id"]; ?>">Print Receipt </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      
                                                                                      
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary5_11<?php echo $row["admin_id"]; ?>" name="permission_7[]" value="7_13" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_8"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary5_11<?php echo $row["admin_id"]; ?>">Print</label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      
                                                                                      
                                                                                      
                                                                                      
                                                                                      
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary5_5<?php echo $row["admin_id"]; ?>" name="permission_7[]" value="7_9" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_9"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary5_5<?php echo $row["admin_id"]; ?>">Course & Year Wise Fee Report </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary5_6<?php echo $row["admin_id"]; ?>" name="permission_7[]" value="7_10" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_10"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary5_6<?php echo $row["admin_id"]; ?>">Datewise Fee Report </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Income / Expenses</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <!--  <div class="col-sm-6">-->
                                                                                        <!-- checkbox -->
                                                                                      <!--  <div class="form-group clearfix">-->
                                                                                      <!--    <div class="icheck-danger d-inline">-->
                                                                                      <!--      <input type="checkbox" id="checkboxPrimary6_all" name="permission_8[]" value="">-->
                                                                                      <!--      <label for="checkboxPrimary6_all">All </label>-->
                                                                                      <!--    </div>-->
                                                                                      <!--  </div>-->
                                                                                      <!--</div>-->
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary6_1<?php echo $row["admin_id"]; ?>" name="permission_8[]" value="8_1" <?php if(isset($autority)){ $page_no_temp = 8; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "8_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary6_1<?php echo $row["admin_id"]; ?>">Extra Income </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary6_2<?php echo $row["admin_id"]; ?>" name="permission_8[]" value="8_2" <?php if(isset($autority)){ $page_no_temp = 8; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "8_2"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary6_2<?php echo $row["admin_id"]; ?>">Income </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary6_3<?php echo $row["admin_id"]; ?>" name="permission_8[]" value="8_3" <?php if(isset($autority)){ $page_no_temp = 8; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "8_3"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary6_3<?php echo $row["admin_id"]; ?>">Expenses </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary6_4<?php echo $row["admin_id"]; ?>" name="permission_8[]" value="8_4" <?php if(isset($autority)){ $page_no_temp = 8; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "8_4"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary6_4<?php echo $row["admin_id"]; ?>">Balance Sheet </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Nsuniv Informations</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <!--  <div class="col-sm-6">-->
                                                                                        <!-- checkbox -->
                                                                                      <!--  <div class="form-group clearfix">-->
                                                                                      <!--    <div class="icheck-danger d-inline">-->
                                                                                      <!--      <input type="checkbox" id="checkboxPrimary7_all" name="permission_9[]" value="">-->
                                                                                      <!--      <label for="checkboxPrimary7_all">All </label>-->
                                                                                      <!--    </div>-->
                                                                                      <!--  </div>-->
                                                                                      <!--</div>-->
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary7_1<?php echo $row["admin_id"]; ?>" name="permission_9[]" value="9_4" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_4"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary7_1<?php echo $row["admin_id"]; ?>">Get Started Enquiry </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary7_2<?php echo $row["admin_id"]; ?>" name="permission_9[]" value="9_2" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_2"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary7_2<?php echo $row["admin_id"]; ?>">Prospectus Enquiry </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary7_3<?php echo $row["admin_id"]; ?>" name="permission_9[]" value="9_3" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_3"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary7_3<?php echo $row["admin_id"]; ?>">Admission Enquiry </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary7_4<?php echo $row["admin_id"]; ?>" name="permission_9[]" value="9_5" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_5"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary7_4<?php echo $row["admin_id"]; ?>">Notifications </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary7_5<?php echo $row["admin_id"]; ?>" name="permission_9[]" value="9_6" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_6"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary7_5<?php echo $row["admin_id"]; ?>">Files </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Students And Examination</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <!--  <div class="col-sm-6">-->
                                                                                        <!-- checkbox -->
                                                                                      <!--  <div class="form-group clearfix">-->
                                                                                      <!--    <div class="icheck-danger d-inline">-->
                                                                                      <!--      <input type="checkbox" id="checkboxPrimary8_all" name="permission_11[]" value="">-->
                                                                                      <!--      <label for="checkboxPrimary8_all">All </label>-->
                                                                                      <!--    </div>-->
                                                                                      <!--  </div>-->
                                                                                      <!--</div>-->
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary8_1<?php echo $row["admin_id"]; ?>" name="permission_11[]" value="11_1" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary8_1<?php echo $row["admin_id"]; ?>">Add Semester </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary8_2<?php echo $row["admin_id"]; ?>" name="permission_11[]" value="11_2" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_2"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary8_2<?php echo $row["admin_id"]; ?>">Export Student </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary8_8<?php echo $row["admin_id"]; ?>" name="permission_11[]" value="11_8" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_8"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary8_8<?php echo $row["admin_id"]; ?>">Import Student </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary8_3<?php echo $row["admin_id"]; ?>" name="permission_11[]" value="11_3" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_3"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary8_3<?php echo $row["admin_id"]; ?>">Allocate Semester to Student </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary8_4<?php echo $row["admin_id"]; ?>" name="permission_11[]" value="11_4" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_4"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary8_4<?php echo $row["admin_id"]; ?>">Add Subject </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div><div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary8_5<?php echo $row["admin_id"]; ?>" name="permission_11[]" value="11_5" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_5"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary8_5<?php echo $row["admin_id"]; ?>">Add Marks </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary8_6<?php echo $row["admin_id"]; ?>" name="permission_11[]" value="11_6" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_6"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary8_6<?php echo $row["admin_id"]; ?>">Create Report </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary8_7<?php echo $row["admin_id"]; ?>" name="permission_11[]" value="11_7" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_7"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary8_7<?php echo $row["admin_id"]; ?>">Create Full Report </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                       <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Examination</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary9_1<?php echo $row["admin_id"]; ?>" name="permission_12[]" value="12_1" <?php if(isset($autority)){ $page_no_temp = 12; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "12_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary9_1<?php echo $row["admin_id"]; ?>">Exam Form</label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary9_2<?php echo $row["admin_id"]; ?>" name="permission_12[]" value="12_2" <?php if(isset($autority)){ $page_no_temp = 12; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "12_2"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary9_2<?php echo $row["admin_id"]; ?>">Student List (No Dues) </label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                        <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Complaints From Student</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary10_1<?php echo $row["admin_id"]; ?>" name="permission_13[]" value="13_1" <?php if(isset($autority)){ $page_no_temp = 13; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "13_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary10_1<?php echo $row["admin_id"]; ?>">Complaints</label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-sm-6">
                                                                        <div class="col-sm-12">
                                                                            <div class="card card-warning">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Admit Card</h3>
                                                                                </div>
                                                                                <div class="card-body pl-5 pr-5">
                                                                                <!-- Minimal style -->
                                                                                    <div class="row">
                                                                                      <div class="col-sm-6">
                                                                                        <!-- checkbox -->
                                                                                        <div class="form-group clearfix">
                                                                                          <div class="icheck-warning d-inline">
                                                                                            <input type="checkbox" id="checkboxPrimary11_11<?php echo $row["admin_id"]; ?>" name="permission_14[]" value="14_1" <?php if(isset($autority)){ $page_no_temp = 14; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "14_1"){ echo "checked"; $flag++; break; } } } } ?>>
                                                                                            <label for="checkboxPrimary11_11<?php echo $row["admin_id"]; ?>">Admit Card Approval</label>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br/>
                                                        </div>

                                                    </div>
                                                    <br>
                                                    <input type='hidden' name='edit_admin_id' id="edit_admin_id<?php echo $row["admin_id"]; ?>" value='<?php echo $row["admin_id"]; ?>' />
                                                    <input type='hidden' name='action' id="action<?php echo $row["admin_id"]; ?>" value='edit_admin' />
                                                    <div class="col-md-12" id="edit_loader_section<?php echo $row["admin_id"]; ?>"></div>
                                                    <button type="button" id="edit_admin_button<?php echo $row["admin_id"]; ?>" class="btn btn-primary">Update</button>
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#edit_admin_button<?php echo $row["admin_id"]; ?>').click(function() {
                                                        $('#edit_loader_section<?php echo $row["admin_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                        $('#edit_admin_button<?php echo $row["admin_id"]; ?>').prop('disabled', true);
                                                        var permission_3 = "";
                                                        var permission_4 = "";
                                                        var permission_5 = "";
                                                        var permission_6 = "";
                                                        var permission_7 = "";
                                                        var permission_8 = "";
                                                        var permission_9 = "";
                                                        var permission_11 = "";
                                                        var permission_12 = "";
                                                        var permission_13 = "";
                                                        var permission_14 = "";
                                                            
                                                        if ($("#checkboxPrimary1_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_3 = permission_3 + $("#checkboxPrimary1_1<?php echo $row["admin_id"]; ?>").val() + "||"; 
                                                        if ($("#checkboxPrimary1_2<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_3 = permission_3 + $("#checkboxPrimary1_2<?php echo $row["admin_id"]; ?>").val() + "||";
                                                            
                                                        if ($("#checkboxPrimary2_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_4 = permission_4 + $("#checkboxPrimary2_1<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                            
                                                        if ($("#checkboxPrimary3_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_5 = permission_5 + $("#checkboxPrimary3_1<?php echo $row["admin_id"]; ?>").val() + "||";
                                                            
                                                        if ($("#checkboxPrimary4_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_6 = permission_6 + $("#checkboxPrimary4_1<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary4_2<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_6 = permission_6 + $("#checkboxPrimary4_2<?php echo $row["admin_id"]; ?>").val() + "||";     
                                                            
                                                        if ($("#checkboxPrimary5_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_7 = permission_7 + $("#checkboxPrimary5_1<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary5_2<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_7 = permission_7 + $("#checkboxPrimary5_2<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary5_3<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_7 = permission_7 + $("#checkboxPrimary5_3<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary5_4<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_7 = permission_7 + $("#checkboxPrimary5_4<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary5_5<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_7 = permission_7 + $("#checkboxPrimary5_5<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary5_6<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_7 = permission_7 + $("#checkboxPrimary5_6<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                            
                                                        if ($("#checkboxPrimary6_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_8 = permission_8 + $("#checkboxPrimary6_1<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary6_2<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_8 = permission_8 + $("#checkboxPrimary6_2<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary6_3<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_8 = permission_8 + $("#checkboxPrimary6_3<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary6_4<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_8 = permission_8 + $("#checkboxPrimary6_4<?php echo $row["admin_id"]; ?>").val() + "||";  
                                                            
                                                        if ($("#checkboxPrimary7_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_9 = permission_9 + $("#checkboxPrimary7_1<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary7_2<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_9 = permission_9 + $("#checkboxPrimary7_2<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary7_3<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_9 = permission_9 + $("#checkboxPrimary7_3<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary7_4<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_9 = permission_9 + $("#checkboxPrimary7_4<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary7_5<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_9 = permission_9 + $("#checkboxPrimary7_5<?php echo $row["admin_id"]; ?>").val() + "||";      
                                                            
                                                        if ($("#checkboxPrimary8_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_11 = permission_11 + $("#checkboxPrimary8_1<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary8_2<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_11 = permission_11 + $("#checkboxPrimary8_2<?php echo $row["admin_id"]; ?>").val() + "||"; 
                                                        if ($("#checkboxPrimary8_8<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_11 = permission_11 + $("#checkboxPrimary8_8<?php echo $row["admin_id"]; ?>").val() + "||";
                                                        if ($("#checkboxPrimary8_3<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_11 = permission_11 + $("#checkboxPrimary8_3<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary8_4<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_11 = permission_11 + $("#checkboxPrimary8_4<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary8_5<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_11 = permission_11 + $("#checkboxPrimary8_5<?php echo $row["admin_id"]; ?>").val() + "||";    
                                                        if ($("#checkboxPrimary8_6<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_11 = permission_11 + $("#checkboxPrimary8_6<?php echo $row["admin_id"]; ?>").val() + "||";
                                                        if ($("#checkboxPrimary8_7<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_11 = permission_11 + $("#checkboxPrimary8_7<?php echo $row["admin_id"]; ?>").val() + "||";
                                                            
                                                        if ($("#checkboxPrimary9_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_12 = permission_12 + $("#checkboxPrimary9_1<?php echo $row["admin_id"]; ?>").val() + "||"; 
                                                        if ($("#checkboxPrimary9_2<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_12 = permission_12 + $("#checkboxPrimary9_2<?php echo $row["admin_id"]; ?>").val() + "||";   

                                                        if ($("#checkboxPrimary10_1<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_13 = permission_13 + $("#checkboxPrimary10_1<?php echo $row["admin_id"]; ?>").val() + "||";
                                                        
                                                        if ($("#checkboxPrimary11_11<?php echo $row["admin_id"]; ?>").is(":checked"))
                                                            permission_14 = permission_14 + $("#checkboxPrimary11_11<?php echo $row["admin_id"]; ?>").val() + "||";
                                                            
                                                        var action = $("#action<?php echo $row["admin_id"]; ?>").val();
                                                        var edit_admin_id = $("#edit_admin_id<?php echo $row["admin_id"]; ?>").val();
                                                        var edit_admin_name = $("#edit_admin_name<?php echo $row["admin_id"]; ?>").val();
                                                        var edit_admin_username = $("#edit_admin_username<?php echo $row["admin_id"]; ?>").val();
                                                       // var edit_admin_password = $("#edit_admin_password<?php echo $row["admin_id"]; ?>").val();
                                                        var edit_admin_email = $("#edit_admin_email<?php echo $row["admin_id"]; ?>").val();
                                                        var edit_admin_mobile = $("#edit_admin_mobile<?php echo $row["admin_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&permission_3='+ permission_3 + '&permission_4='+ permission_4 + '&permission_5='+ permission_5 + '&permission_6='+ permission_6 + '&permission_7='+ permission_7 + '&permission_8='+ permission_8 + '&permission_9='+ permission_9 + '&permission_11='+ permission_11 + '&permission_12='+ permission_12 + '&permission_13='+ permission_13 + '&permission_14='+ permission_14  + '&edit_admin_id='+ edit_admin_id + '&edit_admin_name='+ edit_admin_name + '&edit_admin_username=' + edit_admin_username  + '&edit_admin_email=' + edit_admin_email + '&edit_admin_mobile=' + edit_admin_mobile;
                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#edit_response').remove();
                                                                if(result == "exsits"){
                                                                    $('#edit_error_section<?php echo $row["admin_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Username have already exsits!!!</div></div>');
                                                                }
                                                                if(result == "error"){
                                                                    $('#edit_error_section<?php echo $row["admin_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#edit_error_section<?php echo $row["admin_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out all fields!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#edit_error_section<?php echo $row["admin_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i>  Updated successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_admin',
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
                                                                $('#edit_admin_button<?php echo $row["admin_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Admin Edit Section End -->
                        
                                    <!-- Admin delete Section Start -->
                                    <div id="delete_admin<?php echo $row["admin_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_admin<?php echo $row["admin_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_admin_form<?php echo $row["admin_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["admin_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_admin_id' id="delete_admin_id<?php echo $row["admin_id"]; ?>" value='<?php echo $row["admin_id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["admin_id"]; ?>" value='delete_admin' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["admin_id"]; ?>"></div>
                                                        <button type="button" id="delete_admin_button<?php echo $row["admin_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_admin<?php echo $row["admin_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_admin_button<?php echo $row["admin_id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["admin_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_admin_button<?php echo $row["admin_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["admin_id"]; ?>").val();
                                                        var delete_admin_id = $("#delete_admin_id<?php echo $row["admin_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_admin_id='+ delete_admin_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["admin_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["admin_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["admin_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_admin',
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
                                                                $('#delete_admin_button<?php echo $row["admin_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- admin delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Admin list End
        
        //Nsuniv Home Enquiry Start
        if($_GET["action"] == "get_nsuniv_home_enquiry"){
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Timing</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $objectDefault->select("admission_enquiry_tbl");
                        $objectDefault->where("`is_deleted` = '0' ORDER BY `id` DESC");
                        $result = $objectDefault->get();
                        if($result->num_rows > 0){
                            while($row = $objectDefault->get_row()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <td><?php echo $row["admission_name"] ?></td>
                                    <td><?php echo $row["admission_phone"] ?></td>
                                    <td><?php echo $row["time"] ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('view_university_home_enquiry<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-eye">
                                            </i>
                                            View
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_university_home_enquiry<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- View Section Start -->
                                    <div id="view_university_home_enquiry<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('view_university_home_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">View Details</h2>
                                            </header>
                                            <form role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Course</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["admission_course"] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["admission_name"] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Email Id</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["admission_email"] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Phone No</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["admission_phone"] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>State</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["admission_state"] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>City</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["admission_city"] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Last Qualification</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["admission_last_qualify"] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Timing</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["time"] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- View Section End -->
                        
                                    <!-- Delete Section Start -->
                                    <div id="delete_university_home_enquiry<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_university_home_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_university_home_enquiry_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_id' id="delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_university_home_enquiry' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="delete_university_home_enquiry_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_university_home_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_university_home_enquiry_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_university_home_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["id"]; ?>").val();
                                                        var delete_id = $("#delete_id<?php echo $row["id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_id='+ delete_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
//                                                                console.log(dataString);
//                                                                console.log(result);
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Enquiry Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_nsuniv_home_enquiry',
                                                                            type: 'GET',
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                    $('#delete_university_home_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                                });
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Nsuniv Home Enquiry End
        //Nsuniv Prospectus Enquiry Start
        if($_GET["action"] == "get_nsuniv_prospectus_enquiry"){
            $objectSecond->update("tbl_alert", "`prospectus_enquiry` = '0' WHERE `id`='1'");
            $objectSecond->sql = "";
            $start = intval($_POST["start"]);
            $lenghtOfData = intval($_POST["lenghtOfData"]);
//            echo "hello";
//            exit(0);
        ?>
           
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Prospectus No</th>
                        <th>Course</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Referred By</th>
                         <th>Payment Status</th>
                        <th>Timing</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $objectSecond->select("tbl_prospectus");
                        if(strtolower($lenghtOfData) == "all"){
                            $objectSecond->where("`status` = '$visible' && `type` = 'enquiry' ORDER BY `id` DESC ");
                            $s_no = 1;
                        } else if($start == 1){
                            $objectSecond->where("`status` = '$visible' && `type` = 'enquiry' ORDER BY `id` DESC LIMIT ".$lenghtOfData);
                            $s_no = $start;
                        } else{ 
                            $objectSecond->where("`status` = '$visible' && `type` = 'enquiry' ORDER BY `id` DESC LIMIT ".$start.", ".$lenghtOfData);
                            $s_no = ++$start;
                        }
                        $result = $objectSecond->get();
                        if($result->num_rows > 0){
                            while($row = $objectSecond->get_row()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <td style="color:#8a0410;"><b><?php if($row["prospectus_no"] != "") echo $row["prospectus_no"]; else echo "Please Give Prospectus No"; ?></b></td>
                                    <td><?php echo $row["prospectus_course_name"] ?></td>
                                    <td><?php echo $row["prospectus_applicant_name"] ?></td>
                                    <td><?php echo $row["mobile"] ?></td>
                                    <td><?php echo $row["revert_by"] ?></td>
                                    <td><?php echo $row["payment_status"] ?></td>
                                    <td><?php echo $row["post_at"] ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-info btn-sm" onclick="document.getElementById('view_university_prospectus_enquiry<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-eye">
                                            </i>
                                            View
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_university_prospectus_enquiry<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- View Section Start -->
                                    <div id="view_university_prospectus_enquiry<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%; margin-bottom:50px;">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('view_university_prospectus_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">View Details</h2>
                                            </header>
                                            <form role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Prospectus No</label>
                                                                <div class="input-group mb-3">
                                                                  <input type="text" id="unversity_prospectus_number<?php echo $row["id"] ?>" name="unversity_prospectus_number" class="form-control" value="<?php echo $row["prospectus_no"] ?>">
                                                                   <input type="hidden" id="prospectus_course_name<?php echo $row["id"] ?>" name="prospectus_course_name" class="form-control" value="<?php echo $row["prospectus_course_name"] ?>">
                                                                   <input type="hidden" id="prospectus_rate<?php echo $row["id"] ?>" name="prospectus_rate" class="form-control" value="<?php echo $row["prospectus_rate"] ?>">
                                                                   <input type="hidden" id="post_at<?php echo $row["id"] ?>" name="post_at" class="form-control" value="<?php echo $row["post_at"] ?>">
                                                                  <input type="hidden" id="unversity_prospectus_id<?php echo $row["id"] ?>" name="unversity_prospectus_id" class="form-control" value="<?php echo $row["id"] ?>">
                                                                  <input type="hidden" id="action_prospectus_enquiry<?php echo $row["id"] ?>" name="action" class="form-control" value="update_prospectus_enquiry">
                                                                  <div class="input-group-prepend">
                                                                    <button id="update_prospectus<?php echo $row["id"] ?>" type="button" class="btn btn-info"><span id="update_loader_section<?php echo $row["id"] ?>"></span>Update</button>
                                                                  </div>
                                                                  
                                                                </div>
                                                                <?php if($row["prospectus_no"] == ""){ ?>
                                                                  <small id="update_error_section<?php echo $row["id"] ?>" style="color:#8a0410;">Please Add a Prospectus Number.</small>
                                                                  <?php } else{ ?>
                                                                  <small id="update_error_section<?php echo $row["id"] ?>" style="color:#8a0410;"></small>
                                                                  <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Prospectus Amount</label>
                                                                <input type="text" class="form-control" name="prospectus_rate" value="<?php echo $row["prospectus_rate"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Course</label>
                                                                <input type="text" class="form-control" name="prospectus_course_name" value="<?php echo $row["prospectus_course_name"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Applicant Name</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["prospectus_applicant_name"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Father Name</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["prospectus_applicant_name"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Email Id</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["prospectus_emailid"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Phone No</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["mobile"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Country</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["prospectus_country"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>State</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["prospectus_state"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>City</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["prospectus_city"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <textarea class="form-control" readonly><?php echo $row["prospectus_address"] ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Payment Mode</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["prospectus_payment_mode"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Bank Name</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["bank_name"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Transaction No</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["transaction_no"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Transaction Date</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["transaction_date"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Timing</label>
                                                                <input type="text" class="form-control" value="<?php echo $row["post_at"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#update_prospectus<?php echo $row["id"]; ?>').click(function() {
                                                        $('#update_loader_section<?php echo $row["id"]; ?>').append('<img id = "update_loading" width="20px" src = "images/ajax-loader.gif" alt="Currently loading" /> ');
                                                        $('#update_prospectus<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        
                                                        var prosprectus_number = $("#unversity_prospectus_number<?php echo $row["id"]; ?>").val();
                                                        var prospectus_course_name = $("#prospectus_course_name<?php echo $row["id"]; ?>").val();
                                                        var prospectus_rate = $("#prospectus_rate<?php echo $row["id"]; ?>").val();
                                                         var post_at = $("#post_at<?php echo $row["id"]; ?>").val();
                                                        var prosprectus_id = $("#unversity_prospectus_id<?php echo $row["id"]; ?>").val();
                                                        var action = $("#action_prospectus_enquiry<?php echo $row["id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&prosprectus_id='+ prosprectus_id + '&prosprectus_number='+ prosprectus_number + '&prospectus_course_name='+ prospectus_course_name  + '&prospectus_rate='+ prospectus_rate + '&post_at='+ post_at;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
//                                                                console.log(dataString);
//                                                                console.log(result);
                                                                $('#update_response').remove();
                                                                if(result == "error"){
                                                                    $('#update_error_section<?php echo $row["id"]; ?>').html('<b>Something went wrong please try again!!!</b>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#update_error_section<?php echo $row["id"]; ?>').html('<b>Please Enter Prospectus Number!!!</b>');
                                                                }
                                                                if(result == "exsits"){
                                                                    $('#update_error_section<?php echo $row["id"]; ?>').html('<b>Prospectus Number Already Exsits!!!</b>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#update_error_section<?php echo $row["id"]; ?>').html('<b>Prospectus Number Added successfully!!!</b>');
                                                                    showDeletedData(5, 1);
                                                                    function showDeletedData(lenghtOfData, paginationNumber){
                                                                        $('#data_table').append('<center><img id = "dynamicChangeLoader" width="50px" src = "images/ajax-loader.gif" alt="Loading..." /></center>');
                                                                        $('#dynamicChangeLimit').addClass("disableAll");
                                                                        $('#data_table').addClass("disableAll");
                                                                        $('#dynamicChangePaginations').addClass("disableAll");
                                                                        $('.pagiNation').addClass("disableAll");
                                                                        $(".pagiNation").removeClass("btn-danger");
                                                                        $(".pagiNation").addClass("btn-default");
                                                                        $("#option1").removeClass("btn-default");
                                                                        $("#option1").addClass("btn-danger");
                                                                        var start = 1;
                                                                        if(paginationNumber == 1)
                                                                            start = paginationNumber;
                                                                        else
                                                                            start = Number(lenghtOfData) * (Number(paginationNumber) - 1);
                                                                        console.log(start +", "+ lenghtOfData);
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_nsuniv_prospectus_enquiry',
                                                                            type: 'POST',
                                                                            data:{action:"get_nsuniv_prospectus_enquiry", start:start, lenghtOfData:lenghtOfData},
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                                $('#dynamicChangeLimit').removeClass("disableAll");
                                                                                $('#data_table').removeClass("disableAll");
                                                                                $('#dynamicChangePaginations').removeClass("disableAll");
                                                                                $('.pagiNation').removeClass("disableAll");
                                                                            }
                                                                        }); 
                                                                    }
                                                                }
                                                                $('#update_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                    $('#update_prospectus<?php echo $row["id"]; ?>').prop('disabled', false);
                                                                });
                                                            }
                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- View Section End -->
                        
                                    <!-- Delete Section Start -->
                                    <div id="delete_university_prospectus_enquiry<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_university_prospectus_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_university_prospectus_enquiry_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_id' id="delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_university_prospectus_enquiry' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="delete_university_prospectus_enquiry_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_university_prospectus_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_university_prospectus_enquiry_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_university_prospectus_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["id"]; ?>").val();
                                                        var delete_id = $("#delete_id<?php echo $row["id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_id='+ delete_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
//                                                                console.log(dataString);
//                                                                console.log(result);
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Enquiry Delete successfully!!!</div></div>');
                                                                    showDeletedData(5, 1);
                                                                    function showDeletedData(lenghtOfData, paginationNumber){
                                                                        $('#data_table').append('<center><img id = "dynamicChangeLoader" width="50px" src = "images/ajax-loader.gif" alt="Loading..." /></center>');
                                                                        $('#dynamicChangeLimit').addClass("disableAll");
                                                                        $('#data_table').addClass("disableAll");
                                                                        $('#dynamicChangePaginations').addClass("disableAll");
                                                                        $('.pagiNation').addClass("disableAll");
                                                                        $(".pagiNation").removeClass("btn-danger");
                                                                        $(".pagiNation").addClass("btn-default");
                                                                        $("#option1").removeClass("btn-default");
                                                                        $("#option1").addClass("btn-danger");
                                                                        var start = 1;
                                                                        if(paginationNumber == 1)
                                                                            start = paginationNumber;
                                                                        else
                                                                            start = Number(lenghtOfData) * (Number(paginationNumber) - 1);
                                                                        console.log(start +", "+ lenghtOfData);
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_nsuniv_prospectus_enquiry',
                                                                            type: 'POST',
                                                                            data:{action:"get_nsuniv_prospectus_enquiry", start:start, lenghtOfData:lenghtOfData},
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                                $('#dynamicChangeLimit').removeClass("disableAll");
                                                                                $('#data_table').removeClass("disableAll");
                                                                                $('#dynamicChangePaginations').removeClass("disableAll");
                                                                                $('.pagiNation').removeClass("disableAll");
                                                                            }
                                                                        }); 
                                                                    }
                                                                }
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                    $('#delete_university_prospectus_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                                });
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable({
                        "paging": false
                    });
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Nsuniv Prospectus Enquiry End
        //Nsuniv Get Started Enquiry Start
        if($_GET["action"] == "get_nsuniv_get_enquiry"){
            $objectSecond->update("tbl_alert", "`get_started_enquiry` = '0' WHERE `id`='1'");
            $objectSecond->sql = "";
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Seleted Course</th>
                        <th>Applicant Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                         <th>Referred By</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Last Qualification</th>
                        <th>Timing</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $objectDefault->select("admission_enquiry_tbl");
                       $objectDefault->where("`is_deleted` = '1' ORDER BY `id` DESC");
                      //$objectDefault->where("`admission_city` = 'jamshedpur'");
                        $result = $objectDefault->get();
                        //print_r($result); exit();
                        //if($result->num_rows > 0){
                            while($row = $objectDefault->get_row()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <td><?php echo $row["admission_course"] ?></td>
                                    <td><?php echo $row["admission_name"] ?></td>
                                    <td><?php echo $row["admission_email"] ?></td>
                                    <td><?php echo $row["admission_phone"] ?></td>
                                    <td><?php echo $row["revert_by"] ?></td>
                                    <td><?php echo $row["admission_state"] ?></td>
                                    <td><?php echo $row["admission_city"] ?></td>
                                    <td><?php echo $row["admission_last_qualify"] ?></td>
                                    <td><?php echo $row["time"] ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_university_get_enquiry<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Delete Section Start -->
                                    <div id="delete_university_get_enquiry<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_university_get_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_university_get_enquiry_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_id' id="delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_university_get_enquiry' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="delete_university_get_enquiry_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_university_get_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_university_get_enquiry_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_university_get_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["id"]; ?>").val();
                                                        var delete_id = $("#delete_id<?php echo $row["id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_id='+ delete_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
//                                                                console.log(dataString);
//                                                                console.log(result);
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Enquiry Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_nsuniv_get_enquiry',
                                                                            type: 'GET',
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                    $('#delete_university_get_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                                });
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Delete Section End -->
                                </tr>
                            <?php 
                                $s_no++;
                            }
                        /*} else
                            echo '
                                <div class="alert alert-warning alert-dismissible">
                                    <i class="icon fas fa-exclamation-triangle"></i>  No data available now!!!
                                </div>';
                                */
                    ?>
                </tbody>
            </table>
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Nsuniv Get Started Enquiry End
        
        //Nsuniv Online Admission Start
        if($_GET["action"] == "get_nsuniv_admission_enquiry"){
            $objectSecond->update("tbl_alert", "`admission_enquiry` = '0' WHERE `id`='1'");
            $objectSecond->sql = "";
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Phone No</th>
                        <th>Timing</th>
                        <th>Status</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $objectSecond->select("tbl_admission");
                        $objectSecond->where("`status` = '$visible' && `type` = 'online_admission' ORDER BY `admission_id` DESC");
                        $result = $objectSecond->get();
                        if($result->num_rows > 0){
                            while($row = $objectSecond->get_row()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>                                 
                                    <td><?php echo $row["admission_first_name"] ?> <?php echo $row["admission_middle_name"] ?> <?php echo $row["admission_last_name"] ?></td>
                                    <?php $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                    ?>
                                    <td><?php echo $row_course["course_name"]; ?></td>
                                    <td><?php echo $row["admission_mobile_student"] ?></td>
                                    <td><?php echo $row["post_at"] ?></td>
                                    <td><?php echo $row["approval"] ?></td>
                                    <td class="project-actions text-center">
                                         <button class="btn btn-info btn-sm" onclick="document.getElementById('view_student_lists<?php echo $row["admission_id"]; ?>').style.display='block'">
                                            <i class="fas fa-eye">
                                            </i>
                                            
                                        </button>                                      
                                        <a href="edit_student?id=<?php echo $row['admission_id'];?>"><button class="update btn btn-warning btn-sm"><i class="fas fa-pencil-alt">
                                            </i>
                                            </span></button></a>
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            
                                        </button>
                                    </td>
                                    
                                   <!-- Online Student List view Section Start -->
                                    <div id="view_student_lists<?php echo $row["admission_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:70%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('view_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Student Details</h2>
                                            </header>
                                            <form id="view_student_list_form<?php echo $row["admission_id"]; ?>" role="form" method="POST">
                                                <div class="card-body" style="margin-bottom: 50px;">
                                                    <div class="col-md-12" id="edit_error_section<?php echo $row["admission_id"]; ?>"></div>
                                                    <div class="row">
                                                       <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Registration Number</label>
                                                                <input type="text" name="" id="edit_student_list_reg_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_id"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Prospectus Number</label>
                                                                <input type="text" name="" id="edit_student_list_reg_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_form_no"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Admission Number</label>
                                                                <input type="text" name="" id="edit_student_list_admission_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_no"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Course Name</label>
                                                                <select name="" id="edit_student_list_course_name<?php echo $row["admission_id"]; ?>" class="form-control" readonly>
                                                                   <?php
                                                                        $sql_c = "SELECT * FROM `tbl_course`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                                        $result_c = $con->query($sql_c);
                                                                        while($row_c = $result_c->fetch_assoc()){
                                                                    ?>
                                                                    <option value="<?php echo $row_c["course_id"]; ?>" <?php if($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?> ><?php echo $row_c["course_name"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Session</label>
                                                                <select name="" id="edit_student_list_session<?php echo $row["admission_id"]; ?>" class="form-control" readonly>
                                                                   <?php
                                                                        $sql_c = "SELECT * FROM `tbl_university_details`
                                                                                       WHERE `status` = '$visible';
                                                                                       ";
                                                                        $result_c = $con->query($sql_c);
                                                                        while($row_c = $result_c->fetch_assoc()){
                                                                    ?>
                                                                    <option value="<?php echo $row_c["university_details_id"]; ?>" <?php if($row_c["university_details_id"] == $row["admission_session"]) echo 'selected'; ?> ><?php echo $row_c["university_details_academic_start_date"]; ?> to <?php echo $row_c["university_details_academic_end_date"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Student Name</label>
                                                                <input type="text" name="" id="edit_student_list_first_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_first_name"]; ?>&nbsp;&nbsp;<?php echo $row["admission_middle_name"]; ?>&nbsp;&nbsp;<?php echo $row["admission_last_name"]; ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>DOB</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_dob"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Nationality</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_nationality"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Adhar No</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_aadhar_no"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Date Of Admission</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["date_of_admission"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Category</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_category"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Gender</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_gender"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Username</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_username"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_password"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Blood Group</label>
                                                                <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_blood_group"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Hostel</label>
                                                                <input type="text" name="" id="edit_student_list_email<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_hostel"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Transport</label>
                                                                <input type="text" name="" id="edit_student_list_email<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_transport"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Image</label>
                                                                <img src="images/student_images/<?php echo $row["admission_profile_image"]; ?>" style="height:100%">
                                                            </div>
                                                        </div>
                                                         <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Student Contact No</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_mobile_student"]; ?>" readonly/>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Student EmailID</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_emailid_student"]; ?>" readonly/>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Father's Name</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_name"]; ?>" readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Father Contact No</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_phoneno"]; ?>" readonly/>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Mother's Name</label>
                                                                <input type="text" name="" id="edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_mother_name"]; ?>" readonly/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </form>
                                 
                                        </div>
                                    </div>
                                    <!-- online student list view Section End -->
                        
                                          <!-- delete Section Start -->
                                    <div id="delete_student_lists<?php echo $row["admission_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_student_list_form<?php echo $row["admission_id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["admission_id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_admission_id' id="delete_admission_id<?php echo $row["admission_id"]; ?>" value='<?php echo $row["admission_id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["admission_id"]; ?>" value='delete_student_lists' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["admission_id"]; ?>"></div>
                                                        <button type="button" id="delete_student_list_button<?php echo $row["admission_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <script>
                                                $(function() {
                                                    $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["admission_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["admission_id"]; ?>").val();
                                                        var delete_admission_id = $("#delete_admission_id<?php echo $row["admission_id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_admission_id='+ delete_admission_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Delete successfully!!!</div></div>');
                                                                    showUpdatedData();
                                                                    function showUpdatedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=fetch_student_list_details',
                                                                            type: 'POST',
                                                                            data: $('#fetchStudentDataForm').serializeArray(),
                                                                            success: function(result) {
                                                                                $('#response').remove();
                                                                                $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                console.log(result);
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                });
                                                                $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', false);
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Nsuniv Online Admission  End

        //Nsuniv All Notification Start
        if($_GET["action"] == "get_all_nsuniv_notifications"){
            $total_Notifications = 0;
            $objectSecond->select("tbl_alert");
            $objectSecond->where("`id` = '1'");
            $result = $objectSecond->get();
            if($result->num_rows > 0){
                $row = $objectSecond->get_row();
                $total_Notifications = $total_Notifications + $row["prospectus_enquiry"];
                $total_Notifications = $total_Notifications + $row["admission_enquiry"];
                $total_Notifications = $total_Notifications + $row["get_started_enquiry"];
                echo $total_Notifications;
            } else{
                echo $total_Notifications;
            }
        }
        //Nsuniv Prospectus Notification Start
        if($_GET["action"] == "get_all_nsuniv_prospectus_notifications"){
            $total_Notifications = 0;
            $objectSecond->select("tbl_alert");
            $objectSecond->where("`id` = '1'");
            $result = $objectSecond->get();
            if($result->num_rows > 0){
                $row = $objectSecond->get_row();
                $total_Notifications = $total_Notifications + $row["prospectus_enquiry"];
                echo $total_Notifications;
            } else{
                echo $total_Notifications;
            }
        }
        //Nsuniv Prospectus Notification End
        //Nsuniv Admission Notification Start
        if($_GET["action"] == "get_all_nsuniv_admission_notifications"){
            $total_Notifications = 0;
            $objectSecond->select("tbl_alert");
            $objectSecond->where("`id` = '1'");
            $result = $objectSecond->get();
            if($result->num_rows > 0){
                $row = $objectSecond->get_row();
                $total_Notifications = $total_Notifications + $row["admission_enquiry"];
                echo $total_Notifications;
            } else{
                echo $total_Notifications;
            }
        }
        //Nsuniv Admission Notification End
        //Nsuniv Get Started Notification Start
        if($_GET["action"] == "get_all_nsuniv_get_started_notifications"){
            $total_Notifications = 0;
            $objectSecond->select("tbl_alert");
            $objectSecond->where("`id` = '1'");
            $result = $objectSecond->get();
            if($result->num_rows > 0){
                $row = $objectSecond->get_row();
                $total_Notifications = $total_Notifications + $row["get_started_enquiry"];
                echo $total_Notifications;
            } else{
                echo $total_Notifications;
            }
        }
        //Nsuniv Get Started Notification End
        
        //Nsuniv Notification Start
        if($_GET["action"] == "get_nsuniv_notifications"){
        ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Theme</th>
                        <th>Notification</th>
                        <th class="project-actions text-center">Action </th>
                    </tr>
                </thead>
                <tbody>         
                   <?php 
                        $objectDefault->select("notification_tbl");
                        $objectDefault->where("`status` = '$visible' && `visibility` = 'active' ORDER BY `id` DESC");
                        $result = $objectDefault->get();
                        if($result->num_rows > 0){
                            while($row = $objectDefault->get_row()){
                                switch($row["theme"]){
                                    case "error":
                                        $bgTheme = "Main Red Theme";
                                        break;
                                    case "success":
                                        $bgTheme = "Main Blue Theme";
                                        break;
                                    case "info":
                                        $bgTheme = "Slider Blue Theme";
                                        break;
                                    case "warning":
                                        $bgTheme = "Warning Theme";
                                        break;
                                    default:
                                        $bgTheme = "No theme";
                                        break;
                                }
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <td><?php echo $bgTheme; ?></td>
                                    <td><?php echo $row["notification"]; ?></td>
                                    <td class="project-actions text-center">
                                        <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_university_home_enquiry<?php echo $row["id"]; ?>').style.display='block'">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                    
                                    <!-- Delete Section Start -->
                                    <div id="delete_university_home_enquiry<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                        <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                            <header class="w3-container" style="background:#343a40; color:white;">
                                                <span onclick="document.getElementById('delete_university_home_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                <h2 align="center">Are you sure???</h2>
                                            </header>
                                            <form id="delete_university_home_enquiry_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                <div class="card-body">
                                                    <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                                    <div class="col-md-12" align="center">
                                                        <input type='hidden' name='delete_id' id="delete_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                        <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_university_notification' />
                                                        <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                        <button type="button" id="delete_university_home_enquiry_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                        <button type="button" onclick="document.getElementById('delete_university_home_enquiry<?php echo $row["id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                    </div>
                                                    
                                                    <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                </div>
                                            </form>
                                            <script>
                                                $(function() {

                                                    $('#delete_university_home_enquiry_button<?php echo $row["id"]; ?>').click(function() {
                                                        $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                        $('#delete_university_home_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                        var action = $("#action_delete<?php echo $row["id"]; ?>").val();
                                                        var delete_id = $("#delete_id<?php echo $row["id"]; ?>").val();
                                                        var dataString = 'action='+ action + '&delete_id='+ delete_id;

                                                        $.ajax({
                                                            url: 'include/controller.php',
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function(result) {
//                                                                console.log(dataString);
//                                                                console.log(result);
                                                                $('#delete_response').remove();
                                                                if(result == "error"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "empty"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                }
                                                                if(result == "success"){
                                                                    $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Notification Delete successfully!!!</div></div>');
                                                                    showDeletedData();
                                                                    function showDeletedData(){
                                                                        $.ajax({
                                                                            url: 'include/view.php?action=get_nsuniv_notifications',
                                                                            type: 'GET',
                                                                            success: function(result) {
                                                                                $("#data_table").html(result);
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                $('#delete_loading').fadeOut(500, function() {
                                                                    $(this).remove();
                                                                    $('#delete_university_home_enquiry_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                                });
                                                            }

                                                        });
                                                    });

                                                });

                                            </script>
                                        </div>
                                    </div>
                                    <!-- Delete Section End -->
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
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

            </script>
        <?php
        }
        //Nsuniv Notification End
        /* ---------- All Fetch Codes End ------------------------ */
       
     //Fetching course & year wise fee report Start
        if($_GET["action"] == "fetch_fee_list_details"){
            $course_id = $_POST["course_id"];
            $academic_year = $_POST["academic_year"];          
            ?>
             
            <div class="card">
                <div class="card-header">
                    <form method="POST" action="export_course_yearwise.php">
                        <input type="hidden" name="course_id" value="<?= $course_id ?>" />
                        <input type="hidden" name="academic_year" value="<?= $academic_year ?>" />
                        <input type="hidden" name="action" value="export_fees_details" />
                        <button type="submit" class="btn btn-warning float-right"><i class="fa fa-download"></i> Export All</button>
                    </form>
                </div>
            </div>
            <table id="example1" class="table table-bordered table-striped display" style="width:100%;">
            <!--<table id="example" class="table table-bordered table-striped display" style="width:100%;">-->
             <!-- <table id="dtHorizontalExample" class="table table-bordered table-striped">-->
                <thead>
                    <tr>
                        <th width="10%">S.Nos</th>
                        <th  width="10%">Reg. No</th>
                         <th  width="10%">Course</th>
                        <th width="10%">Student Name</th>       
                        <th width="10%">Fees Details</th>
                       <th width="10%">Status</th>
                    </tr>
                </thead>
                <tbody  id="myTable">         
                   <?php 
                        if($course_id == "all")
                            $sql = "SELECT * FROM `tbl_admission`
                                    WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `stud_status` = 1
                                    ORDER BY `admission_id` ASC
                                    ";
                        else
                            $sql = "SELECT * FROM `tbl_admission`
                                    WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_course_name` = '$course_id'  && `stud_status` = 1
                                    ORDER BY `admission_id` ASC
                                    ";
                        $result = $con->query($sql);
                        if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $s_no; ?></td>
                                    <?php 
                                        $sql_course = "SELECT * FROM `tbl_course`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';
                                                       ";
                                        $result_course = $con->query($sql_course);
                                        $row_course = $result_course->fetch_assoc();
                                    ?>
                                    <td><?php echo $row["admission_id"] ?></td>
                                    <td><?php echo $row_course["course_name"] ?></td>
                                    <td><?php echo $row["admission_first_name"] ?> <?php echo $row["admission_middle_name"] ?> <?php echo $row["admission_last_name"] ?></td>
                                         <td>
                                        <table>
                                            <thead>
                                                <tr>
                                                <th width="10%">S.No</th>
                                                <th width="10%">Particular Name</th>
                                                <th  width="10%">Amount </th>
                                                <th  width="10%">Paid</th>
                                                <th width="10%">Rebate</th>
                                                <th width="10%">Fine</th>
                                                <th width="10%">Balance</th>
                                                <th width="10%">Fee Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $arrayFee = array(); //In Amount or In Number
                                                $arrayFine = array(); //In Amount or In Number
                                                $arrayRemaining = array(); //In Amount or In Number
                                                $arrayRebate = array(); //In Amount or In Number
                                                $totalFee = 0; //In Amount or In Number
                                                $totalFine = 0; //In Amount or In Number
                                                $totalRemaining = 0; //In Amount or In Number
                                                $totalRemainings = 0; //In Amount or In Number
                                                $totalRebate = 0; //In Amount or In Number
                                                $totalPaid = 0; //In Amount or In Number
                                                //String Variables
                                                $arrayPerticular = array();
                                                $arrayTblFee = array();
                                                $objTblFee = "";
                                                     //Checking If Hostel If Available Or Not
                                                if(strtolower($row["admission_hostel"]) == "yes")
                                                    $sqlTblFee = "SELECT *
                                                                 FROM `tbl_fee`
                                                                 WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' ORDER BY `fee_particulars` ASC
                                                                 ";
                                                else
                                                    $sqlTblFee = "SELECT *
                                                                 FROM `tbl_fee`
                                                                 WHERE `status` = '$visible' AND `course_id` = '".$row["admission_course_name"]."' AND `fee_academic_year` = '".$row["admission_session"]."' AND `fee_particulars` NOT IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees', '1st Year Hostel Fee', '1ST YEAR HOSTEL FEE', '2nd Year Hostel Fee', '2ND YEAR HOSTEL FEE', '3rd Year Hostel Fee', '3RD YEAR HOSTEL FEE', '4th Year Hostel Fee', '4TH YEAR HOSTEL FEE', '5th Year Hostel Fee', '5TH YEAR HOSTEL FEE', '6th Year Hostel Fee', '6TH YEAR HOSTEL FEE') ORDER BY `fee_particulars` ASC
                                                                 ";
                                                $resultTblFee = $con->query($sqlTblFee);
                                                if($resultTblFee->num_rows > 0)
                                                    while($rowTblFee = $resultTblFee->fetch_assoc()){
                                                        $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                                                        if(strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                                                            $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"])))/60/60/24;
                                                        else
                                                            $noOfDays = 0;
                                                    if($rowTblFee["fee_astatus"] == "Active")
                                                            $fine_particular = $rowTblFee["fee_fine"];
                                                        else
                                                            $fine_particular = 0;
                                                        $completeArray = array(
                                                                            "fee_id" => $rowTblFee["fee_id"],
                                                                            "fee_particulars" => $rowTblFee["fee_particulars"],
                                                                            "fee_amount" => $rowTblFee["fee_amount"],
                                                                            "fee_paid" => 0,
                                                                            "fee_fine" => $fine_particular,
                                                                            "fee_rebate" => 0,
                                                                            "fee_remaining" => $rowTblFee["fee_amount"],
                                                                            "fee_fine_days" => $noOfDays
                                                                        );
                                                        array_push($arrayTblFee, $completeArray);
                                                    }
                                                $arrayTblFee = json_decode(json_encode($arrayTblFee));
                                                $sqlTblFeePaid = "SELECT *
                                                                 FROM `tbl_fee_paid`
                                                                 WHERE `status` = '$visible' AND `student_id` = '".$row["admission_id"]."' AND `payment_status` IN ('cleared', 'pending')
                                                                 ";
                                                $resultTblFeePaid = $con->query($sqlTblFeePaid);
                                                if($resultTblFeePaid->num_rows > 0)
                                                    while($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()){
                                                        $arrayPaidId = explode(",", $rowTblFeePaid["particular_id"]);
                                                        $arrayPaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                                                        for($i=0; $i<count($arrayPaidId); $i++){
                                                            foreach($arrayTblFee as $arrayTblFeeUpdate){
                                                                if($arrayTblFeeUpdate->fee_id == $arrayPaidId[$i]){
                                                                    $totalPaid =%2
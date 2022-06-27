  <?php /* ------------------------------------------------- Fee Payment Start -------------------------------------------------- */
    // Student fee start
    if ($_GET["action"] == "fetch_student_fee_details") {
        $studentRegistrationNo = $_POST["studentRegistrationNo"];
        if (!empty($studentRegistrationNo)) {
            $sql = "SELECT *
                        FROM `tbl_admission`
                        INNER JOIN `tbl_university_details` ON `tbl_admission`.`admission_session` = `tbl_university_details`.`university_details_id`
                        INNER JOIN `tbl_course` ON `tbl_admission`.`admission_course_name` = `tbl_course`.`course_id`
                        WHERE `tbl_admission`.`admission_id` = '$studentRegistrationNo' && `tbl_admission`.`status` = '$visible' && `tbl_course`.`status` = '$visible' && `tbl_university_details`.`status` = '$visible'
                        ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['hostel_leave_date'] != '') {
                    $hostel_leave_date = $row['hostel_leave_date'];
                } else {
                    $hostel_leave_date = date('Y-m-d');
                }
                //Define Variables Section Start
                //Numeric Veriables
                $fee_inserted_date = '';
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
                $total_fine_payment = 0; //total fine amount 
                $total_fine_payment_remaining = 0;
                //String Variables
                $arrayPerticular = array();
                $arrayTblFee = array();
                $objTblFee = "";
                $overall_total_paid = 0;
                $total_fine_after_paying = 0;
                $total_fine_remaining = 0;
                $fee_remaining_from_database = 0;
                $rebate_fine_by_particular = 0;
                $total_rebate_fine_payment = 0;
                $fine_by_particular_remaning = 0;

                function rebate_fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $particular_id)
                {
                    $fine = 0; //fine variable is used for calculating the total fine for a particular id 

                    $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND rebate_amount!='' ORDER BY `rebate_amount` ASC ";
                    $resultTblFeePaid = $con->query($sqlTblFeePaid);

                    if ($resultTblFeePaid->num_rows > 0) {

                        while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {

                            if ($rowTblFeePaid['rebate_amount'] > 0) {

                                $after_expoide_id = explode(",", $rowTblFeePaid['particular_id']);
                                $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                                // echo "<pre>";
                                //  print_r($after_expoide_id);
                                for ($i = 0; $i < count($after_expoide_id); $i++) {
                                    if ($after_PaidAmount[$i] != '') {
                                        if ($particular_id == $after_expoide_id[$i]) {
                                            $rebate_fine =  explode(",", $rowTblFeePaid['rebate_amount']);
                                            if ($rebate_fine[1] === 'fine') {
                                                $fine = $fine + $rebate_fine[0];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return $fine;
                }


                function remaining_fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $particular_id)
                {
                    $fine = 0; //fine variable is used for calculating the total fine for a particular id 

                    $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND remaining_fine!='' ORDER BY `remaining_fine` ASC ";
                    $resultTblFeePaid = $con->query($sqlTblFeePaid);

                    if ($resultTblFeePaid->num_rows > 0) {

                        while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {

                            if ($rowTblFeePaid['remaining_fine'] > 0) {

                                $after_expoide_id = explode(",", $rowTblFeePaid['particular_id']);
                                $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                                for ($i = 0; $i < count($after_expoide_id); $i++) {
                                    if ($after_PaidAmount[$i] != '') {
                                        if ($particular_id == $after_expoide_id[$i]) {
                                            $fine = $rowTblFeePaid['remaining_fine'];
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

                function fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $particular_id)
                {
                    $fine = 0; //fine variable is used for calculating the total fine for a particular id 

                    $sqlTblFeePaid = "SELECT *
                        FROM `tbl_fee_paid`
                        WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                        AND fine!=''";
                    $resultTblFeePaid = $con->query($sqlTblFeePaid);

                    if ($resultTblFeePaid->num_rows > 0) {

                        while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {

                            if ($rowTblFeePaid['fine'] > 0) {

                                $after_expoide_id = explode(",", $rowTblFeePaid['particular_id']);
                                $after_PaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);

                                for ($i = 0; $i < count($after_expoide_id); $i++) {
                                    if ($after_PaidAmount[$i] != '') {
                                        if ($particular_id == $after_expoide_id[$i]) {
                                            $fine = $fine + $rowTblFeePaid['fine'];
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
                function fine_calculator_by_total($con, $visible, $studentRegistrationNo)
                {
                    $fine = 0; //fine variable is used for calculating the total fine for a particular student 

                    $sqlTblFeePaid = "SELECT SUM(fine) as fine
                            FROM `tbl_fee_paid`
                            WHERE `status` = '$visible' AND `student_id` = '$studentRegistrationNo' AND `payment_status` IN ('cleared', 'pending')
                            AND fine!=''";
                    $resultTblFeePaid = $con->query($sqlTblFeePaid);

                    if ($resultTblFeePaid->num_rows > 0) {
                        $rowTblFeePaid = $resultTblFeePaid->fetch_assoc();
                        $fine = $rowTblFeePaid['fine'];
                    }
                    return $fine;
                }

                $total_fee_recoard = "SELECT *
                        FROM `tbl_fee`
                        WHERE `status` = '$visible' AND `course_id` = '" . $row["admission_course_name"] . "' AND `fee_academic_year` = '" . $row["admission_session"] . "'   ORDER BY `fee_particulars` ASC
                        ";
                $total_fee_result = mysqli_query($con, $total_fee_recoard);
                while ($total_fee_row = mysqli_fetch_array($total_fee_result)) {

                    $checkDate = date('Y-m-d', strtotime(str_replace(',', ' ', $total_fee_row['fee_time'])));
                }




                //Checking If Hostel If Available Or Not
                if (strtolower($row["admission_hostel"]) == "yes") {
                    $sqlTblFee = "SELECT *
                                     FROM `tbl_fee`
                                     WHERE `status` = '$visible' AND `course_id` = '" . $row["admission_course_name"] . "' AND `fee_academic_year` = '" . $row["admission_session"] . "'   ORDER BY `fee_particulars` ASC
                                     ";
                    $resultTblFee = $con->query($sqlTblFee);
                    if ($resultTblFee->num_rows > 0)
                        while ($rowTblFee = $resultTblFee->fetch_assoc()) {

                            //  checking the in particular have a hostel or not

                            if (strripos($rowTblFee['fee_particulars'], "hostel") == '') {

                                if ($fee_inserted_date)
                                    $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                                if (strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                                    $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"]))) / 60 / 60 / 24;
                                else
                                    $noOfDays = 0;
                                if ($rowTblFee["fee_astatus"] == "Active")
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
                                    "balace_amount" => 0,
                                );
                                array_push($arrayTblFee, $completeArray);
                            } else {
                                // getting the date of the fee table 
                                $fee_inserted_date =  date('Y-m-d', strtotime(str_replace(',', ' ', $rowTblFee['fee_time'])));
                                //  checking the hoster leave date
                                if (strtotime($fee_inserted_date) <= strtotime($hostel_leave_date)) {
                                    if ($fee_inserted_date)
                                        $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                                    if (strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                                        $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"]))) / 60 / 60 / 24;
                                    else
                                        $noOfDays = 0;
                                    if ($rowTblFee["fee_astatus"] == "Active")
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
                                        "balace_amount" => 0,
                                    );
                                    array_push($arrayTblFee, $completeArray);
                                }
                            }
                        }
                } else {
                    $sqlTblFee = "SELECT *
                                     FROM `tbl_fee`
                                     WHERE `status` = '$visible' AND `course_id` = '" . $row["admission_course_name"] . "' AND `fee_academic_year` = '" . $row["admission_session"] . "'  AND `fee_particulars` NOT IN ('HOSTEL FEE', 'hostel fee', 'Hostel Fee', 'HOSTELS FEES', 'hostels fees', 'Hostels Fees', 'HOSTELS FEE', 'hostels fee', 'Hostels Fee', 'HOSTEL FEES', 'hostel fees', 'Hostel Fees', '1st Year Hostel Fee', '1ST YEAR HOSTEL FEE', '2nd Year Hostel Fee', '2ND YEAR HOSTEL FEE', '3rd Year Hostel Fee', '3RD YEAR HOSTEL FEE', '4th Year Hostel Fee', '4TH YEAR HOSTEL FEE', '5th Year Hostel Fee', '5TH YEAR HOSTEL FEE', '6th Year Hostel Fee', '6TH YEAR HOSTEL FEE','Caution Fee') ORDER BY `fee_particulars` ASC
                                     ";
                    $resultTblFee = $con->query($sqlTblFee);
                    if ($resultTblFee->num_rows > 0)
                        while ($rowTblFee = $resultTblFee->fetch_assoc()) {
                            if ($fee_inserted_date)
                                $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                            if (strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                                $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"]))) / 60 / 60 / 24;
                            else
                                $noOfDays = 0;
                            if ($rowTblFee["fee_astatus"] == "Active")
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
                                "balace_amount" => 0,
                            );
                            array_push($arrayTblFee, $completeArray);
                        }
                }

                //  $resultTblFee = $con->query($sqlTblFee);
                //  if($resultTblFee->num_rows > 0)
                //      while($rowTblFee = $resultTblFee->fetch_assoc()){
                //          $totalFee = $totalFee + intval($rowTblFee["fee_amount"]);
                //          if(strtotime(date($rowTblFee["fee_lastdate"])) < strtotime(date("Y-m-d")))
                //              $noOfDays = (strtotime(date("Y-m-d")) - strtotime(date($rowTblFee["fee_lastdate"])))/60/60/24;
                //          else
                //              $noOfDays = 0;
                //          if($rowTblFee["fee_astatus"] == "Active")
                //              $fine_particular = $rowTblFee["fee_fine"];
                //          else
                //              $fine_particular = 0;

                //          $completeArray = array(
                //                              "fee_id" => $rowTblFee["fee_id"],
                //                              "fee_particulars" => $rowTblFee["fee_particulars"],
                //                              "fee_amount" => $rowTblFee["fee_amount"],
                //                              "fee_paid" => 0,
                //                              "fee_fine" => $fine_particular,
                //                              "fee_rebate" => 0,
                //                              "fee_remaining" => $rowTblFee["fee_amount"],
                //                              "fee_fine_days" => $noOfDays,
                //                              "fee_last_date" => $rowTblFee["fee_lastdate"],
                //                              "balace_amount"=>0,
                //                          );
                //          array_push($arrayTblFee, $completeArray);
                //      }


                $arrayTblFee = json_decode(json_encode($arrayTblFee));
                // echo "<pre>";
                // print_r($arrayTblFee);
                $lastpaymentDate = "";
                $sqlTblFeePaid = "SELECT *
                                     FROM `tbl_fee_paid`
                                     WHERE `status` = '$visible' AND `student_id` = '" . $studentRegistrationNo . "' AND `payment_status` IN ('cleared', 'pending')
                                     ";
                $resultTblFeePaid = $con->query($sqlTblFeePaid);

                if ($resultTblFeePaid->num_rows > 0)
                    while ($rowTblFeePaid = $resultTblFeePaid->fetch_assoc()) {
                        $lastpaymentDate = $rowTblFeePaid; //get last payment data

                        $arrayPaidId = explode(",", $rowTblFeePaid["particular_id"]);
                        $arrayPaidAmount = explode(",", $rowTblFeePaid["paid_amount"]);
                        for ($i = 0; $i < count($arrayPaidId); $i++) {
                            foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                if ($arrayTblFeeUpdate->fee_id == $arrayPaidId[$i]) {
                                    $totalPaid = $totalPaid + intval($arrayPaidAmount[$i]);
                                    if ($rowTblFeePaid["rebate_amount"] != "") {
                                        $arrayRebateAmount = explode(",", $rowTblFeePaid["rebate_amount"]);
                                        if ($arrayTblFeeUpdate->fee_id == intval($arrayRebateAmount[1])) {
                                            $totalRebate = $totalRebate + intval($arrayRebateAmount[0]);
                                            $arrayTblFeeUpdate->fee_rebate = $arrayTblFeeUpdate->fee_rebate + intval($arrayRebateAmount[0]);
                                        }
                                    }
                                    $arrayTblFeeUpdate->fee_paid = $arrayTblFeeUpdate->fee_paid + intval($arrayPaidAmount[$i]);
                                    $arrayTblFeeUpdate->fee_remaining = $arrayTblFeeUpdate->fee_remaining - intval($arrayPaidAmount[$i]);
                                }
                            }
                        }
                        $total_balance_amount_after_pay = ($arrayTblFeeUpdate->balace_amount + $rowTblFeePaid["balance"]);
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
                                    if (!empty($row["admission_profile_image"])) {
                                    ?>
                                      <img class="profile-user-img " src="../images/student_images/<?php echo $row["admission_profile_image"]; ?>" alt="Student profile picture">
                                  <?php
                                    } else if (strtolower($row["admission_gender"]) == "female") {
                                    ?>
                                      <img class="profile-user-img img-fluid img-circle" src="images/womenIcon.png" alt="Student profile picture">
                                  <?php } else {   ?>
                                      <img class="profile-user-img img-fluid img-circle" src="images/menIcon.png" alt="Student profile picture">
                                  <?php } ?>
                              </div>

                              <h3 class="profile-username text-center"><?php echo $row["admission_first_name"] . " " . $row["admission_last_name"]; ?></h3>
                              <?php
                                $completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
                                $completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
                                $completeSessionOnlyYear = $completeSessionStart[0] . "-" . $completeSessionEnd[0];
                                ?>
                              <p class="text-muted text-center">( <?php echo $row["course_name"] . " | " . $completeSessionOnlyYear; ?> )</p>

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
                                  <b>Name - </b><?php echo $row["admission_first_name"] . " " . $row["admission_last_name"]; ?><br />
                                  <b>Gender - </b><?php echo $row["admission_gender"]; ?><br />
                                  <b>DOB - </b><?php echo $row["admission_dob"]; ?><br />
                                  <b> Nationality - </b><?php echo $row["admission_nationality"]; ?><br />
                                  <b> Blood Group - </b><?php echo $row["admission_blood_group"]; ?><br />
                                  <b> Email - </b><?php echo $row["admission_emailid_student"]; ?><br />
                                  <b>Contact No - </b><?php echo $row["admission_mobile_student"]; ?><br />
                                  <b>Father's Name - </b><?php echo $row["admission_father_name"]; ?><br />
                                  <b>Father's Email - </b><?php echo $row["admission_emailid_father"]; ?><br />
                                  <b>Father's Contact - </b><?php echo $row["admission_father_phoneno"]; ?><br />
                                  <b>Father's Whatsapp - </b><?php echo $row["admission_father_whatsappno"]; ?><br />
                                  <b> Mother's Name - </b><?php echo $row["admission_mother_name"]; ?><br />
                              </p>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <!-- About Me Box -->
                      <div class="card card-primary">
                          <div class="card-header">
                              <h3 class="card-title">More Informations</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                              <h6><i class="fas fa-book mr-1"></i> Educational Details (10th)</h6>
                              <p class="text-muted">
                                  University - <?php echo $row["admission_high_school_board_university"]; ?><br />
                                  College - <?php echo $row["admission_high_school_college_name"]; ?><br />
                                  Passing Year - <?php echo $row["admission_high_school_passing_year"]; ?><br />
                                  Percentage - <?php echo $row["admission_high_school_per"]; ?> %<br />
                              </p>

                              <h6><i class="fas fa-map-marker-alt mr-1"></i> Location</h6>
                              <p class="text-muted">
                                  <?php echo $row["admission_residential_address"]; ?>,<br />
                                  <?php echo $row["admission_city"]; ?>, </br><?php echo $row["admission_state"]; ?><br />
                                  <?php echo $row["admission_district"]; ?>,<br />
                                  <?php echo $row["admission_pin_code"]; ?><br />
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
                                      <form method="POST" id="PayFeeForm" onSubmit="return:false">
                                          <!-- Table row -->
                                          <div class="row">
                                              <input type="hidden" name="registrationNumber" value="<?php echo $studentRegistrationNo; ?>" readonly />
                                              <input type="hidden" name="courseId" value="<?php echo $row["course_id"]; ?>" readonly />
                                              <input type="hidden" name="academicYear" value="<?php echo $row["university_details_id"]; ?>" readonly />
                                              <div class="col-12 table-responsive" style="overflow-x:auto;">
                                                  <h5>Fee Details of <b><a href="javascript:void(0);"><?php echo $row["course_name"] . " | " . $completeSessionOnlyYear; ?></a></b></h5>
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
                                                            $fine_array = 0;
                                                            foreach ($arrayTblFee as $arrayTblFeeUpdate) {

                                                                if (($arrayTblFeeUpdate->fee_remaining - $arrayTblFeeUpdate->fee_rebate) === 0) {
                                                                    $arrayTblFeeUpdate->fee_fine_days = 0;
                                                                    $arrayTblFeeUpdate->fee_fine = 0;
                                                                    $fee_remaining_from_database = remaining_fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $arrayTblFeeUpdate->fee_id);
                                                                } else {

                                                                    $fee_remaining_from_database = 0;
                                                                }



                                                            ?>
                                                              <tr>
                                                                  <td><?php echo $tmpSNo; ?></td> <!-- serial number -->
                                                                  <td><?php echo $arrayTblFeeUpdate->fee_particulars; ?></td> <!-- particular -->
                                                                  <td><?php echo  date("d-m-Y", strtotime($arrayTblFeeUpdate->fee_last_date))  ?></td> <!--  last date -->
                                                                  <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_amount); ?></td> <!-- amount -->
                                                                  <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_paid); ?></td> <!-- paid -->
                                                                  <td>&#8377; <?php echo number_format($arrayTblFeeUpdate->fee_rebate); ?></td> <!-- rebate -->

                                                                  <!-- Remaining -->
                                                                  <td>&#8377; <?php echo $total_remaining_amount = ($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate); ?></td>
                                                                  <?php $totalRemaining = $totalRemaining + $total_remaining_amount;


                                                                    ?>

                                                                  <!-- Fine -->
                                                                  <td>&#8377; <?php echo $all_fine = ($arrayTblFeeUpdate->fee_fine) * ($arrayTblFeeUpdate->fee_fine_days) + $fee_remaining_from_database ?></td>
                                                                  <!-- total fine -->
                                                                  <?php $totalFine = $totalFine + $all_fine ?>
                                                                  <!-- Fine paid -->
                                                                  <td>&#8377; <?php echo $fine_by_particular = fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $arrayTblFeeUpdate->fee_id) ?></td>
                                                                  <!-- total fine paid -->
                                                                  <?php $total_fine_payment = $total_fine_payment + $fine_by_particular;   ?>
                                                                  <!-- fine rebate -->
                                                                  <td>&#8377; <?php
                                                                                echo $rebate_fine_by_particular =  rebate_fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $arrayTblFeeUpdate->fee_id); ?></td>
                                                                  <!-- total fine paid -->
                                                                  <?php

                                                                    $total_rebate_fine_payment = $total_rebate_fine_payment + $rebate_fine_by_particular;   ?>

                                                                  <!-- fine remaining  -->
                                                                  <td>&#8377; <?php
                                                                                // if($fine_by_particular_remaning>0){
                                                                                echo $fine_by_particular_remaning =  $all_fine - $fine_by_particular - $rebate_fine_by_particular;
                                                                                //  }
                                                                                //else{
                                                                                // echo    $fine_by_particular_remaning=  $all_fine-$fine_by_particular;

                                                                                //   } 
                                                                                ?></td>

                                                                  <!-- total fine remaining -->
                                                                  <?php $total_fine_payment_remaining = $total_fine_payment_remaining + $fine_by_particular_remaning ?>

                                                                  <!-- Total paid particular -->
                                                                  <td>&#8377; <?php echo $overall_total_paid_particular =  ($arrayTblFeeUpdate->fee_paid) + fine_calculator_by_particular($con, $visible, $studentRegistrationNo, $arrayTblFeeUpdate->fee_id) + $arrayTblFeeUpdate->fee_rebate + $rebate_fine_by_particular ?></td>

                                                                  <!-- total paid -->
                                                                  <?php $overall_total_paid = $overall_total_paid + $overall_total_paid_particular ?>


                                                                  <!-- total remaining including fine -->

                                                                  <td><span class="text-red text-bold">&#8377; <?php echo  $total_remaing_amount_final = $total_remaining_amount + $fine_by_particular_remaning  ?></span></td>
                                                                  <?php $totalRemainings = $totalRemainings + $total_remaing_amount_final;  ?>
                                                                  <?php //} 
                                                                    ?>
                                                                  <!--check last payment date -->
                                                                  <input type="hidden" id="particular_paid_id[<?php echo $Idno; ?>]" name="particular_paid_id[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_id; ?>" />
                                                                  <input type="hidden" id="particular_paid_lastDate[<?php echo $Idno; ?>]" name="particular_paid_lastDate[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_last_date; ?>" />
                                                                  <input type="hidden" id="particular_paid_fineAmount[<?php echo $Idno; ?>]" name="particular_paid_fineAmount[<?php echo $Idno; ?>]" value="<?php echo $arrayTblFeeUpdate->fee_fine; ?>" />
                                                                  <input type="hidden" id="particular_paid_amount1[<?php echo $Idno; ?>]" name="particular_paid_amount1[<?php echo $Idno; ?>]" value="<?php echo ($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate) ?>" />
                                                                  <input type="hidden" id="particular_fine_remaining[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="particular_fine_remaining[<?php echo $Idno; ?>]" value="<?php echo $fine_by_particular_remaning  ?>" />
                                                                  <input type="hidden" id="fine_by_particular[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="fine_by_particular[<?php echo $Idno; ?>]" value="<?php echo $fine_by_particular  ?>" />

                                                                  <input type="hidden" id="particular_fine_for_database[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" name="particular_fine_for_database[<?php echo $arrayTblFeeUpdate->fee_id; ?>]" value="<?php echo $all_fine  ?>" />

                                                                  <?php
                                                                    //} 
                                                                    ?>

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

                                                            foreach ($arrayTblFee as $arrayTblFeeUpdate) {

                                                            ?>
                                                              <tr>
                                                                  <td><?php echo $tmpSNo; ?></td>
                                                                  <td><?php echo $arrayTblFeeUpdate->fee_particulars; ?></td>
                                                                  <td>


                                                                      <div class="input-group">
                                                                          <div class="input-group-prepend">
                                                                              <span class="input-group-text">&#8377;</span>
                                                                          </div>
                                                                          <input id="particular_paid_amount[<?php echo $Idno; ?>]" name="particular_paid_amount[<?php echo $Idno; ?>]" min="0" value="<?php echo (($arrayTblFeeUpdate->fee_remaining) - ($arrayTblFeeUpdate->fee_rebate));
                                                                                                                                                                                                        ?>" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" <?php echo "readonly"; ?>>

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
                                                                      <input value="<?php echo $totalFine ?>" id="fine_amount1" name="fine_amount" min="0" max="<?php echo $totalFine; ?>" type="hidden">
                                                                      <input value="<?= $total_fine_payment_remaining ?>" id="fine_amount" name="fine_amount" min="0" max="<?php echo $totalFine; ?>" type="number" class="form-control" onKeyup="completeCalculation();" onClick="completeCalculation();" onChange="completeCalculation();" onBlur="completeCalculation();" <?php echo "readonly"; ?>>


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
                                                                      <input id="total_amount" name="total_amount" min="0" value="<?= $totalRemainings ?>" max="<?php echo $totalRemainings ?>" type="number" class="form-control" readonly>
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
                                              <!-- /.col -->

                                          </div>
                                          <br />
                                          <div class="row">

                                              <input type="hidden" id="PaymentMode" value="Online" name="PaymentMode" class="form-control" onchange="" />
                                              <input type="hidden" id="cashDepositTo" name="cashDepositTo" class="form-control" value="University Office" />
                                              <input type="hidden" id="paidDate" name="paidDate" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" />

                                              <div class="col-md-12"></div>
                                              <div class="col-md-12" id="" style="margin-top:20px;"></div>
                                              <div class="col-md-3" id="pay_div" style=" margin-top:20px;">
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <input type="hidden" name="action" value="pay_fees" />
                                                          <button id="PayFeeButton" name="PayFeeButton" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#myModal" onclick="completeCalculation">Pay & Confirm</button>
                                                      </div>
                                                      <!-- /.input group -->
                                                  </div>
                                              </div>
                                              <!--<div class="col-md-3" id="reset_div" style="margin-top:20px;">
                                              <div class="form-group">
                                                  <div class="input-group">
                                                      <button class="btn btn-danger btn-lg btn-block" type="reset" onclick="return confirm('Are you sure you want to reset all Informations???');" >Reset</button>
                                                  </div>
                                                  
                                              </div>
                                          </div>-->


                                          </div>
                                          <!-- /.row -->
                                      </form>

                                      <div class="modal fade" id="myModal" role="dialog">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <?php
                                                        $len = 10;   // total number of numbers
                                                        $min = 10000000000;  // minimum
                                                        $max = 99999999999;  // maximum
                                                        $range = []; // initialize array
                                                        foreach (range(0, $len - 1) as $i) {
                                                            while (in_array($num = mt_rand($min, $max), $range));
                                                            $range[] = $num;
                                                        }
                                                        ?>

                                                      <form id="payment_form" method="post" action="easebuzz/easebuzz.php?api_name=initiate_payment">
                                                          <input type="hidden" name="paymode" value="9" />
                                                          <div class="form-row">
                                                              <div class="form-group col-md-6">
                                                                  <label for="">Transaction ID</label>
                                                                  <input id="txnid" class="form-control" name="txnid" value="<?php echo $num; ?>" placeholder="" readonly>
                                                              </div>

                                                              <div class="form-group col-md-6">
                                                                  <label for="">Amount</label>
                                                                  <!--<input class="form-control" id="amount"  name="amount" value="<?php //echo $_SESSION["remaining_amount"] 
                                                                                                                                    ?>" readonly>-->
                                                                  <input class="form-control" id="amount" name="amount" value="<?= $totalRemainings . '.0' ?>" readonly>

                                                              </div>
                                                              <div class="form-group col-md-6">
                                                                  <label for="">Name</label>
                                                                  <input id="firstname" class="form-control" name="firstname" value="<?php echo $row["admission_first_name"] . " " . $row["admission_last_name"]; ?>" placeholder="" readonly>
                                                              </div>

                                                              <div class="form-group col-md-6">
                                                                  <label for="">Course</label>
                                                                  <input id="course" class="form-control" name="udf1" value="<?php echo $row["course_name"]; ?>" placeholder="" readonly>
                                                                  <?php $_SESSION["course_name"] = $row['course_name']; ?>
                                                              </div>

                                                              <div class="form-group col-md-6">
                                                                  <label for="">Session</label>
                                                                  <input id="course" class="form-control" name="udf2" value="<?php echo $completeSessionOnlyYear; ?>" placeholder="" readonly>
                                                                  <?php //$_SESSION['".$completeSessionOnlyYear."]= $completeSessionOnlyYear; 
                                                                    ?>
                                                              </div>


                                                              <div class="form-group col-md-6">
                                                                  <label for="">Email ID</label>
                                                                  <input id="email" class="form-control" name="email" value="<?php echo $row["admission_emailid_student"] ?>" placeholder="" readonly>
                                                                  <?php $_SESSION["admission_emailid_student"] = $row['admission_emailid_student']; ?>
                                                              </div>
                                                              <div class="form-group col-md-6">
                                                                  <label for="">Phone No</label>
                                                                  <input id="phone" class="form-control" name="phone" value="<?php echo $row["admission_mobile_student"] ?>" placeholder="" readonly>
                                                                  <?php $_SESSION["admission_mobile_student"] = $row['admission_mobile_student']; ?>
                                                              </div>
                                                              <div class="form-group col-md-6">
                                                                  <label for="">Status</label>
                                                                  <input id="productinfo" class="form-control" name="productinfo" value="<?php echo "Fee"; ?>" placeholder="" readonly>
                                                              </div>
                                                              <input type="hidden" id="surl" class="surl" name="surl" value="https://nsucms.in/nsucms/student/success" placeholder="">
                                                              <input type="hidden" id="furl" class="furl" name="furl" value="https://nsucms.in/nsucms/student/success" placeholder="">
                                                              <div class="form-group col-md-4 mt-2">
                                                                  <button class="btn btn-primary btn-lg btn-block" type="submit" name="button"><i class="fa fa-paper-plane"></i> Pay </button>
                                                              </div>
                                                          </div>
                                                          <!-- Submit And Payment Section Ends -->
                                                      </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                  </div>
                                              </div>

                                          </div>
                                      </div>

                                      <script>
                                          window.onscroll = function() {
                                              completeCalculation()
                                          };

                                          //alert('working');
                                          function completeCalculation() {
                                              var totalPaid = 0;
                                              var totalParticular = 0;
                                              var fineAmount = 0;
                                              var rebateAmount = Number(document.getElementById("rebate_amount").value);
                                              if (rebateAmount > 0) {
                                                  if (document.getElementById("rebate_from").value == "") {
                                                      $("#rebate_amount").addClass("is-invalid");
                                                      $("#rebateErr").html("~ Please select 'Rebate From'");
                                                  } else {
                                                      $("#rebate_amount").removeClass("is-invalid");
                                                      $("#rebateErr").html("");
                                                  }
                                              } else {
                                                  $("#rebate_amount").removeClass("is-invalid");
                                                  $("#rebateErr").html("");
                                              }
                                              var remainingAmount = 0;
                                              <?php
                                                $Idno = 0;
                                                foreach ($arrayTblFee as $arrayTblFeeUpdate) {
                                                ?>
                                                  if (document.getElementById("particular_paid_amount[<?php echo $Idno; ?>]").value != "")
                                                      totalParticular = totalParticular + parseInt(document.getElementById("particular_paid_amount[<?php echo $Idno; ?>]").value);
                                              <?php
                                                    $Idno++;
                                                }
                                                ?>
                                              if (document.getElementById("fine_amount").value != "")
                                                  fineAmount = parseInt(document.getElementById("fine_amount").value);
                                              totalPaid = totalPaid + parseInt(totalParticular);
                                              //alert(totalPaid); 
                                              totalPaid = totalPaid + parseInt(fineAmount);
                                              remainingAmount = parseInt(<?php echo $totalRemainings; ?>) - parseInt(totalPaid) - parseInt(rebateAmount);
                                              $("#total_amount").val(totalPaid);
                                              $("#amount").val(totalPaid + ".0");
                                              $("#remaining_amount").val(remainingAmount);
                                              if (0 > parseInt(remainingAmount)) {
                                                  $("#remaining_amount").addClass("is-invalid");
                                                  $("#remainingErr").html("~ Cannot use negative value, Remaining value must be 'greater than or equal to 0'");
                                                  $("#totalErr").html("~ Total value must be 'less than or equal to <?php echo $totalRemainings; ?>'");
                                                  $("#total_amount").addClass("is-invalid");
                                              } else {
                                                  $("#remaining_amount").removeClass("is-invalid");
                                                  $("#total_amount").removeClass("is-invalid");
                                                  $("#remainingErr").html("");
                                                  $("#totalErr").html("");
                                              }
                                          }
                                      </script>
                                      <script>
                                          function PaymentModeSelect(PaymentMode) {
                                              var cash_div = document.getElementById('cash_div');
                                              var bankName_div = document.getElementById('bankName_div');
                                              var chequeNo_div = document.getElementById('chequeNo_div');
                                              var receiptDate_div = document.getElementById('receiptDate_div');
                                              var notes_div = document.getElementById('notes_div');
                                              var pay_div = document.getElementById('pay_div');
                                              if (PaymentMode == "Cash") {
                                                  cash_div.style.display = "block";
                                                  bankName_div.style.display = "none";
                                                  chequeNo_div.style.display = "none";
                                                  receiptDate_div.style.display = "block";
                                                  notes_div.style.display = "block";
                                                  pay_div.style.display = "block";
                                              } else if (PaymentMode == "Cheque" || PaymentMode == "DD" || PaymentMode == "Online" || PaymentMode == "NEFT/IMPS/RTGS") {
                                                  cash_div.style.display = "none";
                                                  bankName_div.style.display = "block";
                                                  chequeNo_div.style.display = "block";
                                                  receiptDate_div.style.display = "block";
                                                  notes_div.style.display = "block";
                                                  pay_div.style.display = "block";
                                              } else {
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
                                                          if (result == "success") {
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
                                                                          if (result == 0) {
                                                                              $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please enter Registration Number!!!</div></div>');
                                                                          } else if (result == 1) {
                                                                              $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                                                                          } else {
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
                                            if ($result_paid_time->num_rows > 0) {
                                                while ($row_paid_time = $result_paid_time->fetch_assoc()) {
                                                    $allPerticulars = explode(",", $row_paid_time["paid_amount"]);
                                                    $totalPerticular = 0;
                                                    for ($i = 0; $i < count($allPerticulars); $i++)
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

                                                      <div id="fee_Status_section_full<?php echo $row_paid_time["feepaid_id"]; ?>" class="timeline-item" style="background-color:<?php if (strtolower($row_paid_time["payment_status"]) == "bounced") echo '#ffcccb';
                                                                                                                                                                                    if (strtolower($row_paid_time["payment_status"]) == "pending") echo '#ffffed';
                                                                                                                                                                                    if (strtolower($row_paid_time["payment_status"]) == "refunded") echo '#ffa7a7'; ?>;">
                                                          <span class="time"><i class="far fa-clock"></i> <?php echo $row_paid_time["fee_paid_time"]; ?> </span>

                                                          <h3 class="timeline-header"><a href="javascript:void(0);">Payment Information</a></h3>

                                                          <div class="timeline-body">
                                                              <table class="table table-striped">
                                                                  <thead>
                                                                      <tr>
                                                                          <th>Total Perticular</th>
                                                                          <th>Fine</th>
                                                                          <th>Rebate</th>
                                                                          <th>Total Paid</th>
                                                                          <th><span class="text-red">Remaining</span></th>
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      <tr>
                                                                          <td>&#8377; <?php echo number_format(intval($totalPerticular)); ?></td>
                                                                          <td>&#8377; <?php echo number_format(intval($row_paid_time["fine"])); ?></td>
                                                                          <td>&#8377; <?php echo number_format(intval($row_paid_time["rebate_amount"])); ?></td>
                                                                          <td>&#8377; <?php echo number_format(intval($totalAmount) + intval($row_paid_time["rebate_amount"])); ?></td>
                                                                          <td>&#8377; <?php echo number_format(intval($row_paid_time["balance"])); ?></td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>

                                                              <h5 class="timeline-header"><a href="javascript:void(0);">Payment Mode</a> ~ <?php echo $row_paid_time["payment_mode"]; ?></h5>
                                                              <h5 class="timeline-header"><a href="javascript:void(0);">Payment Status</a> ~ <span id="fee_Status_section<?php echo $row_paid_time["feepaid_id"]; ?>"><span class="<?php if (strtolower($row_paid_time["payment_status"]) == "bounced") echo 'bg-danger';
                                                                                                                                                                                                                                    if (strtolower($row_paid_time["payment_status"]) == "refunded") echo 'bg-danger';
                                                                                                                                                                                                                                    else if (strtolower($row_paid_time["payment_status"]) == "pending") echo 'bg-warning'; ?>"><?php echo strtoupper($row_paid_time["payment_status"]); ?></span></span> </h5>
                                                          </div>
                                                          <div class="timeline-footer" align="right" style="display:none">
                                                              <h5 class="timeline-header"><a href="javascript:void(0);">Give Status Here</a></h5>
                                                              <?php if ($row_paid_time["payment_status"] == "refunded") { ?>
                                                                  <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'cleared')" class="btn btn-info btn-sm">Add this Fee</a>
                                                                  <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'deleted')" class="btn btn-danger btn-sm">Delete</a>
                                                              <?php } else {
                                                                ?>
                                                                  <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'refunded')" class="btn btn-info btn-sm">Refund</a>
                                                                  <a onclick="statusChange('<?php echo $row_paid_time["feepaid_id"]; ?>' ,'deleted')" class="btn btn-danger btn-sm">Delete</a>
                                                              <?php
                                                                } ?>
                                                              <?php if ($row_paid_time["payment_mode"] == "Cheque") { ?>
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
                                            } else {
                                                ?>
                                              <center><b class="text-red">No any Payment Yet!!!</b></center>
                                          <?php
                                            } ?>
                                          <div>
                                              <i class="fas fa-money-bill-alt bg-danger"></i>
                                          </div>
                                          <script>
                                              function statusChange(feepaid_id, statusUpdate) {
                                                  $('#paidfee').css("opacity", "0.4");
                                                  $('#paidfee').css("pointer-events", "none");
                                                  var action = "change_Fee_Status";
                                                  var dataString = 'action=' + action + '&feepaid_id=' + feepaid_id + '&status=' + statusUpdate;
                                                  $.ajax({
                                                      url: 'include/controller.php',
                                                      type: 'POST',
                                                      data: dataString,
                                                      success: function(result) {
                                                          if (result != "error" && result != "empty") {
                                                              console.log(result);
                                                              var fullinfo = result.split(',');
                                                              $('#fee_Status_section' + feepaid_id).html(fullinfo[0]);
                                                              $('#fee_Status_section_full' + feepaid_id).css("background-color", fullinfo[1]);
                                                              $.ajax({
                                                                  url: 'include/view.php?action=fetch_student_fee_details',
                                                                  type: 'POST',
                                                                  data: $('#fetchStudentDataForm').serializeArray(),
                                                                  success: function(result) {
                                                                      //$("#data_table").html(result);
                                                                      $('#response').remove();
                                                                      if (result == 0) {
                                                                          $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please enter Registration Number!!!</div></div>');
                                                                      } else if (result == 1) {
                                                                          $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                                                                      } else {
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

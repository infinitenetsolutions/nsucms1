<?php
//Starting Session
if (empty(session_start()))
    session_start();
//DataBase Connectivity
include "config.php";
// Setting Time Zone in India Standard Timing
$random_number = rand(111111, 999999); // Random Number
$s_no = 1; //Serial Number
$visible = md5("visible");
$trash = md5("trash");
date_default_timezone_set("Asia/Calcutta");
$date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
//All File Directries Start
$university_logos_dir = "../images/university_logos";
$admission_profile_image_dir = "images/student_images";
$certificates = "images/student_certificates";
//All File Directries End
if (isset($_GET["action"])) {
    //Action Section Start
    /* ---------- All Admin(Backend) View Codes Start ---------- */
    // student fee start
    include 'views/s_payfee.php';
    //Student fee End
    //  fee Calculations Details start
    if ($_GET["action"] == "completeCalculationForFees") {
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
        while ($row_paid = $result_paid->fetch_assoc()) {
            $last_balance = $row_paid["balance"];
            $last_fine = intval($row_paid["fine"]);
            $amountsPaid = explode(",", $row_paid["paid_amount"]);
            $totalPerticularArry = explode(",", $row_paid["particular_id"]);
            $totalAmountVal = 0;
            for ($i = 0; $i < count($amountsPaid); $i++) {
                if (!isset($totalAmountArry[$i]) && empty($totalAmountArry[$i]))
                    $totalAmountArry[$i] = 0;
                $totalAmountArry[$i] = $totalAmountArry[$i] + intval($amountsPaid[$i]);
            }
            if ($last_balance == 0)
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
        while ($row_fee = $result_fee->fetch_assoc()) {
            $fee_perticular = 0;
            if (strtolower($hostelCheck) == "yes") {
                $sno++;
                $total_fees = $total_fees + $row_fee["fee_amount"];
                $fine_perticular_amountArray[$Idno] = 0;
                $total_perticular_amountArray[$Idno] = 0;
                if (isset($totalAmountArry[$Idno])) {
                    $total_paid = $total_paid + $totalAmountArry[$Idno];
                    if ($totalAmountArry[$Idno] == $row_fee["fee_amount"]) {
                        $total_fine = $total_fine + 0;
                        $fee_perticular = 0;
                        $fine_perticular_amountArray[$Idno] = $fee_perticular;
                        $total_perticular_amountArray[$Idno] = $fee_perticular;
                    } else {
                        $beforeDate = date($row_fee["fee_lastdate"]);
                        if ($paymentDate > $beforeDate) {
                            if ($row_fee["fee_astatus"] == "Active") {
                                $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate)) / 60 / 60 / 24;
                                $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                $fee_perticular = $fee_perticular + ($numberOfDays * intval($row_fee["fee_fine"]));
                                $fine_perticular_amountArray[$Idno] = $fee_perticular;
                            }
                        }
                        $total_perticular_amountArray[$Idno] = $row_fee["fee_amount"] + ($fee_perticular + $totalAmountArry[$Idno]);
                    }
                } else {
                    $beforeDate = date($row_fee["fee_lastdate"]);
                    if ($paymentDate > $beforeDate) {
                        if ($row_fee["fee_astatus"] == "Active") {
                            $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate)) / 60 / 60 / 24;
                            $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                            $fee_perticular = $fee_perticular + ($numberOfDays * intval($row_fee["fee_fine"]));
                            $fine_perticular_amountArray[$Idno] = $fee_perticular;
                        }
                    }
                    $total_perticular_amountArray[$Idno] = $fee_perticular + $row_fee["fee_amount"];
                }
                $Idno++;
            } else {
                if (strtolower($row_fee["fee_particulars"]) != "hostel fee") {
                    $sno++;
                    $total_fees = $total_fees + $row_fee["fee_amount"];
                    $fine_perticular_amountArray[$Idno] = 0;
                    if (isset($totalAmountArry[$Idno])) {
                        $total_paid = $total_paid + $totalAmountArry[$Idno];
                        if ($totalAmountArry[$Idno] == $row_fee["fee_amount"]) {
                            $total_fine = $total_fine + 0;
                            $fee_perticular = 0;
                            $fine_perticular_amountArray[$Idno] = $fee_perticular;
                            $total_perticular_amountArray[$Idno] = $fee_perticular;
                        } else {
                            $beforeDate = date($row_fee["fee_lastdate"]);
                            if ($paymentDate > $beforeDate) {
                                if ($row_fee["fee_astatus"] == "Active") {
                                    $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate)) / 60 / 60 / 24;
                                    $total_fine = $total_fine + ($numberOfDays * intval($row_fee["fee_fine"]));
                                    $fee_perticular = $numberOfDays * intval($row_fee["fee_fine"]);
                                    $fine_perticular_amountArray[$Idno] = $fee_perticular;
                                    $total_perticular_amountArray[$Idno] = $fee_perticular + $totalAmountArry[$Idno];
                                }
                            }
                            $total_perticular_amountArray[$Idno] = $row_fee["fee_amount"] + ($fee_perticular + $totalAmountArry[$Idno]);
                        }
                    } else {
                        $beforeDate = date($row_fee["fee_lastdate"]);
                        if ($paymentDate > $beforeDate) {
                            if ($row_fee["fee_astatus"] == "Active") {
                                $numberOfDays = (strtotime($paymentDate) - strtotime($beforeDate)) / 60 / 60 / 24;
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
        $total_remaining = $total_fine + ($total_fees - $total_paid);

        if (!empty($_POST["fine_amount"]))
            $fine_amount = $_POST["fine_amount"];
        if (!empty($_POST["rebate_amount"]))
            $rebate_amount = $_POST["rebate_amount"];
        for ($i = 0; $i < count($_POST["particular_paid_amount"]); $i++) {
            if (!empty($_POST["particular_paid_amount"][$i]))
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
        if ($total_amount < 0 || $remaining_amount < 0 || $fine_perticular_amount < 0)
            $errorMessage .= " Connot Use Negative Values.";
        if ($total_amount > $total_remaining)
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

    // add exam form list
    if ($_GET["action"] == "fetch_exam_form") {
        $course_id = $_POST["course_id"];
        $academic_year = $_POST["academic_year"];
        $semester_id = $_POST["semester_id"];
        $amount = $_POST["amount"];
        $subject_id = $_POST["subject_id"];

        $_SESSION["course_id"] = $course_id;
        $_SESSION["academic_year"] = $academic_year;
        $_SESSION["semester_id"] = $semester_id;
        $_SESSION["amount"] = $amount;

        $sql = "SELECT * FROM `tbl_admission` WHERE `status` = '$visible' && `admission_username` = '" . $_SESSION["logger_username1"] . "'";
        $result = $con->query($sql);
        $row = $result->fetch_assoc();
        $admission_id = $row['admission_id'];

        $sql1 = "SELECT * FROM `tbl_admission_details` WHERE `status` = '$visible' && `admission_id` = '$admission_id' && `course_id` = '" . $_SESSION["course_id"] . "'";
        $adresult = $con->query($sql1);
        $adrow = $adresult->fetch_assoc();


        $sql2 = "SELECT * FROM `tbl_examination_form` WHERE `status` = '$visible' && `course_id` = '" . $_SESSION["course_id"] . "'";
        $depresult = $con->query($sql);
        $deprow = $result->fetch_assoc();


        //echo "<pre>";
        //print_r($adrow); exit;
        //echo $adrow['roll_no']; 
        //echo $row['admission_id']; 
?>
        <form action="exam_confirm" method="post" enctype="multipart/form-data">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">PERSONAL DETAILS</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">

                                <label>Registration Number</label>
                                <input id="" type="hidden" name="course_id" value="<?php echo $_SESSION['course_id'] ?>" class="form-control">
                                <input id="" type="hidden" name="academic_year" value="<?php echo $_SESSION['academic_year'] ?>" class="form-control">
                                <input id="" type="hidden" name="semester_id" value="<?php echo $_SESSION['semester_id'] ?>" class="form-control">
                                <input id="" type="hidden" name="amount" value="<?php echo $_SESSION['amount'] ?>" class="form-control">
                                <input id="" type="text" name="registration_no" class="form-control" required value="<?php echo $adrow['reg_no'] ?>">
                            </div>

                            <div class="col-4">
                                <label>Roll Number</label>
                                <input id="" type="text" name="roll_no" class="form-control" value="<?php echo $adrow['roll_no'] ?>">
                            </div>

                            <div class="col-4">
                                <label>Candidate's Name</label>
                                <input id="" type="hidden" name="candidate_name" class="form-control" value="<?php echo $row['admission_first_name'] . " " . $row['admission_middle_name'] . " " . $row['admission_last_name'] ?>">
                                <input id="" type="text" name="candidate_name" class="form-control" value="<?php echo $row['admission_first_name'] . " " . $row['admission_middle_name'] . " " . $row['admission_last_name'] ?>" readonly>
                            </div>

                            <div class="col-4">
                                <label>Father's Name</label>
                                <input id="" type="hidden" name="father_name" class="form-control" value="<?php echo $row['admission_father_name'] ?>">
                                <input id="" type="text" name="father_name" class="form-control" value="<?php echo $row['admission_father_name'] ?>" readonly>
                            </div>

                            <div class="col-4">
                                <label>Department / Specialisation</label>
                                <input id="" type="text" name="department" class="form-control" required value="<?php echo $deprow['department'] ?>">
                            </div>

                            <div class="col-4">
                                <label>Candidate Signature</label>
                                <input type="file" id="fileSign" onchange="Filevalidation()" name="candidate_signature" class="form-control" required>
                                <script>
                                    Filevalidation = () => {
                                        var fi = document.getElementById('fileSign');
                                        // Check if any file is selected. 
                                        if (fi.files.length > 0) {
                                            for (i = 0; i <= fi.files.length - 1; i++) {

                                                var fsize = fi.files.item(i).size;
                                                var file = Math.round((fsize / 1024));
                                                // The size of the file. 
                                                if (file >= 4096) {
                                                    alert(
                                                        "File too Big, please select a file less than 4mb");
                                                    $("#fileSign").val("");
                                                } else {
                                                    document.getElementById('size').innerHTML = '<b>' +
                                                        file + '</b> KB';
                                                }
                                            }
                                        }
                                    }
                                </script>
                            </div>

                            <div class="col-8">
                                <label>Passport Size Photograph</label><br>
                                <input type="hidden" name="passport_photo" class="form-control" value="<?php echo $row["admission_profile_image"]; ?>">
                                <img class="profile-user-img " src="../images/student_images/<?php echo $row["admission_profile_image"]; ?>" alt="Student profile picture">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">PERSONAL DETAILS</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <label>Gender</label>
                                <input id="" type="hidden" name="gender" class="form-control" value="<?php echo strtoupper($row['admission_gender']) ?>">
                                <input id="" type="text" name="gender" class="form-control" value="<?php echo strtoupper($row['admission_gender']) ?>" readonly>
                            </div>
                            <div class="col-4">
                                <label>Date Of Birth</label>
                                <input id="" type="hidden" name="dob" class="form-control" value="<?php echo date("d/m/Y", strtotime($row['admission_dob'])) ?>">
                                <input id="" type="text" name="dob" class="form-control" value="<?php echo date("d/m/Y", strtotime($row['admission_dob'])) ?>">
                            </div>
                            <div class="col-4">
                                <label>Email Id (Student)</label>
                                <input id="" type="hidden" name="email_id" class="form-control" value="<?php echo $row['admission_emailid_student'] ?>">
                                <input id="" type="text" name="email_id" class="form-control" value="<?php echo $row['admission_emailid_student'] ?>">
                            </div>
                            <div class="col-4">
                                <label>Mobile No.(01)</label>
                                <input id="" type="hidden" name="mobile_no1" class="form-control" value="<?php echo $row['admission_mobile_student'] ?>">
                                <input id="" type="text" name="mobile_no1" class="form-control" value="<?php echo $row['admission_mobile_student'] ?>">
                            </div>
                            <div class="col-4">
                                <label>Mobile No.(02)</label>
                                <input id="" type="text" name="mobile_no2" class="form-control">
                            </div>
                            <div class="col-4">
                                <label>Adhar No</label>
                                <input id="" type="hidden" name="adhar_no" class="form-control" value="<?php echo $row['admission_aadhar_no'] ?>">
                                <input id="" type="text" name="adhar_no" class="form-control" value="<?php echo $row['admission_aadhar_no'] ?>">
                            </div>
                            <div class="col-12">
                                <label>Correspondence Address (for all communication by the University):</label>
                                <input id="" type="hidden" name="address" class="form-control" value="<?php echo $row['admission_residential_address'] ?>">
                                <textarea id="address" name="address" class="form-control" value="<?php echo $row['admission_residential_address'] ?>" style="height: 38px;"><?php echo $row['admission_residential_address'] ?></textarea>
                            </div>
                            <div class="col-4">
                                <label>Last Examination Passed & Year</label>
                                <input id="" type="text" name="last_exam_year" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table id="example1" class="table table-bordered table-striped" style="overflow-x:auto;">
                <thead>
                    <tr>
                        <th width="10%">S.No</th>
                        <th width="20%">Paper Code</th>
                        <th width="20%">Paper Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //$subject_id = $_POST["subject_id"];                        
                    $sql = "SELECT * FROM `tbl_subjects`  WHERE `status` = '$visible' && course_id = '$course_id' && semester_id = '$semester_id' ORDER BY `subject_id` ASC ";
                    // echo $sql;exit();
                    $row = $con->query($sql);
                    while ($row_course = $row->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $s_no; ?></td>
                            <td> <input type="text" name="paper_code" class="form-control" value="<?php echo $row_course["subject_code"] ?>" readonly></td>
                            <td> <input type="text" name="paper_name" class="form-control" value="<?php echo $row_course["subject_name"] ?>" readonly></td>
                        </tr>
                    <?php
                        $s_no++;
                    }
                    ?>
                </tbody>
            </table>

            <p>Declaration By the Student :</p>
            <p style="text-align:justify;">I hereby declare that I have read and understood the instructions given above. I also affirm that I have submitted all the required numbers of assignment as applicable for the aforesaid course filled in the examination form and my registration for the course is valid and not time barred. If any of my statements is found to be untrue, I will have no claim for appearing in the examination. I undertake that I shall abide by the rules and regulations of the University.</p>

            <tr>
                <td height="40" colspan="8" valign="middle" align="center" class="narmal">
                    <input type="submit" name="submit" value="Next" class="btn btn-primary">
                </td>
            </tr>
        </form>

    <?php

    }
    //add exam form Student list end
    //test add exam form list
    if ($_GET["action"] == "test_fetch_exam_form") {
        $course_id = $_POST["course_id"];
        $academic_year = $_POST["academic_year"];
        $semester_id = $_POST["semester_id"];
        $amount = $_POST["amount"];
        $subject_id = $_POST["subject_id"];

        $_SESSION["course_id"] = $course_id;
        $_SESSION["academic_year"] = $academic_year;
        $_SESSION["semester_id"] = $semester_id;
        $_SESSION["amount"] = $amount;

        $sql = "SELECT * FROM `tbl_admission` WHERE `status` = '$visible' && `admission_username` = '" . $_SESSION["logger_username1"] . "'";
        $result = $con->query($sql);
        $row = $result->fetch_assoc();
    ?>
        <form action="exam_submit" method="post" enctype="multipart/form-data">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">PERSONAL DETAILS</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">

                                <label>Registration Number</label>
                                <input id="" type="hidden" name="course_id" value="<?php echo $_SESSION['course_id'] ?>" class="form-control">
                                <input id="" type="hidden" name="academic_year" value="<?php echo $_SESSION['academic_year'] ?>" class="form-control">
                                <input id="" type="hidden" name="semester_id" value="<?php echo $_SESSION['semester_id'] ?>" class="form-control">
                                <input id="" type="hidden" name="amount" value="<?php echo $_SESSION['amount'] ?>" class="form-control">
                                <input id="" type="text" name="registration_no" class="form-control" required>
                            </div>

                            <div class="col-4">
                                <label>Roll Number</label>
                                <input id="" type="text" name="roll_no" class="form-control" required>
                            </div>

                            <div class="col-4">
                                <label>Candidate's Name</label>
                                <input id="" type="hidden" name="candidate_name" class="form-control" value="<?php echo $row['admission_first_name'] . " " . $row['admission_middle_name'] . " " . $row['admission_last_name'] ?>">
                                <input id="" type="text" name="candidate_name" class="form-control" value="<?php echo $row['admission_first_name'] . " " . $row['admission_middle_name'] . " " . $row['admission_last_name'] ?>" readonly>
                            </div>

                            <div class="col-4">
                                <label>Father's Name</label>
                                <input id="" type="hidden" name="father_name" class="form-control" value="<?php echo $row['admission_father_name'] ?>">
                                <input id="" type="text" name="father_name" class="form-control" value="<?php echo $row['admission_father_name'] ?>" readonly>
                            </div>

                            <div class="col-4">
                                <label>Department / Specialisation</label>
                                <input id="" type="text" name="department" class="form-control" required>
                            </div>

                            <div class="col-4">
                                <label>Candidate Signature</label>
                                <input type="file" id="fileSign" onchange="Filevalidation()" name="candidate_signature" class="form-control" required>
                                <script>
                                    Filevalidation = () => {
                                        var fi = document.getElementById('fileSign');
                                        // Check if any file is selected. 
                                        if (fi.files.length > 0) {
                                            for (i = 0; i <= fi.files.length - 1; i++) {

                                                var fsize = fi.files.item(i).size;
                                                var file = Math.round((fsize / 1024));
                                                // The size of the file. 
                                                if (file >= 4096) {
                                                    alert(
                                                        "File too Big, please select a file less than 4mb");
                                                    $("#fileSign").val("");
                                                } else {
                                                    document.getElementById('size').innerHTML = '<b>' +
                                                        file + '</b> KB';
                                                }
                                            }
                                        }
                                    }
                                </script>
                            </div>

                            <div class="col-8">
                                <label>Passport Size Photograph</label><br>
                                <input type="hidden" name="passport_photo" class="form-control" value="<?php echo $row["admission_profile_image"]; ?>">
                                <img class="profile-user-img " src="../images/student_images/<?php echo $row["admission_profile_image"]; ?>" alt="Student profile picture">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">PERSONAL DETAILS</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <label>Gender</label>
                                <input id="" type="hidden" name="gender" class="form-control" value="<?php echo strtoupper($row['admission_gender']) ?>">
                                <input id="" type="text" name="gender" class="form-control" value="<?php echo strtoupper($row['admission_gender']) ?>" readonly>
                            </div>
                            <div class="col-4">
                                <label>Date Of Birth</label>
                                <input id="" type="hidden" name="dob" class="form-control" value="<?php echo date("d/m/Y", strtotime($row['admission_dob'])) ?>">
                                <input id="" type="text" name="dob" class="form-control" value="<?php echo date("d/m/Y", strtotime($row['admission_dob'])) ?>">
                            </div>
                            <div class="col-4">
                                <label>Email Id (Student)</label>
                                <input id="" type="hidden" name="email_id" class="form-control" value="<?php echo $row['admission_emailid_student'] ?>">
                                <input id="" type="text" name="email_id" class="form-control" value="<?php echo $row['admission_emailid_student'] ?>">
                            </div>
                            <div class="col-4">
                                <label>Mobile No.(01)</label>
                                <input id="" type="hidden" name="mobile_no1" class="form-control" value="<?php echo $row['admission_mobile_student'] ?>">
                                <input id="" type="text" name="mobile_no1" class="form-control" value="<?php echo $row['admission_mobile_student'] ?>">
                            </div>
                            <div class="col-4">
                                <label>Mobile No.(02)</label>
                                <input id="" type="text" name="mobile_no2" class="form-control">
                            </div>
                            <div class="col-4">
                                <label>Adhar No</label>
                                <input id="" type="hidden" name="adhar_no" class="form-control" value="<?php echo $row['admission_aadhar_no'] ?>">
                                <input id="" type="text" name="adhar_no" class="form-control" value="<?php echo $row['admission_aadhar_no'] ?>">
                            </div>
                            <div class="col-12">
                                <label>Correspondence Address (for all communication by the University):</label>
                                <input id="" type="hidden" name="address" class="form-control" value="<?php echo $row['admission_residential_address'] ?>">
                                <textarea id="address" name="address" class="form-control" value="<?php echo $row['admission_residential_address'] ?>" style="height: 38px;"><?php echo $row['admission_residential_address'] ?></textarea>
                            </div>
                            <div class="col-4">
                                <label>Last Examination Passed & Year</label>
                                <input id="" type="text" name="last_exam_year" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table id="example1" class="table table-bordered table-striped" style="overflow-x:auto;">
                <thead>
                    <tr>
                        <th width="10%">S.No</th>
                        <th width="20%">Paper Code</th>
                        <th width="20%">Paper Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //$subject_id = $_POST["subject_id"];                        
                    $sql = "SELECT * FROM `tbl_subjects` WHERE course_id = '$course_id' && semester_id = '$semester_id' ORDER BY `subject_id` ASC ";
                    // echo $sql;exit();
                    $row = $con->query($sql);
                    while ($row_course = $row->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $s_no; ?></td>
                            <td> <input type="text" name="paper_code" class="form-control" value="<?php echo $row_course["subject_code"] ?>" readonly></td>
                            <td> <input type="text" name="paper_name" class="form-control" value="<?php echo $row_course["subject_name"] ?>" readonly></td>
                        </tr>
                    <?php
                        $s_no++;
                    }
                    ?>
                </tbody>
            </table>

            <p>Declaration By the Student :</p>
            <p style="text-align:justify;">I hereby declare that I have read and understood the instructions given above. I also affirm that I have submitted all the required numbers of assignment as applicable for the aforesaid course filled in the examination form and my registration for the course is valid and not time barred. If any of my statements is found to be untrue, I will have no claim for appearing in the examination. I undertake that I shall abide by the rules and regulations of the University.</p>

            <tr>
                <td height="40" colspan="8" valign="middle" align="center" class="narmal">
                    <input type="submit" name="submit" value="Next" class="btn btn-primary">
                </td>
            </tr>
        </form>

<?php

    }
    //test add exam form Student list end
    /* ---------- All Admin(Backend) View Codes End ---------- */
    //Action Section End   
}
?>
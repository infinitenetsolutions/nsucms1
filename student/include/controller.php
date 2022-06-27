<?php
    //Starting Session
    error_reporting(0);
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "config.php";
    // Setting Time Zone in India Standard Timing
    $random_number = rand(111111,999999); // Random Number
    $visible = md5("visible");
    $trash = md5("trash");
	date_default_timezone_set("Asia/Calcutta");
    $date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
    //All File Directries Start
    $university_logos_dir = "../images/university_logos";
    $admission_profile_image_dir = "../images/student_images";
	$certificates = "../images/student_certificates";
    //All File Directries End
    if(isset($_POST["action"])){
    //Action Section Start
        /* ---------- All Admin(Backend) Codes Start ---------- */
		        //Login Section Start With Ajax
        if($_POST["action"] == "student_login"){
            $student_login_username = $_POST["student_login_username"];
            $student_login_password = $_POST["student_login_password"];
            if(!empty($student_login_username && $student_login_password)){
                $sql = "SELECT * FROM `tbl_admission`
                        WHERE `admission_username` = '$student_login_username' && `admission_password` = '$student_login_password'
                        ";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                    //$_SESSION["logger_type1"] = "student";
                    $_SESSION["logger_username1"] = $student_login_username;
                    $_SESSION["logger_password1"] = $student_login_password;
                    $_SESSION["logger_time1"] = time();
                    echo '
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check"></i> You have logged in Successfully!!!
                        </div>';
                    echo "<script> location.replace('dashboard') </script>";
                }
                else
                    echo '
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-ban"></i> Incorrect Credential, Please try again!!!
                        </div>';
            } else{
                echo '
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-exclamation-triangle"></i>  Please fill out Username and Password!!!
                    </div>';
            }
        }
        //Login Section End With Ajax
		 //Pay Fee Start
        if($_POST["action"] == "pay_fees"){
          
            $registrationNumber = $_POST["registrationNumber"];
            $academicYear = $_POST["academicYear"];
            $courseId = $_POST["courseId"];
            $particular_paid_id = $_POST["particular_paid_id"];
            $particular_paid_amount = $_POST["particular_paid_amount"];
            $fine_amount = $_POST["fine_amount"];
            $rebate_amount = $_POST["rebate_amount"];
            $total_amount = $_POST["total_amount"];
            $remaining_amount = $_POST["remaining_amount"];
            $PaymentMode = $_POST["PaymentMode"];
            $cashDepositTo = $_POST["cashDepositTo"];
            $bankName = $_POST["bankName"];
            $chequeAndOthersNumber = $_POST["chequeAndOthersNumber"];
            $paidDate = $_POST["paidDate"];
            $paymentDate = $_POST["paymentDate"];
            $NotesByAdmin = $_POST["NotesByAdmin"];
            $FeeStatus = "cleared";
            if(!empty( $registrationNumber && $academicYear && $courseId ) && ( count($particular_paid_id) != 0 ) && ( count($particular_paid_amount) != 0 ) && !empty( $total_amount )){ 
                if(($PaymentMode != "0" && $cashDepositTo != "0") || ($PaymentMode != "0" && !empty($chequeAndOthersNumber))){
                    if($fine_amount >= 0 && $rebate_amount >= 0 && $total_amount >= 0 && $remaining_amount >= 0){
						
						$_SESSION["registrationNumber"]=$registrationNumber;
						$_SESSION["academicYear"]=$academicYear;
						$_SESSION["courseId"]=$courseId;
						$_SESSION["particular_paid_id"]=$particular_paid_id;
						$_SESSION["particular_paid_amount"]=$particular_paid_amount;
						$_SESSION["fine_amount"]=$fine_amount;
						$_SESSION["rebate_amount"]=$rebate_amount;
						$_SESSION["total_amount"]=$total_amount;
						$_SESSION["remaining_amount"]=$remaining_amount;
						$_SESSION["PaymentMode"]=$PaymentMode;
						$_SESSION["cashDepositTo"]=$cashDepositTo;
						$_SESSION["paidDate"]=$paidDate;
						$_SESSION["paymentDate"]=$paymentDate;														
								
						
                       /* if($PaymentMode == "Cheque")
                            $FeeStatus = "pending";
                        $sql = "INSERT INTO `tbl_fee_paid`
                                (`feepaid_id`, `student_id`, `course_id`, `particular_id`, `paid_amount`, `rebate_amount`, `fine`, `balance`, `payment_mode`, `cash_deposit_to`, `cash_date`, `notes`, `receipt_date`, `bank_name`, `transaction_no`, `transaction_date`, `receipt_no`, `paid_on`, `university_details_id`, `fee_paid_time`, `payment_status`, `status`) 
                                VALUES 
                                ('', '$registrationNumber', '$courseId', '$implodedId', '$implodedAmount', '$rebate_amount', '$fine_amount', '$remaining_amount', '$PaymentMode', '$cashDepositTo', '$paymentDate', '$NotesByAdmin', '$paidDate', '$bankName', '$chequeAndOthersNumber', '$paymentDate', 'NSU_$receipt_no_gen', '$paymentDate', '$academicYear', '$date_variable_today_month_year_with_timing', '$FeeStatus', '$visible')
                                ";
                                
                        //insert into tbl_income
                        $sql_course = "SELECT * FROM `tbl_course`
						WHERE `status` = '$visible' &&  `course_id` = '".$getRows["admission_course_name"]."'
						";
            			$result_course = $con->query($sql_course);
            			$row_course = $result_course->fetch_assoc();
            			
            			$perticulars = explode(",",$implodedId);
                        $amounts = explode(",",$implodedAmount);
            			for($i=0; $i<count($perticulars); $i++){
            			$sql_fee = "SELECT * FROM `tbl_fee`
            						WHERE `status` = '$visible' && `fee_id` = '".$perticulars[$i]."'
            						";
            			$result_fee = $con->query($sql_fee);
            			$row_fee = $result_fee->fetch_assoc();
            															
            			$sql_inc = "INSERT INTO `tbl_income`
            				(`id`,`reg_no`,	`course`, `received_date`, `particulars`, `amount`, `payment_mode`,`post_at`) 
            				VALUES
            				('','$registrationNumber','".$row_course["course_name"]."','$paymentDate','".$row_fee["fee_particulars"]."','$amounts[$i]','$PaymentMode','$date_variable_today_month_year_with_timing')
            				";
            			$query=mysqli_query($con,$sql_inc); }
            			
			
                        if($con->query($sql))*/
                            echo "success";
                       /* else
                            echo '<div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again!!!
                                  </div>';*/
                    } else
                        echo '<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="icon fas fa-ban"></i> Cannot calculate Fees with <b>Negative</b> values!!!
                              </div>';
                } else
                    echo '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-exclamation-triangle"></i> Please Fill out Payment Details!!!
                          </div>';
            } else
                echo '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-ban"></i> Please Fill Out Fee Amounts!!!
                      </div>';
        }
        //Pay Fee End
        //Add complaint Form Start
        if($_POST["action"] == "add_complaint"){
            $admission_id=$_POST['admission_id'];
            $subject=$_POST['subject'];
			$message=$_POST['message'];
 
				  $sql = "INSERT INTO `tbl_complaint`
                            (`complaint_id`, `admission_id`,`subject`, `message`,`create_time` ,`status`) 
                            VALUES 
                            ('$complaint_id','$admission_id','$subject','$message','$date_variable_today_month_year_with_timing','$visible')
                            ";							
				  if($con->query($sql)){
                        echo "<script>
                                alert('Added successfully!!!');
                                location.replace('../complaint');
                            </script>";
                    }
                    else
                        echo "<script>
                                alert('Something went wrong please try again!!!');
                                location.replace('../complaint');
                            </script>";
					/*} else{
						echo "<script>
									alert('Please fill out all required fields!!!');
									location.replace('../admission_form');
								</script>";
					}*/
        }
    //Add complaint Form End
        /* ---------- All Admin(Backend) Codes End ---------- */
    //Action Section End   
    }
?>
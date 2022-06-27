<?php
// include file
session_start();
include_once('easebuzz-lib/easebuzz_payment_gateway.php');
include_once('include/config.php');
date_default_timezone_set("Asia/Calcutta");
$date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
$visible = md5("visible");
// salt for testing env
  // $SALT = "M87TPWFJ44";
  // $SALT = "DAH88E3UWQ"; //test

 	//live
	 $SALT = "LNRNU85EPI";
?>
<?php 

// Decode Jeson
ini_set("error_reporting","off");
//include_once('easebuzz-lib/easebuzz_payment_gateway.php');
/*
Enter The SALT 
*/
//$SALT = "M87TPWFJ44";
$easebuzzObj = new Easebuzz($MERCHANT_KEY = null, $SALT, $ENV = null);
//	print_r($_POST);
	//echo "<br>";
//	echo $_POST['bank_ref_num'];
$result = $easebuzzObj->easebuzzResponse( $_POST );
/*
$result jeson Data
*/
//print_r($result);
 $result = json_decode($result, true);
  
  //echo "<h1>EaseBuzz</h1>"; 
$chk_tx=$result["data"]["status"];
 
//echo $chk;

 //if($chk_tx=="success")
   //{
     
    $course_id = $_SESSION["course_id"];
    $academic_year = $_SESSION["academic_year"];		                                           				
	$semester_id = $_SESSION['semester_id'];		                                           				
	$amount = $_SESSION['amount'];		                                           				
	$registration_no = $_SESSION["registration_no"];		                                           				
	$roll_no = $_SESSION['roll_no'];		                                           				
	$candidate_name = $_SESSION['candidate_name'];		                                           				
	$father_name = $_SESSION['father_name'];		                                           				
	$department = $_SESSION['department'];		                                           				
	$gender = $_SESSION['gender'];		                                           				
	$dob = $_SESSION['dob'];		                                           				
	$email_id = $_SESSION['email_id'];		                                           				
	$mobile_no1 = $_SESSION['mobile_no1'];		                                           				
	$mobile_no2 = $_SESSION['mobile_no2'];		                                           				
	$adhar_no = $_SESSION['adhar_no'];		                                           				
	$address = $_SESSION['address'];		                                           				
	$last_exam_year = $_SESSION['last_exam_year'];		                                           				
	$paper_code = $_SESSION['paper_code'];		                                           				
	$paper_name = $_SESSION['paper_name'];		                                           					
	
	$candidate_signature_rand = $_SESSION['candidate_signature'];
	$passport_photo_rand = $_SESSION['passport_photo'];
      
	$sql = "INSERT INTO `tbl_examination_form`
			(`exam_id`, `course_id`,`academic_year`, `semester_id`, `registration_no`, `roll_no`, `candidate_name`, `father_name`, `department`, `candidate_signature`, `passport_photo`, `gender`, `dob`, `email_id`, `mobile_no1`, `mobile_no2`,`adhar_no`, `address`, `last_exam_year`, `paper_code`, `paper_name`,`amount`, `transactionid`, `easebuzzid`,`create_time`, `status`)
			VALUES 
			('', '$course_id','$academic_year', '$semester_id', '$registration_no', '$roll_no', '$candidate_name', '$father_name', '$department', '$candidate_signature_rand', '$passport_photo_rand', '$gender', '$dob', '$email_id', '$mobile_no1','$mobile_no2','$adhar_no','".str_replace("\r\n","",$address)."','$last_exam_year','$paper_code','$paper_name','$amount', '".$result["data"]["txnid"]."', '".$result["data"]["easepayid"]."',  '$date_variable_today_month_year_with_timing', '$visible')
			";

            //call initiatePaymentAPI method and send data
                 //$easebuzzObj->initiatePaymentAPI($_POST);
               $result = $easebuzzObj->transactionAPI($_POST);
             // Note:- initiate payment API response will get for success URL or failure URL  using HTTP form post
      }
                if(empty($course_id && $registration_no && $academic_year && $semester_id && $roll_no && $candidate_name && $father_name && $department && $candidate_signature_rand && $passport_photo_rand && $gender && $dob && $email_id)){
                     $sql = "UPDATE `tbl_examination_form` 
                            SET 
                            `course_id` = '$course_id', `academic_year` = '$academic_year',`semester_id` = '$semester_id',`registration_no` = '$registration_no', 
                            `roll_no` = '$roll_no',`candidate_name` = '$candidate_name',`father_name` = '$father_name',`department` = '$department',`candidate_signature` = '$candidate_signature_rand',`passport_photo` = '$passport_photo_rand',`gender` = '$gender',`dob` = '$dob',`email_id` = '$email_id',`mobile_no1` = '$mobile_no1',`mobile_no2` = '$mobile_no2',`adhar_no` = '$adhar_no',`address` = '".str_replace("\r\n","",$address)."',`last_exam_year` = '$last_exam_year',`paper_code` = '$paper_code',
                            `paper_name` = '$paper_name',`amount` = '$amount'
                              WHERE `status` = '$visible' && `transactionid` = '".$result["data"]["txnid"]."' && `easebuzzid` = '".$result["data"]["easepayid"]."';
                            ";
             }
			
			 function sendsmsGET($mobileNumber,$senderId,$routeId,$message,$serverUrl,$authKey)
		{
		$senderId='NSUJSR';
		$routeId1=1;
		$getData = 'mobileNos='.$mobileNumber.'&message='.urlencode($message).'&senderId='.$senderId.'&routeId='.$routeId1;
		//API URL
		$serverUrl1='msg.msgclub.net';
		$authKey1='6a4743a8355fb97aa42dc2452185a1cd';
		$url="http://".$serverUrl1."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$authKey1."&".$getData;
		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_SSL_VERIFYPEER => 0
		));
		$output = curl_exec($ch);
		if(curl_errno($ch))
		{
		echo 'error:' . curl_error($ch);
		}
		curl_close($ch);
		return $output;
		}
		
	$student_msg = "Dear $candidate_name, Thank you for the payment, towards your Examination Form. Regards NSU";
	sendsmsGET($mobile_no1,'','',$student_msg);	
     if($con->query($sql))

       	 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS UNIVERSITY | Student Fee Details </title>
    <!-- Fav Icon -->
    <link rel="icon" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include 'include/navbar.php'; ?>
        <?php include 'include/aside.php'; ?>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
	
	    <div class="page-wrapper" id="div1">
          <section class="inner-banner" style="background: url('assets/images/header-bg.png'); background-position:top; background-size:cover;">
                
            </section>
            <!-- end inner-banner -->
            <section class="course">
                <div class="container" >
                   <div class="sec-title text-center mb-3 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Payment Details</h2>
                        <div class="divider"> <span class="fa fa-mortar-board"></span> </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-12">
                             
                            <div class="career-form p-5 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000" >
                                <div class="border-line"></div>
                               
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="">Registration No</label>
                                            <input  name="" class="form-control"  value="<?php echo $_SESSION['registration_no'] ?>" type="text" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Email Address</label>
                                            <input id="placement_contact_email" value="<?php echo $_SESSION['email_id'] ?>" class="form-control"  placeholder="Enter Email" type="email" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="">Phone Number</label>
                                            <input id="placement_contact_phone" value="<?php echo $_SESSION['mobile_no1'] ?>" class="form-control"  placeholder="Enter Number" type="text" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Purpose</label>
                                            <input value="Exam Fee" class="form-control"  placeholder="" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="">Amount</label>
                                            <input id="placement_contact_phone" value="<?php echo $result["data"]["amount"]; ?>" class="form-control"  placeholder="Enter Number" type="text" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Transaction ID</label>
                                            <input value="<?php echo $result["data"]["txnid"]; ?>" class="form-control"  placeholder="Enter Designation" type="text" readonly>
                                        </div> 
                                    </div>
                                    <div class="form-row">
                                       
                                   

                                   <div class="form-group col-md-6">
                                        <label for="">Easebuzz ID</label>
                                       <input type="text" value="<?php echo $result["data"]["easepayid"]; ?>" class="form-control"  placeholder="Request For Information" readonly>
                                    </div>
                                     </div>
                                <button onclick="printContent('div1')" style="float:right;">Print</button> 
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
		
    <script type="text/javascript">
	function printContent(e1)
	{
		var restorepage=document.body.innerHTML;
		var printContent=document.getElementById(e1).innerHTML;
		document.body.innerHTML=printContent;
		window.print();
		document.body.innerHTML=restorepage;
	}
</script>
								
<?php
 //}
 //elseif ($chk_tx=="userCancelled") {
	# code...
	//echo "<hr>";
	 //echo "<br> Transaction Details:-";
	 //echo "<br> Status    :".$result["data"]["status"];
	 //echo "<br> Name      :".$result["data"]["firstname"];
	 //echo "<br> Name On Card     :".$result["data"]["name_on_card"];
	 //echo "<br> Email     :".$result["data"]["email"];
	 //echo "<br> Amount    :".$result["data"]["amount"];
	 //echo "<br> Transaction Id    :".$result["data"]["txnid"];
	 //echo "<br> EaseBuzz Pay Id    :".$result["data"]["easepayid"];	 
 //}
 //else
 //{ 
	 /*
	 // Failure  Code..
	  As Per Your Need
	 */	
	//echo "<hr>";
	//echo "<br> Transaction Details ";
	//echo '<p><font color="red">';
	//echo "<br> <b>Error    :".$result["data"]["error_Message"]."</b>"; 
	//echo "</font></p>";
		
 //}
 ?>
  <?php	include_once('include/footer.php'); ?>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
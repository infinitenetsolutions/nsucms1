<?php
// include file
session_start();
include_once('easebuzz-lib/easebuzz_payment_gateway.php');
include_once('include/config.php');
$visible = md5("visible");
date_default_timezone_set("Asia/Calcutta");
$date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
// salt for testing env
//   $SALT = "M87TPWFJ44";

// 	//live
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

 if($chk_tx=="success")
 {
   
   
    $registrationNumber = $result["data"]["udf1"];
    $academicYear = $result["data"]["udf2"];
    $courseId = $result["data"]["udf3"];
    $fine_amount = $result["data"]["udf4"];
    $remaining_amount = $result["data"]["udf5"];
    $rebate_amount = $result["data"]["udf6"];
    $txn_id = $result["data"]["txnid"];


    $PaymentMode = "Online";
    $cashDepositTo = "University Office";
    $paidDate = date('Y-m-d');
    $paymentDate = date('Y-m-d');

    $pyament_check = "SELECT * FROM `tbl_payment_check` WHERE student_id='$registrationNumber' && txno='$txn_id' && date='$paidDate'  ORDER BY  id DESC;";
    $result_payment = mysqli_query($con, $pyament_check);
    $data_payment_check = mysqli_fetch_array($result_payment);

    $particular_paid_amount = json_decode($data_payment_check['particular_paid_amount']);
    $particular_paid_id = json_decode($data_payment_check['particular_paid_id']);


	//$registrationNumber = $_SESSION["registrationNumber"];
	//$academicYear = $_SESSION["academicYear"];
	//$courseId = $_SESSION["courseId"];
	//$particular_paid_id = $_SESSION["particular_paid_id"];
	//$particular_paid_amount = $_SESSION["particular_paid_amount"];
	//$fine_amount = $_SESSION["fine_amount"];
	//$rebate_amount = $_SESSION["rebate_amount"];
	//$amount = $_SESSION["amount"];
	//$remaining_amount = $_SESSION["remaining_amount"];
	//$PaymentMode = $_SESSION["PaymentMode"];
	//$cashDepositTo = $_SESSION["cashDepositTo"];
	//$paidDate = $_SESSION["paidDate"];
	//$paymentDate = $_SESSION["paymentDate"];
   
    // getting the student details form admission tables

    $admission = "SELECT * FROM `tbl_admission` WHERE `admission_id` ";
	
	$getRe = "SELECT `feepaid_id` FROM `tbl_fee_paid`
                                  WHERE `status` = '$visible'
                                 ";  
                        $receipt_no_gen = 0;
                        $getReResult =  $con->query($getRe);
                        while($getReRow = $getReResult->fetch_assoc())
                            $receipt_no_gen = $getReRow["feepaid_id"];
                        $receipt_no_gen++;
                        $implodedId = implode(",", $particular_paid_id);
                        $implodedAmount = implode(",", $particular_paid_amount);
											
                        $sql = "INSERT INTO `tbl_fee_paid`
                                (`feepaid_id`, `student_id`, `course_id`, `particular_id`, `paid_amount`, `rebate_amount`, `fine`, `balance`, `payment_mode`, `cash_deposit_to`, `cash_date`, `notes`, `receipt_date`, `bank_name`, `transaction_no`, `transaction_date`, `receipt_no`, `paid_on`, `university_details_id`, `fee_paid_time`, `payment_status`, `status`) 
                                VALUES 
                                ('', '$registrationNumber', '$courseId', '$implodedId', '$implodedAmount', '$rebate_amount', '$fine_amount', '$remaining_amount', '$PaymentMode', '$cashDepositTo', '$paymentDate', '$NotesByAdmin', '$paidDate', '$bankName', '".$result["data"]["txnid"]."', '$paymentDate', 'NSU_$receipt_no_gen', '$paymentDate', '$academicYear', '$date_variable_today_month_year_with_timing', 'cleared', '$visible')
                                ";
   
                             // call initiatePaymentAPI method and send data
                       // $easebuzzObj->initiatePaymentAPI($_POST);
                       // $result = $easebuzzObj->transactionAPI($_POST);
                        // Note:- initiate payment API response will get for success URL or failure URL  using HTTP form post
                                
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
            				(`id`,`reg_no`,	`course`,`academic_year`, `received_date`, `particulars`, `amount`, `payment_mode`,`check_no`,`bank_name`,`income_from`,`post_at`) 
            				VALUES
            				('','$registrationNumber(Reg No)','$courseId','$academicYear','$paymentDate','".$row_fee["fee_particulars"]."','$amounts[$i]','$PaymentMode','".$result["data"]["easepayid"]."','','Fee','".date("Y-m-d")."')
            				";
            			$query=mysqli_query($con,$sql_inc); }
            			
			
                        if($con->query($sql))
	                    // echo "success";
                          
                     $result = $easebuzzObj->transactionAPI($_POST);

			
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
                                            <input  name="" class="form-control"  value="<?php echo $_SESSION['registrationNumber'] ?>" type="text" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Email Address</label>
                                            <input id="placement_contact_email" value="<?php echo $_SESSION['admission_emailid_student'] ?>" class="form-control"  placeholder="Enter Email" type="email" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="">Phone Number</label>
                                            <input id="placement_contact_phone" value="<?php echo $_SESSION['admission_mobile_student'] ?>" class="form-control"  placeholder="Enter Number" type="text" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Enquiry</label>
                                            <input value="Fee" class="form-control"  placeholder="" type="text" readonly>
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
 }
 elseif ($chk_tx=="userCancelled") {
	# code...
	echo "<hr>";
	 echo "<br> Transaction Details:-";
	 echo "<br> Status    :".$result["data"]["status"];
	 echo "<br> Name      :".$result["data"]["firstname"];
	 echo "<br> Name On Card     :".$result["data"]["name_on_card"];
	 echo "<br> Email     :".$result["data"]["email"];
	 echo "<br> Amount    :".$result["data"]["amount"];
	 echo "<br> Transaction Id    :".$result["data"]["txnid"];
	 echo "<br> EaseBuzz Pay Id    :".$result["data"]["easepayid"];	 
 }
 else
 { 
	 /*
	 // Failure  Code..
	  As Per Your Need
	 */	
	echo "<hr>";
	echo "<br> Transaction Details ";
	echo '<p><font color="red">';
	echo "<br> <b>Error    :".$result["data"]["error_Message"]."</b>"; 
	echo "</font></p>";
		
	
	 
 }
 ?>
  <?php	include_once('include/footer.php'); ?>
</div>
		</body>
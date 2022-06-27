<?php 
    $page_no = "4";
    $page_no_inside = "4_1";
    include "include/authentication.php"; 
    include "include/config.php";
	$visible = md5("visible");
	$random_number = rand(111111,999999); // Random Number
	$image_dir = "images/student_images";
	$sign_dir = "images/student_sign";
	
if(isset($_POST['submit']))
{
	$course_id	 = $_POST["course_id"];
	$academic_year	 = $_POST["academic_year"];
	$semester_id = $_POST["semester_id"];		
	$amount = $_POST["amount"];		
	$registration_no = $_POST["registration_no"];              
	$roll_no = $_POST["roll_no"];              
	$candidate_name = $_POST["candidate_name"];
	$father_name = $_POST["father_name"];              
	$department = $_POST["department"];              
	$gender = $_POST["gender"];              
	$dob = $_POST["dob"];              
	$email_id = $_POST["email_id"];
	$mobile_no1 = $_POST["mobile_no1"];              
	$mobile_no2 = $_POST["mobile_no2"];              
	$adhar_no = $_POST["adhar_no"];
	$address = $_POST["address"];              
	$last_exam_year = $_POST["last_exam_year"];              
	$paper_code	 = $_POST["paper_code"];
	$paper_name = $_POST["paper_name"];  
	$candidate_signature = $_FILES["candidate_signature"]["name"];
	$passport_photo = $_POST["passport_photo"];


	 $candidate_signature_rand = $random_number."_".$candidate_signature;
	 move_uploaded_file($_FILES["candidate_signature"]["tmp_name"], "$image_dir/$candidate_signature_rand");  
	/* $passport_photo_rand = $random_number."_".$passport_photo;
	 move_uploaded_file($_FILES["passport_photo"]["tmp_name"], "$sign_dir/$passport_photo_rand"); */
	 
	/* $sql = "INSERT INTO `tbl_examination_form`
			(`exam_id`, `course_id`, `semester_id`, `registration_no`, `roll_no`, `candidate_name`, `father_name`, `department`, `candidate_signature`, `passport_photo`, `gender`, `dob`, `email_id`, `mobile_no1`, `mobile_no2`,`adhar_no`, `address`, `last_exam_year`, `paper_code`, `paper_name`, `transactionid`, `easebuzzid`,`create_time`, `status`)
			VALUES 
			('', '$course_id', '$semester_id', '$registration_no', '$roll_no', '$candidate_name', '$father_name', '$department', '$candidate_signature_rand', '$passport_photo_rand', '$gender', '$dob', '$email_id', '$mobile_no1','$mobile_no2','$adhar_no','$address','$last_exam_year','$paper_code','$paper_name', '".$result["data"]["txnid"]."', '".$result["data"]["easepayid"]."',  '$date_variable_today_month_year_with_timing', '$visible')
			";
    if($con->query($sql)){
						
                        echo "<script>
                                alert('Inserted successfully!!!');
                                location.replace('../payfee');
                            </script>";
                    }
                    else
						
                        echo "<script>
                                alert('Something went wrong please try again!!!');
                                location.replace('../payfee');
                            </script>";*/

    $_SESSION["course_id"] = $course_id;
    $_SESSION["academic_year"] = $academic_year;
	$_SESSION["semester_id"]=$semester_id;		                                           				
	$_SESSION["amount"]=$amount;		                                           				
	$_SESSION['registration_no']=$registration_no;		                                           				
	$_SESSION["roll_no"]=$roll_no;		                                           				
	$_SESSION['candidate_name']=$candidate_name;		                                           				
	$_SESSION['father_name']=$father_name;		                                           				
	$_SESSION['department']=$department;		                                           				
	$_SESSION['gender']=$gender;		                                           				
	$_SESSION['dob']=$dob;		                                           				
	$_SESSION['email_id']=$email_id;		                                           				
	$_SESSION['mobile_no1']=$mobile_no1;		                                           				
	$_SESSION['mobile_no2']=$mobile_no2;		                                           				
	$_SESSION['adhar_no']=$adhar_no;		                                           				
	$_SESSION['address']=$address;		                                           				
	$_SESSION['last_exam_year']=$last_exam_year;		                                           				
	$_SESSION['paper_code']=$paper_code;		                                           				
	$_SESSION['paper_name']=$paper_name;		                                           				
	$_SESSION['candidate_signature']=$candidate_signature_rand;		                                           				
	$_SESSION['passport_photo']=$passport_photo;		 
    //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
					   
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS UNIVERSITY | Examination Form </title>
    <link rel="icon" href="images/logo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
      .form-control {
          font-weight: 900 !important;
          color: #ad183a !important;
      }
    
    /*Right click disabled*/
/* Disables the selection */
.disableselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none;   /* Chrome/Safari/Opera */
  -khtml-user-select: none;    /* Konqueror */
  -moz-user-select: none;      /* Firefox */
  -ms-user-select: none;       /* Internet Explorer/Edge*/
   user-select: none;          /* Non-prefixed version, currently 
                                  not supported by any browser */
}

/* Disables the drag event 
(mostly used for images) */
.disabledrag{
   -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
   user-drag: none;
}
/* // Right click disabled*/
    
  </style>
</head>
<body class="hold-transition sidebar-mini" oncontextmenu="return false;">
<div class="wrapper">

<?php include 'include/navbar.php'; ?>
<?php include 'include/aside.php'; ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
            <h1>EXAMINATION FORM - For University Campus Programme</h1>
          </div>
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>            
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
	  
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
		 <?php
		$len = 10;   // total number of numbers
		$min = 1000;  // minimum
		$max = 9999;  // maximum
		$range = []; // initialize array
		foreach (range(0, $len - 1) as $i) {
			while(in_array($num = mt_rand($min, $max), $range));
			$range[] = $num;
		}
          
         $sql_course = "SELECT * FROM `tbl_course` WHERE `course_id` = $course_id;"; 
           $result_course = $con->query($sql_course);
             $row_course =  $result_course->fetch_assoc();
          
          $sql = "SELECT * FROM `tbl_admission` WHERE `status` = '$visible' && `admission_username` = '".$_SESSION["logger_username1"]."'";
          $result = $con->query($sql);
	      $row = $result->fetch_assoc();  
          
          
          
         $sql = "SELECT * FROM `tbl_university_details`
			WHERE `status` = '$visible' && university_details_id = '".$row["admission_session"]."'
			ORDER BY `university_details_id` DESC
			";
	$result = $con->query($sql);				
	$rows = $result->fetch_assoc();
	$academic_yearId = $rows["university_details_id"];

    $completeSessionStart = explode("-", $rows["university_details_academic_start_date"]);
    $completeSessionEnd = explode("-", $rows["university_details_academic_end_date"]);
    $completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];
    //echo $completeSessionOnlyYear; 
          
          
          
         // echo $row["admission_session"];
		?>
        <form id="payment_form" method="post"  action="easebuzz/easebuzz.php?api_name=initiate_payment">
            <input type="hidden" name="paymode" value="9" />
            <div class="card-body">
		        <div class="row">
		            <div class="col-md-12" id="error_section"></div>
			      <div class="col-4">
                  <label>Transaction ID</label>
				    <input id="txnid" class="form-control" name="txnid" value="<?php echo $num; ?>" class="form-control" placeholder="" readonly>
                  </div>
                
				<div class="col-4">
                   <label>Exam Fee</label>
					<input class="form-control" id="amount"  name="amount"  value="<?php echo $_SESSION["amount"]; ?>.0" readonly>
					<small class="form-text color-orange">Please Pay this amount For submit this Form.</small> 
                </div> 				
                
				<div class="col-4">  
				<label>Name</label>
                <input id="firstname" class="form-control" name="firstname" value="<?php echo $_SESSION["candidate_name"]; ?>" placeholder="" readonly>			
                </div>
                  
                  <div class="col-4">  
				<label>Father Name</label>
                <input id="firstname" class="form-control" name="udf1" value="<?php echo $_SESSION["father_name"]; ?>" placeholder="" readonly>	
                </div>
                  
                
                  <div class="col-4">
                    <label>Course</label>
                    <input id="course" class="form-control" name="udf2" value="<?php echo $row_course["course_name"]; ?>" placeholder="" readonly>
                    <?php $_SESSION["course_name"] = $row_course["course_name"]; ?>
                  </div>
                  
                  			                                           				

                  
                    <div class="col-4">
                      <label>Session</label>
                      <input id="session" class="form-control" name="udf3" value="<?php echo $completeSessionOnlyYear; ?>" placeholder="" readonly>
                  </div>
                  
				
			    <div class="col-4">
                   <label>Email ID</label>
                    <input id="email" class="form-control" name="email" value="<?php echo $_SESSION["email_id"]; ?>" placeholder="" readonly>                                   
                </div>
				
				<div class="col-4">
                 <label for="">Phone No</label>
                  <input id="phone" class="form-control" name="phone" value="<?php echo $_SESSION["mobile_no1"]; ?>" placeholder="" readonly>                                   
                </div>		
				
			    <div class="col-4">
                   <label for="">Status</label>
                   <input id="productinfo"  class="form-control" name="productinfo" value="<?php echo "Exam Fee Amount"; ?>" placeholder="" readonly> 
                   <input type="hidden" id="surl" class="surl" name="surl" value="https://nsucms.in/nsucms/student/exam_success" placeholder="">
					<input type="hidden" id="furl" class="furl" name="furl" value="https://nsucms.in/nsucms/student/exam_success" placeholder="">				   
                </div></br></br></br></br>
                 <div class="col-md-6">	
				<button type="submit" type="submit" name="button" id="add_admission_button" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Pay </button>
			</div>                                   
			</div>
	    </div>
	</div>		  
			  </div>
	    		  
		  </form>
        			
      </div>
    </section>
    <!-- /.content -->
  </div>

  <?php include 'include/footer.php'; ?>

<aside class="control-sidebar control-sidebar-dark">
</aside>
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
<!-- Page script -->



<script>
  
  document.onkeydown = function(e) {
  if(event.keyCode == 123) {
   return false;
   }
if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
return false;
}
  
if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
return false;
}
    
if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
return false;
}
}

  
  
  
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
</body>
</html>
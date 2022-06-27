<?php 
    $page_no = "4";
    $page_no_inside = "4_1";
    include "include/authentication.php"; 
 
	$sql = "SELECT * FROM `tbl_admission` WHERE `status` = '$visible' && `admission_username` = '".$_SESSION["logger_username1"]."'";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$course_id = $row["admission_course_name"];

	$sql = "SELECT * FROM `tbl_university_details`
			WHERE `status` = '$visible' && university_details_id = '".$row["admission_session"]."'
			ORDER BY `university_details_id` DESC
			";
	$result = $con->query($sql);				
	$rows = $result->fetch_assoc();

    $completeSessionStart = explode("-", $rows["university_details_academic_start_date"]);
    $completeSessionEnd = explode("-", $rows["university_details_academic_end_date"]);
    $completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS UNIVERSITY | Admission Form </title>
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
  </style>
</head>
<body class="hold-transition sidebar-mini">
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
		    <form role="form" method="POST" id="fetchStudentDataForm">
				<div class="card-body">
		            <div class="row">	
                    <?php 
                     $sql = "SELECT * FROM `tbl_fee_status`
                             WHERE `admission_id` = '".$row["admission_id"] ."'
                             ";
                     $result = $con->query($sql);
					 $row = $result->fetch_assoc();
					 if($row["exam_status"] == 'Approve')
					 {
                    ?>					
						<div class="card card-secondary" style="width: -webkit-fill-available;">
							<div class="card-header">
								<h3 class="card-title">INSTRUCTIONS FOR FILLING UP THE EXAMINATION FORM:</h3>
							</div>		  			  
							<div class="card-body table-responsive p-0">
								<div class="card-body">
									<div class="row">			
										<ul>
											<li>Write correct subject code(s) as indicated in your Programme Guide / Syllabus.</li>
											<li>In case, wrong / invalid course or subject code is mentioned in examination form, the Admit Card will not be issued.</li>
											<li>Submit examination form within the due date.</li>
											<li>It is advised to enclose photocopy of Admit Card / Mark sheet / Registration slip of the last examination passed.</li>
											<li>Registration is valid for only enrolled Course.</li>
											<li>The enrolment number, subject code, papers’ name are correctly filled in the examination form.</li>
											<li> Examination fees once paid, not refundable / adjusted in any case.</li>
											<li> The correct size of a passport photo and candidate signature is must within between 50KB</li>
										</ul><br><br><br>
			                        <div class="col-4">
                                        <div class="form-group">
                                            <label>Course Name</label>
                                            <input  type="hidden" name="academic_year" value="<?php echo $row["academic_year"]; ?>">  
                                           <?php 
												$sql_course = "SELECT * FROM `tbl_course`
															   WHERE `status` = '$visible';
															   ";
												$result_course = $con->query($sql_course);
												while($row_course = $result_course->fetch_assoc()){
													if($course_id == $row_course["course_id"]){
											?>
											<input type="hidden" name="course_id"  value="<?php echo $course_id ?>">
											<input class="form-control" name="" id="course_id" value="<?php echo $row_course["course_name"]; ?>" readonly>
											<?php } } ?>
                                        </div>
                                    </div>
									<div class="col-4">
                                        <div class="form-group">
                                            <label>Semester</label>
											<input type="hidden" name="subject_id">
                                            <select class="form-control" name="semester_id" id="sem" onchange="showdesg1(this.value)" required>
											   <option value="-1">Select</option>
											</select>
                                        </div>
                                    </div>	
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Exam Fee</label>
                                         	<input type="text" class="form-control" name="amount" id="amount" readonly>                                        

                                        </div>
                                    </div>										
                                   <!-- <div class="col-4">
                                        <div class="form-group">
                                            <label>Academic Year</label>
                                                <input  type="hidden" name="acadmic_year" value="<?php echo $row["admission_session"]; ?>">                             
                                        </div>
                                    </div>-->
                                   <div class="col-1" style="margin-top: 29px;">
                                        <button type="submit" id="fetchStudentDataButton" class="btn btn-primary">Go</button>
                                    </div>
									</div>
								</div>
							</div>
						</div>  
					 <?php  } else {
                       echo  "<h4 style='color:red;'>Dear ".ucfirst($_SESSION["logger_username1"]).", your dues is not clear, please clear your dues to fill the EXAMINATION FORM.</h4>";
					 }
                    ?>					 
					</div>
				</div>
		
		    </form>
		    <div class="col-12" id="loader_section"></div>
			<!-- /.card-header -->
			<div class="card-body" id="data_table">

			</div>     
  </div>     		  			
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
 <script>
        $(document).ready(function() {
            $('#fetchStudentDataForm').submit(function( event ) {
                $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                $('#fetchStudentDataButton').prop('disabled', true);
                $.ajax({
                    url: 'include/view.php?action=test_fetch_exam_form',
                    type: 'POST',
                    data: $('#fetchStudentDataForm').serializeArray(),
                    success: function(result) {
                        $('#response').remove();
                        if(result == 0){
                            $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please select Academic Year!!!</div></div>');
                        } else{
                            $('#data_table').append('<div id = "response">' + result + '</div>');
                        }
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                        });
                        $('#fetchStudentDataButton').prop('disabled', false);
                    }
                });
                event.preventDefault();
            });
        });
    </script>
<script>
	$(function(){
		showdesg();
		function showdesg() {
			dept = <?= $course_id ?>;
			$.ajax({
				url: '../ajaxdata3.php',
				type: 'POST',
				data: {depart: dept},
				success: function (data) {
					$("#sem").html(data);
				},
			});
		}
	});
</script>
<script>
    function showdesg1(dept1) {
        $.ajax({
            url: 'ajaxdata.php',
            type: 'POST',
            data: {depart1: dept1},
            success: function (data) {
                $("#amount").val(data);
            },
        });
    }
</script>
</body>
</html>
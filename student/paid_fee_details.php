<?php 
    $page_no = "3";
    $page_no_inside = "3_3";
    include "include/authentication.php"; 

    $sql = "SELECT `admission_course_name` FROM `tbl_admission` WHERE `admission_username` = '".$_SESSION["logger_username1"]."'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
	
	$sql_course = "SELECT * FROM `tbl_course` WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';";
	$result_course = $con->query($sql_course);
	$row_course = $result_course->fetch_assoc();
	
	$sql1 = "SELECT *
            FROM `tbl_fee_paid`
            INNER JOIN `tbl_admission` ON `tbl_fee_paid`.`student_id` = `tbl_admission`.`admission_id`
             INNER JOIN `tbl_university_details` ON `tbl_fee_paid`.`university_details_id` = `tbl_university_details`.`university_details_id`
            WHERE `tbl_fee_paid`.`status` = '$visible' && tbl_admission. `admission_username` = '".$_SESSION["logger_username1"]."'";
    $result1 = $con->query($sql1);
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

<body class="hold-transition sidebar-mini" oncontextmenu="return false;">
    <div class="wrapper">

        <?php include 'include/navbar.php'; ?>
        <?php include 'include/aside.php'; ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Fee Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Fee Details</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
							<h5>Total Fee Paid For Course : <?php echo $row_course["course_name"]; ?></h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="data_table">
							  <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <!--<th>Receipt Number</th>-->
                                <th>Date</th>
                                <!--<th>Student Name</th>-->
                                <th>Paid Amount</th>                              
                                <th>Balance Amount</th>
                            </tr>
                        </thead>
                        <tbody>         
                           <?php 
						   $s_no=1;
                                while($row1 = $result1->fetch_assoc()){
                                    ?>
                                        <tr>
                                            <td><?php echo $s_no; ?></td>
                                          <!--  <td><?php echo $row1["receipt_no"] ?></td>-->
                                            <td><?php echo $row1["receipt_date"] ?></td>
                                            <?php 
                                                $sql_student = "SELECT * FROM `tbl_admission`
                                                                WHERE `status` = '$visible' && `admission_username` = '".$_SESSION["logger_username1"]."'
                                                                ";
                                                $result_student = $con->query($sql_student);
                                                $row_student = $result_student->fetch_assoc();
                                            ?>
                                           <!-- <td><?php echo $row_student["admission_first_name"]." ".$row_student["admission_middle_name"]." ".$row_student["admission_last_name"] ?></td>-->
                                            
                                            <?php 
                                                $sumAmount = 0;
                                                $amountsPaid = explode(",",$row1["paid_amount"]);
                                                for($i=0; $i<count($amountsPaid); $i++){
                                                    $sumAmount = $sumAmount + intval($amountsPaid[$i]);
                                                }
                                                unset($amountsPaid);
                                            ?>
                                            <td><?php echo $sumAmount+intval($row1["fine"]); ?></td>
                                            <td><?php echo $row1["balance"] ?></td>
                                          
                                        </tr>
                                    <?php 
                                        $s_no++;
                                    }
                            ?>
                        </tbody>
                    </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>

        <?php include 'include/footer.php'; ?>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
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
if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
return false;
}
}
      
      
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
</body>
	
</html>
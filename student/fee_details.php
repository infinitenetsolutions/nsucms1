<?php 
    $page_no = "3";
    $page_no_inside = "3_2";
    include "include/authentication.php"; 

    $sql = "SELECT `admission_course_name` FROM `tbl_admission` WHERE `admission_username` = '".$_SESSION["logger_username1"]."'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
	
	$sql_course = "SELECT * FROM `tbl_course` WHERE `status` = '$visible' && `course_id` = '".$row["admission_course_name"]."';";
	$result_course = $con->query($sql_course);
	$row_course = $result_course->fetch_assoc();
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
							<h5>Fee Details For Course : <?php echo $row_course["course_name"]; ?></h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="data_table">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>S.No</th>
											<th>Particulars</th>
											<th>Amount</th>
										</tr>
									</thead>
										<tbody>         
										   <?php 
												$s_no=1;
												$sql = "SELECT * FROM `tbl_fee`
                                                        WHERE `status` = '$visible' && `course_id` = '".$row_course["course_id"]."'	  && `fee_academic_year` = '".$row["admission_session"]."'	 											
														";
												$result = $con->query($sql);
												if($result->num_rows > 0){
													while($row = $result->fetch_assoc()){
													?>
														<tr>
															<td><?php echo $s_no; ?></td>															
														  <td align="left" class="narmal"><?php echo $row["fee_particulars"]; ?></td>
                                                          <td class="narmal">Rs&nbsp;<?php echo number_format($row["fee_amount"]); ?>.00</td>
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
<?php
$page_no = "9";
$page_no_inside = "9_3";
include "include/authentication.php";



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS UNIVERSITY | Admission Enquiry </title>
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
 <link rel="stylesheet" href="./dist/css/pagination.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<?php include 'include/navbar.php'; ?>
<?php include 'include/aside.php'; ?>

<body class="hold-transition sidebar-mini">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admission Enquiry</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Admission</a></li>
                            <li class="breadcrumb-item active">Admission Enquiry</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header card-warning">

                            <form method="POST" action="export-admission.php">
                                <div class="card-body" style="margin-top: 0px;">
                                    <div class="row">
                                        <div class="col-12" id="error_section"></div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label>Course Name</label>
                                                <select class="form-control" name="course_id">
                                                    <option value="all">All</option>
                                                    <?php
                                                    $sql_course = "SELECT * FROM `tbl_course`
                                                                   WHERE `status` = '$visible';
                                                                   ";
                                                    $result_course = $con->query($sql_course);
                                                    while ($row_course = $result_course->fetch_assoc()) {
                                                    ?>
                                                        <option value="<?php echo $row_course["course_id"]; ?>"><?php echo $row_course["course_name"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label>Academic Year</label>
                                                <select class="form-control" name="academic_year">
                                                    <option value="all">All</option>
                                                    <?php
                                                    $sql_ac_year = "SELECT * FROM `tbl_university_details`
                                                                   WHERE `status` = '$visible';
                                                                   ";
                                                    $result_ac_year = $con->query($sql_ac_year);
                                                    while ($row_ac_year = $result_ac_year->fetch_assoc()) {
                                                    ?>
                                                        <option value="<?php echo $row_ac_year["university_details_id"]; ?>"><?php echo date("d/m/Y", strtotime($row_ac_year["university_details_academic_start_date"])) . " to " . date("d/m/Y", strtotime($row_ac_year["university_details_academic_end_date"])); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2" style="margin-top: 29px;">
                                            <input type="hidden" name="action" value="export_student_details" />
                                            <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-download"></i> Export All</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="card table-responsive p-3 ">
            <div class="row">
                <div class="col-sm-10">

                </div>
                <div class="col-sm-2">
                    <input type="text" onkeyup="searchData(this.value)" placeholder="Search.." class="form-control form-control-sm">

                </div>
            </div>
            <table id="example1" class="table table-bordered table-striped mt-5">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Seleted Course</th>
                        <th>Applicant Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Session</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Gender</th>
                        <th>Admission District</th>
                        <th>Action </th>
                        <th>Action </th>
                        <th>Action </th>


                    </tr>
                </thead>
                <tbody id="data">
                    <?php
                    $limit = 10;
                    if (isset($_GET["page"])) {
                        $page  = $_GET["page"];
                    } else {
                        $page = 1;
                    };

                    $start_from = ($page - 1) * $limit;
                    $s_no = $start_from + 1;

                    $admission_query = "SELECT * FROM `tbl_admission` WHERE `stud_status`='1' LIMIT $start_from, $limit";
                    $admission_result = $con->query($admission_query);

                    if ($admission_result) {
                        while ($row = $admission_result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $s_no; ?></td>
                                <?php
                                //   i heve to check prospectus course name value interger or charater

                                $prospectus_course_name = $row["admission_course_name"];
                                $course_no_query = "SELECT * FROM `tbl_course` WHERE `course_id`='$prospectus_course_name'";
                                $course_no_result = mysqli_query($con, $course_no_query);
                                $data_row1 = mysqli_fetch_array($course_no_result);
                                $prospectus_course = $data_row1['course_name'];
                                $course_session = $data_row1['duration'];
                                if ($course_session == 2) {
                                    $course_session = date('Y') . '-' . date('Y', strtotime('+2 year'));
                                } elseif ($course_session == 3) {
                                    $course_session = date('Y') . '-' . date('Y', strtotime('+3 year'));
                                } else {
                                    $course_session = date('Y') . '-' . date('Y', strtotime('+4 year'));
                                }

                                ?>
                                <td><?php echo $prospectus_course  ?></td>

                                <td><?php echo $row["admission_title"];
                                    echo " ";
                                    echo $row['admission_first_name']; ?></td>
                                <td><?php echo $row["admission_emailid_student"] ?></td>
                                <td><?php echo $row["admission_mobile_student"] ?></td>
                                <td><?php echo $course_session ?></td>
                                <td><?php echo $row["admission_state"] ?></td>
                                <td><?php echo $row["admission_city"] ?></td>
                                <td><?php echo $row["admission_gender"] ?></td>
                                <td><?php echo $row["admission_district"] ?></td>
                                <td>
                                    <a href="admission_form_view?edit=<?php echo $row["admission_id"];  ?>" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-eye">
                                        </i>

                                    </a>
                                </td>
                                <td>
                                    <a href="admission_form_update?edit=<?php echo $row["admission_id"];  ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit">
                                        </i>

                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_university_get_enquiry<?php echo $row['id']; ?>').style.display='block'">
                                        <i class="fas fa-trash">
                                        </i>

                                    </button>
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
            $result_db = mysqli_query($con, "SELECT COUNT(admission_id) FROM tbl_admission");
            $row_db = mysqli_fetch_row($result_db);
            $total_records = $row_db[0];
            $total_pages = $total_records;
            $num_results_on_page = $limit;

            /* echo  $total_pages; */ ?>
            <div class="ml-3">
                <?php if (ceil($total_pages / $num_results_on_page) > 0) : ?>
                    <ul class="pagination">
                        <?php if ($page > 1) : ?>
                            <li class="prev page-item"><a href="nsuniv-admission-enquiry?page=<?php echo $page - 1 ?>">Prev</a></li>
                        <?php endif; ?>

                        <?php if ($page > 3) : ?>
                            <li class="start"><a href="nsuniv-admission-enquiry?page=1">1</a></li>
                            <li class="dots">...</li>
                        <?php endif; ?>

                        <?php if ($page - 2 > 0) : ?><li class="page"><a href="nsuniv-admission-enquiry?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                        <?php if ($page - 1 > 0) : ?><li class="page"><a href="nsuniv-admission-enquiry?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                        <li class="currentpage"><a href="nsuniv-admission-enquiry?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                        <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="nsuniv-admission-enquiry?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                        <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="nsuniv-admission-enquiry?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page) - 2) : ?>
                            <li class="dots">...</li>
                            <li class="end"><a href="nsuniv-admission-enquiry?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                        <?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)) : ?>
                            <li class="next"><a href="nsuniv-admission-enquiry?page=<?php echo $page + 1 ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>


        </div>
    </div>

    <!-- /.content -->
    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <?php include 'include/footer.php'; ?>

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
            $('#example1').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
    <script>
        function searchData(data) {
            $.ajax({
                url: 'include/ajax/admission_enquiry.php?data=' + data,
                type: 'GET',
                success: function(result) {
                    $("#data").html(result);
                }
            });
        
        }

        // $(document).ready(function() {
        //     $.ajax({
        //         url: 'include/view.php?action=get_nsuniv-nsuniv-admission-enquiry',
        //         type: 'GET',
        //         success: function(result) {
        //             $("#data_table").html(result);
        //         }
        //     });
        // });
    </script>
</body>

</html>


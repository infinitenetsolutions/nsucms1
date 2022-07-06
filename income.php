<?php
$page_no = "8";
$page_no_inside = "8_2";
include './framwork/main.php';

//authentication start
//Starting Session
if (empty(session_start()))
    session_start();
//Logger Type
$logger_type = $_SESSION["logger_type"];
if ($logger_type == "subadmin")
    $autority = $_SESSION["authority"];

//DataBase Connectivity
include "include/config.php";
$idle_time = 1200;
$visible = md5("visible");
$trash = md5("trash");
if (time() - $_SESSION["logger_time"] > $idle_time) {
    unset($_SESSION["logger_time"]);
    unset($_SESSION["logger_type"]);
    unset($_SESSION["logger_username"]);
    unset($_SESSION["logger_password"]);
    echo "<script> location.replace('index'); </script>";
} else {
    $_SESSION["logger_time"] = time();
}
if (!isset($_SESSION["logger_type"]) && !isset($_SESSION["logger_username"]) && !isset($_SESSION["logger_password"]))
    echo "<script> location.replace('index'); </script>";
$flag = 0;
if (isset($autority)) {
    $allAutority = json_decode($autority);
    if ($page_no != 1) {
        if (isset($allAutority->$page_no)) {
            $subMenus = explode("||", $allAutority->$page_no);
            for ($i = 0; $i < count($subMenus); $i++) {
                if ($subMenus[$i] == $page_no_inside) {
                    $flag++;
                    break;
                }
            }
            if ($flag == 0) {
                echo "<script>
                           location.replace('dashboard');
                       </script>";
            }
        } else
            echo "<script>
                           location.replace('dashboard');
                       </script>";
    }
}
//authentication end
//export start
$limit = 20;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};

$start_from = ($page - 1) * $limit;
$s_no = $start_from + 1;
$query = "SELECT * FROM `tbl_income` WHERE `amount`!='' ORDER BY id DESC  LIMIT $start_from, $limit";
$results = mysqli_query($con, $query) or die("database error:" . mysqli_error($con));
$allOrders = array();
while ($order = mysqli_fetch_assoc($results)) {
    $no = 1;
    $allOrders[] = $order;
}
$startDateMessage = '';
$endDate = '';
$noResult = '';
if (isset($_POST["export"])) {
    if (empty($_POST["fromDate"])) {
        $startDateMessage = '<label class="text-danger">Select start date.</label>';
    } else if (empty($_POST["toDate"])) {
        $endDate = '<label class="text-danger">Select end date.</label>';
    } else {
        $orderQuery = "
		SELECT * FROM tbl_income 
		WHERE  post_at >= '" . $_POST["fromDate"] . "' AND post_at <= '" . $_POST["toDate"] . "' ORDER BY post_at DESC, id DESC";
        $orderResult = mysqli_query($con, $orderQuery) or die("database error:" . mysqli_error($con));
        $filterOrders = array();
        while ($order = mysqli_fetch_assoc($orderResult)) {
            $filterOrders[] = $order;
        }
        if (count($filterOrders)) {
            if ($_POST["toDate"] == $_POST["fromDate"])
                $fileName = "Income-Report-" . date('d-m-Y', strtotime($_POST["toDate"])) . ".csv";
            else
                $fileName = "Income-Report-From-" . date('d-m-Y', strtotime($_POST["fromDate"])) . "-To-" . date('d-m-Y', strtotime($_POST["toDate"])) . ".csv";
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-Type: application/csv;");
            $file = fopen('php://output', 'w');
            $header = array("S.No", "Date Of Entry", "Reg.No", "Name", "Course", "Session", "Particulars", "Amount", "Payment Mode", "Cheque/DD/Online No", "Payment Date", "Bank Name", "Remarks");
            fputcsv($file, $header);
            foreach ($filterOrders as $order) {
                if ($order["amount"] != "") {
                    $orderData = array();
                    $orderData[] = $no++;
                    $orderData[] = date("d-m-Y", strtotime($order["post_at"]));
                    $orderData[] = $order["reg_no"];
                   echo  $sql_name = "SELECT * FROM `tbl_admission` WHERE `admission_id` = '" . $order["reg_no"] . "' ";
                    $result_name = $con->query($sql_name);
                    $row_name = $result_name->fetch_assoc();
                    $remove_prospectus = str_replace("(Form No)", "", $order["reg_no"]);
                    $sql_name1 = "SELECT * FROM `tbl_prospectus` WHERE `prospectus_no` = '" . $remove_prospectus . "'  ";
                    $result_name1 = $con->query($sql_name1);
                    $row_name1 = $result_name1->fetch_assoc();
                    if (strpos($order["reg_no"], "Extra Income") === false)
                        $orderData[] = " " . strtoupper($row_name["admission_first_name"]) . " " . strtoupper($row_name["admission_middle_name"]) . " " . strtoupper($row_name["admission_last_name"]) . " " . strtoupper($row_name1["prospectus_applicant_name"]);
                    else
                        $orderData[] =  " " . $order["particulars"] . " From " . str_replace("Extra Income", "", str_replace(")", "", str_replace("(", "", $order["reg_no"])));
                    $sql_course = "SELECT * FROM `tbl_course` WHERE `course_id` = '" . $order["course"] . "' ";
                    $result_course = $con->query($sql_course);
                    $row_course = $result_course->fetch_assoc();
                    $orderData[] = $row_course["course_name"];
                    $sql_session = "SELECT * FROM `tbl_university_details` WHERE `university_details_id` = '" . $order["academic_year"] . "' ";
                    $result_session = $con->query($sql_session);
                    $row_session = $result_session->fetch_assoc();
                    $orderData[] = intval($row_session["university_details_academic_start_date"]) . " - " . intval($row_session["university_details_academic_end_date"]);
                    $orderData[] = strtoupper($order["particulars"]);
                    $orderData[] = $order["amount"];
                    $orderData[] = $order["payment_mode"];
                    $orderData[] = $order["check_no"];
                    $orderData[] = date("d-m-Y", strtotime($order["received_date"]));
                    $orderData[] = $order["bank_name"];
                    fputcsv($file, $orderData);
                }
            }
            fclose($file);
            exit;
        } else {
            $noResult = '<label class="text-danger">There are no record exist with this date range to export. Please choose different date range.</label>';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS UNIVERSITY | Income Details </title>
    <!-- Fav Icon -->
    <link rel="icon" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="./dist/css/income.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="build/js/datepickers.js"></script>
    <style>
        .dtHorizontalExampleWrapper {
            max-width: 600px;
            margin: 0 auto;
        }

        #dtHorizontalExample th,
        td {
            white-space: nowrap;
        }

        .dataTables_paginate {
            display: none;
        }

        #dtHorizontalExample_filter {
            display: none;
        }

        .datepicker {
            display: none !important;
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
                        <div class="col-sm-6">
                            <h1>Income</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Income</li>
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
                                <div class="float-sm-right">
                                    <!-- <button type="button" class="btn btn-success" onclick="document.getElementById('add_expenses').style.display='block'">Add Expenses</button>-->
                                </div>
                                <form method="post">
                                    <div class="input-daterange">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-2">
                                                    From<input type="date" name="fromDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                                                    <?php echo $startDateMessage; ?>
                                                </div>
                                                <div class="col-2">
                                                    To<input type="date" name="toDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                                                    <?php echo $endDate; ?>
                                                </div>
                                                <div class="col-2">
                                                    <div>&nbsp;</div>
                                                    <button type="submit" name="export" class="btn btn-info"> Export to CSV </button>
                                                </div>
                                            </div>
                                        </div>

                                </form>
                                </form>
                                <div class="row">
                                    <div class="col-md-8">
                                        <?php echo $noResult; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9">
                                        show
                                        <select class="form=-control mt-4" onchange="page_size(this.value)" id="">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="500">500</option>

                                        </select>
                                        entires
                                    </div>
                                    <div class="col-sm-3">
                                        Search: <input type="text" onkeyup="search(this.value)" class=" form-control form-control-sm">
                                    </div>
                                </div>
                                <div id="search_data" class="card-body">

                                    <table id="dtHorizontalExample" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Date</th>
                                                <th>Reg No/Form No</th>
                                                <th>Name</th>
                                                <th>Course</th>
                                                <th>Session</th>
                                                <th>Particulars</th>
                                                <th>Amount</th>
                                                <th>Payment Mode</th>
                                                <th>Cheque/DD/Online No</th>
                                                <th>Payment Date</th>
                                                <th>Bank</th>
                                                <th>User Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($allOrders as $order) {
                                                if ($order["amount"] != "") {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $s_no; ?></td>
                                                        <td><?php echo date("d-m-Y", strtotime($order["post_at"])); ?></td>
                                                        <td>
                                                            <?php
                                                            if (strpos($order["reg_no"], "Extra Income") === false)
                                                                echo $order["reg_no"];
                                                            else
                                                                echo "Extra Income";
                                                            ?>

                                                        </td>
                                                        <?php
                                                        if (strpos($order["reg_no"], "Extra Income") === false) {
                                                            $remove_admission = str_replace("(Reg No)", "", $order["reg_no"]);
                                                            $sql_name = "SELECT * FROM `tbl_admission` WHERE `admission_id` = '" . $remove_admission . "' ";
                                                            $result_name = $con->query($sql_name);
                                                            if ($result_name->num_rows > 0) {
                                                                $row_name = $result_name->fetch_assoc();
                                                        ?>
                                                                <td><?php echo strtoupper($row_name["admission_first_name"]) . " " . strtoupper($row_name["admission_middle_name"]) . " " . strtoupper($row_name["admission_last_name"]); ?></td>
                                                            <?php

                                                            } else {
                                                                $remove_prospectus = str_replace("(Form No)", "", $order["reg_no"]);
                                                                $sql_name1 = "SELECT * FROM `tbl_prospectus` WHERE `prospectus_no` = '" . $remove_prospectus . "' ";
                                                                $result_name1 = $con->query($sql_name1);
                                                                $row_name1 = $result_name1->fetch_assoc();
                                                            ?>
                                                                <td><?php echo strtoupper($row_name1["prospectus_applicant_name"]); ?></td>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo "<td> " . strtoupper("From " . str_replace("Extra Income", "", str_replace(")", "", str_replace("(", "", $order["reg_no"])))) . " </td>";
                                                        }
                                                        ?>

                                                        <?php
                                                        $sql_course = "SELECT * FROM `tbl_course` WHERE `course_id` = '" . $order["course"] . "' ";
                                                        $result_course = $con->query($sql_course);
                                                        $row_course = $result_course->fetch_assoc();
                                                        ?>
                                                        <td><?php echo $row_course["course_name"]; ?></td>
                                                        <?php
                                                        $sql_session = "SELECT * FROM `tbl_university_details` WHERE `university_details_id` = '" . $order["academic_year"] . "' ";
                                                        $result_session = $con->query($sql_session);
                                                        $row_session = $result_session->fetch_assoc();
                                                        ?>
                                                        <td><?php echo intval($row_session["university_details_academic_start_date"]) . " - " . intval($row_session["university_details_academic_end_date"]); ?></td>
                                                        <td><?php
                                                            if (strpos($order["reg_no"], "Extra Income") === false)
                                                                echo strtoupper($order["particulars"]);
                                                            else
                                                                echo " " . $order["particulars"] . " From " . str_replace("Extra Income", "", str_replace(")", "", str_replace("(", "", $order["reg_no"])));
                                                            ?>

                                                        </td>
                                                        <td><?php echo $order["amount"]; ?></td>
                                                        <td><?php echo $order["payment_mode"]; ?></td>
                                                        <td><?php echo  $order["check_no"]; ?></td>
                                                        <td><?php echo date("d-m-Y", strtotime($order["received_date"])); ?></td>
                                                        <td><?php echo $order["bank_name"]; ?></td>
                                                        
                                                        <td><?= fetchRow('tbl_fee_paid','student_id='.str_replace('(Reg No)','',$order["reg_no"]))['print_generated_by'] =='' ? fetchRow('tbl_prospectus',' prospectus_no='.str_replace('(Form No)','',$order["reg_no"]))['user_name'] : fetchRow('tbl_fee_paid','student_id='.str_replace('(Reg No)','',$order["reg_no"]))['print_generated_by']
                                                            ?></td>

                                                    </tr>
                                            <?php
                                                    $s_no++;
                                                }
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php  paginate('tbl_income','20','income','amount!=""') ?>

                                <!-- /.card-header -->
                                <div class="card-body" id="data_table">

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
    <!--<script src="plugins/jquery/jquery.min.js"></script>-->
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->


    <script>
        $('#example').dataTable({
            "bPaginate": false
        });
    </script>

    <script>
        function search(data) {
            if (data.length == '') {
                window.location.href
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    document.getElementById("search_data").innerHTML = this.responseText;
                };
                xmlhttp.open("GET", "./include/ajax/incomesearch.php?search=" + data, true);
                xmlhttp.send();
            }
        }

        function page_size(data) {
            console.log(data);

            window.location.replace(window.location.pathname);

        }
    </script>
</body>

</html>
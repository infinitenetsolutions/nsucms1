<?php
$page_no = "9";
$page_no_inside = "9_2";
include "include/authentication.php";
include './framwork/main.php';
$condition1 = 1;
$msg = '';
$limit = 50;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
    unset($_SESSION['condition']);
};
$start_from = ($page - 1) * $limit;
$s_no = $start_from + 1;
$condition = '1 LIMIT ' . $start_from . ',' . $limit;
if (isset($_SESSION['condition'])) {
    if ($_SESSION['condition'] != '') {
        $condition = $_SESSION['condition'] . '  LIMIT ' . $start_from . ',' . $limit;
        $condition1 = $_SESSION['condition'];
    } else {
        $condition = '1 LIMIT ' . $start_from . ',' . $limit;
    }
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS UNIVERSITY | Nsuniv Prospectus Enquiry </title>
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
    <style>
        .disableAll {
            pointer-events: none;
            opacity: 0.6;
        }

        #dynamicChangeLoader {
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
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
                            <h1>Prospectus Enquiry</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Prospectus</a></li>
                                <li class="breadcrumb-item active">Prospectus Enquiry</li>
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
                                <div class="form-group float-left mb-0">
                                    <select onchange="change_max(this.value)" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="dynamicChangeLimit">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="500">500</option>

                                    </select>

                                   
                                </div>
                                <form method="POST" action="export-list" class="float-right mb-0">
                                    <input type="hidden" name="action" value="export_all_prospectus_details" />
                                    <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-download"></i> Export All</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 p-3">
                        <input type="text" value="<?= $_SESSION['q'] ?>" class="form-control form-control-sm " placeholder="Search .." name="" onkeyup="search(this.value)">
                    </div>

                </div>
                <div id="demo">
                    <div class="table-responsive" class="card bg-white">
                        <table class="table table-bordered table-striped table-responsive-lg ">
                            <thead>
                                <tr>
                                    <?php thGen("tbl_prospectus_view", 'true')  ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php tdGen("tbl_prospectus_view", 'edit', 'delete', 'Product List', $condition, 50) ?>
                            </tbody>
                        </table>
                    </div>
                    <?php paginate('tbl_prospectus_view', '50', 'nsuniv-prospectus-enquiry', $condition1) ?>
                </div>

                <!-- /.col -->
        </div>
        <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    <?php include 'include/footer.php'; ?>


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
        var th = document.getElementsByTagName('th');
        for (i = 0; i < th.length; i++) {
            final_text = th[i].innerText.replace('prospectus_', '');
            document.getElementsByTagName('th')[i].innerText = final_text
        }
        document.getElementsByTagName('th')[1].innerText = 'Prospectus_no'


        function prospectus() {
            var th = document.getElementsByTagName('th');
            for (i = 0; i < th.length; i++) {
                final_text = th[i].innerText.replace('prospectus_', '');
                document.getElementsByTagName('th')[i].innerText = final_text
            }
            document.getElementsByTagName('th')[1].innerText = 'Prospectus_no'
        }
    </script>

    <script>
        function search(data) {
            this.prospectus();
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("demo").innerHTML = this.responseText;
            }
            xhttp.open("GET", "./include/search/prospectus_enquiry.php?q=" + data, true);
            xhttp.send();
        }
    </script>


    <style>
        th {
            text-transform: capitalize !important;
        }
    </style>
</body>

</html>
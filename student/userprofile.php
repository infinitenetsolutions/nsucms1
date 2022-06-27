<?php
$page_no = "2";
$page_no_inside = "";
include "include/authentication.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Netaji Subhas University| User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include 'include/navbar.php'; ?>
    <?php include 'include/aside.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">

                <?php
                $sql = "SELECT * FROM `tbl_admission` WHERE `status` = '$visible' && `admission_username` = '" . $_SESSION["logger_username1"] . "'";
                $result = $con->query($sql);
                $row = $result->fetch_assoc();
                ?>
                <div class="card-body box-profile">
                  <div class="text-center">
                    <?php
                    if (!empty($row["admission_profile_image"])) {
                    ?>
                      <img class="profile-user-img " src="../images/student_images/<?php echo $row["admission_profile_image"]; ?>" alt="Student profile picture">
                    <?php
                    } else if (strtolower($row["admission_gender"]) == "female") {
                    ?>
                      <img class="profile-user-img img-fluid img-circle" src="images/womenIcon.png" alt="Student profile picture">
                    <?php } else {   ?>
                      <img class="profile-user-img img-fluid img-circle" src="images/menIcon.png" alt="Student profile picture">
                    <?php } ?>
                  </div>
                  <h3 class="profile-username text-center"><?php echo $row["admission_first_name"] ?> <?php echo $row["admission_middle_name"] ?> <?php echo $row["admission_last_name"] ?></h3>
                  <?php
                  $sql = "SELECT * FROM `tbl_university_details`
							WHERE `status` = '$visible' && university_details_id = '" . $row["admission_session"] . "'
							ORDER BY `university_details_id` DESC
							";
                  $result = $con->query($sql);
                  $rows = $result->fetch_assoc();
                  ?>
                  <?php
                  $sql_course = "SELECT * FROM `tbl_course`
								  WHERE `status` = '$visible' && `course_id` = '" . $row["admission_course_name"] . "' 
								   ";
                  $result_course = $con->query($sql_course);
                  $row_course = $result_course->fetch_assoc();
                  ?>
                  <?php
                  $completeSessionStart = explode("-", $rows["university_details_academic_start_date"]);
                  $completeSessionEnd = explode("-", $rows["university_details_academic_end_date"]);
                  $completeSessionOnlyYear = $completeSessionStart[0] . "-" . $completeSessionEnd[0];
                  ?>
                  <p class="text-muted text-center">( <?php echo $row_course["course_name"] . " | " . $completeSessionOnlyYear; ?> )</p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Registration No</b> <a class="float-right"><?php echo $row["admission_id"]; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Form No</b> <a class="float-right"><?php echo $row["admission_form_no"]; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Admission No</b> <a class="float-right"><?php echo $row["admission_no"]; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Academic Year</b> <a class="float-right"><?php echo date("d/m/Y", strtotime($rows["university_details_academic_start_date"])) . " to " . date("d/m/Y", strtotime($rows["university_details_academic_end_date"])); ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Full Name</b> <a class="float-right"><?php echo $row["admission_first_name"] ?> <?php echo $row["admission_middle_name"] ?> <?php echo $row["admission_last_name"] ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Gender</b> <a class="float-right"><?php echo $row["admission_gender"]; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Blood Group</b> <a class="float-right"><?php echo $row["admission_blood_group"]; ?></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Personal Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Contact Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline2" data-toggle="tab">Address</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Certificates</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <!-- Post -->
                      <div class="timeline timeline-inverse">
                        <div>
                          <i class="fas fa-camera bg-purple"></i>
                          <div class="timeline-item">
                            <div class="timeline-body">
                              <p><b>Date Of Birth :</b><?php echo $row["admission_dob"]; ?></p>
                              <p><b>Nationality :</b><?php echo $row["admission_nationality"]; ?></p>
                              <p><b>Aadhar Number :</b> <?php echo $row["admission_aadhar_no"]; ?></p>
                              <p><b>Date Of Admission :</b><?php echo $row["date_of_admission"]; ?></p>
                              <p>
                              <p><b>Category :</b><?php echo $row["admission_category"]; ?></p>
                              <p><b>Hostel :</b><?php echo $row["admission_hostel"]; ?></p>
                              <p><b>Transport :</b><?php echo $row["admission_transport"]; ?></p>
                              <p><b>Username :</b><?php echo $row["admission_username"]; ?></p>
                              <p><b>Password :</b><?php echo $row["admission_password"]; ?></p>
                              <p><b>Mother's Name :</b><?php echo $row["admission_mother_name"]; ?></p>

                            </div>
                          </div>
                        </div>
                        <!-- END timeline item -->
                        <div>
                          <i class="far fa-clock bg-gray"></i>
                        </div>
                      </div>
                      <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                      <!-- The timeline -->
                      <div class="timeline timeline-inverse">
                        <div>
                          <i class="fas fa-camera bg-purple"></i>
                          <div class="timeline-item">
                            <div class="timeline-body">
                              <p><b>Mobile No :</b> <?php echo $row["admission_mobile_student"]; ?></p>
                              <p><b>Email ID :</b><?php echo $row["admission_emailid_student"]; ?></p>
                              <p><b>Mobile No (Father) :</b> <?php echo $row["admission_father_phoneno"]; ?></p>
                              <p><b>Father's Whatsapp No</b><?php echo $row["admission_father_whatsappno"]; ?></p>
                              <p><b>Email Id (Father) :</b><?php echo $row["admission_emailid_father"]; ?></p>
                              <p><b>Home Landline No :</b><?php echo $row["admission_home_landlineno"]; ?></p>
                            </div>
                          </div>
                        </div>
                        <!-- END timeline item -->
                        <div>
                          <i class="far fa-clock bg-gray"></i>
                        </div>
                      </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="timeline2">
                      <div class="timeline timeline-inverse">
                        <div>
                          <i class="fas fa-camera bg-purple"></i>
                          <div class="timeline-item">
                            <div class="timeline-body">
                              <p><b>Residential Address :</b><?php echo $row["admission_residential_address"]; ?></p>
                              <p><b>State :</b><?php echo $row["admission_state"]; ?></p>
                              <p><b>City :</b> <?php echo $row["admission_city"]; ?></p>
                              <p><b>District :</b><?php echo $row["admission_district"]; ?></p>
                              <p>
                              <p><b>Pincode :</b><?php echo $row["admission_pin_code"]; ?></p>
                            </div>
                          </div>
                        </div>
                        <!-- END timeline item -->
                        <div>
                          <i class="far fa-clock bg-gray"></i>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="settings">
                      <div>
                        <div class="timeline-item">
                          <div class="timeline-body">
                            <a href="../images/student_certificates/<?php echo $row["admission_tenth_marksheet"]; ?>"><img src="../images/student_certificates/<?php echo $row["admission_tenth_marksheet"]; ?>" alt="..." style="width: 100px;height: 100px;"></a>
                            <a href="../images/student_certificates/<?php echo $row["admission_tenth_passing_certificate"]; ?>"><img src="../images/student_certificates/<?php echo $row["admission_tenth_passing_certificate"]; ?>" alt="..." style="width: 100px;height: 100px;"></a>
                            <a href="../images/student_certificates/<?php echo $row["admission_twelve_markesheet"]; ?>"><img src="../images/student_certificates/<?php echo $row["admission_twelve_markesheet"]; ?>" alt="..." style="width: 100px;height: 100px;"></a>
                            <a href="../images/student_certificates/<?php echo $row["admission_twelve_passing_certificate"]; ?>"><img src="../images/student_certificates/<?php echo $row["admission_twelve_passing_certificate"]; ?>" alt="..." style="width: 100px;height: 100px;"></a>
                            <a href="../images/student_certificates/<?php echo $row["admission_graduation_marksheet"]; ?>"><img src="../images/student_certificates/<?php echo $row["admission_graduation_marksheet"]; ?>" alt="..." style="width: 100px;height: 100px;"></a>
                            <a href="../images/student_certificates/<?php echo $row["admission_recent_character_certificate"]; ?>"><img src="../images/student_certificates/<?php echo $row["admission_recent_character_certificate"]; ?>" alt="..." style="width: 100px;height: 100px;"></a>
                            <a href="../images/student_certificates/<?php echo $row["admission_other_certificate"]; ?>"><img src="../images/student_certificates/<?php echo $row["admission_other_certificate"]; ?>" alt="..." style="width: 100px;height: 100px;"></a>
                            <a href="../images/student_certificates/<?php echo $row["admission_character_certificate"]; ?>"><img src="../images/student_certificates/<?php echo $row["admission_character_certificate"]; ?>" alt="..." style="width: 100px;height: 100px;"></a>

                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'include/footer.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
</body>

</html>
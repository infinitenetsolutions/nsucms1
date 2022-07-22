<?php
$msg="";
// $page_no = "5";
// $page_no_inside = "5_1";
$admission_id = $_GET['edit'];
include './include/config.php';

$admission_select_query = "SELECT * FROM `tbl_admission` WHERE `admission_id`='$admission_id'";
$admission_result = mysqli_query($con, $admission_select_query);
$fetch_data = mysqli_fetch_array($admission_result);
//row fetch the from database 
$admission_form_no = $fetch_data['admission_form_no'];
$admission_no = $fetch_data['admission_no'];
$admission_title = $fetch_data['admission_title'];
$admission_first_name = $fetch_data['admission_first_name'];
$admission_middle_name = $fetch_data['admission_middle_name'];
$admission_last_name = $fetch_data['admission_last_name'];
$admission_course_name = $fetch_data['admission_course_name'];
$admission_session = $fetch_data['admission_session'];
$admission_dob = $fetch_data['admission_dob'];
$admission_nationality = $fetch_data['admission_nationality'];
$admission_aadhar_no = $fetch_data['admission_aadhar_no'];
$date_of_admission = $fetch_data['date_of_admission'];
$admission_category = $fetch_data['admission_category'];
$admission_gender = $fetch_data['admission_gender'];
$admission_username = $fetch_data['admission_username'];
$admission_password = $fetch_data['admission_password'];
$admission_blood_group = $fetch_data['admission_blood_group'];
$admission_hostel = $fetch_data['admission_hostel'];
$admission_transport = $fetch_data['admission_transport'];
$admission_profile_image = $fetch_data['admission_profile_image'];
$student_signature = $fetch_data['student_signature'];
$parent_signature = $fetch_data['parent_signature'];
$admission_residential_address = $fetch_data['admission_residential_address'];
$admission_state = $fetch_data['admission_state'];
$admission_city = $fetch_data['admission_city'];
$admission_district = $fetch_data['admission_district'];
$admission_pin_code  = $fetch_data['admission_pin_code'];
$admission_home_landlineno = $fetch_data['admission_home_landlineno'];
$admission_mobile_student = $fetch_data['admission_mobile_student'];
$admission_father_phoneno = $fetch_data['admission_father_phoneno'];
$admission_emailid_father = $fetch_data['admission_emailid_father'];
$admission_emailid_student = $fetch_data['admission_emailid_student'];
$admission_father_name = $fetch_data['admission_father_name'];
$admission_father_whatsappno = $fetch_data['admission_father_whatsappno'];
$admission_mother_name = $fetch_data['admission_mother_name'];
$admission_high_school_board_university  = $fetch_data['admission_high_school_board_university'];
$admission_high_school_college_name = $fetch_data['admission_high_school_college_name'];
$admission_high_school_passing_year = $fetch_data['admission_high_school_passing_year'];
$admission_high_school_per = $fetch_data['admission_high_school_per'];
$admission_high_school_subjects = $fetch_data['admission_high_school_subjects'];
$admission_intermediate_board_university = $fetch_data['admission_intermediate_board_university'];
$admission_intermediate_college_name = $fetch_data['admission_intermediate_college_name'];
$admission_intermediate_passing_year = $fetch_data['admission_intermediate_passing_year'];
$admission_intermediate_per = $fetch_data['admission_intermediate_per'];
$admission_intermediate_subjects = $fetch_data['admission_intermediate_subjects'];
$admission_graduation_board_university = $fetch_data['admission_graduation_board_university'];
$admission_graduation_college_name = $fetch_data['admission_graduation_college_name'];
$admission_graduation_passing_year = $fetch_data['admission_graduation_passing_year'];
$admission_graduation_per = $fetch_data['admission_graduation_per'];
$admission_graduation_subjects = $fetch_data['admission_graduation_subjects'];
$admission_post_graduation_board_university = $fetch_data['admission_post_graduation_board_university'];
$admission_post_graduation_college_name = $fetch_data['admission_post_graduation_college_name'];
$admission_post_graduation_others = $fetch_data['admission_post_graduation_others'];
$admission_post_graduation_per = $fetch_data['admission_post_graduation_per'];
$admission_post_graduation_subjects = $fetch_data['admission_post_graduation_subjects'];
$admission_others_board_university = $fetch_data['admission_others_board_university'];
$admission_others_college_name = $fetch_data['admission_others_college_name'];
$admission_others_passing_year = $fetch_data['admission_others_passing_year'];
$admission_others_per = $fetch_data['admission_others_per'];
$admission_others_subjects = $fetch_data['admission_others_subjects'];
 $admission_tenth_marksheet = $fetch_data['admission_tenth_marksheet'];

$admission_tenth_passing_certificate = $fetch_data['admission_tenth_passing_certificate'];
$admission_twelve_markesheet = $fetch_data['admission_twelve_markesheet'];
$admission_twelve_passing_certificate = $fetch_data['admission_twelve_passing_certificate'];
$admission_graduation_marksheet = $fetch_data['admission_graduation_marksheet'];
$admission_recent_character_certificate = $fetch_data['admission_recent_character_certificate'];
$admission_other_certificate = $fetch_data['admission_other_certificate'];
$admission_character_certificate = $fetch_data['admission_character_certificate'];
$admission_board_university1 = $fetch_data['admission_board_university1'];
$admission_year_of_passing1 = $fetch_data['admission_year_of_passing1'];
$admission_percentage1 = $fetch_data['admission_percentage1'];
$admission_course2 = $fetch_data['admission_course2'];
$admission_board_university2 = $fetch_data['admission_board_university2'];
$admission_year_of_passing2 = $fetch_data['admission_year_of_passing2'];
$admission_percentage2 = $fetch_data['admission_percentage2'];
$admission_course3 = $fetch_data['admission_course3'];
$admission_board_university3 = $fetch_data['admission_board_university3'];
$admission_year_of_passing3 = $fetch_data['admission_year_of_passing3'];
$admission_percentage3 = $fetch_data['admission_percentage3'];
$admission_course4 = $fetch_data['admission_course4'];
$admission_board_university4 = $fetch_data['admission_board_university4'];
$admission_year_of_passing4 = $fetch_data['admission_year_of_passing4'];
$admission_percentage4 = $fetch_data['admission_percentage4'];
$admission_course5 = $fetch_data['admission_course5'];
$admission_board_university5  = $fetch_data['admission_board_university5'];
$admission_year_of_passing5 = $fetch_data['admission_year_of_passing5'];
$admission_percentage5 = $fetch_data['admission_percentage5'];
$admission_name_of_org1  = $fetch_data['admission_name_of_org1'];
$admission_designation1 = $fetch_data['admission_designation1'];
$admission_duration1 = $fetch_data['admission_duration1'];
$post_at = $fetch_data['post_at'];
$datetime  = $fetch_data['date&time'];
$type = $fetch_data['type'];
$approval = $fetch_data['approval'];
$transactionid = $fetch_data['transactionid'];
$easebuzzid = $fetch_data['easebuzzid'];
$status = $fetch_data['status'];
$stud_status = $fetch_data['stud_status'];
$prospectus_number_query = "SELECT `prospectus_no` FROM `tbl_prospectus` WHERE prospectus_emailid='$admission_emailid_student'";
$prospectus_number_result = mysqli_query($con, $prospectus_number_query);
$prospectus_number_data = mysqli_fetch_array($prospectus_number_result);
$prospectus_number = $prospectus_number_data['prospectus_no'];

include "include/authentication.php";
?>
<!-- here t i have to reiciving the registration number and admission number -->
<?php
$sel = mysqli_query($con, " SELECT MAX(admission_id) as id  FROM tbl_admission");
$result = mysqli_fetch_array($sel);
$max_value = $result['id'] + 1;
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SRINATH UNIVERSITY | Admission Form </title>
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
              <h1>Admission Form</h1>
            </div>
            <div class="col-sm-6">
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
            <div class="card-header">
              <h3 class="card-title">Admission Form</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                    class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                    class="fas fa-remove"></i></button>
              </div>
            </div>

            <form method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12" id="error_section"></div>
                  <div class="col-4">


                    <label>Registration No</label>
                    <input type="text" name="add_admission_id" value="<?php echo $max_value; ?>" class="form-control">

                  </div>
                  <div class="col-4">
                    <label>Enter Prospectus No</label>
                    <input disabled id="form_no" type="text" name="add_admission_form_no" class="form-control"
                      value="<?php echo $prospectus_number; ?>" required>
                  </div>
                  <div class="col-4">
                    <label>Admission No</label>
                    <input type="text" name="add_admission_no" class="form-control"
                      value="<?php echo 'SU/' . $admission_course_name . '/' . trim($admission_session) . '/' . $max_value ?>"
                      readonly placeholder="Generate By University">
                  </div>

                  <div class="col-4">
                    <label>Title</label>
                    <select name="add_admission_title" class="form-control">
                      <?php if ($admission_title != '') { ?>
                      <option value="<?php echo $admission_title ?>"><?php echo $admission_title; ?></option>
                      <?php } else { ?>
                      <option value="0">Select</option>
                      <?php } ?>
                      <option value="Master">Master</option>
                      <option value="Miss">Miss</option>
                      <option value="Mr">Mr</option>
                      <option value="Mrs">Mrs</option>
                    </select>
                  </div>

                  <div class="col-4">
                    <label> Name</label>
                    <input id="first_name" type="text" name="add_admission_first_name" class="form-control"
                      value="<?php echo $admission_first_name; ?>" required>
                  </div>



                  <div class="col-4">
                    <label>Course</label>
                    <select id="course" name="add_admission_course_name" class="form-control" required>
                      <?php if ($admission_course_name != '') { ?>
                      <option value="<?php echo $admission_course_name; ?>"><?php echo $admission_course_name ?>
                      </option>
                      <?php } else { ?>
                      <option value="">-Select-</option>
                      <?php   } ?>
                      <?php
                      $sql = "select * from tbl_course";
                      $query = mysqli_query($con, $sql);
                      while ($row = mysqli_fetch_array($query)) {
                      ?>
                      <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>



                  <div class="col-4">
                    <label>Session</label>
                    <select id="session_check" class="form-control" name="add_admission_session">
                      <?php if ($admission_session != '') { ?>
                      <option value=" <?php echo $admission_session ?>" selected><?php echo $admission_session; ?>
                      </option>
                      <?php } else {

                      ?>
                      <option value=" " selected disabled="">-Select-</option>
                      <?php } ?>
                      <option value="<?php echo date('Y');
                                      echo " - ";
                                      echo date('Y', strtotime('+3 year')); ?>">
                        <?php echo date('Y');
                                                                                echo " - ";
                                                                                echo date('Y', strtotime('+3 year')); ?>
                      </option>
                      <option value="<?php echo date('Y');
                                      echo " - ";
                                      echo date('Y', strtotime('+4 year')); ?>">
                        <?php echo date('Y');
                                                                                echo " - ";
                                                                                echo date('Y', strtotime('+4 year')); ?>
                      </option>
                    </select>
                  </div>
                  <div class="col-4">
                    <label>Date Of Birth</label>
                    <input id="dob" type="date" name="add_admission_dob" class="form-control"
                      value="<?php echo  date("Y-m-d", strtotime(str_replace('/', '-', $admission_dob)));   ?>"
                      required>
                  </div>

                  <div class="col-4">
                    <label>Nationality</label>
                    <input type="text" name="add_admission_nationality" class="form-control"
                      value="<?php echo $admission_nationality; ?>">
                  </div>
                  <div class="col-4">
                    <label>Aadhar No</label>
                    <input type="text" name="add_admission_aadhar_no" class="form-control"
                      value="<?php echo $admission_aadhar_no; ?>">
                  </div>

                  <div class="col-4">
                    <label>Date Of Admission</label>
                    <input type="date" name="add_date_of_admission" class="form-control"
                      value="<?php echo date("Y-m-d"); ?>">
                  </div>
                  <div class="col-4">
                    <label>Category</label>
                    <select name="add_admission_category" class="form-control">
                      <?php if ($admission_category != '0') { ?>
                      <option selected value="<?php echo $admission_category ?>"> <?php echo $admission_category; ?>
                      </option>
                      <?php } else { ?>
                      <option selected disabled>Select</option>
                      <?php } ?>
                      <option value="General">General</option>
                      <option value="SC">SC</option>
                      <option value="ST">ST</option>
                      <option value="OBC">OBC</option>
                    </select>
                  </div>
                  <div class="col-4">
                    <label>Gender</label>
                    <select id="gender" name="add_admission_gender" class="form-control">
                      <?php if ($admission_gender != '') { ?>
                      <option selected value="<?php echo $admission_gender ?>"> <?php echo $admission_gender; ?>
                      </option>
                      <?php } else { ?>
                      <option selected disabled>Select</option>
                      <?php } ?>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>


                  <div class="col-md-4">
                    <label>Username</label>
                    <input type="text" name="add_admission_username" class="form-control"
                      value="<?php echo $admission_username ?>" required>
                  </div>
                  <div class="col-4">
                    <label>Password</label>
                    <input type="password" name="add_admission_password" class="form-control" disabled
                      value="<?php echo $admission_password ?>">
                  </div>
                  <div class="col-4">
                    <label>Blood Group</label>
                    <input type="text" name="add_admission_blood_group" class="form-control"
                      value="<?php echo $admission_blood_group; ?>">
                  </div>

                  <div class="col-4">
                    <label>Hostel</label>
                    <select name="add_admission_hostel" class="form-control">
                      <?php if ($admission_hostel != '') { ?>
                      <option selected value="<?php echo $admission_hostel ?>"> <?php echo $admission_hostel; ?>
                      </option>
                      <?php } else { ?>
                      <option selected disabled>Select</option>
                      <?php } ?>
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                    </select>
                  </div>
                  <div class="col-4">
                    <label>Transport</label>
                    <select name="add_admission_transport" class="form-control">
                      <?php if ($admission_transport != '') { ?>
                      <option selected value="<?php echo $admission_transport ?>"> <?php echo $admission_transport; ?>
                      </option>
                      <?php } else { ?>
                      <option selected disabled>Select</option>
                      <?php } ?>
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                    </select>
                  </div>


                  <div class="col-4">
                    <label>Image</label>
                    <input type="file" name="add_admission_profile_image" id="add_admission_profile_image"
                      class="form-control">
                  </div>
                  <?php if ($admission_profile_image != '') { ?>
                  <div class="col-4">
                    <img src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_profile_image) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">
                  </div>
                  <?php } else { ?>

                  <div class="col-4">
                    <img src="http://www.clipartpanda.com/clipart_images/user-66327738/download" id="photoBrowser"
                      style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120" height="120">
                  </div>
                  <?php } ?>



                </div>
              </div>
          </div>

          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">PRESENT ADDRESS</h3>
            </div>

            <div class="card-body table-responsive p-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-4">
                    <label>Residential Address</label>
                    <textarea id="address" name="add_admission_residential_address" class="form-control"
                      style="height: 38px;"> <?php echo $admission_residential_address ?></textarea>
                  </div>
                  <div class="col-4">
                    <label>State</label>
                    <input id="state" type="text" name="add_admission_state" value="<?php echo $admission_state; ?>"
                      class="form-control">
                  </div>
                  <div class="col-4">
                    <label>City</label>
                    <input id="city" type="text" value="<?php echo $admission_city ?>" name="add_admission_city"
                      class="form-control">
                  </div>
                  <div class="col-4">
                    <label>District</label>
                    <input type="text" value="<?php echo $admission_district; ?>" name="add_admission_district"
                      class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Pin Code</label>
                    <input id="postal_code" value="<?php echo $admission_pin_code ?>" type="text"
                      name="add_admission_pin_code" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Home Landline no.</label>
                    <input type="text" name="add_admission_home_landlineno"
                      value="<?php echo $admission_home_landlineno ?>" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Mobile No. (Student)</label>
                    <input id="mobile_no" type="text" value="<?php echo $admission_mobile_student; ?>"
                      name="add_admission_mobile_student" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Father Phone No.</label>
                    <input type="text" value="<?php echo $admission_father_phoneno ?>"
                      name="add_admission_father_phoneno" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Email Id (Father)</label>
                    <input type="email" value="<?php echo $admission_emailid_father ?>"
                      name="add_admission_emailid_father" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Email Id (Student)</label>
                    <input id="email_id" type="email" value="<?php echo $admission_emailid_student; ?>"
                      name="add_admission_emailid_student" class="form-control">
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Parent Details</h3>
            </div>

            <div class="card-body table-responsive p-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-4">
                    <label>Father Name</label>
                    <input id="father_name" value="<?php echo $admission_father_name ?>" type="text"
                      name="add_admission_father_name" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Father Whatsapp No</label>
                    <input type="text" value="<?php echo $admission_father_whatsappno ?>"
                      name="add_admission_father_whatsappno" class="form-control">
                  </div>
                  <div class="col-4">
                    <label>Mother Name</label>
                    <input id="mother_name" value="<?php echo $admission_mother_name ?>" type="text"
                      name="add_admission_mother_name" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Academic Details</h3>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Qualification</th>
                    <th>Board/University</th>
                    <th>School/College Name</th>
                    <th>Year Of Passing</th>
                    <th>Percentage or CGPA</th>
                    <th>Subjects</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>High School</td>
                    <td><input type="text" name="add_admission_high_school_board_university" size="15"
                        value="<?php echo $admission_high_school_board_university; ?>"></td>
                    <td><input type="text" name="add_admission_high_school_college_name" size="15"
                        value="<?php echo $admission_high_school_college_name ?>"></td>
                    <td><input type="text" name="add_admission_high_school_passing_year" size="15"
                        value="<?php echo $admission_high_school_passing_year ?>"></td>
                    <td><input type="text" name="add_admission_high_school_per" size="15"
                        value="<?php echo $admission_high_school_per ?>"></td>
                    <td><input type="text" name="add_admission_high_school_subjects" size="15"
                        value="<?php echo $admission_high_school_subjects ?>"></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Intermediate</td>
                    <td><input type="text" name="add_admission_intermediate_board_university" size="15"
                        value="<?php echo $admission_intermediate_board_university ?>"></td>
                    <td><input type="text" name="add_admission_intermediate_college_name" size="15"
                        value="<?php echo $admission_intermediate_college_name ?>"></td>
                    <td><input type="text" name="add_admission_intermediate_passing_year" size="15"
                        value="<?php echo $admission_intermediate_passing_year ?>"></td>
                    <td><input type="text" name="add_admission_intermediate_per" size="15"
                        value="<?php echo $admission_intermediate_per ?>"></td>
                    <td><input type="text" name="add_admission_intermediate_subjects" size="15"
                        value="<?php echo $admission_intermediate_subjects ?>"></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Graduation</td>
                    <td><input type="text" name="add_admission_graduation_board_university" size="15"
                        value="<?php echo $admission_graduation_board_university ?>"></td>
                    <td><input type="text" name="add_admission_graduation_college_name" size="15"
                        value="<?php echo $admission_graduation_college_name ?>"></td>
                    <td><input type="text" name="add_admission_graduation_passing_year" size="15"
                        value="<?php echo $admission_graduation_passing_year ?>"></td>
                    <td><input type="text" name="add_admission_graduation_per" size="15"
                        value="<?php echo $admission_graduation_per ?>"></td>
                    <td><input type="text" name="add_admission_graduation_subjects" size="15"
                        value="<?php echo $admission_graduation_subjects ?>"></td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Post Graduation</td>
                    <td><input type="text" name="add_admission_post_graduation_board_university" size="15"
                        value="<?php echo $admission_post_graduation_board_university ?>"></td>
                    <td><input type="text" name="add_admission_post_graduation_college_name" size="15"
                        value="<?php echo $admission_post_graduation_college_name ?>"></td>
                    <td><input type="text" name="add_admission_post_graduation_others" size="15"
                        value="<?php echo $admission_post_graduation_others ?>"></td>
                    <td><input type="text" name="add_admission_post_graduation_per" size="15"
                        value="<?php echo $admission_post_graduation_per ?>"></td>
                    <td><input type="text" name="add_admission_post_graduation_subjects" size="15"
                        value="<?php echo $admission_post_graduation_subjects ?>"></td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Others</td>
                    <td><input type="text" name="add_admission_others_board_university" size="15"
                        value="<?php echo $admission_others_board_university ?>"></td>
                    <td><input type="text" name="add_admission_others_college_name" size="15"
                        value="<?php echo $admission_others_college_name ?>"></td>
                    <td><input type="text" name="add_admission_others_passing_year" size="15"
                        value="<?php echo $admission_others_passing_year ?>"></td>
                    <td><input type="text" name="add_admission_others_per" size="15"
                        value="<?php echo $admission_others_per ?>"></td>
                    <td><input type="text" name="add_admission_others_subjects" size="15"
                        value="<?php echo $admission_others_subjects ?>"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>


          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Documents Required For Admission</h3>
            </div>

            <div class="card-body table-responsive p-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-4">
                    <label>10th Marksheet</label>
                    <input type="file" name="add_admission_tenth_marksheet" class="form-control">
                    <img
                      src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_tenth_marksheet) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">
                  </div>
                  <div class="col-4">
                    <label>10th Passing Certificate</label>
                    <input type="file" name="add_admission_tenth_passing_certificate" class="form-control">
                    <img
                      src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_tenth_passing_certificate) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">
                  </div>
                  <div class="col-4">
                    <label>12th Marksheet</label>
                    <input type="file" name="add_admission_twelve_markesheet" class="form-control">
                    <img
                      src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_twelve_markesheet) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">
                  </div>

                  <div class="col-4">
                    <label>12th Passing Certificate</label>
                    <input type="file" name="add_admission_twelve_passing_certificate" class="form-control">
                    <img
                      src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_twelve_passing_certificate) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">
                  </div>
                  <div class="col-4">
                    <label>Graduation Marksheet</label>
                    <input type="file" name="add_admission_graduation_marksheet" class="form-control">
                    <img
                      src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_graduation_marksheet) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">

                  </div>
                  <div class="col-4">
                    <label>Recent Character Certificate</label>
                    <input type="file" name="add_admission_recent_character_certificate" class="form-control">
                    <img
                      src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_recent_character_certificate) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">

                  </div>

                  <div class="col-4">
                    <label>Other Certificate (If applicable)</label>
                    <input type="file" name="add_admission_other_certificate" class="form-control">
                    <img
                      src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_other_certificate) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">

                  </div>
                  <div class="col-4">
                    <label>Character Certificate (If applicable)</label>
                    <input type="file" name="add_admission_character_certificate" class="form-control">
                    <img
                      src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($admission_character_certificate) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">

                  </div>
                  <div class="col-4">
                    <label> Student Signature </label>
                    <input type="file" name="student_signature" class="form-control">
                    <img src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($student_signature) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">

                  </div>
                  <div class="col-4">
                    <label>Parent Signature </label>
                    <input type="file" name="parent_signature" class="form-control">
                    <img src=<?php echo  ' "data:image/jpeg;base64,' . base64_encode($parent_signature) . '" ' ?>
                      id="photoBrowser" style="margin-top:17px;margin-left:4px;border:solid 1px lightgray" width="120"
                      height="120">

                  </div>


                </div>
              </div>
            </div>
          </div>

          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">TECHNICAL QUALIFICATION (IF ANY)</h3>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Course</th>
                    <th>Board / University</th>
                    <th>Year Of Passing</th>
                    <th>Percentage or CGPA</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td><input type="text" name="add_admission_course1" size="15" value=""></td>
                    <td><input type="text" name="add_admission_board_university1" size="15" value=""></td>
                    <td><input type="text" name="add_admission_year_of_passing1" size="15" value=""></td>
                    <td><input type="text" name="add_admission_percentage1" size="15" value=""></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td><input type="text" name="add_admission_course2" size="15"
                        value="<?php echo $admission_course2 ?>"></td>
                    <td><input type="text" name="add_admission_board_university2" size="15"
                        value="<?php echo $admission_board_university2 ?>"></td>
                    <td><input type="text" name="add_admission_year_of_passing2" size="15"
                        value="<?php echo $admission_year_of_passing2 ?>"></td>
                    <td><input type="text" name="add_admission_percentage2" size="15"
                        value="<?php echo $admission_percentage2 ?>"></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td><input type="text" name="add_admission_course3" size="15"
                        value="<?php echo $admission_course3 ?>"></td>
                    <td><input type="text" name="add_admission_board_university3" size="15"
                        value="<?php echo $admission_board_university3 ?>"></td>
                    <td><input type="text" name="add_admission_year_of_passing3" size="15"
                        value="<?php echo $admission_year_of_passing3 ?>"></td>
                    <td><input type="text" name="add_admission_percentage3" size="15"
                        value="<?php echo $admission_percentage3 ?>"></td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td><input type="text" name="add_admission_course4" size="15"
                        value="<?php echo $admission_course4 ?>"></td>
                    <td><input type="text" name="add_admission_board_university4" size="15"
                        value="<?php echo $admission_board_university4 ?>"></td>
                    <td><input type="text" name="add_admission_year_of_passing4" size="15"
                        value="<?php echo $admission_year_of_passing4 ?>"></td>
                    <td><input type="text" name="add_admission_percentage4" size="15"
                        value="<?php echo $admission_percentage4 ?>"></td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td><input type="text" name="add_admission_course5" size="15"
                        value="<?php echo $admission_course5 ?>"></td>
                    <td><input type="text" name="add_admission_board_university5" size="15"
                        value="<?php echo $admission_board_university5 ?>"></td>
                    <td><input type="text" name="add_admission_year_of_passing5" size="15"
                        value="<?php echo $admission_year_of_passing5 ?>"></td>
                    <td><input type="text" name="add_admission_percentage5" size="15"
                        value="<?php echo $admission_percentage5 ?>"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title"> WORK EXPERIENCE (IF ANY)</h3>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Name of organisation</th>
                    <th>Designation</th>
                    <th>Duration</th>

                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td><input type="text" name="add_admission_name_of_org1" size="15"
                        value="<?php echo $admission_name_of_org1 ?>"></td>
                    <td><input type="text" name="add_admission_designation1" size="15"
                        value="<?php echo $admission_designation1 ?>"></td>
                    <td><input type="text" name="add_admission_duration1" size="15"
                        value="<?php echo $admission_duration1 ?>"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div id="loader_section"></div>
          </div>
          <div class="col-md-6">


            <button type="submit" name="submit" id="add_admission_button" class="btn btn-primary">Submit</button>



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
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
      })
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
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
              'month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
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

      $('.my-colorpicker2').on('colorpickerChange', function (event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
      });

      $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });

    })
  </script>
  <script>
    $(document).ready(function () {
      $('#form_no').on('keyup', function (event) {
        $.ajax({
          url: 'include/view.php?action=fetch_prospectus_info',
          type: 'POST',
          data: $('#add_admission_form').serializeArray(),
          success: function (result) {
            $('#first_name').val('');
            $('#last_name').val('');
            $('#gender').val('0');
            $('#father_name').val('');
            $('#address').val('');
            $('#country').val('');
            $('#state').val('');
            $('#city').val('');
            $('#postal_code').val('');
            $('#email_id').val('');
            $('#dob').val('');
            $('#mobile_no').val('');
            $('#course').val('0');
            if (result != "") {
              var fullinfo = result.split('|||');
              $('#first_name').val(fullinfo[0]);
              $('#last_name').val(fullinfo[1]);
              $('#gender').val(fullinfo[2]);
              $('#father_name').val(fullinfo[3]);
              $('#address').val(fullinfo[4]);
              $('#country').val(fullinfo[5]);
              $('#state').val(fullinfo[6]);
              $('#city').val(fullinfo[7]);
              $('#postal_code').val(fullinfo[8]);
              $('#email_id').val(fullinfo[9]);
              $('#dob').val(fullinfo[10]);
              $('#mobile_no').val(fullinfo[11]);
              $('#course').val(Number(fullinfo[12]));
              $('#session_check').val(Number(fullinfo[13]));
              $('#mother_name').val(fullinfo[14]);
            }
          }
        });
        event.preventDefault();
      });
    });
  </script>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  // echo "<pre>";
  // print_r($_POST);
  $admission_no = trim($_POST['add_admission_no']);
  $admission_title = $_POST['add_admission_title'];
  $admission_first_name = $_POST['add_admission_first_name'];
  // $admission_middle_name = $_POST['admission_middle_name'];
  // $admission_last_name = $_POST['admission_last_name'];
  $admission_course_name = $_POST['add_admission_course_name'];
  $admission_session = $_POST['add_admission_session'];
  $admission_dob = $_POST['add_admission_dob'];
  $admission_nationality = $_POST['add_admission_nationality'];
  $admission_aadhar_no = $_POST['add_admission_aadhar_no'];
  $date_of_admission = $_POST['add_date_of_admission'];
  $admission_category = $_POST['add_admission_category'];
  $admission_gender = $_POST['add_admission_gender'];
  $admission_username = $_POST['add_admission_username'];
  $admission_password = $_POST['add_admission_password'];
  $admission_blood_group = $_POST['add_admission_blood_group'];
  $admission_hostel = $_POST['add_admission_hostel'];
  $admission_transport = $_POST['add_admission_transport'];

  $admission_residential_address = $_POST['add_admission_residential_address'];
  $admission_state = $_POST['add_admission_state'];
  $admission_city = $_POST['add_admission_city'];
  $admission_district = $_POST['add_admission_district'];
  $admission_pin_code  = $_POST['add_admission_pin_code'];
  $admission_home_landlineno = $_POST['add_admission_home_landlineno'];
  $admission_mobile_student = $_POST['add_admission_mobile_student'];
  $admission_father_phoneno = $_POST['add_admission_father_phoneno'];
  $admission_emailid_father = $_POST['add_admission_emailid_father'];
  $admission_emailid_student = $_POST['add_admission_emailid_student'];
  $admission_father_name = $_POST['add_admission_father_name'];
  $admission_father_whatsappno = $_POST['add_admission_father_whatsappno'];
  $admission_mother_name = $_POST['add_admission_mother_name'];
  $admission_high_school_board_university  = $_POST['add_admission_high_school_board_university'];
  $admission_high_school_college_name = $_POST['add_admission_high_school_college_name'];
  $admission_high_school_passing_year = $_POST['add_admission_high_school_passing_year'];
  $admission_high_school_per = $_POST['add_admission_high_school_per'];
  $admission_high_school_subjects = $_POST['add_admission_high_school_subjects'];
  $admission_intermediate_board_university = $_POST['add_admission_intermediate_board_university'];
  $admission_intermediate_college_name = $_POST['add_admission_intermediate_college_name'];
  $admission_intermediate_passing_year = $_POST['add_admission_intermediate_passing_year'];
  $admission_intermediate_per = $_POST['add_admission_intermediate_per'];
  $admission_intermediate_subjects = $_POST['add_admission_intermediate_subjects'];
  $admission_graduation_board_university = $_POST['add_admission_graduation_board_university'];
  $admission_graduation_college_name = $_POST['add_admission_graduation_college_name'];
  $admission_graduation_passing_year = $_POST['add_admission_graduation_passing_year'];
  $admission_graduation_per = $_POST['add_admission_graduation_per'];
  $admission_graduation_subjects = $_POST['add_admission_graduation_subjects'];
  $admission_post_graduation_board_university = $_POST['add_admission_post_graduation_board_university'];
  $admission_post_graduation_college_name = $_POST['add_admission_post_graduation_college_name'];
  $admission_post_graduation_others = $_POST['add_admission_post_graduation_others'];
  $admission_post_graduation_per = $_POST['add_admission_post_graduation_per'];
  $admission_post_graduation_subjects = $_POST['add_admission_post_graduation_subjects'];
  $admission_others_board_university = $_POST['add_admission_others_board_university'];
  $admission_others_college_name = $_POST['add_admission_others_college_name'];
  $admission_others_passing_year = $_POST['add_admission_others_passing_year'];
  $admission_others_per = $_POST['add_admission_others_per'];
  $admission_others_subjects = $_POST['add_admission_others_subjects'];

  $admission_board_university1 = $_POST['add_admission_board_university1'];
  $admission_year_of_passing1 = $_POST['add_admission_year_of_passing1'];
  $admission_percentage1 = $_POST['add_admission_percentage1'];
  $admission_course2 = $_POST['add_admission_course2'];
  $admission_board_university2 = $_POST['add_admission_board_university2'];
  $admission_year_of_passing2 = $_POST['add_admission_year_of_passing2'];
  $admission_percentage2 = $_POST['add_admission_percentage2'];
  $admission_course3 = $_POST['add_admission_course3'];
  $admission_board_university3 = $_POST['add_admission_board_university3'];
  $admission_year_of_passing3 = $_POST['add_admission_year_of_passing3'];
  $admission_percentage3 = $_POST['add_admission_percentage3'];
  $admission_course4 = $_POST['add_admission_course4'];
  $admission_board_university4 = $_POST['add_admission_board_university4'];
  $admission_year_of_passing4 = $_POST['add_admission_year_of_passing4'];
  $admission_percentage4 = $_POST['add_admission_percentage4'];
  $admission_course5 = $_POST['add_admission_course5'];
  $admission_board_university5  = $_POST['add_admission_board_university5'];
  $admission_year_of_passing5 = $_POST['add_admission_year_of_passing5'];
  $admission_percentage5 = $_POST['add_admission_percentage5'];
  $admission_name_of_org1  = $_POST['add_admission_name_of_org1'];
  $admission_designation1 = $_POST['add_admission_designation1'];
  $admission_duration1 = $_POST['add_admission_duration1'];
  $post_at = $_POST['post_at'];
  $datetime  = $_POST['date&time'];
  $type = $_POST['type'];
  $approval = $_POST['approval'];
  $transactionid = $_POST['transactionid'];
  $easebuzzid = $_POST['easebuzzid'];
  $status = $_POST['status'];
  $stud_status = $_POST['stud_status'];


  $update_admission_query = "UPDATE `tbl_admission` SET `admission_form_no`='$admission_form_no',`admission_no`='$admission_no',`admission_title`='$admission_title',`admission_first_name`='$admission_first_name',`admission_course_name`='$admission_course_name',`admission_session`='$admission_session',`admission_dob`='$admission_dob',`admission_nationality`='$admission_nationality',`admission_aadhar_no`='$admission_aadhar_no',`date_of_admission`='$date_of_admission',`admission_category`='$admission_category',`admission_gender`='$admission_gender',`admission_username`='$admission_username',`admission_password`='$admission_password',`admission_blood_group`='$admission_blood_group',`admission_hostel`='$admission_hostel',`admission_transport`='$admission_transport',`admission_residential_address`='$admission_residential_address',`admission_state`='$admission_state',`admission_city`='$admission_city',`admission_district`='$admission_district',`admission_pin_code`='$admission_pin_code',`admission_home_landlineno`='$admission_home_landlineno',`admission_mobile_student`='$admission_mobile_student',`admission_father_phoneno`='$admission_father_phoneno',`admission_emailid_father`='$admission_emailid_father',`admission_emailid_student`='$admission_emailid_student',`admission_father_name`='$admission_father_name',`admission_father_whatsappno`='$admission_father_whatsappno',`admission_mother_name`='$admission_mother_name',`admission_high_school_board_university`='$admission_high_school_board_university',`admission_high_school_college_name`='$admission_high_school_college_name',`admission_high_school_passing_year`='$admission_high_school_passing_year',`admission_high_school_per`='$admission_high_school_per',`admission_high_school_subjects`='$admission_high_school_subjects',`admission_intermediate_board_university`='$admission_intermediate_board_university',`admission_intermediate_college_name`='$admission_intermediate_college_name',`admission_intermediate_passing_year`='$admission_intermediate_passing_year',`admission_intermediate_per`='$admission_intermediate_per',`admission_intermediate_subjects`='$admission_intermediate_subjects',`admission_graduation_board_university`='$admission_graduation_board_university',`admission_graduation_college_name`='$admission_graduation_college_name',`admission_graduation_passing_year`='$admission_graduation_passing_year',`admission_graduation_per`='$admission_graduation_per',`admission_graduation_subjects`='$admission_graduation_subjects',`admission_post_graduation_board_university`='$admission_post_graduation_board_university',`admission_post_graduation_college_name`='$admission_post_graduation_college_name',`admission_post_graduation_others`='$admission_post_graduation_others',`admission_post_graduation_per`='$admission_post_graduation_per',`admission_post_graduation_subjects`='$admission_post_graduation_subjects',`admission_others_board_university`='$admission_others_board_university',`admission_others_college_name`='$admission_others_college_name',`admission_others_passing_year`='$admission_others_passing_year',`admission_others_per`='$admission_others_per',`admission_others_subjects`='$admission_others_subjects',`admission_course1`='$admission_course_name',`admission_board_university1`='$admission_board_university1',`admission_year_of_passing1`='$admission_year_of_passing1',`admission_percentage1`='$admission_percentage1',`admission_course2`='$admission_course2',`admission_board_university2`='$admission_board_university2',`admission_year_of_passing2`='$admission_year_of_passing2',`admission_percentage2`='$admission_percentage2',`admission_course3`='$admission_course3',`admission_board_university3`='$admission_board_university3',`admission_year_of_passing3`='$admission_year_of_passing3',`admission_percentage3`='$admission_percentage3',`admission_course4`='$admission_course4',`admission_board_university4`='$admission_board_university4',`admission_year_of_passing4`='$admission_year_of_passing4',`admission_percentage4`='$admission_percentage4',`admission_course5`='$admission_course5',`admission_board_university5`='$admission_board_university5',`admission_year_of_passing5`='$admission_year_of_passing5',`admission_percentage5`='$admission_percentage5',`admission_name_of_org1`='$admission_name_of_org1',`admission_designation1`='$admission_designation1',`admission_duration1`='$admission_duration1' WHERE `admission_id`='$admission_id'";
  $update_admission_result = mysqli_query($con, $update_admission_query);
  
  if ($update_admission_result) {
 
    $msg= "Data updated successfully";
}
else{
  echo "sonthing went wrong";
}
// image update

if(!empty($_FILES['add_admission_profile_image']['tmp_name'])){
 $add_admission_profile_image =addslashes(file_get_contents($_FILES['add_admission_profile_image']['tmp_name'])); 


  $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_profile_image`='$add_admission_profile_image',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
$update_admission_result1 = mysqli_query($con, $update_admission_query1);
if ($update_admission_result1) {
$msg="data update succesfully";
}
else{
echo "data not be updated";
}
}
if(!empty($_FILES['add_admission_profile_image']['tmp_name'])){
  $add_admission_profile_image =addslashes(file_get_contents($_FILES['add_admission_profile_image']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_profile_image`='$add_admission_profile_image',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }
 if(!empty($_FILES['add_admission_profile_image']['tmp_name'])){
  $add_admission_profile_image =addslashes(file_get_contents($_FILES['add_admission_profile_image']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_profile_image`='$add_admission_profile_image',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }
 if(!empty($_FILES['add_admission_profile_image']['tmp_name'])){
  $add_admission_profile_image =addslashes(file_get_contents($_FILES['add_admission_profile_image']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_profile_image`='$add_admission_profile_image',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }
 if(!empty($_FILES['add_admission_profile_image']['tmp_name'])){
  $add_admission_profile_image =addslashes(file_get_contents($_FILES['add_admission_profile_image']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_tenth_passing_certificate`='$add_admission_profile_image',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }
 if(!empty($_FILES['add_admission_tenth_marksheet']['tmp_name'])){
  $add_admission_tenth_marksheet = addslashes(file_get_contents($_FILES['add_admission_tenth_marksheet']['tmp_name']));
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_tenth_marksheet`='$add_admission_tenth_marksheet',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }


 if(!empty($_FILES['add_admission_tenth_passing_certificate']['tmp_name'])){
 $add_admission_tenth_passing_certificate = addslashes(file_get_contents($_FILES['add_admission_tenth_passing_certificate']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_tenth_passing_certificate`='$add_admission_tenth_passing_certificate',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }
 if(!empty($_FILES['add_admission_twelve_markesheet']['tmp_name'])){
 $add_admission_twelve_markesheet = addslashes(file_get_contents($_FILES['add_admission_twelve_markesheet']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_twelve_markesheet`='$add_admission_twelve_markesheet',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }




 if(!empty($_FILES['add_admission_twelve_passing_certificate']['tmp_name'])){
 $add_admission_twelve_passing_certificate = addslashes(file_get_contents($_FILES['add_admission_twelve_passing_certificate']['tmp_name']));
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_twelve_passing_certificate`='$add_admission_twelve_passing_certificate',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }
 if(!empty($_FILES['add_admission_graduation_marksheet']['tmp_name'])){
$add_admission_graduation_marksheet = addslashes(file_get_contents($_FILES['add_admission_graduation_marksheet']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_graduation_marksheet`='$add_admission_graduation_marksheet',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }



 if(!empty($_FILES['add_admission_recent_character_certificate']['tmp_name'])){
  $add_admission_recent_character_certificate = addslashes(file_get_contents($_FILES['add_admission_recent_character_certificate']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_recent_character_certificate`='$add_admission_recent_character_certificate',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }
 if(!empty($_FILES['add_admission_other_certificate']['tmp_name'])){
$add_admission_other_certificate = addslashes(file_get_contents($_FILES['add_admission_other_certificate']['tmp_name']));
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_other_certificate`='$add_admission_other_certificate',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }


 if(!empty($_FILES['add_admission_character_certificate']['tmp_name'])){
  $add_admission_character_certificate = addslashes(file_get_contents($_FILES['add_admission_character_certificate']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `admission_character_certificate`='$add_admission_character_certificate',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }

 if(!empty($_FILES['student_signature']['tmp_name'])){
  $student_signature = addslashes(file_get_contents($_FILES['student_signature']['tmp_name'])); 
 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `student_signature`='$student_signature',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }



 if(!empty($_FILES['parent_signature']['tmp_name'])){
  $parent_signature = addslashes(file_get_contents($_FILES['parent_signature']['tmp_name'])); 
 
 $update_admission_query1 = "UPDATE `tbl_admission` SET `parent_signature`='$parent_signature',`admission_tenth_marksheet`='$add_admission_tenth_marksheet' where  `admission_id`='$admission_id'";
 $update_admission_result1 = mysqli_query($con, $update_admission_query1);
 if ($update_admission_result1) {
 $msg="data update succesfully";
 }
 else{
 echo "data not be updated";
 }
 }
echo $msg;

}

?>
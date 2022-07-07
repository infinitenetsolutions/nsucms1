<?php
if ($_GET["action"] == "fetch_student_list_details") {
    $course_id = $_POST["course_id"];
    $academic_year = $_POST["academic_year"];
    if ($academic_year != 0) {
?>
        <div class="card">
            <div class="card-header card-warning">
                <form method="POST" action="export-list">
                    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
                    <input type="hidden" name="academic_year" value="<?php echo $academic_year; ?>" />
                    <input type="hidden" name="action" value="export_student_details" />
                    <button type="submit" class="btn btn-warning pull-right float-right"><i class="fa fa-download"></i> Export All</button>
                </form>
            </div>
        </div>
        <table id="example1" class="table table-bordered table-striped table-responsive" style="overflow-x:auto;">
            <thead>
                <tr>
                    <th width="10%">S.No</th>
                    <th width="10%">Reg. No</th>
                    <th width="10%">Student Name</th>
                    <th width="10%">Course</th>
                    <th width="10%">Father Name</th>
                    <th width="10%">Mother Name</th>
                    <th width="10%">Student Contact No.</th>
                    <th width="10%">Father Contact No.</th>
                    <th width="10%">Father Whatsapp No.</th>
                    <th width="10%">DOB</th>
                    <th width="10%">Gender</th>
                    <!--<th width="10%">Mobile No.</th>-->
                    <th class="project-actions text-center">Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($course_id == "all")
                    $sql = "SELECT * FROM `tbl_admission`
                                WHERE `status` = '$visible' && `admission_session` = '$academic_year'
                                ORDER BY `admission_id` ASC
                                ";
                else
                    $sql = "SELECT * FROM `tbl_admission`
                                WHERE `status` = '$visible' && `admission_session` = '$academic_year' && `admission_course_name` = '$course_id'
                                ORDER BY `admission_id` ASC
                                ";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $orgDate = $row["admission_dob"];
                        $newDate = date("d-m-Y", strtotime($orgDate));
                ?>
                        <tr>
                            <td><?php echo $s_no; ?></td>
                            <?php
                            $sql_course = "SELECT * FROM `tbl_course`
                                                   WHERE `status` = '$visible' && `course_id` = '" . $row["admission_course_name"] . "';
                                                   ";
                            $result_course = $con->query($sql_course);
                            $row_course = $result_course->fetch_assoc();
                            ?>
                            <td><?php echo $row["admission_id"] ?></td>
                            <td><?php echo $row["admission_first_name"] ?> <?php echo $row["admission_middle_name"] ?> <?php echo $row["admission_last_name"] ?></td>
                            <td><?php echo $row_course["course_name"]; ?></td>
                            <td><?php echo $row["admission_father_name"] ?></td>
                            <td><?php echo $row["admission_mother_name"] ?></td>
                            <td><?php echo $row["admission_mobile_student"]; ?></td>
                            <td><?php echo $row["admission_father_phoneno"]; ?></td>
                            <td><?php echo $row["admission_father_whatsappno"]; ?></td>
                            <td><?php echo $newDate; ?></td>
                            <td><?php echo $row["admission_gender"]; ?></td>
                            <!--<td><?php //echo $row["admission_mobile_student"]; 
                                    ?></td>-->
                            <td class="project-actions text-center" id="row_id_<?= $row['admission_id'] ?>">
                                <button class="btn btn-info btn-sm" onclick="document.getElementById('view_student_lists<?php echo $row["admission_id"]; ?>').style.display='block'">
                                    <i class="fas fa-eye">
                                    </i>

                                </button>
                                <!--<button class="btn btn-info btn-sm" onclick="document.getElementById('edit_student_lists<?php echo $row["admission_id"]; ?>').style.display='block'">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </button>-->
                                <a href="edit_student?id=<?php echo $row['admission_id']; ?>"><button class="update btn btn-warning btn-sm"><i class="fas fa-pencil-alt">
                                        </i>
                                        </span></button></a>
                                <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='block'">
                                    <i class="fas fa-trash">
                                    </i>

                                </button>

                                <button onclick="update_status(<?= $row['admission_id'] ?>,<?= $row['stud_status'] ?>)" class="btn btn-<?= ($row['stud_status'] == 1 ? 'success' : 'danger') ?>"><?= ($row['stud_status'] == 1 ? 'Active' : 'Inactive') ?></button>
                            </td>

                            <!-- Fees Edit Section Start -->
                            <div id="edit_student_lists<?php echo $row["admission_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                    <header class="w3-container" style="background:#343a40; color:white;">
                                        <span onclick="document.getElementById('edit_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                        <h2 align="center">Edit Fee</h2>
                                    </header>
                                    <form id="edit_student_list_form<?php echo $row["admission_id"]; ?>" role="form" method="POST">
                                        <div class="card-body">
                                            <div class="col-md-12" id="edit_error_section<?php echo $row["admission_id"]; ?>"></div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Registration Number</label>
                                                        <input type="text" name="" id="edit_student_list_reg_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_id"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Admission Number</label>
                                                        <input type="text" name="" id="edit_student_list_admission_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_no"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Course Name</label>
                                                        <select name="" id="edit_student_list_course_name<?php echo $row["admission_id"]; ?>" class="form-control">
                                                            <?php
                                                            $sql_c = "SELECT * FROM `tbl_course`
                                                                                   WHERE `status` = '$visible';
                                                                                   ";
                                                            $result_c = $con->query($sql_c);
                                                            while ($row_c = $result_c->fetch_assoc()) {
                                                            ?>
                                                                <option value="<?php echo $row_c["course_id"]; ?>" <?php if ($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?>><?php echo $row_c["course_name"]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Session</label>
                                                        <select name="" id="edit_student_list_session<?php echo $row["admission_id"]; ?>" class="form-control">
                                                            <?php
                                                            $sql_c = "SELECT * FROM `tbl_university_details`
                                                                                   WHERE `status` = '$visible';
                                                                                   ";
                                                            $result_c = $con->query($sql_c);
                                                            while ($row_c = $result_c->fetch_assoc()) {
                                                            ?>
                                                                <option value="<?php echo $row_c["university_details_id"]; ?>" <?php if ($row_c["university_details_id"] == $row["admission_session"]) echo 'selected'; ?>><?php echo $row_c["university_details_academic_start_date"]; ?> to <?php echo $row_c["university_details_academic_end_date"]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input type="text" name="" id="edit_student_list_first_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_first_name"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input type="text" name="" id="edit_student_list_last_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_last_name"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Contact No</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_mobile_student"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" name="" id="edit_student_list_email<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_emailid_student"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Father's Name</label>
                                                        <input type="text" name="" id="edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_name"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Contact No</label>
                                                        <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_phoneno"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Hostel</label>
                                                        <select name="" id="edit_student_list_hostel<?php echo $row["admission_id"]; ?>" class="form-control">
                                                            <option <?php if ($row["admission_hostel"] == "Yes") echo "selected"; ?> value="Yes">Yes</option>
                                                            <option <?php if ($row["admission_hostel"] == "No") echo "selected"; ?> value="No">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Transport</label>
                                                        <select name="" id="edit_student_list_transport<?php echo $row["admission_id"]; ?>" class="form-control">
                                                            <option <?php if ($row["admission_transport"] == "Yes") echo "selected"; ?> value="Yes">Yes</option>
                                                            <option <?php if ($row["admission_transport"] == "No") echo "selected"; ?> value="No">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" name="" id="edit_student_list_username<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_username"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="text" name="" id="edit_student_list_password<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_password"]; ?>" />
                                                    </div>
                                                </div>

                                            </div>
                                            <input type='hidden' name='edit_admission_id' id="edit_admission_id<?php echo $row["admission_id"]; ?>" value='<?php echo $row["admission_id"]; ?>' />
                                            <input type='hidden' name='action' id="action_student<?php echo $row["admission_id"]; ?>" value='edit_student_lists' />
                                            <div class="col-md-12" id="edit_loader_section<?php echo $row["admission_id"]; ?>"></div>
                                            <button type="button" id="edit_student_list_button<?php echo $row["admission_id"]; ?>" class="btn btn-primary">Update</button>
                                            <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                        </div>
                                    </form>
                                    <script>
                                        function update_status(id, status) {
                                            //   alert('working');
                                            //   alert(id);
                                            //   alert(status); exit;
                                            $.ajax({
                                                type: "POST",
                                                url: 'include/controller.php',
                                                data: {
                                                    "action": "student_status_update",
                                                    "id": id,
                                                    "status": status
                                                },
                                                success: function(data) {
                                                    if (data == "success") {
                                                        $("#row_id_" + id).html(data);
                                                        //  $('#status_response').remove();
                                                        //     $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "status_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Status Updated successfully!!!</div></div>');

                                                    }

                                                }

                                            });
                                        }

                                        $(function() {

                                            $('#edit_student_list_button<?php echo $row["admission_id"]; ?>').click(function() {
                                                $('#edit_loader_section<?php echo $row["admission_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                                $('#edit_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', true);
                                                var action = $("#action_student<?php echo $row["admission_id"]; ?>").val();
                                                var edit_admission_id = $("#edit_admission_id<?php echo $row["admission_id"]; ?>").val();

                                                var edit_student_list_reg_no = $("#edit_student_list_reg_no<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_admission_no = $("#edit_student_list_admission_no<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_course_name = $("#edit_student_list_course_name<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_session = $("#edit_student_list_session<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_first_name = $("#edit_student_list_first_name<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_last_name = $("#edit_student_list_last_name<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_contact_no = $("#edit_student_list_contact_no<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_email = $("#edit_student_list_email<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_fathers_name = $("#edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_fathers_contact = $("#edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_hostel = $("#edit_student_list_hostel<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_transport = $("#edit_student_list_transport<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_username = $("#edit_student_list_username<?php echo $row["admission_id"]; ?>").val();
                                                var edit_student_list_password = $("#edit_student_list_password<?php echo $row["admission_id"]; ?>").val();

                                                var dataString = 'action=' + action + '&edit_admission_id=' + edit_admission_id + '&edit_student_list_reg_no=' + edit_student_list_reg_no + '&edit_student_list_admission_no=' + edit_student_list_admission_no + '&edit_student_list_course_name=' + edit_student_list_course_name + '&edit_student_list_session=' + edit_student_list_session + '&edit_student_list_first_name=' + edit_student_list_first_name + '&edit_student_list_last_name=' + edit_student_list_last_name + '&edit_student_list_contact_no=' + edit_student_list_contact_no + '&edit_student_list_email=' + edit_student_list_email + '&edit_student_list_fathers_name=' + edit_student_list_fathers_name + '&edit_student_list_fathers_contact=' + edit_student_list_fathers_contact + '&edit_student_list_hostel=' + edit_student_list_hostel + '&edit_student_list_transport=' + edit_student_list_transport + '&edit_student_list_username=' + edit_student_list_username + '&edit_student_list_password=' + edit_student_list_password;

                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: dataString,
                                                    success: function(result) {
                                                        console.log(result);
                                                        $('#edit_response').remove();
                                                        if (result == "exsits") {
                                                            $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Fee Details have already exsits!!!</div></div>');
                                                        }
                                                        if (result == "error") {
                                                            $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                        }
                                                        if (result == "empty") {
                                                            $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out required Fields!!!</div></div>');
                                                        }
                                                        if (result == "success") {
                                                            $('#edit_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Fee Details Updated successfully!!!</div></div>');
                                                            showUpdatedData();

                                                            function showUpdatedData() {
                                                                $.ajax({
                                                                    url: 'include/view.php?action=fetch_student_list_details',
                                                                    type: 'POST',
                                                                    data: $('#fetchStudentDataForm').serializeArray(),
                                                                    success: function(result) {
                                                                        $('#response').remove();
                                                                        $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                    }
                                                                });
                                                            }
                                                        }
                                                        $('#edit_loading').fadeOut(500, function() {
                                                            $(this).remove();
                                                        });
                                                        $('#edit_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', false);
                                                    }

                                                });

                                            });

                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- Fees Edit Section End -->

                            <!-- Student List view Section Start -->
                            <div id="view_student_lists<?php echo $row["admission_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                <div class="w3-modal-content w3-animate-top w3-card-4" style="width:70%">
                                    <header class="w3-container" style="background:#343a40; color:white;">
                                        <span onclick="document.getElementById('view_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                        <h2 align="center">Student Details</h2>
                                    </header>
                                    <form id="view_student_list_form<?php echo $row["admission_id"]; ?>" role="form" method="POST">
                                        <div class="card-body" style="margin-bottom: 50px;">
                                            <div class="col-md-12" id="edit_error_section<?php echo $row["admission_id"]; ?>"></div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Registration Number</label>
                                                        <input type="text" name="" id="edit_student_list_reg_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_id"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Prospectus Number</label>
                                                        <input type="text" name="" id="edit_student_list_reg_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_form_no"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Admission Number</label>
                                                        <input type="text" name="" id="edit_student_list_admission_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_no"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Course Name</label>
                                                        <select name="" id="edit_student_list_course_name<?php echo $row["admission_id"]; ?>" class="form-control" readonly>
                                                            <?php
                                                            $sql_c = "SELECT * FROM `tbl_course`
                                                                                   WHERE `status` = '$visible';
                                                                                   ";
                                                            $result_c = $con->query($sql_c);
                                                            while ($row_c = $result_c->fetch_assoc()) {
                                                            ?>
                                                                <option value="<?php echo $row_c["course_id"]; ?>" <?php if ($row_c["course_id"] == $row_course["course_id"]) echo 'selected'; ?>><?php echo $row_c["course_name"]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Session</label>
                                                        <select name="" id="edit_student_list_session<?php echo $row["admission_id"]; ?>" class="form-control" readonly>
                                                            <?php
                                                            $sql_c = "SELECT * FROM `tbl_university_details`
                                                                                   WHERE `status` = '$visible';
                                                                                   ";
                                                            $result_c = $con->query($sql_c);
                                                            while ($row_c = $result_c->fetch_assoc()) {
                                                            ?>
                                                                <option value="<?php echo $row_c["university_details_id"]; ?>" <?php if ($row_c["university_details_id"] == $row["admission_session"]) echo 'selected'; ?>><?php echo $row_c["university_details_academic_start_date"]; ?> to <?php echo $row_c["university_details_academic_end_date"]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Student Name</label>
                                                        <input type="text" name="" id="edit_student_list_first_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_first_name"]; ?>&nbsp;&nbsp;<?php echo $row["admission_middle_name"]; ?>&nbsp;&nbsp;<?php echo $row["admission_last_name"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>DOB</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_dob"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Nationality</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_nationality"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Adhar No</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_aadhar_no"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Date Of Admission</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["date_of_admission"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Category</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_category"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Gender</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_gender"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_username"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_password"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Blood Group</label>
                                                        <input type="text" name="" id="edit_student_list_contact_no<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_blood_group"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Hostel</label>
                                                        <input type="text" name="" id="edit_student_list_email<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_hostel"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Transport</label>
                                                        <input type="text" name="" id="edit_student_list_email<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_transport"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Image</label>
                                                        <img src="images/student_images/<?php echo $row["admission_profile_image"]; ?>" style="height:100%">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Student Contact No</label>
                                                        <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_mobile_student"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Student EmailID</label>
                                                        <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_emailid_student"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Father's Name</label>
                                                        <input type="text" name="" id="edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_name"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Father Contact No</label>
                                                        <input type="text" name="" id="edit_student_list_fathers_contact<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_father_phoneno"]; ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Mother's Name</label>
                                                        <input type="text" name="" id="edit_student_list_fathers_name<?php echo $row["admission_id"]; ?>" class="form-control" value="<?php echo $row["admission_mother_name"]; ?>" readonly />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <!-- student list view Section End -->

                            <!-- Fees delete Section Start -->
                            <div id="delete_student_lists<?php echo $row["admission_id"]; ?>" class="w3-modal" style="z-index:2020;">
                                <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                    <header class="w3-container" style="background:#343a40; color:white;">
                                        <span onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                        <h2 align="center">Are you sure???</h2>
                                    </header>
                                    <form id="delete_student_list_form<?php echo $row["admission_id"]; ?>" role="form" method="POST">
                                        <div class="card-body">
                                            <div class="col-md-12" id="delete_error_section<?php echo $row["admission_id"]; ?>"></div>
                                            <div class="col-md-12" align="center">
                                                <input type='hidden' name='delete_admission_id' id="delete_admission_id<?php echo $row["admission_id"]; ?>" value='<?php echo $row["admission_id"]; ?>' />
                                                <input type='hidden' name='action' id="action_delete<?php echo $row["admission_id"]; ?>" value='delete_student_lists' />
                                                <div class="col-md-12" id="delete_loader_section<?php echo $row["admission_id"]; ?>"></div>
                                                <button type="button" id="delete_student_list_button<?php echo $row["admission_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                <button type="button" onclick="document.getElementById('delete_student_lists<?php echo $row["admission_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        $(function() {
                                            $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').click(function() {
                                                $('#delete_loader_section<?php echo $row["admission_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', true);
                                                var action = $("#action_delete<?php echo $row["admission_id"]; ?>").val();
                                                var delete_admission_id = $("#delete_admission_id<?php echo $row["admission_id"]; ?>").val();
                                                var dataString = 'action=' + action + '&delete_admission_id=' + delete_admission_id;

                                                $.ajax({
                                                    url: 'include/controller.php',
                                                    type: 'POST',
                                                    data: dataString,
                                                    success: function(result) {
                                                        $('#delete_response').remove();
                                                        if (result == "error") {
                                                            $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                        }
                                                        if (result == "empty") {
                                                            $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                        }
                                                        if (result == "success") {
                                                            $('#delete_error_section<?php echo $row["admission_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Student Delete successfully!!!</div></div>');
                                                            showUpdatedData();

                                                            function showUpdatedData() {
                                                                $.ajax({
                                                                    url: 'include/view.php?action=fetch_student_list_details',
                                                                    type: 'POST',
                                                                    data: $('#fetchStudentDataForm').serializeArray(),
                                                                    success: function(result) {
                                                                        $('#response').remove();
                                                                        $('#data_table').append('<div id = "response">' + result + '</div>');
                                                                    }
                                                                });
                                                            }
                                                        }
                                                        console.log(result);
                                                        $('#delete_loading').fadeOut(500, function() {
                                                            $(this).remove();
                                                        });
                                                        $('#delete_student_list_button<?php echo $row["admission_id"]; ?>').prop('disabled', false);
                                                    }

                                                });
                                            });

                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- Fees delete Section End -->
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
<?php
    } else
        echo "0";
}

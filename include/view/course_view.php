<?php
//Courses Start
if ($_GET["action"] == "get_courses") {
?>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Course Name</th>
                <th>Prospectus Fee</th>
                <th>Course Duration</th>
                <th class="project-actions text-center">Action </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `tbl_course`
                                WHERE `status` = '$visible'
                                ORDER BY `course_id` ASC
                                ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $s_no; ?></td>
                        <td><?php echo $row["course_name"] ?></td>
                        <td><?php echo $row["prospectus_rate"] ?></td>
                        <td><?php echo $row["duration"] ?></td>
                        <td class="project-actions text-center">
                            <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_courses<?php echo $row["course_id"]; ?>').style.display='block'">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_courses<?php echo $row["course_id"]; ?>').style.display='block'">
                                <i class="fas fa-trash">
                                </i>
                                Delete
                            </button>
                        </td>


                        <!-- Courses Edit Section Start -->
                        <div id="edit_courses<?php echo $row["course_id"]; ?>" class="w3-modal" style="z-index:2020;">
                            <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                <header class="w3-container" style="background:#343a40; color:white;">
                                    <span onclick="document.getElementById('edit_courses<?php echo $row["course_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                    <h2 align="center">Edit Course</h2>
                                </header>
                                <form id="edit_course_form<?php echo $row["course_id"]; ?>" role="form" method="POST">
                                    <div class="card-body">
                                        <div class="col-md-12" id="edit_error_section<?php echo $row["course_id"]; ?>"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Course Name</label>
                                                    <input type="text" name="edit_course_name" id="edit_course_name<?php echo $row["course_id"]; ?>" class="form-control" value="<?php echo $row["course_name"]; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Prospectus Rate</label>
                                                    <input type="text" name="edit_prospectus_rate" id="edit_prospectus_rate<?php echo $row["course_id"]; ?>" class="form-control" value="<?php echo $row["prospectus_rate"]; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Course Duration</label>
                                                    <input type="number" name="edit_course_duration" id="edit_course_duration<?php echo $row["course_id"]; ?>" class="form-control" value="<?php echo $row["duration"]; ?>">
                                                </div>


                                                <div class="form-group">
                                                </div>
                                            </div>

                                        </div>
                                        <input type='hidden' name='edit_course_id' id="edit_course_id<?php echo $row["course_id"]; ?>" value='<?php echo $row["course_id"]; ?>' />
                                        <input type='hidden' name='action' id="action<?php echo $row["course_id"]; ?>" value='edit_courses' />
                                        <div class="col-md-12" id="edit_loader_section<?php echo $row["course_id"]; ?>"></div>
                                        <button type="button" id="edit_course_button<?php echo $row["course_id"]; ?>" class="btn btn-primary">Update</button>
                                        <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                    </div>
                                </form>
                                <script>
                                    $(function() {

                                        $('#edit_course_button<?php echo $row["course_id"]; ?>').click(function() {
                                            $('#edit_loader_section<?php echo $row["course_id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                                            $('#edit_course_button<?php echo $row["course_id"]; ?>').prop('disabled', true);
                                            var action = $("#action<?php echo $row["course_id"]; ?>").val();
                                            var edit_course_id = $("#edit_course_id<?php echo $row["course_id"]; ?>").val();
                                            var edit_course_name = $("#edit_course_name<?php echo $row["course_id"]; ?>").val();
                                            var edit_prospectus_rate = $("#edit_prospectus_rate<?php echo $row["course_id"]; ?>").val();
                                            var edit_course_duration = $("#edit_course_duration<?php echo $row["course_id"]; ?>").val();
                                            var dataString = 'action=' + action + '&edit_course_id=' + edit_course_id + '&edit_course_name=' + edit_course_name + '&edit_prospectus_rate=' + edit_prospectus_rate + '&edit_course_duration=' + edit_course_duration;

                                            $.ajax({
                                                url: 'include/controller.php',
                                                type: 'POST',
                                                data: dataString,
                                                success: function(result) {
                                                    $('#edit_response').remove();
                                                    if (result == "exsits") {
                                                        $('#edit_error_section<?php echo $row["course_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Course have already exsits!!!</div></div>');
                                                    }
                                                    if (result == "error") {
                                                        $('#edit_error_section<?php echo $row["course_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                    }
                                                    if (result == "empty") {
                                                        $('#edit_error_section<?php echo $row["course_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out Course Name!!!</div></div>');
                                                    }
                                                    if (result == "success") {
                                                        $('#edit_error_section<?php echo $row["course_id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Updated successfully!!!</div></div>');
                                                        showUpdatedData();

                                                        function showUpdatedData() {
                                                            $.ajax({
                                                                url: 'include/view.php?action=get_courses',
                                                                type: 'GET',
                                                                success: function(result) {
                                                                    $("#data_table").html(result);
                                                                }
                                                            });
                                                        }
                                                    }
                                                    $('#edit_loading').fadeOut(500, function() {
                                                        $(this).remove();
                                                    });
                                                    $('#edit_course_button<?php echo $row["course_id"]; ?>').prop('disabled', false);
                                                }

                                            });
                                        });

                                    });
                                </script>
                            </div>
                        </div>
                        <!-- Courses Edit Section End -->

                        <!-- Courses delete Section Start -->
                        <div id="delete_courses<?php echo $row["course_id"]; ?>" class="w3-modal" style="z-index:2020;">
                            <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                <header class="w3-container" style="background:#343a40; color:white;">
                                    <span onclick="document.getElementById('delete_courses<?php echo $row["course_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                    <h2 align="center">Are you sure???</h2>
                                </header>
                                <form id="delete_course_form<?php echo $row["course_id"]; ?>" role="form" method="POST">
                                    <div class="card-body">
                                        <div class="col-md-12" id="delete_error_section<?php echo $row["course_id"]; ?>"></div>
                                        <div class="col-md-12" align="center">
                                            <input type='hidden' name='delete_course_id' id="delete_course_id<?php echo $row["course_id"]; ?>" value='<?php echo $row["course_id"]; ?>' />
                                            <input type='hidden' name='action' id="action_delete<?php echo $row["course_id"]; ?>" value='delete_courses' />
                                            <div class="col-md-12" id="delete_loader_section<?php echo $row["course_id"]; ?>"></div>
                                            <button type="button" id="delete_course_button<?php echo $row["course_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                            <button type="button" onclick="document.getElementById('delete_courses<?php echo $row["course_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                        </div>

                                        <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                    </div>
                                </form>
                                <script>
                                    $(function() {

                                        $('#delete_course_button<?php echo $row["course_id"]; ?>').click(function() {
                                            $('#delete_loader_section<?php echo $row["course_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                            $('#delete_course_button<?php echo $row["course_id"]; ?>').prop('disabled', true);
                                            var action = $("#action_delete<?php echo $row["course_id"]; ?>").val();
                                            var delete_course_id = $("#delete_course_id<?php echo $row["course_id"]; ?>").val();
                                            var dataString = 'action=' + action + '&delete_course_id=' + delete_course_id;

                                            $.ajax({
                                                url: 'include/controller.php',
                                                type: 'POST',
                                                data: dataString,
                                                success: function(result) {
                                                    $('#delete_response').remove();
                                                    if (result == "error") {
                                                        $('#delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                    }
                                                    if (result == "empty") {
                                                        $('#delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                    }
                                                    if (result == "success") {
                                                        $('#delete_error_section<?php echo $row["course_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Delete successfully!!!</div></div>');
                                                        showDeletedData();

                                                        function showDeletedData() {
                                                            $.ajax({
                                                                url: 'include/view.php?action=get_courses',
                                                                type: 'GET',
                                                                success: function(result) {
                                                                    $("#data_table").html(result);
                                                                }
                                                            });
                                                        }
                                                    }
                                                    $('#delete_loading').fadeOut(500, function() {
                                                        $(this).remove();
                                                    });
                                                    $('#delete_course_button<?php echo $row["course_id"]; ?>').prop('disabled', false);
                                                }

                                            });
                                        });

                                    });
                                </script>
                            </div>
                        </div>
                        <!-- Courses delete Section End -->
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
}
        //Courses End
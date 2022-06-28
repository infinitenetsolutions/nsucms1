<?php
//Add Courses Start With Ajax
if ($_POST["action"] == "add_courses") {
    $add_course_name = $_POST["add_course_name"];
    $prospectus_fee = $_POST["prospectus_fee"];
    $course_duration = $_POST["course_duration"];
    if (!empty($add_course_name)) {
        $sql = "SELECT * FROM `tbl_course`
                WHERE `status` = '$visible' && `course_name` = '$add_course_name'
                ";
        $result = $con->query($sql);
        if ($result->num_rows > 0)
            echo '
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fas fa-exclamation-triangle"></i> This Course already exsits!!!
                </div>';
        else {
             $sql = "INSERT INTO `tbl_course`
                    (`course_id`, `course_name`,`prospectus_rate`,`duration`, `course_time`, `status`) 
                    VALUES 
                    (NULL,'$add_course_name','$prospectus_fee','$course_duration','$date_variable_today_month_year_with_timing','$visible')
                    ";
            if ($con->query($sql))
                echo '
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> Course added successfully!!!
                    </div>';
            else
                echo '
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-ban"></i> Something went wrong please try again!!!
                    </div>';
        }
    } else
        echo '
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-exclamation-triangle"></i>  Please fill out Course Name!!!
            </div>';
}
//Add Courses End With Ajax
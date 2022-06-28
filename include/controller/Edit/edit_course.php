<?php
//Edit Courses Start With Ajax
if($_POST["action"] == "edit_courses"){
    $edit_course_name = $_POST["edit_course_name"];
    $edit_prospectus_rate = $_POST["edit_prospectus_rate"];
    $edit_course_duration = $_POST["edit_course_duration"];
    $edit_course_id = $_POST["edit_course_id"];
   // print_R($_POST); exit; 
 /* if(!empty($edit_course_name && $edit_course_id)){
        $sql = "SELECT * FROM `tbl_course`
                WHERE `status` = '$visible' && `course_name` = '$edit_course_name';
                ";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            echo 'exsits'; 
        }
        else{ */
            $sql = "UPDATE `tbl_course` 
                    SET 
                    `course_name` = '$edit_course_name', `prospectus_rate` = '$edit_prospectus_rate',`duration` = '$edit_course_duration' , `course_time` = '$date_variable_today_month_year_with_timing' 
                    WHERE `status` = '$visible' && `course_id` = '$edit_course_id';
                    ";
            if($con->query($sql))
                echo 'success';
            else
                echo 'error';
       /*}
    } else
        echo 'empty'; */
}
//Edit Courses End With Ajax

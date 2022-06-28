<?php 


        //Delete Courses Start With Ajax
        if($_POST["action"] == "delete_courses"){
            $delete_course_id = $_POST["delete_course_id"];
            if(!empty($delete_course_id)){
                $sql = "UPDATE `tbl_course` 
                        SET 
                        `status` = '$trash', `course_time` = '$date_variable_today_month_year_with_timing' 
                        WHERE `status` = '$visible' && `course_id` = '$delete_course_id';
                        ";
                if($con->query($sql))
                    echo 'success';
                else
                    echo 'error';
            } else
                echo 'empty';
        }
        //Delete Courses End With Ajax
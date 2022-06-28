<?php 
 //Add Fee Start With Ajax
 if($_POST["action"] == "add_fees"){

   

$fee_type = $_POST["fee_type"];
$course_id = $_POST["course_id"];
$academic_year = $_POST["academic_year"];
$particulars = $_POST["particulars"];
$amount = $_POST["amount"];
$fine = $_POST["fine"];
$lastdate = $_POST["lastdate"];
$astatus = $_POST["astatus"];

//echo $fee_type;
//ADD FEE START
if($fee_type == 'Examination Fee'){

if(!empty($fee_type && $course_id && $academic_year) && $particulars[0] != "" && $amount[0] != "" && $fine[0] != "" && $lastdate[0] != "" && $astatus[0] != ""){
    $allParticulars = count($particulars);
    $allAmount = count($amount);
    //$allFee = count($fee);
    //$allLastdate = count($lastdate);
    //$allAstatus = count($astatus);
    if($course_id == "all"){
        $sql = "SELECT * FROM `tbl_course`
                WHERE `status` = '$visible'
                ";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            $sql = ""; 
            while($row = $result->fetch_assoc()){
                $course_id_all = $row["course_id"];
                for($i = 0; $i<$allParticulars; $i++){
                    $sql_check = "SELECT * FROM `tbl_examination_fee`
                                 WHERE `status` = '$visible' && `course_id` = '$course_id_all' && `exfee_academic_year` = '$academic_year' && `exfee_particulars` = '$particulars[$i]';
                                 ";
                    $result_check = $con->query($sql_check);
                    if($result_check->num_rows > 0){
                        $row_check = $result_check->fetch_assoc();
                        $sql .= "UPDATE `tbl_examination_fee` 
                                SET `exfee_amount`='$amount[$i]',`exfee_time`='$date_variable_today_month_year_with_timing'
                                WHERE `exfee_id` = '".$row_check['exfee_id']."';
                                ";
                    } else{
                        $sql .= "INSERT INTO `tbl_examination_fee`
                                (`exfee_id`, `course_id`, `exfee_academic_year`, `exfee_particulars`, `exfee_amount`, `exfee_fine`,`exfee_lastdate`,`exfee_astatus`,`exfee_time`, `status`) 
                                VALUES 
                                (NULL,'$course_id_all','$academic_year','$particulars[$i]','$amount[$i]','$fine[$i]','$lastdate[$i]','$astatus[$i]','$date_variable_today_month_year_with_timing','$visible');
                                ";
                    }
                }
            }
            if($con->multi_query($sql))
                echo 'success';
            else
               echo 'error1';
            
        } else
            echo 'courseempty';
    }
    else{
        $sql = "";
        for($i = 0; $i<$allParticulars; $i++){
            $sql_check = "SELECT * FROM `tbl_examination_fee`
                         WHERE `status` = '$visible' && `course_id` = '$course_id' && `exfee_academic_year` = '$academic_year' && `exfee_particulars` = '$particulars[$i]';
                         ";
            $result = $con->query($sql_check);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $sql .= "UPDATE `tbl_examination_fee` 
                        SET `exfee_amount`='$amount[$i]',`exfee_time`='$date_variable_today_month_year_with_timing'
                        WHERE `status` = '$visible' && `course_id` = '$course_id' && `exfee_academic_year` = '$academic_year' && `exfee_particulars` = '$particulars[$i]';
                        ";
            } else{
                $sql .= "INSERT INTO `tbl_examination_fee`
                        (`exfee_id`, `course_id`, `exfee_academic_year`, `exfee_particulars`, `exfee_amount`,`exfee_fine`,`exfee_lastdate`,`exfee_astatus`, `exfee_time`, `status`) 
                        VALUES 
                        (NULL,'$course_id','$academic_year','$particulars[$i]','$amount[$i]','$fine[$i]','$lastdate[$i]','$astatus[$i]','$date_variable_today_month_year_with_timing','$visible');
                        ";
            }
        }
        if($con->multi_query($sql))
            echo 'success';
        else
           echo 'error2';
    }
} else
    echo 'empty';

}

//ADD FEE END


//ADD EXAM FEE START

else{
    
   //echo 'working1242';  exit;

  if(!empty($fee_type && $course_id && $academic_year) && $particulars[0] != "" && $amount[0] != "" && $fine[0] != "" && $lastdate[0] != "" && $astatus[0] != ""){
    $allParticulars = count($particulars);
    $allAmount = count($amount);
    //$allFee = count($fee);
    //$allLastdate = count($lastdate);
    //$allAstatus = count($astatus);
   
    if($course_id == "all"){
        $sql = "SELECT * FROM `tbl_course`
                WHERE `status` = '$visible'
                ";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            $sql = ""; 
            while($row = $result->fetch_assoc()){
                $course_id_all = $row["course_id"];
                for($i = 0; $i<$allParticulars; $i++){
                    $sql_check = "SELECT * FROM `tbl_fee`
                                 WHERE `status` = '$visible' && `course_id` = '$course_id_all' && `fee_academic_year` = '$academic_year' && `fee_particulars` = '$particulars[$i]';
                                 ";
                    $result_check = $con->query($sql_check);
                    if($result_check->num_rows > 0){
                        $row_check = $result_check->fetch_assoc();
                        $sql .= "UPDATE `tbl_fee` 
                                SET `fee_amount`='$amount[$i]',`fee_time`='$date_variable_today_month_year_with_timing'
                                WHERE `fee_id` = '".$row_check['fee_id']."';
                                ";
                    } else{
                        $sql .= "INSERT INTO `tbl_fee`
                                (`fee_id`, `course_id`, `fee_academic_year`, `fee_particulars`, `fee_amount`, `fee_fine`,`fee_lastdate`,`fee_astatus`,`fee_time`, `status`) 
                                VALUES 
                                (NULL,'$course_id_all','$academic_year','$particulars[$i]','$amount[$i]','$fine[$i]','$lastdate[$i]','$astatus[$i]','$date_variable_today_month_year_with_timing','$visible');
                                ";
                    }
                }
            }
            if($con->multi_query($sql))
                echo 'success';
            else
               echo 'error';
            
        } else
            echo 'courseempty';
    }
    else{
        $sql = "";
        for($i = 0; $i<$allParticulars; $i++){
            $sql_check = "SELECT * FROM `tbl_fee`
                         WHERE `status` = '$visible' && `course_id` = '$course_id' && `fee_academic_year` = '$academic_year' && `fee_particulars` = '$particulars[$i]';
                         ";
            $result = $con->query($sql_check);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $sql .= "UPDATE `tbl_fee` 
                        SET `fee_amount`='$amount[$i]',`fee_time`='$date_variable_today_month_year_with_timing'
                        WHERE `status` = '$visible' && `course_id` = '$course_id' && `fee_academic_year` = '$academic_year' && `fee_particulars` = '$particulars[$i]';
                        ";
            } else{
                $sql .= "INSERT INTO `tbl_fee`
                        (`fee_id`, `course_id`, `fee_academic_year`, `fee_particulars`, `fee_amount`,`fee_fine`,`fee_lastdate`,`fee_astatus`, `fee_time`, `status`) 
                        VALUES 
                        (NULL,'$course_id','$academic_year','$particulars[$i]','$amount[$i]','$fine[$i]','$lastdate[$i]','$astatus[$i]','$date_variable_today_month_year_with_timing','$visible');
                        ";
            }
        }
        if($con->multi_query($sql))
            echo 'success';
        else
           echo 'error';
    }
} else
    echo 'empty';

}

//END EXAM FEE START

}
//Add Fee End With Ajax
?>
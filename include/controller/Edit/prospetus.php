<?php

if($_POST["action"] == "edit_prospectus"){
    $edit_prospectus_no = $_POST["edit_prospectus_no"];
    $edit_prospectus_applicant_name = $_POST["edit_prospectus_applicant_name"];
    $edit_prospectus_gender = $_POST["edit_prospectus_gender"];
    $edit_prospectus_father_name = $_POST["edit_prospectus_father_name"];
    $edit_prospectus_address = $_POST["edit_prospectus_address"];
    $edit_prospectus_country = $_POST["edit_prospectus_country"];
    $edit_prospectus_state = $_POST["edit_prospectus_state"];
    $edit_prospectus_city = $_POST["edit_prospectus_city"];
    $edit_prospectus_postal_code = $_POST["edit_prospectus_postal_code"];
    $edit_prospectus_dob = $_POST["edit_prospectus_dob"];
    $edit_prospectus_emailid = $_POST["edit_prospectus_emailid"];
    $edit_mobile = $_POST["edit_mobile"];
    $edit_prospectus_course_name = $_POST["edit_prospectus_course_name"];
    $edit_prospectus_session = $_POST["edit_prospectus_session"];
    $edit_prospectus_rate = $_POST["edit_prospectus_rate"];
    $edit_prospectus_payment_mode = $_POST["edit_prospectus_payment_mode"];
    $edit_bank_name = $_POST["edit_bank_name"];
    $edit_transaction_no = $_POST["edit_transaction_no"];
    $edit_transaction_date = date('Y-m-d');
    $edit_id = $_POST["edit_id"];
    if(!empty($edit_prospectus_no && $edit_id)){
        $sql = "SELECT * FROM `tbl_prospectus`
                WHERE `status` = '$visible' && `prospectus_no` = '$edit_prospectus_no';
                ";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            echo 'exsits';
        }
        else{
            $sql = "UPDATE `tbl_prospectus` 
                    SET 
                    `prospectus_no` = '$edit_prospectus_no',`prospectus_applicant_name` = '$edit_prospectus_applicant_name',`prospectus_gender` = '$edit_prospectus_gender',`prospectus_father_name` = '$edit_prospectus_father_name',`prospectus_address` = '$edit_prospectus_address',`prospectus_country` = '$edit_prospectus_country',`prospectus_state` = '$edit_prospectus_state',`prospectus_city` = '$edit_prospectus_city',`prospectus_postal_code` = '$edit_prospectus_postal_code',`prospectus_dob` = '$edit_prospectus_dob',`prospectus_emailid` = '$edit_prospectus_emailid',`mobile` = '$edit_mobile',`prospectus_course_name` = '$edit_prospectus_course_name',`prospectus_session` = '$edit_prospectus_session',`prospectus_rate` = '$edit_prospectus_rate',`prospectus_payment_mode` = '$edit_prospectus_payment_mode',`bank_name` = '$edit_bank_name',`transaction_no` = '$edit_transaction_no',`transaction_date` = '$edit_transaction_date'
                     WHERE `status` = '$visible' && `id` = '$edit_id';
                    ";
            if($con->query($sql))
                echo 'success';
            else
                echo 'error';
        }
    } else
        echo 'empty';
}
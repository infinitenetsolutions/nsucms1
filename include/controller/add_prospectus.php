<?php 
 if($_POST["action"] == "add_prospectus"){
    $add_prospectus_no = $_POST["add_prospectus_no"];
    $add_prospectus_applicant_name = $_POST["add_prospectus_applicant_name"];
    $add_prospectus_gender = $_POST["add_prospectus_gender"];
    $add_prospectus_father_name = $_POST["add_prospectus_father_name"];
    $add_prospectus_mother_name = $_POST["add_prospectus_mother_name"];
    $add_prospectus_address = $_POST["add_prospectus_address"];
    $add_prospectus_country = $_POST["add_prospectus_country"];
    $add_prospectus_state = $_POST["add_prospectus_state"];
    $add_prospectus_city = $_POST["add_prospectus_city"];
    $add_prospectus_postal_code = $_POST["add_prospectus_postal_code"];
    $add_prospectus_dob = $_POST["add_prospectus_dob"];
    $add_prospectus_emailid = $_POST["add_prospectus_emailid"];
    $mobile = $_POST["mobile"];
    $add_prospectus_course_name = $_POST["add_prospectus_course_name"];
    $add_prospectus_session = $_POST["add_prospectus_session"];
    $add_prospectus_rate = $_POST["add_prospectus_rate"];
    $add_prospectus_payment_mode = $_POST["add_prospectus_payment_mode"];
    $cashDepositTo = $_POST["cashDepositTo"];
    $add_bank_name = $_POST["add_bank_name"];
    $add_transaction_no = $_POST["add_transaction_no"];
    $add_transaction_date = $_POST["add_transaction_date"];
    $date = date_create()->format('Y-m-d');
    
        if(!empty($add_prospectus_no && $add_prospectus_applicant_name && $add_prospectus_gender && $add_prospectus_address && $add_prospectus_emailid && $mobile && $add_prospectus_course_name && $add_prospectus_session && $add_prospectus_rate && $add_prospectus_payment_mode)){
       
        $sql = "INSERT INTO `tbl_prospectus`
                    (`id`, `prospectus_no`, `prospectus_applicant_name`, `prospectus_gender`, `prospectus_father_name`, `prospectus_mother_name`, `prospectus_address`, `prospectus_country`, `prospectus_state`, `prospectus_city`, `prospectus_postal_code`, `prospectus_dob`, `prospectus_emailid`,`mobile`,`prospectus_course_name`,`prospectus_session`,`prospectus_rate`,`prospectus_payment_mode`,`prospectus_deposit_to`,`bank_name`,`transaction_no`,`transaction_date`,`post_at`, `type`,`easebuzz_id`,`transaction_id`,`status`) 
                    VALUES 
                    (NULL,'$add_prospectus_no','$add_prospectus_applicant_name','$add_prospectus_gender','$add_prospectus_father_name','$add_prospectus_mother_name','$add_prospectus_address','$add_prospectus_country','$add_prospectus_state','$add_prospectus_city','$add_prospectus_postal_code','$add_prospectus_dob','$add_prospectus_emailid','$mobile','$add_prospectus_course_name','$add_prospectus_session','$add_prospectus_rate','$add_prospectus_payment_mode','$cashDepositTo','$add_bank_name','$add_transaction_no','$add_transaction_date','$date','','','','$visible')
                    ";
                    
       $sql_prospectus = "INSERT INTO `tbl_income`
                            (`id`, `reg_no`,`course`,`academic_year`,`received_date`, `particulars`, `amount`, `payment_mode`,`check_no`,`bank_name`,`income_from`,`post_at`) 
                            VALUES 
                            (NULL,'$add_prospectus_no(Form No)','$add_prospectus_course_name','$add_prospectus_session','$add_transaction_date','Prospectus','$add_prospectus_rate','$add_prospectus_payment_mode','$add_transaction_no','$add_bank_name','Prospectus','".date("Y-m-d")."')
                            ";
        $query=mysqli_query($con,$sql_prospectus);
        
               if($con->query($sql)){
                
                function sendsmsGET($mobileNumber,$message)
                {
                    $senderId='NSUJSR';
                    $routeId1=1;
                    $getData = 'mobileNos='.$mobileNumber.'&message='.urlencode($message).'&senderId='.$senderId.'&routeId='.$routeId1;
                    //API URL
                    $serverUrl1='msg.msgclub.net';
                    $authKey1='6a4743a8355fb97aa42dc2452185a1cd';
                    $url="http://".$serverUrl1."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$authKey1."&".$getData;
                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0
                    ));
                    $output = curl_exec($ch);
                    if(curl_errno($ch))
                    {
                    echo 'error:' . curl_error($ch);
                    }
                    curl_close($ch);
                    return $output;
                }
                    
                $student_msg = "Dear $add_prospectus_applicant_name, Thank you for the payment of Rs. $add_prospectus_rate through $add_prospectus_payment_mode towards your Prospectus of selected Course $add_prospectus_course_name. Regards NSU";
                sendsmsGET($mobile,$student_msg);
                
                echo "<script>
                        alert('Prospectus details added successfully!!!');
                        location.replace('prospectus_view');
                    </script>";
            }
            else
                echo "<script>
                        alert('Something went wrong please try again!!!');
                        location.replace('prospectus_view');
                    </script>";
        /*} else
            echo "<script>
                        alert('Something went wrong please try again!!!');
                        location.replace('../add_university_details');
                    </script>";*/
    } else{
        echo "<script>
                    alert('Please fill out all required fields!!!');
                    location.replace('prospectus_view');
                </script>";
    }
}
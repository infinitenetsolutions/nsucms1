<?php
    // include file
    include_once('easebuzz-lib/easebuzz_payment_gateway.php');

    /*
    * Create object for call easepay payment gate API and Pass required data into constructor.
    * Get API response.
    *  
    * param string $_GET['apiname'] - holds the API name.
    * param  string $MERCHANT_KEY - holds the merchant key.
    * param  string $SALT - holds the merchant salt key.
    * param  string $ENV - holds the env(enviroment).
    * param  string $_POST - holds the form data.
    *
    * ##Return values
    *   
    * - return array ApiResponse['status']== 1 successful.
    * - return array ApiResponse['status']== 0 error.
    *
    * @param string $_GET['apiname'] - holds the API name.
    * @param  string $MERCHANT_KEY - holds the merchant key.
    * @param  string $SALT - holds the merchant salt key.
    * @param  string $ENV - holds the env(enviroment).
    * @param  string $_POST - holds the form data.
    *
    * @return array ApiResponse['status']== 1 successful. 
    * @return array ApiResponse['status']== 0 error. 
    *
    */
    if(!empty($_POST) && (sizeof($_POST) > 0)){
      
      
      $transation_id = $_POST['txnid'];
      $amount = $_POST['amount'];
      $firstname = $_POST['firstname'];
      $course_name = $_SESSION["course_name"];
      $completeSessionOnlyYear = $_SESSION['completeSessionOnlyYear'];
      $email = $_POST["email"];
      $phone = $_POST["phone"];
      $furl = $_POST['furl'];
      $surl = $_POST['surl'];
      
      // all important data for seding into the database
      $registrationNumber = $_SESSION["registrationNumber"];
      $academicYear = $_SESSION["academicYear"];
      $courseId = $_SESSION["courseId"];
      // this data is insert into the admission page
      $fine_amount = $_SESSION["fine_amount"];
      $rebate_amount = $_SESSION["rebate_amount"];
      $remaining_amount = $_SESSION["remaining_amount"];
      $PaymentMode = $_SESSION["PaymentMode"];
      $cashDepositTo = $_SESSION["cashDepositTo"];
      $paidDate = $_SESSION["paidDate"];
      $paymentDate = $_SESSION["paymentDate"];
      
      
       $particular_paid_id = json_encode($_SESSION["particular_paid_id"]);
    $particular_paid_amount = json_encode($_SESSION["particular_paid_amount"]);
    $date = date('d-m-Y');
    $payment_check = "INSERT INTO `tbl_payment_check`( `particular_paid_id`, `particular_paid_amount`, `date`, `txno`, `student_id`) VALUES
                                                         ('$particular_paid_id','$particular_paid_amount','$date','$transation_id','$registrationNumber')";

    $success_result = mysqli_query($con, $payment_check);

        /*
        * There are three approch to call easebuzz API.
        *
        * 1. using hidden api_name which is $_POST from form.
        * 2. using pass api_name into URL.
        * 3. using extract html file name then based on file name call API.
        *
        */

        // first way
        // $apiname = trim(htmlentities($_POST['api_name'], ENT_QUOTES));

        // second way
        $apiname = trim(htmlentities($_GET['api_name'], ENT_QUOTES));

        // third way
        // $url_link = $_SERVER['HTTP_REFERER'];
        // $apiname = explode('.', ( end( explode( '/',$url_link) ) ) )[0];
        // $apiname = trim(htmlentities($apiname, ENT_QUOTES));


        /*
        * Based on API call change the Merchant key and salt key for testing(initiate payment).
        */
          //$MERCHANT_KEY = "2PBP7IABZ2"; //setup test enviroment
          //$SALT = "DAH88E3UWQ"; //setup test enviroment
          //$ENV = "test";    // setup test enviroment (testpay.easebuzz.in). 
      
          $MERCHANT_KEY = "VNQSM82SAE";  
          $SALT = "LNRNU85EPI"; 
          $ENV = "prod";   // setup production enviroment (pay.easebuzz.in).
 
        $easebuzzObj = new Easebuzz($MERCHANT_KEY, $SALT, $ENV);

       // print_r("*********test1");
        
        if($apiname === "initiate_payment"){ 

            /*  Very Important Notes
            * 
            * Post Data should be below format.
            *
                Array ( [txnid] => T3SAT0B5OL [amount] => 100.0 [firstname] => jitendra [email] => test@gmail.com [phone] => 1231231235 [productinfo] => Laptop [surl] => http://localhost:3000/response.php [furl] => http://localhost:3000/response.php [udf1] => aaaa [udf2] => aa [udf3] => aaaa [udf4] => aaaa [udf5] => aaaa [address1] => aaaa [address2] => aaaa [city] => aaaa [state] => aaaa [country] => aaaa [zipcode] => 123123 ) 
            */
           
            $easebuzzObj->initiatePaymentAPI($_POST);

        }else if($apiname === "transaction"){ 

            /*  Very Important Notes
            * 
            * Post Data should be below format.
            *
                Array ( [txnid] => TZIF0SS24C [amount] => 1.03 [email] => test@gmail.com [phone] => 1231231235 )
            */
            $result = $easebuzzObj->transactionAPI($_POST);

            easebuzzAPIResponse($result);
     
        }else if($apiname === "transaction_date" || $apiname === "transaction_date_api"){ 

            /*  Very Important Notes
            * 
            * Post Data should be below format.
            *
                Array ( [merchant_email] => jitendra@gmail.com [transaction_date] => 06-06-2018 )
            */
            $result = $easebuzzObj->transactionDateAPI($_POST);

            easebuzzAPIResponse($result);
                       
        }else if($apiname === "refund"){
            
            /*  Very Important Notes
            * 
            * Post Data should be below format.
            *
                Array ( [txnid] => ASD20088 [refund_amount] => 1.03 [phone] => 1231231235 [email] => test@gmail.com [amount] => 1.03 )
            */
            $result = $easebuzzObj->refundAPI($_POST);

            easebuzzAPIResponse($result);
                       
        }else if($apiname === "payout"){

            /*  Very Important Notes
            * 
            * Post Data should be below format.
            *
               Array ( [merchant_email] => jitendra@gmail.com [payout_date] => 08-06-2018 )
            */
            $result = $easebuzzObj->payoutAPI($_POST);

            easebuzzAPIResponse($result);
                       
        }else{

            echo '<h1>You called wrong API, Pleae try again</h1>';
        }

    }else{
        echo '<h1>Please fill all mandatory fields.</h1>';
    }


    /*
    *  Show All API Response except initiate Payment API
    */
    function easebuzzAPIResponse($data){
        print_r($data);
    }

?>
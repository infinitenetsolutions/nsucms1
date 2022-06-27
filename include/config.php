<?php
    // Create connection
    if($_SERVER['HTTP_HOST']=='localhost'){
    $con = new mysqli("localhost", "root", "", "nsucms_cms");
    }else{
        $con = new mysqli("localhost", "nsucms_cms", "wpNnnOv5", "nsucms_cms");
    }
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
?>
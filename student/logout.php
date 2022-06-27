<?php
    //Starting Session
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "include/config.php";
    unset($_SESSION["logger_time"]);
    unset($_SESSION["logger_username1"]);
    unset($_SESSION["logger_password1"]);
    if(!isset($_SESSION["logger_username1"]) && !isset($_SESSION["logger_password1"]))
        echo "<script> location.replace('student_login'); </script>";
?>
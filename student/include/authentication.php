<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<?php 
	$visible = md5("visible");
    //Starting Session
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "config.php";
    $idle_time = 12000;
    if (time()-$_SESSION["logger_time1"]>$idle_time){
        unset($_SESSION["logger_time1"]);
        unset($_SESSION["logger_type1"]);
        unset($_SESSION["logger_username1"]);
        unset($_SESSION["logger_password1"]);
        echo "<script> location.replace('dashboard'); </script>";
    }
    if(!isset($_SESSION["logger_type1"]) && !isset($_SESSION["logger_username1"]) && !isset($_SESSION["logger_password1"]))
        echo "<script> location.replace('dashboard'); </script>";
?>
<script>
    $(document).ready(function() {
        setInterval('refreshPage()', 1201000);
    });

    function refreshPage() {
        location.reload();
    }
</script>
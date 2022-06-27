<?php 
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "include/config.php";
      if( isset($_SESSION["logger_type1"]) && isset($_SESSION["logger_username1"]) && isset($_SESSION["logger_password1"]))
        echo "<script> location.replace('dashboard'); </script>";
?>

<body>
	<title> NSU Login Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="dist/css/login.css" rel="stylesheet" id="bootstrap-css">

<style type="text/css">
    body
{
    background: url('images/img_bg_nsu.png') fixed ;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 0;
    margin: 0;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-4"></div>
            <div class="col-sm-5">
             <div class="wrap form-section">
                <center> <img class="opt_img" src="images/logo.png"></center>
                <p class="form-title">Sign In</p>
                <small>If you don't have your Login User Id and Password or if you are getting some issues during Login your Panel, feel free to contact with this number <a href="tel:9835203429" style="color:red">+91 983-520-3429</a></small><br/><br/>
                <form  method="POST" id="student_login_form">
				 <div id="error_section"></div>
               <b> User ID :</b><input type="text" id="student_login_username" name="student_login_username" class="form-control" placeholder="Username"></br>
                <b>Password : </b><input type="password" id="student_login_password" name="student_login_password" class="form-control" placeholder="Password"></br>
                 <div class="col-4">
				<div class="col-4">
				<input type='hidden' name='action' value='student_login' />
				<button type="submit" id="student_login_button" name="student_login_button" class="btn btn-primary btn-block">Sign In</button>
			</div>
			<div class="col-12" id="loader_section"></div>
                        </div>              
                </form>
            </div></div>
            <div class="col-sm-3">
           
            </div>
        </div>
</div>
<script>
        $(function() {

            $('#student_login_form').submit(function( event ) {
                $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/load.gif" alt="Currently loading" /></center>');
                $('#student_login_button').prop('disabled', true);
                $.ajax({
                    url: 'include/controller.php',
                    type: 'POST',
                    data: $('#student_login_form').serializeArray(),
                    success: function(result) {
                        $('#response').remove();
                        $('#student_login_form')[0].reset();
                        $('#error_section').append('<div id = "response">' + result + '</div>');
                        $('#loading').fadeOut(500, function() {
                            $(this).remove();
                        });
                        $('#student_login_button').prop('disabled', false);
                    }

                });
                event.preventDefault();
            });

        });
    </script>
</body>
</html>
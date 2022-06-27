<?php 
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "include/config.php";
      if( isset($_SESSION["logger_type1"]) && isset($_SESSION["logger_username1"]) && isset($_SESSION["logger_password1"]))
        echo "<script> location.replace('dashboard'); </script>";
?>


	<title> NSU Login Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="dist/css/login.css" rel="stylesheet" id="bootstrap-css">

<style type="text/css">
    body
{
    background: url('images/cms.png') fixed ;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 0;
    margin: 0;
}
  .form-sections{
 border-radius: 90px 4px;
    width: 390px;
    margin: 94px auto;
    background: #e3b020;
    padding: 18px 20px;
    box-shadow: 5px 5px 14px #c70013;
  }
  @media screen and (max-width: 600px){
    .form-sections {        
    margin: 225px 0px 0px 9px;
    padding: 18px 24px;
    border-radius: 21px 4px;
}
    .form-sections .mobile{display:none;}
    .website-view{display:none;}
  }
  
  @media screen and (min-width: 600px){
  .form-sections p{        
   display:none;
}
    .mobile-view{display:none;}
  }
</style>
<body>
  <section>
  <h4 class="website-view" style="
    color: white;
    /* margin-top:20px; */
    padding: 17px;
font-weight: 700;
">Establised Under Jharkhand State Private University Act 2018</h4>
    
    <h4 class="mobile-view" style="
	font-size: 17px;
    color: white;
    position: absolute;
    margin-top: -100px;
    padding-left: 50px;
    padding-top: 20px;
    
">Establised Under Jharkhand State Private University Act 2018</h4>
      
          <div class="form-sections">
                <center> <img class="opt_img" src="images/logo.png"></center>
            <h3 class="text-center"><b style="
    color: #c70013;
    font-weight: 700;
    text-align: center;
    text-transform: uppercase;
">Sign In</b></h3>
                <small>If you don't have your Login User Id and Password or if you are getting some issues during Login your Panel, feel free to contact with this number <a href="tel:9835203429" style="color: #6e5e61;
    font-weight: 700;">+91 983-520-3429</a></small><br/><br/>
        <form  method="POST" id="student_login_form">
				 <div id="error_section"></div>
               <b> User ID :</b><input type="text" id="student_login_username" name="student_login_username" class="form-control" placeholder="Username"><br>
                <b>Password : </b><input type="password" id="student_login_password" name="student_login_password" class="form-control" placeholder="Password"><br>
                 
				
				<input type='hidden' name='action' value='student_login' />
				<button type="submit" id="student_login_button" name="student_login_button" class="btn btn-primary btn-block">Sign In</button>
			
        
			<div class="col-12" id="loader_section"></div>
          <br><p class="mobile">© 2022 Netaji Subhas University. All Right Reserved. Powered By <a class="text-light text-decoration-none font-weight-bold" href="http://infinitenetsolutions.com/" target="_blank">Infinite Net Solutions</a></p>
                </form>
        </div>
    
    <p style="
    
    padding-left: 80px;
    position: absolute;
    right: 2px;
    width: 432px;
    color: #fff;
    font-weight: 800;
    bottom: 20px;

">© 2022 Netaji Subhas University. All Right Reserved. Powered By <a class="text-light text-decoration-none font-weight-bold" href="http://infinitenetsolutions.com/" target="_blank">Infinite Net Solutions</a></p>
  </section>

<!--<div class="container">
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
</div>-->
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
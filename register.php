<?php
    /*
        Login Page
    */

    session_start();
    require_once 'dbconnect.php';

    // if(!isset($_SESSION['user'])) {
    //     header('Location: register.php');
    // }

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = hash('sha256', $_POST['password']);
        $result = $db->facultyProfileUsers->insertOne(array('username'=>$username, 'password'=>$password));
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title> Register </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ven/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ven/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="ven/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ven/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ven/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="ven/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form method='post' class="login100-form validate-form p-l-55 p-r-55 p-t-178">
					<span class="login100-form-title">
						Register
                    </span>
                    
                    <fieldset>
					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
						<input class="input100" type="text" name="username" placeholder="Username"/>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100" type="password" name="password" placeholder="Password"/>
                        <span class="focus-input100"></span>
					</div>
                    
					<div class="text-right p-t-13 p-b-23">
					</div>
                    
					<div class="container-login100-form-btn">
                        <input type="submit" class="login100-form-btn" value="register"/>
                    </div>
                    </fieldset>
                    
					<div class="flex-col-c p-t-170 p-b-40">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="ven/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="ven/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="ven/bootstrap/js/popper.js"></script>
	<script src="ven/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="ven/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="ven/daterangepicker/moment.min.js"></script>
	<script src="ven/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="ven/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
</body>
</html>
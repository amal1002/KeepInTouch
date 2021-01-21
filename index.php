<?php 
    require 'functions/functions.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
        if($_SESSION['user_role'] == 'admin') {
            header("location:admin.php");
        } else {
            header("location:home.php");
        }
    }
    session_destroy();
    session_start();
    ob_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Keep In Touch</title>
    <link rel="stylesheet" type="text/css" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="resources/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="resources/fontawesome-free-5.3.1-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
    <style>
    body {
        background: #FFF !important;
    }
        .container{
            margin: 40px auto;
            width: 400px;
        }
        .content {
            padding: 30px;
            background-color: white;
            box-shadow: 0 0 5px #4267b2;
        }
        td{
	        padding:10px 5px;
	    }	
    </style>
</head>
<body>
<div class="container-flud">
	<div class="col-lg-12 row_1 d-flex">
		<div class="col-lg-6">
			<a href="../index.html" class="logo">keep in touch</a>
		</div>

		<div class="col-lg-6 login_box mt-2">
		<form method="post" onsubmit="return validateLogin()">
			<table>
				<tr>
					<td class="col-xs-5">
						<input type="text" name="useremail" id="loginuseremail" placeholder="Email" class="form-control" />
					</td>
					<td class="col-xs-5">
						<input type="password" name="userpass" id="loginuserpass" placeholder="Password" class="form-control" />
					</td>
					<td class="col-xs-2">
						<input type="submit" name="login" value="Login" class="btn btn-primary" style="margin-top: -5px !important"/>
					</td>
				</tr>
			</table>	
		</form>	
		</div>
	</div>
		<div class="col-lg-6 login_box2">
	
		<form action="" method="post">
			<table>
				<tr>
					<td>
						<h5>Email</h5>
						<input type="email" name="username" placeholder="Email" class="form-control" />
					</td>
				</tr>
				<tr>
					<td>
						<h5>Password</h5>
						<input type="password" name="password" placeholder= Password class="form-control" />
					</td>
				</tr>
				<tr>
					<td align="right">
						<input type="submit" name="Login" value="Login" class="btn btn-primary login_btn" />
					</td>
				</tr>
				<tr>
					<td>
						<h5><a href="forgot-password.php">Forgot your password ?</a></h5>
					</td>
				</tr>
				<tr>
					<td>
						<a href="signup.php" class="btn btn-success signup_btn2" />Signup</td>
					</td>
				</tr>
			</table>	
		</form>	
		</div>
<div class="col-lg-12 row_2 d-flex mt-4">
	<div class="col-lg-7">
		<h3>keep in touch helps you connect and share with the people in your life.</h3>
		<img class="connect-img" src="resources/images/facebook_map.gif" width="500px">
	</div>
	
	<div class="col-lg-5 signup_box">
		<form action="" method="post" onSubmit="return check();" name="Reg" >
			<table>
				<tr>
					<td><input type="text" name="userfirstname" id="userfirstname" placeholder="First Name" class="form-control"></td>
					<td><input type="text" name="userlastname" id="userlastname" placeholder="Last Name" class="form-control"></td>
				</tr>
				<tr>
					<td colspan="2px"><input type="email" name="useremail" id="useremail" placeholder="Email" class="form-control"  /> <div class="status" id="status"></div></td>
				</tr>
				<tr>
					<td colspan="2px">
                        <input type="radio" name="usergender" value="M" id="malegender" class="usergender">
                        <label>Male</label>
                        <input type="radio" name="usergender" value="F" id="femalegender" class="usergender">
                        <label>Female</label>
                        <div class="required"></div>
					</td>
				</tr>
					<tr> 
						<td colspan="2px">
						 <input type = "date" placeholder="Date of birth" class="form-control" name="dateOfBirth" id="dateOfBirth"/>
							</td> 
					</tr> 

					<tr>
						<td colspan="2px">
							<input type="password"  placeholder="Password"  name="userpass" id="userpass" class="form-control" />
						</td>
					</tr>

					<tr>
						<td colspan="2px">
							<input type="password" placeholder="Confirm Password"  name="userpassconfirm" id="userpassconfirm" class="form-control" onKeyUp="checkPass(); return false;"  />
							<span id="confirmMessage" class="confirmMessage"></span>
						</td>
					</tr>

                    <tr>
						<td colspan="2px">
                            <textarea class="form-control" placeholder="Something about you ..." rows="2" name="userabout" id="userabout"></textarea>
						</td>
					</tr>


					<tr>
						<td colspan="2px">
						<input type="submit" value="Create Account" name="register">
					</tr>
			</table>		
		</form>
	</div>
</div>
</div>
<script src="resources/js/jquery-3.5.1.min.js"></script>
<script src="resources/js/popper.min.js"></script>
<script src="resources/js/bootstrap3.min.js"></script>
</body>
</html>

<?php
$conn = connect();
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A form is posted
    if (isset($_POST['login'])) { // Login process
        $useremail = $_POST['useremail'];
        $userpass = md5($_POST['userpass']);
        $query = mysqli_query($conn, "SELECT * FROM users WHERE user_email = '$useremail' AND user_password = '$userpass'");
        if($query){
            if(mysqli_num_rows($query) == 1) {
                $row = mysqli_fetch_assoc($query);
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_role'] = $row['user_role'];
                $_SESSION['user_name'] = $row['user_firstname'] . " " . $row['user_lastname'];
                if($row['user_role'] == 'admin') {
                    header("location:admin.php");
                } else {
                    header("location:home.php");
                }
            }
            else {
                ?> <script>
                    document.getElementsByClassName("required")[0].innerHTML = "Invalid Login Credentials.";
                    document.getElementsByClassName("required")[1].innerHTML = "Invalid Login Credentials.";
                </script> <?php
            }
        } else{
            echo mysqli_error($conn);
        }
    }
    if (isset($_POST['register'])) { // Register process
        // Retrieve Data
        $userfirstname = $_POST['userfirstname'];
        $userlastname = $_POST['userlastname'];
        $userpassword = md5($_POST['userpass']);
        $useremail = $_POST['useremail'];
        $userbirthdate = $_POST['dateOfBirth'];
        $usergender = $_POST['usergender'];
        $userabout = $_POST['userabout'];
        $userrole = 'user';
        if (isset($_POST['userstatus'])){
            $userstatus = $_POST['userstatus'];
        }
        else{
            $userstatus = NULL;
        }
        $query = mysqli_query($conn, "SELECT user_email FROM users WHERE user_email = '$useremail'");
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);
            if($useremail == $row['user_email']){
                ?> <script>
                document.getElementsByClassName("required")[7].innerHTML = "This Email already exists.";
                </script> <?php
            }
        }
        $sql = "INSERT INTO users(user_firstname, user_lastname, user_password, user_email, user_gender, user_birthdate, user_status, user_about, user_role)
                VALUES ('$userfirstname', '$userlastname', '$userpassword', '$useremail', '$usergender', '$userbirthdate', '$userstatus', '$userabout', '$userrole')";
        $query = mysqli_query($conn, $sql);
        if($query){
            $query = mysqli_query($conn, "SELECT user_id FROM users WHERE user_email = '$useremail'");
            $row = mysqli_fetch_assoc($query);
            $_SESSION['user_id'] = $row['user_id'];
            header("location:home.php");
        }
    }
}
?>

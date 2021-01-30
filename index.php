<?php 

session_start();
//error_reporting(E_ERROR | E_PARSE);
$logintime= date("H:i:s A");

// include classes
include_once "model/dao/database.php";
include_once "model/dao/user.php";

// get database connection
$database = new Database();
$db = $database->getConnection();


// initialize user objects
$userObj = new User($db);

// if the login form was submitted
if($_POST){
	
function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$username = clean($_POST['uname']);
	
	$password = clean($_POST['upass']);
	
	//$ip = clean($_POST['cat']);
	//$lab = clean($_POST['subcat']);
	//echo $lab;
	
	if ((strlen($username) <1) || (strlen($username) > 32))
	{
					 $r='<font color="#CC6600" style="font-family:monospace; font-size:12px">* Login failed, Please Enter Username </font>';

	}
	else if ((strlen($password) < 1) || (strlen($password) > 32))
	{
						 $r='<font color="#CC6600" style="font-family:monospace; font-size:12px">* Login failed,Please Enter Password </font>';

	}
	else {
		
	// check if email and password are in the database
	    $userObj->email=$_POST['uname'];

	// check if email exists, also get user details using this emailExists() method
	$email_exists = $userObj->emailExists();
	
	// validate login
	if ($email_exists && ((md5($password))== $userObj->password)){

		$_SESSION['unames'] = $userObj->surname.' '.$userObj->oname;
		$_SESSION['state_id'] = $userObj->state_id;
		$_SESSION['uid'] = $userObj->id;
		$_SESSION['uemail'] = $userObj->email;
		$_SESSION['group_id'] = $userObj->group_id;
		$_SESSION['logintime'] = $logintime;
		//echo 'here'.$_SESSION['facility'] = $_POST['subcat'];
		//break;
		if ($_SESSION['group_id'] == "1")//DASHBOARD
			{
				header("location: view/home.php");
						
			}
			else if ($_SESSION['group_id'] == "2")//FILE UPLOAD
			{
				header("location: dwh/home.php");
						
			}
			else if ($_SESSION['group_id'] == "3")//STATE USER
			{
				header("location: view/statepage.php");
						
			}
			else if ($_SESSION['group_id'] == "4")//STATE USER
			{
				header("location: admin/read_users.php");
						
			}
				
					
				session_write_close();
		
	}
	else{
		$access_denied=true;
	}
}
if($access_denied){
	echo "<div class=\"alert alert-danger margin-top-40\" role=\"alert\">";
		echo "Access Not Granted.<br /><br />";
		echo "Your username or password maybe incorrect";
	echo "</div>";
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>IHVN Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" type="image/png" href="resources/images/login_icon.ico"/>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style type="text/css">
    body {
        color: #999;
		background: #f5f5f5;
		font-family: 'Varela Round', sans-serif;
	}
	.form-control {
		box-shadow: none;
		border-color: #ddd;
	}
	.form-control:focus {
		border-color: #4aba70; 
	}
	.login-form {
        width: 350px;
		margin: 0 auto;
		padding: 30px 0;
	}
    .login-form form {
        color: #434343;
		border-radius: 1px;
    	margin-bottom: 15px;
        background: #fff;
		border: 1px solid #f3f3f3;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
	}
	.login-form h4 {
		text-align: center;
		font-size: 22px;
        margin-bottom: 20px;
	}
    .login-form .avatar {
        color: #fff;
		margin: 0 auto 30px;
        text-align: center;
		width: 100px;
		height: 100px;
		border-radius: 50%;
		z-index: 9;
		background: #4aba70;
		padding: 15px;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
    .login-form .avatar i {
        font-size: 62px;
    }
    .login-form .form-group {
        margin-bottom: 20px;
    }
	.login-form .form-control, .login-form .btn {
		min-height: 40px;
		border-radius: 2px; 
        transition: all 0.5s;
	}
	.login-form .close {
        position: absolute;
		top: 15px;
		right: 15px;
	}
	.login-form .btn {
		background: #4aba70;
		border: none;
		line-height: normal;
	}
	.login-form .btn:hover, .login-form .btn:focus {
		background: #42ae68;
	}
    .login-form .checkbox-inline {
        float: left;
    }
    .login-form input[type="checkbox"] {
        margin-top: 2px;
    }
    .login-form .forgot-link {
        float: right;
    }
    .login-form .small {
        font-size: 13px;
    }
    .login-form a {
        color: #4aba70;
    }
</style>
</head>
<body>

<div class="login-form">    
   <form name="form1" method="post" action='index.php'>
		<div align="center"><img src="resources/login-icon.png" height="80px" width="100px" /></div><br>
        <p align="center"><b>IHVN CENTRAL DASHBOARD</b> </p>
		
	
		<div class="form-group">
            <input type="text" class="form-control" name="uname" value="<?php //echo $user;?>" placeholder="Username" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="upass" placeholder="Password" required="required">
        </div>
		
     
		
        <input type="submit" name="Login" class="btn btn-primary btn-block btn-lg" value="Login">              
   
	</form>			
    

</body>
</html>                                		                            
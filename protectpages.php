<?php
session_start();
//Check whether the users session variable  is present or not
	if(!isset($_SESSION['group_id']) || (trim($_SESSION['unames']) == '')) {
		header("location: index.php");
		
	}
			


?>
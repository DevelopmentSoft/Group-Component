<?php
	require_once "dbconn.php";
	session_start();
	
	$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	
	if(isset($_SESSION["login"]) && isset($_SESSION["type"]) && $_SESSION["type"] == "student"){
		$user_check = $_SESSION["login"];
		
		$sql = "SELECT * FROM `student_tb` WHERE `Name` = '$user_check' || `Student_ID` = '$user_check'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);
		
		$login_session = $row['Student_ID'];
		$login_name = $row['Name'];
		$login_email = $row['Email'];
		$login_type = $row['Type'];
		$login_faculty = $row['Faculty'];
	}
	else if(isset($_SESSION["login"]) && isset($_SESSION["type"]) && $_SESSION["type"] == "admin"){
		$user_check = $_SESSION["login"];
		
		$sql = "SELECT * FROM `management_tb` WHERE `Username` = '$user_check' || `Management_ID` = '$user_check'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);
		
		$login_session = $row['Management_ID'];
		$login_name = $row['Username'];
		$login_type = $row['Type'];
		$login_faculty = $row['Faculty'];
		
	}
	else{
//		mysqli_close($conn);
		
		if($curPageName == "Home.php"){
			
		}
		else{
			header("Location: Home.php");
		}
	}

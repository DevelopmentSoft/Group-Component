<?php
session_start();
//Manager (982075262,Manager123)
//Coordinator (982075261,111111)
//Admin (302419723,admin123)
//student (982075231,123123)

     $errors =array();
	require_once("dbconn.php");
	date_default_timezone_set('Asia/Kuala_Lumpur');

    if(isset($_POST["Login"])){
        if(!empty($_POST["name"]) && !empty($_POST["password"])){
            $name = $_POST['name'];
			$password = $_POST['password'];
			$role = $_POST["RoleRad"];

			if(!empty($role)){
				if($role == "student"){
					$sql = "SELECT * FROM `student_tb` WHERE `Student_ID` = '$name'";
					$result = mysqli_query($conn, $sql);
				}
				else{
					$sql = "SELECT * FROM `management_tb` WHERE `Management_ID` = '$name'";
					$result = mysqli_query($conn, $sql);
				}

				if (mysqli_num_rows($result) == 1) {
					$rows = mysqli_fetch_assoc($result);
					$apass = $rows["Password"];

						if (password_verify($password,$apass)) {
							  if(!empty($rows['Student_ID'])){
								$_SESSION["login"] = $rows['Student_ID'];
							    }
							    else{
								$_SESSION["login"] = $rows['Management_ID'];
							    }
							$_SESSION["type"] = $role;

							echo "<script>alert('Login Success')</script>";

							if(isset($_SESSION["login"])){
								setcookie("login_cookie", $_SESSION["login"], time() + (86400 * 30), "/");
								setcookie("login_cookie", $_SESSION["type"], time() + (86400 * 30), "/");

                if($_SESSION["type"] == "student"){
echo "<script>window.location.replace('Index.php')</script>";
}
else if($_SESSION["type"] == "coordinator"){
echo "<script>window.location.replace('Faculty.php')</script>";
}
else{
echo "<script>window.location.replace('Home.php')</script>";
}
							}
						}
						else {
						$error = "Invalid User ID or Password";
							echo "<script>alert('$error')</script>";
						}
				}
				else {
					$error = "Invalid User ID or Password";
					echo "<script>alert('$error')</script>";
				}
				//mysqli_close($conn);
			}
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Login</title>

    <!-- Icons font CSS-->
    <link href="../EWSDcoursework/Layout/login/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="../EWSDcoursework/Layout/login/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="../EWSDcoursework/Layout/login/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../EWSDcoursework/Layout/login/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="../EWSDcoursework/Layout/login/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-01 p-t-180 p-b-100 font-poppins">
        <div class="wrapper wrapper--w780">
            <div class="card card-3">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Login</h2>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>"method="POST">
                        <div class="input-group">
                            <input class="input--style-3" type="text" placeholder="ID" name="name" required>
                        </div>
                        <div class="input-group">
                            <input class="input--style-3" type="password" placeholder="Password" name="password" required>
                        </div>

						<div class="col">
                            <label for="inputState" class="form-label" style="font-size:20px;">Role</label>
                            <div class="row">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="RoleRad" id="gridRadios1" value="student" checked>
									<label class="form-check-label" for="gridRadios1">student</label>
								</div>
								<div class="form-check" style="margin-left:20px;">
									<input class="form-check-input" type="radio" name="RoleRad" id="gridRadios2" value="admin">
									<label class="form-check-label" for="gridRadios2">admin</label>
								</div>
							</div>
                        </div>

						<div class="p-t-10" style="padding-top: 60px;float: right;">
                            <button class="btn btn--pill btn--green" name="Login" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="../EWSDcoursework/Layout/login/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="../EWSDcoursework/Layout/login/vendor/select2/select2.min.js"></script>
    <script src="../EWSDcoursework/Layout/login/vendor/datepicker/moment.min.js"></script>
    <script src="../EWSDcoursework/Layout/login/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="../EWSDcoursework/Layout/login/js/global.js"></script>

</body>

</html>
<!-- end document-->

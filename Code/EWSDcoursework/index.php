<?php include '../EWSDcoursework/Top.php' ?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = array();
require_once("dbconn.php");
require 'vendor/autoload.php';
date_default_timezone_set('Asia/Kuala_Lumpur');


if (isset($_POST["PostContri"])) {
	if (isset($_POST["term"])) {
		$ds = date("Y-m-d");

		$checkImg = getimagesize($_FILES["Image"]["tmp_name"]);
		$Imgtemp = $_FILES['Image']['tmp_name'];

		$filename = $_FILES["uploadfile"]["name"];
		$type = $_FILES["uploadfile"]["type"];
		$fileData = addslashes(file_get_contents($_FILES['uploadfile']['tmp_name']));

		if ($Imgtemp == null) {
			$image = "NoImage";
		} else {
			$Imgdata = base64_encode(file_get_contents($Imgtemp));
			$image = "data:" . $checkImg["mime"] . ";base64," . $Imgdata;
		}

		if ($filename == null) {
			array_push($errors, "File is required");
		}

		$chksql = "SELECT * FROM contribution_tb WHERE SubBy ='$login_session'";
		$chkresult = mysqli_query($conn, $chksql);
		$rowCheck = mysqli_num_rows($chkresult);

		if ($rowCheck > 0) {
			$Updatesql =  "UPDATE contribution_tb SET Type='$type', Image = '$image', File='$filename',DateSubmitted='$ds',filedata = '$fileData' WHERE SubBy ='$login_session'";

			if ($conn->query($Updatesql) === TRUE) {
				echo "<script>alert('Contribution Updated')
						                        window.location.replace('index.php')</script>";
			} else {
				echo "Error updating record: " . $conn->error;
			}
		} else {
			//if there are no error,save user to database
			if (count($errors) == 0) {
				$insert = "INSERT INTO contribution_tb(Type,Image,File,DateSubmitted,SubBy,Faculty,filedata)VALUES('$type','$image','$filename','$ds','$login_session','$login_faculty','$fileData')";

				if ($conn->query($insert) === TRUE) {
					//=============== Send Email to Coordinator =================
					$sql2 = "SELECT * FROM management_tb WHERE Faculty = '$login_faculty'";
					$result2 = mysqli_query($conn, $sql2);
					$row = mysqli_fetch_assoc($result2);

					$mail = new PHPMailer();

					$mail->Host = "smtp.gmail.com";
					$mail->Port = 587;
					$mail->SMTPSecure = 'tls';
					$mail->IsSMTP();
					$mail->SMTPAuth = true;

					//Gmail
					$sender_email = "khiewjames@gmail.com";
					$mail->Username = $sender_email;

					//App Password
					$mail->Password = "czrsmeapfcqzjzpy";

					//Recipeint's name
					$name = "";
					$mail->From = $sender_email;
					$mail->FromName = "Do-Not-Reply-System";
					$mail->Subject = "New Contribution has been submitted";


					$mail->AddAddress($row['Email'], $row['Username']);
					$mail->IsHTML(true);
					$mail->WordWrap = 50;
					$mail->Body = "<h1>Dear " . $row["Username"] . " of " . $row["Faculty"] . ",</h1><br>
			<p>New submission of contribution has been submitted by " . $login_name . " in your faculty.</p>
			<p>Please review the contribution within 14 weeks</p><br>Thank You!</h4>";

					if ($mail->Send()) {
						echo "<script>alert('Contribution Submitted'); window.location.replace('index.php');</script>";
					}
					$mail->clearAddresses();
					//============== Send Email to Coordinator End ==============
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			} else {
				foreach ($errors as $err) {
					echo "<script>alert('$err')</script>";
				}
			}
		}
	} else {
		echo "<script>alert('Please check the term and condition.')</script>";
	}
}

if (isset($_POST['UpdateProfile'])) {
	if (!empty($_POST['SName']) && !empty($_POST['SEmail'])) {
		$name = $_POST['SName'];
		$email = $_POST['SEmail'];

		//check if draft already saved
		$chksql = "SELECT * FROM `student_tb` WHERE `Student_ID` = '$login_session' AND `Faculty` = '$login_faculty'";
		$chkresult = mysqli_query($conn, $chksql);
		$rowCheck = mysqli_num_rows($chkresult);

		// if data exist update the data
		if ($rowCheck > 0) {
			$Updatesql =  "UPDATE `student_tb` SET `Name` ='$name', Email = '$email' WHERE `Student_ID` ='$login_session' AND `Faculty` = '$login_faculty'";
			mysqli_query($conn, $Updatesql);

			if ($conn->query($Updatesql) == TRUE) {

				echo "<script>alert('Profile has been Updated') window.location.replace('index.php')</script>";
			} else {
				echo "Error updating record: " . $conn->error;
			}
		}
	}
}
?>

<head>
	<!--<title>Upload</title>-->
</head>

<body>
	<!-- our -->
	<div id="txtarea" class="our">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="titlepage">
						<h2>Student Form</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 margin_bottom">
					<div class="row">

						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="two-box">
								<figure><img style="width:300px;height:250px;" src="../EWSDcoursework/Layout/mainpage/images/gradurate.jpg" alt="#" /></figure>
							</div>
						</div>

						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

							<div class="txtarea">
								<?php
								$cd = date("Y-m-d");
								$chkdate = "SELECT * FROM `event_tb` ORDER BY `Event_ID` DESC";
								$dateresult = mysqli_query($conn, $chkdate);
								$daterow = mysqli_fetch_assoc($dateresult);

								$datetoday = date('Y-m-d', strtotime($cd));
								//echo $paymentDate; // echos today!
								$DateBegin = date('Y-m-d', strtotime($daterow["Start_Date"]));
								$DateEnd = date('Y-m-d', strtotime($daterow["End_Date"]));

								if (($datetoday >= $DateBegin) && ($datetoday <= $DateEnd)) {

									echo "<form action='" . $_SERVER["PHP_SELF"] . "' method='POST' enctype='multipart/form-data'>
											<label for='Image' class='form-label'>Image</label>
											<div class='custom-file'>
											<input type='file' class='custom-file-input' id='inputImage' name='Image' accept='image/*'>
											<label class='custom-file-label' id='lblImg' for='inputImage'>Choose file</label>
											</div>

											<label for='file' class='form-label'>File</label>
											<div class='custom-file' style='margin: 20px 0'>
											<input type='file' class='custom-file-input' id='inputFile' name='uploadfile' accept='.xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf'>
											<label class='custom-file-label' id='lblfile' for='inputFile'>Choose file</label>
											</div>

											<div class='custom-file' style='margin: 20px 0'>
                                    <input type='checkbox'  id='term' name='term'>
                                    <label class='' id='lblterm' for='term'>Term & Condition</label>
                                </div>

											<div class='row' style='float:right;'>
											<button style='margin-left:20px;' type='submit' class='btn btn-success' name='PostContri'>Submit</button>
											</div>
											</form>";
								} else {
									echo "
											<div class='custom-file'>
											<label class='text-danger' style='font-size:40px'>No Submission Available</label>
											</div>";
								}
								?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- end our -->

	<div id="txtarea" class="ourInvert">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="titlepage">
						<h2 style="color:snow;">My Profile</h2>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 margin_bottom">
					<div class="row">

						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
							<div class="txtarea">
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="Profile_Form">
									<?php
									$sql3 = "SELECT * FROM student"
									?>
									<div class="row">
										<div class="col">
											<input type="text" class="form-control" name="ID" placeholder="ID" id="COID" aria-label="ID" value="<?php echo $login_session; ?>" readonly>
										</div>
										<div class="col">
											<input type="text" class="form-control" name="SName" placeholder="Name" id="COName" aria-label="name" value="<?php echo $login_name; ?>" required>
										</div>
										<br>
									</div>
									<br>
									<div class="row">
										<div class="col">
											<input type="text" class="form-control" name="SCourse" placeholder="Course" id="course" aria-label="Course" value="<?php echo $login_faculty; ?>" readonly>
										</div>
										<div class="col">
											<input type="emial" class="form-control" name="SEmail" placeholder="Email" id="email" aria-label="Email" value="<?php echo $login_email; ?>" required>
										</div>
									</div>
									<br>
									<div class="row" style="float:right;">
										<button style="margin-right:15px" type="submit" name="UpdateProfile" class="btn btn-primary">Update Profile</button>
									</div>
								</form>
							</div>
						</div>

						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="two-box">
								<figure><img style="width:300px;height:250px;float:right" src="../EWSDcoursework/Layout/mainpage/images/gradurate.jpg" alt="#" /></figure>
							</div>
						</div>


					</div>
				</div>

			</div>
		</div>
</body>

<?php include '../EWSDcoursework/footer.php' ?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#inputImage").on('change', function() {
			$("#lblImg").text($(this).val());

		});

		$("#inputFile").on('change', function() {
			$("#lblfile").text($(this).val());

		});
	})


	// function sumit(btnclick){
	//     if($("#term").prop('checked') == true){
	//         alert("True");
	//     }
	//     else{
	//         alert("Please check the term & Condition.");
	//     }
	//     // $("#testsb").submit();
	// }
</script>

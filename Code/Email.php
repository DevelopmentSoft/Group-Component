<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	include 'Session.php';
	require 'vendor/autoload.php';
	
	// If btn  for Notify is clicked
	if(isset($_POST['SendComment'])){
		if(empty($_POST['Sid']) && empty($_POST['comm'])){
			echo "<script>alert('Unavailable'); window.location.replace('Faculty.php');</script>";
		}
		else{
			$sid = $_POST['Sid'];
			$comment = $_POST['comm'];
			
			// Multiple Recepient
			$sql2 = "SELECT * FROM student_tb WHERE Student_ID = $sid";
			$result2 = mysqli_query($conn, $sql2);
			$row = mysqli_fetch_assoc($result2);
			
			$mail = new PHPMailer();
			
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
			$mail->IsSMTP();
			$mail->SMTPAuth=true;
			
			//Gmail
			$sender_email ="khiewjames@gmail.com";
			$mail->Username = $sender_email;

			//App Password
			$mail->Password = "czrsmeapfcqzjzpy";
				
			//Recipeint's name
			$name="";
			$mail->From = $sender_email;
			$mail->FromName = "Marketing Coordinator of ". $row["Faculty"];
			$mail->Subject = "Comments Regarding the Contribution Submitted";

			
			$mail->AddAddress($row['Email'],$row['Name']);
			$mail->IsHTML(true);
			$mail->WordWrap = 50;
			$mail->Body = "<h1>Dear ".$row["Name"]." of ".$row["Faculty"].",</h1><br>
							<p>Below is the comment given by the Marketing Coordinator from me regarding the contribution you have submitted</p>
							<h4>$comment</p><br>Thank You!</h4>";
								
			if($mail->Send()){
				  echo "<script>alert('Email has been sent successfully'); window.location.replace('Faculty.php');</script>";
			}
			$mail->clearAddresses();
		}
	}
?>
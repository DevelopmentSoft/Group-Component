<?php
require_once("dbconn.php");

	$id = isset($_GET['id'])? $_GET['id'] : "";
	$sql = "SELECT * from contribution_tb WHERE id= $id";

	$result = mysqli_query($conn,$sql);
                                                    
	if(mysqli_num_rows($result)!=0) { 
	
	$row = mysqli_fetch_assoc($result);
		header('Content-Type:'. $row["Type"]);
		// output data of each row
		echo $row['filedata'];
	}

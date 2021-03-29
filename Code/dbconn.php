<?php
	define ("HOST",'localhost');
	define ("USERNAME",'root');
	define ("PASSWORD",'');
	define ("DATABASE",'unimaganzine_db');
	
	//create connection
	$conn = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);
	
	if (!$conn){
		echo "Fail";	
		//die("Connection Failed : ".mysqli_connect_error());
		
	}
?>
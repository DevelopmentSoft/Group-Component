<link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">

<?php include '../EWSDcoursework/Top.php' ?>

<?php
	$errors =array();
	require_once("dbconn.php");
	date_default_timezone_set('Asia/Kuala_Lumpur');
    
    
    //============ Pagination ============
	$query = "SELECT * FROM `event_tb`";
    $pageresult = mysqli_query($conn,$query);
 
	define("RPP",6);
	$totalRecords = mysqli_num_rows($pageresult);
    $number_pages = ceil($totalRecords / RPP);

    if(!isset($_GET['p'])){
        $curr_page = 1;
    }
    else{
        $curr_page = $_GET['p'];
    }
    $curr_result = ($curr_page - 1)* RPP;
    //============ Pagination End ============
    
    //============ Coordinator ===============
	if(isset($_POST["AddCoordinator"])){
		$name = $_POST["Name"];
		$password = $_POST["pass"];
		$email = $_POST["email"];
		$faculty = $_POST["course"];
		
		if(empty($email)){
			array_push($errors,"Email is required");
		}
		if(empty($name)){
			array_push($errors,"Userame is required");
		}
		if(empty($password)){
			array_push($errors,"Password is required");
		}
		
		$user_check_query = "SELECT * FROM management_tb WHERE `Management_ID` = '$login_session'";
		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);
			
		if ($user) { // if user exists
			if ($user['Management_ID'] === $sid) {
				array_push($errors, "Management ID already exists");
			}
		}
	
		//if there are no error,save user to database
		if(count($errors) == 0){
            $password=password_hash($password,PASSWORD_DEFAULT);//use to encrypt passowrd before storing in database;for security purpose)
		
            $insert ="INSERT INTO management_tb(Username,Password,Faculty,Email,Type)VALUES('$name','$password','$faculty','$email','coordinator')";
        
			if ($conn->query($insert) === TRUE) {
				echo "<script>alert('Coordinaotr has been added')</script>";
			}
			else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else{
			foreach($errors as $err){
				echo "<script>alert('$err')</script>";
			}
		}
	}
    //============Coordinator End ===============//
    //================= Event ===================//
    if(isset($_POST["CreateEvent"])){
        
		$EventName = $_POST["EventName"];
		$SDate = $_POST["StartDate"];
		$EDate = $_POST["EndDate"];
		
		if(empty($EventName)){
			array_push($errors,"Event Name is required");
		}
		if(empty($SDate)){
			array_push($errors,"Start Date is required");
		}
		if(empty($EDate)){
			array_push($errors,"End Date is required");
		}
        
        if(date('Y-m-d',strtotime($SDate)) >= date('Y-m-d',strtotime($EDate))){
            array_push($errors,"Invalid Date");
        }
        
        $user_check_query = "SELECT * FROM Event_tb WHERE `Name` = '$EventName'";
		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);
			
		if ($user) { // if user exists
			if ($user['Name'] === $EventName) {
				array_push($errors, "Name already exists");
			}
            
            if($user['Start_Date'] === $SDate){
                array_push($errors, "Start Date is already set");
            }
            
            if($user['End_Date'] === $EDate){
                array_push($errors, "End Date is already set");
            }
		}
        
        
		//if there are no error,save user to database
		if(count($errors) == 0){
            $insert ="INSERT INTO event_tb(Name,Start_Date,End_Date,Status)VALUES('$EventName','$SDate','$EDate','Active')";
        
			if ($conn->query($insert) === TRUE) {
				echo "<script>alert('Event has been created')</script>";
			}
			else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else{
			foreach($errors as $err){
				echo "<script>alert('$err')</script>";
			}
		}
    }
	?>
    




<body>

<!-- Event Management -->
<!-- our -->
<div id="txtarea" class="our">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Contribution Submission Date Management</h2>
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
                            
                                    <div class="container">
                                        <div class="infobody">

                                            <table id="table_id" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Status</th>
                                                        <!-- Open Date For Update only || Add Uploaded Deadline || Cancel Submission 1 wk b4 End Date-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $sql2 = "SELECT * FROM event_tb ORDER BY Start_Date ASC LIMIT $curr_result,".RPP;
                                                    $eventresult = mysqli_query($conn,$sql2);
                                                    
                                                    if(mysqli_num_rows($eventresult)!=0) { 
                                                    // output data of each row
                                                        while($Eventrow = mysqli_fetch_assoc($eventresult)) {
                                                            echo "<tr><td>" . $Eventrow["Name"]. "</td><td id='marker'>" . $Eventrow["Start_Date"]. "</td><td>" . $Eventrow["End_Date"]. "</td><td>" . $Eventrow["Status"]. "</td></tr>";
                                                        }
                                                    }
                                                    else{
                                                          echo "<tr><td colspan='3' style='text-align:center'> No Data </td></tr>";
                                                    }
                                                ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" id="Event_Form">
                                    <div class="row">
                                     <div class="col">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="EventName" placeholder="Event Name" aria-label="Event_Name" required>
                                        </div>
                                        <div class="col">
                                            <label>Start Date</label>
                                            <input type="date" class="form-control" name="StartDate" placeholder="Start Date" aria-label="Start_Date" required>
                                        </div>
                                        <div class="col">
                                            <label>End Date</label>
                                            <input type="date" class="form-control" name="EndDate" placeholder="End Date" aria-label="End_Date" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" style="float:right;">
                                        <button style="margin-left:20px;" type="submit" name="CreateEvent" class="btn btn-success">Create</button>
                                    </div>

                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Management End -->
    
    <!-- New Coordinator --> 
    
    <div id="txtarea" class="ourInvert">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2 style="color:snow;">Coordinator Registration Form</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 margin_bottom">
                <div class="row">

                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                        <div class="txtarea">
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" id="NewCO_Form">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="Name" placeholder="Name" id="COName" aria-label="name">
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <input type="password" class="form-control" name="pass" placeholder="Password" id="pass" aria-label="Password" required>
                                    </div>
                                    <div class="col">
                                        <input type="emial" class="form-control" name="email" placeholder="Email" id="email" aria-label="Email" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="course" placeholder="Course" id="course" aria-label="Course" required>
                                    </div>
                                </div>
                                <br>

                                <div class="row" style="float:right;">
                                    <button style="margin-left:20px;" type="submit" name="AddCoordinator" class="btn btn-primary">Create</button>
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
    <!-- New Coordinator End --> 
</div>

<!-- end our -->

</body>


<script src="../EWSDcoursework/Layout/mainpage/js/jquery-3.3.1.js"></script>
<script src="../EWSDcoursework/Layout/mainpage/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript"  src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function () {
        $('#table_id').DataTable();
    });
</script>

<?php include '../EWSDcoursework/footer.php' ?>



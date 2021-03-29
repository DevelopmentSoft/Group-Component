<?php include '../EWSDcoursework/Top.php' ?>

<?php
	$errors =array();
	require_once("dbconn.php");
	date_default_timezone_set('Asia/Kuala_Lumpur');

	//============ Pagination ============
	$query = "SELECT * FROM `student_tb` WHERE Faculty = '$login_faculty'";
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

	//============ New Student ============
	if(isset($_POST["CreateStu"])){
		$name = $_POST["Name"];
		$password = $_POST["pass"];
		$email = $_POST["email"];
		$course = $_POST["course"];
		$dob = $_POST["DateofBirth"];
		$gender = $_POST["GenRad"];

		// if(empty($sid)){
		// 	array_push($errors,"Student ID is required");
		// }
		if(empty($email)){
			array_push($errors,"Email is required");
		}
		if(empty($name)){
			array_push($errors,"Name is required");
		}
		if(empty($password)){
			array_push($errors,"Password is required");
		}


		//if there are no error,save user to database
		if(count($errors) == 0){
		$password=password_hash($password,PASSWORD_DEFAULT);//use to encrypt passowrd before storing in database;for security purpose)

		$insert ="INSERT INTO student_tb(Name,Password,Email,DOB,Gender,Faculty,Type)VALUES('$name','$password','$email','$dob','$gender','$course','student')";

			if ($conn->query($insert) === TRUE) {
				echo "<script>alert('Student has been added')</script>";
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
	//============ New Student End ============
	?>

<body>
    <!-- our -->
    <div id="txtarea" class="our">
         <!-- Student Creation Form-->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Create Student Profile</h2>
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
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" id="NewStu_Form">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="Name" placeholder="Name" id="StuName" aria-label="name">
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
                                        <div class="col">
                                            <input type="date" class="form-control" name="DateofBirth" placeholder="Birthdate" id="dob" aria-label="Birth-date" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                    <div class="col">
                                            <label for="inputState" class="form-label" style="font-size:20px;">Gender</label>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="GenRad" id="gridRadios1" value="Male" checked>
                                                    <label class="form-check-label" for="gridRadios1">
                                                    Male
                                                    </label>
                                                </div>
                                                <div class="form-check" style="margin-left:20px;">
                                                        <input class="form-check-input" type="radio" name="GenRad" id="gridRadios2" value="Female">
                                                        <label class="form-check-label" for="gridRadios2">
                                                        Female
                                                        </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="float:right;">
                                        <!-- <button style="margin-left:20px;" type="button" class="btn btn-success" onclick="AddStudent(this)">Create</button> -->
                                        <button style="margin-left:20px;" type="submit" name="CreateStu" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
		<!-- Student Creation Form End -->
	<!-- Student Table -->
	<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Students</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 margin_bottom">
                    <div class="row">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="txtarea">
                                <div class="container">
                                        <div class="infobody">

                                            <table id="table_id" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>DOB</th>
                                                        <th>Gender</th>
														<th>Email</th>
														<th>Faculty</th>
                                                        <!-- Open Date For Update only || Add Uploaded Deadline || Cancel Submission 1 wk b4 End Date-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $sql2 = "SELECT * FROM student_tb WHERE Faculty = '$login_faculty' ORDER BY Student_ID ASC LIMIT $curr_result,".RPP;
                                                    $eventresult = mysqli_query($conn,$sql2);

                                                    if(mysqli_num_rows($eventresult)!=0) {
                                                    // output data of each row
                                                        while($row = mysqli_fetch_assoc($eventresult)) {
                                                            echo "<tr><td>" . $row["Student_ID"]. "</td><td>". $row["Name"]. "</td><td>" . $row["DOB"]. "</td><td>" . $row["Gender"]. "</td><td>" . $row["Email"]. "</td><td>" . $row["Faculty"]. "</td></tr>";
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
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
		<!-- Student Table End -->

    </div>

    <!-- end our -->
</body>
<?php include '../EWSDcoursework/footer.php' ?>

<script type="text/javascript">
$(document).ready(function(){


})

function AddStudent(btnClicked){
	var form = $("#NewStu_Form");

	var id = form.find("#StuID").val();
	var name = form.find("#StuName").val();
	var pass = form.find("#pass").val();
	var email = form.find("#email").val();
	var course = form.find("#course").val();
	var dob = form.find("#dob").val();
	var gender = findSelection("GenRad");

	var data = {"Function":"Register","ID":id,"Name":name,"Password":pass,"Email":email,"Course":course,"DateofBirth":dob,"Gender":gender};

    $.ajax({
		url: "AccountManagement.php",
        data: data,
        type: "POST",
        dataType: "json",
        success: function(data) {
                alert("success");
        },
        error:function (){
            alert("Something is wrong");
        }
    });
}

function findSelection(field) {
    var test = document.getElementsByName(field);
    var sizes = test.length;

    for (i=0; i < sizes; i++) {
            if (test[i].checked==true) {
            return test[i].value;
        }
    }
}
</script>

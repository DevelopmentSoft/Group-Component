<link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">

<?php include '../EWSDcoursework/Top.php' ?>

<?php
	$errors =array();
	require_once("dbconn.php");
	date_default_timezone_set('Asia/Kuala_Lumpur');


    //============ Pagination ============
	$query = "SELECT * FROM `contribution_tb` WHERE Faculty = '$login_faculty'";
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
	?>


<body>

<!-- Event Management -->
<!-- our -->

<div id="txtarea" class="our">
        <div class="container" style="margin-left: 35px;"	>
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
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

                            <div class="txtarea">

                                    <div class="container">
                                        <div class="infobody">

                                            <table id="table_id" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Image</th>
                                                        <th>File</th>
                                                        <th>SubBy</th>
														<th>DateSubmitted</th>
														<th>Faculty</th>
														<th>Action</th>
                                                         <?php
                                                            if($login_type == "admin" || $login_type == "coordinator"|| $login_type == "Manager"){
                                                                echo '<th><button><a href="DownloadZip.php">Download as Zip</a></button></th>';
                                                            }
                                                         ?>
                                                        <!-- Open Date For Update only || Add Uploaded Deadline || Cancel Submission 1 wk b4 End Date-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                     if($login_session == null){
                                                          $sql2 = "SELECT * FROM contribution_tb ORDER BY DateSubmitted ASC LIMIT $curr_result,".RPP;
                                                       $eventresult = mysqli_query($conn,$sql2);

                                                       if(mysqli_num_rows($eventresult)!=0) {
                                                       // output data of each row
                                                        while($Eventrow = mysqli_fetch_assoc($eventresult)) {
                                                            echo "<tr><td>" . $Eventrow["Type"]. "</td><td><a target='_blank' href='ViewImg.php?id=".$Eventrow["ID"]."'>View Image</td><td><a target='_blank' href='View.php?id=".$Eventrow["ID"]."'>" . $Eventrow["File"]. "</td><td>" . $Eventrow["SubBy"]. "</td><td id='marker'>" . $Eventrow["DateSubmitted"]. "</td><td id='marker'>" . $Eventrow["Faculty"]. "</td></tr>";
                                                        }
                                                    }
                                                    else{
                                                          echo "<tr><td colspan='3' style='text-align:center'> No Data </td></tr>";
                                                    }
                                                     }
                                                     else{
                                                        $sql2 = "SELECT * FROM contribution_tb WHERE Faculty = '$login_faculty' ORDER BY DateSubmitted ASC LIMIT $curr_result,".RPP;
                                                       $eventresult = mysqli_query($conn,$sql2);

                                                    if(mysqli_num_rows($eventresult)!=0) {
                                                    // output data of each row
                                                        while($Eventrow = mysqli_fetch_assoc($eventresult)) {
                                                            // echo "<tr><td>" . $Eventrow["Type"]. "</td><td><a target='_blank' href='ViewImg.php?id=".$Eventrow["ID"]."'>View Image</td><td><a target='_blank' href='View.php?id=".$Eventrow["ID"]."'>" . $Eventrow["File"]. "</td><td>" . $Eventrow["SubBy"]. "</td><td id='marker'>" . $Eventrow["DateSubmitted"]. "</td><td id='marker'>" . $Eventrow["Faculty"]."</td></tr>";

																														echo "<tr>";
																														echo "<td>" . $Eventrow["Type"]. "</td>";
																														echo "<td><a target='_blank' href='ViewImg.php?id=".$Eventrow["ID"]."'>View Image</td>";
																														echo "<td><a target='_blank' href='View.php?id=".$Eventrow["ID"]."'>" . $Eventrow["File"]. "</td>";
																														echo "<td>" . $Eventrow["SubBy"]. "</td>";
																														echo "<td id='marker'>" . $Eventrow["DateSubmitted"]. "</td>";
																														echo "<td id='marker'>" . $Eventrow["Faculty"]."</td>";
																														echo "<td><a href='Contribution.php?Cid=".$Eventrow["ID"]."' class='btn btn-warning'>Comment</a></td>";
																														echo "</tr>";
                                                        }
                                                    }
                                                    else{
                                                          echo "<tr><td colspan='3' style='text-align:center'> No Data </td></tr>";
                                                    }
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
    </div>
    <!-- Event Management End -->
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

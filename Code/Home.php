<?php include '../EWSDcoursework/Top.php'; ?>
<?php 

//============ Pagination ============
	$query = "SELECT * FROM `contribution_tb`";
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
    <!-- our -->
<!--
    <div id="txtarea" class="our">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Home</h2>
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
                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Information</label>
                                    <input type="text" class="form-control" id="inputinfo" placeholder="Type" required>
                                </div>
                                <label for="Image" class="form-label">Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile04">
                                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                </div>

                                <label for="file" class="form-label">File</label>
                                <div class="custom-file" style="margin: 20px 0">
                                    <input type="file" class="custom-file-input" id="inputGroupFile04">
                                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                </div>
                                
                                <div class="row" style="float:right;">
                                <button type="button" class="btn btn-primary">Save Draft</button>
                                <button style="margin-left:20px;" type="button" class="btn btn-success" onclick="">Submit</button>
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
   
-->
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
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

                            <div class="txtarea">
                            
                                    <div class="container">
                                        <div class="infobody">

                                            <table id="table_id" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Image</th>
                                                        <th>File</th>
                                                        <th>SubBy</th>
														<th>DateSubmitted</th>
														<th>Faculty</th>
                                                        <!-- Open Date For Update only || Add Uploaded Deadline || Cancel Submission 1 wk b4 End Date-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
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
    <!-- end our -->

</body>

<?php include '../EWSDcoursework/footer.php' ?>

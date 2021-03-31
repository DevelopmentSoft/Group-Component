<?php include '../EWSDcoursework/Top.php'; ?>
<?php

//============ Pagination ============
$query = "SELECT * FROM `contribution_tb`";
$pageresult = mysqli_query($conn, $query);

define("RPP", 6);
$totalRecords = mysqli_num_rows($pageresult);
$number_pages = ceil($totalRecords / RPP);

if (!isset($_GET['p'])) {
    $curr_page = 1;
} else {
    $curr_page = $_GET['p'];
}
$curr_result = ($curr_page - 1) * RPP;
//============ Pagination End ============
?>

<body>
    <!-- our -->
    <div id="txtarea" class="our">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Contributions</h2>
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
                                                $sql2 = "SELECT * FROM contribution_tb ORDER BY DateSubmitted ASC LIMIT $curr_result," . RPP;
                                                $eventresult = mysqli_query($conn, $sql2);

                                                if (mysqli_num_rows($eventresult) != 0) {
                                                    // output data of each row
                                                    while ($Eventrow = mysqli_fetch_assoc($eventresult)) {
                                                        echo "<tr><td>" . $Eventrow["Type"] . "</td><td><a target='_blank' href='ViewImg.php?id=" . $Eventrow["ID"] . "'>View Image</td><td><a target='_blank' href='View.php?id=" . $Eventrow["ID"] . "'>" . $Eventrow["File"] . "</td><td>" . $Eventrow["SubBy"] . "</td><td id='marker'>" . $Eventrow["DateSubmitted"] . "</td><td id='marker'>" . $Eventrow["Faculty"] . "</td></tr>";
                                                    }
                                                } else {
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
            <div id="chart-container">
                <canvas id="graphCanvas"></canvas>
            </div>
        </div>
    </div>
    <!-- end our -->

</body>

<script src="../EWSDcoursework/Layout/mainpage/js/jquery-3.3.1.js"></script>
<script src="../EWSDcoursework/Layout/mainpage/js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        showGraph();
    });

    function showGraph() {

        var faculty = [];
        var total = [];

        $.ajax({
            url: "chartdata.php",
            type: "GET",
            dataType: "json",
            success: function(data) {

                //======== Loop Value into Array ===========
                for (var i in data) {
                    faculty.push(data[i].Faculty);
                    total.push(data[i].Total);
                }
                //======== Loop Value into Array End ===========

                //========== Chart ==========
                var chartdata = {
                    labels: faculty,
                    datasets: [{
                        label: faculty,
                        backgroundColor: '#49e2ff',
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#666666',
                        data: total
                    }]
                };

                var graphTarget = $("#graphCanvas");

                var barGraph = new Chart(graphTarget, {
                    type: 'bar',
                    data: chartdata
                });
                //========== End Chart ===========
            },
            error: function(data) {
                console.log(data);
                alert("Something wrong");
            }
        });
    }
</script>

<?php include '../EWSDcoursework/footer.php' ?>
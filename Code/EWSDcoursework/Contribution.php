<?php include '../EWSDcoursework/Top.php' ?>

<?php
$errors = array();

if (!empty($_GET["Cid"])) {
    $cid = $_GET["Cid"];
} else {
    echo "<script>location.replace('index.php')</script>";
}
?>

<body>
    <style>
        #CommentTxt {
            width: 100%;
            font-size: x-large;
            padding-left: 10px;
            border: none;
        }
    </style>

    <!-- our -->
    <div id="txtarea" class="our">
        <div class="container" style="padding-left: 0px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Comments</h2>
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
                                        <div class="" id="contributioninfo">
                                            <table id="table_id" class="table">
                                                <thead>
                                                    <tr>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Image</th>
                                                        <th>File</th>
                                                        <th>SubBy</th>
                                                        <th>DateSubmitted</th>
                                                        <th>Faculty</th>
                                                    </tr>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql2 = "SELECT * FROM contribution_tb WHERE ID = '$cid'";
                                                    $eventresult = mysqli_query($conn, $sql2);

                                                    if (mysqli_num_rows($eventresult) != 0) {
                                                        // output data of each row
                                                        while ($Eventrow = mysqli_fetch_assoc($eventresult)) {
                                                            echo "<tr><td>" . $Eventrow["Type"] . "</td><td><a target='_blank' href='ViewImg.php?id=" . $Eventrow["ID"] . "'>View Image</td><td><a target='_blank' href='View.php?id=" . $Eventrow["ID"] . "'>" . $Eventrow["File"] . "</td><td id='subby'>" . $Eventrow["SubBy"] . "</td><td>" . $Eventrow["DateSubmitted"] . "</td><td id='marker'>" . $Eventrow["Faculty"] . "</td></tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='3' style='text-align:center;' > No Data </td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="" id="commentsection" style="max-height:200px;overflow:auto;">
                                            <?php
                                            $sql3 = "SELECT * FROM comment_tb WHERE Contribution_ID = $cid";
                                            $commres = mysqli_query($conn, $sql3);

                                            if (mysqli_num_rows($commres) != 0) {
                                                while ($comrow = mysqli_fetch_assoc($commres)) {
                                                    if ($comrow['InsertBy'] == "coordinator") {
                                                        echo "<input type='text' value='" . $comrow['Comment'] . "' id='CommentTxt' style='text-align:right' readonly><br>";
                                                        echo "<span style='float:right;margin-top:5px'>" . $comrow['DateTime'] . "</span>";
                                                    } else {
                                                        echo "<input type='text' value='" . $comrow['Comment'] . "' id='CommentTxt' readonly><br>";
                                                        echo "<span>" . $comrow['DateTime'] . "</span>";
                                                    }
                                                }
                                            } else {
                                                echo "<input type='text' id='CommentTxt' readonly>";
                                                echo "<span>" . date("d-m-Y h:ia") . "</span>";
                                            }
                                            ?>
                                        </div>

                                        <div class="" id="comment">
                                            <form>
                                                <input type='text' value='<?php echo $cid ?>' id='cid' readonly hidden>
                                                <div class="row">
                                                    <div class="col" style="padding-top:20px;">
                                                        <label for="floatingTextarea">Comments</label>
                                                        <textarea class="form-control" placeholder="Leave a comment here" name="NewCom" id="NewCom"></textarea>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row" style="float:right;">
                                                    <button type="button" style="margin-left:20px;" class="btn btn-success" name="SendComment" onclick="Send()">Send</button>
                                                </div>
                                            </form>
                                        </div>
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
    <!-- Modal End -->
</body>


<script src="../EWSDcoursework/Layout/mainpage/js/jquery-3.3.1.js"></script>
<script src="../EWSDcoursework/Layout/mainpage/js/jquery-3.3.1.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_id').DataTable();

    });

    function Send() {
        $.ajax({
            url: "comment.php",
            data: {
                "Comment": $("#NewCom").val(),
                "Cid": $("#cid").val()
            },
            type: "POST",
            dataType: "json",
            success: function(data) {

                alert(data);
            },
            error: function(data) {
                console.log(data);
                alert("Something wrong");
            }
        });
    }
</script>

<?php include '../EWSDcoursework/footer.php' ?>
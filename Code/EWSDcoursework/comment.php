<?php

 require_once 'Session.php';
 date_default_timezone_set('Asia/Kuala_Lumpur');
 
if (isset($_POST["Comment"]) && isset($_POST["Cid"])) {
        $c = $_POST["Comment"];
        $cdt = date("Y-m-d h:ia");
        $cid = $_POST["Cid"];


        $insert = "INSERT INTO comment_tb(InsertBy,`User_ID`,`DateTime`,Contribution_ID,Comment)VALUES('$login_type','$login_session','$cdt','$cid','$c')";

        if ($conn->query($insert) === TRUE) {
            echo json_encode("Comment have been saved");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>
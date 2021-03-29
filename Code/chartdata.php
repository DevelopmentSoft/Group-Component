<?php
header('Content-Type: application/json');

require_once "dbconn.php";

$sqlQuery = "SELECT DISTINCT `Faculty` FROM `contribution_tb` ORDER BY ID";

$result = mysqli_query($conn, $sqlQuery);

$data = array();
foreach ($result as $row) {

    $sql1 = "SELECT Faculty,COUNT(Faculty) AS Total FROM `contribution_tb` WHERE `Faculty` ='". $row["Faculty"]."'";
    $result1 = mysqli_query($conn, $sql1);

    foreach ($result1 as $i) {

        $data[] = $i;
    }
}

echo json_encode($data);
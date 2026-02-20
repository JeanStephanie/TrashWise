<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $waste_type = mysqli_real_escape_string($conn, $_POST['waste_type']);
    $date = $_POST['collection_date'];
    $time = $_POST['collection_time'];

    $sql = "
        INSERT INTO collection_schedule 
        (area, waste_type, collection_date, collection_time)
        VALUES ('$area','$waste_type','$date','$time')
    ";

    mysqli_query($conn, $sql);
}

header("Location: collection_schedule.php");
exit;

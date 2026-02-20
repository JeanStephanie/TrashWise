<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = intval($_POST['schedule_id']);
    $area = trim($_POST['area']);
    $waste_type = trim($_POST['waste_type']);
    $date = $_POST['collection_date'];
    $time = $_POST['collection_time'];

    $stmt = $conn->prepare("
        UPDATE collection_schedule
        SET area=?, waste_type=?, collection_date=?, collection_time=?
        WHERE schedule_id=?
    ");

    $stmt->bind_param("ssssi",
        $area, $waste_type, $date, $time, $id
    );

    $stmt->execute();
}

header("Location: collection_schedule.php");
exit;
?>

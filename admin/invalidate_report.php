<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['report_id'])) {
        header("Location: waste_reports.php");
        exit;
    }

    $report_id = (int) $_POST['report_id'];

    mysqli_query($conn, "
        UPDATE waste_reports
        SET status = 'Invalid'
        WHERE report_id = $report_id AND status = 'Pending'
    ");
}

header("Location: waste_reports.php");
exit;

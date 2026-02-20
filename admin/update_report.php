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

    /* Mark as Resolved */
    mysqli_query($conn, "
        UPDATE waste_reports
        SET status = 'Resolved'
        WHERE report_id = $report_id AND status = 'Pending'
    ");

    /* Get report owner */
    $res = mysqli_query($conn, "
        SELECT user_id FROM waste_reports WHERE report_id = $report_id
    ");
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        $user_id = $row['user_id'];
        $points = 10;

        /* Prevent duplicate points */
        $check = mysqli_query($conn, "
            SELECT rp_id FROM reward_points WHERE report_id = $report_id
        ");

        if (mysqli_num_rows($check) === 0) {
            mysqli_query($conn, "
                INSERT INTO reward_points (user_id, report_id, points)
                VALUES ($user_id, $report_id, $points)
            ");
        }
    }
}

header("Location: waste_reports.php");
exit;

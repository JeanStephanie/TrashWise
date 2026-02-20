<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    mysqli_query($conn, "DELETE FROM collection_schedule WHERE schedule_id=$id");
}

header("Location: collection_schedule.php");
exit;

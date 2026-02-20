<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$newName = trim($_POST['name']);
$newArea = trim($_POST['area']);

/* Basic validation */
if (empty($newName)) {
    header("Location: dashboard.php");
    exit;
}

/* Update database */
$stmt = $conn->prepare("
    UPDATE users 
    SET name = ?, area = ? 
    WHERE user_id = ?
");
$stmt->bind_param("ssi", $newName, $newArea, $user_id);
$stmt->execute();

/* Update session instantly */
$_SESSION['user_name'] = $newName;

/* Redirect back */
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

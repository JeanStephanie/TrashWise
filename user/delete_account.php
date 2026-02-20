<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

/*
IMPORTANT:
If waste_reports has a FOREIGN KEY linked to users,
you must delete reports first.
*/

// 1️⃣ Delete user's reports (if needed)
mysqli_query($conn, "DELETE FROM waste_reports WHERE user_id = $user_id");

// 2️⃣ Delete user account
mysqli_query($conn, "DELETE FROM users WHERE user_id = $user_id");

// 3️⃣ Destroy session
session_unset();
session_destroy();

// 4️⃣ Redirect to homepage
header("Location: ../index.php");
exit;
?>

<?php
include "auth_check.php";
include "../includes/db.php";

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id    = $_SESSION['user_id'];
    $issue_type = mysqli_real_escape_string($conn, $_POST['issue_type']);
    $desc       = mysqli_real_escape_string($conn, $_POST['description']);
    $location   = mysqli_real_escape_string($conn, $_POST['location']);

    $imageName = "";

    if (!empty($_FILES['image']['name'])) {

        $uploadDir = __DIR__ . "/../uploads/reports/";

        // Create folder if missing
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];

        if (!in_array($ext, $allowed)) {
            $error = "Only JPG, JPEG, PNG images allowed";
        } else {

            $safeName = preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['image']['name']);
            $imageName = time() . "_" . $safeName;

            $targetPath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $error = "Image upload failed!";
            }
        }
    }

    if ($error === "") {

        $sql = "INSERT INTO waste_reports
                (user_id, issue_type, description, image, location)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $issue_type, $desc, $imageName, $location);

        if ($stmt->execute()) {
            $success = "Waste issue reported successfully!";
        } else {
            $error = "Database error!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Report Issue | TrashWise</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php include "navbar.php"; ?>

<div class="container py-5">
<div class="col-md-6 mx-auto">

<div class="card shadow">
<div class="card-header bg-success text-white">
    Report Waste Issue
</div>

<div class="card-body">

<?php if ($success): ?>
<div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>Issue Type</label>
<select name="issue_type" class="form-select" required>
    <option value="">-- Select --</option>
    <option>Overflowing Bin</option>
    <option>Illegal Dumping</option>
    <option>Missed Collection</option>
    <option>Other</option>
</select>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Location</label>
<input type="text" name="location" class="form-control" required>
</div>

<div class="mb-3">
<label>Upload Image (optional)</label>
<input type="file" name="image" class="form-control">
</div>

<button class="btn btn-success w-100">Submit Report</button>

</form>
</div>
</div>
</div>
</div>

</body>
</html>

<?php
session_start();
include "../includes/db.php";

if (!isset($_GET['id'])) {
    header("Location: awareness.php");
    exit;
}

$id = intval($_GET['id']);

$post = mysqli_query($conn,
    "SELECT * FROM awareness_posts WHERE post_id=$id");

if (mysqli_num_rows($post) == 0) {
    header("Location: awareness.php");
    exit;
}

$row = mysqli_fetch_assoc($post);
?>

<!DOCTYPE html>
<html>
<head>
<title><?= htmlspecialchars($row['title']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<div class="card shadow">
<div class="card-body">

<h3 class="mb-3">
<?= htmlspecialchars($row['title']) ?>
</h3>

<p class="text-muted small">
<?= date("d M Y", strtotime($row['created_at'])) ?>
</p>

<img src="../uploads/awareness/<?= $row['image'] ?>"
     class="img-fluid rounded mb-4"
     style="max-height:400px; object-fit:contain; width:100%; background:#f8f9fa;">

<p>
<?= nl2br(htmlspecialchars($row['content'])) ?>
</p>

<a href="dashboard.php" class="btn btn-secondary mt-3">
Back to Posts
</a>

</div>
</div>

</div>

</body>
</html>

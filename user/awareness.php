<?php
include "auth_check.php";
include "../includes/db.php";

$posts = mysqli_query($conn,
    "SELECT * FROM awareness_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Awareness Posts</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include "navbar.php"; ?>

<div class="container py-5">

<h3 class="mb-4">Awareness & Announcements</h3>

<div class="row">

<?php while($row=mysqli_fetch_assoc($posts)): ?>

<div class="col-md-4 mb-4">
<div class="card h-100 shadow-sm">

<img src="../uploads/awareness/<?= $row['image'] ?>"
     class="card-img-top"
     style="height:180px; object-fit:contain; background:#f8f9fa;">

<div class="card-body">

<h5><?= htmlspecialchars($row['title']) ?></h5>

<p class="text-muted small">
<?= substr(htmlspecialchars($row['content']),0,100) ?>...
</p>

<a href="view_post.php?id=<?= $row['post_id'] ?>"
   class="btn btn-success btn-sm">
   Read More
</a>

</div>
</div>
</div>

<?php endwhile; ?>

</div>
</div>

</body>
</html>

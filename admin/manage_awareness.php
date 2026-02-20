<?php
include "admin_auth.php";

include "../includes/db.php";

/* ADD POST */
if (isset($_POST['submit'])) {

    $title   = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $imageName = $_FILES['image']['name'];
    $imageTmp  = $_FILES['image']['tmp_name'];

    $uploadPath = "../uploads/awareness/" . $imageName;

    if (move_uploaded_file($imageTmp, $uploadPath)) {

        $query = "INSERT INTO awareness_posts (title, content, image)
                  VALUES ('$title', '$content', '$imageName')";

        mysqli_query($conn, $query);
    }
}

/* DELETE POST */
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $getImage = mysqli_query($conn,
        "SELECT image FROM awareness_posts WHERE post_id=$id");

    $row = mysqli_fetch_assoc($getImage);
    $imagePath = "../uploads/awareness/" . $row['image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    mysqli_query($conn,
        "DELETE FROM awareness_posts WHERE post_id=$id");

    header("Location: manage_awareness.php");
    exit;
}

/* FETCH POSTS */
$posts = mysqli_query($conn,
    "SELECT * FROM awareness_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Awareness | Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background:#f4f7f6; }
img.preview { width:80px; height:60px; object-fit:cover; border-radius:6px; }
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<?php include "admin_sidebar.php"; ?>

<div class="col-md-10 p-4">

<h3 class="mb-4">
    <i class="bi bi-megaphone"></i> Awareness Posts
</h3>

<!-- ADD POST FORM -->
<div class="card shadow mb-4">
<div class="card-body">

<h5 class="mb-3">Add New Post</h5>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <input type="text"
               name="title"
               class="form-control"
               placeholder="Post Title"
               required>
    </div>

    <div class="mb-3">
        <textarea name="content"
                  rows="4"
                  class="form-control"
                  placeholder="Post Content"
                  required></textarea>
    </div>

    <div class="mb-3">
        <input type="file"
               name="image"
               class="form-control"
               required>
    </div>

    <button type="submit"
            name="submit"
            class="btn btn-success">
        Publish Post
    </button>

</form>

</div>
</div>

<!-- POSTS TABLE -->
<div class="card shadow">
<div class="card-body table-responsive">

<table class="table table-bordered align-middle">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Image</th>
    <th>Title</th>
    <th>Content</th>
    <th>Date</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php if (mysqli_num_rows($posts) > 0): ?>
<?php $i=1; while($row=mysqli_fetch_assoc($posts)): ?>

<tr>
    <td><?= $i++ ?></td>

    <td>
        <img src="../uploads/awareness/<?= $row['image'] ?>"
             class="preview">
    </td>

    <td><?= htmlspecialchars($row['title']) ?></td>

    <td>
        <?= substr(htmlspecialchars($row['content']),0,80) ?>...
    </td>

    <td>
        <?= date("d M Y", strtotime($row['created_at'])) ?>
    </td>

    <td>
        <div class="d-flex gap-2">
            
            <a href="edit_awareness.php?id=<?= $row['post_id'] ?>"
            class="btn btn-primary btn-sm">
            Edit
            </a>

            <a href="?delete=<?= $row['post_id'] ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('Delete this post?')">
                Delete
            </a>

        </div>
    </td>

</tr>

<?php endwhile; ?>
<?php else: ?>

<tr>
<td colspan="6" class="text-center text-muted">
No awareness posts found
</td>
</tr>

<?php endif; ?>

</tbody>
</table>

</div>
</div>

</div>
</div>
</div>

</body>
</html>

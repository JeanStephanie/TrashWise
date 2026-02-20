<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

$id = intval($_GET['id']);

$result = mysqli_query($conn,
    "SELECT * FROM awareness_posts WHERE post_id=$id");

$post = mysqli_fetch_assoc($result);

if (!$post) {
    header("Location: manage_awareness.php");
    exit;
}

/* UPDATE POST */
if (isset($_POST['update'])) {

    $title   = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    /* Check if new image uploaded */
    if (!empty($_FILES['image']['name'])) {

        $imageName = $_FILES['image']['name'];
        $imageTmp  = $_FILES['image']['tmp_name'];
        $uploadPath = "../uploads/awareness/" . $imageName;

        /* Delete old image */
        $oldImage = "../uploads/awareness/" . $post['image'];
        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        move_uploaded_file($imageTmp, $uploadPath);

        mysqli_query($conn,
            "UPDATE awareness_posts
             SET title='$title',
                 content='$content',
                 image='$imageName'
             WHERE post_id=$id");

    } else {

        mysqli_query($conn,
            "UPDATE awareness_posts
             SET title='$title',
                 content='$content'
             WHERE post_id=$id");
    }

    header("Location: manage_awareness.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Awareness Post</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card shadow">
<div class="card-body">

<h4 class="mb-4">Edit Post</h4>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text"
               name="title"
               value="<?= htmlspecialchars($post['title']) ?>"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content"
                  rows="5"
                  class="form-control"
                  required><?= htmlspecialchars($post['content']) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Current Image</label><br>
        <img src="../uploads/awareness/<?= $post['image'] ?>"
             width="120"
             class="mb-2">
    </div>

    <div class="mb-3">
        <label class="form-label">Change Image (optional)</label>
        <input type="file"
               name="image"
               class="form-control">
    </div>

    <button type="submit"
            name="update"
            class="btn btn-success">
        Update Post
    </button>

    <a href="manage_awareness.php"
       class="btn btn-secondary">
        Cancel
    </a>

</form>

</div>
</div>
</div>

</body>
</html>

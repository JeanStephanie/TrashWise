<?php
include "auth_check.php";
include "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM waste_reports 
        WHERE user_id = ? 
        ORDER BY reported_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Reports | TrashWise</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
img.report-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
}
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container py-5">

<h3 class="mb-4">My Submitted Reports</h3>

<?php if ($result->num_rows === 0): ?>
    <div class="alert alert-info">
        You haven’t submitted any reports yet.
    </div>
<?php else: ?>

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">

<thead class="table-success">
<tr>
    <th>#</th>
    <th>Issue</th>
    <th>Description</th>
    <th>Location</th>
    <th>Image</th>
    <th>Status</th>
    <th>Reported On</th>
</tr>
</thead>

<tbody>
<?php $i = 1; ?>
<?php while ($row = $result->fetch_assoc()): ?>

<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($row['issue_type']) ?></td>
    <td><?= htmlspecialchars($row['description']) ?></td>
    <td><?= htmlspecialchars($row['location']) ?></td>

    <td>
        <?php if (!empty($row['image'])): ?>
            <img src="../uploads/reports/<?= $row['image'] ?>" class="report-img">
        <?php else: ?>
            <span class="text-muted">No Image</span>
        <?php endif; ?>
    </td>

    <td>
        <?php
        $status = $row['status'];
        $badge = "secondary";

        if ($status === "Pending") $badge = "warning";
        if ($status === "In Progress") $badge = "info";
        if ($status === "Resolved") $badge = "success";
        ?>
        <span class="badge bg-<?= $badge ?>">
            <?= $status ?>
        </span>
    </td>

    <td>
        <?= date("d M Y", strtotime($row['reported_at'])) ?>
    </td>
</tr>

<?php endwhile; ?>
</tbody>

</table>
</div>

<?php endif; ?>

</div>

</body>
</html>

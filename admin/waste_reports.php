<?php
include "admin_auth.php";

include "../includes/db.php";

/* FILTER */
$where = "";
if (isset($_GET['status']) && $_GET['status'] !== "") {
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    $where = "WHERE wr.status = '$status'";
}

/* FETCH REPORTS */
$sql = "
    SELECT wr.*, u.name 
    FROM waste_reports wr
    JOIN users u ON wr.user_id = u.user_id
    $where
    ORDER BY wr.report_id DESC
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Waste Reports</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background:#f4f7f6; }

.badge.Pending { background:#ffc107; color:#000; }
.badge.Resolved { background:#198754; }
.badge.Invalid { background:#dc3545; }
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<?php include "admin_sidebar.php"; ?>

<div class="col-md-10 p-4">

<h3 class="mb-4">Waste Reports</h3>

<!-- FILTER -->
<form method="GET" class="mb-3">
    <select name="status" class="form-select w-auto" onchange="this.form.submit()">
        <option value="">All</option>
        <option value="Pending" <?= (isset($_GET['status']) && $_GET['status']=='Pending')?'selected':'' ?>>Pending</option>
        <option value="Resolved" <?= (isset($_GET['status']) && $_GET['status']=='Resolved')?'selected':'' ?>>Resolved</option>
        <option value="Invalid" <?= (isset($_GET['status']) && $_GET['status']=='Invalid')?'selected':'' ?>>Invalid</option>
    </select>
</form>

<div class="card shadow">
<div class="card-body table-responsive">

<table class="table table-bordered align-middle">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>User</th>
    <th>Issue</th>
    <th>Description</th>
    <th>Location</th>
    <th>Image</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
<?php if (mysqli_num_rows($result) > 0): ?>
<?php $i=1; while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['issue_type']) ?></td>
    <td><?= htmlspecialchars($row['description']) ?></td>
    <td><?= htmlspecialchars($row['location']) ?></td>

    <td>
        <?php if ($row['image']): ?>
            <img src="../uploads/reports/<?= htmlspecialchars($row['image']) ?>" width="60">
        <?php else: ?>
            <span class="text-muted">No Image</span>
        <?php endif; ?>
    </td>

    <td>
        <span class="badge <?= $row['status'] ?>">
            <?= $row['status'] ?>
        </span>
    </td>

   <td>
    <?php if ($row['status'] === 'Pending'): ?>

        <div class="d-flex justify-content-center gap-2">

            <form method="POST" action="update_report.php">
                <input type="hidden" name="report_id" value="<?= $row['report_id'] ?>">
                <button class="btn btn-success btn-sm px-2 py-1"
                        onclick="return confirm('Mark as resolved?')">
                    Resolve
                </button>
            </form>

            <form method="POST" action="invalidate_report.php">
                <input type="hidden" name="report_id" value="<?= $row['report_id'] ?>">
                <button class="btn btn-danger btn-sm px-2 py-1"
                        onclick="return confirm('Mark as invalid?')">
                    Invalid
                </button>
            </form>

        </div>

    <?php else: ?>
        <span class="text-muted">Done</span>
    <?php endif; ?>
    </td>

</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="8" class="text-center text-muted">No reports found</td>
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

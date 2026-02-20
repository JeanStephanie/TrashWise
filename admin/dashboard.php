<?php
include "admin_auth.php";

include "../includes/db.php";

/* ===== STATS ===== */

$totalUsers = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM users")
)['total'];

$totalReports = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM waste_reports")
)['total'];

$pendingReports = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM waste_reports WHERE status='Pending'")
)['total'];

$resolvedReports = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM waste_reports WHERE status='Resolved'")
)['total'];

/* ===== RECENT REPORTS ===== */

$recent = mysqli_query($conn,"
    SELECT * FROM waste_reports
    ORDER BY reported_at DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: #f4f7f6;
}

/* GREEN CARD STYLE */
.green-card {
    background: linear-gradient(135deg, #198754, #2ecc71);
    color: white;
    border-radius: 15px;
    padding: 20px;
    transition: 0.3s;
}

.green-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.green-card h6 {
    font-size: 14px;
    opacity: 0.9;
}

.green-card h2 {
    font-weight: bold;
}

.table thead {
    background: #e9ecef;
}
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<?php include "admin_sidebar.php"; ?>

<div class="col-md-10 p-4">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Admin Dashboard</h4>
    <span class="text-muted">
        <?= date("d M Y") ?>
    </span>
</div>

<!-- ===== STAT CARDS ===== -->
<div class="row g-4">

    <div class="col-md-3">
        <div class="green-card shadow">
            <h6>Total Users</h6>
            <h2><?= $totalUsers ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="green-card shadow">
            <h6>Total Reports</h6>
            <h2><?= $totalReports ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="green-card shadow">
            <h6>Pending Reports</h6>
            <h2><?= $pendingReports ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="green-card shadow">
            <h6>Resolved Reports</h6>
            <h2><?= $resolvedReports ?></h2>
        </div>
    </div>

</div>

<!-- ===== RECENT REPORTS ===== -->

<div class="card mt-5 shadow">
<div class="card-body">

<h5 class="mb-3">Recent Reports</h5>

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>User ID</th>
    <th>Issue Type</th>
    <th>Location</th>
    <th>Status</th>
    <th>Date</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($recent) > 0): ?>
<?php while($r = mysqli_fetch_assoc($recent)): ?>
<tr>
    <td><?= $r['user_id'] ?></td>
    <td><?= htmlspecialchars($r['issue_type']) ?></td>
    <td><?= htmlspecialchars($r['location']) ?></td>
    <td>
        <span class="badge bg-<?=
            $r['status']=='Resolved' ? 'success' :
            ($r['status']=='Pending' ? 'warning text-dark' :
            'secondary')
        ?>">
            <?= $r['status'] ?>
        </span>
    </td>
    <td><?= date("d M Y", strtotime($r['reported_at'])) ?></td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="5" class="text-center text-muted">
        No reports found
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

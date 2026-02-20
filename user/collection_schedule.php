<?php
include "auth_check.php";

include "../includes/db.php";

$where = "";

if (isset($_GET['area']) && $_GET['area'] != "") {
    $area = mysqli_real_escape_string($conn, $_GET['area']);
    $where = "WHERE area='$area'";
}

$sql = "
    SELECT * FROM collection_schedule
    $where
    ORDER BY collection_date ASC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Collection Schedule</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container mt-4">

<h3 class=" mb-4 ">
    <i class="bi bi-truck"></i> Upcoming Collection Schedule
</h3>

<!-- Filter -->
<form method="GET" class="mb-3">
    <input type="text" name="area"
           placeholder="Enter your area"
           class="form-control w-25 d-inline me-2"
           value="<?= isset($_GET['area']) ? htmlspecialchars($_GET['area']) : '' ?>">

    <button class="btn btn-success me-2">
        <i class="bi bi-funnel-fill"></i> Filter
    </button>

    <?php if(!empty($_GET['area'])): ?>
        <a href="collection_schedule.php" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle"></i> Clear
        </a>
    <?php endif; ?>
</form>

<table class="table table-bordered">
<thead class="table-success">
<tr>
    <th>Area</th>
    <th>Waste Type</th>
    <th>Date</th>
    <th>Time</th>
</tr>
</thead>

<tbody>
<?php if(mysqli_num_rows($result) > 0): ?>
    <?php while($row=mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= htmlspecialchars($row['area']) ?></td>
        <td><?= htmlspecialchars($row['waste_type']) ?></td>
        <td>
            <i class="bi bi-calendar-event text-success"></i>
            <?= date("d M Y", strtotime($row['collection_date'])) ?>
        </td>
        <td>
            <i class="bi bi-clock text-success"></i>
            <?= date("h:i A", strtotime($row['collection_time'])) ?>
        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="4" class="text-center text-muted">
        No collection schedule found for this area.
    </td>
</tr>
<?php endif; ?>

</tbody>

</table>

</div>

</body>
</html>

<?php
include "admin_auth.php";

include "../includes/db.php";

/* Fetch schedules */
$sql = "SELECT * FROM collection_schedule ORDER BY collection_date ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Collection Schedule | Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background:#f4f7f6; }
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<?php include "admin_sidebar.php"; ?>

<div class="col-md-10 p-4">

<h3 class="mb-4">
    <i class="bi bi-calendar-event"></i> Collection Schedule
</h3>

<!-- ADD SCHEDULE FORM -->
<div class="card shadow mb-4">
<div class="card-body">

<h5 class="mb-3">Add New Schedule</h5>

<form method="POST" action="add_schedule.php" class="row g-3">

    <div class="col-md-3">
        <input type="text" name="area" class="form-control"
               placeholder="Area" required>
    </div>

    <div class="col-md-3">
        <select name="waste_type" class="form-select" required>
            <option value="">Select Waste Type</option>
            <option value="Dry Waste">Dry Waste</option>
            <option value="Wet Waste">Wet Waste</option>
        </select>
    </div>

    <div class="col-md-2">
        <input type="date" name="collection_date"
               class="form-control" required>
    </div>

    <div class="col-md-2">
        <input type="time" name="collection_time"
               class="form-control" required>
    </div>

    <div class="col-md-2">
        <button class="btn btn-success w-100">
            Add
        </button>
    </div>

</form>

</div>
</div>

<!-- SCHEDULE TABLE -->
<div class="card shadow">
<div class="card-body table-responsive">

<table class="table table-bordered align-middle">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Area</th>
    <th>Waste Type</th>
    <th>Date</th>
    <th>Time</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
<?php if (mysqli_num_rows($result) > 0): ?>
<?php $i=1; while($row=mysqli_fetch_assoc($result)): ?>

<tr>

<?php if (isset($_GET['edit']) && $_GET['edit'] == $row['schedule_id']): ?>

<form method="POST" action="update_schedule.php">

    <td><?= $i++ ?></td>

    <td>
        <input type="text" name="area"
               value="<?= htmlspecialchars($row['area']) ?>"
               class="form-control" required>
    </td>

    <td>
        <select name="waste_type" class="form-select" required>
            <option value="Dry Waste"
                <?= $row['waste_type']=="Dry Waste"?"selected":"" ?>>
                Dry Waste
            </option>
            <option value="Wet Waste"
                <?= $row['waste_type']=="Wet Waste"?"selected":"" ?>>
                Wet Waste
            </option>
        </select>
    </td>

    <td>
        <input type="date" name="collection_date"
               value="<?= $row['collection_date'] ?>"
               class="form-control" required>
    </td>

    <td>
        <input type="time" name="collection_time"
               value="<?= $row['collection_time'] ?>"
               class="form-control" required>
    </td>

    <input type="hidden" name="schedule_id"
           value="<?= $row['schedule_id'] ?>">

    <td>
        <button class="btn btn-primary btn-sm">Update</button>
        <a href="collection_schedule.php"
           class="btn btn-secondary btn-sm">Cancel</a>
    </td>

</form>

<?php else: ?>

    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($row['area']) ?></td>
    <td><?= htmlspecialchars($row['waste_type']) ?></td>
    <td><?= date("d M Y", strtotime($row['collection_date'])) ?></td>
    <td><?= date("h:i A", strtotime($row['collection_time'])) ?></td>
    <td>
        <a href="collection_schedule.php?edit=<?= $row['schedule_id'] ?>"
           class="btn btn-primary btn-sm">Edit</a>

        <a href="delete_schedule.php?id=<?= $row['schedule_id'] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete this schedule?')">
           Delete
        </a>
    </td>

<?php endif; ?>

</tr>

<?php endwhile; ?>
<?php else: ?>

<tr>
<td colspan="6" class="text-center text-muted">
No schedules found
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

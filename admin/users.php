<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7f6;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <?php include "admin_sidebar.php"; ?>

        <!-- MAIN CONTENT -->
        <div class="col-md-10 p-4">

            <h3 class="mb-4">
                <i class="bi bi-people-fill"></i> Registered Users
            </h3>

            <div class="card shadow">
                <div class="card-body table-responsive">

                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Total Reports</th>
                                <th>Reward Points</th>
                                <th>Joined On</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $sql = "
                            SELECT 
                                u.user_id,
                                u.name,
                                u.email,
                                u.created_at,
                                COALESCE(r.total_reports, 0) AS total_reports,
                                COALESCE(p.total_points, 0) AS total_points
                            FROM users u

                            LEFT JOIN (
                                SELECT user_id, COUNT(*) AS total_reports
                                FROM waste_reports
                                GROUP BY user_id
                            ) r ON u.user_id = r.user_id

                            LEFT JOIN (
                                SELECT user_id, SUM(points) AS total_points
                                FROM reward_points
                                GROUP BY user_id
                            ) p ON u.user_id = p.user_id

                            ORDER BY u.created_at DESC
                        ";

                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0):
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= $row['total_reports'] ?></td>
                                <td>
                                    <span class="badge bg-success">
                                        <?= $row['total_points'] ?> pts
                                    </span>
                                </td>
                                <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                            </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No users found
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

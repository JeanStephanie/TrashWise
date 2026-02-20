<?php
include "auth_check.php";

include "../includes/db.php";

$user_id   = $_SESSION['user_id'];
$userName  = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];

/* Total reports */
$reportQuery = "SELECT COUNT(*) AS total_reports FROM waste_reports WHERE user_id = $user_id";
$reportResult = mysqli_query($conn, $reportQuery);
$totalReports = mysqli_fetch_assoc($reportResult)['total_reports'];

/* Total points */
$pointsQuery = "
    SELECT COALESCE(SUM(points),0) AS total_points
    FROM reward_points
    WHERE user_id = $user_id
";
$pointsResult = mysqli_query($conn, $pointsQuery);
$greenPoints = mysqli_fetch_assoc($pointsResult)['total_points'];

/* Fetch user area */
$areaQuery = "SELECT area FROM users WHERE user_id = $user_id";
$areaResult = mysqli_query($conn, $areaQuery);
$areaData = mysqli_fetch_assoc($areaResult);
$userArea = $areaData['area'];

/* Latest awareness */
$awarenessQuery = "
    SELECT * FROM awareness_posts
    ORDER BY created_at DESC
    LIMIT 3
";
$awarenessResult = mysqli_query($conn, $awarenessQuery);

/* Badge Logic */
if ($greenPoints >= 500) {
    $badge = "Eco Champion 🌳";
    $current = 500;
    $next = 500;
} elseif ($greenPoints >= 300) {
    $badge = "Eco Hero 🌿";
    $current = 300;
    $next = 500;
} elseif ($greenPoints >= 150) {
    $badge = "Eco Member 🌱";
    $current = 150;
    $next = 300;
} elseif ($greenPoints >= 50) {
    $badge = "Eco Newbie 🌍";
    $current = 50;
    $next = 150;
} else {
    $badge = "Eco Contributor 🍃";
    $current = 0;
    $next = 50;
}

$progress = ($next > 0)
    ? min(100, (($greenPoints - $current) / ($next - $current)) * 100)
    : 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TrashWise | Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>

body {
    background: #f1f8f4;
    font-family: 'Segoe UI', sans-serif;
}

/* Make footer stick to bottom */
html, body {
    height: 100%;
}

.page-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
}

/* PAGE TITLE */
.page-title {
    font-weight: 700;
    font-size: 1.6rem;
    margin-bottom: 30px;
}

/* CARD BASE */
.card {
    border-radius: 18px;
    border: none;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    transition: 0.25s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.1);
}

/* CARD TITLES */
.card-body h5 {
    font-size: 1.4rem;
    font-weight: 600;
    color: #1b5e20;
}

/* MAIN NUMBERS */
.card-body h2 {
    font-size: 2.4rem;
    font-weight: 700;
    margin: 10px 0;
    color: #111;
}

/* TEXT BELOW */
.card-body p {
    font-size: 1.05rem;
    color: #333;
}

/* GREEN POINTS CARD */
.points-card {
    background: linear-gradient(135deg, #2e7d32, #43a047);
    color: white;
}

.points-card h5,
.points-card h2,
.points-card p,
.points-card small {
    color: white;
}

/* PROGRESS */
.progress {
    height: 10px;
    border-radius: 20px;
    background: rgba(255,255,255,0.3);
}

.progress-bar {
    background-color: #ffffff;
    border-radius: 20px;
}

/* Awareness image */
.card-img-top {
    height: 180px;
    object-fit: cover;
    border-top-left-radius: 18px;
    border-top-right-radius: 18px;
}

</style>
</head>

<body>

<div class="page-wrapper">

<?php include "navbar.php"; ?>

<div class="main-content">

<div class="container-fluid px-4 py-5">

<h3 class="page-title">
    Welcome, <?= htmlspecialchars($userName) ?> 👋
</h3>

<!-- TOP CARDS -->
<div class="row g-4 mb-4">

    <!-- GREEN POINTS -->
    <div class="col-md-4">
        <div class="card points-card h-100">
            <div class="card-body">

                <h5>Green Points</h5>
                <h2><?= $greenPoints ?> 🌱</h2>
                <p class="fw-semibold mb-2"><?= $badge ?></p>

                <div class="progress mb-2">
                    <div class="progress-bar" style="width: <?= round($progress) ?>%"></div>
                </div>

                <?php if ($greenPoints < 500): ?>
                    <small><?= ($next - $greenPoints) ?> points to next badge</small>
                <?php else: ?>
                    <small>Highest badge achieved 🎉</small>
                <?php endif; ?>

                <div class="mt-3">
                    <a href="leaderboard.php" class="btn btn-light btn-sm w-100">
                        <i class="bi bi-trophy"></i> View Leaderboard
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- ISSUES REPORTED -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h5>Issues Reported</h5>
                <h2><?= $totalReports ?></h2>
                <p>Total issues reported</p>
            </div>
        </div>
    </div>

    <!-- COLLECTION -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h5>Next Collection</h5>

                <?php if (!empty($userArea)): ?>

                    <?php
                    $scheduleQuery = "
                        SELECT * FROM collection_schedule
                        WHERE area = '$userArea'
                        ORDER BY collection_date ASC
                        LIMIT 1
                    ";
                    $scheduleResult = mysqli_query($conn, $scheduleQuery);
                    $schedule = mysqli_fetch_assoc($scheduleResult);
                    ?>

                    <?php if ($schedule): ?>
                        <h4><?= htmlspecialchars($schedule['waste_type']) ?></h4>

                        <p class="mb-1 fs-5 fw-semibold">
                            <i class="bi bi-calendar-event"></i>
                            <?= date("d M Y", strtotime($schedule['collection_date'])) ?>
                        </p>

                        <p class="mb-0 fs-5 fw-semibold">
                            <i class="bi bi-clock"></i>
                            <?= date("h:i A", strtotime($schedule['collection_time'])) ?>
                        </p>

                    <?php else: ?>
                        <p class="text-muted">No upcoming schedule</p>
                    <?php endif; ?>

                <?php else: ?>

                    <p class="text-muted">
                        Please update your area to view collection schedule.
                    </p>

                    <button class="btn btn-outline-success btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#profileModal">
                        Update Area
                    </button>

                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<!-- AWARENESS -->
<div class="card mb-4">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                <i class="bi bi-megaphone"></i> Latest Awareness
            </h5>
            <a href="awareness.php" class="btn btn-outline-success btn-sm">
                View All
            </a>
        </div>

        <div class="row g-4">

        <?php if (mysqli_num_rows($awarenessResult) > 0): ?>
            <?php while($post = mysqli_fetch_assoc($awarenessResult)): ?>

                <div class="col-md-4">
                    <div class="card h-100">

                        <img src="../uploads/awareness/<?= $post['image'] ?>"
                             class="card-img-top">

                        <div class="card-body">
                            <h6 class="fw-bold">
                                <?= htmlspecialchars($post['title']) ?>
                            </h6>

                            <p class="small text-muted">
                                <?= substr(htmlspecialchars($post['content']),0,80) ?>...
                            </p>

                            <a href="view_post.php?id=<?= $post['post_id'] ?>"
                               class="btn btn-success btn-sm">
                               Read More
                            </a>
                        </div>

                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>

            <div class="col-12 text-muted text-center">
                No awareness posts available.
            </div>

        <?php endif; ?>

        </div>

    </div>
</div>

</div>
</div>

<?php include "footer.php"; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

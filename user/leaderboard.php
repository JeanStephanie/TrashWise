<?php
include "auth_check.php";
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$currentUserId = $_SESSION['user_id'];

/* TOP 10 QUERY */
$query = "
    SELECT 
        u.user_id,
        u.name,
        COALESCE(SUM(rp.points), 0) AS total_points
    FROM users u
    LEFT JOIN reward_points rp ON u.user_id = rp.user_id
    GROUP BY u.user_id
    ORDER BY total_points DESC
    LIMIT 10
";

$result = mysqli_query($conn, $query);

/* GET CURRENT USER RANK */
$rankQuery = "
    SELECT user_id, total_points
    FROM (
        SELECT 
            u.user_id,
            COALESCE(SUM(rp.points), 0) AS total_points
        FROM users u
        LEFT JOIN reward_points rp ON u.user_id = rp.user_id
        GROUP BY u.user_id
        ORDER BY total_points DESC
    ) ranked_users
";

$rankResult = mysqli_query($conn, $rankQuery);

$userRank = 0;
$userPoints = 0;
$position = 1;

while ($row = mysqli_fetch_assoc($rankResult)) {
    if ($row['user_id'] == $currentUserId) {
        $userRank = $position;
        $userPoints = $row['total_points'];
        break;
    }
    $position++;
}

/* Badge Function */
function getBadge($points) {
    if ($points >= 500) return "Eco Champion 🌳";
    if ($points >= 300) return "Eco Hero 🌿";
    if ($points >= 100) return "Eco Member 🌱";
    if ($points >= 20)  return "Eco Newbie 🌍";
    return "Eco Contributor 🍃";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Leaderboard | TrashWise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .leaderboard-card {
            border-radius: 15px;
        }
        .rank-badge {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .highlight-user {
            background-color: #d1f7dc !important;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

    <div class="card leaderboard-card shadow">
        <div class="card-body">
            <h3 class="text-center mb-2">🏆 Community Leaderboard</h3>
            <p class="text-center text-muted">
                Top eco-warriors making a difference 🌱
            </p>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-success">
                        <tr>
                            <th>Rank</th>
                            <th>User</th>
                            <th>Badge</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rank = 1;
                        $userInTop10 = false;

                        while ($row = mysqli_fetch_assoc($result)) {

                            if ($rank == 1) $rankIcon = "🥇";
                            elseif ($rank == 2) $rankIcon = "🥈";
                            elseif ($rank == 3) $rankIcon = "🥉";
                            else $rankIcon = $rank;

                            $badge = getBadge($row['total_points']);

                            $highlight = "";
                            if ($row['user_id'] == $currentUserId) {
                                $highlight = "highlight-user";
                                $userInTop10 = true;
                            }
                        ?>
                        <tr class="<?= $highlight ?>">
                            <td class="rank-badge"><?= $rankIcon ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= $badge ?></td>
                            <td><?= $row['total_points'] ?></td>
                        </tr>
                        <?php
                            $rank++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SHOW USER RANK IF NOT IN TOP 10 -->
    <?php if (!$userInTop10): ?>
    <div class="card shadow mt-4">
        <div class="card-body text-center">
            <h5>Your Rank</h5>
            <p class="mb-1"><strong>#<?= $userRank ?></strong></p>
            <p><?= getBadge($userPoints) ?></p>
            <p><?= $userPoints ?> Points</p>
        </div>
    </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

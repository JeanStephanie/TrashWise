<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db.php";

$userArea = '';

if (isset($_SESSION['user_id'])) {
    $uid = intval($_SESSION['user_id']);
    $areaQuery = mysqli_query($conn,
        "SELECT area FROM users WHERE user_id = $uid");

    if ($areaRow = mysqli_fetch_assoc($areaQuery)) {
        $userArea = $areaRow['area'];
    }
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Bootstrap Icons ONLY (do NOT reload bootstrap CSS here) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .premium-navbar {
        background: linear-gradient(135deg, #157347, #198754);
        padding: 15px 0;
    }

    .premium-navbar .brand-logo {
        font-size: 1.35rem;
        font-weight: 700;
        color: white !important;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: 0.5px;
        text-decoration: none;
    }

    .premium-navbar .brand-logo i {
        font-size: 1.6rem;
    }

    .premium-navbar .nav-link {
        color: rgba(255,255,255,0.9) !important;
        font-size: 1.08rem;
        font-weight: 500;
        margin-right: 22px;
        transition: 0.2s ease;
        position: relative;
    }

    .premium-navbar .nav-link:hover {
        color: #ffffff !important;
    }

    .premium-navbar .nav-link.active::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 100%;
        height: 2px;
        background: white;
        border-radius: 10px;
    }

    .premium-navbar .profile-btn {
        background: rgba(255,255,255,0.18);
        border-radius: 50px;
        padding: 8px 18px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-weight: 500;
        font-size: 1.05rem;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .premium-navbar .profile-btn:hover {
        background: rgba(255,255,255,0.28);
    }

    .premium-navbar .profile-btn i {
        font-size: 1.4rem;
    }
</style>

<nav class="navbar navbar-expand-lg premium-navbar shadow-sm">
    <div class="container-fluid px-4">

        <!-- LOGO -->
        <a class="brand-logo" href="dashboard.php">
            <i class="bi bi-recycle"></i>
            TrashWise
        </a>

        <button class="navbar-toggler bg-light"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-4">

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage=='dashboard.php')?'active':'' ?>"
                       href="dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage=='report_issue.php')?'active':'' ?>"
                       href="report_issue.php">Report Issue</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage=='my_reports.php')?'active':'' ?>"
                       href="my_reports.php">My Reports</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage=='collection_schedule.php')?'active':'' ?>"
                       href="collection_schedule.php">Collection Schedule</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage=='leaderboard.php')?'active':'' ?>"
                       href="leaderboard.php">Leaderboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage=='awareness.php')?'active':'' ?>"
                       href="awareness.php">Awareness</a>
                </li>

            </ul>

            <!-- PROFILE -->
            <div class="ms-auto d-flex align-items-center">
                <div class="profile-btn"
                     data-bs-toggle="modal"
                     data-bs-target="#profileModal">
                    <i class="bi bi-person-circle"></i>
                    <?= htmlspecialchars($_SESSION['user_name'] ?? 'Profile') ?>
                </div>
            </div>

        </div>
    </div>
</nav>

<!-- PROFILE MODAL -->
<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">My Profile</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <i class="bi bi-person-circle"
                   style="font-size:4rem;color:#198754;"></i>

                <h5 class="mt-3 fw-bold">
                    <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>
                </h5>

                <p class="text-muted">
                    <?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>
                </p>

                <hr>

                <form method="POST" action="update_profile.php">

                    <!-- NAME FIELD -->
                    <div class="mb-3 text-start">
                        <label class="form-label small text-muted">
                            Full Name
                        </label>
                        <input type="text"
                            name="name"
                            value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>"
                            class="form-control rounded-3"
                            required>
                    </div>

                    <!-- AREA FIELD -->
                    <div class="mb-3 text-start">
                        <label class="form-label small text-muted">
                            Your Area
                        </label>
                        <input type="text"
                            name="area"
                            value="<?= htmlspecialchars($userArea) ?>"
                            class="form-control rounded-3">
                    </div>

                    <button type="submit"
                            class="btn btn-success w-100 rounded-3 mb-2">
                        Update Profile
                    </button>

                </form>

                <a href="logout.php"
                   class="btn btn-outline-secondary w-100 rounded-3 mb-2">
                    Logout
                </a>

                <a href="delete_account.php"
                   onclick="return confirm('Are you sure?')"
                   class="btn btn-outline-danger w-100 rounded-3">
                    Delete Account
                </a>

            </div>

        </div>
    </div>
</div>

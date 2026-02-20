<style>
.sidebar {
    background: #145a32;
    min-height: 100vh;
    color: white;
}

.sidebar h4 {
    font-weight: bold;
}

.sidebar a {
    color: white;
    text-decoration: none;
    padding: 12px;
    display: block;
    border-radius: 8px;
    margin-bottom: 6px;
}

.sidebar a:hover,
.sidebar a.active {
    background: rgba(255,255,255,0.2);
}
</style>

<div class="col-md-2 sidebar p-3">
    <h4 class="text-center mb-4">
        <i class="bi bi-recycle"></i> TrashWise
    </h4>

    <a href="dashboard.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="users.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
        <i class="bi bi-people"></i> Manage Users
    </a>

    <a href="waste_reports.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'waste_reports.php' ? 'active' : '' ?>">
        <i class="bi bi-exclamation-circle"></i> Waste Reports
    </a>

    <a href="collection_schedule.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'collection_schedule.php' ? 'active' : '' ?>">
        <i class="bi bi-calendar-check"></i> Collection Schedules
    </a>

    <a href="manage_awareness.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'manage_awareness.php' ? 'active' : '' ?>">
        <i class="bi bi-book"></i> Awareness Content
    </a>

    <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

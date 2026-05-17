<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hospital Management</title>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2><i class="material-icons-round">local_hospital</i> MediCare</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="?page=dashboard" class="nav-item <?= $page == 'dashboard' ? 'active' : '' ?>">
                <i class="material-icons-round">dashboard</i>
                <span>Dashboard</span>
            </a>
            <a href="?page=patients" class="nav-item <?= $page == 'patients' ? 'active' : '' ?>">
                <i class="material-icons-round">people</i>
                <span>Patients</span>
            </a>
            <a href="?page=doctors" class="nav-item <?= $page == 'doctors' ? 'active' : '' ?>">
                <i class="material-icons-round">medical_services</i>
                <span>Doctors</span>
            </a>
            <a href="?page=appointments" class="nav-item <?= $page == 'appointments' ? 'active' : '' ?>">
                <i class="material-icons-round">event_note</i>
                <span>Appointments</span>
            </a>
            <!-- Keep these dummy for now unless requested -->
            <a href="#" class="nav-item">
                <i class="material-icons-round">account_balance_wallet</i>
                <span>Billing</span>
            </a>
            <a href="#" class="nav-item">
                <i class="material-icons-round">settings</i>
                <span>Settings</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="logout.php" class="logout-btn">
                <i class="material-icons-round">logout</i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="search-bar">
                <i class="material-icons-round">search</i>
                <input type="text" placeholder="Search...">
            </div>
            <div class="header-actions">
                <button class="notification-btn">
                    <i class="material-icons-round">notifications</i>
                    <span class="badge">3</span>
                </button>
                <div class="user-profile">
                    <div class="avatar">
                        <?= strtoupper(substr($_SESSION['name'], 0, 1)) ?>
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?= htmlspecialchars($_SESSION['name']) ?></span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <i class="material-icons-round">expand_more</i>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <?php
            $allowed_pages = ['dashboard', 'patients', 'doctors', 'appointments'];
            if(in_array($page, $allowed_pages)) {
                include "modules/{$page}.php";
            } else {
                echo "<div class='dashboard-container'><h2>Page not found.</h2></div>";
            }
        ?>
    </main>

</body>
</html>

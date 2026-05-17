<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}
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
            <a href="#" class="nav-item active">
                <i class="material-icons-round">dashboard</i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="nav-item">
                <i class="material-icons-round">people</i>
                <span>Patients</span>
            </a>
            <a href="#" class="nav-item">
                <i class="material-icons-round">medical_services</i>
                <span>Doctors</span>
            </a>
            <a href="#" class="nav-item">
                <i class="material-icons-round">event_note</i>
                <span>Appointments</span>
            </a>
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
                <input type="text" placeholder="Search patients, doctors...">
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

        <!-- Dashboard Content -->
        <div class="dashboard-container">
            <h1 class="page-title">Dashboard Overview</h1>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-title">Total Patients</span>
                        <span class="stat-value">1,284</span>
                        <span class="stat-change positive">
                            <i class="material-icons-round">arrow_upward</i> 12.5% this month
                        </span>
                    </div>
                    <div class="stat-icon icon-blue">
                        <i class="material-icons-round">personal_injury</i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-title">Available Doctors</span>
                        <span class="stat-value">64</span>
                        <span class="stat-change positive">
                            <i class="material-icons-round">arrow_upward</i> 4 new joined
                        </span>
                    </div>
                    <div class="stat-icon icon-green">
                        <i class="material-icons-round">medication</i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-title">Appointments Today</span>
                        <span class="stat-value">142</span>
                        <span class="stat-change negative">
                            <i class="material-icons-round">arrow_downward</i> 5% vs yesterday
                        </span>
                    </div>
                    <div class="stat-icon icon-orange">
                        <i class="material-icons-round">pending_actions</i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-title">Monthly Revenue</span>
                        <span class="stat-value">$54,230</span>
                        <span class="stat-change positive">
                            <i class="material-icons-round">arrow_upward</i> 8.2% this month
                        </span>
                    </div>
                    <div class="stat-icon icon-red">
                        <i class="material-icons-round">payments</i>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments Table -->
            <div class="table-section">
                <div class="table-header">
                    <h2 class="table-title">Recent Appointments</h2>
                    <a href="#" class="view-all">View All</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar">S</div>
                                    Sarah Johnson
                                </div>
                            </td>
                            <td>Dr. Robert Chen</td>
                            <td>Cardiology</td>
                            <td>Oct 24, 09:30 AM</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>
                                <button class="action-btn"><i class="material-icons-round">more_vert</i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar" style="background-color: #fef3c7; color: #b45309;">M</div>
                                    Michael Smith
                                </div>
                            </td>
                            <td>Dr. Emily White</td>
                            <td>Neurology</td>
                            <td>Oct 24, 11:00 AM</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>
                                <button class="action-btn"><i class="material-icons-round">more_vert</i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar" style="background-color: #fee2e2; color: #991b1b;">J</div>
                                    James Wilson
                                </div>
                            </td>
                            <td>Dr. Sarah Davis</td>
                            <td>Orthopedics</td>
                            <td>Oct 24, 02:15 PM</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>
                                <button class="action-btn"><i class="material-icons-round">more_vert</i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar" style="background-color: #e0e7ff; color: #3730a3;">E</div>
                                    Emma Brown
                                </div>
                            </td>
                            <td>Dr. Michael Lee</td>
                            <td>Pediatrics</td>
                            <td>Oct 24, 04:00 PM</td>
                            <td><span class="status-badge status-cancelled">Cancelled</span></td>
                            <td>
                                <button class="action-btn"><i class="material-icons-round">more_vert</i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>

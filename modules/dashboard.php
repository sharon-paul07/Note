<?php
require_once 'config.php';

// Fetch stats
$patient_count = $conn->query("SELECT COUNT(*) FROM patients")->fetch_row()[0] ?? 0;
$doctor_count = $conn->query("SELECT COUNT(*) FROM doctors")->fetch_row()[0] ?? 0;
$appointment_count = $conn->query("SELECT COUNT(*) FROM appointments WHERE DATE(appointment_date) = CURDATE()")->fetch_row()[0] ?? 0;

// Dummy revenue for now
$revenue = 54230;

// Fetch recent appointments
$recent_apps = $conn->query("
    SELECT a.id, a.appointment_date, a.status, 
           p.first_name as pf_name, p.last_name as pl_name,
           d.first_name as df_name, d.last_name as dl_name, d.department
    FROM appointments a
    JOIN patients p ON a.patient_id = p.id
    JOIN doctors d ON a.doctor_id = d.id
    ORDER BY a.appointment_date DESC
    LIMIT 5
");
?>
<div class="dashboard-container">
    <h1 class="page-title">Dashboard Overview</h1>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-title">Total Patients</span>
                <span class="stat-value"><?= number_format($patient_count) ?></span>
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
                <span class="stat-value"><?= number_format($doctor_count) ?></span>
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
                <span class="stat-value"><?= number_format($appointment_count) ?></span>
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
                <span class="stat-value">$<?= number_format($revenue) ?></span>
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
            <a href="?page=appointments" class="view-all">View All</a>
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
                <?php if($recent_apps && $recent_apps->num_rows > 0): ?>
                    <?php while($row = $recent_apps->fetch_assoc()): ?>
                        <?php
                            $status_class = '';
                            if($row['status'] == 'Completed') $status_class = 'status-completed';
                            elseif($row['status'] == 'Pending') $status_class = 'status-pending';
                            else $status_class = 'status-cancelled';
                        ?>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar"><?= strtoupper(substr($row['pf_name'], 0, 1)) ?></div>
                                    <?= htmlspecialchars($row['pf_name'] . ' ' . $row['pl_name']) ?>
                                </div>
                            </td>
                            <td>Dr. <?= htmlspecialchars($row['df_name'] . ' ' . $row['dl_name']) ?></td>
                            <td><?= htmlspecialchars($row['department']) ?></td>
                            <td><?= date('M d, h:i A', strtotime($row['appointment_date'])) ?></td>
                            <td><span class="status-badge <?= $status_class ?>"><?= $row['status'] ?></span></td>
                            <td>
                                <button class="action-btn"><i class="material-icons-round">more_vert</i></button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">No recent appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

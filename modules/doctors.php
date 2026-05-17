<?php
require_once 'config.php';

// Handle Add Doctor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_doctor'])) {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $department = $conn->real_escape_string($_POST['department']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);

    $conn->query("INSERT INTO doctors (first_name, last_name, department, phone, email) VALUES ('$first_name', '$last_name', '$department', '$phone', '$email')");
    echo "<meta http-equiv='refresh' content='0'>";
    exit;
}

// Handle Delete Doctor
if (isset($_GET['delete_doctor'])) {
    $id = (int)$_GET['delete_doctor'];
    $conn->query("DELETE FROM doctors WHERE id = $id");
    echo "<meta http-equiv='refresh' content='0;url=?page=doctors'>";
    exit;
}

// Fetch Doctors
$doctors = $conn->query("SELECT * FROM doctors ORDER BY created_at DESC");
?>

<div class="dashboard-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 class="page-title" style="margin-bottom: 0;">Doctors Management</h1>
        <button class="logout-btn" onclick="document.getElementById('addDoctorModal').style.display='flex'" style="background: var(--success); color: white;">
            <i class="material-icons-round">add</i> Add Doctor
        </button>
    </div>

    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Department</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if($doctors && $doctors->num_rows > 0): ?>
                    <?php while($row = $doctors->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar" style="background: var(--success); color: white;"><?= strtoupper(substr($row['first_name'], 0, 1)) ?></div>
                                    Dr. <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
                                </div>
                            </td>
                            <td><span class="status-badge" style="background: #e0e7ff; color: var(--primary);"><?= htmlspecialchars($row['department']) ?></span></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td>
                                <a href="?page=doctors&delete_doctor=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this doctor?')" class="action-btn" style="color: var(--danger);"><i class="material-icons-round">delete</i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center; color: var(--text-muted);">No doctors found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Doctor Modal -->
<div id="addDoctorModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div style="background: white; padding: 32px; border-radius: 16px; width: 100%; max-width: 500px;">
        <h2 style="margin-bottom: 24px;">Add New Doctor</h2>
        <form method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">First Name</label>
                    <input type="text" name="first_name" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">Last Name</label>
                    <input type="text" name="last_name" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                </div>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Department</label>
                <select name="department" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                    <option value="Cardiology">Cardiology</option>
                    <option value="Neurology">Neurology</option>
                    <option value="Orthopedics">Orthopedics</option>
                    <option value="Pediatrics">Pediatrics</option>
                    <option value="General Surgery">General Surgery</option>
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Phone</label>
                <input type="text" name="phone" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
            </div>
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 16px;">
                <button type="button" onclick="document.getElementById('addDoctorModal').style.display='none'" style="padding: 10px 20px; border: none; background: #e2e8f0; border-radius: 8px; cursor: pointer;">Cancel</button>
                <button type="submit" name="add_doctor" style="padding: 10px 20px; border: none; background: var(--success); color: white; border-radius: 8px; cursor: pointer;">Add Doctor</button>
            </div>
        </form>
    </div>
</div>

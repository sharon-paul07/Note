<?php
require_once 'config.php';

// Handle Add Appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_appointment'])) {
    $patient_id = (int)$_POST['patient_id'];
    $doctor_id = (int)$_POST['doctor_id'];
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);
    $status = $conn->real_escape_string($_POST['status']);

    $conn->query("INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) VALUES ($patient_id, $doctor_id, '$appointment_date', '$status')");
    echo "<meta http-equiv='refresh' content='0'>";
    exit;
}

// Handle Update Status
if (isset($_GET['update_status']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $conn->real_escape_string($_GET['update_status']);
    $conn->query("UPDATE appointments SET status = '$status' WHERE id = $id");
    echo "<meta http-equiv='refresh' content='0;url=?page=appointments'>";
    exit;
}

// Handle Delete Appointment
if (isset($_GET['delete_appointment'])) {
    $id = (int)$_GET['delete_appointment'];
    $conn->query("DELETE FROM appointments WHERE id = $id");
    echo "<meta http-equiv='refresh' content='0;url=?page=appointments'>";
    exit;
}

// Fetch Appointments
$appointments = $conn->query("
    SELECT a.*, 
           p.first_name as pf_name, p.last_name as pl_name,
           d.first_name as df_name, d.last_name as dl_name, d.department
    FROM appointments a
    JOIN patients p ON a.patient_id = p.id
    JOIN doctors d ON a.doctor_id = d.id
    ORDER BY a.appointment_date DESC
");

// Fetch for dropdowns
$patient_list = $conn->query("SELECT id, first_name, last_name FROM patients ORDER BY first_name");
$doctor_list = $conn->query("SELECT id, first_name, last_name, department FROM doctors ORDER BY first_name");
?>

<div class="dashboard-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 class="page-title" style="margin-bottom: 0;">Appointments Management</h1>
        <button class="logout-btn" onclick="document.getElementById('addApptModal').style.display='flex'" style="background: var(--warning); color: #78350f;">
            <i class="material-icons-round">event_note</i> Schedule Appointment
        </button>
    </div>

    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Patient Name</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if($appointments && $appointments->num_rows > 0): ?>
                    <?php while($row = $appointments->fetch_assoc()): ?>
                        <?php
                            $status_class = '';
                            if($row['status'] == 'Completed') $status_class = 'status-completed';
                            elseif($row['status'] == 'Pending') $status_class = 'status-pending';
                            else $status_class = 'status-cancelled';
                        ?>
                        <tr>
                            <td style="font-weight: 500;"><?= date('M d, Y h:i A', strtotime($row['appointment_date'])) ?></td>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar"><?= strtoupper(substr($row['pf_name'], 0, 1)) ?></div>
                                    <?= htmlspecialchars($row['pf_name'] . ' ' . $row['pl_name']) ?>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span>Dr. <?= htmlspecialchars($row['df_name'] . ' ' . $row['dl_name']) ?></span>
                                    <span style="font-size: 0.75rem; color: var(--text-muted);"><?= htmlspecialchars($row['department']) ?></span>
                                </div>
                            </td>
                            <td><span class="status-badge <?= $status_class ?>"><?= $row['status'] ?></span></td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <?php if($row['status'] == 'Pending'): ?>
                                        <a href="?page=appointments&update_status=Completed&id=<?= $row['id'] ?>" class="action-btn" title="Mark Completed" style="color: var(--success);"><i class="material-icons-round">check_circle</i></a>
                                        <a href="?page=appointments&update_status=Cancelled&id=<?= $row['id'] ?>" class="action-btn" title="Cancel" style="color: var(--danger);"><i class="material-icons-round">cancel</i></a>
                                    <?php endif; ?>
                                    <a href="?page=appointments&delete_appointment=<?= $row['id'] ?>" onclick="return confirm('Delete this appointment completely?')" class="action-btn" title="Delete" style="color: var(--text-muted);"><i class="material-icons-round">delete</i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center; color: var(--text-muted);">No appointments found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Appointment Modal -->
<div id="addApptModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div style="background: white; padding: 32px; border-radius: 16px; width: 100%; max-width: 500px;">
        <h2 style="margin-bottom: 24px;">Schedule Appointment</h2>
        <form method="POST">
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Select Patient</label>
                <select name="patient_id" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                    <option value="">-- Select Patient --</option>
                    <?php if($patient_list) while($p = $patient_list->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Select Doctor</label>
                <select name="doctor_id" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                    <option value="">-- Select Doctor --</option>
                    <?php if($doctor_list) while($d = $doctor_list->fetch_assoc()): ?>
                        <option value="<?= $d['id'] ?>">Dr. <?= htmlspecialchars($d['first_name'] . ' ' . $d['last_name']) ?> (<?= htmlspecialchars($d['department']) ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Date & Time</label>
                <input type="datetime-local" name="appointment_date" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
            </div>
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Status</label>
                <select name="status" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 16px;">
                <button type="button" onclick="document.getElementById('addApptModal').style.display='none'" style="padding: 10px 20px; border: none; background: #e2e8f0; border-radius: 8px; cursor: pointer;">Cancel</button>
                <button type="submit" name="add_appointment" style="padding: 10px 20px; border: none; background: var(--warning); color: #78350f; border-radius: 8px; cursor: pointer;">Schedule</button>
            </div>
        </form>
    </div>
</div>

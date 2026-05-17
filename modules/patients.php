<?php
require_once 'config.php';

// Handle Add Patient
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_patient'])) {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);

    $conn->query("INSERT INTO patients (first_name, last_name, phone, email, date_of_birth, gender) VALUES ('$first_name', '$last_name', '$phone', '$email', '$dob', '$gender')");
    echo "<meta http-equiv='refresh' content='0'>";
    exit;
}

// Handle Delete Patient
if (isset($_GET['delete_patient'])) {
    $id = (int)$_GET['delete_patient'];
    $conn->query("DELETE FROM patients WHERE id = $id");
    echo "<meta http-equiv='refresh' content='0;url=?page=patients'>";
    exit;
}

// Fetch Patients
$patients = $conn->query("SELECT * FROM patients ORDER BY created_at DESC");
?>

<div class="dashboard-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 class="page-title" style="margin-bottom: 0;">Patients Management</h1>
        <button class="logout-btn" onclick="document.getElementById('addPatientModal').style.display='flex'" style="background: var(--primary); color: white;">
            <i class="material-icons-round">add</i> Add Patient
        </button>
    </div>

    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>D.O.B</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if($patients && $patients->num_rows > 0): ?>
                    <?php while($row = $patients->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar" style="background: var(--primary); color: white;"><?= strtoupper(substr($row['first_name'], 0, 1)) ?></div>
                                    <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= date('M d, Y', strtotime($row['date_of_birth'])) ?></td>
                            <td><?= htmlspecialchars($row['gender']) ?></td>
                            <td>
                                <a href="?page=patients&delete_patient=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this patient?')" class="action-btn" style="color: var(--danger);"><i class="material-icons-round">delete</i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align: center; color: var(--text-muted);">No patients found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Patient Modal -->
<div id="addPatientModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div style="background: white; padding: 32px; border-radius: 16px; width: 100%; max-width: 500px;">
        <h2 style="margin-bottom: 24px;">Add New Patient</h2>
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
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Phone</label>
                <input type="text" name="phone" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">Date of Birth</label>
                    <input type="date" name="dob" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">Gender</label>
                    <select name="gender" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 16px;">
                <button type="button" onclick="document.getElementById('addPatientModal').style.display='none'" style="padding: 10px 20px; border: none; background: #e2e8f0; border-radius: 8px; cursor: pointer;">Cancel</button>
                <button type="submit" name="add_patient" style="padding: 10px 20px; border: none; background: var(--primary); color: white; border-radius: 8px; cursor: pointer;">Add Patient</button>
            </div>
        </form>
    </div>
</div>

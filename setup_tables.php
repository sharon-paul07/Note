<?php
require 'config.php';

echo "<h2>Initializing Database Tables...</h2>";

// 1. Patients Table
$sql_patients = "CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_patients) === TRUE) {
    echo "Table 'patients' created or already exists.<br>";
} else {
    echo "Error creating table 'patients': " . $conn->error . "<br>";
}

// 2. Doctors Table
$sql_doctors = "CREATE TABLE IF NOT EXISTS doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    department VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_doctors) === TRUE) {
    echo "Table 'doctors' created or already exists.<br>";
} else {
    echo "Error creating table 'doctors': " . $conn->error . "<br>";
}

// 3. Appointments Table
$sql_appointments = "CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    appointment_date DATETIME NOT NULL,
    status ENUM('Pending', 'Completed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
)";
if ($conn->query($sql_appointments) === TRUE) {
    echo "Table 'appointments' created or already exists.<br>";
} else {
    echo "Error creating table 'appointments': " . $conn->error . "<br>";
}

echo "<h3>Setup Complete!</h3>";
echo "<a href='admin_page.php'>Return to Dashboard</a>";

$conn->close();
?>

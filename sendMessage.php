<?php
session_start();

if (!isset($_SESSION['patient_login_id'])) {
    header("Location: patientlogin.php");
    exit();
}

if (!isset($_SESSION['patient_sign_id'])) {
    header("Location: patientsignup.php");
    exit();
}

$patient_id = $_SESSION['patient_login_id'];
$doctor_id = $_SESSION['patient_login_doctor_id'];
$message = $_POST['message'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = "77220011fady";
$dbname = "clinic";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO messages (patient_id, doctor_id, send_msg) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $patient_id, $doctor_id, $message);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Message sent successfully!";
} else {
    $_SESSION['error_message'] = "Failed to send message.";
}

$stmt->close();
$conn->close();

header("Location: patienthome.php");
exit();
?>

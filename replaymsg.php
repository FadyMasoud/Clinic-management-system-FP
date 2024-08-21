<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctorlogin.php");
    exit();
}

$message_id = $_POST['message_id'];
$reply_msg = $_POST['reply_msg'];

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

$sql = "UPDATE messages SET reply_msg = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $reply_msg, $message_id);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Reply sent successfully!";
} else {
    $_SESSION['error_message'] = "Failed to send reply.";
}

$stmt->close();
$conn->close();

header("Location: doctorMessages.php");
exit();
?>

<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctorlogin.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "77220011fady";
$dbname = "clinic";
$port=3306;
$previousPath = $_SERVER['HTTP_REFERER'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_d = $_SESSION['doctor_id'] ;
    $d_name = $_POST['d_name'];
    $specialization = $_POST['specialization'];
    $d_certificate = $_POST['d_certificate'];
    $d_email = $_POST['d_email'];
    $profile_picture = $_POST['profile_picture'];

    $sql = "UPDATE doctor SET d_name = ?, specialization = ?, d_certificate = ?, d_email = ?, profile_picture = ? WHERE id_d = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $d_name, $specialization, $d_certificate, $d_email, $profile_picture, $id_d);

    if ($stmt->execute()) {
        // Update session variables
       
            $_SESSION['profile_pic'] = $profile_picture;
            $_SESSION['doctor_name'] = $d_name;
            $_SESSION['doctor_email'] = $d_email;
            $_SESSION['doctor_specilalize'] = $specialization;
            $_SESSION['doctor_certify'] = $d_certificate;
       

        header("Location: docProfile.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctorhome.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $action = $_POST['action'];

    if ($action == "update") {
        $profile_picture = $_POST['profile_picture'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $diseases = $_POST['diseases'];

        $sql = "UPDATE patient SET P_profile_picture = ?, P_name = ?, P_email = ?, P_gender = ?, P_age = ?, P_phone = ?, P_address = ?, P_diseases = ? WHERE P_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $profile_picture, $name, $email, $gender, $age, $phone, $address, $diseases, $patient_id);

        if ($stmt->execute()) {
            $_SESSION['Patient_profile_pic'] = $profile_picture;
            $_SESSION['patient_name'] = $name;
            $_SESSION['patient_email'] = $email;
            $_SESSION['patient_gender'] = $gender;
            $_SESSION['patient_age'] = $age;
            $_SESSION['patient_phone'] = $phone;
            $_SESSION['patient_address'] = $address;
            $_SESSION['patient_diseases'] = $diseases;

            header("Location: AccessDocPatient.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    } elseif ($action == "delete") {
        $sql = "DELETE FROM patient WHERE P_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $patient_id);

        if ($stmt->execute()) {
            // Optionally, clear patient session data if necessary
            header("Location: AccessDocPatient.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

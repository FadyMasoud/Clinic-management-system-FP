<?php
session_start();

if (!isset($_SESSION['patient_login_id'])) {
    header("Location: patientProfile.php");
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
    $id_P = $_SESSION['patient_login_id'];
    $name = $_POST['name'];
    $profile_picture=$_POST['profile_picture'];
    $email = $_POST['email'];
    $age=$_POST['age'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $diseases = $_POST['diseases'];


    $sql = "UPDATE patient SET P_name=?, P_email=?, P_gender=?, P_age=?, P_profile_picture = ?, P_phone=?, P_address=?, P_diseases=?  WHERE P_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissssi", $name,$email,$gender,$age,$profile_picture,$phone,$address,$diseases, $id_P);

    if ($stmt->execute()) {
        // Update session variables
       
            $_SESSION['patient_login_profile_pic'] = $profile_picture;
            $_SESSION['patient_login_name'] = $name;
            $_SESSION['patient_login_email'] = $email;
            $_SESSION['patient_login_age'] = $age;
            $_SESSION['patient_login_gender'] = $gender;
            $_SESSION['patient_login_phone'] = $phone;
            $_SESSION['patient_login_address'] = $address;
            $_SESSION['patient_login_diseases'] = $diseases;
           
       

        header("Location: patientProfile.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

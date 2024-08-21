<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "77220011fady";
$dbname = "clinic";
$port=3306;

try {
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
        $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
        $profile_picture = $_FILES['profile_picture'];

        // Validate input
        $name_pattern = "/^[a-zA-Z ]+$/";
        $email_pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
        $password_pattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/"; // Minimum 8 characters, at least one letter and one number

        if (!preg_match($name_pattern, $first_name)) {
            $errors['first_name'] = "Invalid first name format.";
        }

        if (!preg_match($name_pattern, $last_name)) {
            $errors['last_name'] = "Invalid last name format.";
        }

        if (!preg_match($email_pattern, $email)) {
            $errors['email'] = "Invalid email format.";
        }

        if (!preg_match($password_pattern, $password)) {
            $errors['password'] = "Password must be at least 8 characters long and include at least one letter and one number.";
        }

        if ($password !== $confirm_password) {
            $errors['confirm_password'] = "Passwords do not match.";
        }

        if (empty($specialization)) {
            $errors['specialization'] = "Specialization is required.";
        }

        if (empty($errors)) {
            $target_dir = "upload/";
            $target_file = $target_dir . basename($profile_picture["name"]);
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if ($profile_picture["size"] > 500000) { // 500KB limit
                $errors['profile_picture'] = "Sorry, your file is too large.";
            }

            if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
                $errors['profile_picture'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }

            if (empty($errors)) {
                if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $d_name = $first_name . " " . $last_name;
                    $id_department = 1; // Example department id

                    $sql = "INSERT INTO doctor (d_name, d_pass, d_email, id_department_doc, profile_picture, specialization,d_certificate) VALUES (?, ?, ?, ?, ?, ?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssdsss", $d_name, $hashed_password, $email, $id_department, $target_file, $specialization,$certificate);
                    $stmt->execute();

                    $doctor_id = $conn->insert_id;
                    $_SESSION['doc_id'] = $doctor_id;
                    $_SESSION['doc_name'] = $d_name;
                    $_SESSION['doc_email'] = $email;
                    $_SESSION['doc_picture'] = $target_file;
                    $_SESSION['doc_specilalize'] = $specialization;
                    $_SESSION['doc_certify'] = $certificate;

                    header('Location: doctorlogin.php');
                    exit();
                } else {
                    $errors['profile_picture'] = "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>


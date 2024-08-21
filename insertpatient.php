<?php

session_start();
$errors = [];

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "77220011fady";
$dbname = "clinic";
$port = 3306;

// Validate input functions
function validate_name($name) {
    return preg_match("/^[a-zA-Z ]+$/", $name);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    return preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password);
}

function validate_phone($phone) {
    return preg_match("/^[0-9]{10,15}$/", $phone);
}

function handle_file_upload($file) {
    $target_dir = "uploadpatient/";
    $target_file = $target_dir . basename($file["name"]);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $file_size_limit = 500000; // 500KB limit
    $allowed_file_types = ["jpg", "png", "jpeg", "gif"];

    if ($file["size"] > $file_size_limit) {
        return ["error" => "File is too large."];
    }

    if (!in_array($image_file_type, $allowed_file_types)) {
        return ["error" => "Only JPG, JPEG, PNG & GIF files are allowed."];
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ["success" => $target_file];
    } else {
        return ["error" => "Error uploading file."];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $diseases = mysqli_real_escape_string($conn, $_POST['diseases']);
    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointDate']);
    $profile_picture = $_FILES['profile_picture'];

    // Perform validation
    if (!validate_name($name)) {
        $errors['name'] = "Invalid name format.";
    }
    if (!validate_email($email)) {
        $errors['email'] = "Invalid email format.";
    }
    if (!validate_password($password)) {
        $errors['password'] = "Password must be at least 8 characters long and include at least one letter and one number.";
    }
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }
    if (!validate_phone($phone)) {
        $errors['phone'] = "Invalid phone number format.";
    }
    if (empty($gender)) {
        $errors['gender'] = "Gender is required.";
    }
    if (empty($doctor_id)) {
        $errors['doctor_id'] = "Doctor selection is required.";
    }

    $file_upload_result = handle_file_upload($profile_picture);
    if (isset($file_upload_result['error'])) {
        $errors['profile_picture'] = $file_upload_result['error'];
    } else {
        $profile_picture_path = $file_upload_result['success'];
    }

    // If no errors, insert data into database
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Patient (P_name, P_gender, P_age, P_phone, P_email, P_pass, P_profile_picture, P_Appointment_Date, P_address, P_diseases, P_doctor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisssssssi", $name, $gender, $age, $phone, $email, $hashed_password, $profile_picture_path, $appointment_date, $address, $diseases, $doctor_id);

        if ($stmt->execute()) {
            $patient_id = $conn->insert_id;
            $_SESSION['patient_insert_id'] = $patient_id;
            $_SESSION['patient_insert_name'] = $name;
            $_SESSION['patient_insert_email'] = $email;
            $_SESSION['patient_insert_picture'] = $profile_picture_path;
            $_SESSION['patient_insert_gender'] = $gender;
            $_SESSION['patient_insert_age'] = $age;
            $_SESSION['patient_insert_phone'] = $phone;
            $_SESSION['patient_insert_address'] = $address;
            $_SESSION['patient_insert_diseases'] = $diseases;
            $_SESSION['patient_insert_doctor_id'] = $doctor_id;
            $_SESSION['patient_insert_appointment_date'] = $appointment_date;

            header('Location: AccessDocPatient.php');
            exit();
        } else {
            $errors['database'] = "Error inserting data into database.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/close-up-doctor-holding-medicine.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.6);
            box-shadow: 0px 20px 20px 0px rgba(0,0,0,0.1);
        }

        .form-container h1 {
            text-align: center;
            color: white;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 95%;
            padding: 10px;
            font-size:15px;
            margin: 5px 0;
            border-radius:5px ;
            border:0px solid gray;
            color:black;
        }

        .form-container button {
            background-color: #4CAF50;
            padding: 15px;
            font-size: 20px;
            color: white;
            border: none;
            cursor: pointer;
            transition:1s ease;
        }

        .form-container button:hover {
            background-color: #3e8e41;
            scale:0.9;
        }

        label{
            color: white;
        }

        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>ADD Patient Info</h1>
        <form action="insertpatient.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Full Name" required>
            <span class="error"><?php echo $errors['name'] ?? ''; ?></span><br><br>

            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <span class="error"><?php echo $errors['gender'] ?? ''; ?></span><br><br>

            <input type="number" name="age" placeholder="Age" required>
            <span class="error"><?php echo $errors['age'] ?? ''; ?></span><br><br>

            <input type="text" name="phone" placeholder="Phone Number" required>
            <span class="error"><?php echo $errors['phone'] ?? ''; ?></span><br><br>

            <input type="email" name="email" placeholder="Email" required>
            <span class="error"><?php echo $errors['email'] ?? ''; ?></span><br><br>

            <input type="password" name="password" placeholder="Password" required>
            <span class="error"><?php echo $errors['password'] ?? ''; ?></span><br><br>

            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <span class="error"><?php echo $errors['confirm_password'] ?? ''; ?></span><br><br>

            <input type="text" name="address" placeholder="Address" required>
            <span class="error"><?php echo $errors['address'] ?? ''; ?></span><br><br>

            <input type="text" name="diseases" placeholder="Known Diseases (Optional)">
            <span class="error"><?php echo $errors['diseases'] ?? ''; ?></span><br><br>

            <label for="doctor">Choose a Doctor:</label>
            <select id="doctor" name="doctor_id" placeholder="Choose a Doctor Now: (Optional)">
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname, $port);
                $result = $conn->query("SELECT id_d, d_name, specialization FROM doctor");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id_d']}'>{$row['d_name']} - {$row['specialization']}</option>";
                }
                $conn->close();
                ?>
            </select>
            <span class="error"><?php echo $errors['doctor_id'] ?? ''; ?></span><br><br>

            <label for="appointDate">Appointment Date :</label>
            <input type="date" name="appointDate" id="appointDate" placeholder="Appointment Date Now: (Optional)">

            <input type="file" name="profile_picture" style="color:white;" required>
            <input type="submit" value="Upload Image" style="color:black;" name="submit"><br>
            <span class="error"><?php echo $errors['profile_picture'] ?? ''; ?></span><br>

            <button type="submit">ADD New Patient</button>
        </form>
    </div>
</body>
</html>

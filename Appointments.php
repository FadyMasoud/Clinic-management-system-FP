<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctorhome.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

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

$sql = "SELECT * FROM patient WHERE P_doctor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .table-container {
            margin-top: 20px;
        }
        .profile-picture {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        @media (max-width: 767px) {
            .table-container {
                margin-top: 10px;
            }}
    </style>
</head>
<body>
    <div class="container table-container">
        <h2 class="text-center">Patient Appointments</h2>
        <?php if (count($patients) > 0): ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Profile Picture</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td class="text-center"><img src="<?php echo $patient['P_profile_picture']; ?>" alt="Profile Picture" class="profile-picture"></td>
                            <td><?php echo $patient['P_name']; ?></td>
                            <td><?php echo $patient['P_Appointment_Date']; ?></td>
            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No patients found.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

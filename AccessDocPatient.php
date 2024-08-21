<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctorhome.php");
    exit();
}

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

$patient = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_name'])) {
    $patient_name = $_POST['search_name'];
    $sql = "SELECT * FROM patient WHERE P_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $patient_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script> -->
    <style>
        body {
            background-image:url('images/Screenshot (584).png');
            background-size:cover;
            background-repeat: no-repeat;
            background-attachment: fixed;

        }
        .profile-card {
            background-color: #fff;
            max-width: 600px;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-picture {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .profile-info {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-light">Search for a Patient</h2>
        <form method="post" class="form-inline justify-content-center mb-5">
            <div class="form-group mx-sm-3 mb-2">
                <label for="search_name" class="sr-only">Patient name</label>
                <input type="text" class="form-control" id="search_name" name="search_name" placeholder="Enter Patient Name" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Search</button>
        </form>

        <?php if ($patient): ?>
        <div class="profile-card" >
            <div id="printArea">
            <div class="text-center">
                <img src="<?php echo $patient['P_profile_picture']; ?>" alt="Profile Picture" class="profile-picture">
            </div>
            <div class="profile-info" >

                <h2><?php echo $patient['P_name']; ?></h2>
                <p>Email: <?php echo $patient['P_email']; ?></p>
                <p>Gender: <?php echo $patient['P_gender']; ?></p>
                <p>Age: <?php echo $patient['P_age']; ?></p>
                <p>Phone: <?php echo $patient['P_phone']; ?></p>
                <p>Address: <?php echo $patient['P_address']; ?></p>
                <p>Diseases: <?php echo $patient['P_diseases']; ?></p>
                </div>
            </div>
                <button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
                <button class="btn btn-secondary " onclick="printDiv('printArea')">Print</button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editForm" method="post" action="Accessupdatedelet.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture URL</label>
                            <input type="text" class="form-control" id="profile_picture" name="profile_picture" value="<?php echo $patient['P_profile_picture']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $patient['P_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $patient['P_email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $patient['P_gender']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" id="age" name="age" value="<?php echo $patient['P_age']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $patient['P_phone']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $patient['P_address']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="diseases">Diseases</label>
                            <input type="text" class="form-control" id="diseases" name="diseases" value="<?php echo $patient['P_diseases']; ?>" required>
                        </div>
                        <input type="hidden" name="patient_id" value="<?php echo $patient['P_id']; ?>">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="action" value="update" class="btn btn-primary">Save changes</button>
                        <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>


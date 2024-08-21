<?php
session_start();

if (!isset($_SESSION['patient_login_id'])) {
    header("Location: patientlogin.php");
    exit();
}

$profileInfo = $_SESSION['patient_login_id'] ;
$profilePicturePath = $_SESSION['patient_login_profile_pic'];
$name = $_SESSION['patient_login_name'];
$email = $_SESSION['patient_login_email'] ;
$gender = $_SESSION['patient_login_gender'] ;
$age = $_SESSION['patient_login_age'] ;
$phone = $_SESSION['patient_login_phone'];
$address = $_SESSION['patient_login_address'] ;
$diseases = $_SESSION['patient_login_diseases'];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.1);
            min-height: 100vh;
            margin: 0;
            background-image:url(images/pro_doc.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
        .profile-card {
            margin-top: 50px;
            max-width: 90%;
            width: 100%;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        .profile-picture {
            border-radius: 50%;
            max-width: 300px;
            width: 100%;
            height: auto;
            object-fit: cover;
            margin-right: 20px;
            margin-bottom: 20px;
        }
        .profile-info {
            flex-grow: 1; 
            text-align: left;
            margin-top: 0;
        }
        #p1 {
            font-size: 20px;
        }
        button {
            padding: 10px 30px;
            font-size: 18px;
            transition: 1s ease;
        }
        @media screen and (max-width: 600px) {
            .profile-card {
                flex-direction: column;
                align-items: center;
            }
            .profile-picture {
                max-width: 100%;
                margin-right: 0;
                margin-bottom: 10px;
            }
            .profile-info {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <img src="<?php echo $profilePicturePath; ?>" alt="Profile Picture" class="profile-picture">
        <div class="profile-info">
            <h2><?php echo $name; ?></h2>
            <p id="p1">Age :  <?php echo $age; ?> years</p>
            <p>Gender:  <?php echo $gender; ?></p>
            <p>Phone number:  <?php echo $phone; ?></p>
            <p>E-mail :  <?php echo $email; ?></p>
            <p>Address :  <?php echo $address; ?></p>
            <p>Diseases :  <?php echo $diseases; ?></p>

            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editForm" method="post" action="updatePatProfile.php" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture URL</label>
                            <input type="text" class="form-control" id="profile_picture" name="profile_picture" value="<?php echo $profilePicturePath; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $gender; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" id="age" name="age" value="<?php echo $age; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="diseases">Diseases</label>
                            <input type="text" class="form-control" id="diseases" name="diseases" value="<?php echo $diseases; ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button><br>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>


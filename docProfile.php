<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}
// if (!isset($_SESSION['doc_id'])) {
//     header("Location: doctorSignUp.php");
//     exit();
// }

// function getPreviousPath() {
//     if (!isset($_SERVER['HTTP_REFERER'])) {
//         return null; // Return null if there is no referrer
//     }

//     $previousUrl = $_SERVER['HTTP_REFERER'];

//     // Parse the URL to get the path
//     $parsedUrl = parse_url($previousUrl, PHP_URL_PATH);

//     return $parsedUrl;
// }

// // Usage example
// $previousPath = getPreviousPath();

// if ($previousPath == 'doctorlogin.php') {

    $profile_picture_path =  $_SESSION['profile_pic'];
    $name_of_doctor=$_SESSION['doctor_name'];
    $mail_of_doctor=$_SESSION['doctor_email'];
    $special_of_doctor=$_SESSION['doctor_specilalize'];
    $certification =$_SESSION['doctor_certify'];

// } else {
//     $profile_picture_path =  $_SESSION['doc_picture'];
//     $name_of_doctor=$_SESSION['doc_name'];
//     $mail_of_doctor=$_SESSION['doc_email'];
//     $special_of_doctor=$_SESSION['doc_specilalize'];
//     $certification =$_SESSION['doc_certify'];
// }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <!-- <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
 
    <style>
        body {
            /* display: flex;
            justify-content: center;
            align-items: center; */
            background-color: rgba(0, 0, 0, 0.9);
            min-height: 100vh;
            background-image:url(images/stethoscope-840125_1280.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0;
        }
        .navbar {
            background-color: #0080de;
            color: white;
        }
        .navbar .logo img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            
        }
        .navbar-nav .marg {
            color: white;
            font-size:20px;
            cursor: pointer;
            transition: 1s ease;
            margin-right:70px;
        }
        .navbar-nav .nav-link:hover {
            text-decoration: underline;
            
        }
        .nav-item form {
            border-radius: 5px; 
            background-color: white;
            font-size:20px;
            color:white;
            text-align: center;
            align-items:center;
            transition: 1s ease;
        }
        .nav-item form:hover {
            scale:0.9;
            color:white;
            text-decoration:underline;
        }
        .nav-item form input[type="submit"] {
            border: none;
            /* color: blue; */
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            width: 150px;
        }
        .nav-item form input[type="submit"]:hover {
            text-decoration: underline;
            color:#FF0000;
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
        /* button {
            padding: 10px 30px;
            font-size: 18px;
            transition: 1s ease;
        } */
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
        .navbar-toggler-icon{
            color:white;
            
        }
        .navbar-toggler{
            color:white;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" >
        <div class="container-fluid">
            <a class="navbar-brand logo" href="docProfile.php">
                <?php if ($profile_picture_path): ?>
                    <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture">
                <?php endif; ?>
                <span style="color: white;font-size:20px;">MyProfile</span>
            </a>
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item marg" >
                        <a class="nav-link"  href="doctorhome.php" style="color: white;">Home</a>
                    </li>
                    <li class="nav-item marg" >
                        <a class="nav-link"  href="Appointments.php" style="color: white;">Appointments</a>
                    </li>
                    <li class="nav-item marg" >
                        <a class="nav-link" href="#" style="color: white;" onclick="showpatients()">Patients</a>
                    </li>
                    <li class="nav-item">
                        <form action="home.php" method="post">
                            <input type="submit" value="Log Out" class="nav-link btn btn-link" >
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="profile-card">
        
        <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture" class="profile-picture">
        <div class="profile-info">
            <h2 style="font-size: 30px;">Dr. <?php echo $name_of_doctor; ?></h2>
            <p id="p1">Certificate : <?php echo $certification; ?></p>
            <p style="font-size: 20px;">Specialization : <?php echo $special_of_doctor; ?></p>
            <p style="font-size: 20px;">E-mail : <?php echo $mail_of_doctor; ?></p>
            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" style="font-size: 20px;">Edit</button>
        </div>
    </div>
</body>
</html>


    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editForm" method="post" action="updateDocPro.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="d_name">Name</label>
                            <input type="text" class="form-control" id="d_name" name="d_name" value="<?php echo $name_of_doctor; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo $special_of_doctor; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="d_certificate">Certificate</label>
                            <input type="text" class="form-control" id="d_certificate" name="d_certificate" value="<?php echo $certification; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="d_email">Email</label>
                            <input type="email" class="form-control" id="d_email" name="d_email" value="<?php echo $mail_of_doctor; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture URL</label>
                            <input type="text" class="form-control" id="profile_picture" name="profile_picture" value="<?php echo $profile_picture_path; ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
   function showpatients(){
            window.location.href = 'DisplayEachPatientforeachdoc.php';
        }
        
        </script>
</body>
</html>

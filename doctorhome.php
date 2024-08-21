<?php
// session_id("zzzzzhzzzzz");
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctorlogin.php");
    exit();
}

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


    $profile_picture_path =  $_SESSION['profile_pic'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
   
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            background-image:url(images/pro_doc.jpg);
            background-color:rgba(0,0,0,0.1);
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-attachment: fixed;
            background-size: cover;
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
            color: blue;
            text-align: center;
            align-items:center;
            transition: 1s ease;
        }
        .nav-item form:hover {
            scale:0.9;
            color:#FF0000;
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
        .container {
           margin-top:150px;
            padding: 20px;
        }
        .container .box {
            max-width: 400px;
            height: 200px;
            cursor:pointer;
           color: white;
            margin: 10px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition:1s ease;
        }
        .container .box:hover {
            box-shadow: 0 0 20px 20px rgba(0, 0, 0, 0.5);
            scale:0.9;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #0080de;">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="docProfile.php">
                <?php if ($profile_picture_path): ?>
                    <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture">
                <?php endif; ?>
                <span style="color: white;font-size:20px;">MyProfile</span>
            </a>
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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



    <div class="container">
        <div class="row">
        <div class="col-md-4 box" onclick="insertpatients()" style=" background-image:url(images/news-7246477_1280.jpg);
            background-color:rgba(0,0,0,0.1);
            background-repeat: no-repeat;
            background-size: 100% 100%;
           
            background-size: cover;">
            <h2>New Patient</h2>
            <p>Insert new patients Here.</p>
        </div>
        <div class="col-md-4 box" onclick="redirectToPage()"style=" background-image:url(images/businessman-3492383_1280.jpg);
            background-color:rgba(0,0,0,0.1);
            background-repeat: no-repeat;
            background-size: 100% 100%;
            
            background-size: cover;">
            <a href=""></a>
            <h2>Update & Delete</h2>
            <p>Patients Here.</p>
        </div>
        <div class="col-md-4 box" onclick="showpatients()"style=" background-image:url(images/people-4050698_1280.jpg);
            background-color:rgba(0,0,0,0.1);
            background-repeat: no-repeat;
            background-size: 100% 100%;
         
            background-size: cover;">
            <a href=""></a>
            <h2>Patients</h2>
            <p>All patients Here.</p>
        </div>
        <div class="col-md-4 box" onclick="GoToMsg()"style=" background-image:url(images/msg.jpg);
            background-color:rgba(0,0,0,0.1);
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-size: cover;color:black;">
            <a href=""></a>
            <h2>Messages</h2>
            <p>All msgs patients Here.</p>
        </div>

    </div>
    </div>

    <script>
        function redirectToPage() {
            window.location.href = 'AccessDocPatient.php'; // Replace with your target URL
        }
        function showpatients(){
            window.location.href = 'DisplayEachPatientforeachdoc.php';
        }
        function insertpatients(){
            window.location.href = 'insertpatient.php';
        }
        function GoToMsg(){
            window.location.href = 'doctorMessages.php';
        }
    </script>
</body>
</html>





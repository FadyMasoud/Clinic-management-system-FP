<?php
// session_id("zzzzzhzzzzz");
// echo session_id("signpatient12345");
session_start();

if (!isset($_SESSION['patient_login_id'])) {
    header("Location: patientlogin.php");
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



 $profile_picture_path = $_SESSION['patient_login_profile_pic'];
   

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url(images/people-4050698_1280.jpg);
            /* background-color:rgba(0,0,0,0.1); */
            background-repeat: no-repeat;
            background-size: 100% 100%;
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
            box-shadow: 0 0 20px 20px rgba(255, 255, 255, 0.2);
            text-align: center;
            transition:1s ease;
        }
        .container .box:hover {
            box-shadow: 0 0 20px 20px rgba(255, 255, 255, 0.5);
            scale:0.9;
        }
        .message-box {
            display: none;
            margin-top: 20px;
        }
        .message-box textarea {
            width: 100%;
            height: 100px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #0080de;">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="patientProfile.php">
                <?php if ($profile_picture_path): ?>
                    <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture">
                <?php endif; ?>
                <span style="color: white;font-size:20px;">Profile</span>
            </a>
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item marg" >
                        <a class="nav-link"  href="patienthome.php" style="color: white;">Home</a>
                    </li>
                    <li class="nav-item marg" >
                        <a class="nav-link"  href="#" style="color: white;">Appointments</a>
                    </li>
                    <li class="nav-item marg" >
                        <a class="nav-link" href="#" style="color: white;">Doctor</a>
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
        <div class="col-md-12 box">
        <div class="text-center">
            <div id="send-message" class="btn btn-primary mt-5">Send Messages</div>
            <div class="message-box mt-3">
                <form id="messageForm" action="sendMessage.php" method="post">
                    <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                    <textarea name="message" placeholder="Write your message here..." required></textarea>
                    <button type="submit" class="btn btn-success mt-2">Send</button>
                </form>
            </div>
        </div>
        </div>
       
    </div>
    </div>
    <script>
          document.getElementById('send-message').addEventListener('click', function() {
            document.querySelector('.message-box').style.display = 'block';
        });
    </script>
</body>
</html>






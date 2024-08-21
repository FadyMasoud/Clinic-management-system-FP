<?php
session_id("zzzzzhzzzzz");
session_start();

$servername = "localhost";
$username = "root";
$password = "77220011fady";
$dbname = "clinic";
$port=3306;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname,$port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    $sql = "SELECT * FROM doctor WHERE d_email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['d_pass'])) {
                $_SESSION['doctor_id'] = $row['id_d'];
                $_SESSION['doctor_name'] = $row['d_name'];
                $_SESSION['doctor_email'] = $row['d_email'];
                $_SESSION['profile_pic'] = $row['profile_picture'];
                $_SESSION['doctor_specilalize'] = $row['specialization'];
                $_SESSION['doctor_certify']=$row['d_certificate'];

                header("Location: doctorhome.php");
                // exit();
            } else {
                $login_error = "Incorrect password.";
            }
        } else {
            $login_error = "No account found with that email.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $login_error = "Database query failed: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('images/Screenshot (584).png'); /* Set your background image here */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
        }
        .login-container {
            margin-top:50px;
            background-color: rgba(255,255,255,0.8);
            width: 600px;
            height:620px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0px 20px 20px 0px rgba(0,0,0,0.1);
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 20px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 80%;
            padding: 20px;
            margin: 20px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .login-container #log {
            width: 80%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition:1s ease;
        }
        #log:hover {
            background-color: white;
            color: #007BFF;
            scale:1.1;
            
        }
        .login-container .error {
            color: red;
            font-size: 12px;
            margin-top: 10px;
            margin-bottom:10px;
        }
        .login-container  a {
            color: #007BFF;
            margin-top: 10px;
            margin-bottom:30px;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        #sign{
            width: 100%;
            color: white;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            background-color:#007BFF;
            padding: 10px;
            border: none;
            border-radius: 3px;
            transition:1s ease;
        }
        .butt{
            width: 50%;
            color: white;
            text-decoration: none;
            font-size: 20px;
            cursor: pointer;
            padding:10px;
            margin:5px 10px;
            border: none;
            border-radius:50px;
            transition:1s ease;
        }
        .butt:hover{
            background-color: white;
            scale:0.9;
        }
        #sign:hover{
            background-color: white;
            color: #007BFF;
            scale:0.9;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h1>Doctor Login</h1>
        <form action="doctorlogin.php" method="POST">
            <input type="text" name="email" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <?php if (!empty($login_error)): ?><div class="error"><?php echo $login_error; ?></div><?php endif; ?>
            <button type="submit" id="log">Login</button><br><br>
            <button type="button" class="butt" style="background-color: #ff0000;"><i class="fab fa-google"></i> Continue with Google</button>
            <button type="button" class="butt" style="background-color: #3b5998;"><i class="fab fa-facebook-square"></i> Continue with Facebook</button>
            <button type="button" class="butt" style="background-color: #000000;"><i class="fab fa-apple"></i> Continue with Apple</button><br><br>
            
                <div>
                    <a href="#">Forgot your password?</a>
                </div>
                <div style="margin-top:30px;">
                    <a href="docFormSignhtml.php" id="sign">Sign up now</a>
                </div>
            

        </form>
    </div>
</body>
</html>


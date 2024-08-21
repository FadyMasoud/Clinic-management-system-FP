<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            height: 100vh;
        }
        .signup-form {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.6);
            width: 600px;
            box-shadow: 0px 20px 20px 0px rgba(0,0,0,0.1);
        }
        .signup-form h1 {
            text-align: center;
            color: white;
        }
        .signup-form .name-container {
            display: flex;
            gap:15px;
        }
        .signup-form .name-container input {
            flex: 1;
            font-size:15px;
            border-radius:5px ;
            border:0px solid gray;
            color:black;
            text-align:center;
        }
        .signup-form input[type="email"],
        .signup-form input[type="password"],
        .signup-form input[type="file"],
        .signup-form input[type="submit"],
        .signup-form select,
        .signup-form button {
            width: 95%;
            padding: 10px;
            font-size:15px;
            margin: 5px 0;
            border-radius:5px ;
            border:0px solid gray;
            color:black;
        }
        .signup-form button {
            background-color: #4CAF50;
            padding: 15px;
            font-size: 20px;
            color: white;
            border: none;
            cursor: pointer;
            transition:1s ease;
        }
        .signup-form button:hover {
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
    <div class="signup-form">
        <h1>Sign Up</h1>
        <form action="doctorSignUp.php" method="POST" enctype="multipart/form-data">
            <div class="name-container">
                <input style="height:40px;" type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <span class="error"><?php echo $errors['first_name'] ?? ''; ?></span>
            <span class="error"><?php echo $errors['last_name'] ?? ''; ?></span><br><br>

            <input type="email" name="email" placeholder="Email" required>
            <span class="error"><?php echo $errors['email'] ?? ''; ?></span><br><br>

            <input type="password" name="password" placeholder="Password" required>
            <span class="error"><?php echo $errors['password'] ?? ''; ?></span><br><br>

            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <span class="error"><?php echo $errors['confirm_password'] ?? ''; ?></span><br><br>

            <label for="specialization">Choose a specialization:</label>
            <select id="specialization" name="specialization" required>
                <option value="Cardiology">Cardiology</option>
                <option value="Neurology">Neurology</option>
                <option value="Oncology">Oncology</option>
                <option value="Pediatrics">Pediatrics</option>
            

                <!-- Add more options as needed -->
            </select><br>
            <span class="error"><?php echo $errors['specialization'] ?? ''; ?></span><br>

            <input type="file" name="profile_picture" style="color:white;" required>
            <input type="submit" value="Upload Image"  style="color:black;" name="submit"><br>
            <span class="error"><?php echo $errors['profile_picture'] ?? ''; ?></span><br>
            
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
</html>


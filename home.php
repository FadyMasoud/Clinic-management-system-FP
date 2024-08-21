<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Clinic Home Page</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url(images/young-handsome-physician-medical-robe-with-stethoscope.jpg); 
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
        .container {
            text-align: center;
            padding: 50px;
            max-width: 90%;
            width: 500px;
            height: auto;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 20px 20px rgba(0, 0, 0, 0.3);
        }
        .container h1 {
            margin-bottom: 10px;
            font-size: 40px;
        }
        .container p {
            margin-bottom: 20px;
            color: #777;
        }
        .container .buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 40px;
        }
        .container button {
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 20px;
        }
        .btn-doctor {
            background-color: #4CAF50;
            width: 160px;
            height:90px;
            font-size:30px;
            color: white;
            transition: 1s ease;
        }
        .btn-patient {
            background-color: #2196F3;
            width: 160px;
            height:90px;
            font-size:30px;
            color: white;
            transition: 1s ease;
        }
        .btn-doctor:hover {
            background-color: #3e8e41;
            transform: scale(1.1);
        }
        .btn-patient:hover {
            background-color: #0b7dda;
            transform: scale(1.1);
        }
        @media (max-width: 768px) {
            .container h1 {
                font-size: 30px;
            }
            .container button {
                padding: 10px 20px;
                font-size: 16px;
            }
        }
        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
            .container h1 {
                font-size: 24px;
            }
            .container button {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Better <i class="fas fa-heartbeat"></i> Health</h1>
        <p>Dr. Mark Hoffman's clinic welcomes you!</p>
        <div class="buttons">
            <button class="btn-doctor" id="doctor-login">Doctor</button>
            <button class="btn-patient" id="patient-login">Patient</button>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#doctor-login').click(function() {
                window.location.href = 'doctorlogin.php';
            });
            $('#patient-login').click(function() {
                window.location.href = 'patientlogin.php';
            });
        });
    </script>
</body>
</html>

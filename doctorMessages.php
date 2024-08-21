<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctorlogin.php");
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

$sql = "SELECT m.id, p.P_name AS patient_name, m.send_msg, m.reply_msg
        FROM messages m
        JOIN patient p ON m.patient_id = p.P_id
        WHERE m.doctor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Messages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Patient Messages</h2>
        <?php if (count($messages) > 0): ?>
            <table class="table table-bordered mt-3">
                <thead class="thead-dark">
                    <tr>
                        
                        <th scope="col">Patient Name</th>
                        <th scope="col">Message</th>
                        <th scope="col">Reply</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                          
                            <td><?php echo $message['patient_name']; ?></td>
                            <td><?php echo $message['send_msg']; ?></td>
                            <td><?php echo $message['reply_msg']; ?></td>
                            <td>
                                <form action="replaymsg.php" method="post">
                                    <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                    <textarea name="reply_msg" required><?php echo $message['reply_msg']; ?></textarea>
                                    <button type="submit" class="btn btn-primary mt-2">Reply</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No messages found.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

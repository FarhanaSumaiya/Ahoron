<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['S_ID'])) {
    header("Location: S_login.php");
    exit();
}

$S_ID = $_SESSION['S_ID'];

// Fetching user details from the database
$sql = "SELECT * FROM Student WHERE S_ID = '$S_ID'";
$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['First_name'];
    $lastName = $row['Last_name'];
    $username = $row['username'];
    $gender = $row['Gender'];
    $instituteType = $row['Institute_type'];
    $instituteName = $row['Institute_name'];
    $class = $row['Class'];
    $phoneNumber = $row['Phone_number'];
    $registrationDate = $row['Registration_date'];
} else {
    $firstName = "Student";
}

// Check if 'page' is set to 'profile' in the URL
$showProfile = isset($_GET['page']) && $_GET['page'] == 'profile';

$paymentSql = "SELECT * FROM Payment WHERE ID = '$S_ID'";
$paymentResult = mysqli_query($con, $paymentSql);
$paymentDone = ($paymentResult && mysqli_num_rows($paymentResult) > 0);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_check'])) {
    if ($paymentDone) {
        header("Location: S_I_message.php");
    } else {
        header("Location: payment.php");
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['talk_instructor'])) {
    header("Location: S_I_message.php");
    exit();
}

// Handle sending message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_message'])) {
    $message = $_POST['message'];

    $sql = "INSERT INTO S_message (ID, Message) VALUES ('$S_ID', '$message')";
    $result = mysqli_query($con, $sql);
    
    if (!$result) {
        $message_error = "Error occurred: " . mysqli_error($con);
    } else {
        $message_success = "Message sent successfully!";
    }
}

// Fetch messages if 'view all Messages' is clicked
$messages = [];
if (isset($_GET['page']) && $_GET['page'] == 'view_messages') {
    $sql = "SELECT * FROM S_message WHERE ID = '$S_ID'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
    } else {
        $error_message = "Error fetching messages: " . mysqli_error($con);
    }
}

// Fetch messages if 'read Messages' is clicked
if (isset($_GET['page']) && $_GET['page'] == 'read_messages') {
    $sql = "SELECT * FROM AS_message WHERE ID = '$S_ID'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
    } else {
        $error_message = "Error fetching messages: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            width: 100%;
            padding: 20px;
            background-color: #4A90E2;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        header a:hover {
            color: #FFD700;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 40px;
        }

        .options {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 40px;
        }

        .option {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 250px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .option:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .option a, .option button {
            display: block;
            margin: 20px 0;
            text-decoration: none;
            color: #333;
            font-size: 18px;
            background: none;
            border: none;
            cursor: pointer;
        }

        .option a:hover, .option button:hover {
            color: #4A90E2;
        }

        .profile {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .profile h2 {
            margin-top: 0;
        }

        <?php if ($showProfile): ?>
        .profile {
            display: block;
        }
        <?php endif; ?>

        .message {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
        }

        .message a {
            color: #4A90E2;
            text-decoration: none;
            font-weight: bold;
        }

        .message a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .option form {
            display: inline;
        }

        .option input[type="submit"] {
            background: none;
            border: none;
            color: #4A90E2;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <a href="Student.php">Home</a>
        <div class="welcome">
            <a href="Student.php?page=profile"><?php echo "Welcome " . htmlspecialchars($firstName); echo " !"; ?></a>
        </div>
        <a href="index.php">Logout</a>
    </header>

    <div class="container">
        <h1>Welcome to the Dashboard</h1>

        <div class="options">
            <div class="option">
                <form method="post">
                    <input type="hidden" name="payment_check" value="1">
                    <button type="submit">Payments</button>
                </form>
            </div>
            <div class="option">
                <a href="Student.php?page=message_options">Messages</a>
            </div>
            <div class="option">
                <a href="clubs.php">Clubs</a>
            </div>
            <div class="option">
                <a href="Student.php?page=check_payment">Chat with Instructor</a>
            </div>
        </div>

        <?php if ($paymentDone && isset($_GET['page']) && $_GET['page'] == 'check_payment'): ?>
        <div class="message">
            <p>You have already made your payment! Want to talk with your instructor?</p>
            <form method="post">
                <button type="submit" name="talk_instructor">Yes</button>
            </form>
        </div>
        <?php endif; ?>

        <div id="profile" class="profile">
            <h2>Profile Details</h2>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($firstName); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($lastName); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
            <p><strong>Institute Type:</strong> <?php echo htmlspecialchars($instituteType); ?></p>
            <p><strong>Institute Name:</strong> <?php echo htmlspecialchars($instituteName); ?></p>
            <p><strong>Class:</strong> <?php echo htmlspecialchars($class); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phoneNumber); ?></p>
            <p><strong>Registration Date:</strong> <?php echo htmlspecialchars($registrationDate); ?></p>
            <p><a href="S_Forgetpass.php">Change Password</a></p>
        </div>

        <?php if (isset($_GET['page']) && $_GET['page'] == 'message_options'): ?>
        <div class="option">
            <h2>Messages</h2>
            <a href="?page=send_message">Send Message</a>
            <a href="?page=view_messages">View Sent Messages</a>
            <a href="?page=read_messages">Read Messages</a>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['page']) && $_GET['page'] == 'send_message'): ?>
        <div class="option">
            <h2>Send Message</h2>
            <?php if (isset($message_error)): ?>
                <p style="color: red;"><?php echo $message_error; ?></p>
            <?php elseif (isset($message_success)): ?>
                <p style="color: green;"><?php echo $message_success; ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <input type="hidden" name="submit_message" value="1">
                <input type="text" name="message" placeholder="Write Message" required>
                <input type="submit" value="Submit">
            </form>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['page']) && $_GET['page'] == 'view_messages'): ?>
        <div class="option">
            <h2>View Sent Messages</h2>
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Sent to Admin</th>
                        <th>Message</th>
                        <th>Send Time</th>
                    </tr>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($message['ID']); ?></td>
                            <td><?php echo htmlspecialchars($message['Message']); ?></td>
                            <td><?php echo htmlspecialchars($message['Send_time']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['page']) && $_GET['page'] == 'read_messages'): ?>
        <div class="option">
            <h2>Read Messages</h2>
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Send By Admin</th>
                        <th>Message</th>
                        <th>Receive Time</th>
                    </tr>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($message['ID']); ?></td>
                            <td><?php echo htmlspecialchars($message['Message']); ?></td>
                            <td><?php echo htmlspecialchars($message['Send_time']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

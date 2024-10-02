<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_user'])) {
    $student_id = $_POST['student_id'];
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];

    // Verify the user details
    $sql = "SELECT * FROM Student WHERE S_ID='$student_id' AND username='$username' AND Phone_number='$phone_number'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $verified = true;
    } else {
        $error_message = "Invalid ID, username, or phone number.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $student_id = $_POST['student_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Update the user's password
        $update_sql = "UPDATE Student SET Password='$password' WHERE S_ID='$student_id' AND username='$username'";
        $update_result = mysqli_query($con, $update_sql);

        if ($update_result) {
            $reset_message = "Password has been reset successfully!";
        } else {
            $error_message = "Error updating password: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial;
            background-color: #ABFCC1 ;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .reset-password-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .reset-password-container h2 {
            margin-top: 0;
        }
        .reset-password-form {
            display: flex;
            flex-direction: column;
        }
        .reset-password-form input {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .reset-password-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .reset-password-form input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
        .reset-message {
            color: green;
            margin-bottom: 10px;
        }
        .back-to-login {
            margin-top: 10px;
        }
        .back-to-login a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
        .back-to-login a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="reset-password-container">
        <h2>Reset Password</h2>
        <?php if (isset($error_message)) { echo '<p class="error-message">' . $error_message . '</p>'; } ?>
        <?php if (isset($reset_message)) { echo '<p class="reset-message">' . $reset_message . '</p>'; } ?>

        <?php if (!isset($verified)) { ?>
        <form action="" method="post" class="reset-password-form">
            <input type="text" name="student_id" placeholder="Student ID" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <input type="submit" name="verify_user" value="Verify">
        </form>
        <?php } else { ?>
        <form action="" method="post" class="reset-password-form">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" name="reset_password" value="Reset Password">
        </form>
        <?php } ?>
        <div class="back-to-login">
            <a href="S_login.php">Back to Login</a>
        </div>
    </div>
</body>
</html>

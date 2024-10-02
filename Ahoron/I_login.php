<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['un'];
    $password = $_POST['pw'];
    
    $sql = "SELECT * FROM Instructor WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION['I_ID'] = $row['I_ID'];
        header("Location: Instructor.php");
        exit();
    } else {
        $login_error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login_html</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            padding: 0;
            background-image: url('image/Instructor.png');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container h2 {
            margin-top: 0;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-form input {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: none;
        }

        .login-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .login-link {
            margin-top: 20px;
        }

        .login-link a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }

        .login-link a:hover {
            color: #2980b9;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .forgot-password-link {
            margin-top: 10px;
        }

        .forgot-password-link a {
            text-decoration: none;
            color: #3498db;
        }

        .forgot-password-link a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($login_error)) { echo '<p class="error-message">' . $login_error . '</p>'; } ?>
        <form action="" method="post" class="login-form">
            <input type="text" name="un" placeholder="User Name" required>
            <input type="password" name="pw" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
		 <div class="forgot-password-link"><a href="I_ForgetPass.php">Forgot Password?</a></div>
        <div class="login-link">Don't have an account? <a href="signup1.php">Sign up!</a>.</div>
       
    </div>

</body>
</html>

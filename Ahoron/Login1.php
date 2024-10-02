<!DOCTYPE html>
<html>
<head>
    <title>Login_html</title>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #9fc5e8;
        }

        header {
            background-color: #3498db;
            color: #fff;
            padding: 10px 0;
            text-align: left;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        header a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column; /* Added */
        }

        .options {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .option {
            width: 300px;
            background-color: #3498db;
            border-radius: 5px;
            margin: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .option:hover {
            transform: translateY(-5px);
        }

        .option a {
            display: block;
            padding: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }

        .option img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .login-link {
            font-size: 16px;
            color: #666;
            margin-top: 20px;
        }

        .login-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php">Home</a>
    </header>
    <div class="container">
        <div class="options">
            <div class="option">
                <img src="image/student.jpg" alt="Students">
                <a href="S_Login.php">log in as Student</a>
            </div>
            <div class="option">
                <img src="image/Instructor.png" alt="Instructor">
                <a href="I_login.php">log in as Instructor</a>
            </div>
        </div>
        <div class="login-link">Don't have an account? <a href="signup1.php">Sign up!</a>.</div>
    </div>
</body>
</html>

  
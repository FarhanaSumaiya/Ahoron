<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #9fc5e8;
            background-image: url('image/index.png');
            background-size: cover;
            background-position: center;
        }
        header {
            background-color: #3498db;
            padding: 20px;
            text-align: center;
        }
        header a {
            color: #fff;
            font-size: 20px;
            text-decoration: none;
            padding: 10px;
            margin: 0 5px;
            transition: background-color 0.3s;
        }
        header a:hover {
            background-color: #2980b9;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .welcome-content {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .welcome-text {
            flex: 1;
            padding: 20px;
            text-align: center;
        }
        .welcome-text h1 {
            font-size: 36px;
            color: #3498db;
            margin-bottom: 20px;
        }
        .welcome-text p {
            font-size: 18px;
            color: #fff;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .welcome-image {
            flex: 1;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        .setting-option {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
        .setting-option a {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .setting-option a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="Contact.php">Contact</a>
        <a href="Login1.php">Login</a>
        <a href="Signup1.php">Sign Up</a>
    </header>
    <div class="container">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1>Welcome to Ahoron!</h1>
                <p>Thank you for visiting our website! We're excited to have you here.</p>
                <p>Feel free to explore our content and let us know if you have any questions.</p>
                <p>Stay tuned for updates and new features!</p>
            </div>
            <img class="welcome-image" src="image/pic1.jpg" alt="Welcome Image">
        </div>
    </div>
    <div class="setting-option">
        <a href="A_login.php">Admin panel</a>
    </div>
</body>
</html>

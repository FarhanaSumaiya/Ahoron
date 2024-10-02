<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('image/Contact.png');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: white;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
        }

        h1 {
            margin-top: 40px;
            font-size: 36px;
            color: #3498db;
        }

        p {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        h2 {
            margin-top: 30px;
            font-size: 24px;
            color: #3498db;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
            margin-top: 20px;
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li::before {
            content: "\2022";
            color: #3498db;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
            margin-right: 5px;
        }

        .contact {
            margin-top: 30px;
        }

        .contact a {
            color: #3498db;
            text-decoration: none;
        }

        .top-nav {
            background-color: rgba(52, 152, 219, 0.7);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-nav .left-link {
            text-align: left;
        }

        .top-nav .right-links {
            text-align: right;
        }

        .top-nav a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }

        .social {
            margin-bottom: 10px;
        }

        .social span {
            display: block;
            margin-bottom: 10px;
        }

        .social a {
            color: #3498db;
            text-decoration: none;
            margin: 0 10px;
        }

        .admin {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .admin .profile {
            text-align: center;
            width: 30%;
        }

        .admin .profile img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }

        .admin .profile a {
            color: #3498db;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="top-nav">
        <div class="left-link">
            <a href="index.php">Home</a>
        </div>
        <div class="right-links">
            <a href="Login1.php">Login</a>
            <a href="Signup1.php">Sign Up</a>
        </div>
    </div>

    <div class="container">
        <h1>About Us</h1>
        <p>Welcome to Ahoron. We are dedicated to providing you with the best opportunities for career growth and club activities.</p>
        
        <h2>Contact Us</h2>
        <div class="contact">
            <ul>
                <li>Email: <a href="mailto:info@careersandclubs.com">info@careersandclubs.com</a></li>
                <li>Phone: 01312680390</li>
                <li>Address: BUP</li>
            </ul>
        </div>
        
        <h2>Our Team</h2>
        <div class="admin">
            <div class="profile">
                <img src="image/admin1.jpeg" alt="Admin 1">
                <a href="https://www.facebook.com/fabiha.tasnim.969">Fabiha Tasnim</a>
                <p>Fabiha Tasnim is passionate about community building and career development.</p>
            </div>
            <div class="profile">
                <img src="image/admin2.jpeg" alt="Admin 2">
                <a href="https://www.facebook.com/profile.php?id=61552573592203">Ishrat Jahan</a>
                <p>Ishrat Jahan is dedicated to creating engaging club activities and events.</p>
            </div>
            <div class="profile">
                <img src="image/admin3.jpeg" alt="Admin 3">
                <a href="https://www.facebook.com/farhana.sumaiya23">Farhana Sumaiya</a>
                <p>Farhana Sumaiya specializes in career counseling and professional growth.</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="social">
            <span>Follow Us:</span>
            <a href="https://www.facebook.com/fabiha.tasnim.969">Admin 1</a>
            <a href="https://www.facebook.com/profile.php?id=61552573592203">Admin 2</a>
            <a href="https://www.facebook.com/farhana.sumaiya23">Admin 3</a>
        </div>
        <a href="contact.php">Contact</a>
    </div>
</body>
</html>

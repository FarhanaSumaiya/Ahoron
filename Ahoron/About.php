<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('image/aesthetic4.png');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            margin-top: 0;
            font-size: 36px;
            color: #3498db;
            font-weight: bold;
        }

        p {
            line-height: 1.8;
            font-size: 18px;
            margin-bottom: 20px;
        }

        h2 {
            margin-top: 30px;
            font-size: 28px;
            color: #3498db;
            font-weight: bold;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
            margin-top: 20px;
            text-align: left;
        }

        ul li {
            margin-bottom: 10px;
            font-size: 18px;
        }

        ul li::before {
            content: "\2022";
            color: #3498db;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
            margin-right: 5px;
        }

        .top-nav {
            background-color: rgba(52, 152, 219, 0.8);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .top-nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .top-nav a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 50px;
            padding: 20px;
            background: rgba(52, 152, 219, 0.8);
            text-align: center;
            border-radius: 10px;
        }

        .footer a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            margin-left: 15px;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .social {
            margin-bottom: 10px;
        }

        .social span {
            display: block;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .social a {
            color: #3498db;
            text-decoration: none;
            font-size: 18px;
            margin: 0 10px;
        }

        .social a:hover {
            text-decoration: underline;
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
        <p>Embarking on a career and joining clubs are crucial aspects of personal and professional development. Our career is a significant part of our life, influencing not only our financial well-being but also our overall satisfaction and sense of purpose. Similarly, joining clubs or organizations can enhance our social life, provide networking opportunities, and allow us to pursue our hobbies or passions with like-minded individuals.</p>
        <p>This project aims to help individuals in suggesting a career based on their interests and also through counseling. Additionally, it provides information about various clubs across the country for career development and personal growth.</p>
        <h2>Our Mission</h2>
        <p>Our mission is to empower individuals in making informed decisions about their careers and personal development. We aim to provide valuable resources, guidance, and support to help individuals achieve their goals and lead fulfilling lives.</p>
        <a href="Contact.php"><h3>Contact Us</h3></a>
    </div>

    <div class="footer">
        <div class="social">
            <span>Follow Us:</span>
            <a href="https://www.facebook.com/fabiha.tasnim.969">Admin 1</a>
            <a href="https://www.facebook.com/profile.php?id=61552573592203">Admin 2</a>
            <a href="https://www.facebook.com/farhana.sumaiya23">Admin 3</a>
        </div>
    </div>
</body>
</html>

<?php
include('connection.php');

$sql = "SELECT DISTINCT university FROM club ORDER BY university ASC";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Universities</h2>";
    echo "<div class='clubs-container'>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='club'><a href='fetch_clubs.php?university=" . urlencode($row["university"]) . "'>" . htmlspecialchars($row["university"]) . "</a></div>";
    }
    echo "</div>";
} else {
    echo "No results found.";
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universities</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #009688;
        }

        header a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        header a:hover {
            color: #ffa500;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }

        .clubs-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .club {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .club:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .club a {
            text-decoration: none;
            color: #009688;
            font-size: 18px;
        }

        .club a:hover {
            color: #00796b;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background-color: #009688;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #00796b;
        }
    </style>
</head>
<body>
    <!-- <header>
        <a href="Admin.php">Home</a>
        <a href="A_login.php">Logout</a>
    </header> 

    <div class="container">
       
    </div>-->
</body>
</html>

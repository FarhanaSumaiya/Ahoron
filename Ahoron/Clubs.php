<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universities</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2; /* Light gray background */
            color: #333; /* Dark gray text color */
            margin: 0;
            padding: 0;
        }

        header {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #009688; /* Teal header background */
        }

        header a {
            text-decoration: none;
            color: #fff; /* White text color */
            font-weight: bold;
            transition: color 0.3s ease;
        }

        header a:hover {
            color: #ffa500; /* Orange color on hover */
        }

        h1 {
            margin-top: 50px;
            margin-bottom: 30px;
            font-size: 36px;
            text-align: center;
            color: #009688; /* Teal header text color */
        }

        .clubs-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }

        .club {
            width: 200px;
            height: 100px;
            background-color: #fff; /* White background */
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add shadow */
        }

        .club:hover {
            background-color: #e0e0e0; /* Light gray background on hover */
        }

        .club a {
            text-decoration: none;
            color: #009688; /* Teal text color */
            font-size: 18px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .club:hover a {
            color: #00796b; /* Darker teal text color on hover */
        }

        .footer {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            bottom: 0;
            left: 0;
            background-color: #009688; /* Teal footer background */
        }

        .social {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .social a {
            text-decoration: none;
            color: #fff; /* White text color */
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .social a:hover {
            color: #ffa500; /* Orange color on hover */
        }
    </style>
</head>
<body>
    <header>
        <a href="student.php">Home</a>
        <a href="index.php">Logged out</a>
    </header>

    <h1>Universities</h1> <!-- Header color already set -->
	<a href="S_search.php">Search Clubs</a>

    <div class="clubs-container">
        <?php
        // Connect to your MySQL database
        include('connection.php');

        // Fetch data from the universities table
        $sql = "SELECT DISTINCT university FROM club ORDER BY university ASC";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Print the university name with a link to fetch clubs
                echo "<div class='club'><a href='fetch_clubs.php?university=" . urlencode($row["university"]) . "'>" . $row["university"] . "</a></div>"; // Removed inline styles for club
            }
        } else {
            echo "0 results";
        }

        $con->close();
        ?>
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

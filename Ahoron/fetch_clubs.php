<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Clubs</title>
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff; /* Blue header text color */
        }

        .clubs-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .club {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .club a {
            text-decoration: none;
            color: #009688;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .club a:hover {
            color: #00796b; /* Darker teal */
        }

        .club:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <header>
        <a href="student.php">Home</a>
        <a href="index.php">Log out</a>
    </header>

    <div class="container">
        <?php
        include('connection.php');

        if (isset($_GET['university'])) {
            $university = $con->real_escape_string($_GET['university']);

            $sql = "SELECT club_name FROM club WHERE university = ? ORDER BY club_name ASC";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $university);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<h2>{$university} Clubs</h2>";
                echo "<div class='clubs-container'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='club'><a href='event.php?club_name=" . urlencode($row["club_name"]) . "'>" . htmlspecialchars($row["club_name"]) . "</a></div>";
                }
                echo "</div>";
            } else {
                echo "<p>No clubs found for {$university}.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>University parameter is missing.</p>";
        }

        $con->close();
        ?>
    </div>
</body>
</html>

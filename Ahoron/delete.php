<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Club</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Light gray background */
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
            background-color: #009688; /* Teal */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #00796b; /* Darker teal */
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Delete Club</h2>
        <?php
        include('connection.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $university = $_POST['university'];
            $club_name = $_POST['club_name'];

            // First, delete related events
            $sql_delete_events = "DELETE FROM event WHERE university=? AND club_name=?";
            $stmt_delete_events = $con->prepare($sql_delete_events);
            $stmt_delete_events->bind_param("ss", $university, $club_name);

            if ($stmt_delete_events->execute()) {
                // Now delete the club
                $sql_delete_club = "DELETE FROM club WHERE university=? AND club_name=?";
                $stmt_delete_club = $con->prepare($sql_delete_club);
                $stmt_delete_club->bind_param("ss", $university, $club_name);

                if ($stmt_delete_club->execute()) {
                    echo "<p>Club deleted successfully.</p>";
                } else {
                    echo "<p>Error: " . $stmt_delete_club->error . "</p>";
                }

                $stmt_delete_club->close();
            } else {
                echo "<p>Error: " . $stmt_delete_events->error . "</p>";
            }

            $stmt_delete_events->close();
            $con->close();
        }
        ?>

        <form method="POST">
            <label for="university">University:</label>
            <input type="text" id="university" name="university" required>
            <label for="club_name">Club Name:</label>
            <input type="text" id="club_name" name="club_name" required>
            <input type="submit" value="Delete Club">
        </form>
    </div>
</body>
</html>
